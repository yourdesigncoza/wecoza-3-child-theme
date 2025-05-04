#!/usr/bin/env node

/**
 * This script synchronizes tasks between task-viewer.html and GitHub issues
 * It performs bidirectional synchronization to ensure both systems are up-to-date
 *
 * Synchronization Steps:
 * 1. Fetches latest issue IDs from GitHub
 * 2. Compares with local task IDs in task-viewer.html
 * 3. Updates discrepancies in both directions:
 *    - Creates GitHub issues for local tasks not yet on GitHub
 *    - Adds new GitHub issues to the local task-viewer.html file
 * 4. Avoids duplicate creation by checking existing tasks/issues
 *
 * Usage:
 * 1. Install dependencies: npm install @octokit/rest
 * 2. Set environment variables:
 *    - GITHUB_TOKEN: Your GitHub personal access token
 *    - GITHUB_OWNER: Repository owner (e.g., yourdesigncoza)
 *    - GITHUB_REPO: Repository name (e.g., wecoza-3-child-theme)
 *    - DRY_RUN: Set to 'true' to test without making changes
 *    - SYNC_DIRECTION: 'both' (default), 'local-to-github', or 'github-to-local'
 * 3. Run: node sync-github-issues.js
 *
 * How to Use the Script:
 *
 * 1. Basic Usage:
 *    export GITHUB_TOKEN=your_personal_access_token
 *    node scripts/sync-github-issues.js
 *
 * 2. Dry Run Mode (test without making changes):
 *    export GITHUB_TOKEN=your_personal_access_token
 *    DRY_RUN=true node scripts/sync-github-issues.js
 *
 * 3. Synchronization Direction:
 *    # Only create GitHub issues for local tasks
 *    export GITHUB_TOKEN=your_personal_access_token
 *    SYNC_DIRECTION=local-to-github node scripts/sync-github-issues.js
 *
 *    # Only create local tasks for GitHub issues
 *    export GITHUB_TOKEN=your_personal_access_token
 *    SYNC_DIRECTION=github-to-local node scripts/sync-github-issues.js
 */

const fs = require('fs');
const path = require('path');
const { Octokit } = require('@octokit/rest');

// Configuration
const GITHUB_TOKEN = process.env.GITHUB_TOKEN;
const GITHUB_OWNER = process.env.GITHUB_OWNER || 'yourdesigncoza';
const GITHUB_REPO = process.env.GITHUB_REPO || 'wecoza-3-child-theme';
const DRY_RUN = process.env.DRY_RUN === 'true' || false;
const DEBUG = process.env.DEBUG === 'true' || false;
const SYNC_DIRECTION = process.env.SYNC_DIRECTION || 'both'; // 'both', 'local-to-github', 'github-to-local'

// Initialize Octokit
const octokit = new Octokit({
  auth: GITHUB_TOKEN
});

// Read task data from task-viewer.html
function extractTaskData() {
  const taskViewerPath = path.join(__dirname, '..', 'project-planning', 'task-viewer.html');
  const taskViewerContent = fs.readFileSync(taskViewerPath, 'utf8');

  // Extract JSON data from the script tag
  const jsonMatch = taskViewerContent.match(/const data = (\{[\s\S]*?\});/);
  if (!jsonMatch) {
    console.error('Could not extract JSON data from task-viewer.html');
    process.exit(1);
  }

  try {
    // Parse the JSON data
    const jsonData = eval(`(${jsonMatch[1]})`);

    // Process the data to ensure all fields are properly formatted
    processTaskData(jsonData);

    // Collect all tasks from all categories
    const allTasks = [];
    const taskMap = {};

    for (const category of jsonData.categories) {
      for (const task of category.tasks) {
        // Add category name to task for reference
        task.categoryName = category.name;
        allTasks.push(task);

        // Add to task map for easy lookup
        taskMap[task.id] = task;
      }
    }

    return { jsonData, allTasks, taskMap };
  } catch (error) {
    console.error('Error parsing JSON data:', error);
    process.exit(1);
  }
}

// Process task data to ensure all fields are properly formatted
function processTaskData(data) {
  if (!data || !data.categories) return;

  for (const category of data.categories) {
    if (!category.tasks) continue;

    for (const task of category.tasks) {
      // Debug output
      if (DEBUG) {
        console.log(`Processing task ${task.id}: ${task.title}`);
      }

      // Ensure comments are strings
      if (task.comments) {
        task.comments = task.comments.map(comment => {
          if (typeof comment === 'string') return comment;
          if (typeof comment === 'object' && comment !== null) {
            try {
              return JSON.stringify(comment, null, 2);
            } catch (e) {
              return String(comment);
            }
          }
          return String(comment);
        });
      }

      // Ensure subtasks are properly formatted
      if (task.subtasks) {
        task.subtasks = task.subtasks.map(subtask => {
          if (typeof subtask === 'string') {
            return { id: 'Subtask', title: subtask, completed: false };
          }
          return subtask;
        });
      }

      // Ensure files are strings
      if (task.files) {
        task.files = task.files.map(file => String(file));
      }
    }
  }
}

// Fetch all GitHub issues
async function fetchGitHubIssues() {
  console.log('Fetching GitHub issues...');

  try {
    // Get all issues (both open and closed)
    const allIssues = [];
    let page = 1;
    let hasMoreIssues = true;

    while (hasMoreIssues) {
      const response = await octokit.issues.listForRepo({
        owner: GITHUB_OWNER,
        repo: GITHUB_REPO,
        state: 'all',
        per_page: 100,
        page: page
      });

      if (response.data.length === 0) {
        hasMoreIssues = false;
      } else {
        allIssues.push(...response.data);
        page++;
      }
    }

    console.log(`Fetched ${allIssues.length} GitHub issues`);

    // Filter out pull requests (they're also returned by the issues API)
    const issues = allIssues.filter(issue => !issue.pull_request);

    console.log(`Found ${issues.length} actual issues (excluding PRs)`);

    // Create a map of issue numbers to issues
    const issueMap = {};
    for (const issue of issues) {
      // Skip issues with the 'deprecated' label
      if (issue.labels.some(label => label.name === 'deprecated')) {
        console.log(`Skipping deprecated issue #${issue.number}: ${issue.title}`);
        continue;
      }

      issueMap[issue.number] = {
        number: issue.number,
        title: issue.title,
        body: issue.body,
        state: issue.state,
        labels: issue.labels.map(label => label.name),
        created_at: issue.created_at,
        updated_at: issue.updated_at,
        html_url: issue.html_url
      };
    }

    return { issues, issueMap };
  } catch (error) {
    console.error('Error fetching GitHub issues:', error.message);
    return { issues: [], issueMap: {} };
  }
}

// Get the highest GitHub issue number
async function getHighestIssueNumber() {
  try {
    const issues = await octokit.issues.listForRepo({
      owner: GITHUB_OWNER,
      repo: GITHUB_REPO,
      state: 'all',
      per_page: 1,
      sort: 'created',
      direction: 'desc'
    });

    return issues.data.length > 0 ? issues.data[0].number : 0;
  } catch (error) {
    console.error('Error getting highest issue number:', error.message);
    return 0;
  }
}

// Create GitHub issues for tasks that don't exist on GitHub
async function createGitHubIssues(tasksToCreate) {
  console.log(`Creating ${tasksToCreate.length} GitHub issues for local tasks`);

  const issueMap = {};

  for (const task of tasksToCreate) {
    console.log(`Processing task ${task.id}: ${task.title} (from ${task.categoryName})`);

    // Format subtasks as a checklist
    const subtasksMarkdown = task.subtasks && task.subtasks.length > 0 ?
      task.subtasks.map(subtask => `- [ ] ${subtask.id}: ${subtask.title}`).join('\n') : '';

    // Format files as a list
    const filesMarkdown = task.files && task.files.length > 0 ?
      '## Files\n' + task.files.map(file => `- \`${file}\``).join('\n') : '';

    // Format comments as a list
    const commentsMarkdown = task.comments && task.comments.length > 0 ?
      '## Comments\n' + task.comments.map(comment => `- ${comment}`).join('\n') : '';

    // Create issue body
    const body = `
## Original Task ID: ${task.id}
## Priority: ${task.priority || 'None'}
## Status: ${task.status || 'Backlog'}

${task.description}

${subtasksMarkdown ? '## Subtasks\n' + subtasksMarkdown : ''}
${filesMarkdown}
${commentsMarkdown}
    `.trim();

    try {
      if (DRY_RUN) {
        // In dry run mode, just log what would be created
        console.log(`[DRY RUN] Would create issue for task ${task.id}: ${task.title}`);
        if (DEBUG) {
          console.log(`[DRY RUN] Issue body would be:\n${body}`);
        }
      } else {
        // Format labels: priority gets "priority-" prefix, status remains as is
        const labels = [
          `priority-${(task.priority || 'none').toLowerCase()}`,
          (task.status || 'backlog').toLowerCase()
        ];

        // Create the issue
        const response = await octokit.issues.create({
          owner: GITHUB_OWNER,
          repo: GITHUB_REPO,
          title: `${task.title}`,
          body: body,
          labels: labels
        });

        // Store mapping between task ID and GitHub issue number
        issueMap[task.id] = response.data.number;
        console.log(`Created issue #${response.data.number} for task ${task.id}: ${response.data.html_url}`);
      }
    } catch (error) {
      console.error(`Error creating issue for ${task.id}:`, error.message);
    }

    // Add a small delay to avoid rate limiting
    await new Promise(resolve => setTimeout(resolve, 1000));
  }

  return issueMap;
}

// Create local tasks from GitHub issues that don't exist locally
function createLocalTasks(jsonData, issuesToCreate) {
  console.log(`Creating ${issuesToCreate.length} local tasks from GitHub issues`);

  const newTaskMap = {};

  for (const issue of issuesToCreate) {
    console.log(`Creating local task from issue #${issue.number}: ${issue.title}`);

    // Parse the issue body to extract information
    const priority = extractPriorityFromIssue(issue);
    const status = extractStatusFromIssue(issue);
    const description = extractDescriptionFromIssue(issue);
    const subtasks = extractSubtasksFromIssue(issue);
    const files = extractFilesFromIssue(issue);
    const comments = extractCommentsFromIssue(issue);

    // Create a new task object
    const newTask = {
      id: String(issue.number),
      title: issue.title,
      description: description,
      priority: priority,
      status: status,
      subtasks: subtasks,
      files: files,
      comments: comments
    };

    // Determine which category to add the task to
    let targetCategory = null;

    // Try to find a category matching the status
    for (const category of jsonData.categories) {
      if (category.name.toLowerCase() === status.toLowerCase()) {
        targetCategory = category;
        break;
      }
    }

    // If no matching category, use the first category (usually "Backlog")
    if (!targetCategory && jsonData.categories.length > 0) {
      targetCategory = jsonData.categories[0];
    }

    // Add the task to the category
    if (targetCategory) {
      if (!targetCategory.tasks) {
        targetCategory.tasks = [];
      }

      targetCategory.tasks.push(newTask);
      newTask.categoryName = targetCategory.name;

      if (!DRY_RUN) {
        console.log(`Added task for issue #${issue.number} to category "${targetCategory.name}"`);
      } else {
        console.log(`[DRY RUN] Would add task for issue #${issue.number} to category "${targetCategory.name}"`);
      }

      newTaskMap[issue.number] = newTask;
    } else {
      console.error(`Could not find a category to add issue #${issue.number} to`);
    }
  }

  return newTaskMap;
}

// Helper functions to extract information from GitHub issues
function extractPriorityFromIssue(issue) {
  // Try to extract from labels first
  const priorityLabel = issue.labels.find(label => label.startsWith('priority-'));
  if (priorityLabel) {
    return priorityLabel.replace('priority-', '').charAt(0).toUpperCase() + priorityLabel.replace('priority-', '').slice(1);
  }

  // Try to extract from body
  if (issue.body) {
    const priorityMatch = issue.body.match(/## Priority: (.*?)$/m);
    if (priorityMatch && priorityMatch[1]) {
      return priorityMatch[1].trim();
    }
  }

  return 'None';
}

function extractStatusFromIssue(issue) {
  // Try to extract from labels first (excluding priority labels)
  const statusLabel = issue.labels.find(label => !label.startsWith('priority-'));
  if (statusLabel) {
    return statusLabel.charAt(0).toUpperCase() + statusLabel.slice(1);
  }

  // Try to extract from body
  if (issue.body) {
    const statusMatch = issue.body.match(/## Status: (.*?)$/m);
    if (statusMatch && statusMatch[1]) {
      return statusMatch[1].trim();
    }
  }

  // Default to the issue state
  return issue.state === 'open' ? 'Backlog' : 'Done';
}

function extractDescriptionFromIssue(issue) {
  if (!issue.body) return '';

  // Try to extract the description (text between status and subtasks/files/comments)
  const lines = issue.body.split('\n');
  let description = '';
  let inDescription = false;

  for (const line of lines) {
    if (line.startsWith('## Status:')) {
      inDescription = true;
      continue;
    }

    if (inDescription && (line.startsWith('## Subtasks') || line.startsWith('## Files') || line.startsWith('## Comments'))) {
      inDescription = false;
      continue;
    }

    if (inDescription && !line.startsWith('##')) {
      description += line + '\n';
    }
  }

  return description.trim();
}

function extractSubtasksFromIssue(issue) {
  if (!issue.body) return [];

  const subtasks = [];
  const subtasksMatch = issue.body.match(/## Subtasks\n([\s\S]*?)(?=##|$)/);

  if (subtasksMatch && subtasksMatch[1]) {
    const subtaskLines = subtasksMatch[1].trim().split('\n');

    for (let i = 0; i < subtaskLines.length; i++) {
      const line = subtaskLines[i];
      const subtaskMatch = line.match(/- \[([ x])\] (.*?): (.*)/);

      if (subtaskMatch) {
        const completed = subtaskMatch[1] === 'x';
        const id = subtaskMatch[2].trim();
        const title = subtaskMatch[3].trim();

        subtasks.push({
          id: id,
          title: title,
          completed: completed
        });
      }
    }
  }

  return subtasks;
}

function extractFilesFromIssue(issue) {
  if (!issue.body) return [];

  const files = [];
  const filesMatch = issue.body.match(/## Files\n([\s\S]*?)(?=##|$)/);

  if (filesMatch && filesMatch[1]) {
    const fileLines = filesMatch[1].trim().split('\n');

    for (const line of fileLines) {
      const fileMatch = line.match(/- `(.*?)`/);

      if (fileMatch && fileMatch[1]) {
        files.push(fileMatch[1]);
      }
    }
  }

  return files;
}

function extractCommentsFromIssue(issue) {
  if (!issue.body) return [];

  const comments = [];
  const commentsMatch = issue.body.match(/## Comments\n([\s\S]*?)(?=##|$)/);

  if (commentsMatch && commentsMatch[1]) {
    const commentLines = commentsMatch[1].trim().split('\n');

    for (const line of commentLines) {
      if (line.startsWith('- ')) {
        comments.push(line.substring(2).trim());
      }
    }
  }

  return comments;
}

// Update task-viewer.html with GitHub issue numbers
function updateTaskViewer(jsonData, issueMap) {
  if (DRY_RUN) {
    console.log('[DRY RUN] Would update task-viewer.html with GitHub issue numbers');
    return;
  }

  console.log('Updating task-viewer.html with GitHub issue numbers');

  // Update tasks with GitHub issue numbers
  for (const category of jsonData.categories) {
    for (const task of category.tasks) {
      if (issueMap[task.id]) {
        // Store the GitHub issue number in the task
        task.id = String(issueMap[task.id]);
        console.log(`Updated task ID to ${task.id}`);

        // Update subtask IDs if they exist
        if (task.subtasks && task.subtasks.length > 0) {
          for (let i = 0; i < task.subtasks.length; i++) {
            const subtask = task.subtasks[i];
            subtask.id = `${task.id}-${i+1}`;
            console.log(`  Updated subtask ID to ${subtask.id}`);
          }
        }
      }
    }
  }

  // Write the updated JSON data back to task-viewer.html
  writeTaskDataToFile(jsonData);
}

// Update the TASK ID TRACKING section
function updateTaskIdTracking(highestIssueNumber) {
  if (DRY_RUN) {
    console.log(`[DRY RUN] Would update TASK ID TRACKING section with highest issue number: ${highestIssueNumber}`);
    return;
  }

  console.log(`Updating TASK ID TRACKING section with highest issue number: ${highestIssueNumber}`);

  const taskViewerPath = path.join(__dirname, '..', 'project-planning', 'task-viewer.html');
  let content = fs.readFileSync(taskViewerPath, 'utf8');

  // Replace the TASK ID TRACKING section
  content = content.replace(
    /<!--\s*TASK ID TRACKING[\s\S]*?-->/,
    `<!--
  TASK ID TRACKING
  Now using GitHub issue numbers instead of WEC-XX
  Last used GitHub issue number: #${highestIssueNumber}
  Next available GitHub issue number: #${highestIssueNumber + 1}

  IMPORTANT: Always create GitHub issues first to get issue numbers!
-->`
  );

  fs.writeFileSync(taskViewerPath, content, 'utf8');
  console.log('Updated TASK ID TRACKING section successfully');
}

// Write the updated JSON data back to task-viewer.html
function writeTaskDataToFile(jsonData) {
  if (DRY_RUN) {
    console.log('[DRY RUN] Would write updated JSON data to task-viewer.html');
    return;
  }

  const taskViewerPath = path.join(__dirname, '..', 'project-planning', 'task-viewer.html');
  let content = fs.readFileSync(taskViewerPath, 'utf8');

  // Replace the JSON data in the file
  content = content.replace(
    /const data = (\{[\s\S]*?\});/,
    `const data = ${JSON.stringify(jsonData, null, 2)};`
  );

  fs.writeFileSync(taskViewerPath, content, 'utf8');
  console.log('Updated task-viewer.html successfully');
}

// Main function
async function main() {
  console.log('WeCoza Task-GitHub Synchronization');
  console.log('=================================');

  // Check for required token
  if (!GITHUB_TOKEN) {
    console.error('Error: GITHUB_TOKEN environment variable is required');
    console.log('\nPlease set your GitHub token:');
    console.log('  export GITHUB_TOKEN=your_personal_access_token');
    process.exit(1);
  }

  // Show configuration
  console.log(`Configuration:`);
  console.log(`- Repository: ${GITHUB_OWNER}/${GITHUB_REPO}`);
  console.log(`- Sync direction: ${SYNC_DIRECTION}`);
  console.log(`- Dry run mode: ${DRY_RUN ? 'Enabled (no changes will be made)' : 'Disabled'}`);
  console.log(`- Debug mode: ${DEBUG ? 'Enabled' : 'Disabled'}`);
  console.log('');

  // Step 1: Fetch GitHub issues
  const { issueMap: githubIssueMap } = await fetchGitHubIssues();

  // Step 2: Extract local tasks
  console.log('Extracting task data from task-viewer.html...');
  const { jsonData, allTasks, taskMap } = extractTaskData();
  console.log(`Found ${allTasks.length} local tasks`);

  // Step 3: Identify tasks that need synchronization

  // Tasks that exist locally but not on GitHub
  const tasksToCreateOnGitHub = [];

  // GitHub issues that exist on GitHub but not locally
  const issuesToCreateLocally = [];

  // Check for local tasks not on GitHub
  if (SYNC_DIRECTION === 'both' || SYNC_DIRECTION === 'local-to-github') {
    for (const task of allTasks) {
      // If the task ID is numeric, it's already a GitHub issue number
      if (!isNaN(parseInt(task.id))) {
        const issueNumber = parseInt(task.id);

        // Check if this issue exists on GitHub
        if (!githubIssueMap[issueNumber]) {
          console.log(`Task ${task.id} exists locally but not on GitHub`);
          tasksToCreateOnGitHub.push(task);
        }
      } else {
        // This is a WEC-XX style ID, needs to be created on GitHub
        console.log(`Task ${task.id} has a WEC-XX style ID and needs to be created on GitHub`);
        tasksToCreateOnGitHub.push(task);
      }
    }

    console.log(`Found ${tasksToCreateOnGitHub.length} local tasks to create on GitHub`);
  }

  // Check for GitHub issues not in local tasks
  if (SYNC_DIRECTION === 'both' || SYNC_DIRECTION === 'github-to-local') {
    for (const issueNumber in githubIssueMap) {
      // Check if this issue exists locally
      if (!taskMap[issueNumber]) {
        console.log(`Issue #${issueNumber} exists on GitHub but not locally`);
        issuesToCreateLocally.push(githubIssueMap[issueNumber]);
      }
    }

    console.log(`Found ${issuesToCreateLocally.length} GitHub issues to create locally`);
  }

  // Confirm before proceeding
  if (!DRY_RUN && (tasksToCreateOnGitHub.length > 0 || issuesToCreateLocally.length > 0)) {
    console.log('WARNING: This will create actual GitHub issues and/or local tasks.');
    console.log('If you want to test first, run with DRY_RUN=true environment variable.\n');
    console.log('Proceeding in 3 seconds... (Press Ctrl+C to cancel)');
    await new Promise(resolve => setTimeout(resolve, 3000));
  }

  // Step 4: Perform synchronization

  // Create GitHub issues for local tasks
  let newIssueMap = {};
  if (tasksToCreateOnGitHub.length > 0) {
    newIssueMap = await createGitHubIssues(tasksToCreateOnGitHub);
  }

  // Create local tasks for GitHub issues
  let newTaskMap = {};
  if (issuesToCreateLocally.length > 0) {
    newTaskMap = createLocalTasks(jsonData, issuesToCreateLocally);
  }

  // Step 5: Update task-viewer.html
  if (Object.keys(newIssueMap).length > 0 || Object.keys(newTaskMap).length > 0) {
    // Update task IDs in task-viewer.html
    updateTaskViewer(jsonData, newIssueMap);

    // Get the highest issue number
    const highestIssueNumber = await getHighestIssueNumber();

    // Update the TASK ID TRACKING section
    updateTaskIdTracking(highestIssueNumber);
  }

  // Show completion message
  if (DRY_RUN) {
    console.log('\nDry run completed. No changes were made.');
    console.log('To make actual changes, run without DRY_RUN=true');
  } else {
    console.log('\nSynchronization completed successfully!');
    console.log(`Created ${Object.keys(newIssueMap).length} GitHub issues from local tasks`);
    console.log(`Created ${Object.keys(newTaskMap).length} local tasks from GitHub issues`);
  }
}

main().catch(error => {
  console.error('Error:', error);
  process.exit(1);
});
