# WeCoza Shortcode List Documentation

## Overview

The `[wecoza_shortcode_list]` shortcode provides a comprehensive, self-documenting list of all available WeCoza shortcodes in the system. It follows the WeCoza naming convention and MVC architecture pattern, serving as both a reference tool for developers and a documentation system for end users.

## Usage

### Basic Usage
```
[wecoza_shortcode_list]
```

### With Parameters
```
[wecoza_shortcode_list show_loading="false" category="all"]
```

## Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `show_loading` | boolean | `true` | Whether to show loading animation |
| `category` | string | `all` | Filter by category (future enhancement) |

### Parameter Details

#### show_loading
- **Type**: Boolean (accepts "true"/"false" as strings)
- **Default**: `true`
- **Description**: Controls whether a loading spinner is displayed while the shortcode content loads

#### category
- **Type**: String
- **Default**: `all`
- **Description**: Future enhancement for filtering shortcodes by category (Class Management, Reporting, etc.)

## Features

### Comprehensive Documentation
- **Complete Shortcode List**: Displays all available WeCoza shortcodes with detailed information
- **Categorized Display**: Groups shortcodes by functional category for better organization
- **Usage Examples**: Shows exact syntax and parameter examples for each shortcode
- **Parameter Information**: Details available parameters and their usage patterns
- **Input Type Indicators**: Shows whether shortcodes accept URL parameters, attributes, or are static

### Bootstrap 5 Styling
- Responsive card-based layout with header and body sections
- Clean table presentation with hover effects and proper spacing
- Color-coded badges for categories and parameter types
- Bootstrap Icons for visual enhancement and improved UX
- Mobile-friendly responsive design that works on all screen sizes

### Interactive Features
- Refresh button to reload the shortcode list
- Print functionality for creating physical documentation
- Auto-hide loading indicator with smooth transitions
- Summary statistics showing total counts and categorization

## Implementation Details

### MVC Architecture
- **Controller**: `WeCoza\Controllers\ShortcodeListController`
- **View**: `app/Views/components/shortcode-list.view.php`
- **Registration**: Automatically registered via config/app.php and ajax-handlers.php

### Data Structure
Each shortcode entry contains:
- `name`: The shortcode name (e.g., 'wecoza_capture_class')
- `category`: Functional category (e.g., 'Class Management', 'Reporting')
- `description`: Brief description of functionality
- `usage`: Example usage with parameters
- `parameters`: List of available parameters
- `controller`: Controller class handling the shortcode
- `view`: View file path for the shortcode
- `url_params`: Boolean indicating if shortcode accepts URL parameters
- `shortcode_attrs`: Boolean indicating if shortcode accepts shortcode attributes

### Security Features
- All output is properly escaped using esc_html()
- No user input processing in the view
- Read-only display of static shortcode information
- Follows WordPress security best practices

## Styling

The shortcode uses Bootstrap 5 classes and custom WeCoza styling:

### CSS Classes Used
- `card`, `card-header`, `card-body` - Card layout structure
- `table`, `table-hover`, `table-sm` - Table styling with hover effects
- `badge` with various color variants - Category and type indicators
- `alert` - Informational messages and instructions
- `spinner-border` - Loading animation

### Custom CSS Classes
- `.wecoza-shortcode-list` - Main container class
- `.category-section` - Individual category sections
- `.ydcoza-table-subheader` - Category headers within tables

### Color Scheme
- **Primary**: Blue for main headers and primary actions
- **Success**: Green for MVC architecture indicators
- **Info**: Blue for category counts and informational elements
- **Warning**: Orange for URL parameter support indicators
- **Secondary**: Gray for neutral elements and static shortcodes

## Categories

The shortcodes are organized into the following categories:

### Class Management
- Class capture, display, and management shortcodes
- Single class detail views with calendar integration

### Client Management
- Client capture and display functionality
- Client information management

### Agent Management
- Agent capture, display, and management
- Agent information with modal details

### Learner Management
- Learner capture, display, and update functionality
- Learner information management with modal views

### Reporting
- Outstanding deliveries and analytics
- Status reports and data visualization

### Utilities
- Dynamic tables and data presentation tools
- General-purpose utility shortcodes

### Documentation
- Self-documenting shortcodes like this one
- Reference and help systems

## Examples

### Simple Display
```html
<!-- In a WordPress post or page -->
[wecoza_shortcode_list]
```

### Without Loading Animation
```html
<!-- Display immediately without loading spinner -->
[wecoza_shortcode_list show_loading="false"]
```

### In PHP Template
```php
// In a WordPress theme template
echo do_shortcode('[wecoza_shortcode_list]');
```

## Integration

### WordPress Integration
- Automatically registered via ShortcodeListController
- Uses WordPress shortcode API
- Compatible with posts, pages, and widgets
- Follows WordPress coding standards

### Theme Integration
- Uses existing WeCoza styling from `ydcoza-styles.css`
- Compatible with Bootstrap 5 themes
- Responsive design works with all screen sizes
- No additional CSS dependencies required

## Technical Notes

### Performance
- Static data generation with no database queries
- Minimal resource usage
- Efficient rendering with output buffering
- Fast loading with optional loading indicator

### Compatibility
- WordPress 5.0+
- PHP 7.4+
- Bootstrap 5.x
- Modern browsers with JavaScript support

### Maintenance
- Self-updating: Add new shortcodes to the getAllShortcodes() method
- Centralized documentation in the controller
- Easy to extend with additional categories or features

## Future Enhancements

### Planned Features
- Category filtering functionality
- Search capability within shortcodes
- Export to PDF/print-friendly format
- Interactive testing of shortcodes
- Version history and changelog integration

### Extensibility
- Plugin architecture for additional shortcode sources
- Custom category definitions
- User-specific shortcode visibility
- Integration with WordPress plugin shortcodes

## Related Shortcodes

This shortcode documents all other WeCoza shortcodes, making it a central reference point for:
- `[wecoza_capture_class]` - Class management forms
- `[wecoza_display_classes]` - Class listing tables
- `[wecoza_display_single_class]` - Individual class details
- All other WeCoza shortcodes in the system

## Support

For technical support, feature requests, or questions about this shortcode:
- Contact the WeCoza development team
- Refer to the WeCoza development documentation
- Check the GitHub repository for updates and issues

## Changelog

### Version 1.0.0
- Initial implementation with comprehensive shortcode listing
- Bootstrap 5 responsive design
- MVC architecture integration
- Category-based organization
- Interactive features (refresh, print)
- Complete documentation and examples
