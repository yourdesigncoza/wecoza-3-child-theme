# WeCoza Outstanding Tasks & Improvements

## 1. Class Creation Form Improvements (WEC-38) 
/*
Move to cancelled we will not be implementing a tabbed form
*/

## 2. Calendar & Event Management
- [ ] Exception date handling (WEC-25)
- [ ] Stepped workflow (WEC-31)
- [ ] Automatic duration calculation
- [ ] Recurring schedule handling:
  - [ ] Every second week option
  - [ ] Last Saturday of month option
  - [ ] Custom patterns

## 3. Class Type & Duration Integration

/*
Reference Implementation:
- ClassTypesController.php already handles basic class type structure
- Current duration calculation exists but needs expansion
- Integration with calendar events for automatic scheduling

Key Implementation Notes:
- All durations need to integrate with the calendar scheduling system for automatic end date calculation
- Each module type requires specific validation rules
- Need to implement override capability for manual adjustments
- Must support both automatic progression and manual override
- Integration with existing classes-capture-shortcode.php for event display
*/

- [ ] Integration points:
    // Need to extend ClassTypesController::getClassTypes() to include all program categories
    // Currently missing detailed subject mappings and hierarchical relationships
    // See feedback-april-15.md for complete program structure requirements

- [ ] Skill Packages (Walk, Hexa, Run)
    // Not yet automated
    // Need to implement flexible duration calculation
    // Special invoicing methods required (see feedback-april-15.md)
    // Integration with invoice method dropdown in class creation form

## 4. Learner Management Enhancements
- [ ] Status tracking (CIC, RBE, DRO)
    // Implement learner status system:
    // - CIC (Currently in Class): Active learner status
    // - RBE (Removed by Employer): Employer-initiated removal
    // - DRO (Drop Out): Learner-initiated withdrawal
    // Requirements:
    // - Status change dropdown in learner management interface
    // - Automatic status history tracking
    // - Status change notifications
    // - Reporting functionality for status changes
    // - Integration with class attendance tracking
    // - Status-based access control to resources

- [ ] Level/module assignment per learner
- [ ] Automatic level progression
- [ ] Portfolio scanning integration
- [ ] Community learner handling

## 5. Event Types to Implement

- [ ] Material delivery scheduling
    // Delivery event management:
    // - Integration with class schedule
    // - Automatic scheduling based on class start date
    // - Delivery status tracking (Pending, In Transit, Delivered)
    // - Multiple delivery types support:
    //   * Initial material delivery
    //   * Supplementary materials
    //   * Replacement materials
    // Features needed:
    // - Delivery date selection/override
    // - Courier integration options
    // - Delivery confirmation system
    // - Notification system for stakeholders
    // - Material inventory tracking

- [ ] Agent absence handling
    // Agent availability management:
    // - Absence type categorization:
    //   * Planned leave
    //   * Sick leave
    //   * Emergency absence
    // Implementation:
    // - Calendar integration for absence marking
    // - Automatic backup agent assignment
    // - Class rescheduling options
    // - Notification system for:
    //   * Affected learners
    //   * Client contacts
    //   * Management team
    // - Absence history tracking

- [ ] Client cancellation management
    // Cancellation handling system:
    // - Single session cancellation
    // - Multiple session cancellation
    // - Recurring schedule adjustments
    // Features:
    // - Cancellation reason tracking
    // - Impact assessment on schedule
    // - Automatic makeup session scheduling
    // - Hours tracking adjustment
    // - Client communication automation
    // - Reporting integration

- [ ] Exam date management
    // Comprehensive exam scheduling:
    // - Multiple exam types support:
    //   * AET Communication
    //   * AET Numeracy
    //   * GETC AET modules
    // Features:
    // - Exam venue allocation
    // - Examiner assignment
    // - Candidate registration
    // - Document preparation tracking
    // - Results recording system
    // - Integration with learner progression

- [ ] Material collection tracking
    // Collection event system:
    // - Schedule collection dates
    // - Track collection status
    // - Handle multiple collection types:
    //   * Completed portfolios
    //   * Assessment materials
    //   * Unused resources
    // Features:
    // - Collection confirmation
    // - Quality check integration
    // - Return processing
    // - Inventory reconciliation

- [ ] Mock exam scheduling
    // Mock exam management:
    // - Schedule creation
    // - Resource allocation
    // - Multiple session support
    // Features:
    // - Automatic scheduling based on main exam
    // - Result tracking
    // - Performance analysis
    // - Feedback system
    // - Integration with exam preparation

- [ ] SBA task & submission date tracking
    // SBA management system:
    // - Task scheduling
    // - Submission tracking
    // - Multiple submission types:
    //   * Individual tasks
    //   * Group projects
    //   * Portfolio elements
    // Features:
    // - Automatic deadline calculation
    // - Progress tracking
    // - Late submission handling
    // - Feedback mechanism
    // - Integration with assessment system

/*
Global Integration Requirements:
- All events must integrate with main calendar system
- Color coding for different event types
- Drag-and-drop rescheduling support
- Conflict detection and resolution
- Automatic notification system
- Mobile-responsive interface
- Export/import functionality
- Reporting integration

Technical Implementation:
- Extend classes-capture-shortcode.php
- Integrate with ClassTypesController
- Follow WordPress event handling
- Support GeneratePress styling
- Implement proper error handling
- Enable event filtering/search
- Support recurring events
- Enable bulk operations

Reference:
- See feedback-april-15.md for detailed requirements
- Follow existing calendar implementation
- Maintain consistent UI/UX patterns
*/

## 6. UI/UX Improvements

- [ ] Color scheme update (WEC-39 in Progress)
    // Update color scheme implementation:
    // - Primary colors:
    //   * Base Background: #ffffff
    //   * Secondary Background: #f7f8f9
    //   * Tertiary Background: #f3f0ff
    //   * Primary Text: #222222
    //   * Secondary Text: #575760
    //   * Tertiary Text: #b2b2be
    //   * Accent Color: #6e5dc6
    // - UI Element colors:
    //   * Button Background: #55555e
    //   * Button Hover: #3f4047
    //   * Button Text: #ffffff
    //   * Overlay Background: rgba(0,0,0,0.2)
    //   * Modal Background: rgba(0,0,0,0.4)

- [ ] Event type differentiation
    // Visual distinction between event types:
    // - Color coding system:
    //   * Delivery events: Blue-based
    //   * Exam events: Red-based
    //   * Collection events: Green-based
    //   * Absence/cancellation: Orange-based
    // - Icon system for quick recognition
    // - Status indicators
    // - Priority highlighting

## 7. Integration Requirements

- [ ] SETA funding integration
    // SETA funding management system:
    // - Funding type identification:
    //   * AET Communication
    //   * AET Numeracy
    //   * GETC AET modules
    // Implementation requirements:
    // - Funding status tracking
    // - Automatic validation rules
    // - Document management
    // - Integration with class creation:
    //   * Funding checkbox in class setup
    //   * Automatic exam selection
    //   * Special reporting requirements
    // - Financial tracking:
    //   * Funding amounts
    //   * Payment schedules
    //   * Reconciliation reports

- [ ] Exam system integration
    // Comprehensive exam management:
    // - Exam type categorization:
    //   * Internal assessments
    //   * External examinations
    //   * SETA examinations
    // Core features:
    // - Automatic scheduling based on class progression
    // - Venue management
    // - Examiner allocation
    // - Results tracking
    // - Certificate generation
    // - Integration with learner profiles
    // - Automated notifications

- [ ] Portfolio management system
    // Digital portfolio handling:
    // - Upload functionality:
    //   * Bulk upload support
    //   * File type validation
    //   * Size limitations
    // - Processing features:
    //   * Automatic categorization
    //   * OCR for physical documents
    //   * Metadata extraction
    // - Management tools:
    //   * Version control
    //   * Review system
    //   * Feedback mechanism
    // - Integration points:
    //   * Learner profiles
    //   * Assessment tracking
    //   * Progress monitoring

- [ ] Agent order number generation
    // Automated agent numbering system:
    // - Unique identifier generation:
    //   * Sequential numbering
    //   * Region/area codes
    //   * Class type indicators
    // - Integration requirements:
    //   * Class assignment
    //   * Agent profile
    //   * Reporting system
    // - Management features:
    //   * Number tracking
    //   * History logging
    //   * Search functionality

- [ ] Backup agent system
    // Backup agent management:
    // - Agent matching system:
    //   * Skill level matching
    //   * Availability checking
    //   * Geographic location
    // - Assignment features:
    //   * Automatic suggestion
    //   * Manual override
    //   * Notification system
    // - Integration points:
    //   * Agent profiles
    //   * Class schedules
    //   * Absence management
    // - Tracking features:
    //   * Replacement history
    //   * Performance monitoring
    //   * Client feedback

/*
Global Integration Notes:
- All systems must integrate with WordPress core
- Follow GeneratePress theme compatibility
- Maintain MVC architecture
- Implement proper error handling
- Support mobile responsiveness
- Enable data export/import
- Provide API endpoints where needed
*/

## 8. Reporting & Tracking

- [ ] Class progress tracking
    // Comprehensive class monitoring system:
    // - Progress metrics:
    //   * Hours completed vs scheduled
    //   * Module completion rates
    //   * Assessment outcomes
    //   * Portfolio submissions
    // - Visual indicators:
    //   * Progress bars
    //   * Status indicators:
    //     - On Track (Green)
    //     - At Risk (Yellow)
    //     - Behind Schedule (Red)
    //   * Milestone markers
    // - Automated alerts:
    //   * Approaching deadlines
    //   * Missing submissions
    //   * Schedule conflicts
    //   * Hours shortfall warnings
    // - Reporting features:
    //   * Daily progress summaries
    //   * Weekly status reports
    //   * Monthly completion trends
    //   * Custom date range reports
    //   * Export capabilities (PDF, Excel)

- [ ] Learner progression monitoring
    // Individual learner tracking system:
    // - Academic progress:
    //   * Module completion status
    //   * Assessment scores
    //   * Portfolio completion
    //   * Practical evaluations
    // - Status tracking:
    //   * Currently in Class (CIC)
    //   * Removed by Employer (RBE)
    //   * Drop Out (DRO)
    //   * Completed
    // - Performance metrics:
    //   * Attendance rates
    //   * Assignment completion
    //   * Test scores
    //   * Practical assessments
    // - Intervention tracking:
    //   * Support provided
    //   * Additional resources
    //   * Special arrangements
    // - Documentation:
    //   * Progress reports
    //   * Achievement certificates
    //   * Competency records
    //   * Historical data

- [ ] Attendance tracking
    // Comprehensive attendance management:
    // - Daily tracking:
    //   * Present
    //   * Absent
    //   * Late arrival
    //   * Early departure
    //   * Excused absence
    // - Reporting features:
    //   * Individual attendance records
    //   * Class attendance summaries
    //   * Trend analysis
    //   * Absence patterns
    // - Integration points:
    //   * Class schedules
    //   * Exception dates
    //   * Public holidays
    //   * Special events
    // - Automated functions:
    //   * Attendance calculations
    //   * Warning notifications
    //   * Monthly summaries
    //   * Required hours tracking
    // - Management tools:
    //   * Bulk attendance entry
    //   * Correction capabilities
    //   * Audit trail
    //   * Report generation

- [ ] Exception date reporting
    // Exception management system:
    // - Exception types:
    //   * Public holidays
    //   * Client cancellations
    //   * Agent absence
    //   * Venue unavailability
    //   * Weather-related
    //   * Emergency closures
    // - Tracking features:
    //   * Date and duration
    //   * Reason categorization
    //   * Impact assessment
    //   * Make-up arrangements
    // - Reporting capabilities:
    //   * Exception summaries
    //   * Impact analysis
    //   * Schedule adjustments
    //   * Hours compensation
    // - Management tools:
    //   * Calendar integration
    //   * Notification system
    //   * Rescheduling assistant
    //   * Documentation

- [ ] Agent performance monitoring
    // Comprehensive agent evaluation system:
    // - Performance metrics:
    //   * Class completion rates
    //   * Learner success rates
    //   * Attendance reliability
    //   * Documentation compliance
    //   * Client feedback scores
    // - Quality indicators:
    //   * Teaching effectiveness
    //   * Material utilization
    //   * Assessment quality
    //   * Portfolio management
    //   * Administrative compliance
    // - Tracking elements:
    //   * Classes handled
    //   * Hours delivered
    //   * Learner progression
    //   * Support provided
    //   * Professional development
    // - Evaluation components:
    //   * Regular assessments
    //   * Peer reviews
    //   * Client feedback
    //   * Learner surveys
    //   * Self-evaluation
    // - Reporting features:
    //   * Individual performance reports
    //   * Comparative analysis
    //   * Trend identification
    //   * Development needs
    //   * Recognition opportunities

/*
Global Reporting Requirements:
- Real-time data updates
- Mobile-responsive interfaces
- Export functionality:
  * PDF reports
  * Excel spreadsheets
  * CSV data exports
  * API integration capability
- Customizable dashboards:
  * Role-based views
  * Configurable metrics
  * Custom report builders
  * Saved report templates
- Security features:
  * Role-based access
  * Data encryption
  * Audit logging
  * Backup systems
- Integration capabilities:
  * WordPress core
  * External systems
  * Email notifications
  * SMS alerts
*/

## 9. Data Structure Updates
- [ ] Class type hierarchies
    // Database structure for class types:
    // - Primary tables:
    //   * class_types
    //     - id (PRIMARY KEY)
    //     - code (VARCHAR) // e.g., AETC, GETC, REALLL
    //     - name (VARCHAR)
    //     - parent_id (FK to class_types)
    //     - duration_hours (INT)
    //     - is_active (BOOLEAN)
    //     - created_at (TIMESTAMP)
    //     - updated_at (TIMESTAMP)
    //   * class_modules
    //     - id (PRIMARY KEY)
    //     - class_type_id (FK)
    //     - code (VARCHAR) // e.g., LP19, 1.2
    //     - name (VARCHAR)
    //     - sequence_order (INT)
    //     - duration_hours (INT)
    //   * class_prerequisites
    //     - id (PRIMARY KEY)
    //     - module_id (FK)
    //     - prerequisite_id (FK)
    // - Relationships:
    //   * One-to-many: class_types to modules
    //   * Self-referential: class_types hierarchy
    //   * Many-to-many: module prerequisites

- [ ] Duration mappings
    // Duration calculation system:
    // - Core tables:
    //   * duration_templates
    //     - id (PRIMARY KEY)
    //     - name (VARCHAR)
    //     - total_hours (INT)
    //     - default_session_hours (DECIMAL)
    //     - frequency_type (ENUM) // daily, weekly, monthly
    //     - custom_pattern (JSON)
    //   * class_schedules
    //     - id (PRIMARY KEY)
    //     - class_id (FK)
    //     - template_id (FK)
    //     - start_date (DATE)
    //     - end_date (DATE)
    //     - actual_hours (DECIMAL)
    //     - remaining_hours (DECIMAL)
    // - Calculations:
    //   * Automatic end date based on hours/frequency
    //   * Progress tracking
    //   * Schedule adjustments
    //   * Exception handling

- [ ] Event type categorization
    // Event management structure:
    // - Primary tables:
    //   * event_categories
    //     - id (PRIMARY KEY)
    //     - name (VARCHAR)
    //     - color_code (VARCHAR)
    //     - icon_class (VARCHAR)
    //     - is_system (BOOLEAN)
    //   * event_types
    //     - id (PRIMARY KEY)
    //     - category_id (FK)
    //     - name (VARCHAR)
    //     - requires_approval (BOOLEAN)
    //     - notification_template (TEXT)
    //   * events
    //     - id (PRIMARY KEY)
    //     - type_id (FK)
    //     - class_id (FK)
    //     - start_datetime (TIMESTAMP)
    //     - end_datetime (TIMESTAMP)
    //     - status (ENUM)
    //     - metadata (JSON)
    // - Event categories:
    //   * Class sessions
    //   * Examinations
    //   * Deliveries
    //   * Collections
    //   * Absences
    //   * Cancellations

- [ ] Learner status tracking
    // Learner management structure:
    // - Core tables:
    //   * learners
    //     - id (PRIMARY KEY)
    //     - external_id (VARCHAR)
    //     - first_name (VARCHAR)
    //     - last_name (VARCHAR)
    //     - contact_details (JSON)
    //     - current_status (ENUM)
    //     - created_at (TIMESTAMP)
    //   * learner_class_enrollments
    //     - id (PRIMARY KEY)
    //     - learner_id (FK)
    //     - class_id (FK)
    //     - status (ENUM) // CIC, RBE, DRO
    //     - enrollment_date (DATE)
    //     - completion_date (DATE)
    //   * learner_progress
    //     - id (PRIMARY KEY)
    //     - enrollment_id (FK)
    //     - module_id (FK)
    //     - status (ENUM)
    //     - completion_percentage (DECIMAL)
    //     - last_activity (TIMESTAMP)
    // - Status history:
    //   * Track all status changes
    //   * Record reason for changes
    //   * Maintain audit trail

- [ ] Agent assignment structure
    // Agent management system:
    // - Primary tables:
    //   * agents
    //     - id (PRIMARY KEY)
    //     - external_id (VARCHAR)
    //     - first_name (VARCHAR)
    //     - last_name (VARCHAR)
    //     - qualifications (JSON)
    //     - availability (JSON)
    //     - status (ENUM)
    //   * agent_assignments
    //     - id (PRIMARY KEY)
    //     - agent_id (FK)
    //     - class_id (FK)
    //     - order_number (VARCHAR)
    //     - role_type (ENUM) // primary, backup
    //     - start_date (DATE)
    //     - end_date (DATE)
    //   * agent_availability
    //     - id (PRIMARY KEY)
    //     - agent_id (FK)
    //     - date (DATE)
    //     - status (ENUM)
    //     - reason (VARCHAR)
    // - Assignment rules:
    //   * Order number generation
    //   * Qualification matching
    //   * Schedule conflicts
    //   * Geographic constraints

/*
Global Data Structure Requirements:
- Database compatibility:
  * MySQL 5.7+
  * PostgreSQL 12+
- Indexing strategy:
  * Primary keys
  * Foreign keys
  * Common search fields
  * Composite indexes
- Data integrity:
  * Foreign key constraints
  * Unique constraints
  * Check constraints
  * Default values
- Performance optimization:
  * Proper data types
  * Normalized structure
  * Efficient queries
  * Caching strategy
- Security measures:
  * Encryption at rest
  * Access control
  * Audit logging
  * Backup procedures
*/

## 10. Validation & Error Handling
- [ ] Form validation per section
- [ ] Date conflict detection
- [ ] Schedule validation
- [ ] Learner assignment validation
- [ ] Agent availability checking

## Priority Order

1. Complete WEC-39 (Color Profile Update) - TODO
   - Critical updates needed for color scheme
   - Subtasks:
     * Update CSS root variables with new color values
     * Update UI elements to use new color scheme
     * Update calendar styling with new colors
   - Files affected: `includes/css/ydcoza-styles.css`
   - Priority: Medium
   - Current status: In Progress

2. Implement WEC-25 (Exception Date Management) - TODO
   - Allow direct calendar interaction for exception dates
   - Features needed:
     * Click-to-add exception dates
     * Drag-and-drop functionality
     * Visual calendar integration
     * Exception date validation
   - Priority: Medium
   - Current status: Todo

3. Implement WEC-43 (Color Profile Update Clarification) - TODO
   - Get design requirements clarification
   - Subtasks:
     * Get clarification on design requirements
     * Implement base typography changes
     * Update form styling
     * Implement button styling
     * Update heading margins
     * Implement icon color system
   - Priority: Medium
   - Current status: Todo

/*
Notes:
- WEC-38 (Tabbed Interface) has been cancelled
- WEC-31 (Stepped Workflow) has been cancelled
- Focus should be on completing WEC-39 first
- Exception date management (WEC-25) remains high priority
- New task WEC-43 added for additional color profile updates
*/
