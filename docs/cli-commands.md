# WeCoza 3 Child Theme CLI Commands

This document describes the available CLI commands for the WeCoza 3 Child Theme.

## Prerequisites

You have two options for authentication:

### Option 1: GitHub CLI Authentication (Recommended)

Authenticate with GitHub CLI:

```bash
gh auth login
```

Follow the prompts to authenticate with your GitHub account.

### Option 2: GitHub Token

If you prefer not to use GitHub CLI authentication, you can set a GitHub token:

```bash
export GITHUB_TOKEN=your_token_here
```

You can create a token at https://github.com/settings/tokens with the `repo` scope.

The script will automatically use GitHub CLI if authenticated, or fall back to using the GITHUB_TOKEN if set.

## Available Commands

### CLI-PULL

Fetches and displays detailed information about a GitHub issue.

**Usage:**
```
(CLI-PULL)(<ISSUE_NUMBER>)
```

**Example:**
```
(CLI-PULL)(123)
```

**Output Format:**
```
# Issue #<NUMBER>: <TITLE>

## Status: <STATUS>

<BODY>

## Comments:
### <AUTHOR> on <DATE>:
<COMMENT_BODY>

### <AUTHOR> on <DATE>:
<COMMENT_BODY>

## Labels:
- <LABEL1>
- <LABEL2>
```

### CLI-REVIEW

Moves an issue to "In Review" status with complete documentation.

**Usage:**
```
(CLI-REVIEW)(<ISSUE_NUMBER>)
```

**Example:**
```
(CLI-REVIEW)(123)
```

**Actions:**
1. Adds implementation summary comment to the issue
2. Updates issue labels to remove "backlog" and add "in-review"

### CLI-CREATE

Creates a new GitHub issue. Can be used in two ways:

#### 1. Auto-generation from Augment thread

**Usage:**
```
(CLI-CREATE)
```

This simplified format will prompt you for a title and description, making it easy to create issues directly from Augment conversations.

**Process:**
1. The command prompts you for a title
2. Then prompts you for a description (type 'DONE' on a new line when finished)
3. Automatically applies the labels "augment" and "auto-generated"
4. Creates the issue and returns the issue number and URL

**Example Output:**
```
Auto-generating issue from Augment thread...
Please provide a title for the issue:
Implement CLI-CREATE command
Please provide a description for the issue (type 'DONE' on a new line when finished):
Create a CLI command that can generate GitHub issues from Augment threads.

Requirements:
- Simple (CLI-CREATE) format
- Auto-prompt for title and description
- Apply default labels
DONE
Creating new issue with title: Implement CLI-CREATE command
Using GitHub CLI...
Issue #456 created successfully: https://github.com/yourdesigncoza/wecoza-3-child-theme/issues/456
```

#### 2. Explicit parameter specification

**Usage:**
```
(CLI-CREATE)("<TITLE>")("<BODY>")("<LABELS>")
```

**Example:**
```
(CLI-CREATE)("Bug: Login Form")("The login form is not working properly.
Steps to reproduce:
1. Go to login page
2. Enter credentials
3. Click submit")("bug,priority:high")
```

**Notes:**
- The title is required
- The body can include multiple lines with proper formatting
- Labels are optional and should be comma-separated
- All parameters must be enclosed in double quotes

**Output:**
```
Creating new issue with title: Bug: Login Form
Using GitHub CLI...
Issue #456 created successfully: https://github.com/yourdesigncoza/wecoza-3-child-theme/issues/456
```

## Implementation Details

These commands are implemented as bash scripts that use the GitHub CLI or GitHub API to interact with issues. The scripts are located in:

- `cli.sh` - Main CLI wrapper script
- `scripts/cli/cli-commands.sh` - Implementation of CLI commands

The implementation has the following features:

- Uses GitHub CLI if authenticated
- Falls back to GitHub API with GITHUB_TOKEN if CLI is not authenticated
- Handles both authentication methods transparently
- Uses `jq` for JSON parsing if available, with fallback to `grep` and `sed`
- Comprehensive error handling

## Troubleshooting

If you encounter issues with the CLI commands:

1. **Authentication Errors**:
   - For GitHub CLI: Run `gh auth status` to check authentication status
   - For token: Ensure your GITHUB_TOKEN is set and has the correct permissions

2. **GitHub CLI Not Found**:
   - Make sure GitHub CLI is installed. Run `gh --version` to check
   - Install it following the instructions at: https://cli.github.com/manual/installation
   - Alternatively, use the GITHUB_TOKEN method

3. **Issue Not Found**:
   - Verify that the issue number exists in the repository
   - Check that you have permission to view the issue

4. **JSON Parsing Errors**:
   - Install `jq` for better JSON parsing: `sudo apt-get install jq`
   - The script will fall back to `grep` and `sed` if `jq` is not available
