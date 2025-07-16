# AJAX Handlers Analysis for Agents

## Investigation Results from Subtask 1.3

### AJAX Handlers in ajax-handlers.php

**No agent-related AJAX handlers found** in `/app/ajax-handlers.php`

The file contains only:
- Learner AJAX handlers (`wecoza_save_learner`)
- Contact form AJAX handler (`wecoza_save_contact`)
- Shortcode registration (not AJAX-related)

### Agent Form Processing Method

The agent functionality uses **traditional form submission**, not AJAX:

1. **Agent Capture Form** (`agents-capture-shortcode.php`):
   - Uses standard HTML form with `method="POST"`
   - Form ID: `agents-form`
   - Processes data on same page after POST submission
   - Uses two nonces for security:
     - `wecoza_agents_form_nonce` (action: `submit_learners_form`)
     - `agent_form_nonce` (action: `save_agent_data`)

2. **Form Submission Flow**:
   - Client-side validation using Bootstrap 5 (`needs-validation` class)
   - JavaScript validation for SA ID and Passport numbers
   - Server-side processing on form POST
   - No AJAX calls detected

### JavaScript Analysis (`agents-app.js`)

The JavaScript file contains:
- **No AJAX functionality**
- **No fetch() or XMLHttpRequest calls**
- **No jQuery AJAX methods** ($.ajax, $.post, $.get)

Key JavaScript features:
1. Bootstrap form validation
2. SA ID and Passport number validation
3. Dynamic field toggling (SA ID vs Passport)
4. Select2 initialization for dropdown fields
5. Conditional field display (signed agreement fields)

### Localized Script Data

From `agents-functions.php`, the following data is available to JavaScript:
```javascript
agents_nonce = {
    ajax_url: 'admin-ajax.php URL',
    nonce: 'agents_nonce value',
    uploads_url: 'WordPress uploads directory URL',
    is_admin: true/false
}
```

**Note**: Despite having `ajax_url` localized, it's not currently used in the JavaScript code.

### Database Operations

Agent data handling appears to be server-side only:
- Uses `learner_DB` class for database operations
- No AJAX endpoints for CRUD operations
- All database interactions happen during page load/POST

### Comments in Code

Line 19-23 in `agents-capture-shortcode.php` has commented code:
```php
// Below calls are now called via Ajax
// $locations = $db->get_locations();
// $qualifications = $db->get_qualifications();
// $employers = $db->get_employers();
// $placement_levels = $db->get_placement_level();
```

This suggests these methods **might** be called via AJAX elsewhere, but no corresponding AJAX handlers were found.

### Migration Implications

1. **No AJAX handlers to migrate** - simplifies plugin development
2. **Form processing stays server-side** - maintain POST handling
3. **Localized data structure** should be preserved for future AJAX implementation
4. **Consider adding AJAX** in the plugin for better UX:
   - Form submission without page reload
   - Dynamic data loading for dropdowns
   - Real-time validation feedback

### Recommendations

1. The plugin can maintain the current non-AJAX approach initially
2. The localized `ajax_url` and `nonce` suggest AJAX was planned but not implemented
3. Future enhancement: Add AJAX handlers for:
   - Form submission
   - Dynamic dropdown population
   - Search/filter operations in the display table