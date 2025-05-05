#!/bin/bash

# Test script for CLI-REVIEW command

# Source the CLI commands
source "$(dirname "$0")/scripts/cli/cli-commands.sh"

# Check if an issue number was provided
if [ $# -lt 1 ]; then
    echo "Error: No issue number provided."
    echo "Usage: $0 <issue_number>"
    exit 1
fi

# Get the issue number
issue_number=$1

# Run the CLI-REVIEW command
echo "Running CLI-REVIEW command for issue #$issue_number..."
echo "=================================================="
cli_review "$issue_number"
echo "=================================================="
echo "CLI-REVIEW command completed."
