#!/usr/bin/env node

/**
 * GitHub Issues Fetcher
 *
 * This script fetches issues from GitHub using the GitHub API and saves them
 * to a JSON file for use in a web-based task viewer.
 */

const fs = require('fs');
const path = require('path');
const https = require('https');

// Configuration
const OUTPUT_DIR = path.join(__dirname, '..', 'data');
const ISSUES_FILE = path.join(OUTPUT_DIR, 'github-issues.json');
const CATEGORIES_FILE = path.join(OUTPUT_DIR, 'categories.json');

// GitHub repository information
const REPO_OWNER = 'yourdesigncoza';
const REPO_NAME = 'wecoza-3-child-theme';

// Ensure output directory exists
if (!fs.existsSync(OUTPUT_DIR)) {
  fs.mkdirSync(OUTPUT_DIR, { recursive: true });
}

// Define categories and their mapping from GitHub labels/states
const categories = [
  { name: 'Ideas', emoji: '💡', githubLabels: ['idea', 'enhancement'] },
  { name: 'Backlog', emoji: '📥', githubLabels: ['backlog'] },
  { name: 'Todo', emoji: '📝', githubLabels: [] }, // Default for open issues
  { name: 'In Progress', emoji: '🚧', githubLabels: ['in progress', 'wip'] },
  { name: 'In Review', emoji: '🔍', githubLabels: ['in review', 'review'] },
  { name: 'Done', emoji: '✅', githubState: 'closed', excludeLabels: ['cancelled', 'wontfix'] },
  { name: 'Cancelled', emoji: '❌', githubState: 'closed', githubLabels: ['cancelled', 'wontfix'] }
];

// Save categories configuration
fs.writeFileSync(CATEGORIES_FILE, JSON.stringify(categories, null, 2));

console.log('Fetching issues from GitHub...');

// Function to make a GitHub API request
function fetchFromGitHub(endpoint, callback) {
  const options = {
    hostname: 'api.github.com',
    path: endpoint,
    method: 'GET',
    headers: {
      'User-Agent': 'WeCoza-Task-Manager',
      'Accept': 'application/vnd.github.v3+json'
    }
  };

  // Add authorization if token is provided
  const token = process.env.GITHUB_TOKEN;
  if (token) {
    options.headers['Authorization'] = `token ${token}`;
  }

  const req = https.request(options, (res) => {
    let data = '';

    res.on('data', (chunk) => {
      data += chunk;
    });

    res.on('end', () => {
      if (res.statusCode === 200) {
        try {
          const parsedData = JSON.parse(data);
          callback(null, parsedData);
        } catch (error) {
          callback(new Error(`Failed to parse GitHub API response: ${error.message}`));
        }
      } else {
        callback(new Error(`GitHub API returned status code ${res.statusCode}: ${data}`));
      }
    });
  });

  req.on('error', (error) => {
    callback(error);
  });

  req.end();
}

// Fetch all issues (both open and closed)
function fetchAllIssues(callback) {
  const issues = [];

  // Function to fetch a page of issues
  function fetchPage(state, page = 1) {
    const endpoint = `/repos/${REPO_OWNER}/${REPO_NAME}/issues?state=${state}&per_page=100&page=${page}`;

    fetchFromGitHub(endpoint, (error, data) => {
      if (error) {
        return callback(error);
      }

      // GitHub API returns pull requests as issues, so we need to filter them out
      const filteredData = data.filter(item => !item.pull_request);

      issues.push(...filteredData);

      // If we got a full page, there might be more
      if (filteredData.length === 100) {
        fetchPage(state, page + 1);
      } else if (state === 'open') {
        // If we've finished fetching open issues, fetch closed ones
        fetchPage('closed');
      } else {
        // We've fetched all issues
        callback(null, issues);
      }
    });
  }

  // Start by fetching open issues
  fetchPage('open');
}

// Main execution
fetchAllIssues((error, issues) => {
  if (error) {
    console.error('Error fetching issues:', error.message);
    process.exit(1);
  }

  console.log(`Fetched ${issues.length} issues from GitHub.`);

  // Process issues to add category information
  const processedIssues = issues.map(issue => {
    // Extract label names for easier processing
    const labelNames = issue.labels.map(label => label.name.toLowerCase());

    // Determine category
    let category = 'Todo'; // Default category

    if (issue.state === 'closed') {
      // Check if it's cancelled or done
      const isCancelled = labelNames.some(label =>
        ['cancelled', 'wontfix'].includes(label)
      );

      category = isCancelled ? 'Cancelled' : 'Done';
    } else {
      // For open issues, check labels
      for (const cat of categories) {
        if (cat.githubLabels && cat.githubLabels.length > 0) {
          if (labelNames.some(label => cat.githubLabels.includes(label))) {
            category = cat.name;
            break;
          }
        }
      }

      // Special case for In Progress - also check assignees
      if (category === 'Todo' && issue.assignees && issue.assignees.length > 0) {
        category = 'In Progress';
      }
    }

    // Extract subtasks from body if they exist
    const subtasks = [];
    if (issue.body) {
      const taskListRegex = /- \[([ x])\] (.+)$/gm;
      let match;
      while ((match = taskListRegex.exec(issue.body)) !== null) {
        subtasks.push({
          id: `${issue.number}-${subtasks.length + 1}`,
          title: match[2].trim(),
          completed: match[1] === 'x'
        });
      }
    }

    return {
      number: issue.number,
      title: issue.title,
      body: issue.body || '',
      state: issue.state,
      labels: issue.labels,
      assignees: issue.assignees || [],
      createdAt: issue.created_at,
      closedAt: issue.closed_at,
      url: issue.html_url,
      category,
      subtasks,
      completed: issue.state === 'closed',
      priority: getPriorityFromLabels(labelNames)
    };
  });

  // Save the processed issues
  fs.writeFileSync(ISSUES_FILE, JSON.stringify(processedIssues, null, 2));

  console.log(`Saved ${processedIssues.length} processed issues to ${ISSUES_FILE}`);
});

/**
 * Helper function to determine priority from labels
 */
function getPriorityFromLabels(labels) {
  if (labels.includes('priority:urgent') || labels.includes('urgent')) {
    return 'Urgent';
  } else if (labels.includes('priority:high') || labels.includes('high')) {
    return 'High';
  } else if (labels.includes('priority:medium') || labels.includes('medium')) {
    return 'Medium';
  } else if (labels.includes('priority:low') || labels.includes('low')) {
    return 'Low';
  }
  return 'None';
}
