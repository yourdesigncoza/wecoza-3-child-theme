# WeCoza Agents Plugin - Backwards Compatibility Layer

## Overview

The backwards compatibility layer ensures that existing code continues to work during and after the migration from theme-based to plugin-based agent functionality. This layer provides fallbacks, redirects, and compatibility shims for any breaking changes.

## Implementation Location

**File**: `/wp-content/plugins/wecoza-agents-plugin/includes/class-backwards-compatibility.php`  
**Namespace**: `WeCoza\Agents\BackwardsCompatibility`  
**Initialization**: Automatically loaded and initialized when plugin is active

## Compatibility Features

### 1. Function Fallbacks

The compatibility layer provides fallback functions for deprecated theme functions:

#### Deprecated Theme Functions
```php
// Theme functions that are now deprecated
function load_agents_files() { ... }                    // → Plugin auto-loading
function enqueue_agents_assets() { ... }                // → Plugin asset management
function agents_capture_shortcode($atts) { ... }        // → Plugin shortcode
function wecoza_display_agents_shortcode($atts) { ... } // → Plugin shortcode
```

#### Plugin Fallbacks
```php
// Automatic fallback functions created by compatibility layer
load_agents_files()                    // → logs deprecation, no action needed
enqueue_agents_assets()                // → logs deprecation, no action needed
agents_capture_shortcode($atts)        // → redirects to [wecoza_capture_agents]
wecoza_display_agents_shortcode($atts) // → redirects to [wecoza_display_agents]
```

### 2. Constant Compatibility

Ensures theme constants are available when needed:

#### Theme Constants
```php
// Constants that might be referenced by custom code
WECOZA_CHILD_DIR        // → get_stylesheet_directory()
WECOZA_CHILD_URL        // → get_stylesheet_directory_uri()
WECOZA_PLUGIN_VERSION   // → WECOZA_AGENTS_VERSION
```

#### Plugin Constants
```php
// New plugin constants
WECOZA_AGENTS_VERSION      // Plugin version
WECOZA_AGENTS_PLUGIN_DIR   // Plugin directory path
WECOZA_AGENTS_PLUGIN_URL   // Plugin URL
WECOZA_AGENTS_SRC_DIR      // Source directory path
WECOZA_AGENTS_JS_URL       // JavaScript URL
WECOZA_AGENTS_CSS_URL      // CSS URL
```

### 3. Hook Compatibility

Maps old theme hooks to new plugin hooks:

#### Hook Mappings
```php
// Old theme hooks → New plugin hooks
'wecoza_theme_agents_loaded'          → 'wecoza_agents_loaded'
'wecoza_theme_agents_init'            → 'wecoza_agents_init'
'wecoza_theme_agents_assets_enqueued' → 'wecoza_agents_assets_enqueued'
```

#### Usage Example
```php
// Old code (still works)
add_action('wecoza_theme_agents_loaded', 'my_custom_function');

// New code (recommended)
add_action('wecoza_agents_loaded', 'my_custom_function');
```

### 4. Asset URL Compatibility

Handles asset URL redirects and compatibility:

#### Asset Redirects
```php
// Theme asset URL → Plugin asset URL
'/assets/agents/js/agents-app.js'     → '/assets/js/agents-app.js'
'/assets/agents/css/agents-style.css' → '/assets/css/agents-extracted.css'
```

#### Script Handle Compatibility
```php
// Theme script handle → Plugin script handle
'agents-app' → 'wecoza-agents'
```

### 5. Database Compatibility

Provides database service compatibility:

#### Legacy Database Access
```php
// Legacy database class still available
$db = new learner_DB();

// Plugin database service
$plugin = Plugin::get_instance();
$db_service = $plugin->get_component('database');
```

#### Query Compatibility
```php
// Handles legacy query patterns
$compat = BackwardsCompatibility::get_instance();
$results = $compat->handle_legacy_database_query('get_agents', $args);
```

## Automatic Compatibility Features

### 1. Dynamic Function Creation

The compatibility layer dynamically creates fallback functions for deprecated theme functions:

```php
// Example: If load_agents_files() is called but doesn't exist
// The compatibility layer creates it automatically:
function load_agents_files() {
    return BackwardsCompatibility::get_instance()->load_agents_files_fallback();
}
```

### 2. Asset Deregistration and Reregistration

Automatically handles asset conflicts:

```php
// If theme tries to load 'agents-app' script
// Compatibility layer deregisters it and loads plugin version
wp_deregister_script('agents-app');
wp_enqueue_script('wecoza-agents', WECOZA_AGENTS_JS_URL . 'agents-app.js', ...);
```

### 3. Deprecation Logging

All deprecated function calls are logged when WP_DEBUG is enabled:

```php
// Example log entries
[WeCoza Agents] Deprecated function call: load_agents_files() - Plugin handles file loading automatically
[WeCoza Agents] Deprecated function call: enqueue_agents_assets() - Plugin handles asset loading automatically
```

## Compatibility Status Checking

### Check Overall Compatibility
```php
$compat = BackwardsCompatibility::get_instance();
$status = $compat->get_compatibility_status();

if ($status['overall_compatible']) {
    // All systems compatible
}
```

### Generate Compatibility Report
```php
$compat = BackwardsCompatibility::get_instance();
$report = $compat->generate_compatibility_report();

// Returns:
// - status: Array of compatibility checks
// - overall_compatible: Boolean overall status
// - breaking_changes: List of breaking changes
// - recommendations: Array of recommendations
```

## Breaking Changes Handled

### 1. Function Namespace Changes
- **Old**: Global theme functions
- **New**: Plugin class methods
- **Compatibility**: Fallback functions that redirect to plugin

### 2. Asset Loading Changes
- **Old**: Theme enqueues agent assets
- **New**: Plugin conditionally enqueues assets
- **Compatibility**: Automatic asset redirection

### 3. Database Service Changes
- **Old**: Direct learner_DB class usage
- **New**: Plugin database service
- **Compatibility**: Fallback to legacy database when needed

### 4. Hook Name Changes
- **Old**: Theme-specific hook names
- **New**: Plugin-specific hook names
- **Compatibility**: Automatic hook forwarding

## Configuration

### Enable/Disable Compatibility Features

The compatibility layer can be controlled via WordPress options:

```php
// Disable specific compatibility features
update_option('wecoza_agents_compat_functions', false);
update_option('wecoza_agents_compat_hooks', false);
update_option('wecoza_agents_compat_assets', false);
```

### Debug Mode

Enable enhanced debugging for compatibility issues:

```php
// Enable compatibility debugging
update_option('wecoza_agents_compat_debug', true);
```

## Migration Timeline

### Phase 1: Plugin Activation (Immediate)
- Backwards compatibility layer active
- All theme functions still work
- Deprecation notices logged

### Phase 2: Migration Period (60 days)
- Compatibility layer continues to work
- Admin notices guide users to update code
- Gradual migration of custom code

### Phase 3: Cleanup (After 60 days)
- Deprecated theme files can be removed
- Compatibility layer remains for custom code
- Legacy function calls continue to work

## Testing Compatibility

### Manual Testing
```php
// Test deprecated function calls
if (function_exists('load_agents_files')) {
    load_agents_files(); // Should work via compatibility layer
}

// Test shortcode compatibility
echo do_shortcode('[wecoza_capture_agents]'); // Should work from plugin
```

### Automated Testing
```php
// Check compatibility status
$compat = BackwardsCompatibility::get_instance();
$status = $compat->get_compatibility_status();

// Verify all features are compatible
$all_compatible = !in_array(false, $status, true);
```

## Performance Impact

### Minimal Overhead
- Compatibility layer only activates when needed
- Functions are created on-demand
- No performance impact on new plugin functionality

### Memory Usage
- Singleton pattern ensures single instance
- Lazy loading of compatibility features
- Minimal memory footprint

## Future Considerations

### Long-term Support
- Compatibility layer will remain active indefinitely
- No plans to remove deprecated function support
- Ensures long-term stability for custom code

### Updates
- Compatibility layer will be updated as needed
- New compatibility features added as required
- Backward compatibility maintained across plugin updates

## Troubleshooting

### Common Issues

#### 1. Function Not Found Errors
```php
// If you get "Call to undefined function" errors
// Check if compatibility layer is loaded:
if (class_exists('WeCoza\Agents\BackwardsCompatibility')) {
    // Compatibility layer is active
}
```

#### 2. Asset Loading Issues
```php
// If assets don't load correctly
// Check if plugin assets exist:
if (file_exists(WECOZA_AGENTS_PLUGIN_DIR . 'assets/js/agents-app.js')) {
    // Plugin assets are available
}
```

#### 3. Database Errors
```php
// If database calls fail
// Check if database service is available:
$plugin = Plugin::get_instance();
$db_service = $plugin->get_component('database');
if (!$db_service && class_exists('learner_DB')) {
    // Fall back to legacy database
}
```

### Debug Information

Enable debugging to see compatibility layer activity:

```php
// In wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);

// Check debug log for compatibility messages
// wp-content/debug.log
```

## Conclusion

The backwards compatibility layer ensures a smooth migration from theme-based to plugin-based agent functionality. It provides comprehensive fallbacks for all breaking changes while maintaining full functionality for existing code.

This layer will remain active indefinitely, ensuring long-term compatibility and stability for all users of the WeCoza Agents system.