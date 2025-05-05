#!/bin/bash

# Test script for CLI-CREATE command with auto-generation

# Source the CLI commands
source "$(dirname "$0")/scripts/cli/cli-commands.sh"

# Test CLI-CREATE command with auto-generation
echo "Testing CLI-CREATE command with auto-generation..."
echo "-------------------------"
handle_cli_command "CLI-CREATE" "AUTO_GENERATE" "" ""
echo "-------------------------"
