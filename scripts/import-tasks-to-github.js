#!/usr/bin/env node

/**
 * This script imports tasks from task-viewer.html to GitHub Issues
 *
 * Usage:
 * 1. Install dependencies: npm install @octokit/rest
 * 2. Set environment variables:
 *    - GITHUB_TOKEN: Your GitHub personal access token
 *    - GITHUB_OWNER: Repository owner (e.g., yourdesigncoza)
 *    - GITHUB_REPO: Repository name (e.g., wecoza-3-child-theme)
 * 3. Run: node import-tasks-to-github.js
 */

const fs = require('fs');
const path = require('path');
const { Octokit } = require('@octokit/rest');

// Configuration
const GITHUB_TOKEN = process.env.GITHUB_TOKEN;
const GITHUB_OWNER = process.env.GITHUB_OWNER || 'yourdesigncoza';
const GITHUB_REPO = process.env.GITHUB_REPO || 'wecoza-3-child-theme';
const DEBUG = process.env.DEBUG === 'true' || false;
const DRY_RUN = process.env.DRY_RUN === 'true' || false;

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

    return jsonData;
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
        console.log(`Comments before processing:`, task.comments);
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

        // Debug output
        if (DEBUG) {
          console.log(`Comments after processing:`, task.comments);
        }
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

// Create GitHub issues from tasks
async function createGitHubIssues(taskData) {
  console.log(`Importing tasks to GitHub repository: ${GITHUB_OWNER}/${GITHUB_REPO}`);

  for (const category of taskData.categories) {
    console.log(`Processing category: ${category.name}`);

    for (const task of category.tasks) {
      // Skip tasks that are already completed or cancelled
      if (task.status === 'Done' || task.status === 'Cancelled') {
        console.log(`Skipping ${task.id}: ${task.title} (${task.status})`);
        continue;
      }

      console.log(`Creating issue for ${task.id}: ${task.title}`);

      // Format subtasks as a checklist
      const subtasksMarkdown = task.subtasks.map(subtask =>
        `- [ ] ${subtask.id}: ${subtask.title}`
      ).join('\n');

      // Format files as a list
      const filesMarkdown = task.files ?
        '## Files\n' + task.files.map(file => `- \`${file}\``).join('\n') : '';

      // Format comments as a list
      const commentsMarkdown = task.comments && task.comments.length > 0 ?
        '## Comments\n' + task.comments.map(comment => {
          // Handle different types of comments (string, object, etc.)
          if (typeof comment === 'object' && comment !== null) {
            try {
              // Try to format the object in a readable way
              if (Object.keys(comment).length === 0) {
                return `- Empty object`;
              }

              // Format each property of the object
              const formattedProps = Object.entries(comment).map(([key, value]) => {
                return `  - ${key}: ${value}`;
              }).join('\n');

              return `- Comment object:\n${formattedProps}`;
            } catch (e) {
              // Fallback to simple JSON stringify
              return `- ${JSON.stringify(comment)}`;
            }
          }
          return `- ${comment}`;
        }).join('\n') : '';

      // Create issue body
      const body = `
## Task ID: ${task.id}
## Priority: ${task.priority}
## Status: ${task.status}

${task.description}

${subtasksMarkdown ? '## Subtasks\n' + subtasksMarkdown : ''}
${filesMarkdown}
${commentsMarkdown}
      `.trim();

      try {
        if (DRY_RUN) {
          // In dry run mode, just log what would be created
          console.log(`[DRY RUN] Would create issue: ${task.id}: ${task.title}`);
          if (DEBUG) {
            console.log(`[DRY RUN] Issue body would be:\n${body}`);
            console.log(`[DRY RUN] Labels would be: priority-${task.priority.toLowerCase()}, ${task.status.toLowerCase()}`);
          }
        } else {
          // Create the issue
          // Format labels: priority gets "priority-" prefix, status remains as is
          const labels = [
            `priority-${task.priority.toLowerCase()}`,
            task.status.toLowerCase()
          ];

          const response = await octokit.issues.create({
            owner: GITHUB_OWNER,
            repo: GITHUB_REPO,
            title: `${task.id}: ${task.title}`,
            body: body,
            labels: labels
          });

          console.log(`Created issue #${response.data.number}: ${response.data.html_url}`);
        }
      } catch (error) {
        console.error(`Error creating issue for ${task.id}:`, error.message);
      }

      // Add a small delay to avoid rate limiting
      await new Promise(resolve => setTimeout(resolve, 1000));
    }
  }

  console.log('Import completed!');
}

// Main function
async function main() {
  console.log('WeCoza Task Import to GitHub');
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
  console.log(`- Debug mode: ${DEBUG ? 'Enabled' : 'Disabled'}`);
  console.log(`- Dry run mode: ${DRY_RUN ? 'Enabled (no issues will be created)' : 'Disabled'}`);
  console.log('');

  // Extract and process task data
  console.log('Extracting task data from task-viewer.html...');
  const taskData = extractTaskData();

  // Show summary of tasks
  let totalTasks = 0;
  let skippedTasks = 0;

  for (const category of taskData.categories) {
    for (const task of category.tasks) {
      totalTasks++;
      if (task.status === 'Done' || task.status === 'Cancelled') {
        skippedTasks++;
      }
    }
  }

  console.log(`Found ${totalTasks} total tasks (${skippedTasks} will be skipped as they are Done or Cancelled)`);
  console.log(`Will create ${totalTasks - skippedTasks} GitHub issues\n`);

  // Confirm before proceeding
  if (!DRY_RUN) {
    console.log('WARNING: This will create actual GitHub issues in your repository.');
    console.log('If you want to test first, run with DRY_RUN=true environment variable.\n');
    console.log('Proceeding in 3 seconds... (Press Ctrl+C to cancel)');
    await new Promise(resolve => setTimeout(resolve, 3000));
  }

  // Create GitHub issues
  await createGitHubIssues(taskData);

  // Show completion message
  if (DRY_RUN) {
    console.log('\nDry run completed. No issues were created.');
    console.log('To create actual issues, run without DRY_RUN=true');
  } else {
    console.log('\nImport completed successfully!');
  }
}

main().catch(error => {
  console.error('Error:', error);
  process.exit(1);
});
