#!/usr/bin/env node

const { Octokit } = require('@octokit/rest');

// Configuration
const GITHUB_TOKEN = process.env.GITHUB_TOKEN;
const GITHUB_OWNER = process.env.GITHUB_OWNER || 'yourdesigncoza';
const GITHUB_REPO = process.env.GITHUB_REPO || 'wecoza-3-child-theme';
const DRY_RUN = process.env.DRY_RUN === 'true' || false;

// Initialize Octokit
const octokit = new Octokit({
  auth: GITHUB_TOKEN
});

async function deleteAllIssues() {
  console.log(`${DRY_RUN ? '[DRY RUN] Would delete' : 'Deleting'} all issues from ${GITHUB_OWNER}/${GITHUB_REPO}...`);

  try {
    // Get all issues (both open and closed)
    const issues = await octokit.issues.listForRepo({
      owner: GITHUB_OWNER,
      repo: GITHUB_REPO,
      state: 'all',
      per_page: 100
    });

    const openIssues = issues.data.filter(issue => issue.state === 'open');
    const closedIssues = issues.data.filter(issue => issue.state === 'closed');

    console.log(`Found ${issues.data.length} total issues (${openIssues.length} open, ${closedIssues.length} closed).`);

    // Make sure the deprecated label exists
    try {
      console.log('Ensuring "deprecated" label exists...');
      if (!DRY_RUN) {
        try {
          await octokit.issues.getLabel({
            owner: GITHUB_OWNER,
            repo: GITHUB_REPO,
            name: 'deprecated'
          });
          console.log('Label "deprecated" already exists.');
        } catch (error) {
          if (error.status === 404) {
            await octokit.issues.createLabel({
              owner: GITHUB_OWNER,
              repo: GITHUB_REPO,
              name: 'deprecated',
              color: 'cccccc',
              description: 'Deprecated issue that should be ignored'
            });
            console.log('Created "deprecated" label.');
          } else {
            throw error;
          }
        }
      }
    } catch (error) {
      console.error('Error managing labels:', error.message);
    }

    // Process open issues first
    if (openIssues.length > 0) {
      console.log('\nProcessing open issues:');
      for (const issue of openIssues) {
        console.log(`${DRY_RUN ? '[DRY RUN] Would process' : 'Processing'} issue #${issue.number}: ${issue.title}`);

        if (!DRY_RUN) {
          // Remove all existing labels except "deprecated"
          if (issue.labels && issue.labels.length > 0) {
            const labelsToRemove = issue.labels
              .filter(label => label.name !== 'deprecated')
              .map(label => label.name);

            for (const labelName of labelsToRemove) {
              try {
                console.log(`Removing label "${labelName}" from issue #${issue.number}`);
                await octokit.issues.removeLabel({
                  owner: GITHUB_OWNER,
                  repo: GITHUB_REPO,
                  issue_number: issue.number,
                  name: labelName
                });
              } catch (error) {
                console.error(`Error removing label "${labelName}" from issue #${issue.number}:`, error.message);
              }

              // Add a small delay to avoid rate limiting
              await new Promise(resolve => setTimeout(resolve, 500));
            }
          }

          // Add the deprecated label
          try {
            console.log(`Adding "deprecated" label to issue #${issue.number}`);
            await octokit.issues.addLabels({
              owner: GITHUB_OWNER,
              repo: GITHUB_REPO,
              issue_number: issue.number,
              labels: ['deprecated']
            });
          } catch (error) {
            console.error(`Error adding "deprecated" label to issue #${issue.number}:`, error.message);
          }

          // Close the issue
          console.log(`Closing issue #${issue.number}`);
          await octokit.issues.update({
            owner: GITHUB_OWNER,
            repo: GITHUB_REPO,
            issue_number: issue.number,
            state: 'closed'
          });

          // Add a comment to indicate the issue is deprecated
          await octokit.issues.createComment({
            owner: GITHUB_OWNER,
            repo: GITHUB_REPO,
            issue_number: issue.number,
            body: '⚠️ This issue has been deprecated and should be ignored. It was closed as part of a bulk cleanup operation.'
          });

          console.log(`Issue #${issue.number} processed successfully.`);

          // Add a small delay to avoid rate limiting
          await new Promise(resolve => setTimeout(resolve, 1000));
        }
      }
    }

    // Process already closed issues
    if (closedIssues.length > 0) {
      console.log('\nProcessing closed issues:');
      for (const issue of closedIssues) {
        console.log(`${DRY_RUN ? '[DRY RUN] Would process' : 'Processing'} closed issue #${issue.number}: ${issue.title}`);

        if (!DRY_RUN) {
          // Remove all existing labels except "deprecated"
          if (issue.labels && issue.labels.length > 0) {
            const labelsToRemove = issue.labels
              .filter(label => label.name !== 'deprecated')
              .map(label => label.name);

            for (const labelName of labelsToRemove) {
              try {
                console.log(`Removing label "${labelName}" from issue #${issue.number}`);
                await octokit.issues.removeLabel({
                  owner: GITHUB_OWNER,
                  repo: GITHUB_REPO,
                  issue_number: issue.number,
                  name: labelName
                });
              } catch (error) {
                console.error(`Error removing label "${labelName}" from issue #${issue.number}:`, error.message);
              }

              // Add a small delay to avoid rate limiting
              await new Promise(resolve => setTimeout(resolve, 500));
            }
          }

          // Add the deprecated label
          try {
            console.log(`Adding "deprecated" label to issue #${issue.number}`);
            await octokit.issues.addLabels({
              owner: GITHUB_OWNER,
              repo: GITHUB_REPO,
              issue_number: issue.number,
              labels: ['deprecated']
            });
          } catch (error) {
            console.error(`Error adding "deprecated" label to issue #${issue.number}:`, error.message);
          }

          // Add a comment to indicate the issue is deprecated
          await octokit.issues.createComment({
            owner: GITHUB_OWNER,
            repo: GITHUB_REPO,
            issue_number: issue.number,
            body: '⚠️ This issue has been deprecated and should be ignored. It was closed as part of a bulk cleanup operation.'
          });

          console.log(`Issue #${issue.number} processed successfully.`);

          // Add a small delay to avoid rate limiting
          await new Promise(resolve => setTimeout(resolve, 1000));
        }
      }
    }

    console.log(`\n${DRY_RUN ? '[DRY RUN] All issues would have been processed' : 'All issues have been processed successfully'}!`);

    if (!DRY_RUN) {
      console.log('\nNote: GitHub does not allow true deletion of issues. The issues have been:');
      console.log('1. Closed (for open issues)');
      console.log('2. All labels except "deprecated" have been removed');
      console.log('3. Labeled as "deprecated"');
      console.log('4. Commented on to indicate they should be ignored');
    }
  } catch (error) {
    console.error('Error:', error.message);
  }
}

// Main function
async function main() {
  console.log('GitHub Issue Cleanup Tool');
  console.log('========================');

  if (!GITHUB_TOKEN) {
    console.error('Error: GITHUB_TOKEN environment variable is required');
    console.log('\nPlease set your GitHub token:');
    console.log('  export GITHUB_TOKEN=your_personal_access_token');
    process.exit(1);
  }

  // Show configuration
  console.log(`Configuration:`);
  console.log(`- Repository: ${GITHUB_OWNER}/${GITHUB_REPO}`);
  console.log(`- Dry run mode: ${DRY_RUN ? 'Enabled (no changes will be made)' : 'Disabled'}`);
  console.log('');

  if (!DRY_RUN) {
    console.log('WARNING: This will process ALL issues in the repository:');
    console.log('- Open issues will be closed');
    console.log('- All labels except "deprecated" will be removed from all issues');
    console.log('- All issues will be labeled as "deprecated"');
    console.log('- All issues will be commented on to indicate they are deprecated');
    console.log('\nIf you want to test first, run with DRY_RUN=true environment variable.');
    console.log('Press Ctrl+C within 5 seconds to cancel...');

    // Wait for 5 seconds before proceeding
    await new Promise(resolve => setTimeout(resolve, 5000));
  }

  await deleteAllIssues();
}

main().catch(error => {
  console.error('Error:', error);
  process.exit(1);
});
