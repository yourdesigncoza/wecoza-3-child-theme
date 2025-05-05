#!/bin/bash

# WeCoza 3 Child Theme CLI
# This script provides a command-line interface for various operations

# Source the CLI commands
source "$(dirname "$0")/scripts/cli/cli-commands.sh"

# Function to parse CLI commands from the format (COMMAND)(PARAMETER)
parse_cli_command() {
    local input=$1
    
    # Extract command and parameter using regex
    if [[ $input =~ \(([A-Z-]+)\)\(([0-9]+)\) ]]; then
        command="${BASH_REMATCH[1]}"
        parameter="${BASH_REMATCH[2]}"
        
        # Handle the command
        handle_cli_command "$command" "$parameter"
    else
        echo "Error: Invalid command format."
        echo "Expected format: (COMMAND)(PARAMETER)"
        return 1
    fi
}

# If this script is run directly, parse the first argument
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    if [ $# -lt 1 ]; then
        echo "Error: No command provided."
        echo "Usage: $0 '(COMMAND)(PARAMETER)'"
        exit 1
    fi
    
    parse_cli_command "$1"
fi
