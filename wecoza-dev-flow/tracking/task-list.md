# WECOZA-DEV Task List

This file serves as the central task management system for the project, synchronized with Linear and maintained alongside the codebase.

## Task Management Instructions

1. **Read the Task Table**: Use the table below to identify tasks, sub-tasks, their status, dependencies, and completion dates.

2. **Follow Test-Driven Development (TDD)**:
   - For each task, first write tests that define the expected behavior
   - Implement the code to make the tests pass
   - Refactor the code while ensuring tests continue to pass
   - No task should be marked as "Completed" until all associated tests are written and passing

3. **Status Workflow Rules**:
   - **Not Started**: Initial state for all tasks
   - **In Progress**: Set when tests are being written and implementation has begun
   - **Testing**: Set when implementation is complete and tests are being run/refined
   - **Completed**: Set ONLY when all tests pass, code is refactored, and documentation is updated
   - **Blocked**: Set when a task cannot proceed due to external dependencies

4. **Update Task Status**:
   - Update this file whenever task status changes
   - Run the sync script to update Linear status
   - Include completion date (YYYY-MM-DD) when marking as Completed

5. **Implementation Sequence**:
   - Follow the implementation sequence specified in task documentation
   - Do not start a task until all its dependencies are completed
   - Prioritize tasks in the specified order unless blocked

## Task Table
| Task ID | Description | Implementation Order | Status | Dependencies | Completion Date | Linear URL |
|---------|-------------|----------------------|--------|--------------|-----------------|------------|
| WEC-13-1 | Status Change UI | 1 | Not Started | None | N/A | https://linear.app/wecoza/issue/WEC-13/learner-status-tracking-system |
| WEC-13-2 | Status History Tracking | 2 | Not Started | WEC-13-1 | N/A | https://linear.app/wecoza/issue/WEC-13/learner-status-tracking-system |
| WEC-13-5 | Class Attendance Integration | 3 | Not Started | WEC-13-2 | N/A | https://linear.app/wecoza/issue/WEC-13/learner-status-tracking-system |
| WEC-13-3 | Status Change Notifications | 4 | Not Started | WEC-13-2 | N/A | https://linear.app/wecoza/issue/WEC-13/learner-status-tracking-system |
| WEC-13-6 | Status-Based Access Control | 5 | Not Started | WEC-13-2, WEC-13-5 | N/A | https://linear.app/wecoza/issue/WEC-13/learner-status-tracking-system |
| WEC-13-4 | Status Reporting | 6 | Not Started | WEC-13-2, WEC-13-3, WEC-13-5, WEC-13-6 | N/A | https://linear.app/wecoza/issue/WEC-13/learner-status-tracking-system |
| WEC-15-1 | Module Completion Tracking | 1 | Not Started | None | N/A | https://linear.app/wecoza/issue/WEC-15/automatic-level-progression |
| WEC-15-2 | Assessment Result Integration | 2 | Not Started | WEC-15-1 | N/A | https://linear.app/wecoza/issue/WEC-15/automatic-level-progression |
| WEC-15-3 | Progression Rules Engine | 3 | Not Started | WEC-15-1, WEC-15-2 | N/A | https://linear.app/wecoza/issue/WEC-15/automatic-level-progression |
| WEC-15-4 | Automatic Level Update | 4 | Not Started | WEC-15-3 | N/A | https://linear.app/wecoza/issue/WEC-15/automatic-level-progression |
| WEC-15-5 | Progression History Tracking | 5 | Not Started | WEC-15-4 | N/A | https://linear.app/wecoza/issue/WEC-15/automatic-level-progression |
| WEC-15-6 | Progression Reporting | 6 | Not Started | WEC-15-5 | N/A | https://linear.app/wecoza/issue/WEC-15/automatic-level-progression |


## Current Sprint Focus
- WEC-13-1: Status Change UI
- WEC-13-2: Status History Tracking
- WEC-15-1: Module Completion Tracking

## Blocked Tasks
| Task ID | Reason Blocked | Waiting On | Expected Unblock Date |
|---------|----------------|------------|----------------------|
| [Task ID] | [Reason] | [Dependency] | [Date] |
