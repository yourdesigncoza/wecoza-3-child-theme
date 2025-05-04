/**
 * WeCoza Task Manager
 * A modern web interface for managing GitHub issues
 */

// Global variables
let allIssues = [];
let categories = [];
let currentFilter = 'all';
let currentUser = ''; // Will be populated with the GitHub username

// DOM elements
const taskBoard = document.getElementById('task-board');
const summaryStats = document.getElementById('summary-stats');
const refreshBtn = document.getElementById('refresh-btn');
const filterOptions = document.querySelectorAll('.filter-option');
const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
const taskModalBody = document.getElementById('task-modal-body');
const openInGithubBtn = document.getElementById('open-in-github');

// Initialize the application
document.addEventListener('DOMContentLoaded', () => {
  initApp();

  // Event listeners
  refreshBtn.addEventListener('click', refreshData);

  filterOptions.forEach(option => {
    option.addEventListener('click', (e) => {
      e.preventDefault();
      currentFilter = e.target.dataset.filter;
      renderTaskBoard();

      // Update active filter in dropdown
      document.getElementById('filterDropdown').textContent = `Filter: ${formatFilterName(currentFilter)}`;
    });
  });
});

// Initialize the application
async function initApp() {
  try {
    // Load categories first
    await loadCategories();

    // Then load issues
    await loadIssues();

    // Render the task board
    renderTaskBoard();

    // Render summary statistics
    renderSummaryStats();
  } catch (error) {
    console.error('Error initializing app:', error);
    alert('Error loading data. Please check the console for details.');
  }
}

// Load categories from the data file
async function loadCategories() {
  try {
    const response = await fetch('../data/categories.json');
    if (!response.ok) {
      throw new Error(`Failed to load categories: ${response.status} ${response.statusText}`);
    }
    categories = await response.json();
  } catch (error) {
    console.error('Error loading categories:', error);
    // Use default categories if file not found
    categories = [
      { name: 'Ideas', emoji: '💡' },
      { name: 'Backlog', emoji: '📥' },
      { name: 'Todo', emoji: '📝' },
      { name: 'In Progress', emoji: '🚧' },
      { name: 'In Review', emoji: '🔍' },
      { name: 'Done', emoji: '✅' },
      { name: 'Cancelled', emoji: '❌' }
    ];
  }
}

// Load issues from the data file
async function loadIssues() {
  try {
    const response = await fetch('../data/github-issues.json');
    if (!response.ok) {
      throw new Error(`Failed to load issues: ${response.status} ${response.statusText}`);
    }
    allIssues = await response.json();

    // Try to determine current user from assignees
    if (allIssues.length > 0 && allIssues[0].assignees && allIssues[0].assignees.length > 0) {
      // Assume the most common assignee is the current user
      const assigneeCounts = {};
      allIssues.forEach(issue => {
        issue.assignees.forEach(assignee => {
          assigneeCounts[assignee.login] = (assigneeCounts[assignee.login] || 0) + 1;
        });
      });

      let maxCount = 0;
      Object.entries(assigneeCounts).forEach(([login, count]) => {
        if (count > maxCount) {
          currentUser = login;
          maxCount = count;
        }
      });
    }
  } catch (error) {
    console.error('Error loading issues:', error);
    allIssues = [];
  }
}

// Refresh data from the server
async function refreshData() {
  refreshBtn.disabled = true;
  refreshBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Refreshing...';

  try {
    // Check GitHub token status first
    const tokenResponse = await fetch('/api/rate-limit');
    const tokenData = await tokenResponse.json();

    if (!tokenData.authenticated) {
      const setToken = confirm(
        "No GitHub token found. Without a token, you'll be limited to 60 requests per hour.\n\n" +
        "To set a token:\n" +
        "1. Create a token at https://github.com/settings/tokens\n" +
        "2. Run: export GITHUB_TOKEN=your_token_here\n\n" +
        "Do you want to continue without a token?"
      );

      if (!setToken) {
        refreshBtn.disabled = false;
        refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Refresh';
        return;
      }
    }

    // Execute the fetch script
    const response = await fetch('/api/refresh-issues', { method: 'POST' });
    if (!response.ok) {
      throw new Error(`Failed to refresh data: ${response.status} ${response.statusText}`);
    }

    // Parse response but we don't need to use the result
    await response.json();

    // Reload the data
    await loadCategories();
    await loadIssues();

    // Re-render the UI
    renderTaskBoard();
    renderSummaryStats();

    // Show success message
    alert('Data refreshed successfully!');
  } catch (error) {
    console.error('Error refreshing data:', error);
    alert('Error refreshing data. Please check the console for details or run the fetch script manually.');
  } finally {
    refreshBtn.disabled = false;
    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Refresh';
  }
}

// Render the task board
function renderTaskBoard() {
  // Clear the task board
  taskBoard.innerHTML = '';

  // Filter issues based on current filter
  const filteredIssues = filterIssues(allIssues, currentFilter);

  // Create columns for each category
  categories.forEach(category => {
    const categoryIssues = filteredIssues.filter(issue => issue.category === category.name);

    // Create column element
    const column = document.createElement('div');
    column.className = `col-md-6 col-lg-4 col-xl mb-4 task-column column-${category.name.toLowerCase().replace(/\s+/g, '-')}`;

    // Create column header
    const header = document.createElement('div');
    header.className = 'column-header';
    header.innerHTML = `
      <span>${category.emoji} ${category.name}</span>
      <span class="badge">${categoryIssues.length}</span>
    `;

    // Create task list
    const taskList = document.createElement('div');
    taskList.className = 'task-list';

    // Add tasks to the list
    categoryIssues.forEach(issue => {
      const taskCard = createTaskCard(issue);
      taskList.appendChild(taskCard);
    });

    // Assemble column
    column.appendChild(header);
    column.appendChild(taskList);

    // Add column to board
    taskBoard.appendChild(column);
  });
}

// Create a task card element
function createTaskCard(issue) {
  const card = document.createElement('div');
  card.className = 'task-card';
  card.dataset.issueNumber = issue.number;

  // Determine if task has assignees
  const hasAssignees = issue.assignees && issue.assignees.length > 0;

  // Create card content
  card.innerHTML = `
    <div class="task-card-header">
      <span class="task-id">#${issue.number}</span>
      <span class="priority-badge priority-${issue.priority}">${issue.priority}</span>
    </div>
    <div class="task-title">${issue.title}</div>
    <div class="task-card-footer">
      <div>
        ${issue.subtasks.length > 0 ? `<span><i class="bi bi-check2-square"></i> ${issue.subtasks.filter(st => st.completed).length}/${issue.subtasks.length}</span>` : ''}
      </div>
      <div>
        ${hasAssignees ? `<span><i class="bi bi-person"></i> ${issue.assignees[0].login}</span>` : ''}
      </div>
    </div>
  `;

  // Add click event to open modal
  card.addEventListener('click', () => {
    showTaskDetails(issue);
  });

  return card;
}

// Show task details in modal
function showTaskDetails(issue) {
  // Format the creation date
  const createdDate = new Date(issue.createdAt).toLocaleDateString();
  const closedDate = issue.closedAt ? new Date(issue.closedAt).toLocaleDateString() : null;

  // Format assignees
  const assigneesList = issue.assignees && issue.assignees.length > 0
    ? issue.assignees.map(a => `<span class="badge bg-secondary">${a.login}</span>`).join(' ')
    : '<span class="text-muted">None</span>';

  // Format labels
  const labelsList = issue.labels && issue.labels.length > 0
    ? issue.labels.map(l => `<span class="badge" style="background-color: #${l.color}">${l.name}</span>`).join(' ')
    : '<span class="text-muted">None</span>';

  // Format subtasks
  const subtasksList = issue.subtasks && issue.subtasks.length > 0
    ? `<ul class="subtask-list mt-3">
        ${issue.subtasks.map(st => `
          <li class="subtask-item">
            <input type="checkbox" class="subtask-checkbox" ${st.completed ? 'checked' : ''} disabled>
            <span class="${st.completed ? 'subtask-completed' : ''}">${st.title}</span>
          </li>
        `).join('')}
      </ul>`
    : '';

  // Set modal content
  taskModalBody.innerHTML = `
    <div class="row">
      <div class="col-md-8">
        <h4>${issue.title}</h4>
        <div class="mb-3">
          <span class="badge priority-badge priority-${issue.priority}">${issue.priority}</span>
          <span class="badge bg-secondary">${issue.category}</span>
        </div>
        <div class="task-description mb-3">
          ${issue.body ? marked.parse(issue.body) : '<em>No description provided</em>'}
        </div>
        ${subtasksList}
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h6>Details</h6>
            <dl>
              <dt>Issue Number</dt>
              <dd>#${issue.number}</dd>

              <dt>Status</dt>
              <dd>${issue.category}</dd>

              <dt>Created</dt>
              <dd>${createdDate}</dd>

              ${closedDate ? `<dt>Closed</dt><dd>${closedDate}</dd>` : ''}

              <dt>Assignees</dt>
              <dd>${assigneesList}</dd>

              <dt>Labels</dt>
              <dd>${labelsList}</dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
  `;

  // Set GitHub URL
  openInGithubBtn.href = issue.url;

  // Show the modal
  taskModal.show();
}

// Render summary statistics
function renderSummaryStats() {
  // Clear the summary stats
  summaryStats.innerHTML = '';

  // Calculate statistics
  const totalIssues = allIssues.length;
  const openIssues = allIssues.filter(issue => !issue.completed).length;
  const completedIssues = allIssues.filter(issue => issue.completed && issue.category !== 'Cancelled').length;
  const cancelledIssues = allIssues.filter(issue => issue.category === 'Cancelled').length;
  const inProgressIssues = allIssues.filter(issue => issue.category === 'In Progress').length;
  const myIssues = allIssues.filter(issue =>
    issue.assignees &&
    issue.assignees.some(a => a.login === currentUser) &&
    !issue.completed
  ).length;

  // Create stat cards
  const stats = [
    { label: 'Total', value: totalIssues, color: 'var(--accent)' },
    { label: 'Open', value: openIssues, color: 'var(--todo-color)' },
    { label: 'In Progress', value: inProgressIssues, color: 'var(--in-progress-color)' },
    { label: 'Completed', value: completedIssues, color: 'var(--done-color)' },
    { label: 'Cancelled', value: cancelledIssues, color: 'var(--cancelled-color)' },
    { label: 'My Tasks', value: myIssues, color: 'var(--priority-high)' }
  ];

  // Add stat cards to the summary
  stats.forEach(stat => {
    const statCard = document.createElement('div');
    statCard.className = 'stat-card';
    statCard.style.backgroundColor = stat.color;
    statCard.innerHTML = `
      <div class="stat-value">${stat.value}</div>
      <div class="stat-label">${stat.label}</div>
    `;
    summaryStats.appendChild(statCard);
  });
}

// Filter issues based on the current filter
function filterIssues(issues, filter) {
  switch (filter) {
    case 'my-tasks':
      return issues.filter(issue =>
        issue.assignees &&
        issue.assignees.some(a => a.login === currentUser)
      );
    case 'unassigned':
      return issues.filter(issue =>
        !issue.assignees || issue.assignees.length === 0
      );
    case 'priority-urgent':
      return issues.filter(issue => issue.priority === 'Urgent');
    case 'priority-high':
      return issues.filter(issue => issue.priority === 'High');
    default:
      return issues;
  }
}

// Format filter name for display
function formatFilterName(filter) {
  switch (filter) {
    case 'all': return 'All Tasks';
    case 'my-tasks': return 'My Tasks';
    case 'unassigned': return 'Unassigned';
    case 'priority-urgent': return 'Priority: Urgent';
    case 'priority-high': return 'Priority: High';
    default: return filter.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
  }
}

// Add marked.js for Markdown rendering
document.addEventListener('DOMContentLoaded', () => {
  const script = document.createElement('script');
  script.src = 'https://cdn.jsdelivr.net/npm/marked/marked.min.js';
  document.head.appendChild(script);
});
