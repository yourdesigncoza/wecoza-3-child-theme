<?php
/**
 * Linear Task Sync Script
 *
 * This script synchronizes the TASK_LIST.md file with Linear.app tasks.
 * It can be run manually or as part of a Git hook.
 *
 * Usage: php linear-sync.php [--direction=both|to-linear|from-linear]
 */

// Configuration
$config = [
    'api_key' => getenv('LINEAR_API_KEY'),
    'team_id' => getenv('LINEAR_TEAM_ID'),
    'task_list_path' => 'wecoza-dev-flow/tracking/task-list.md',
    'status_map' => [
        'Not Started' => 'todo',       // Update these to match your Linear status names
        'In Progress' => 'in_progress',
        'Testing' => 'in_review',
        'Completed' => 'done',
        'Blocked' => 'blocked'
    ],
    'reverse_status_map' => [
        'todo' => 'Not Started',
        'in_progress' => 'In Progress',
        'in_review' => 'Testing',
        'done' => 'Completed',
        'blocked' => 'Blocked'
    ]
];

// Parse command line arguments
$options = getopt('', ['direction::']);
$direction = $options['direction'] ?? 'both';

// Validate configuration
if (empty($config['api_key'])) {
    die("Error: LINEAR_API_KEY environment variable not set.\n");
}

if (empty($config['team_id'])) {
    die("Error: LINEAR_TEAM_ID environment variable not set.\n");
}

if (!file_exists($config['task_list_path'])) {
    die("Error: Task list file not found at {$config['task_list_path']}.\n");
}

/**
 * Parses the TASK_LIST.md file and extracts task information
 *
 * @param string $filePath Path to the TASK_LIST.md file
 * @return array Array of tasks with their details
 */
function parseTaskList($filePath) {
    $content = file_get_contents($filePath);
    $tasks = [];

    // Regular expression to match table rows
    preg_match_all('/\|\s*([^|]+)\s*\|\s*([^|]+)\s*\|\s*(\d+)\s*\|\s*([^|]+)\s*\|\s*([^|]+)\s*\|\s*([^|]+)\s*\|\s*([^|]+)\s*\|/', $content, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
        if (trim($match[1]) === 'Task ID') {
            continue; // Skip header row
        }

        $taskId = trim($match[1]);
        $tasks[$taskId] = [
            'description' => trim($match[2]),
            'implementation_order' => (int)trim($match[3]),
            'status' => trim($match[4]),
            'dependencies' => array_map('trim', explode(',', trim($match[5]))),
            'completion_date' => trim($match[6]) !== 'N/A' ? trim($match[6]) : null,
            'linear_url' => trim($match[7]),
        ];
    }

    return $tasks;
}

/**
 * Extracts Linear issue ID from Linear URL
 *
 * @param string $url Linear issue URL
 * @return string|null Linear issue ID or null if not found
 */
function extractLinearIssueId($url) {
    if (empty($url) || $url === 'https://linear.app/...') {
        return null;
    }

    // Extract the issue ID from the URL
    preg_match('/\/issue\/([^\/]+)/', $url, $matches);
    return $matches[1] ?? null;
}

/**
 * Updates the TASK_LIST.md file with the latest task information
 *
 * @param string $filePath Path to the TASK_LIST.md file
 * @param array $tasks Updated task information
 * @return bool True if successful, false otherwise
 */
function updateTaskList($filePath, $tasks) {
    $content = file_get_contents($filePath);

    // Rebuild the table section
    $tableStart = '## Task Table';
    $tableEnd = "\n\n## Current Sprint Focus";

    $tableHeader = "| Task ID | Description | Implementation Order | Status | Dependencies | Completion Date | Linear URL |\n";
    $tableSeparator = "|---------|-------------|----------------------|--------|--------------|-----------------|------------|\n";

    $tableRows = '';
    foreach ($tasks as $taskId => $task) {
        $dependencies = implode(', ', $task['dependencies']);
        $completionDate = $task['completion_date'] ?? 'N/A';
        $linearUrl = $task['linear_url'] ?? 'https://linear.app/...';

        $tableRows .= "| {$taskId} | {$task['description']} | {$task['implementation_order']} | {$task['status']} | {$dependencies} | {$completionDate} | {$linearUrl} |\n";
    }

    $newTable = $tableHeader . $tableSeparator . $tableRows;

    // Replace the old table with the new one
    $pattern = '/'. preg_quote($tableStart, '/') . '.*?' . preg_quote($tableEnd, '/') . '/s';
    $replacement = $tableStart . "\n" . $newTable . $tableEnd;
    $updatedContent = preg_replace($pattern, $replacement, $content);

    return file_put_contents($filePath, $updatedContent) !== false;
}

/**
 * Fetches tasks from Linear.app API
 *
 * @param string $apiKey Linear API key
 * @param string $teamId Linear team ID
 * @return array Array of Linear tasks
 */
function fetchLinearTasks($apiKey, $teamId) {
    $query = <<<'GRAPHQL'
    query Issues($teamId: String!) {
      issues(filter: { team: { id: { eq: $teamId } } }) {
        nodes {
          id
          identifier
          title
          state {
            name
          }
          description
          url
        }
      }
    }
    GRAPHQL;

    $variables = [
        'teamId' => $teamId
    ];

    $ch = curl_init('https://api.linear.app/graphql');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'query' => $query,
        'variables' => $variables
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: ' . $apiKey
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('Error fetching Linear tasks: ' . curl_error($ch) . "\n");
    }

    curl_close($ch);
    $data = json_decode($response, true);

    if (isset($data['errors'])) {
        die('GraphQL Error: ' . $data['errors'][0]['message'] . "\n");
    }

    return $data['data']['issues']['nodes'];
}

/**
 * Updates a Linear task's status
 *
 * @param string $apiKey Linear API key
 * @param string $issueId Linear issue ID
 * @param string $status New status name (from status_map)
 * @return bool True if successful, false otherwise
 */
function updateLinearTaskStatus($apiKey, $issueId, $status) {
    // First, we need to find the state ID for the given status name
    $query = <<<'GRAPHQL'
    query WorkflowStates($issueId: String!) {
      issue(id: $issueId) {
        team {
          states {
            nodes {
              id
              name
            }
          }
        }
      }
    }
    GRAPHQL;

    $variables = [
        'issueId' => $issueId
    ];

    $ch = curl_init('https://api.linear.app/graphql');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'query' => $query,
        'variables' => $variables
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: ' . $apiKey
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error fetching workflow states: ' . curl_error($ch) . "\n";
        return false;
    }

    curl_close($ch);
    $data = json_decode($response, true);

    if (isset($data['errors'])) {
        echo 'GraphQL Error: ' . $data['errors'][0]['message'] . "\n";
        return false;
    }

    $stateId = null;
    foreach ($data['data']['issue']['team']['states']['nodes'] as $state) {
        if (strtolower($state['name']) === strtolower($status)) {
            $stateId = $state['id'];
            break;
        }
    }

    if (!$stateId) {
        echo "Error: Could not find state '{$status}' for the team.\n";
        return false;
    }

    // Now update the issue with the state ID
    $mutation = <<<'GRAPHQL'
    mutation UpdateIssue($issueId: String!, $stateId: String!) {
      issueUpdate(id: $issueId, input: { stateId: $stateId }) {
        success
        issue {
          id
          state {
            name
          }
        }
      }
    }
    GRAPHQL;

    $variables = [
        'issueId' => $issueId,
        'stateId' => $stateId
    ];

    $ch = curl_init('https://api.linear.app/graphql');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'query' => $mutation,
        'variables' => $variables
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: ' . $apiKey
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error updating Linear task: ' . curl_error($ch) . "\n";
        return false;
    }

    curl_close($ch);
    $data = json_decode($response, true);

    if (isset($data['errors'])) {
        echo 'GraphQL Error: ' . $data['errors'][0]['message'] . "\n";
        return false;
    }

    return $data['data']['issueUpdate']['success'];
}

// Main execution
echo "Linear Task Sync Script\n";
echo "----------------------\n";

if ($direction === 'both' || $direction === 'from-linear') {
    echo "Fetching tasks from Linear...\n";
    $linearTasks = fetchLinearTasks($config['api_key'], $config['team_id']);
    echo "Found " . count($linearTasks) . " tasks in Linear.\n";

    echo "Parsing local task list...\n";
    $localTasks = parseTaskList($config['task_list_path']);
    echo "Found " . count($localTasks) . " tasks in local task list.\n";

    // Update local tasks with Linear information
    foreach ($localTasks as $taskId => &$task) {
        $linearId = extractLinearIssueId($task['linear_url']);

        if (!$linearId) {
            continue;
        }

        foreach ($linearTasks as $linearTask) {
            if ($linearTask['id'] === $linearId) {
                // Update status if different
                $linearStatus = $config['reverse_status_map'][strtolower($linearTask['state']['name'])] ?? $linearTask['state']['name'];

                if ($task['status'] !== $linearStatus) {
                    echo "Updating task {$taskId} status from '{$task['status']}' to '{$linearStatus}'.\n";
                    $task['status'] = $linearStatus;
                }

                // Update description if different
                if ($task['description'] !== $linearTask['title']) {
                    echo "Updating task {$taskId} description.\n";
                    $task['description'] = $linearTask['title'];
                }

                break;
            }
        }
    }

    echo "Updating local task list...\n";
    if (updateTaskList($config['task_list_path'], $localTasks)) {
        echo "Local task list updated successfully.\n";
    } else {
        echo "Error updating local task list.\n";
    }
}

if ($direction === 'both' || $direction === 'to-linear') {
    echo "Parsing local task list...\n";
    $localTasks = parseTaskList($config['task_list_path']);
    echo "Found " . count($localTasks) . " tasks in local task list.\n";

    echo "Updating Linear tasks...\n";
    $updatedCount = 0;

    foreach ($localTasks as $taskId => $task) {
        $linearId = extractLinearIssueId($task['linear_url']);

        if (!$linearId) {
            echo "Skipping task {$taskId} - no Linear ID found.\n";
            continue;
        }

        $linearStatus = $config['status_map'][trim($task['status'])] ?? null;

        if (!$linearStatus) {
            echo "Skipping task {$taskId} - unknown status '{$task['status']}'.\n";
            continue;
        }

        echo "Updating Linear task {$taskId} ({$linearId}) status to '{$linearStatus}'...\n";

        if (updateLinearTaskStatus($config['api_key'], $linearId, $linearStatus)) {
            echo "Task {$taskId} updated successfully.\n";
            $updatedCount++;
        } else {
            echo "Error updating task {$taskId}.\n";
        }
    }

    echo "Updated {$updatedCount} Linear tasks.\n";
}

echo "Sync completed.\n";
