#!/bin/bash

# Test script for CLI commands

# Source the CLI commands
source "$(dirname "$0")/scripts/cli/cli-commands.sh"

# Test CLI-PULL command
echo "Testing CLI-PULL command..."
echo "-------------------------"
handle_cli_command "CLI-PULL" "1"
echo "-------------------------"

# Test CLI-REVIEW command
echo "Testing CLI-REVIEW command..."
echo "-------------------------"
handle_cli_command "CLI-REVIEW" "1"
echo "-------------------------"
