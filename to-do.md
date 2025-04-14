# WeCoza MVC Improvement To-Do List

## Class Capture Form View Improvements

### 1. Consistent Use of View Helpers
- [x] Convert Client Name dropdown to use select_dropdown() helper
- [x] Convert Class/Site Name dropdown to use select_dropdown_with_optgroups() helper
- [x] Convert Class Type dropdown to use select_dropdown() helper
- [x] Convert Class Original Start Date to use form_input() helper
- [x] Convert Class Subjects dropdown to use select_dropdown() helper
- [x] Standardize all form labels to use consistent styling (remove fw-bold where used)
- [ ] Convert all remaining form elements to use appropriate helpers

### 2. Create Partial Views
- [ ] Create partial view for Basic Details section
- [ ] Create partial view for Class Schedule Calendar section
- [ ] Create partial view for Class Info section
- [ ] Create partial view for Date History section
- [ ] Create partial view for Funding & Exam Details section
- [ ] Create partial view for Class Learners section
- [ ] Create partial view for Exam Learners section
- [ ] Create partial view for Class Notes & QA section
- [ ] Create partial view for Assignments & Dates section
- [ ] Update main view to include all partials

### 3. JavaScript Improvements
- [ ] Move all inline JavaScript to external files
- [ ] Add data attributes for JavaScript hooks
- [ ] Ensure calendar initialization happens only when tab is visible
- [ ] Improve event handling for dynamic form elements

### 4. Validation Improvements
- [ ] Move client-side validation logic to dedicated JS file
- [ ] Ensure server-side validation in ValidationService matches client-side
- [ ] Implement consistent validation feedback patterns
- [ ] Add field-specific validation rules in the controller

### 5. Bug Fixes
- [ ] Fix calendar not initializing properly in tabs

## General MVC Architecture Improvements

### 1. Controller Refactoring
- [ ] Move data retrieval methods to appropriate repository classes
- [ ] Implement proper dependency injection
- [ ] Add proper error handling and logging

### 2. Model Improvements
- [ ] Ensure all models follow consistent patterns
- [ ] Implement data validation in models
- [ ] Add proper type hinting and return types

### 3. View Helper System
- [ ] Create additional view helpers for common patterns
- [ ] Improve documentation for all view helpers
- [ ] Add unit tests for view helpers

## Completed Tasks

### 1. Consistent Use of View Helpers
- ✅ Convert Client Name dropdown to use select_dropdown() helper
- ✅ Convert Class/Site Name dropdown to use select_dropdown_with_optgroups() helper
- ✅ Convert Class Type dropdown to use select_dropdown() helper
- ✅ Convert Class Original Start Date to use form_input() helper
- ✅ Convert Class Subjects dropdown to use select_dropdown() helper
- ✅ Standardize all form labels to use consistent styling (remove fw-bold where used)

### UI Improvements
- ✅ Add text-white class to Save Event button for consistent button styling
- ✅ Add proper form label to Class Subjects dropdown
- ✅ Add proper form label to Initial Class Agent dropdown
