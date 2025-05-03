# WeCoza GitHub Feedback Workflow

This document outlines the process for collecting, tracking, and implementing client feedback using GitHub.

## Overview

We use GitHub's built-in features to manage the feedback process:

1. **GitHub Issues** - Track individual tasks and feedback requests
2. **GitHub Projects** - Visualize workflow and task status
3. **Pull Requests** - Review and approve code changes
4. **GitHub Actions** - Automate notifications and processes

## Feedback Process

### For Developers

#### 1. Creating Tasks

All tasks are tracked as GitHub Issues. When creating a new task:

1. Use the appropriate issue template (Feature, Bug, etc.)
2. Include the WEC-XX ID in the title
3. Add relevant labels (priority, type)
4. Assign to the responsible developer

#### 2. Working on Tasks

1. Create a branch for the task: `feature/WEC-XX-short-description`
2. Make your changes
3. Commit regularly with descriptive messages
4. Reference the issue in commits: `WEC-XX: Add feature`

#### 3. Requesting Feedback

When a task is ready for review:

1. Open a Pull Request
2. Link it to the issue: `Closes #XX`
3. Add the `feedback-requested` label
4. Assign reviewers
5. Move the issue to "Feedback Requested" in the project board

### For Clients/Reviewers

#### 1. Providing Feedback

When feedback is requested:

1. You'll receive a notification
2. Review the changes in the Pull Request
3. Add comments directly on specific lines of code
4. Use the issue comments for general feedback
5. Check off items in the feedback checklist

#### 2. Approving Changes

Once satisfied with the changes:

1. Approve the Pull Request
2. Add a comment: "Approved for merge"
3. The developer will then merge the changes

## Setting Up Your Environment

### 1. GitHub Access

1. Accept the invitation to the repository
2. Set up two-factor authentication for security
3. Install the GitHub mobile app for notifications on the go

### 2. Notifications

Configure your notification preferences:

1. Go to [GitHub Notification Settings](https://github.com/settings/notifications)
2. Enable email notifications for:
   - Issues you're participating in
   - Pull Request reviews
   - Pull Request pushes

## Feedback Templates

### Issue Comments

When providing general feedback on an issue, use this format:

```
## Feedback

**Overall impression:** [Positive/Negative/Mixed]

**Specific points:**
- [Point 1]
- [Point 2]
- [Point 3]

**Questions:**
- [Question 1]
- [Question 2]

**Suggested changes:**
- [Suggestion 1]
- [Suggestion 2]
```

### Pull Request Reviews

When reviewing code, focus on:

1. Functionality - Does it work as expected?
2. User Experience - Is it intuitive and easy to use?
3. Code Quality - Is the code well-structured and maintainable?
4. Documentation - Is the code well-documented?

## GitHub Projects Board

Our project board has the following columns:

1. **Backlog** - Tasks that are planned but not started
2. **In Progress** - Tasks currently being worked on
3. **Ready for Review** - Tasks completed and ready for review
4. **Feedback Requested** - Tasks awaiting client feedback
5. **Done** - Tasks completed and approved

## Importing Existing Tasks

To import tasks from the task-viewer.html file:

1. Install Node.js if not already installed
2. Install dependencies:
   ```bash
   cd scripts
   npm install
   ```
3. Run the import script in dry run mode first:
   ```bash
   export GITHUB_TOKEN=your_token_here
   npm run import-tasks:dry
   ```
4. When you're ready to create the actual issues:
   ```bash
   npm run import-tasks
   ```

### Troubleshooting Task Import

If you encounter issues with the import process:

1. **Debug Mode**: Run with debugging enabled
   ```bash
   npm run import-tasks:debug-dry
   ```

2. **Object Object in Comments**: If you see `[object Object]` in comments, the script encountered a JavaScript object it couldn't properly format. Run with debug mode to see details.

3. **Rate Limiting**: GitHub API has rate limits. If you hit them, wait a while before trying again.

4. **Authentication Errors**: Ensure your token has the correct permissions (needs `repo` scope).

See `scripts/README.md` for more detailed information about the import script.

## Need Help?

If you have any questions about the feedback process, please contact:

- [Developer Name] - [Email] - For technical questions
- [Project Manager] - [Email] - For process questions
