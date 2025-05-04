#!/usr/bin/env node

/**
 * Simple HTTP server for the Task Manager
 *
 * This script serves the task manager web app and provides an API endpoint
 * to refresh GitHub issues data.
 */

const express = require('express');
const { exec } = require('child_process');
const path = require('path');
const fs = require('fs');

const app = express();
const PORT = process.env.PORT || 3001; // Changed to 3001 to avoid conflicts

// Serve static files from task-manager directory
app.use(express.static(path.join(__dirname, '..', 'task-manager')));

// Serve data files
app.use('/data', express.static(path.join(__dirname, '..', 'data')));

// API endpoint to refresh issues
app.post('/api/refresh-issues', (req, res) => {
  console.log('Refreshing GitHub issues...');

  // Create a command that includes the GitHub token if available
  const githubToken = process.env.GITHUB_TOKEN || '';
  const command = githubToken
    ? `GITHUB_TOKEN=${githubToken} node scripts/fetch-github-issues.js`
    : 'node scripts/fetch-github-issues.js';

  exec(command, (error, stdout, stderr) => {
    if (error) {
      console.error(`Error: ${error.message}`);
      return res.status(500).json({ error: error.message });
    }

    if (stderr) {
      console.error(`stderr: ${stderr}`);
      return res.status(500).json({ error: stderr });
    }

    console.log(`stdout: ${stdout}`);
    res.json({ success: true, message: 'GitHub issues refreshed successfully' });
  });
});

// API endpoint to get GitHub rate limit info
app.get('/api/rate-limit', (req, res) => {
  const githubToken = process.env.GITHUB_TOKEN || '';

  // If no token, just return a message
  if (!githubToken) {
    return res.json({
      message: 'No GitHub token provided. API requests may be rate limited.',
      authenticated: false
    });
  }

  // Check GitHub rate limit
  const command = `curl -s -H "Authorization: token ${githubToken}" https://api.github.com/rate_limit`;

  exec(command, (error, stdout, stderr) => {
    if (error) {
      console.error(`Error: ${error.message}`);
      return res.status(500).json({ error: error.message });
    }

    try {
      const data = JSON.parse(stdout);
      res.json({
        authenticated: true,
        rateLimit: data.rate,
        message: `Rate limit: ${data.rate.remaining}/${data.rate.limit} requests remaining. Resets at ${new Date(data.rate.reset * 1000).toLocaleString()}`
      });
    } catch (e) {
      res.status(500).json({ error: 'Failed to parse GitHub API response' });
    }
  });
});

// Create data directory if it doesn't exist
const dataDir = path.join(__dirname, '..', 'data');
if (!fs.existsSync(dataDir)) {
  fs.mkdirSync(dataDir, { recursive: true });
}

// Create sample data if it doesn't exist
const issuesFile = path.join(dataDir, 'github-issues.json');
if (!fs.existsSync(issuesFile)) {
  // Create a sample issues file with instructions
  const sampleData = [
    {
      number: 0,
      title: "Sample Issue - No GitHub Data Yet",
      body: "This is a sample issue. To see your actual GitHub issues, you need to run the fetch script.\n\n1. Set your GitHub token: `export GITHUB_TOKEN=your_token_here`\n2. Run: `npm run fetch`\n\nOr click the Refresh button in the UI.",
      state: "open",
      labels: [{ name: "sample", color: "0075ca" }],
      assignees: [],
      createdAt: new Date().toISOString(),
      closedAt: null,
      url: "https://github.com/settings/tokens",
      category: "Todo",
      subtasks: [],
      completed: false,
      priority: "None"
    }
  ];

  fs.writeFileSync(issuesFile, JSON.stringify(sampleData, null, 2));
  console.log('Created sample issues file');
}

// Create categories file if it doesn't exist
const categoriesFile = path.join(dataDir, 'categories.json');
if (!fs.existsSync(categoriesFile)) {
  const categories = [
    { name: 'Ideas', emoji: '💡', githubLabels: ['idea', 'enhancement'] },
    { name: 'Backlog', emoji: '📥', githubLabels: ['backlog'] },
    { name: 'Todo', emoji: '📝', githubLabels: [] },
    { name: 'In Progress', emoji: '🚧', githubLabels: ['in progress', 'wip'] },
    { name: 'In Review', emoji: '🔍', githubLabels: ['in review', 'review'] },
    { name: 'Done', emoji: '✅', githubState: 'closed', excludeLabels: ['cancelled', 'wontfix'] },
    { name: 'Cancelled', emoji: '❌', githubState: 'closed', githubLabels: ['cancelled', 'wontfix'] }
  ];

  fs.writeFileSync(categoriesFile, JSON.stringify(categories, null, 2));
  console.log('Created categories file');
}

// Start the server
app.listen(PORT, () => {
  console.log(`Task Manager server running at http://localhost:${PORT}`);
  console.log(`Open your browser and navigate to http://localhost:${PORT}`);
  console.log('\nTo fetch GitHub issues:');
  console.log('1. Set your GitHub token: export GITHUB_TOKEN=your_token_here');
  console.log('2. Run: npm run fetch');
  console.log('   or click the Refresh button in the UI');
});
