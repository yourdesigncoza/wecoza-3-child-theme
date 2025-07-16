# Functions.php Agent-Related Analysis

## Investigation Results from Subtask 1.2

### Direct Agent Includes in functions.php

1. **Line 141**: `require_once WECOZA_CHILD_DIR . '/assets/agents/agents-functions.php';`
   - Located in the "Legacy files" section
   - Marked with comment: "// Legacy files - these will be migrated to the MVC structure"
   - Loaded after MVC bootstrap (line 133)
   - No conditional loading - always loaded

### Agent-Related Hooks and Actions

#### From agents-functions.php:

1. **Function: `load_agents_files()`**
   - Loads two required files:
     - `/assets/agents/agents-capture-shortcode.php`
     - `/assets/agents/agents-display-shortcode.php`
   - Called immediately upon file inclusion (line 27)
   - No hooks attached to this function

2. **Hook: `wp_enqueue_scripts`**
   - Action: `enqueue_agents_assets` (line 56)
   - Enqueues `agents-app.js` JavaScript file
   - Localizes script with:
     - `ajax_url`: WordPress AJAX endpoint
     - `nonce`: Security nonce with handle 'agents_nonce'
     - `uploads_url`: WordPress uploads directory URL
     - `is_admin`: Boolean for admin capability check

#### From Shortcode Files:

1. **agents-capture-shortcode.php**
   - Registers shortcode: `[wecoza_capture_agents]` (line 530)
   - Handler function: `agents_capture_shortcode`

2. **agents-display-shortcode.php**
   - Registers shortcode: `[wecoza_display_agents]` (line 640)
   - Handler function: `wecoza_display_agents_shortcode`

### Global Script Localization

From functions.php (not agent-specific but available to agent scripts):

1. **Line 53**: `wp_localize_script('wecoza-table-handler', 'wecoza_table_ajax', ...)`
   - Provides `ajax_url` and `nonce` for table operations

2. **Line 55**: `wp_localize_script('jquery', 'wecoza_ajax', ...)`
   - Makes `ajax_url` globally available to all jQuery scripts

### Load Order Analysis

1. **Priority 10** (default): `enqueue_assets()` - Global assets
2. **After that**: MVC bootstrap loaded
3. **After that**: Agent files loaded (agents-functions.php)
4. **Priority 10** (default): `enqueue_agents_assets()` - Agent-specific assets
5. **Priority 99**: `ydcoza_load_child_style_last()` - Final styles

### No Agent-Specific Filters Found

- No `add_filter` calls in agent files
- No custom agent-related filters applied to WordPress core functionality
- No agent-specific AJAX handlers registered (wp_ajax_* actions)

### Dependencies and Considerations

1. **Script Dependencies**:
   - agents-app.js depends on jQuery
   - Uses Bootstrap 5 (loaded by parent theme)
   - Uses Select2 (loaded globally in functions.php)

2. **Style Dependencies**:
   - Agent styles are part of ydcoza-styles.css (loaded at priority 99)
   - No separate agent-specific CSS file

3. **Security**:
   - Uses WordPress nonce system ('agents_nonce')
   - Checks admin capabilities with `current_user_can('manage_options')`

### Migration Impact

1. **Minimal Hook Conflicts**: Only one `wp_enqueue_scripts` hook to migrate
2. **Clean Separation**: Agent code is already isolated in separate files
3. **No Filter Dependencies**: No filters to maintain compatibility with
4. **Simple Include Structure**: Single entry point through agents-functions.php

### Recommendations for Plugin Migration

1. Remove line 141 from functions.php after plugin activation
2. Maintain same hook priorities in plugin
3. Keep same script handles to avoid conflicts
4. Preserve nonce names for backward compatibility
5. No need to maintain filter compatibility (none exist)