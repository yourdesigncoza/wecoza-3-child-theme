# WeCoza Display Classes Shortcode

## Overview

The `[wecoza_display_classes]` shortcode displays all classes from the database in a clean, Bootstrap 5 compatible format. It follows the WeCoza naming convention and MVC architecture pattern.

## Usage

### Basic Usage
```
[wecoza_display_classes]
```

### With Parameters
```
[wecoza_display_classes limit="25" order_by="class_subject" order="ASC" show_loading="false"]
```

## Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `limit` | integer | 50 | Maximum number of classes to display |
| `order_by` | string | 'created_at' | Column to sort by |
| `order` | string | 'DESC' | Sort direction (ASC or DESC) |
| `show_loading` | boolean | true | Whether to show loading indicator |

### Valid `order_by` Values
- `class_id`
- `client_id`
- `class_type`
- `class_subject`
- `original_start_date`
- `delivery_date`
- `created_at`
- `updated_at`

## Features

### Display Features
- **Bootstrap 5 Compatible**: Uses Bootstrap 5 classes for responsive design
- **Loading Indicator**: Shows "Loading classes..." message while data loads
- **Responsive Table**: Displays class information in a clean table format
- **Summary Cards**: Shows statistics about total classes, SETA funded, exam classes, and unique clients
- **Action Buttons**: Provides edit, view, and delete options for each class

### Data Displayed
- Class ID
- Client name and site
- Class type and subject
- Start date and delivery date
- Assigned agent
- SETA funding status
- Action buttons

### Error Handling
- Graceful error handling with user-friendly messages
- Database connection error handling
- Empty state handling when no classes are found

## Implementation Details

### MVC Architecture
- **Controller**: `WeCoza\Controllers\ClassController::displayClassesShortcode()`
- **View**: `app/Views/components/classes-display.view.php`
- **Model**: Uses `WeCoza\Services\Database\DatabaseService` for data access

### Database Query
The shortcode queries the PostgreSQL database using:
- Main table: `public.classes`
- Joined tables: `public.clients`, `public.sites`, `public.agents`, `public.users`
- Includes proper LEFT JOINs to handle missing related data

### Security Features
- SQL injection prevention through parameterized queries
- Input validation for all parameters
- Proper data sanitization and escaping

## Styling

### Custom CSS Classes
- `.wecoza-classes-display` - Main container
- Custom table styling for enhanced appearance
- Bootstrap 5 badge and card components
- Responsive design considerations

### Icons
Uses Bootstrap Icons for:
- Loading spinner
- Table headers
- Action buttons
- Summary cards

## JavaScript Functionality

### Interactive Features
- Refresh button to reload the page
- Export placeholder functionality
- View details modal (placeholder)
- Delete confirmation dialog (placeholder)
- Auto-hide loading indicator

### Future Enhancements
- AJAX-based refresh without page reload
- Export to CSV/PDF functionality
- Inline editing capabilities
- Advanced filtering and search

## Examples

### Simple Display
```html
<!-- In a WordPress post or page -->
[wecoza_display_classes]
```

### Limited Results
```html
<!-- Show only 10 most recent classes -->
[wecoza_display_classes limit="10" order_by="created_at" order="DESC"]
```

### Alphabetical by Subject
```html
<!-- Show classes sorted by subject alphabetically -->
[wecoza_display_classes order_by="class_subject" order="ASC" show_loading="false"]
```

## Error States

### No Classes Found
Displays an informative alert with Bootstrap styling when no classes exist in the database.

### Database Connection Error
Shows a user-friendly error message if the database connection fails.

### Invalid Parameters
Automatically falls back to safe defaults for invalid parameter values.

## Integration

### WordPress Integration
- Registered as a WordPress shortcode
- Compatible with posts, pages, and widgets
- Follows WordPress coding standards

### Theme Integration
- Uses existing theme Bootstrap 5 framework
- Inherits theme styling and responsive behavior
- Compatible with WeCoza child theme structure

## Testing

A test file is available at `test-display-classes.php` for development and debugging purposes.

## Support

For issues or feature requests related to this shortcode, please refer to the WeCoza development documentation or contact the development team.
