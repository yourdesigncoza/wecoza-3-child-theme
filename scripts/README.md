# WeCoza Scripts

This directory contains utility scripts for the WeCoza project.

## Prerequisites for All Scripts

- Node.js installed
- GitHub Personal Access Token with `repo` scope

## Installation

```bash
npm install
```

## Create GitHub Issues

The `create-github-issues.js` script creates GitHub issues from tasks in the `task-viewer.html` file.

### Usage

```bash
# Set your GitHub token
export GITHUB_TOKEN=your_personal_access_token

# Run in dry run mode first (recommended)
npm run create-issues:dry
# or
DRY_RUN=true node scripts/create-github-issues.js

# Run with debugging output
npm run create-issues:debug

# Run with both debugging and dry run
npm run create-issues:debug-dry

# When ready, run for real
npm run create-issues
# or
node scripts/create-github-issues.js
```

### What It Does

1. Extracts task data from `project-planning/task-viewer.html`
2. Creates GitHub issues for each task in sequential order
3. Formats subtasks, files, and comments as Markdown
4. Adds appropriate labels based on priority and status
5. Updates the task-viewer.html file with GitHub issue numbers

## Sync GitHub Issues

The `sync-github-issues.js` script synchronizes tasks between `task-viewer.html` and GitHub issues bidirectionally.

### Usage

```bash
# Set your GitHub token
export GITHUB_TOKEN=your_personal_access_token

# Run in dry run mode first (recommended)
npm run sync-issues:dry
# or
DRY_RUN=true node scripts/sync-github-issues.js

# Run with debugging output
npm run sync-issues:debug

# Run with both debugging and dry run
npm run sync-issues:debug-dry

# Sync in both directions (default)
npm run sync-issues
# or
node scripts/sync-github-issues.js

# Only create GitHub issues for local tasks
npm run sync-issues:local-to-github
# or
SYNC_DIRECTION=local-to-github node scripts/sync-github-issues.js

# Only create local tasks for GitHub issues
npm run sync-issues:github-to-local
# or
SYNC_DIRECTION=github-to-local node scripts/sync-github-issues.js
```

### What It Does

1. Fetches all GitHub issues for the repository
2. Extracts task data from `project-planning/task-viewer.html`
3. Identifies tasks that exist locally but not on GitHub
4. Identifies issues that exist on GitHub but not locally
5. Creates GitHub issues for local tasks (if SYNC_DIRECTION is 'both' or 'local-to-github')
6. Creates local tasks for GitHub issues (if SYNC_DIRECTION is 'both' or 'github-to-local')
7. Updates the task-viewer.html file with the synchronized data

## Delete Issues

The `delete-issues.js` script helps clean up GitHub issues by marking them as deprecated.

### Usage

```bash
# Set your GitHub token
export GITHUB_TOKEN=your_personal_access_token

# Run in dry run mode first (recommended)
npm run delete-issues:dry

# When ready, run for real
npm run delete-issues
```

### What It Does

1. Fetches all GitHub issues (both open and closed)
2. Ensures a "deprecated" label exists in the repository
3. For each issue:
   - Removes all existing labels except "deprecated"
   - Adds the "deprecated" label
   - Closes the issue (if it's open)
   - Adds a comment indicating the issue is deprecated

## Configuration for All Scripts

You can configure the scripts using environment variables:

- `GITHUB_TOKEN` (required): Your GitHub personal access token
- `GITHUB_OWNER` (optional, default: "yourdesigncoza"): Repository owner
- `GITHUB_REPO` (optional, default: "wecoza-3-child-theme"): Repository name
- `DRY_RUN` (optional, default: false): Set to "true" to run in dry run mode (no changes made)
- `DEBUG` (optional, default: false): Set to "true" for verbose debugging output
- `SYNC_DIRECTION` (optional, default: "both"): For sync-github-issues.js, controls sync direction ("both", "local-to-github", or "github-to-local")

## Troubleshooting

### Rate Limiting

GitHub API has rate limits. If you hit them, you'll see an error message. Wait a while before trying again.

### Authentication Errors

If you see authentication errors, check that:
1. Your token has the correct permissions (needs `repo` scope)
2. Your token is valid and not expired
3. You have access to the repository

### Testing with Dry Run

Always test first with dry run mode to see what would be done without making actual changes:

```bash
# Using npm scripts (recommended)
npm run create-issues:dry
npm run sync-issues:dry
npm run delete-issues:dry

# Or using environment variables
DRY_RUN=true node scripts/script-name.js
```
