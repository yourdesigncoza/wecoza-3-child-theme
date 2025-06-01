# WeCoza Display Single Class Shortcode

## Overview

The `[wecoza_display_single_class]` shortcode displays detailed information for a single class from the database in a clean, Bootstrap 5 compatible format. It follows the WeCoza naming convention and MVC architecture pattern.

## Usage

### Basic Usage
```
[wecoza_display_single_class class_id="25"]
```

### With Parameters
```
[wecoza_display_single_class class_id="25" show_loading="false"]
```

## Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `class_id` | integer | **Required** | The ID of the class to display |
| `show_loading` | boolean | `true` | Whether to show loading animation |

### Parameter Details

#### class_id (Required)
- **Type**: Integer
- **Required**: Yes
- **Description**: The unique class ID from the database
- **Example**: `class_id="25"`
- **Validation**: Must be a positive integer

#### show_loading
- **Type**: Boolean
- **Default**: `true`
- **Description**: Controls whether to show a loading spinner before displaying content
- **Values**: `true`, `false`, `1`, `0`
- **Example**: `show_loading="false"`

## Features

### Comprehensive Class Information
- **Basic Details**: Class ID, code, subject, type, duration, address
- **Dates & Schedule**: Start date, delivery date, creation/update timestamps, QA visit dates
- **Client & Staff**: Client information, assigned agent, project supervisor
- **SETA & Exam**: SETA funding status, exam class designation, exam type

### Bootstrap 5 Styling
- Responsive card-based layout
- Clean table presentation with striped rows
- Color-coded badges for status indicators
- Bootstrap Icons for visual enhancement
- Mobile-friendly responsive design

### Error Handling
- Invalid class_id parameter validation
- Class not found error messages
- Database connection error handling
- User-friendly error displays

## Implementation Details

### MVC Architecture
- **Controller**: `WeCoza\Controllers\ClassController::displaySingleClassShortcode()`
- **View**: `app/Views/components/single-class-display.view.php`
- **Model**: Uses `WeCoza\Services\Database\DatabaseService` for data access

### Database Query
The shortcode queries the PostgreSQL database using:
- Main table: `public.classes`
- Joined tables: `public.clients`, `public.agents`, `public.users`
- Includes proper LEFT JOINs to handle missing related data
- Parameterized query to prevent SQL injection

### Security Features
- SQL injection prevention through parameterized queries
- Input validation for class_id parameter
- Proper data sanitization and escaping
- WordPress capability checks for debug information

## Styling

The shortcode uses Bootstrap 5 classes and custom WeCoza styling:

### CSS Classes Used
- `card`, `card-header`, `card-body` - Card layout structure
- `table`, `table-striped`, `table-hover` - Table styling
- `badge`, `badge-phoenix` - Status indicators
- `alert` - Error and warning messages
- `spinner-border` - Loading animation

### Color Scheme
- **Primary**: Blue for headers and main elements
- **Success**: Green for positive status (SETA funded)
- **Warning**: Orange for exam classes
- **Secondary**: Gray for neutral status
- **Danger**: Red for error messages

## Examples

### Simple Display
```html
<!-- In a WordPress post or page -->
[wecoza_display_single_class class_id="25"]
```

### Without Loading Animation
```html
<!-- Display class immediately without loading spinner -->
[wecoza_display_single_class class_id="25" show_loading="false"]
```

### In PHP Template
```php
// In a WordPress theme template
echo do_shortcode('[wecoza_display_single_class class_id="' . $class_id . '"]');
```

## Error States

### Invalid Class ID
Displays a warning alert when:
- No class_id parameter provided
- class_id is not a valid integer
- class_id is zero or negative

### Class Not Found
Shows an informative message when the specified class_id doesn't exist in the database.

### Database Connection Error
Displays a user-friendly error message if the database connection fails.

## Integration

### WordPress Integration
- Automatically registered via `ClassController::registerShortcodes()`
- Uses WordPress shortcode API
- Compatible with WordPress posts, pages, and widgets
- Follows WordPress coding standards

### Theme Integration
- Uses existing WeCoza styling from `ydcoza-styles.css`
- Compatible with Bootstrap 5 themes
- Responsive design works with all screen sizes
- No additional CSS dependencies required

## Technical Notes

### Performance
- Single database query with optimized JOINs
- Minimal resource usage
- Cached database connection
- Efficient data processing

### Compatibility
- WordPress 5.0+
- PHP 7.4+
- PostgreSQL database
- Bootstrap 5.x
- Modern browsers

### Debugging
- Detailed error logging for administrators
- Debug mode shows technical error details
- Production mode shows user-friendly messages
- Error logging to WordPress debug.log

## Related Shortcodes

- `[wecoza_display_classes]` - Display all classes in a table
- `[wecoza_capture_class]` - Create/edit class form

## Support

For technical support or feature requests, contact the WeCoza development team.
