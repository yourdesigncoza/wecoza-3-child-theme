/**
 * Task Manager for WeCoza 3 Child Theme
 *
 * This file contains task definitions for project management.
 */

interface Task {
  id: string;
  title: string;
  description: string;
  status: 'todo' | 'in-progress' | 'review' | 'done';
  priority: 'low' | 'medium' | 'high';
  assignee?: string;
  dueDate?: string;
  subtasks?: Subtask[];
  linearId?: string;
}

interface Subtask {
  id: string;
  title: string;
  description: string;
  status: 'todo' | 'in-progress' | 'done';
}

interface Project {
  id: string;
  name: string;
  description: string;
  tasks: Task[];
}

// WEC-75: Monthly Training Hours Visibility & Export
const monthlyTrainingHoursProject: Project = {
  id: 'wec-75',
  name: 'Monthly Training Hours Visibility & Export',
  description: 'Implement functionality to display and export monthly training hours for classes based on schedules, with filtering options and support for various export formats.',
  tasks: [
    {
      id: 'wec-75-1',
      title: 'Implement Monthly Hours Calculation Service',
      description: 'Create the MonthlyHoursCalculationService class that will calculate training hours based on class schedules, group by month, account for holidays and breaks, and implement caching for performance.',
      status: 'todo',
      priority: 'high',
      assignee: 'John',
      linearId: 'WEC-75-1',
      subtasks: [
        {
          id: 'wec-75-1-1',
          title: 'Create service class structure',
          description: 'Set up the basic class structure with method signatures and documentation',
          status: 'todo'
        },
        {
          id: 'wec-75-1-2',
          title: 'Implement core calculation logic',
          description: 'Implement the logic to calculate hours based on schedule data',
          status: 'todo'
        },
        {
          id: 'wec-75-1-3',
          title: 'Add holiday and break exclusion',
          description: 'Implement logic to exclude holidays and class breaks from calculations',
          status: 'todo'
        },
        {
          id: 'wec-75-1-4',
          title: 'Implement caching mechanism',
          description: 'Add transient caching for performance optimization',
          status: 'todo'
        },
        {
          id: 'wec-75-1-5',
          title: 'Write unit tests',
          description: 'Create unit tests for the calculation service',
          status: 'todo'
        }
      ]
    },
    {
      id: 'wec-75-2',
      title: 'Add Monthly Hours Display to Calendar UI',
      description: 'Create UI components to display monthly hours summary in the calendar view, including total hours for the current month and navigation to view different months.',
      status: 'todo',
      priority: 'medium',
      assignee: 'John',
      linearId: 'WEC-75-2',
      subtasks: [
        {
          id: 'wec-75-2-1',
          title: 'Create monthly hours summary component',
          description: 'Create the view file for displaying monthly hours summary',
          status: 'todo'
        },
        {
          id: 'wec-75-2-2',
          title: 'Implement month navigation',
          description: 'Add controls for navigating between months',
          status: 'todo'
        },
        {
          id: 'wec-75-2-3',
          title: 'Add JavaScript for dynamic updates',
          description: 'Implement client-side functionality for updating the display',
          status: 'todo'
        },
        {
          id: 'wec-75-2-4',
          title: 'Style the component',
          description: 'Add CSS styles following Bootstrap conventions',
          status: 'todo'
        },
        {
          id: 'wec-75-2-5',
          title: 'Integrate with calendar view',
          description: 'Add the component to the calendar view',
          status: 'todo'
        }
      ]
    },
    {
      id: 'wec-75-3',
      title: 'Create Monthly Hours Export Service',
      description: 'Implement the MonthlyHoursExportService to generate reports in different formats (PDF, CSV, Excel) with proper formatting and styling.',
      status: 'todo',
      priority: 'medium',
      assignee: 'John',
      linearId: 'WEC-75-3',
      subtasks: [
        {
          id: 'wec-75-3-1',
          title: 'Create export service structure',
          description: 'Set up the basic class structure with method signatures',
          status: 'todo'
        },
        {
          id: 'wec-75-3-2',
          title: 'Implement PDF export',
          description: 'Add functionality to export data to PDF format',
          status: 'todo'
        },
        {
          id: 'wec-75-3-3',
          title: 'Implement CSV export',
          description: 'Add functionality to export data to CSV format',
          status: 'todo'
        },
        {
          id: 'wec-75-3-4',
          title: 'Implement Excel export',
          description: 'Add functionality to export data to Excel format',
          status: 'todo'
        },
        {
          id: 'wec-75-3-5',
          title: 'Create report templates',
          description: 'Design templates for each export format',
          status: 'todo'
        }
      ]
    },
    {
      id: 'wec-75-4',
      title: 'Implement Export UI and AJAX Handlers',
      description: 'Create the export options modal with class selection interface, date range selection, and format options. Implement AJAX handlers for export requests.',
      status: 'todo',
      priority: 'medium',
      assignee: 'John',
      linearId: 'WEC-75-4',
      subtasks: [
        {
          id: 'wec-75-4-1',
          title: 'Create export options modal',
          description: 'Create the view file for the export options modal',
          status: 'todo'
        },
        {
          id: 'wec-75-4-2',
          title: 'Implement class selection interface',
          description: 'Add UI for selecting classes to include in the export',
          status: 'todo'
        },
        {
          id: 'wec-75-4-3',
          title: 'Add date range selection',
          description: 'Implement date range picker for filtering exports',
          status: 'todo'
        },
        {
          id: 'wec-75-4-4',
          title: 'Create AJAX endpoints',
          description: 'Implement server-side handlers for export requests',
          status: 'todo'
        },
        {
          id: 'wec-75-4-5',
          title: 'Add progress indicator',
          description: 'Implement progress indicator for export generation',
          status: 'todo'
        }
      ]
    },
    {
      id: 'wec-75-5',
      title: 'Database Optimization and Testing',
      description: 'Optimize database queries for hours calculation, implement caching strategy, and test the feature with various scenarios including classes with holidays, breaks, and spanning multiple months.',
      status: 'todo',
      priority: 'medium',
      assignee: 'John',
      linearId: 'WEC-75-5',
      subtasks: [
        {
          id: 'wec-75-5-1',
          title: 'Analyze query performance',
          description: 'Identify and optimize slow queries',
          status: 'todo'
        },
        {
          id: 'wec-75-5-2',
          title: 'Implement database indexes',
          description: 'Add indexes for frequently queried columns',
          status: 'todo'
        },
        {
          id: 'wec-75-5-3',
          title: 'Test with various scenarios',
          description: 'Test the feature with different class configurations',
          status: 'todo'
        },
        {
          id: 'wec-75-5-4',
          title: 'Performance testing',
          description: 'Test with large datasets to ensure performance',
          status: 'todo'
        },
        {
          id: 'wec-75-5-5',
          title: 'Documentation',
          description: 'Create documentation for the feature',
          status: 'todo'
        }
      ]
    }
  ]
};

// Export the projects
export const projects: Project[] = [
  monthlyTrainingHoursProject,
  // Add other projects here
];

// Helper function to get a task by ID
export function getTaskById(taskId: string): Task | undefined {
  for (const project of projects) {
    const task = project.tasks.find(t => t.id === taskId);
    if (task) {
      return task;
    }
  }
  return undefined;
}

// Helper function to update task status
export function updateTaskStatus(taskId: string, status: 'todo' | 'in-progress' | 'review' | 'done'): boolean {
  for (const project of projects) {
    const taskIndex = project.tasks.findIndex(t => t.id === taskId);
    if (taskIndex !== -1) {
      project.tasks[taskIndex].status = status;
      return true;
    }
  }
  return false;
}

// Helper function to get all tasks for a specific assignee
export function getTasksByAssignee(assignee: string): Task[] {
  const assigneeTasks: Task[] = [];
  for (const project of projects) {
    const tasks = project.tasks.filter(t => t.assignee === assignee);
    assigneeTasks.push(...tasks);
  }
  return assigneeTasks;
}

// Helper function to get tasks by status
export function getTasksByStatus(status: 'todo' | 'in-progress' | 'review' | 'done'): Task[] {
  const statusTasks: Task[] = [];
  for (const project of projects) {
    const tasks = project.tasks.filter(t => t.status === status);
    statusTasks.push(...tasks);
  }
  return statusTasks;
}

// Helper function to get all tasks for a specific project
export function getTasksByProject(projectId: string): Task[] {
  const project = projects.find(p => p.id === projectId);
  return project ? project.tasks : [];
}