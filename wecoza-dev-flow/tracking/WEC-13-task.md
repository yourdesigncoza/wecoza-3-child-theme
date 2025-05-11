# Learner Status Tracking System

## Description
Implement a comprehensive learner status tracking system for managing learner statuses throughout their educational journey. The system will track three primary statuses:

- CIC (Currently in Class): Active learner status
- RBE (Removed by Employer): Employer-initiated removal
- DRO (Drop Out): Learner-initiated withdrawal

This feature will provide a complete workflow for status management, including UI components for status changes, automatic history tracking, notifications, reporting, and integration with existing class attendance systems.

As shown in the UI:
- Status dropdown in learner management interface
- Status history timeline showing all previous status changes with dates and reasons
- Status indicators in learner listings with color coding (green for CIC, yellow for RBE, red for DRO)
- Status change notification alerts for administrators
- Status-based filtering in reporting interfaces

## Implementation Sequence
1. First implement WEC-13-1 (Status Change UI) - This provides the foundational interface for status management
2. Then implement WEC-13-2 (Status History Tracking) - This creates the data structure for recording status changes
3. Next implement WEC-13-5 (Class Attendance Integration) - This connects status tracking with attendance records
4. Then implement WEC-13-3 (Status Change Notifications) - This builds on the status tracking system
5. Next implement WEC-13-6 (Status-Based Access Control) - This utilizes the status system for permissions
6. Finally implement WEC-13-4 (Status Reporting) - This provides analytics based on all previous components

## Subtasks
- [ ] WEC-13-1: Status Change UI
  - **Test Criteria (TDD):**
    - Unit tests for status dropdown component rendering
    - Tests for status change form validation
    - Tests for status change submission handling
    - Acceptance criteria: UI allows changing status with reason field and displays current status correctly
  - **Implementation Details:**
    - Create status dropdown in learner management interface
    - Implement status change form with reason field
    - Add status indicators with appropriate color coding
    - Implement client-side validation for status change form
    - Add confirmation dialog for status changes
  - **Status Transitions:**
    - Not Started → In Progress: When tests for status UI components are created
    - In Progress → Testing: When UI implementation is complete
    - Testing → Completed: When all UI tests pass and user experience is verified

- [ ] WEC-13-2: Status History Tracking
  - **Test Criteria (TDD):**
    - Unit tests for status history data model
    - Tests for status history creation on status change
    - Tests for retrieving complete status history
    - Acceptance criteria: System maintains accurate history of all status changes with timestamps and reasons
  - **Implementation Details:**
    - Create LearnerStatusModel for tracking status history
    - Implement database schema for status history
    - Add methods to record status changes with timestamp, user, and reason
    - Create status history timeline view
    - Implement status history retrieval methods
  - **Status Transitions:**
    - Not Started → In Progress: When tests for status history model are created
    - In Progress → Testing: When history tracking implementation is complete
    - Testing → Completed: When all history tracking tests pass

- [ ] WEC-13-3: Status Change Notifications
  - **Test Criteria (TDD):**
    - Unit tests for notification generation on status change
    - Tests for notification delivery to appropriate users
    - Tests for notification content formatting
    - Acceptance criteria: System sends appropriate notifications when learner status changes
  - **Implementation Details:**
    - Implement event listeners for status change events
    - Create notification templates for different status changes
    - Add notification preferences for administrators
    - Implement email and in-system notifications
    - Create notification log for tracking delivery
  - **Status Transitions:**
    - Not Started → In Progress: When tests for notification system are created
    - In Progress → Testing: When notification implementation is complete
    - Testing → Completed: When all notification tests pass

- [ ] WEC-13-4: Status Reporting
  - **Test Criteria (TDD):**
    - Unit tests for status report generation
    - Tests for filtering and aggregation functions
    - Tests for report export functionality
    - Acceptance criteria: System generates accurate reports on learner status changes and distributions
  - **Implementation Details:**
    - Create reporting interface for status analytics
    - Implement filters for date ranges, classes, and status types
    - Add data visualization for status distributions
    - Create export functionality for reports (CSV, PDF)
    - Implement scheduled report generation
  - **Status Transitions:**
    - Not Started → In Progress: When tests for reporting functionality are created
    - In Progress → Testing: When reporting implementation is complete
    - Testing → Completed: When all reporting tests pass

- [ ] WEC-13-5: Class Attendance Integration
  - **Test Criteria (TDD):**
    - Unit tests for status-attendance relationship
    - Tests for attendance record updates based on status
    - Tests for attendance reporting with status context
    - Acceptance criteria: System correctly integrates status with attendance tracking
  - **Implementation Details:**
    - Link learner status with attendance records
    - Update attendance calculations based on status
    - Modify attendance reports to include status context
    - Implement automatic status updates based on attendance patterns
    - Add attendance history in status change interface
  - **Status Transitions:**
    - Not Started → In Progress: When tests for attendance integration are created
    - In Progress → Testing: When integration implementation is complete
    - Testing → Completed: When all integration tests pass

- [ ] WEC-13-6: Status-Based Access Control
  - **Test Criteria (TDD):**
    - Unit tests for access control based on learner status
    - Tests for resource visibility rules
    - Tests for permission changes on status updates
    - Acceptance criteria: System restricts or grants access to resources based on learner status
  - **Implementation Details:**
    - Implement access control rules based on learner status
    - Create permission system for status-based resource access
    - Add status checks to resource controllers
    - Implement UI indicators for access restrictions
    - Create override mechanism for administrators
  - **Status Transitions:**
    - Not Started → In Progress: When tests for access control are created
    - In Progress → Testing: When access control implementation is complete
    - Testing → Completed: When all access control tests pass

## Files
- `app/Models/Learner/LearnerModel.php`
- `app/Models/Learner/LearnerStatusModel.php` (new file)
- `app/Controllers/LearnerController.php`
- `app/Controllers/NotificationController.php`
- `app/Views/learner/learner-management.php`
- `app/Views/learner/status-history.php` (new file)
- `app/Views/admin/status-reports.php` (new file)
- `public/js/learner-status.js` (new file)
- `includes/css/ydcoza-styles.css`
- `includes/db-migrations/learner-status-tables.php` (new file)
- `app/Services/Notification/StatusNotificationService.php` (new file)
- `app/Services/Reporting/StatusReportingService.php` (new file)

## Related Issues
- WEC-50: Public Holidays Integration (related issue mentioned in Linear)

## Technical Approach

### Data Structure
We'll extend the learner data model to include status information and history:

```php
// Status constants
const STATUS_CIC = 'cic'; // Currently in Class
const STATUS_RBE = 'rbe'; // Removed by Employer
const STATUS_DRO = 'dro'; // Drop Out

// Status history table structure
CREATE TABLE learner_status_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    learner_id INT NOT NULL,
    status VARCHAR(10) NOT NULL,
    reason TEXT,
    changed_by INT NOT NULL,
    changed_at DATETIME NOT NULL,
    FOREIGN KEY (learner_id) REFERENCES learners(id),
    FOREIGN KEY (changed_by) REFERENCES users(id)
);
```

### Notification System
The notification system will:
1. Trigger on status change events
2. Determine recipients based on configuration
3. Format appropriate messages based on status type
4. Deliver via email and in-system notifications
5. Log delivery for audit purposes

### Reporting System
The reporting system will provide:
1. Status distribution analytics
2. Status change trends over time
3. Filtering by date, class, employer, and status type
4. Export functionality in multiple formats
5. Scheduled report generation

### User Flow
1. Administrator selects learner in management interface
2. Current status is displayed with color indicator
3. Administrator selects new status from dropdown
4. System prompts for reason for status change
5. On confirmation, system:
   - Updates learner status
   - Records entry in status history
   - Sends notifications to relevant stakeholders
   - Updates access permissions based on new status
   - Updates attendance records if necessary
6. Status history is available for review
7. Status data is available in reporting interface
