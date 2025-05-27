# ClassModel Documentation

## Model Overview

The `ClassModel` is a core component of the WeCoza 3 Child Theme's MVC architecture, responsible for managing training class/session data within the assessment system.

**Namespace**: `WeCoza\Models\Assessment`
**File Location**: `app/Models/Assessment/ClassModel.php`
**Purpose**: Handles CRUD operations, validation, and business logic for training classes including scheduling, learner management, and exam coordination.

## Database Schema

### Primary Table: `wecoza_classes`
```sql
CREATE TABLE wecoza_classes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    site_id INT NOT NULL,
    site_address VARCHAR(255),
    class_type VARCHAR(50) NOT NULL,
    class_subject VARCHAR(50) NOT NULL,
    class_code VARCHAR(50) NOT NULL,
    class_duration INT,
    class_start_date DATE NOT NULL,
    seta_funded ENUM('Yes', 'No') NOT NULL,
    seta_id INT,
    exam_class ENUM('Yes', 'No') NOT NULL,
    exam_type VARCHAR(100),
    qa_visit_dates TEXT,
    class_agent INT NOT NULL,
    project_supervisor INT NOT NULL,
    delivery_date DATE NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Related Tables

#### `wecoza_class_schedule`
- **Relationship**: One-to-Many with `wecoza_classes`
- **Purpose**: Stores recurring schedule patterns and individual session data
- **Key Fields**: `class_id`, `day`, `date`, `start_time`, `end_time`, `notes`, `type`

#### `wecoza_class_dates`
- **Relationship**: One-to-Many with `wecoza_classes`
- **Purpose**: Tracks stop and restart dates for classes
- **Key Fields**: `class_id`, `stop_date`, `restart_date`

#### `wecoza_class_learners`
- **Relationship**: Many-to-Many between `wecoza_classes` and learners
- **Purpose**: Associates learners with specific classes
- **Key Fields**: `class_id`, `learner_id`

#### `wecoza_class_backup_agents`
- **Relationship**: Many-to-Many between `wecoza_classes` and agents
- **Purpose**: Manages backup agent assignments
- **Key Fields**: `class_id`, `agent_id`

#### `wecoza_class_notes`
- **Relationship**: Many-to-Many between `wecoza_classes` and notes
- **Purpose**: Links operational notes to classes
- **Key Fields**: `class_id`, `note_id`

## Properties & Methods

### Core Properties
```php
private $id;                    // Primary key
private $clientId;              // Client reference
private $siteId;                // Site reference
private $siteAddress;           // Site address string
private $classType;             // Class type/category
private $classSubject;          // Specific subject/module
private $classCode;             // Auto-generated class code
private $classDuration;         // Duration in hours
private $classStartDate;        // Original start date
private $classNotes = [];       // Array of note IDs
private $setaFunded;            // SETA funding status
private $setaId;                // SETA reference
private $examClass;             // Exam class flag
private $examType;              // Type of exam
private $qaVisitDates;          // QA visit scheduling
private $classAgent;            // Primary agent ID
private $projectSupervisor;     // Supervisor ID
private $learnerIds = [];       // Array of learner IDs
private $deliveryDate;          // Expected delivery date
private $backupAgentIds = [];   // Array of backup agent IDs
private $scheduleData = [];     // Schedule configuration
private $stopDates = [];        // Array of stop dates
private $restartDates = [];     // Array of restart dates
private $createdAt;             // Creation timestamp
private $updatedAt;             // Last update timestamp
```

### Public Methods

#### Static Methods
- `getById($id)` - Retrieve class by ID with all related data
- `validate($data)` - Validate class data against rules
- `getValidationRules()` - Get complete validation schema

#### Instance Methods
- `save()` - Create new class record with related data
- `update()` - Update existing class record
- `delete()` - Delete class and all related data
- `hydrate($data)` - Populate model from array data

#### Getter/Setter Methods
Complete getter/setter pairs for all properties following camelCase convention.

## Dependencies

### Required Services
- **`WeCoza\Services\Database\DatabaseService`** - Database operations
- **`WeCoza\Services\Validation\ValidationService`** - Form validation

### Related Models
- **`WeCoza\Models\Learner\LearnerModel`** - Learner data (referenced via learner_ids)
- **Agent Models** - Agent data (referenced via class_agent, backup_agent_ids)
- **Client Models** - Client data (referenced via client_id)

## Usage Examples

### Creating a New Class
```php
use WeCoza\Models\Assessment\ClassModel;

$classData = [
    'client_id' => 1,
    'site_id' => 1,
    'class_type' => 'Safety Training',
    'class_subject' => 'First Aid Level 1',
    'class_start_date' => '2024-02-01',
    'seta_funded' => 'Yes',
    'seta_id' => 1,
    'exam_class' => 'Yes',
    'exam_type' => 'Practical Assessment',
    'class_agent' => 5,
    'project_supervisor' => 3,
    'delivery_date' => '2024-02-15',
    'learner_ids' => [10, 11, 12],
    'backup_agent_ids' => [6, 7]
];

$class = new ClassModel($classData);
if ($class->save()) {
    echo "Class created successfully with ID: " . $class->getId();
}
```

### Reading Class Data
```php
$class = ClassModel::getById(1);
if ($class) {
    echo "Class: " . $class->getClassSubject();
    echo "Start Date: " . $class->getClassStartDate();
    echo "Learners: " . count($class->getLearnerIds());
}
```

### Updating a Class
```php
$class = ClassModel::getById(1);
if ($class) {
    $class->setDeliveryDate('2024-02-20');
    $class->setClassAgent(8);

    if ($class->update()) {
        echo "Class updated successfully";
    }
}
```

### Validation Example
```php
$validator = ClassModel::validate($formData);
if (!$validator->isValid()) {
    $errors = $validator->getErrors();
    foreach ($errors as $field => $error) {
        echo "Error in {$field}: {$error}";
    }
}
```

## Validation Rules

### Required Fields
- `client_id` - Must be numeric
- `site_id` - Must be numeric
- `class_type` - Required string
- `class_subject` - Required string
- `class_code` - Required string
- `class_start_date` - Required valid date
- `seta_funded` - Must be 'Yes' or 'No'
- `exam_class` - Must be 'Yes' or 'No'
- `class_agent` - Must be numeric
- `project_supervisor` - Must be numeric
- `delivery_date` - Required valid date
- `add_learner` - Required array (at least one learner)
- `backup_agent` - Required array

### Conditional Requirements
- `seta_id` - Required when `seta_funded` = 'Yes'
- `exam_type` - Required when `exam_class` = 'Yes'

### Custom Validation
- Schedule start date cannot be before class original start date
- Exception dates must be within schedule date range
- Holiday overrides must have valid date formats

## File Dependencies

### Controllers
- **`app/Controllers/ClassController.php`** - Primary controller for class operations
- **`app/Controllers/ClassTypesController.php`** - Provides class type/subject data
- **`app/Controllers/PublicHolidaysController.php`** - Holiday data for scheduling

### Views
- **`app/Views/components/class-capture-form.view.php`** - Main form view
- **`app/Views/components/class-capture-partials/`** - Form partial components:
  - `basic-details.php` - Client/site selection
  - `class-info.php` - Class type/subject/dates
  - `class-schedule-form.php` - Schedule management
  - `funding-exam-details.php` - SETA/exam information
  - `class-learners.php` - Learner management
  - `exam-learners.php` - Exam learner selection
  - `class-notes-qa.php` - Notes and QA visits
  - `assignments-dates.php` - Agent assignments
  - `date-history.php` - Stop/restart dates
  - `export-options.php` - Calendar export

### JavaScript Files
- **`public/js/class-capture.js`** - Main form functionality
- **`public/js/class-schedule-form.js`** - Schedule-specific logic
- **`assets/js/class-types.js`** - Class type/subject management

### CSS Files
- **`includes/css/ydcoza-styles.css`** - Class form styling and calendar styles

### Services
- **`app/Services/Export/CalendarExportService.php`** - Calendar export functionality

## AJAX Integration

### WordPress AJAX Actions
- **`save_class`** - Saves ClassModel data via AJAX
- **`check_class_conflicts`** - Validates schedule conflicts
- **`export_calendar`** - Exports class calendar to iCal format
- **`get_class_subjects`** - Retrieves subjects for selected class type

### AJAX Handlers Location
- **`app/ajax-handlers.php`** - Registers all class-related AJAX endpoints

### JavaScript AJAX Usage
```javascript
// Save class data
$.ajax({
    url: wecozaClass.ajaxUrl,
    type: 'POST',
    data: {
        action: 'save_class',
        nonce: wecozaClass.nonce,
        // ... form data
    },
    success: function(response) {
        // Handle success
    }
});
```

## Database Migrations

### Migration Files
- **`includes/db/migrations/add-class-subject-fields.php`**
  - Adds `class_subject`, `class_code`, `class_duration` columns to `wecoza_classes`
  - Executed automatically on theme activation

### Migration System
- **`includes/db-migrations.php`** - Migration management system
- **`functions.php`** - Loads migrations during theme initialization

### Manual Migration Execution
```php
// Run specific migration
require_once WECOZA_CHILD_DIR . '/includes/db/migrations/add-class-subject-fields.php';
```

## WordPress Integration

### Shortcodes

#### Class Form Shortcodes
- **`[wecoza_capture_class]`** - Enhanced form with mode detection via URL parameters
  - `?mode=create` - Create mode (default)
  - `?mode=update&class_id=123` - Update mode with specific class
- **`[wecoza_create_class]`** - Dedicated create form (always create mode)
- **`[wecoza_update_class]`** - Dedicated update form (always update mode)
  - `class_id="123"` attribute or `?class_id=123` URL parameter

#### Class Display Shortcodes
- **`[wecoza_display_class class_id="1"]`** - Displays specific class information

#### Usage Examples
```html
<!-- Create-only page -->
[wecoza_create_class redirect_url="/success/"]

<!-- Update-only page -->
[wecoza_update_class]
<!-- Use with URL: ?class_id=123 -->

<!-- Flexible page (backward compatible) -->
[wecoza_capture_class]
<!-- Use with URLs:
     /page/ - Create mode
     /page/?mode=update&class_id=123 - Update mode
-->
```

### Hooks & Filters
- **`wp_enqueue_scripts`** - Enqueues class-related assets
- **`init`** - Registers shortcodes and AJAX handlers

### Asset Management
Assets are automatically enqueued when class-related shortcodes are used:
- CSS: Bootstrap 5, FullCalendar, custom styles
- JavaScript: jQuery, FullCalendar, form validation, AJAX handlers

## Development Notes

### MVC Architecture
The ClassModel follows strict MVC principles:
- **Model**: Handles data and business logic only
- **View**: Presentation layer in separate view files
- **Controller**: Coordinates between model and view

### Error Handling
- Database errors are logged via `error_log()`
- Transactions are used for data integrity
- Validation errors are returned to the frontend

### Performance Considerations
- Related data is loaded lazily via separate methods
- Database queries use prepared statements
- Transactions ensure data consistency

### Security
- All inputs are validated and sanitized
- WordPress nonces are used for AJAX requests
- Database queries use parameter binding

## Future Enhancements

### Planned Features
- Class scheduling conflict detection
- Advanced reporting capabilities
- Integration with external calendar systems
- Automated notifications for class events

### Extension Points
- Custom validation rules can be added to `getValidationRules()`
- Additional related tables can be managed via new load/save methods
- Export formats can be extended in `CalendarExportService`

---

**Last Updated**: May 24 2025
**Version**: 1.0
**Maintainer**: WeCoza Development Team
