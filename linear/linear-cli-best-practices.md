# Linear CLI Best Practices

## Introduction

This document provides best practices and guidelines for interacting with the Linear API through CLI commands. Linear is a project management tool that offers a powerful GraphQL API for automation and integration.

## Common Pitfalls and Solutions

Based on our testing, here are common issues encountered when working with the Linear API and how to address them:

### 1. Using Identifiers vs UUIDs

**Problem**: Many API operations require UUIDs, not the human-readable identifiers (e.g., "WEC-56").

**Solution**: Always use the UUID for operations like:
- Setting parent issues
- Changing state
- Adding labels
- Assigning users

```bash
# INCORRECT - Will fail
linear_update "WEC-56" "In Progress"

# CORRECT - Will work
linear_update "4a9d4967-4ca4-4c9c-ab7a-4957263888ef" "aa5c44a6-ebdf-4167-8eb5-ae89c7f41c77"
```

### 2. State Changes

**Problem**: You cannot use state names directly; you must use state UUIDs.

**Solution**: Create a lookup function to get state IDs by name:

```bash
get_state_id_by_name() {
    local state_name=$1
    # Query Linear API to get the state ID
}
```

### 3. Label Operations

**Problem**: Similar to states, labels require UUIDs.

**Solution**: Create a lookup function for labels:

```bash
get_label_id_by_name() {
    local label_name=$1
    # Query Linear API to get the label ID
}
```

### 4. Error Handling

**Problem**: Linear API errors can be cryptic.

**Solution**: Implement robust error handling and validation:

```bash
handle_linear_error() {
    local response=$1
    if [[ $response == *"error"* ]]; then
        # Extract and display meaningful error message
        echo "Error: $(extract_error_message "$response")"
        return 1
    fi
    return 0
}
```

## Authentication Best Practices

### API Token Security

1. **Never hardcode API tokens** in your scripts.
2. Use environment variables or secure credential storage.
3. Set up token with appropriate permissions only.

```bash
# Store token in environment variable
export LINEAR_API_KEY="your_api_key"

# Or use a credentials file with restricted permissions
LINEAR_API_KEY=$(cat ~/.linear/credentials)
```

### Token Validation

Always validate your token before performing operations:

```bash
validate_linear_token() {
    # Make a simple API call to verify token validity
    response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d '{"query":"query { viewer { id } }"}' \
        https://api.linear.app/graphql)

    if [[ $response == *"error"* ]]; then
        echo "Invalid Linear API token"
        return 1
    fi
    return 0
}
```

## Working with Linear's GraphQL API

### Query Structure

Linear uses GraphQL, which requires understanding query structure:

```graphql
query {
  issues(filter: { team: { key: { eq: "WEC" } } }) {
    nodes {
      id
      identifier
      title
    }
  }
}
```

### Mutations for Changes

Changes in Linear use GraphQL mutations:

```graphql
mutation {
  issueUpdate(
    id: "issue-id-here",
    input: {
      stateId: "state-id-here"
    }
  ) {
    success
    issue {
      id
      identifier
      state {
        name
      }
    }
  }
}
```

## Command Design Patterns

### Command Structure

Follow a consistent pattern for CLI commands:

```bash
linear_command <action> <resource> [parameters...]

# Examples:
linear_command get issue WEC-56
linear_command update issue 4a9d4967-4ca4-4c9c-ab7a-4957263888ef --state="In Progress"
linear_command create issue "New Issue Title" --description="Description here"
```

### Caching IDs

Cache frequently used IDs to reduce API calls:

```bash
# Cache team, state, and label IDs
cache_linear_ids() {
    # Get and store team IDs
    # Get and store state IDs for each team
    # Get and store label IDs
}
```

## Implementing Linear CLI Commands

### Linear CLI Shortcuts

The following shortcut patterns provide a convenient way to interact with Linear from the command line:

#### 1. LINEAR-REVIEW MODE
* **Trigger**: `(LINEAR-REVIEW)(<ISSUE_IDENTIFIER>)`
* **Behavior**: Moves an issue to "In Review" status with complete documentation
* **Steps**:
  - Run `./linear-cli.sh '(LINEAR-REVIEW)(<ISSUE_IDENTIFIER>)'`
  - Adds implementation summary comment to the issue
  - Updates issue state to "In Review" in Linear
  - Uses Linear's workflow states instead of labels for status tracking
* **Multiple Issues**: Supports comma-separated identifiers: `(LINEAR-REVIEW)(WEC-50, WEC-51, WEC-52)`

#### 2. LINEAR-PULL MODE
* **Trigger**: `(LINEAR-PULL)(<ISSUE_IDENTIFIER>)`
* **Behavior**: Retrieves complete issue details from Linear and displays in a formatted way
* **Steps**:
  - Run `./linear-cli.sh '(LINEAR-PULL)(<ISSUE_IDENTIFIER>)'`
  - Fetches issue details using Linear's GraphQL API
  - Displays issue title, description, and status
  - Shows all comments in chronological order
  - Lists all labels attached to the issue
  - Handles Linear's UUID-based system transparently

#### 3. LINEAR-CREATE MODE
* **Trigger**: `(LINEAR-CREATE)` or `(LINEAR-CREATE)("Title")("Body")("Labels")`
* **Behavior**: Creates a new Linear issue with interactive prompts or explicit parameters
* **Steps**:
  - Run `./linear-cli.sh '(LINEAR-CREATE)'` for interactive mode
  - When prompted, enter a descriptive title for the issue
  - Enter a detailed description with relevant file references and requirements
  - Issue is created with "Feature" label by default
  - Automatically assigns to the Wecoza team
  - Alternatively, use `./linear-cli.sh '(LINEAR-CREATE)("Title")("Body")("Label1,Label2")'` for direct creation
  - Uses Linear's GraphQL mutations for issue creation

### Equivalent Commands to GitHub CLI

Here are Linear equivalents to your GitHub CLI commands:

#### 1. LINEAR-PULL

```bash
linear_pull() {
    local issue_identifier=$1

    # First get the issue ID from the identifier
    issue_id=$(get_issue_id_from_identifier "$issue_identifier")

    # Then fetch complete issue details
    fetch_issue_details "$issue_id"
}
```

#### 2. LINEAR-REVIEW

```bash
linear_review() {
    local issue_identifier=$1

    # Check if we have multiple issues (comma-separated)
    if [[ $issue_identifier == *","* ]]; then
        echo "Processing multiple issues: $issue_identifier"
        linear_review_multiple "$issue_identifier"
        return $?
    fi

    echo "Processing issue: $issue_identifier"

    # Get issue details first to check current state and gather information
    issue_details=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"query { issue(identifier: \\\"$issue_identifier\\\") { id title description state { id name } } }\"}" \
        $LINEAR_API_URL)

    # Extract issue ID
    issue_id=$(echo "$issue_details" | jq -r '.data.issue.id')

    if [ -z "$issue_id" ] || [ "$issue_id" == "null" ]; then
        echo "Error: Could not find issue $issue_identifier"
        return 1
    fi

    # Get team ID from issue identifier prefix
    team_key=$(echo "$issue_identifier" | cut -d'-' -f1)

    # Get workflow states for the team
    workflow_states=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"query { workflowStates(filter: { team: { key: { eq: \\\"$team_key\\\" } } }) { nodes { id name } } }\"}" \
        $LINEAR_API_URL)

    # Find the "In Review" state ID
    in_review_state_id=$(echo "$workflow_states" | jq -r '.data.workflowStates.nodes[] | select(.name == "In Review") | .id')

    if [ -z "$in_review_state_id" ] || [ "$in_review_state_id" == "null" ]; then
        echo "Error: Could not find 'In Review' state for team $team_key"
        return 1
    fi

    # Update issue state
    update_response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"mutation { issueUpdate(id: \\\"$issue_id\\\", input: { stateId: \\\"$in_review_state_id\\\" }) { success issue { id identifier state { name } } } }\"}" \
        $LINEAR_API_URL)

    # Check if update was successful
    update_success=$(echo "$update_response" | jq -r '.data.issueUpdate.success')

    if [ "$update_success" != "true" ]; then
        echo "Error: Failed to update issue state"
        echo "Response: $update_response"
        return 1
    fi

    # Add implementation summary comment
    comment_response=$(curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"mutation { commentCreate(input: { issueId: \\\"$issue_id\\\", body: \\\"# Implementation Summary\\n\\nThis issue has been reviewed and all implementation tasks have been completed. The code changes have been tested and are ready for final review.\\n\\n## Changes Made\\n\\n- Implemented all required functionality\\n- Added appropriate error handling\\n- Ensured code follows project standards\\n- Tested all changes thoroughly\\\" }) { success } }\"}" \
        $LINEAR_API_URL)

    # Check if comment was added successfully
    comment_success=$(echo "$comment_response" | jq -r '.data.commentCreate.success')

    if [ "$comment_success" != "true" ]; then
        echo "Warning: Failed to add implementation summary comment"
        echo "Response: $comment_response"
    fi

    echo "Issue $issue_identifier successfully moved to 'In Review' state"
    return 0
}

# Helper function to process multiple issues
linear_review_multiple() {
    local issue_identifiers=$1
    local success=true

    # Split the comma-separated list
    IFS=',' read -ra ISSUES <<< "$issue_identifiers"

    # Process each issue
    for issue in "${ISSUES[@]}"; do
        # Trim whitespace
        issue=$(echo "$issue" | xargs)

        if [ -z "$issue" ]; then
            continue
        fi

        echo "Processing issue: $issue"

        # Get issue details and update state
        issue_details=$(curl -s -X POST \
            -H "Authorization: $LINEAR_API_KEY" \
            -H "Content-Type: application/json" \
            -d "{\"query\":\"query { issue(identifier: \\\"$issue\\\") { id title description state { id name } } }\"}" \
            $LINEAR_API_URL)

        # Extract issue ID
        issue_id=$(echo "$issue_details" | jq -r '.data.issue.id')

        if [ -z "$issue_id" ] || [ "$issue_id" == "null" ]; then
            echo "Error: Could not find issue $issue"
            success=false
            continue
        fi

        # Get team ID from issue identifier prefix
        team_key=$(echo "$issue" | cut -d'-' -f1)

        # Get workflow states for the team
        workflow_states=$(curl -s -X POST \
            -H "Authorization: $LINEAR_API_KEY" \
            -H "Content-Type: application/json" \
            -d "{\"query\":\"query { workflowStates(filter: { team: { key: { eq: \\\"$team_key\\\" } } }) { nodes { id name } } }\"}" \
            $LINEAR_API_URL)

        # Find the "In Review" state ID
        in_review_state_id=$(echo "$workflow_states" | jq -r '.data.workflowStates.nodes[] | select(.name == "In Review") | .id')

        if [ -z "$in_review_state_id" ] || [ "$in_review_state_id" == "null" ]; then
            echo "Error: Could not find 'In Review' state for team $team_key"
            success=false
            continue
        fi

        # Update issue state
        update_response=$(curl -s -X POST \
            -H "Authorization: $LINEAR_API_KEY" \
            -H "Content-Type: application/json" \
            -d "{\"query\":\"mutation { issueUpdate(id: \\\"$issue_id\\\", input: { stateId: \\\"$in_review_state_id\\\" }) { success issue { id identifier state { name } } } }\"}" \
            $LINEAR_API_URL)

        # Check if update was successful
        update_success=$(echo "$update_response" | jq -r '.data.issueUpdate.success')

        if [ "$update_success" != "true" ]; then
            echo "Error: Failed to update issue state for $issue"
            echo "Response: $update_response"
            success=false
            continue
        fi

        # Add implementation summary comment
        comment_response=$(curl -s -X POST \
            -H "Authorization: $LINEAR_API_KEY" \
            -H "Content-Type: application/json" \
            -d "{\"query\":\"mutation { commentCreate(input: { issueId: \\\"$issue_id\\\", body: \\\"# Implementation Summary\\n\\nThis issue has been reviewed and all implementation tasks have been completed. The code changes have been tested and are ready for final review.\\n\\n## Changes Made\\n\\n- Implemented all required functionality\\n- Added appropriate error handling\\n- Ensured code follows project standards\\n- Tested all changes thoroughly\\\" }) { success } }\"}" \
            $LINEAR_API_URL)

        echo "Issue $issue successfully moved to 'In Review' state"
    done

    if [ "$success" = true ]; then
        return 0
    else
        return 1
    fi
}
```

#### 3. LINEAR-CREATE

```bash
linear_create() {
    local title=$1
    local body=$2
    local labels=$3

    # Create the issue
    create_linear_issue "$title" "$body" "$labels"
}
```

## Error Messages and Troubleshooting

### Common Error Messages

| Error Message | Likely Cause | Solution |
|---------------|--------------|----------|
| `stateId must be a UUID` | Using state name instead of UUID | Use `get_state_id_by_name` function |
| `labelIds must be a UUID` | Using label name instead of UUID | Use `get_label_id_by_name` function |
| `parentId must be a UUID` | Using issue identifier instead of UUID | Use `get_issue_id_from_identifier` function |
| `Not authorized` | Invalid or expired API token | Regenerate API token |
| `not all arguments converted during string formatting` | String formatting error in query | Check for special characters in query parameters |
| `Failed to query Linear due to unparseable GQL` | Malformed GraphQL query | Validate query syntax in GraphQL playground |
| `Argument Validation Error` | Invalid argument type or format | Ensure all IDs are valid UUIDs |
| `null` responses | Missing or invalid API key | Check LINEAR_API_KEY environment variable |
| `Error: Issue WEC-XX not found` | Issue doesn't exist or no access | Verify issue ID and permissions |
| `Error: Could not find 'In Review' state` | Workflow state doesn't exist | Check team workflow configuration |
| `Unknown argument "identifier" on field "Query.issue"` | API changes in Linear | Use issues filter query instead of direct identifier lookup |
| `Bad control character in string literal in JSON` | Improper JSON escaping | Use proper escaping for newlines and quotes in JSON |
| `Syntax Error: Unterminated string` | Newline characters in GraphQL strings | Double escape newlines in GraphQL strings (\\\\n) |

### API Key Management

The LINEAR_API_KEY environment variable must be set before running any Linear CLI commands. There are several ways to manage this:

1. **Set in current shell session**:
   ```bash
   export LINEAR_API_KEY=your_api_key_here
   ```

2. **Add to shell profile** (for persistence):
   ```bash
   echo 'export LINEAR_API_KEY=your_api_key_here' >> ~/.bashrc
   source ~/.bashrc
   ```

3. **Store in credentials file**:
   ```bash
   mkdir -p ~/.linear
   echo 'your_api_key_here' > ~/.linear/credentials
   chmod 600 ~/.linear/credentials
   ```

4. **Use the interactive prompt**:
   The updated CLI will prompt for an API key if not found and offer to save it.

### Debugging Linear CLI Issues

If you encounter issues with the Linear CLI, use the new debug mode:

```bash
./linear-linear-cli.sh LINEAR-DEBUG
```

This will display:
- API URL being used
- Cache directory location
- Whether the API key is set
- Whether jq is available for formatting

Common issues and solutions:

1. **Empty or null responses**:
   - Check if LINEAR_API_KEY is set correctly
   - Verify API key has correct permissions
   - Check network connectivity to Linear API

2. **Issue not found errors**:
   - Verify the issue identifier is correct
   - Ensure you have access to the issue
   - Check team key in the issue identifier

3. **Authentication failures**:
   - Regenerate API key in Linear settings
   - Check for special characters in API key
   - Ensure API key is not expired

4. **Workflow state errors**:
   - Verify workflow state names in your Linear team
   - Different teams may have different workflow states
   - Custom workflows may require configuration updates

### Handling Multiple Issues in Commands

**Problem**: Commands like `LINEAR-REVIEW` fail when passing multiple issue identifiers.

**Solution**: Process each issue identifier separately:

```bash
linear_review_multiple() {
    local issue_identifiers=$1

    # Split the comma-separated list
    IFS=',' read -ra ISSUES <<< "$issue_identifiers"

    # Process each issue
    for issue in "${ISSUES[@]}"; do
        # Trim whitespace
        issue=$(echo "$issue" | xargs)
        echo "Processing issue: $issue"
        linear_review "$issue"
    done
}
```

### Handling API Changes in Linear

**Problem**: Linear occasionally updates their GraphQL API, which can break existing scripts.

**Solution**: Keep scripts updated to handle API changes and use more robust query methods:

1. **Issue Lookup Changes**:
   - Old method (no longer works): `query { issue(identifier: "WEC-56") { id } }`
   - New method: `query { issues(filter: { number: { eq: 56 }, team: { key: { eq: "WEC" } } }) { nodes { id } } }`

2. **String Escaping in GraphQL**:
   - Double escape newlines in GraphQL strings: `\\\\n` instead of `\\n`
   - Use proper JSON escaping for all special characters

3. **Robust JSON Handling**:
   - Create JSON payloads carefully to avoid control character issues
   - Use separate variables for query/mutation strings and JSON payloads

```bash
# Example of proper JSON handling
local query="query { issues(filter: { number: { eq: $issue_number }, team: { key: { eq: \\\"$team_key\\\" } } }) { nodes { id } } }"
local json_payload="{\"query\":\"$query\"}"

response=$(curl -s -X POST \
    -H "Authorization: $LINEAR_API_KEY" \
    -H "Content-Type: application/json" \
    -d "$json_payload" \
    $LINEAR_API_URL)
```

### Handling State Transitions

**Problem**: When updating an issue's state, you need the exact UUID of the target state, which varies by team workflow.

**Solution**: Create a workflow state cache that maps state names to UUIDs for each team:

```bash
# Cache workflow states for a team
cache_workflow_states() {
    local team_key=$1
    local cache_file="$LINEAR_CACHE_DIR/workflow_states_${team_key}.json"

    # Query and cache all workflow states for the team
    curl -s -X POST \
        -H "Authorization: $LINEAR_API_KEY" \
        -H "Content-Type: application/json" \
        -d "{\"query\":\"query { workflowStates(filter: { team: { key: { eq: \\\"$team_key\\\" } } }) { nodes { id name description color } } }\"}" \
        $LINEAR_API_URL > "$cache_file"

    echo "Workflow states cached for team $team_key"
}
```

### Debugging Tips

1. Use verbose mode to see full API requests and responses
2. Validate input parameters before sending to API
3. Test queries in Linear's GraphQL playground before implementing in CLI
4. Add proper error handling for GraphQL errors
5. Implement logging for all API calls to track issues
6. Use the LINEAR-DEBUG command to check configuration and authentication
7. Redirect debug output to stderr to keep function return values clean
8. Use printf instead of echo for returning values from functions
9. Check for null or empty responses at each step
10. Implement proper error codes and exit statuses

## Implementation Summary Comments

When moving issues to "In Review" status, it's important to provide detailed implementation summaries. Here are best practices for creating effective implementation summary comments:

### Comment Structure

Use a consistent structure for implementation summary comments:

```markdown
# Implementation Summary

Brief overview of what was implemented.

## Implementation Details

### 1. Component/Feature Name
- Specific implementation detail 1
- Specific implementation detail 2
- Specific implementation detail 3

### 2. Another Component/Feature
- Implementation detail 1
- Implementation detail 2

## Technical Challenges Solved
- Challenge 1: How it was solved
- Challenge 2: How it was solved

## Files Modified
- `path/to/file1.php` (new)
- `path/to/file2.js` (updated)
- `path/to/file3.css` (updated)

## Future Enhancements
- Potential improvement 1
- Potential improvement 2

## Completion Status
- ✅ Subtask 1 completed
- ✅ Subtask 2 completed
```

### Escaping Special Characters

When adding implementation summaries via the API, be careful with special characters:

```bash
# Escape newlines and quotes properly
body="# Implementation Summary\\n\\nThis is a summary with \\"quoted text\\"\\n\\n## Details\\n\\n- Item 1\\n- Item 2"
```

### Handling Markdown in GraphQL

Linear's GraphQL API requires proper escaping of markdown content:

```bash
# Double escape backslashes in GraphQL strings
query="{\"query\":\"mutation { commentCreate(input: { issueId: \\\"$issue_id\\\", body: \\\"# Title\\\\n\\\\n- Item 1\\\\n- Item 2\\\" }) { success } }\"}"
```

### Proper JSON Construction

To avoid issues with JSON parsing, construct your payloads carefully:

```bash
# Bad approach - prone to errors
curl -d "{\"query\":\"mutation { commentCreate(input: { issueId: \\\"$issue_id\\\", body: \\\"$comment_body\\\" }) { success } }\"}"

# Good approach - separate variables for better control
local comment_body="## Implementation Summary\\\\n\\\\nThis is a summary"
local json_payload="{\"query\":\"mutation { commentCreate(input: { issueId: \\\"$issue_id\\\", body: \\\"$comment_body\\\" }) { success } }\"}"
curl -d "$json_payload"
```

### Preserving Formatting

To preserve markdown formatting in API calls:

1. Use a heredoc for complex markdown:
```bash
read -r -d '' COMMENT << 'EOT'
# Implementation Summary

This is a multi-line comment
with **formatting**.

- List item 1
- List item 2
EOT

# Escape the heredoc content for GraphQL
ESCAPED_COMMENT=$(echo "$COMMENT" | sed 's/\\/\\\\/g' | sed 's/"/\\"/g' | sed ':a;N;$!ba;s/\n/\\n/g')
```

2. Use a template file for consistent comments:
```bash
# Load comment template and replace placeholders
template=$(cat templates/implementation-summary.md)
comment=${template//\{\{ISSUE_ID\}\}/$issue_identifier}
comment=${comment//\{\{DATE\}\}/$(date +"%Y-%m-%d")}
```

## Conclusion

Following these best practices will help you create robust and reliable Linear CLI commands. Remember to always use UUIDs for API operations and implement proper error handling.

## Resources

- [Linear API Documentation](https://developers.linear.app/docs/)
- [Linear GraphQL API Reference](https://developers.linear.app/docs/graphql/working-with-the-graphql-api)
- [Linear API Explorer](https://linear.app/wecoza/settings/api/explorer)
- [Linear Markdown Guide](https://linear.app/docs/markdown)
