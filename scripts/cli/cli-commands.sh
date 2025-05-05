#!/bin/bash

# CLI Commands for WeCoza 3 Child Theme
# This script contains functions for various CLI commands

# Configuration
REPO_OWNER="yourdesigncoza"
REPO_NAME="wecoza-3-child-theme"

# Function to check GitHub CLI authentication
check_github_auth() {
    # First check if GitHub CLI is installed
    if ! command -v gh &>/dev/null; then
        echo "Error: GitHub CLI is not installed."
        echo "Please install it following the instructions at: https://cli.github.com/manual/installation"
        return 1
    fi

    # Check if GitHub CLI is authenticated
    if ! gh auth status &>/dev/null; then
        echo "Error: GitHub CLI is not authenticated."
        echo "Please run 'gh auth login' to authenticate."
        echo ""
        echo "If you prefer not to authenticate, you can set the GITHUB_TOKEN environment variable:"
        echo "export GITHUB_TOKEN=your_token_here"
        echo ""
        echo "The script will use this token if GitHub CLI is not authenticated."

        # Check if GITHUB_TOKEN is set as a fallback
        if [ -n "$GITHUB_TOKEN" ]; then
            echo "GITHUB_TOKEN is set. Using token authentication as fallback."
            return 0
        fi

        return 1
    fi
    return 0
}

# Function to handle CLI-PULL command
cli_pull() {
    local issue_number=$1

    if [ -z "$issue_number" ]; then
        echo "Error: Issue number is required."
        echo "Usage: (CLI-PULL)(<ISSUE_NUMBER>)"
        return 1
    fi

    echo "Fetching issue #$issue_number from GitHub..."

    # Check if we should use GitHub CLI or fallback to curl with GITHUB_TOKEN
    if gh auth status &>/dev/null; then
        # Use GitHub CLI
        echo "Using GitHub CLI..."

        # First, check if the issue exists
        if ! gh issue view "$issue_number" --repo "$REPO_OWNER/$REPO_NAME" &>/dev/null; then
            echo "Error: Issue #$issue_number not found."
            return 1
        fi

        # Get issue details in JSON format
        issue_json=$(gh issue view "$issue_number" --repo "$REPO_OWNER/$REPO_NAME" --json number,title,body,state,labels,comments)

        # Extract issue details using jq if available, otherwise fallback to grep
        if command -v jq &>/dev/null; then
            number=$(echo "$issue_json" | jq -r '.number')
            title=$(echo "$issue_json" | jq -r '.title')
            body=$(echo "$issue_json" | jq -r '.body')
            state=$(echo "$issue_json" | jq -r '.state')
        else
            number=$(echo "$issue_json" | grep -o '"number":[^,]*' | cut -d':' -f2)
            title=$(echo "$issue_json" | grep -o '"title":"[^"]*"' | cut -d'"' -f4)
            body=$(echo "$issue_json" | grep -o '"body":"[^"]*"' | cut -d'"' -f4 | sed 's/\\r\\n/\n/g' | sed 's/\\n/\n/g')
            state=$(echo "$issue_json" | grep -o '"state":"[^"]*"' | cut -d'"' -f4)
        fi

    elif [ -n "$GITHUB_TOKEN" ]; then
        # Fallback to curl with GITHUB_TOKEN
        echo "Using GITHUB_TOKEN for authentication..."

        # Use curl to fetch issue details
        response=$(curl -s -H "Authorization: token $GITHUB_TOKEN" \
            "https://api.github.com/repos/$REPO_OWNER/$REPO_NAME/issues/$issue_number")

        # Check if the issue exists
        if [[ $response == *"Not Found"* ]]; then
            echo "Error: Issue #$issue_number not found."
            return 1
        fi

        # Extract issue details
        if command -v jq &>/dev/null; then
            number=$(echo "$response" | jq -r '.number')
            title=$(echo "$response" | jq -r '.title')
            body=$(echo "$response" | jq -r '.body')
            state=$(echo "$response" | jq -r '.state')

            # Get comments
            comments_url=$(echo "$response" | jq -r '.comments_url')
            issue_json=$(curl -s -H "Authorization: token $GITHUB_TOKEN" "$comments_url")
        else
            number=$(echo "$response" | grep -o '"number":[^,]*' | cut -d':' -f2)
            title=$(echo "$response" | grep -o '"title":"[^"]*"' | cut -d'"' -f4)
            body=$(echo "$response" | grep -o '"body":"[^"]*"' | cut -d'"' -f4 | sed 's/\\r\\n/\n/g' | sed 's/\\n/\n/g')
            state=$(echo "$response" | grep -o '"state":"[^"]*"' | cut -d'"' -f4)

            # Get comments
            comments_url=$(echo "$response" | grep -o '"comments_url":"[^"]*"' | cut -d'"' -f4)
            issue_json=$(curl -s -H "Authorization: token $GITHUB_TOKEN" "$comments_url")
        fi
    else
        echo "Error: Neither GitHub CLI authentication nor GITHUB_TOKEN is available."
        echo "Please either authenticate with GitHub CLI or set the GITHUB_TOKEN environment variable."
        return 1
    fi

    # Format output
    echo "# Issue #$number: $title"
    echo ""
    echo "## Status: $state"
    echo ""
    echo "$body"
    echo ""

    # Format comments
    echo "## Comments:"

    if command -v jq &>/dev/null; then
        # Check if issue_json is an array or an object
        is_array=$(echo "$issue_json" | jq 'if type == "array" then true else false end')

        if [ "$is_array" = "true" ]; then
            # It's an array (likely comments)
            comment_count=$(echo "$issue_json" | jq 'length')
        else
            # It's an object (likely issue with comments field)
            comment_count=$(echo "$issue_json" | jq '.comments | length')
        fi

        if [ -z "$comment_count" ] || [ "$comment_count" = "null" ] || [ "$comment_count" -eq 0 ]; then
            echo "No comments yet."
        else
            # Process each comment based on format
            if [ "$is_array" = "true" ]; then
                # Direct array of comments
                echo "$issue_json" | jq -r '.[] | "### " + (.author.login // .user.login) + " on " + (.createdAt // .created_at | sub("T"; " ") | sub("Z"; "") | sub("\\..*"; "")) + ":\n" + .body + "\n"'
            else
                # Comments inside the issue object
                echo "$issue_json" | jq -r '.comments[] | "### " + (.author.login // .user.login) + " on " + (.createdAt // .created_at | sub("T"; " ") | sub("Z"; "") | sub("\\..*"; "")) + ":\n" + .body + "\n"'
            fi
        fi
    else
        # Fallback to grep and sed
        if [[ $issue_json == *"[]"* ]] || [[ $(echo "$issue_json" | grep -o '"id":[^,]*' | wc -l) -eq 0 ]]; then
            echo "No comments yet."
        else
            # Process each comment
            echo "$issue_json" | grep -o '{[^}]*}' | while read -r comment; do
                # Try both formats (GitHub CLI and API)
                author=$(echo "$comment" | grep -o '"author":{[^}]*}' | grep -o '"login":"[^"]*"' | cut -d'"' -f4)
                if [ -z "$author" ]; then
                    author=$(echo "$comment" | grep -o '"login":"[^"]*"' | cut -d'"' -f4)
                fi

                date=$(echo "$comment" | grep -o '"createdAt":"[^"]*"' | cut -d'"' -f4)
                if [ -z "$date" ]; then
                    date=$(echo "$comment" | grep -o '"created_at":"[^"]*"' | cut -d'"' -f4)
                fi
                date=$(echo "$date" | sed 's/T/ /g' | sed 's/Z//g' | cut -d'.' -f1)

                comment_body=$(echo "$comment" | grep -o '"body":"[^"]*"' | cut -d'"' -f4 | sed 's/\\r\\n/\n/g' | sed 's/\\n/\n/g')

                echo "### $author on $date:"
                echo "$comment_body"
                echo ""
            done
        fi
    fi

    # Format labels
    echo "## Labels:"

    if command -v jq &>/dev/null; then
        # Check if issue_json is an array or an object
        is_array=$(echo "$issue_json" | jq 'if type == "array" then true else false end')

        if [ "$is_array" = "true" ]; then
            # For API responses, we need to use the original response
            if [ -n "$response" ]; then
                label_count=$(echo "$response" | jq '.labels | length')

                if [ -z "$label_count" ] || [ "$label_count" = "null" ] || [ "$label_count" -eq 0 ]; then
                    echo "No labels."
                else
                    echo "$response" | jq -r '.labels[] | "- " + .name'
                fi
            else
                echo "No labels information available."
            fi
        else
            # It's an object (likely issue with labels field)
            label_count=$(echo "$issue_json" | jq '.labels | length')

            if [ -z "$label_count" ] || [ "$label_count" = "null" ] || [ "$label_count" -eq 0 ]; then
                echo "No labels."
            else
                echo "$issue_json" | jq -r '.labels[] | "- " + .name'
            fi
        fi
    else
        # Fallback to grep and sed
        labels=$(echo "$response" | grep -o '"labels":\[[^]]*\]' | grep -o '"name":"[^"]*"' | cut -d'"' -f4)

        if [ -z "$labels" ]; then
            echo "No labels."
        else
            echo "$labels" | while read -r label; do
                echo "- $label"
            done
        fi
    fi

    return 0
}

# Function to handle CLI-REVIEW command
cli_review() {
    local issue_number=$1

    if [ -z "$issue_number" ]; then
        echo "Error: Issue number is required."
        echo "Usage: (CLI-REVIEW)(<ISSUE_NUMBER>)"
        return 1
    fi

    echo "Moving issue #$issue_number to 'In Review' status..."

    # Check if we should use GitHub CLI or fallback to curl with GITHUB_TOKEN
    if gh auth status &>/dev/null; then
        # Use GitHub CLI
        echo "Using GitHub CLI..."

        # First, check if the issue exists
        if ! gh issue view "$issue_number" --repo "$REPO_OWNER/$REPO_NAME" &>/dev/null; then
            echo "Error: Issue #$issue_number not found."
            return 1
        fi

        # Get current labels
        current_labels=$(gh issue view "$issue_number" --repo "$REPO_OWNER/$REPO_NAME" --json labels --jq '.labels[].name')

        # Remove 'backlog' label if present
        if echo "$current_labels" | grep -q "backlog"; then
            echo "Removing 'backlog' label..."
            gh issue edit "$issue_number" --repo "$REPO_OWNER/$REPO_NAME" --remove-label "backlog"
        fi

        # Add 'in-review' label if not already present
        if ! echo "$current_labels" | grep -q "in-review"; then
            echo "Adding 'in-review' label..."
            gh issue edit "$issue_number" --repo "$REPO_OWNER/$REPO_NAME" --add-label "in-review"
        fi

        # Add implementation summary comment
        echo "Adding implementation summary comment..."
        gh issue comment "$issue_number" --repo "$REPO_OWNER/$REPO_NAME" --body "## Implementation Summary

This issue has been moved to 'In Review' status. All required changes have been implemented and are ready for review."

    elif [ -n "$GITHUB_TOKEN" ]; then
        # Fallback to curl with GITHUB_TOKEN
        echo "Using GITHUB_TOKEN for authentication..."

        # First, get the current issue details
        response=$(curl -s -H "Authorization: token $GITHUB_TOKEN" \
            "https://api.github.com/repos/$REPO_OWNER/$REPO_NAME/issues/$issue_number")

        # Check if the issue exists
        if [[ $response == *"Not Found"* ]]; then
            echo "Error: Issue #$issue_number not found."
            return 1
        fi

        # Get current labels
        if command -v jq &>/dev/null; then
            current_labels=$(echo "$response" | jq -r '.labels[].name')
        else
            current_labels=$(echo "$response" | grep -o '"labels":\[[^]]*\]' | grep -o '"name":"[^"]*"' | cut -d'"' -f4)
        fi

        # Create a new array of labels, excluding 'backlog'
        new_labels=()
        for label in $current_labels; do
            if [ "$label" != "backlog" ]; then
                new_labels+=("$label")
            fi
        done

        # Add 'in-review' label if not already present
        if ! echo "${new_labels[*]}" | grep -q "in-review"; then
            new_labels+=("in-review")
        fi

        # Create a JSON array of labels
        labels_json="["
        for label in "${new_labels[@]}"; do
            labels_json+="\"$label\","
        done
        # Remove trailing comma and close array
        labels_json="${labels_json%,}]"

        # Update issue with new labels
        echo "Updating labels..."
        update_data="{\"labels\":$labels_json}"

        curl -s -X PATCH -H "Authorization: token $GITHUB_TOKEN" \
            -H "Content-Type: application/json" \
            -d "$update_data" \
            "https://api.github.com/repos/$REPO_OWNER/$REPO_NAME/issues/$issue_number" > /dev/null

        # Add implementation summary comment
        echo "Adding implementation summary comment..."
        comment_data="{\"body\":\"## Implementation Summary\\n\\nThis issue has been moved to 'In Review' status. All required changes have been implemented and are ready for review.\"}"

        curl -s -X POST -H "Authorization: token $GITHUB_TOKEN" \
            -H "Content-Type: application/json" \
            -d "$comment_data" \
            "https://api.github.com/repos/$REPO_OWNER/$REPO_NAME/issues/$issue_number/comments" > /dev/null
    else
        echo "Error: Neither GitHub CLI authentication nor GITHUB_TOKEN is available."
        echo "Please either authenticate with GitHub CLI or set the GITHUB_TOKEN environment variable."
        return 1
    fi

    echo "Issue #$issue_number has been moved to 'In Review' status."
    echo "Added implementation summary comment."

    return 0
}

# Function to handle CLI-CREATE command
cli_create() {
    local title=$1
    local body=$2
    local labels=$3

    # Handle auto-generation from Augment thread
    if [ "$title" = "AUTO_GENERATE" ]; then
        echo "Auto-generating issue from Augment thread..."

        # Create a temporary file to store the Augment thread
        temp_file=$(mktemp)

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

        # Default labels for Augment-generated issues
        labels="augment,auto-generated"

        # Clean up
        rm -f "$temp_file"

        if [ -z "$title" ]; then
            echo "Error: Title is required."
            return 1
        fi

        body="$description"

        echo "Creating new issue with title: $title"
    elif [ -z "$title" ]; then
        echo "Error: Title is required."
        echo "Usage: (CLI-CREATE)(\"Title\")(\"Body\")(\"label1,label2\")"
        return 1
    else
        echo "Creating new issue with title: $title"
    fi

    # Check if we should use GitHub CLI or fallback to curl with GITHUB_TOKEN
    if gh auth status &>/dev/null; then
        # Use GitHub CLI
        echo "Using GitHub CLI..."

        # Create the issue
        if [ -z "$labels" ]; then
            # Create issue without labels
            issue_url=$(gh issue create --repo "$REPO_OWNER/$REPO_NAME" --title "$title" --body "$body")
        else
            # Create issue with labels
            issue_url=$(gh issue create --repo "$REPO_OWNER/$REPO_NAME" --title "$title" --body "$body" --label "$labels")
        fi

        # Extract issue number from URL
        issue_number=$(echo "$issue_url" | grep -o '[0-9]*$')

        echo "Issue #$issue_number created successfully: $issue_url"

    elif [ -n "$GITHUB_TOKEN" ]; then
        # Fallback to curl with GITHUB_TOKEN
        echo "Using GITHUB_TOKEN for authentication..."

        # Prepare JSON data for issue creation
        if [ -z "$labels" ]; then
            # Create issue without labels
            issue_data="{\"title\":\"$title\",\"body\":\"$body\"}"
        else
            # Convert comma-separated labels to JSON array
            labels_json="["
            IFS=',' read -ra LABEL_ARRAY <<< "$labels"
            for label in "${LABEL_ARRAY[@]}"; do
                labels_json+="\"$label\","
            done
            # Remove trailing comma and close array
            labels_json="${labels_json%,}]"

            issue_data="{\"title\":\"$title\",\"body\":\"$body\",\"labels\":$labels_json}"
        fi

        # Create the issue
        response=$(curl -s -X POST -H "Authorization: token $GITHUB_TOKEN" \
            -H "Content-Type: application/json" \
            -d "$issue_data" \
            "https://api.github.com/repos/$REPO_OWNER/$REPO_NAME/issues")

        # Check if issue was created successfully
        if command -v jq &>/dev/null; then
            issue_number=$(echo "$response" | jq -r '.number')
            issue_url=$(echo "$response" | jq -r '.html_url')
        else
            issue_number=$(echo "$response" | grep -o '"number":[^,]*' | cut -d':' -f2)
            issue_url=$(echo "$response" | grep -o '"html_url":"[^"]*"' | cut -d'"' -f4)
        fi

        if [ -z "$issue_number" ] || [ "$issue_number" = "null" ]; then
            echo "Error: Failed to create issue."
            echo "Response: $response"
            return 1
        fi

        echo "Issue #$issue_number created successfully: $issue_url"
    else
        echo "Error: Neither GitHub CLI authentication nor GITHUB_TOKEN is available."
        echo "Please either authenticate with GitHub CLI or set the GITHUB_TOKEN environment variable."
        return 1
    fi

    return 0
}

# Main function to handle CLI commands
handle_cli_command() {
    local command=$1
    local param1=$2
    local param2=$3
    local param3=$4

    # Check GitHub CLI authentication
    check_github_auth || return 1

    case $command in
        "CLI-PULL")
            cli_pull "$param1"
            ;;
        "CLI-REVIEW")
            cli_review "$param1"
            ;;
        "CLI-CREATE")
            cli_create "$param1" "$param2" "$param3"
            ;;
        *)
            echo "Error: Unknown command '$command'."
            echo "Available commands: CLI-PULL, CLI-REVIEW, CLI-CREATE"
            return 1
            ;;
    esac
}

# If this script is run directly, parse arguments and execute
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    if [ $# -lt 2 ]; then
        echo "Error: Insufficient arguments."
        echo "Usage: $0 <command> <issue_number>"
        exit 1
    fi

    handle_cli_command "$1" "$2"
fi
