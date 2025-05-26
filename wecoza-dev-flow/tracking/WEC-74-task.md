# WEC-74 Implementation Task List: Split Class Create/Update Functionality

## Overview
Split the existing class capture form into separate Create and Update workflows with different validation rules and field distributions.

## Phase 1: Controller & Routing Updates

### 1.1 Update ClassController.php
- [ ] **File**: `app/Controllers/ClassController.php`
- [ ] Add mode detection logic in `captureClassShortcode()` method
- [ ] Implement URL parameter handling for `?mode=create` and `?mode=update&class_id=123`
- [ ] Create new shortcode handlers:
  - [ ] `createClassShortcode()` - handles `[wecoza_create_class]`
  - [ ] `updateClassShortcode()` - handles `[wecoza_update_class class_id="123"]`
- [ ] Update data preparation logic to handle both modes
- [ ] Add class data retrieval for update mode

### 1.2 Register New Shortcodes
- [ ] **File**: `app/ajax-handlers.php`
- [ ] Register `[wecoza_create_class]` shortcode
- [ ] Register `[wecoza_update_class]` shortcode
- [ ] Maintain backward compatibility with existing `[wecoza_capture_class]`

## Phase 2: Form File Creation

### 2.1 Create Separate Form Files
- [ ] **File**: `app/Views/components/create-class-form.view.php`
  - [ ] Include only creation-specific fields
  - [ ] Implement Bootstrap 5 floating labels
  - [ ] Add proper form validation classes
  - [ ] Include comprehensive developer comments

- [ ] **File**: `app/Views/components/update-class-form.view.php`
  - [ ] Include only update/management fields
  - [ ] Add read-only display section for creation data
  - [ ] Implement conditional field rendering
  - [ ] Include comprehensive developer comments

### 2.2 Create Form Partials for Create Mode
- [ ] **File**: `app/Views/components/create-class-partials/basic-details.php`
  - [ ] Client & Site selection
  - [ ] Class identification fields
  - [ ] Address display (read-only)

- [ ] **File**: `app/Views/components/create-class-partials/curriculum-info.php`
  - [ ] Class type selection
  - [ ] Class subject selection
  - [ ] Duration calculation (auto-calculated)

- [ ] **File**: `app/Views/components/create-class-partials/schedule-setup.php`
  - [ ] Original start date
  - [ ] Schedule pattern selection
  - [ ] Days of week selection
  - [ ] Time selection (start/end)

- [ ] **File**: `app/Views/components/create-class-partials/funding-exams.php`
  - [ ] SETA funding fields
  - [ ] Exam class configuration
  - [ ] Exam type selection

- [ ] **File**: `app/Views/components/create-class-partials/roster-setup.php`
  - [ ] Initial learner selection
  - [ ] Exam learner selection (conditional)

- [ ] **File**: `app/Views/components/create-class-partials/staffing-setup.php`
  - [ ] Initial agent assignment
  - [ ] Project supervisor assignment
  - [ ] Optional backup agent

### 2.3 Create Form Partials for Update Mode
- [ ] **File**: `app/Views/components/update-class-partials/class-summary.php`
  - [ ] Read-only display of creation data
  - [ ] Class identification information
  - [ ] Basic schedule information

- [ ] **File**: `app/Views/components/update-class-partials/exceptions-holidays.php`
  - [ ] Exception dates management
  - [ ] Public holiday overrides
  - [ ] Date validation (strict mode)

- [ ] **File**: `app/Views/components/update-class-partials/schedule-analytics.php`
  - [ ] Schedule statistics display
  - [ ] Calendar days calculation
  - [ ] Session and hours tracking

- [ ] **File**: `app/Views/components/update-class-partials/date-history.php`
  - [ ] Class stop/restart dates
  - [ ] Date history management
  - [ ] Validation for restart > stop dates

- [ ] **File**: `app/Views/components/update-class-partials/quality-notes.php`
  - [ ] Class notes & QA fields
  - [ ] Operational flags
  - [ ] QA visit dates and reports

- [ ] **File**: `app/Views/components/update-class-partials/staff-changes.php`
  - [ ] Agent replacement functionality
  - [ ] Additional backup agents
  - [ ] Staff change history

## Phase 3: Validation Updates

### 3.1 Update ClassModel Validation
- [ ] **File**: `app/Models/Assessment/ClassModel.php`
- [ ] Add mode parameter to `getValidationRules()` method
- [ ] Implement create-mode validation rules:
  - [ ] Exception dates: completely optional
  - [ ] All creation fields: required validation
  - [ ] Basic schedule validation
- [ ] Implement update-mode validation rules:
  - [ ] Exception dates: strict validation (cannot be before start date)
  - [ ] Management fields: appropriate validation
  - [ ] Staff change validation

### 3.2 Update Validation Service
- [ ] **File**: `app/Services/Validation/ValidationService.php`
- [ ] Add mode-aware validation methods
- [ ] Implement conditional validation rules
- [ ] Add exception date validation logic for update mode

## Phase 4: Data Handling Updates

### 4.1 Update AJAX Handlers
- [ ] **File**: `app/Controllers/ClassController.php`
- [ ] Update `saveClassAjax()` method to handle mode detection
- [ ] Implement separate save logic for create vs update
- [ ] Add class data retrieval for update mode pre-population
- [ ] Update form data processing for different field sets

### 4.2 Database Operations
- [ ] **File**: `app/Models/Assessment/ClassModel.php`
- [ ] Ensure `getById()` method returns complete class data
- [ ] Update save/update methods to handle mode-specific data
- [ ] Add methods for retrieving class summary data

## Phase 5: JavaScript Updates

### 5.1 Update Client-Side Validation
- [ ] **File**: `public/js/class-capture.js`
- [ ] Add mode detection in JavaScript
- [ ] Implement separate validation logic for create/update modes
- [ ] Update form submission handling for different endpoints
- [ ] Add conditional field validation

### 5.2 Update Schedule Form JavaScript
- [ ] **File**: `public/js/class-schedule-form.js`
- [ ] Add mode-aware schedule validation
- [ ] Implement different validation rules for exception dates
- [ ] Update calendar integration for update mode

## Phase 6: Testing & Integration

### 6.1 Create Mode Testing
- [ ] Test form rendering with `[wecoza_create_class]` shortcode
- [ ] Verify all creation fields are present and functional
- [ ] Test relaxed validation (exception dates optional)
- [ ] Test successful class creation workflow
- [ ] Verify redirect functionality after creation

### 6.2 Update Mode Testing
- [ ] Test form rendering with `[wecoza_update_class class_id="X"]` shortcode
- [ ] Verify class data pre-population
- [ ] Test read-only creation data display
- [ ] Test strict exception date validation
- [ ] Test update functionality for management fields

### 6.3 Integration Testing
- [ ] Test URL parameter handling (`?mode=create` vs `?mode=update&class_id=123`)
- [ ] Verify backward compatibility with existing `[wecoza_capture_class]`
- [ ] Test AJAX form submissions for both modes
- [ ] Verify proper error handling and validation messages
- [ ] Test responsive design on mobile devices

## Phase 7: Documentation Updates

### 7.1 Update Documentation
- [ ] **File**: `app/Models/Assessment/ClassModel-README.md`
- [ ] Document new shortcodes and their usage
- [ ] Add examples for both create and update modes
- [ ] Document validation rule differences

### 7.2 Add Developer Comments
- [ ] Ensure all new view files have comprehensive header comments
- [ ] Document the MVC architecture usage
- [ ] Add inline comments for complex validation logic
- [ ] Document the mode detection and routing logic

## Success Criteria
- [ ] Create form contains only initial setup fields
- [ ] Update form contains only management fields with pre-populated creation data
- [ ] Exception date validation is optional in create mode, strict in update mode
- [ ] Both forms maintain Bootstrap 5 styling and validation patterns
- [ ] Proper MVC architecture separation is maintained
- [ ] All existing functionality remains intact
- [ ] Forms are responsive and accessible

## Technical Notes
- Maintain existing Bootstrap 5 floating label implementation
- Follow strict MVC architecture patterns
- Ensure proper nonce verification for security
- Use existing ViewHelpers for consistent UI elements
- Maintain compatibility with existing AJAX handlers
- Follow WordPress coding standards throughout

## Progress Tracking
- **Started**: [Date]
- **Current Phase**: Phase 1
- **Completed Phases**: None
- **Estimated Completion**: [Date]
- **Actual Completion**: [Date]

## Implementation Notes
[Add notes during implementation about decisions made, challenges encountered, and solutions implemented]