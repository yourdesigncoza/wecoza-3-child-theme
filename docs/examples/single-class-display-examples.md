# Single Class Display Examples

## Basic Usage Examples

### Example 1: Simple Class Display
```html
[wecoza_display_single_class class_id="25"]
```

This will display all details for class ID 25 with the default loading animation.

### Example 2: Without Loading Animation
```html
[wecoza_display_single_class class_id="25" show_loading="false"]
```

This displays the class immediately without the loading spinner.

### Example 3: In WordPress Post Content
```html
<h2>Class Details</h2>
<p>Below are the complete details for this training class:</p>

[wecoza_display_single_class class_id="25"]

<p>For more information, please contact our training coordinator.</p>
```

### Example 4: In PHP Template
```php
<?php
// In a WordPress theme template file
$class_id = get_query_var('class_id', 25); // Get from URL parameter or default to 25
echo do_shortcode('[wecoza_display_single_class class_id="' . $class_id . '"]');
?>
```

### Example 5: Dynamic Class ID from URL
```php
<?php
// Get class_id from URL parameter (?class_id=25)
$class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;

if ($class_id > 0) {
    echo do_shortcode('[wecoza_display_single_class class_id="' . $class_id . '"]');
} else {
    echo '<div class="alert alert-warning">Please provide a valid class ID.</div>';
}
?>
```

## Error Handling Examples

### Example 6: Invalid Class ID
```html
[wecoza_display_single_class class_id="invalid"]
```
**Result**: Shows warning message about invalid class ID parameter.

### Example 7: Missing Class ID
```html
[wecoza_display_single_class]
```
**Result**: Shows warning message requesting a valid class_id parameter.

### Example 8: Non-existent Class
```html
[wecoza_display_single_class class_id="99999"]
```
**Result**: Shows error message that the class was not found in the database.

## Integration Examples

### Example 9: With Custom Wrapper
```html
<div class="my-custom-class-container">
    <div class="row">
        <div class="col-12">
            <h1>Training Class Information</h1>
            [wecoza_display_single_class class_id="25"]
        </div>
    </div>
</div>
```

### Example 10: Multiple Classes on Same Page
```html
<h2>Comparison of Training Classes</h2>

<div class="row">
    <div class="col-md-6">
        <h3>Class A</h3>
        [wecoza_display_single_class class_id="25" show_loading="false"]
    </div>
    <div class="col-md-6">
        <h3>Class B</h3>
        [wecoza_display_single_class class_id="26" show_loading="false"]
    </div>
</div>
```

### Example 11: In Widget Area
```php
<?php
// In a WordPress widget or sidebar
add_action('widgets_init', function() {
    register_sidebar([
        'name' => 'Class Details Sidebar',
        'id' => 'class-details',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ]);
});

// In the widget content
echo do_shortcode('[wecoza_display_single_class class_id="25"]');
?>
```

## Advanced Usage Examples

### Example 12: Conditional Display Based on User Role
```php
<?php
if (current_user_can('view_classes')) {
    echo do_shortcode('[wecoza_display_single_class class_id="25"]');
} else {
    echo '<div class="alert alert-info">Please log in to view class details.</div>';
}
?>
```

### Example 13: With Custom CSS Styling
```html
<style>
.wecoza-single-class-display .card {
    border: 2px solid #007bff;
    border-radius: 10px;
}
.wecoza-single-class-display .card-header {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
}
</style>

[wecoza_display_single_class class_id="25"]
```

### Example 14: AJAX Loading Example
```javascript
// JavaScript to load class details dynamically
function loadClassDetails(classId) {
    const container = document.getElementById('class-details-container');
    container.innerHTML = '<div class="text-center"><div class="spinner-border"></div></div>';
    
    // This would typically be done via WordPress AJAX
    // For demonstration, we'll show the concept
    const shortcode = `[wecoza_display_single_class class_id="${classId}" show_loading="false"]`;
    
    // In a real implementation, you'd use wp_ajax actions
    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: new FormData(/* form data with shortcode */)
    })
    .then(response => response.text())
    .then(html => {
        container.innerHTML = html;
    });
}
```

## Testing Examples

### Example 15: Test Different Class Types
```html
<!-- AET Class -->
[wecoza_display_single_class class_id="1"]

<!-- Business Admin Class -->
[wecoza_display_single_class class_id="2"]

<!-- Skills Package Class -->
[wecoza_display_single_class class_id="3"]
```

### Example 16: Test Error Conditions
```html
<!-- Test invalid ID -->
[wecoza_display_single_class class_id="0"]

<!-- Test missing ID -->
[wecoza_display_single_class]

<!-- Test non-numeric ID -->
[wecoza_display_single_class class_id="abc"]
```

## Best Practices

1. **Always validate class_id** before using the shortcode
2. **Use show_loading="false"** when displaying multiple classes
3. **Wrap in custom containers** for additional styling
4. **Test error conditions** to ensure graceful handling
5. **Consider user permissions** when displaying sensitive class data

## Common Use Cases

- **Class detail pages** - Full information about a specific class
- **Student portals** - Show enrolled class details
- **Admin dashboards** - Quick class overview
- **Reports** - Include class details in generated reports
- **Email templates** - Embed class information in notifications
