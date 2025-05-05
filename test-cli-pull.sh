#!/bin/bash

# Test script for CLI-PULL command

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

# Run the CLI-PULL command
echo "Running CLI-PULL command for issue #$issue_number..."
echo "=================================================="
cli_pull "$issue_number"
echo "=================================================="
echo "CLI-PULL command completed."
