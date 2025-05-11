# Revised Implementation Guide for WECOZA-DEV Workflow Improvements

Since you're already using the Linear MCP in your workflow, we can integrate our improvements directly with it rather than creating a separate sync mechanism. This guide has been adjusted accordingly.

## Step 1: Set Up the Directory Structure

First, create any necessary directories in your project:

```bash
# Create the tracking directory if it doesn't exist
mkdir -p wecoza-dev-flow/tracking
```

## Step 2: Add the Enhanced Task Template

1. Copy the "Enhanced WECOZA-DEV Task Template with TDD" content to a new file:

```bash
# Create template file
touch wecoza-dev-flow/templates/task-template.md
```

2. This will be your new standard template for creating detailed task specifications with TDD focus.

## Step 3: Create the TASK_LIST.md File

1. Create a task-list.md file in your tracking directory:

```bash
# Create task list file
touch wecoza-dev-flow/tracking/task-list.md
```

2. This file will serve as a codebase-integrated view of your tasks, reflecting the information from Linear.

## Step 4: Add the Status Workflow Guide

1. Create a status workflow document to standardize how you transition tasks:

```bash
# Create workflow guide file
touch wecoza-dev-flow/guides/status-workflow.md
```

2. This document will define the clear rules for when tasks should change status.

## Step 5: Linear MCP Integration

Instead of creating a separate sync script, we'll leverage your existing Linear MCP integration:

1. **Task Creation**: When creating new tasks in your WEC documents, use the Linear MCP to automatically create corresponding Linear tickets:

```
// Example command for your AI assistant using Linear MCP
Create a new Linear task for WEC-XX-1 with title "[Component Name]", status "Not Started", and implementation details from the task document.
```

2. **Status Updates**: When updating task status in TASK_LIST.md, use Linear MCP to update the corresponding Linear ticket:

```
// Example command for your AI assistant using Linear MCP
Update the status of Linear task WEC-XX-1 to "In Progress" with the note "Tests have been written, beginning implementation."
```

3. **Task Retrieval**: When starting work, use Linear MCP to retrieve current tasks and update TASK_LIST.md:

```
// Example command for your AI assistant using Linear MCP
Retrieve all active tasks for the current sprint and update wecoza-dev-flow/tracking/task-list.md with their status.
```

## Step 6: TDD Workflow Integration

To properly integrate TDD with your workflow:

1. Create a test checklist file following the naming convention `WEC-{issue-number}-test-checklist.md` in the tracking directory:

```markdown
# Test Checklist for [Feature]

## Unit Tests
- [ ] Test for [specific functionality 1]
- [ ] Test for [specific functionality 2]
- [ ] Edge case: [specific edge case]

## Integration Tests
- [ ] Test for [integration point 1]
- [ ] Test for [integration point 2]

## Acceptance Tests
- [ ] Verify [user story 1]
- [ ] Verify [user story 2]
```

2. These test checklists will guide your implementation and ensure TDD principles are followed.

## Step 7: Implementation Sequence Standardization

To standardize implementation sequencing:

1. Always include the "Implementation Sequence" section in your task documents
2. Reference the implementation sequence when starting work on a new component
3. Use specific numbering for tasks that reflects their sequence (e.g., WEC-50-1, WEC-50-2, etc.)
4. Use the Linear MCP to query for dependencies before starting a new task

## Step 8: Create AI Assistant Prompts

Create standard prompts for your AI assistant to help with your workflow:

1. **Start Task Prompt**:
```
I'm starting work on [Task ID]. Please:
1. Retrieve the current status from Linear
2. Update TASK_LIST.md with current information
3. Generate test cases based on the TDD section
4. Create a WEC-{issue-number}-test-checklist.md file for this feature
```

2. **Update Status Prompt**:
```
I've completed the implementation for [Task ID]. Please:
1. Update its status to [New Status] in TASK_LIST.md
2. Update the Linear ticket status
3. Add a comment with test results
4. Check if any dependent tasks can now be started
```

3. **Implementation Sequence Prompt**:
```
What's the next task I should work on based on the implementation sequence? Please check TASK_LIST.md and Linear for task dependencies and status.
```

## Step 9: Example Workflow

Here's how your workflow would look in practice:

1. **Create Task Document**:
   - Create a detailed task document using the enhanced template
   - Include TDD test criteria for each component
   - Define clear implementation sequence

2. **Initialize in Linear**:
   - Use Linear MCP to create tickets for all subtasks
   - Set initial status to "Not Started"
   - Add the implementation sequence to ticket descriptions

3. **Start Implementation**:
   - Use the "Start Task" prompt with your AI assistant
   - Begin by writing tests following TDD principles
   - Update status to "In Progress" in both TASK_LIST.md and Linear

4. **Complete Implementation**:
   - Ensure all tests pass
   - Use the "Update Status" prompt to change status to "Testing"
   - Complete any refactoring while maintaining passing tests

5. **Finalize Task**:
   - Verify all acceptance criteria
   - Update status to "Completed"
   - Move to next task in the implementation sequence

## Step 10: Share with Your Team

Create a quick reference guide that explains:

1. The enhanced task template structure
2. The TDD workflow integration
3. The status transition rules
4. How to use the Linear MCP with this workflow

This approach leverages your existing Linear MCP integration while adding structure through TDD integration, clear status workflows, and explicit implementation sequencing.
