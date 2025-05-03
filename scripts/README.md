# WeCoza Scripts

This directory contains utility scripts for the WeCoza project.

## Import Tasks to GitHub

The `import-tasks-to-github.js` script imports tasks from the `task-viewer.html` file to GitHub Issues.

### Prerequisites

- Node.js installed
- GitHub Personal Access Token with `repo` scope

### Installation

```bash
npm install
```

### Usage

```bash
# Set your GitHub token
export GITHUB_TOKEN=your_personal_access_token

# Run in dry run mode first (recommended)
npm run import-tasks:dry

# Run with debugging output
npm run import-tasks:debug

# Run with both debugging and dry run
npm run import-tasks:debug-dry

# When ready, run for real
npm run import-tasks
```

You can also set environment variables manually:

```bash
# Set your GitHub token
export GITHUB_TOKEN=your_personal_access_token

# Run in dry run mode
export DRY_RUN=true
npm run import-tasks

# Run with debugging
export DEBUG=true
npm run import-tasks
```

### Configuration

You can configure the script using environment variables:

- `GITHUB_TOKEN` (required): Your GitHub personal access token
- `GITHUB_OWNER` (optional, default: "yourdesigncoza"): Repository owner
- `GITHUB_REPO` (optional, default: "wecoza-3-child-theme"): Repository name
- `DRY_RUN` (optional, default: false): Set to "true" to run in dry run mode (no issues created)
- `DEBUG` (optional, default: false): Set to "true" for verbose debugging output

### What It Does

1. Extracts task data from `project-planning/task-viewer.html`
2. Creates GitHub issues for each task
3. Formats subtasks, files, and comments as Markdown
4. Adds appropriate labels based on priority and status
5. Skips tasks that are already completed or cancelled

### Troubleshooting

#### Object Object in Comments

If you see `[object Object]` in your issue comments, it means the script encountered a JavaScript object in the comments that couldn't be properly stringified. Try running with `DEBUG=true` to see the raw comment data:

```bash
export DEBUG=true
npm run import-tasks
```

#### Rate Limiting

GitHub API has rate limits. If you hit them, you'll see an error message. Wait a while before trying again.

#### Authentication Errors

If you see authentication errors, check that:
1. Your token has the correct permissions (needs `repo` scope)
2. Your token is valid and not expired
3. You have access to the repository

#### Testing with Dry Run

Always test first with dry run mode to see what would be created:

```bash
export DRY_RUN=true
npm run import-tasks
```

#### Importing Specific Tasks

If you want to import only specific tasks, you can modify the script to filter by task ID, priority, or other criteria. Look for the `createGitHubIssues` function and add your filtering logic.
