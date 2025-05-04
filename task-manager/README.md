# WeCoza Task Manager

A modern, web-based task manager that integrates with GitHub Issues.

## Features

- View all GitHub issues organized by status
- Filter tasks by assignee, priority, and more
- View detailed task information including subtasks
- Refresh data directly from GitHub
- Responsive design that works on desktop and mobile

## Setup

### Prerequisites

- Node.js (v14 or later)
- A GitHub personal access token (for API access)
- A GitHub repository with issues

### Installation

1. Clone this repository
2. Install dependencies:

```bash
npm install express
```

### Initial Setup

1. Set your GitHub personal access token as an environment variable:

```bash
export GITHUB_TOKEN=your_personal_access_token
```

You can create a token at https://github.com/settings/tokens with the `repo` scope.

2. Fetch GitHub issues:

```bash
npm run fetch
```

This will create a `data` directory with the following files:
- `github-issues.json`: Contains all issues from your GitHub repository
- `categories.json`: Contains category definitions

### Running the Application

1. Start the server:

```bash
npm start
```

2. Open your browser and navigate to `http://localhost:3001`

## Usage

### Viewing Tasks

Tasks are organized into columns based on their status:
- Ideas
- Backlog
- Todo
- In Progress
- In Review
- Done
- Cancelled

Click on any task card to view detailed information.

### Filtering Tasks

Use the Filter dropdown to filter tasks by:
- All Tasks
- My Tasks (assigned to you)
- Unassigned
- Priority: Urgent
- Priority: High

### Refreshing Data

Click the "Refresh" button to fetch the latest data from GitHub.

## Customization

### Categories

You can customize the categories by editing the `categories.json` file. Each category has the following properties:

- `name`: Display name of the category
- `emoji`: Emoji to display next to the category name
- `githubLabels`: Array of GitHub label names that map to this category
- `githubState`: GitHub issue state (e.g., "open" or "closed")
- `excludeLabels`: Array of label names to exclude from this category

### Styling

The application uses Bootstrap 5 for styling. You can customize the appearance by editing the `styles.css` file.

## Troubleshooting

### Issues Not Showing Up

Make sure:
1. The GitHub CLI is authenticated (`gh auth status`)
2. You have run the fetch script (`node scripts/fetch-github-issues.js`)
3. Your issues have the correct labels or states

### Refresh Button Not Working

If the refresh button doesn't work:
1. Check the browser console for errors
2. Make sure the server is running
3. Try running the fetch script manually

## License

This project is licensed under the MIT License.
