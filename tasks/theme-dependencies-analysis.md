# Theme-Specific Dependencies Analysis

## Investigation Results from Subtask 1.9

### Theme Constants Used

1. **`WECOZA_CHILD_DIR`**
   - Definition: `get_stylesheet_directory(__FILE__)`
   - Used in: `agents-functions.php` (line 19)
   - Purpose: File path for requiring PHP files

2. **`WECOZA_CHILD_URL`**
   - Definition: `get_stylesheet_directory_uri(__FILE__)`
   - Used in: `agents-functions.php` (line 39)
   - Purpose: URL for enqueuing JavaScript files

3. **`WECOZA_PLUGIN_VERSION`**
   - Definition: Random number (`rand()`)
   - Used in: `agents-functions.php` (line 41)
   - Purpose: Cache busting for assets

### Theme Classes/Functions Used

#### 1. **`learner_DB` Class**
- **Location**: `/assets/learners/learners-db.php`
- **Used in**: `agents-capture-shortcode.php` (line 18)
- **Purpose**: Database operations (though methods are commented out)
- **Methods referenced** (but commented):
  - `get_locations()`
  - `get_qualifications()`
  - `get_employers()`
  - `get_placement_level()`
- **Migration Impact**: HIGH - Need to replace with agent-specific database class

#### 2. **`MainController::getAgents()`**
- **Location**: `/app/Controllers/MainController.php`
- **Used by**: Other theme components (not directly by agents)
- **Returns**: Static array of agents
- **Migration Impact**: LOW - Agents don't call this directly

### WordPress Functions Used

All WordPress functions used are **standard** and will work in plugin:

1. **Nonce Functions**:
   - `wp_verify_nonce()`
   - `wp_nonce_field()`
   - `wp_create_nonce()`

2. **Asset Functions**:
   - `wp_enqueue_script()`
   - `wp_enqueue_style()`
   - `wp_localize_script()`
   - `admin_url()`
   - `wp_upload_dir()`

3. **User Functions**:
   - `current_user_can()`

4. **Hook Functions**:
   - `add_action()`
   - `add_shortcode()`

5. **Data Functions**:
   - `sanitize_text_field()`
   - `get_option()` (in DatabaseService)

### Parent Theme Dependencies

1. **Bootstrap 5**
   - CSS and JS loaded by parent theme
   - Critical dependency for UI components

2. **Theme Styles**
   - Uses theme color utilities (e.g., `bg-discovery-subtle`)
   - Uses theme spacing and typography

### File Structure Dependencies

Current file loading hierarchy:
1. `functions.php` loads `agents-functions.php`
2. `agents-functions.php` loads:
   - `agents-capture-shortcode.php`
   - `agents-display-shortcode.php`
3. No autoloading - uses `require_once`

### Database Dependencies

1. **DatabaseService**
   - Location: `/app/Services/Database/DatabaseService.php`
   - Not directly used by agents (but should be)
   - Uses PDO for PostgreSQL connection

2. **Database Operations**
   - Currently none implemented for agents
   - Relies on `learner_DB` class (instantiated but unused)

### Migration Requirements

#### Must Replace/Recreate:
1. **Constants**:
   ```php
   // Replace with plugin constants
   WECOZA_CHILD_DIR → WECOZA_AGENTS_PLUGIN_DIR
   WECOZA_CHILD_URL → WECOZA_AGENTS_PLUGIN_URL
   WECOZA_PLUGIN_VERSION → WECOZA_AGENTS_VERSION
   ```

2. **learner_DB Class**:
   - Create `AgentDatabase` class
   - Implement actual database methods
   - Use DatabaseService pattern

3. **File Loading**:
   - Implement PSR-4 autoloading
   - Remove manual requires

#### Can Keep As-Is:
1. All WordPress core functions
2. Nonce handling
3. Sanitization functions
4. Hook registrations

#### External Dependencies to Document:
1. Bootstrap 5 requirement
2. jQuery requirement
3. Select2 (currently CDN)

### Compatibility Considerations

1. **Namespace Conflicts**: None found (no namespaces used)
2. **Function Name Conflicts**: 
   - `agents_capture_shortcode()` - unique name
   - `wecoza_display_agents_shortcode()` - unique name
   - `enqueue_agents_assets()` - prefix with plugin slug
3. **Global Variables**: None used
4. **Direct Database Queries**: None implemented

### Recommendations

1. **Create plugin constants** early in development
2. **Copy DatabaseService pattern** but make agent-specific
3. **Document Bootstrap 5 dependency** prominently
4. **Create compatibility checker** for parent theme
5. **Implement proper error handling** for missing dependencies
6. **Add theme fallback styles** for missing utilities