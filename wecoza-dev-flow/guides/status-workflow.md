# WECOZA-DEV Task Status Workflow

This document defines the clear rules for when tasks change status in both the TASK_LIST.md file and Linear.app.

## Status Definitions

### Not Started
- Initial state for all tasks
- No work has begun on tests or implementation
- Task may be waiting on dependencies

### In Progress
- Tests are being written or have been written
- Implementation work has begun
- Active development is ongoing

### Testing
- Initial implementation is complete
- Tests are being run and refined
- Code may be undergoing review or refactoring
- Edge cases are being addressed

### Completed
- All tests pass successfully
- Code has been refactored and optimized
- Documentation has been updated
- The feature meets all acceptance criteria
- Code has been reviewed (if applicable)

### Blocked
- Task cannot proceed due to external dependencies
- Clearly documented reason for being blocked
- Has an expected unblock date if possible

## Status Transition Rules

### Not Started → In Progress
When to transition:
- All dependencies have been completed
- Tests have been created but are failing
- Developer has begun active work on the task
- Task is next in the implementation sequence

Required actions:
- Update status in TASK_LIST.md
- Run sync script to update Linear
- Document the start date in comments

### In Progress → Testing
When to transition:
- Initial implementation is complete
- Code meets the requirements specified
- Tests are all implemented but may not all pass
- Feature is ready for testing/review

Required actions:
- Update status in TASK_LIST.md
- Run sync script to update Linear
- Document any implementation notes or challenges

### Testing → Completed
When to transition:
- ALL tests pass successfully
- Code has been refactored as needed
- Documentation is complete and up-to-date
- Feature meets all acceptance criteria
- No known issues or edge cases remain

Required actions:
- Update status in TASK_LIST.md
- Add completion date in YYYY-MM-DD format
- Run sync script to update Linear
- Document any final notes or considerations

### Any Status → Blocked
When to transition:
- External dependency is preventing progress
- Technical issue cannot be resolved immediately
- Waiting on decision or input from stakeholders

Required actions:
- Update status in TASK_LIST.md
- Document the reason for being blocked
- Add to the "Blocked Tasks" section with details
- Set an expected unblock date if possible
- Run sync script to update Linear

## Status Validation Checklist

### For In Progress:
- [ ] Tests have been written and are failing (as expected)
- [ ] Implementation plan is clear
- [ ] All dependencies are completed
- [ ] Task is next in sequence or prioritized

### For Testing:
- [ ] Implementation is complete
- [ ] All test cases are implemented
- [ ] Core functionality works as expected
- [ ] Code has been initially reviewed (if applicable)
- [ ] Documentation has been started

### For Completed:
- [ ] ALL tests pass successfully
- [ ] Edge cases have been addressed
- [ ] Code has been refactored and optimized
- [ ] Documentation is complete and accurate
- [ ] Review feedback has been addressed (if applicable)
- [ ] No TODO comments remain in the code
- [ ] Feature meets all acceptance criteria

## Example Status Flow

```
Task: WEC-50-2 (Public Holiday Override UI)

1. Initial Status: Not Started
   - Task is defined in TASK_LIST.md
   - Dependencies (WEC-50-1) are not yet completed

2. Dependencies Completed:
   - WEC-50-1 is marked as Completed
   - WEC-50-2 is next in sequence

3. Begin Development:
   - Write failing tests for the UI components
   - Update status to "In Progress"
   - Run sync script to update Linear

4. Implementation:
   - Implement the UI components
   - Get tests passing
   - Document implementation details

5. Completion:
   - All tests pass
   - UI meets all requirements
   - Documentation is complete
   - Update status to "Testing"
   - Run sync script to update Linear

6. Final Verification:
   - Review UI for edge cases
   - Ensure all tests still pass
   - Verify against acceptance criteria
   - Update status to "Completed"
   - Add completion date
   - Run sync script to update Linear
```

## Integration with TDD Workflow

The status workflow integrates directly with the Test-Driven Development approach:

1. **Write Tests** (Status: In Progress)
   - Create failing tests that define expected behavior
   - Document acceptance criteria

2. **Implement** (Status: In Progress)
   - Write minimal code to make tests pass
   - Focus on functionality first

3. **Refactor** (Status: Testing)
   - Improve code while keeping tests passing
   - Address edge cases
   - Optimize for performance

4. **Finalize** (Status: Completed)
   - Ensure all tests pass
   - Complete documentation
   - Verify against all requirements
