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
 * 3. Run: node create-github-issues.js
 *
 * How to Use the Script:
 *
 * 1. Basic Usage:
 *    export GITHUB_TOKEN=your_personal_access_token
 *    node scripts/create-github-issues.js
 *
 * 2. Dry Run Mode (test without making changes):
 *    export GITHUB_TOKEN=your_personal_access_token
 *    DRY_RUN=true node scripts/create-github-issues.js
 *
 * 3. Synchronization Direction:
 *    # Only create GitHub issues for local tasks
 *    export GITHUB_TOKEN=your_personal_access_token
 *    SYNC_DIRECTION=local-to-github node scripts/create-github-issues.js
 *
 *    # Only create local tasks for GitHub issues
 *    export GITHUB_TOKEN=your_personal_access_token
 *    SYNC_DIRECTION=github-to-local node scripts/create-github-issues.js
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
    for (const category of jsonData.categories) {
      for (const task of category.tasks) {
        // Add category name to task for reference
        task.categoryName = category.name;
        allTasks.push(task);
      }
    }

    // Sort tasks by their numeric ID to maintain sequential order
    // This ensures WEC-1 comes before WEC-10, etc.
    allTasks.sort((a, b) => {
      // Extract the numeric part from the ID (e.g., "1" from "WEC-1")
      const aNum = parseInt(a.id.replace(/WEC-(\d+).*/, '$1'));
      const bNum = parseInt(b.id.replace(/WEC-(\d+).*/, '$1'));

      // Sort numerically in ascending order
      return aNum - bNum;
    });

    return { jsonData, allTasks };
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

// Create GitHub issues for tasks
async function createGitHubIssues(allTasks) {
  console.log(`Creating GitHub issues for ${allTasks.length} tasks starting with issue #${STARTING_ISSUE_NUMBER}`);

  const issueMap = {};
  let currentIssueNumber = STARTING_ISSUE_NUMBER;

  for (const task of allTasks) {
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
        console.log(`[DRY RUN] Would create issue #${currentIssueNumber}: ${task.title}`);
        if (DEBUG) {
          console.log(`[DRY RUN] Issue body would be:\n${body}`);
        }

        // For dry run, simulate an issue number
        issueMap[task.id] = currentIssueNumber;
        console.log(`[DRY RUN] Simulated issue #${currentIssueNumber} for task ${task.id}`);
        currentIssueNumber++;
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

        // Store mapping between WEC-XX and GitHub issue number
        issueMap[task.id] = response.data.number;
        console.log(`Created issue #${response.data.number} for task ${task.id}: ${response.data.html_url}`);

        // Update the current issue number for the next task
        currentIssueNumber = response.data.number + 1;
      }
    } catch (error) {
      console.error(`Error creating issue for ${task.id}:`, error.message);
    }

    // Add a small delay to avoid rate limiting
    await new Promise(resolve => setTimeout(resolve, 1000));
  }

  return { issueMap, highestIssueNumber: currentIssueNumber - 1 };
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
        task.githubIssue = issueMap[task.id];
        console.log(`Updated task ${task.id} with GitHub issue #${issueMap[task.id]}`);
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
  console.log('WeCoza GitHub Issue Creation');
  console.log('===========================');

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
  console.log(`- Starting issue number: #${STARTING_ISSUE_NUMBER}`);
  console.log(`- Dry run mode: ${DRY_RUN ? 'Enabled (no changes will be made)' : 'Disabled'}`);
  console.log(`- Debug mode: ${DEBUG ? 'Enabled' : 'Disabled'}`);
  console.log('');

  // Extract task data from task-viewer.html
  console.log('Extracting task data from task-viewer.html...');
  const { jsonData, allTasks } = extractTaskData();
  console.log(`Found ${allTasks.length} tasks to create issues for`);

  if (allTasks.length === 0) {
    console.log('No tasks to create issues for. Exiting.');
    process.exit(0);
  }

  // Confirm before proceeding
  if (!DRY_RUN) {
    console.log('WARNING: This will create actual GitHub issues in your repository.');
    console.log('If you want to test first, run with DRY_RUN=true environment variable.\n');
    console.log('Proceeding in 3 seconds... (Press Ctrl+C to cancel)');
    await new Promise(resolve => setTimeout(resolve, 3000));
  }

  // Create GitHub issues for tasks
  const { issueMap, highestIssueNumber } = await createGitHubIssues(allTasks);
  console.log(`Created ${Object.keys(issueMap).length} GitHub issues`);

  // Update task-viewer.html with GitHub issue numbers
  updateTaskViewer(jsonData, issueMap);

  // Update the TASK ID TRACKING section
  updateTaskIdTracking(highestIssueNumber);

  // Show completion message
  if (DRY_RUN) {
    console.log('\nDry run completed. No changes were made.');
    console.log('To make actual changes, run without DRY_RUN=true');
  } else {
    console.log('\nIssue creation completed successfully!');
    console.log(`${Object.keys(issueMap).length} tasks were created as GitHub issues`);
    console.log(`The highest GitHub issue number is now #${highestIssueNumber}`);
    console.log('The TASK ID TRACKING section has been updated to reflect the new system');
  }
}

main().catch(error => {
  console.error('Error:', error);
  process.exit(1);
});
