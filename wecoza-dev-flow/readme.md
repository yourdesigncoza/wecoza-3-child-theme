# WECOZA-DEV Workflow System

A structured workflow system for PHP projects that integrates Test-Driven Development, task sequencing, and status management with Linear.app.

## Overview

The WECOZA-DEV workflow system provides a standardized approach to task management, test-driven development, and implementation sequencing. It combines detailed task documentation with structured test requirements and clear status transitions to ensure consistent, high-quality development.

## Key Features

- **Test-Driven Development (TDD)** - Write tests before code for all features
- **Implementation Sequencing** - Clear ordering of task implementation with dependencies
- **Status Workflow** - Defined rules for task status transitions
- **Linear.app Integration** - Works with Linear MCP for task tracking
- **Comprehensive Documentation** - Templates and guides for all aspects of the workflow

## Components

### Templates

- **TASK_TEMPLATE.md** - Enhanced task template with TDD sections and implementation sequencing
- **TEST_CHECKLIST_TEMPLATE.md** - Template for creating comprehensive test plans
- **Example Task** - Sample implementation using the new format

### Guides

- **QUICK_REFERENCE.md** - Concise workflow reference for daily use
- **STATUS_WORKFLOW.md** - Detailed guide to status transitions
- **TDD_GUIDE.md** - Guide to Test-Driven Development practices

### Tracking

- **TASK_LIST.md** - Central task management document that syncs with Linear

### Examples

- **Test Checklists** - Example test plans for features
- **Enhanced Tasks** - Sample tasks using the improved format

## Getting Started

1. **Set Up the Structure**
   - Place this folder in your project root or docs directory
   - Review the README.md to understand the workflow

2. **Create Your First Task**
   - Copy `templates/TASK_TEMPLATE.md` to create a new task
   - Fill in all sections, including test criteria and implementation sequence
   - Create a test checklist using `templates/TEST_CHECKLIST_TEMPLATE.md`
   - Add the task to `tracking/TASK_LIST.md`

3. **Follow the Workflow**
   - Use `guides/QUICK_REFERENCE.md` for day-to-day workflow steps
   - Follow TDD principles when implementing
   - Update task status according to the defined rules
   - Keep `tracking/TASK_LIST.md` in sync with Linear

## Benefits

- **Improved Code Quality** - TDD ensures well-tested, reliable code
- **Better Planning** - Implementation sequencing prevents dependency issues
- **Clearer Progress Tracking** - Standardized status transitions
- **Consistency** - Team members follow the same workflow
- **Documentation** - All tasks are thoroughly documented

## Best Practices

1. **Always Write Tests First** - Follow TDD principles strictly
2. **Respect the Implementation Sequence** - Complete dependencies before starting new tasks
3. **Update TASK_LIST.md Regularly** - Keep it in sync with actual progress
4. **Follow Status Rules** - Only transition status when criteria are met
5. **Create Detailed Test Checklists** - Comprehensive test coverage is essential

## Integration with Existing Tools

This workflow system is designed to work alongside your existing tools:

- **Linear.app** - Use Linear MCP for task management
- **Git** - Commit TASK_LIST.md changes with your code
- **PHP Projects** - Specially designed for PHP development workflows
- **Unit Testing Frameworks** - Works with PHPUnit or any testing framework

## Need Help?

- Refer to the example implementations in `examples/`
- Check the quick reference guide for common workflows
- Review the status workflow document for transition rules
