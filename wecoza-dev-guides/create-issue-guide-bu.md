# How to Create a Comprehensive WECOZA-DEV Task for Any Feature

This guide outlines the streamlined process for creating a well-structured WECOZA-DEV task for implementing any new feature or functionality.

## Step 1: Gather Information About the Feature Requirements

First, clearly define the requirements for the feature:
- What functionality is needed?
- What UI elements are required?
- What technical components need to be implemented?
- How does it integrate with the existing system?
- What are the acceptance criteria?
- Are there any performance considerations?

## Step 2: Research the Existing Codebase

Understand how similar features are implemented in the codebase:
- What existing patterns should be followed?
- What components can be reused?
- What services or utilities are available?
- How are similar features structured?
- What naming conventions should be followed?

## Step 3: Create a Detailed Task Description Using the Development Template

1. Create a markdown file in the `build-tasks/` directory with a name that reflects your feature:

```markdown
# [Feature Title]

## Description
[Provide a clear, concise description of the feature or requirement]

[Include any additional context, background information, software requirements or script dependencies]

As shown in the UI:
- [Key UI element or interaction point]
- [Another UI element or interaction point]
- [Additional UI elements as needed]

## Subtasks
- [ ] SUB-1: [First major component]
  - [Specific implementation detail]
  - [Technical approach]
  - [Testing criteria]
  - [Performance considerations]

- [ ] SUB-2: [Second major component]
  - [Specific implementation detail]
  - [Technical approach]
  - [Testing criteria]
  - [Performance considerations]

## Files
- [File path 1]
- [File path 2]
- [File path 3]
- [Additional files as needed]

## Related Issues
- ISSUE-1: [Brief description of related issue]
- ISSUE-2: [Brief description of another related issue]
```

2. Fill in the template with your feature details. Here's an example of a well-structured task:

```markdown
# Implement [Feature Name]

## Description
[Provide a clear, concise description of what the feature does and its purpose]

[Include any additional context, background information, or technical requirements]

As shown in the UI:
- [Key UI element or interaction point]
- [User flow or interaction pattern]
- [Visual styling or design requirements]
- [Feedback mechanisms]

## Subtasks
- [ ] WEC-XX.1: [First Major Component]
  - [Specific implementation detail]
  - [Technical approach]
  - [Integration points]
  - [Error handling considerations]
  - [Performance considerations]

- [ ] WEC-XX.2: [Second Major Component]
  - [Specific implementation detail]
  - [Technical approach]
  - [Integration points]
  - [Error handling considerations]
  - [Performance considerations]

- [ ] WEC-XX.3: [Third Major Component]
  - [Specific implementation detail]
  - [Technical approach]
  - [Integration points]
  - [Error handling considerations]
  - [Performance considerations]

- [ ] WEC-XX.4: [Testing and Documentation]
  - [Test cases to cover]
  - [Documentation requirements]
  - [User guidance needed]
  - [Performance testing]

## Files
- [File path 1]
- [File path 2]
- [File path 3]
- [Additional files as needed]

## Related Issues
- [Related issue reference, if any]
```

## Step 4: Create the WECOZA-DEV Task

1. Create a new WECOZA-DEV task with a basic title and description:

```
WECOZA-DEV> Create a new issue with title "Implement [Feature Name]" and description "[Brief description of the feature]"
```

2. Note the issue ID and UUID from the response:
   - Issue ID: WEC-XX (e.g., WEC-67)
   - UUID: [UUID from response] (e.g., 7ac3dd6e-51aa-41d4-ab7e-da1d069d6df6)

## Step 5: Update the WECOZA-DEV Task with Detailed Content

Update the task with the full detailed description from your markdown file in the `build-tasks/` directory:

```
WECOZA-DEV> Update issue WEC-XX with description "[Paste your complete markdown content here]"
```

For example:

```
WECOZA-DEV> Update issue WEC-XX with description "# Implement [Feature Name]

## Description
[Your detailed feature description]

As shown in the UI:
- [UI element 1]
- [UI element 2]
- [UI element 3]

## Subtasks
- [ ] WEC-XX.1: [First Major Component]
  - [Implementation detail 1]
  - [Implementation detail 2]
  - [Implementation detail 3]

- [ ] WEC-XX.2: [Second Major Component]
  - [Implementation detail 1]
  - [Implementation detail 2]
  - [Implementation detail 3]

## Files
- [File path 1]
- [File path 2]
- [File path 3]

## Related Issues
- [Related issue reference, if any]"
```

## Step 6: Move the Task to "In Progress" State

1. First, get the team states to find the UUID of the "In Progress" state:

```
WECOZA-DEV> Get team with id "[your-team-id]" including states
```

2. From the response, identify the UUID for the "In Progress" state:
   - Look for the state with "name": "In Progress" and note its "id" value

3. Update the task state:

```
WECOZA-DEV> Update issue WEC-XX with stateId "[in-progress-state-uuid]"
```

## Summary

Following this process, you've created a comprehensive WECOZA-DEV task that:

1. Has a clear title and description
2. Includes detailed subtasks with the WEC-xx.y convention
3. Provides implementation details for each component
4. Lists all files that need to be created or modified
5. Is properly set to "In Progress" state
6. Has a permanent record in the `build-tasks/` directory for future reference

This structured approach ensures that the development team has all the information needed to implement any feature correctly and efficiently.

## Tips for Different Feature Types

### For UI Features
- Include mockups or wireframes if available
- Detail user interactions and flows
- Specify responsive behavior requirements
- List accessibility considerations

### For Backend Features
- Detail data structures and schemas
- Specify API endpoints and parameters
- Include performance requirements
- Document security considerations

### For Integration Features
- List all systems involved
- Detail data flow between systems
- Specify authentication requirements
- Include error handling scenarios

## Best Practices

1. **Be Specific**: Provide enough detail that a developer can understand what needs to be built without additional context
2. **Use Consistent Naming**: Follow the WEC-xx.y convention for subtasks
3. **Break Down Complex Tasks**: Aim for subtasks that can be completed in 1-2 days
4. **Include Acceptance Criteria**: Make it clear when a task is considered complete
5. **Reference Related Issues**: Link to related tasks or dependencies
6. **Update as You Go**: Keep the task updated with progress and new information
7. **Maintain Task Files**: Store all task definitions in the `build-tasks/` directory for documentation and future reference
8. **Use Consistent File Naming**: Name task files descriptively (e.g., `feature-name-task.md`)
