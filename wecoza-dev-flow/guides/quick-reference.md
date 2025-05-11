# WECOZA-DEV Workflow Quick Reference

This guide provides a quick reference for the WECOZA-DEV enhanced workflow incorporating TDD, sequenced implementation, and status tracking.

## Creating a New Task

1. **Use the Enhanced Template**
   - Copy the template from `docs/TASK_TEMPLATE.md`
   - Fill in all sections, including TDD test criteria for each subtask
   - Define clear implementation sequence with numbered steps and dependencies

2. **Create Linear Tasks**
   - Use Linear MCP to create tickets for each subtask
   - Include implementation sequence in ticket descriptions
   - Link subtasks with dependencies in Linear

3. **Add to TASK_LIST.md**
   - Add all subtasks to the task table
   - Set initial status to "Not Started"
   - Document dependencies clearly

4. **Create Test Checklist**
   - Create a `.test-checklist.md` file for the feature
   - Break down tests by component
   - Include unit, integration, and acceptance tests

## Task Implementation Workflow

### Step 1: Begin Task (Not Started → In Progress)
- Verify all dependencies are completed
- Create and document test cases first (TDD)
- Update status in TASK_LIST.md to "In Progress"
- Update Linear ticket status using Linear MCP

### Step 2: Implementation (In Progress)
- Write minimal code to make tests pass
- Follow the implementation details in task document
- Document any challenges or design decisions
- Commit code with meaningful messages

### Step 3: Review and Refine (In Progress → Testing)
- Ensure all tests pass
- Refactor code for optimization
- Add edge case tests
- Update status in TASK_LIST.md to "Testing"
- Update Linear ticket status using Linear MCP

### Step 4: Finalize (Testing → Completed)
- Conduct final review of implementation
- Verify all items in test checklist
- Complete documentation
- Update status in TASK_LIST.md to "Completed"
- Add completion date in YYYY-MM-DD format
- Update Linear ticket status using Linear MCP

## Status Definitions

- **Not Started**: Initial state, awaiting start
- **In Progress**: Tests written, active development
- **Testing**: Implementation complete, verifying with tests
- **Completed**: All tests pass, documentation complete
- **Blocked**: Cannot proceed due to dependencies (document reason)

## Implementation Sequence

Always follow the numbered implementation sequence defined in the task document:

1. Each major component is assigned a sequence number
2. Do not start work on a component until all its dependencies are completed
3. Document the rationale for the chosen sequence
4. Update TASK_LIST.md to reflect the current implementation stage

## TDD Process

1. **Write Tests First**
   - Define expected behavior through tests
   - Tests should initially fail
   - Cover all requirements and edge cases

2. **Implement Minimal Code**
   - Write just enough code to make tests pass
   - Focus on functionality before optimization
   - Keep implementation aligned with test requirements

3. **Refactor**
   - Improve code while maintaining test coverage
   - Eliminate technical debt
   - Optimize for performance and maintainability

4. **Document**
   - Add inline comments for complex logic
   - Update technical documentation
   - Ensure test purpose is clear

## Linear MCP Commands

### Creating Tasks
```
Create a Linear task for WEC-XX-1 with title "[Component Name]",
status "Not Started", and description from the task document.
```

### Updating Status
```
Update Linear task WEC-XX-1 to status "In Progress"
with comment "Tests written, beginning implementation."
```

### Checking Dependencies
```
List all dependencies for Linear task WEC-XX-1
and verify their current status.
```

### Adding Test Results
```
Add comment to Linear task WEC-XX-1: "All tests passing.
Test coverage: 95%. Ready for review."
```

## File Organization

- **Task Documentation**: `wecoza-dev-flow/tracking/WEC-{issue-number}-task.md`
- **Task Tracking**: `wecoza-dev-flow/tracking/task-list.md`
- **Status Workflow**: `wecoza-dev-flow/guides/status-workflow.md`
- **Test Checklists**: `wecoza-dev-flow/tracking/WEC-{issue-number}-test-checklist.md`
- **Task Template**: `wecoza-dev-flow/templates/task-template.md`

## Common Commands

### Start New Feature
```
1. Create detailed task document using template
2. Set up implementation sequence
3. Create test checklist
4. Create Linear tickets for subtasks
5. Update TASK_LIST.md
```

### Daily Workflow
```
1. Check TASK_LIST.md for next task in sequence
2. Update status to "In Progress"
3. Write tests first (TDD)
4. Implement and refactor
5. Update status when complete
```

### Completing a Task
```
1. Verify all tests pass
2. Complete documentation
3. Update status to "Completed"
4. Add completion date
5. Update Linear ticket
```
