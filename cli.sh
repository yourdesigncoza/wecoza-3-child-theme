#!/bin/bash

# WeCoza 3 Child Theme CLI
# This script provides a command-line interface for various operations

# Source the CLI commands
source "$(dirname "$0")/scripts/cli/cli-commands.sh"

# Function to parse CLI commands from various formats
parse_cli_command() {
    local input=$1

    # Extract command and parameters using regex
    # Format 1: (COMMAND)(PARAMETER) - for CLI-PULL and CLI-REVIEW
    if [[ $input =~ \(([A-Z-]+)\)\(([0-9]+)\) ]]; then
        command="${BASH_REMATCH[1]}"
        parameter="${BASH_REMATCH[2]}"

        # Handle the command
        handle_cli_command "$command" "$parameter"
    # Format 2: (COMMAND)("PARAM1")("PARAM2")("PARAM3") - for CLI-CREATE with explicit parameters
    elif [[ $input =~ \(([A-Z-]+)\)\(\"([^\"]*)\"\)\(\"([^\"]*)\"\)(\(\"([^\"]*)\"\))? ]]; then
        command="${BASH_REMATCH[1]}"
        param1="${BASH_REMATCH[2]}"
        param2="${BASH_REMATCH[3]}"
        param3="${BASH_REMATCH[5]}" # This might be empty

        # Handle the command
        handle_cli_command "$command" "$param1" "$param2" "$param3"
    # Format 3: (COMMAND) - for CLI-CREATE without parameters (auto-generate from Augment)
    elif [[ $input =~ \(([A-Z-]+)\) ]]; then
        command="${BASH_REMATCH[1]}"

        # Special handling for CLI-CREATE without parameters
        if [[ "$command" == "CLI-CREATE" ]]; then
            # Call CLI-CREATE with special flag to indicate auto-generation
            handle_cli_command "$command" "AUTO_GENERATE" "" ""
        else
            echo "Error: Invalid command format for $command."
            echo "Expected formats:"
            echo "  (CLI-PULL)(ISSUE_NUMBER)"
            echo "  (CLI-REVIEW)(ISSUE_NUMBER)"
            echo "  (CLI-CREATE) - Auto-generate from Augment thread"
            return 1
        fi
    else
        echo "Error: Invalid command format."
        echo "Expected formats:"
        echo "  (COMMAND)(PARAMETER) - for CLI-PULL and CLI-REVIEW"
        echo "  (CLI-CREATE) - Auto-generate from Augment thread"
        echo "  (CLI-CREATE)(\"TITLE\")(\"BODY\")(\"LABELS\") - for CLI-CREATE with explicit parameters"
        return 1
    fi
}

# If this script is run directly, parse the first argument
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    if [ $# -lt 1 ]; then
        echo "Error: No command provided."
        echo "Usage:"
        echo "  $0 '(CLI-PULL)(ISSUE_NUMBER)'"
        echo "  $0 '(CLI-REVIEW)(ISSUE_NUMBER)'"
        echo "  $0 '(CLI-CREATE)'"
        echo "  $0 '(CLI-CREATE)(\"TITLE\")(\"BODY\")(\"LABELS\")'"
        echo ""
        echo "Examples:"
        echo "  $0 '(CLI-PULL)(123)'"
        echo "  $0 '(CLI-REVIEW)(123)'"
        echo "  $0 '(CLI-CREATE)' # Auto-generates issue from Augment thread"
        echo "  $0 '(CLI-CREATE)(\"Bug: Login Form\")(\"The login form is not working properly.\nSteps to reproduce:\n1. Go to login page\n2. Enter credentials\n3. Click submit\")(\"bug,priority:high\")'"
        exit 1
    fi

    parse_cli_command "$1"
fi
