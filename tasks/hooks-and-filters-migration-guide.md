# WeCoza Agents Plugin - Hooks and Filters Migration Guide

## Overview

This document details all WordPress hooks and filters that were removed from the WeCoza 3 Child Theme during the migration to the WeCoza Agents Plugin. This guide is essential for developers and users who need to understand what changed and how to adapt their code.

## Migration Date
- **Migration Started**: January 1, 2025
- **Theme Deprecation Phase**: January 1, 2025 - March 1, 2025
- **Complete Removal**: March 1, 2025

## Removed Theme Hooks and Filters

### 1. Shortcode Registration Hooks

#### Theme (REMOVED)
```php
// File: /assets/agents/agents-capture-shortcode.php
add_shortcode('wecoza_capture_agents', 'agents_capture_shortcode');

// File: /assets/agents/agents-display-shortcode.php
add_shortcode('wecoza_display_agents', 'wecoza_display_agents_shortcode');
```

#### Plugin (NEW LOCATION)
```php
// File: /includes/class-plugin.php
// Method: add_shortcodes()
add_shortcode('wecoza_capture_agents', array($this->components['capture_shortcode'], 'render'));
add_shortcode('wecoza_display_agents', array($this->components['display_shortcode'], 'render'));
```

### 2. Asset Enqueue Hooks

#### Theme (REMOVED)
```php
// File: /assets/agents/agents-functions.php
add_action('wp_enqueue_scripts', 'enqueue_agents_assets');
```

#### Plugin (NEW LOCATION)
```php
// File: /includes/class-plugin.php
// Method: define_public_hooks()
add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts'));
add_action('wp_enqueue_scripts', array($this, 'enqueue_public_styles'));
```

### 3. Functions Removed from Theme

#### Theme Functions (REMOVED)
```php
// File: /assets/agents/agents-functions.php
function load_agents_files() { ... }
function enqueue_agents_assets() { ... }
```

#### Plugin Equivalent (NEW LOCATION)
```php
// File: /includes/class-plugin.php
// Functionality moved to class methods:
private function load_dependencies() { ... }
public function enqueue_public_scripts() { ... }
public function enqueue_public_styles() { ... }
```

### 4. Asset Loading Changes

#### Theme Asset Loading (REMOVED)
```php
// File: /assets/agents/agents-functions.php
wp_enqueue_script('agents-app', WECOZA_CHILD_URL . '/assets/agents/js/agents-app.js', array('jquery'), WECOZA_PLUGIN_VERSION, true);
wp_localize_script('agents-app', 'agents_nonce', array(...));
```

#### Plugin Asset Loading (NEW LOCATION)
```php
// File: /includes/class-plugin.php
wp_enqueue_script('wecoza-agents', WECOZA_AGENTS_JS_URL . 'agents-app.js', array('jquery', 'select2'), $this->version, true);
wp_localize_script('wecoza-agents', 'agents_nonce', array(...));
```

### 5. File Include Structure Changes

#### Theme Includes (REMOVED)
```php
// File: /assets/agents/agents-functions.php
$required_files = array(
    '/assets/agents/agents-capture-shortcode.php',
    '/assets/agents/agents-display-shortcode.php'
);
foreach ($required_files as $file) {
    require_once $file;
}
```

#### Plugin Includes (NEW LOCATION)
```php
// File: /includes/class-plugin.php
// PSR-4 autoloading and structured class loading:
private function load_shortcode_classes() { ... }
private function load_helper_classes() { ... }
private function load_database_classes() { ... }
```

## New Plugin Hooks and Filters

### 1. Plugin-Specific Action Hooks

#### Initialization Hooks
```php
// Plugin fully loaded
do_action('wecoza_agents_loaded');

// Plugin initialization
do_action('wecoza_agents_init');

// Plugin upgrade
do_action('wecoza_agents_upgrade', $old_version, $new_version);
```

#### Admin Hooks
```php
// Admin menu creation
add_action('admin_menu', array($this, 'add_admin_menu'));

// Admin initialization
add_action('admin_init', array($this, 'admin_init'));

// Admin notices
add_action('admin_notices', array($this, 'display_admin_notices'));
```

### 2. Asset Loading Hooks

#### Conditional Loading
```php
// Public assets (only when shortcodes present)
add_action('wp_enqueue_scripts', array($this, 'enqueue_public_styles'));
add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts'));

// Admin assets (only on plugin pages)
add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
```

### 3. Deprecation Hooks

#### Deprecation Logging
```php
// AJAX notice dismissal
add_action('wp_ajax_wecoza_agents_dismiss_notice', array($this, 'dismiss_notice'));

// Admin script enqueue for dismissal
add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
```

## Backward Compatibility

### 1. Conditional Loading in Theme

The theme now uses conditional loading to maintain compatibility:

```php
// File: /functions.php
if (!defined('WECOZA_AGENTS_VERSION')) {
    // Load theme agent functions only if plugin is not active
    require_once WECOZA_CHILD_DIR . '/assets/agents/agents-functions.php';
}
```

### 2. Deprecation Notices

All theme files now include deprecation notices:

```php
// File: /assets/agents/agents-capture-shortcode.php
_deprecated_file( 
    basename(__FILE__), 
    '1.0.0', 
    'WeCoza Agents Plugin', 
    'This functionality has been moved to the WeCoza Agents Plugin.'
);
```

### 3. Plugin Detection

The plugin defines a constant for detection:

```php
// File: /wecoza-agents-plugin.php
if (!defined('WECOZA_AGENTS_VERSION')) {
    define('WECOZA_AGENTS_VERSION', '1.0.0');
}
```

## JavaScript Changes

### 1. Script Handle Changes

#### Theme (REMOVED)
```javascript
// Script handle: 'agents-app'
// Localization: 'agents_nonce'
```

#### Plugin (NEW)
```javascript
// Script handle: 'wecoza-agents'
// Localization: 'agents_nonce' (same variable name for compatibility)
```

### 2. Asset URL Changes

#### Theme URLs (REMOVED)
```php
WECOZA_CHILD_URL . '/assets/agents/js/agents-app.js'
```

#### Plugin URLs (NEW)
```php
WECOZA_AGENTS_JS_URL . 'agents-app.js'
```

## CSS Changes

### 1. Stylesheet Loading

#### Theme (REMOVED)
```php
// No dedicated agent CSS loading in theme
```

#### Plugin (NEW)
```php
wp_enqueue_style('wecoza-agents', WECOZA_AGENTS_CSS_URL . 'agents-extracted.css', array(), $this->version);
```

### 2. CSS Extraction

Agent-specific CSS was extracted from the theme's main stylesheet:

- **Source**: `/includes/css/ydcoza-styles.css`
- **Destination**: `/assets/css/agents-extracted.css`

## Database Changes

### 1. No Database Schema Changes

The plugin uses the existing database structure without modifications.

### 2. Database Service Migration

#### Theme (REMOVED)
```php
// File: /app/Services/Database/DatabaseService.php
```

#### Plugin (NEW)
```php
// File: /src/Database/DatabaseService.php
// Namespace: WeCoza\Agents\Database
```

## File Structure Changes

### 1. Removed Theme Files

After the migration, these files can be safely removed:

```
/assets/agents/agents-capture-shortcode.php
/assets/agents/agents-display-shortcode.php
/assets/agents/agents-functions.php
/assets/agents/js/agents-app.js
/assets/agents/agents-extracted.css
/app/Controllers/AgentController.php
```

### 2. New Plugin Structure

```
/wp-content/plugins/wecoza-agents-plugin/
├── includes/
│   ├── class-plugin.php
│   ├── class-admin-notices.php
│   ├── class-deprecation-logger.php
│   └── functions.php
├── src/
│   ├── Shortcodes/
│   ├── Database/
│   ├── Models/
│   ├── Helpers/
│   └── Forms/
├── assets/
│   ├── js/
│   └── css/
└── templates/
```

## Migration Checklist

### For Site Administrators

- [ ] Activate the WeCoza Agents Plugin
- [ ] Verify shortcodes still work: `[wecoza_capture_agents]` and `[wecoza_display_agents]`
- [ ] Check admin notices for deprecation warnings
- [ ] Remove deprecated theme files after confirmation
- [ ] Test all agent functionality thoroughly

### For Developers

- [ ] Update any custom code that referenced theme agent functions
- [ ] Replace theme asset URLs with plugin equivalents
- [ ] Update any custom hooks to use plugin actions instead
- [ ] Test theme functionality without agent components
- [ ] Verify no conflicts with other plugins

### For Future Development

- [ ] Use plugin hooks instead of theme hooks for agent functionality
- [ ] Reference plugin constants instead of theme constants
- [ ] Follow plugin's PSR-4 autoloading structure
- [ ] Use plugin's template system for customizations

## Support and Troubleshooting

### Common Issues

1. **Shortcodes not working**: Ensure plugin is activated and theme compatibility is disabled
2. **Missing assets**: Check that plugin assets are properly enqueued
3. **Database errors**: Verify database service is properly initialized
4. **Theme errors**: Ensure deprecated functions are not being called

### Debug Information

The plugin includes comprehensive logging and admin notices to help identify issues:

- Check WordPress debug logs for deprecation notices
- Review admin notices for migration guidance
- Use plugin's built-in diagnostics

## Conclusion

This migration successfully moves all agent functionality from the theme to a standalone plugin while maintaining complete backward compatibility. The phased approach ensures a smooth transition with clear deprecation warnings and comprehensive documentation.

For additional support, refer to the plugin's README.md and CHANGELOG.md files.