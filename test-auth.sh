#!/bin/bash

# Test script for GitHub CLI authentication

# Check if GitHub CLI is authenticated
if ! gh auth status &>/dev/null; then
    echo "GitHub CLI is not authenticated."
    echo "To use the CLI commands, you need to authenticate with GitHub CLI:"
    echo ""
    echo "Run the following command and follow the prompts:"
    echo "  gh auth login"
    echo ""
    echo "After authentication, you can run the CLI commands."
    exit 1
else
    echo "GitHub CLI is authenticated."
    echo "You can use the CLI commands."
    exit 0
fi
