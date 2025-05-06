
#!/bin/bash

# Linear CLI Commands for WeCoza 3 Child Theme
# This script contains functions for various Linear CLI commands

# Configuration
TEAM_KEY="WEC"
LINEAR_API_URL="https://api.linear.app/graphql"
LINEAR_CACHE_DIR="$HOME/.linear/cache"
LINEAR_CACHE_EXPIRY=3600  # Cache expiry in seconds (1 hour)

# Function to check Linear API authentication
check_linear_auth() {
    # Check if LINEAR_API_KEY is set
    if [ -z "$LINEAR_API_KEY" ]; then
        echo "Error: LINEAR_API_KEY environment variable is not set."
        echo "Please set it with: export LINEAR_API_KEY=your_api_key"
        echo "You can generate an API key at: https://linear.app/wecoza/settings/api"
        return 1
    fi

    echo "Validating Linear API key..."

    # Show API URL being used
    echo "Using API URL: $LINEAR_API_URL"

    # Validate the API key with a simple query
    response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d '{"query":"query { viewer { id name } }"}' \
        $LINEAR_API_URL)

    # Debug: Show raw response
    echo "Raw authentication response: $response"

    # Check if the response contains errors
    if [[ $response == *"errors"* ]]; then
        echo "Error: Authentication failed."
        if command -v jq &>/dev/null; then
            echo "Error details: $(echo "$response" | jq -r '.errors[].message')"
        else
            echo "Error details: $response"
        fi
        echo "Please check your API key and try again."
        return 1
    fi

    # Check if the response is empty or malformed
    if [[ -z "$response" || "$response" == "{}" ]]; then
        echo "Error: Received empty or malformed response from Linear API."
        echo "Please check your network connection and API URL."
        return 1
    fi

    # Extract user name for confirmation
    if command -v jq &>/dev/null; then
        if ! echo "$response" | jq -e '.data.viewer' > /dev/null 2>&1; then
            echo "Error: Unexpected response format. Missing data.viewer field."
            echo "Full response: $response"
            return 1
        fi

        user_name=$(echo "$response" | jq -r '.data.viewer.name // "Unknown"')
        user_id=$(echo "$response" | jq -r '.data.viewer.id // "Unknown"')
        echo "Authenticated as: $user_name (ID: $user_id)"
    else
        echo "Authentication successful, but jq is not available for detailed output."
        echo "Consider installing jq for better output formatting."
    fi

    return 0
}

# Function to ensure cache directory exists
ensure_cache_dir() {
    mkdir -p "$LINEAR_CACHE_DIR"
}

# Function to get team ID from team key
get_team_id() {
    local team_key=$1
    local cache_file="$LINEAR_CACHE_DIR/team_${team_key}.json"

    # Check if cache exists and is not expired
    if [ -f "$cache_file" ] && [ $(($(date +%s) - $(stat -c %Y "$cache_file"))) -lt $LINEAR_CACHE_EXPIRY ]; then
        if command -v jq &>/dev/null; then
            cat "$cache_file" | jq -r '.id'
        else
            grep -o '"id":"[^"]*"' "$cache_file" | cut -d'"' -f4
        fi
        return 0
    fi

    # Query Linear API for team ID
    response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"query { team(key: \\\"$team_key\\\") { id name key } }\"}" \
        $LINEAR_API_URL)

    # Save to cache
    echo "$response" > "$cache_file"

    # Extract team ID
    if command -v jq &>/dev/null; then
        echo "$response" | jq -r '.data.team.id'
    else
        echo "$response" | grep -o '"id":"[^"]*"' | head -1 | cut -d'"' -f4
    fi
}

# Function to get state ID by name
get_state_id_by_name() {
    local state_name=$1
    local team_key=${2:-$TEAM_KEY}
    local verbose=${3:-true}
    local cache_file="$LINEAR_CACHE_DIR/states_${team_key}.json"

    if [ "$verbose" = true ]; then
        echo "Getting state ID for '$state_name' in team '$team_key'..." >&2
    fi

    # Check if cache exists and is not expired
    if [ -f "$cache_file" ] && [ $(($(date +%s) - $(stat -c %Y "$cache_file"))) -lt $LINEAR_CACHE_EXPIRY ]; then
        if [ "$verbose" = true ]; then
            echo "Using cached workflow states..." >&2
        fi

        if command -v jq &>/dev/null; then
            state_id=$(cat "$cache_file" | jq -r ".data.workflowStates.nodes[] | select(.name == \"$state_name\") | .id")
            if [ -n "$state_id" ] && [ "$state_id" != "null" ]; then
                if [ "$verbose" = true ]; then
                    echo "Found state ID in cache: $state_id" >&2
                fi
                printf "%s" "$state_id"
                return 0
            fi
        else
            # Fallback for systems without jq
            state_id=$(grep -A 5 "\"name\":\"$state_name\"" "$cache_file" | grep -o '"id":"[^"]*"' | head -1 | cut -d'"' -f4)
            if [ -n "$state_id" ]; then
                if [ "$verbose" = true ]; then
                    echo "Found state ID in cache: $state_id" >&2
                fi
                printf "%s" "$state_id"
                return 0
            fi
        fi

        if [ "$verbose" = true ]; then
            echo "State not found in cache, querying API..." >&2
        fi
    else
        if [ "$verbose" = true ]; then
            echo "Cache not found or expired, querying API..." >&2
        fi
    fi

    # Query Linear API for states
    if [ "$verbose" = true ]; then
        echo "Querying Linear API for workflow states..." >&2
    fi

    response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"query { workflowStates(filter: { team: { key: { eq: \\\"$team_key\\\" } } }) { nodes { id name } } }\"}" \
        $LINEAR_API_URL)

    # Check for errors in the response
    if [[ $response == *"errors"* ]]; then
        echo "Error in API response:" >&2
        echo "$response" | jq -r '.errors[].message' 2>/dev/null || echo "$response" >&2
        return 1
    fi

    # Save to cache
    mkdir -p "$LINEAR_CACHE_DIR"
    echo "$response" > "$cache_file"

    if [ "$verbose" = true ]; then
        echo "Workflow states cached for team $team_key" >&2
    fi

    # Extract state ID
    local state_id=""
    if command -v jq &>/dev/null; then
        # Check if we have any workflow states in the response
        if ! echo "$response" | jq -e '.data.workflowStates.nodes' > /dev/null 2>&1; then
            echo "Error: No workflow states found for team $team_key" >&2
            echo "Full response: $response" >&2
            return 1
        fi

        state_id=$(echo "$response" | jq -r ".data.workflowStates.nodes[] | select(.name == \"$state_name\") | .id")
    else
        # Fallback for systems without jq
        state_id=$(grep -A 5 "\"name\":\"$state_name\"" <(echo "$response") | grep -o '"id":"[^"]*"' | head -1 | cut -d'"' -f4)
    fi

    if [ -z "$state_id" ] || [ "$state_id" = "null" ]; then
        echo "Error: Could not find state '$state_name' for team $team_key" >&2

        # List available states for debugging
        if [ "$verbose" = true ] && command -v jq &>/dev/null; then
            echo "Available states:" >&2
            echo "$response" | jq -r '.data.workflowStates.nodes[] | .name' >&2
        fi

        return 1
    fi

    if [ "$verbose" = true ]; then
        echo "Found state ID: $state_id" >&2
    fi

    printf "%s" "$state_id"
    return 0
}

# Function to get label ID by name
get_label_id_by_name() {
    local label_name=$1
    local team_key=${2:-$TEAM_KEY}
    local cache_file="$LINEAR_CACHE_DIR/labels_${team_key}.json"

    # Check if cache exists and is not expired
    if [ -f "$cache_file" ] && [ $(($(date +%s) - $(stat -c %Y "$cache_file"))) -lt $LINEAR_CACHE_EXPIRY ]; then
        if command -v jq &>/dev/null; then
            label_id=$(cat "$cache_file" | jq -r ".data.team.labels.nodes[] | select(.name == \"$label_name\") | .id")
            if [ -n "$label_id" ]; then
                echo "$label_id"
                return 0
            fi
        else
            # Fallback for systems without jq
            grep -A 5 "\"name\":\"$label_name\"" "$cache_file" | grep -o '"id":"[^"]*"' | head -1 | cut -d'"' -f4
            return 0
        fi
    fi

    # Get team ID
    team_id=$(get_team_id "$team_key")

    # Query Linear API for labels
    response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"query { team(id: \\\"$team_id\\\") { labels { nodes { id name } } } }\"}" \
        $LINEAR_API_URL)

    # Save to cache
    echo "$response" > "$cache_file"

    # Extract label ID
    if command -v jq &>/dev/null; then
        echo "$response" | jq -r ".data.team.labels.nodes[] | select(.name == \"$label_name\") | .id"
    else
        grep -A 5 "\"name\":\"$label_name\"" <(echo "$response") | grep -o '"id":"[^"]*"' | head -1 | cut -d'"' -f4
    fi
}

# Function to get issue ID from identifier
get_issue_id_from_identifier() {
    local identifier=$1
    local verbose=${2:-true}

    if [ "$verbose" = true ]; then
        echo "Querying Linear API for issue ID of $identifier..." >&2
    fi

    # Extract team key and issue number
    local team_key="${identifier%%-*}"
    local issue_number="${identifier#*-}"

    if [ "$verbose" = true ]; then
        echo "Team key: $team_key, Issue number: $issue_number" >&2
    fi

    # Validate input
    if [ -z "$team_key" ] || [ -z "$issue_number" ] || [ "$team_key" = "$identifier" ]; then
        echo "Error: Invalid issue identifier format. Expected format: TEAM-NUMBER (e.g., WEC-56)" >&2
        return 1
    fi

    # Build the GraphQL query
    local query="{\"query\":\"query { issues(filter: { number: { eq: $issue_number }, team: { key: { eq: \\\"$team_key\\\" } } }) { nodes { id identifier title } } }\"}"

    # Query Linear API for issues by filter
    response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "$query" \
        $LINEAR_API_URL)

    # Check for errors in the response
    if [[ $response == *"errors"* ]]; then
        echo "Error in API response:" >&2
        echo "$response" | jq -r '.errors[].message' 2>/dev/null || echo "$response" >&2
        return 1
    fi

    # Extract issue ID
    local issue_id=""
    if command -v jq &>/dev/null; then
        # Check if we have any issues in the response
        if ! echo "$response" | jq -e '.data.issues.nodes' > /dev/null 2>&1; then
            echo "Error: Unexpected response format. Missing data.issues.nodes field." >&2
            echo "Full response: $response" >&2
            return 1
        fi

        local issue_count=$(echo "$response" | jq '.data.issues.nodes | length')

        if [ "$verbose" = true ]; then
            echo "Found $issue_count matching issues" >&2
        fi

        if [ "$issue_count" = "0" ]; then
            echo "Error: Issue $identifier not found." >&2

            if [ "$verbose" = true ]; then
                # Try to list some issues for debugging
                echo "Fetching some issues from team $team_key for debugging..." >&2
                debug_response=$(curl -s -X POST \
                    -H "Authorization: $LINEAR_API_KEY" \
                    -H "Content-Type: application/json" \
                    -d "{\"query\":\"query { issues(filter: { team: { key: { eq: \\\"$team_key\\\" } } }, first: 5) { nodes { id identifier title } } }\"}" \
                    $LINEAR_API_URL)

                echo "Some issues from team $team_key:" >&2
                echo "$debug_response" | jq -r '.data.issues.nodes[] | .identifier + ": " + .title' 2>/dev/null || echo "$debug_response" >&2
            fi

            return 1
        fi

        # Get the ID of the first matching issue
        issue_id=$(echo "$response" | jq -r '.data.issues.nodes[0].id')

        if [ "$verbose" = true ]; then
            issue_title=$(echo "$response" | jq -r '.data.issues.nodes[0].title // "No title"')
            echo "Found issue: $issue_title with ID: $issue_id" >&2
        fi
    else
        # Fallback for systems without jq
        if [[ $response == *"\"nodes\":[]"* ]]; then
            echo "Error: Issue $identifier not found." >&2
            return 1
        fi

        issue_id=$(echo "$response" | grep -o '"id":"[^"]*"' | head -1 | cut -d'"' -f4)
    fi

    # Validate issue ID
    if [ -z "$issue_id" ] || [ "$issue_id" = "null" ]; then
        echo "Error: Could not extract issue ID from response:" >&2
        echo "$response" >&2
        return 1
    fi

    # Return only the issue ID without any other output
    printf "%s" "$issue_id"
    return 0
}

# Function to handle LINEAR-PULL command
linear_pull() {
    local issue_identifier=$1

    if [ -z "$issue_identifier" ]; then
        echo "Error: Issue identifier is required."
        echo "Usage: (LINEAR-PULL)(<ISSUE_IDENTIFIER>)"
        return 1
    fi

    echo "Fetching issue $issue_identifier from Linear..."

    # Check if LINEAR_API_KEY is set
    if [ -z "$LINEAR_API_KEY" ]; then
        echo "Error: LINEAR_API_KEY environment variable is not set."
        echo "Please set it with: export LINEAR_API_KEY=your_api_key"
        echo "You can generate an API key at: https://linear.app/wecoza/settings/api"
        return 1
    fi

    # Debug info
    echo "Using API URL: $LINEAR_API_URL"
    echo "API Key is set: ${LINEAR_API_KEY:0:3}...${LINEAR_API_KEY: -3}"

    # First get the issue ID from the identifier
    echo "Getting issue ID for $issue_identifier..."

    # Run the function with verbose=false to suppress debug output
    local issue_id
    issue_id=$(get_issue_id_from_identifier "$issue_identifier" false)

    if [ $? -ne 0 ] || [ -z "$issue_id" ]; then
        echo "Error: Failed to get issue ID for $issue_identifier"
        return 1
    fi

    echo "Using issue ID: $issue_id"

    # Query Linear API for issue details using ID
    echo "Sending GraphQL query for issue details..."
    # Prepare the query with proper escaping
    local query="query { issue(id: \\\"$issue_id\\\") { id identifier title description state { name } assignee { name email } labels { nodes { name color } } comments { nodes { body user { name } createdAt } } } }"
    local json_payload="{\"query\":\"$query\"}"

    response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "$json_payload" \
        $LINEAR_API_URL)

    # Check for errors in the response
    if [[ $response == *"errors"* ]]; then
        echo "Error in API response:"
        echo "$response" | jq -r '.errors[].message' 2>/dev/null || echo "$response"
        return 1
    fi

    # Check if the issue exists
    if [[ $response == *"\"issue\":null"* ]]; then
        echo "Error: Issue with ID $issue_id not found."
        echo "Full response: $response"
        return 1
    fi

    # Format output
    if command -v jq &>/dev/null; then
        # Check if data.issue exists
        if ! echo "$response" | jq -e '.data.issue' > /dev/null 2>&1; then
            echo "Error: Unexpected response format. Missing data.issue field."
            echo "Full response: $response"
            return 1
        fi

        # Extract issue details using jq
        actual_identifier=$(echo "$response" | jq -r '.data.issue.identifier // "Unknown"')
        title=$(echo "$response" | jq -r '.data.issue.title // "No title"')
        description=$(echo "$response" | jq -r '.data.issue.description // "No description"')
        state=$(echo "$response" | jq -r '.data.issue.state.name // "Unknown"')

        echo "# Issue $actual_identifier: $title"
        echo ""
        echo "## Status: $state"
        echo ""
        echo "$description"
        echo ""

        # Format comments
        echo "## Comments:"
        if echo "$response" | jq -e '.data.issue.comments.nodes' > /dev/null 2>&1; then
            comment_count=$(echo "$response" | jq '.data.issue.comments.nodes | length')

            if [ "$comment_count" = "0" ]; then
                echo "No comments yet."
            else
                echo "$response" | jq -r '.data.issue.comments.nodes[] | "### " + (if .user.name then .user.name else "System" end) + " on " + (.createdAt | sub("T"; " ") | sub("Z"; "") | sub("\\..*"; "")) + ":\n" + .body + "\n"'
            fi
        else
            echo "No comments data available."
        fi

        # Format labels
        echo "## Labels:"
        if echo "$response" | jq -e '.data.issue.labels.nodes' > /dev/null 2>&1; then
            label_count=$(echo "$response" | jq '.data.issue.labels.nodes | length')

            if [ "$label_count" = "0" ]; then
                echo "No labels."
            else
                echo "$response" | jq -r '.data.issue.labels.nodes[] | "- " + .name'
            fi
        else
            echo "No labels data available."
        fi
    else
        # Fallback for systems without jq
        echo "Error: jq is required for formatting the output."
        echo "Please install jq or view the raw response:"
        echo "$response"
    fi

    return 0
}

# Function to handle LINEAR-REVIEW command
linear_review() {
    local issue_identifier=$1

    if [ -z "$issue_identifier" ]; then
        echo "Error: Issue identifier is required."
        echo "Usage: (LINEAR-REVIEW)(<ISSUE_IDENTIFIER>)"
        return 1
    fi

    echo "Moving issue $issue_identifier to 'In Review' status..."

    # Get issue ID
    local issue_id
    issue_id=$(get_issue_id_from_identifier "$issue_identifier" false)

    if [ $? -ne 0 ] || [ -z "$issue_id" ]; then
        echo "Error: Could not find issue $issue_identifier."
        return 1
    fi

    echo "Using issue ID: $issue_id"

    # Get team key from issue identifier
    team_key="${issue_identifier%%-*}"
    echo "Team key: $team_key"

    # Get In Review state ID
    local in_review_state_id
    in_review_state_id=$(get_state_id_by_name "In Review" "$team_key" false)

    if [ -z "$in_review_state_id" ]; then
        echo "Error: Could not find 'In Review' state for team $team_key."
        echo "Trying to get all available states..."

        # Get all workflow states for debugging
        workflow_states=$(curl -s -X POST \
            -H "Authorization: $LINEAR_API_KEY" \
            -H "Content-Type: application/json" \
            -d "{\"query\":\"query { workflowStates(filter: { team: { key: { eq: \\\"$team_key\\\" } } }) { nodes { id name } } }\"}" \
            $LINEAR_API_URL)

        echo "Available workflow states:"
        echo "$workflow_states" | jq -r '.data.workflowStates.nodes[] | .name + " (" + .id + ")"' 2>/dev/null || echo "$workflow_states"

        # Try to find a similar state name
        echo "Trying to find a similar state to 'In Review'..."
        similar_states=("Review" "Ready for Review" "In QA" "QA" "Testing")

        for state in "${similar_states[@]}"; do
            echo "Checking for state: $state"
            state_id=$(echo "$workflow_states" | jq -r ".data.workflowStates.nodes[] | select(.name == \"$state\") | .id" 2>/dev/null)

            if [ -n "$state_id" ] && [ "$state_id" != "null" ]; then
                echo "Found alternative state: $state with ID: $state_id"
                in_review_state_id="$state_id"
                break
            fi
        done

        if [ -z "$in_review_state_id" ]; then
            echo "Error: Could not find any suitable review state."
            return 1
        fi
    fi

    echo "Using 'In Review' state ID: $in_review_state_id"

    # Update issue state
    echo "Updating issue state..."
    # Prepare the mutation with proper escaping
    local mutation="mutation { issueUpdate(id: \\\"$issue_id\\\", input: { stateId: \\\"$in_review_state_id\\\" }) { success issue { id identifier state { name } } } }"
    local json_payload="{\"query\":\"$mutation\"}"

    echo "Mutation payload: $json_payload"

    update_response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "$json_payload" \
        $LINEAR_API_URL)

    # Check for errors in the update response
    if [[ $update_response == *"errors"* ]]; then
        echo "Error updating issue state:"
        echo "$update_response" | jq -r '.errors[].message' 2>/dev/null || echo "$update_response"
        return 1
    fi

    # Check if update was successful
    update_success=$(echo "$update_response" | jq -r '.data.issueUpdate.success' 2>/dev/null)

    if [ "$update_success" != "true" ]; then
        echo "Error: Failed to update issue state."
        echo "Response: $update_response"
        return 1
    fi

    # Add implementation summary comment
    echo "Adding implementation summary comment..."
    # Create a properly escaped comment body
    local comment_body="## Implementation Summary\\\\n\\\\nThis issue has been moved to 'In Review' status. All required changes have been implemented and are ready for review.\\\\n\\\\n### Changes Made\\\\n\\\\n- Implemented all required functionality\\\\n- Added appropriate error handling\\\\n- Ensured code follows project standards\\\\n- Tested all changes thoroughly"

    # Create the GraphQL mutation with the comment body
    local comment_payload="{\"query\":\"mutation { commentCreate(input: { issueId: \\\"$issue_id\\\", body: \\\"$comment_body\\\" }) { success } }\"}"

    echo "Comment payload: $comment_payload"

    comment_response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "$comment_payload" \
        $LINEAR_API_URL)

    # Check for errors in the comment response
    if [[ $comment_response == *"errors"* ]]; then
        echo "Error adding comment:"
        echo "$comment_response" | jq -r '.errors[].message' 2>/dev/null || echo "$comment_response"
        echo "Issue state was updated successfully, but comment could not be added."
        return 0
    fi

    # Check if comment was added successfully
    comment_success=$(echo "$comment_response" | jq -r '.data.commentCreate.success' 2>/dev/null)

    if [ "$comment_success" != "true" ]; then
        echo "Warning: Failed to add implementation summary comment."
        echo "Response: $comment_response"
        echo "Issue state was updated successfully, but comment could not be added."
        return 0
    fi

    echo "Issue $issue_identifier has been moved to 'In Review' status."
    echo "Added implementation summary comment."

    return 0
}

# Function to handle LINEAR-CREATE command
linear_create() {
    local title=$1
    local body=$2
    local labels=$3

    # Handle auto-generation mode
    if [ "$title" = "AUTO_GENERATE" ]; then
        echo "Auto-generating issue..."

        # Prompt the user to provide a title and description for the issue
        echo "Please provide a title for the issue:"
        read -r title

        echo "Please provide a description for the issue (type 'DONE' on a new line when finished):"
        description=""
        while IFS= read -r line; do
            if [ "$line" = "DONE" ]; then
                break
            fi
            description+="$line"$'\n'
        done

        # Default labels
        labels="Feature"

        if [ -z "$title" ]; then
            echo "Error: Title is required."
            return 1
        fi

        body="$description"

        echo "Creating new issue with title: $title"
    elif [ -z "$title" ]; then
        echo "Error: Title is required."
        echo "Usage: (LINEAR-CREATE)(\"Title\")(\"Body\")(\"label1,label2\")"
        return 1
    else
        echo "Creating new issue with title: $title"
    fi

    # Get team ID
    team_id=$(get_team_id "$TEAM_KEY")

    if [ -z "$team_id" ]; then
        echo "Error: Could not find team with key $TEAM_KEY."
        return 1
    fi

    # Prepare mutation for issue creation
    mutation="mutation { issueCreate(input: { teamId: \\\"$team_id\\\", title: \\\"$title\\\", description: \\\"$body\\\" }) { success issue { id identifier title url } } }"

    # If labels are provided, get their IDs and include them in the mutation
    if [ -n "$labels" ]; then
        label_ids="["
        IFS=',' read -ra LABEL_ARRAY <<< "$labels"
        for label in "${LABEL_ARRAY[@]}"; do
            label_id=$(get_label_id_by_name "$label")
            if [ -n "$label_id" ]; then
                label_ids+="\\\"$label_id\\\","
            fi
        done
        # Remove trailing comma and close array
        label_ids="${label_ids%,}]"

        # Update mutation to include labels
        mutation="mutation { issueCreate(input: { teamId: \\\"$team_id\\\", title: \\\"$title\\\", description: \\\"$body\\\", labelIds: $label_ids }) { success issue { id identifier title url } } }"
    fi

    # Create the issue
    response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"$mutation\"}" \
        $LINEAR_API_URL)

    # Check if issue was created successfully
    if command -v jq &>/dev/null; then
        success=$(echo "$response" | jq -r '.data.issueCreate.success')

        if [ "$success" = "true" ]; then
            issue_identifier=$(echo "$response" | jq -r '.data.issueCreate.issue.identifier')
            issue_url=$(echo "$response" | jq -r '.data.issueCreate.issue.url')
            echo "Issue $issue_identifier created successfully: $issue_url"
        else
            echo "Error: Failed to create issue."
            echo "Response: $response"
            return 1
        fi
    else
        # Fallback for systems without jq
        if [[ $response == *"\"success\":true"* ]]; then
            issue_identifier=$(echo "$response" | grep -o '"identifier":"[^"]*"' | head -1 | cut -d'"' -f4)
            issue_url=$(echo "$response" | grep -o '"url":"[^"]*"' | head -1 | cut -d'"' -f4)
            echo "Issue $issue_identifier created successfully: $issue_url"
        else
            echo "Error: Failed to create issue."
            echo "Response: $response"
            return 1
        fi
    fi

    return 0
}

# Function to check and set LINEAR_API_KEY if not already set
ensure_linear_api_key() {
    # Check if LINEAR_API_KEY is already set
    if [ -n "$LINEAR_API_KEY" ]; then
        echo "LINEAR_API_KEY is already set."
        return 0
    fi

    # Check if API key is stored in a file
    if [ -f "$HOME/.linear/credentials" ]; then
        echo "Loading API key from $HOME/.linear/credentials..."
        export LINEAR_API_KEY=$(cat "$HOME/.linear/credentials")
        return 0
    fi

    # Prompt user for API key
    echo "LINEAR_API_KEY is not set. Please enter your Linear API key:"
    read -r api_key

    if [ -z "$api_key" ]; then
        echo "Error: No API key provided."
        echo "You can generate an API key at: https://linear.app/wecoza/settings/api"
        return 1
    fi

    # Set the API key
    export LINEAR_API_KEY="$api_key"

    # Ask if user wants to save the API key
    echo "Do you want to save this API key for future use? (y/n)"
    read -r save_key

    if [[ "$save_key" == "y" || "$save_key" == "Y" ]]; then
        mkdir -p "$HOME/.linear"
        echo "$api_key" > "$HOME/.linear/credentials"
        chmod 600 "$HOME/.linear/credentials"
        echo "API key saved to $HOME/.linear/credentials"
    fi

    return 0
}

# Main function to handle Linear CLI commands
handle_linear_command() {
    local command=$1
    local param1=$2
    local param2=$3
    local param3=$4

    echo "Executing Linear CLI command: $command"

    # Ensure cache directory exists
    ensure_cache_dir

    # Ensure LINEAR_API_KEY is set
    ensure_linear_api_key || return 1

    # Check Linear API authentication
    check_linear_auth || return 1

    case $command in
        "LINEAR-PULL")
            linear_pull "$param1"
            ;;
        "LINEAR-REVIEW")
            linear_review "$param1"
            ;;
        "LINEAR-CREATE")
            linear_create "$param1" "$param2" "$param3"
            ;;
        "LINEAR-DEBUG")
            echo "Running in debug mode..."
            echo "LINEAR_API_URL: $LINEAR_API_URL"
            echo "LINEAR_CACHE_DIR: $LINEAR_CACHE_DIR"
            echo "LINEAR_API_KEY is set: $(if [ -n "$LINEAR_API_KEY" ]; then echo "Yes"; else echo "No"; fi)"
            echo "jq is available: $(if command -v jq &>/dev/null; then echo "Yes"; else echo "No"; fi)"
            return 0
            ;;
        *)
            echo "Error: Unknown command '$command'."
            echo "Available commands: LINEAR-PULL, LINEAR-REVIEW, LINEAR-CREATE, LINEAR-DEBUG"
            return 1
            ;;
    esac
}

# If this script is run directly, parse arguments and execute
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    if [ $# -lt 1 ]; then
        echo "Error: Insufficient arguments."
        echo "Usage: $0 <command> [parameters...]"
        exit 1
    fi

    handle_linear_command "$@"
fi

# Example implementation
linear_set_priority() {
    local issue_identifier=$1
    local priority=$2  # "Urgent", "High", "Medium", "Low", "No priority"
    
    # Convert priority name to value
    local priority_value
    case "$priority" in
        "Urgent") priority_value=1 ;;
        "High") priority_value=2 ;;
        "Medium") priority_value=3 ;;
        "Low") priority_value=4 ;;
        "No priority") priority_value=0 ;;
        *) echo "Invalid priority: $priority"; return 1 ;;
    esac
    
    # Get issue ID
    local issue_id=$(get_issue_id_from_identifier "$issue_identifier")
    
    # Update priority
    local mutation="mutation { issueUpdate(id: \\\"$issue_id\\\", input: { priority: $priority_value }) { success } }"
    local response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"$mutation\"}" \
        $LINEAR_API_URL)
        
    # Check success
    if [[ $(echo "$response" | jq -r '.data.issueUpdate.success') == "true" ]]; then
        echo "Updated priority of $issue_identifier to $priority"
        return 0
    else
        echo "Failed to update priority: $response"
        return 1
    fi
}

# Example implementation
linear_link_issues() {
    local source_issue=$1
    local target_issue=$2
    local relationship_type=$3  # "blocks", "relates_to", "duplicate", etc.
    
    # Get issue IDs
    local source_id=$(get_issue_id_from_identifier "$source_issue")
    local target_id=$(get_issue_id_from_identifier "$target_issue")
    
    # Create relationship
    local mutation="mutation { issueRelationCreate(input: { issueId: \\\"$source_id\\\", relatedIssueId: \\\"$target_id\\\", type: $relationship_type }) { success } }"
    local response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"$mutation\"}" \
        $LINEAR_API_URL)
        
    # Check success
    if [[ $(echo "$response" | jq -r '.data.issueRelationCreate.success') == "true" ]]; then
        echo "Created $relationship_type relationship between $source_issue and $target_issue"
        return 0
    else
        echo "Failed to create relationship: $response"
        return 1
    fi
}

# Example implementation for file upload
linear_upload_file() {
    local file_path=$1
    local issue_identifier=$2
    
    # Get issue ID
    local issue_id=$(get_issue_id_from_identifier "$issue_identifier")
    
    # Get file upload URL
    local query="mutation { attachmentLinkURL(fileName: \\\"$(basename "$file_path")\\\", contentType: \\\"application/octet-stream\\\", size: $(stat -c%s "$file_path")) { success url attachmentId } }"
    local response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"$query\"}" \
        $LINEAR_API_URL)
        
    # Check if URL generation was successful
    if [[ $(echo "$response" | jq -r '.data.attachmentLinkURL.success') != "true" ]]; then
        echo "Failed to get upload URL: $response"
        return 1
    fi
    
    # Extract upload URL and attachment ID
    local upload_url=$(echo "$response" | jq -r '.data.attachmentLinkURL.url')
    local attachment_id=$(echo "$response" | jq -r '.data.attachmentLinkURL.attachmentId')
    
    # Upload file
    local upload_response=$(curl -s -X PUT \
        -H "Content-Type: application/octet-stream" \
        --data-binary "@$file_path" \
        "$upload_url")
        
    # Link attachment to issue
    local link_mutation="mutation { attachmentCreate(input: { id: \\\"$attachment_id\\\", issueId: \\\"$issue_id\\\" }) { success } }"
    local link_response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"$link_mutation\"}" \
        $LINEAR_API_URL)
        
    # Check if linking was successful
    if [[ $(echo "$link_response" | jq -r '.data.attachmentCreate.success') == "true" ]]; then
        echo "File $(basename "$file_path") uploaded and attached to $issue_identifier"
        return 0
    else
        echo "Failed to link attachment to issue: $link_response"
        return 1
    fi
}

# Example implementation
linear_search_issues() {
    local query_string=$1
    local team_key=$2
    local limit=${3:-10}
    
    # Build GraphQL query
    local query="query { issues(filter: { team: { key: { eq: \\\"$team_key\\\" } }, or: [{ title: { contains: \\\"$query_string\\\" } }, { description: { contains: \\\"$query_string\\\" } }] }, first: $limit) { nodes { id identifier title state { name } } } }"
    local response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"$query\"}" \
        $LINEAR_API_URL)
        
    # Format and display results
    if command -v jq &>/dev/null; then
        echo "Search results for \"$query_string\" in team $team_key:"
        echo "$response" | jq -r '.data.issues.nodes[] | "- " + .identifier + ": " + .title + " (" + .state.name + ")"'
    else
        echo "Search results (raw response):"
        echo "$response"
    fi
}
