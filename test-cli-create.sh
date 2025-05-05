#!/bin/bash

# Test script for CLI-CREATE command

# Source the CLI commands
source "$(dirname "$0")/scripts/cli/cli-commands.sh"

# Test CLI-CREATE command
echo "Testing CLI-CREATE command..."
echo "-------------------------"
handle_cli_command "CLI-CREATE" "Test Issue from CLI" "This is a test issue created using the CLI-CREATE command.\n\nIt supports multi-line content." "test,cli"
echo "-------------------------"
