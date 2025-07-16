# Agent-Related References in Theme Files

## Investigation Results from Subtask 1.1

### Core Agent Files (Primary Migration Targets)

1. **`/assets/agents/agents-functions.php`**
   - Main agent functionality file
   - Required by functions.php (line 141)
   - Contains core agent processing logic

2. **`/assets/agents/agents-capture-shortcode.php`**
   - Agent capture form shortcode implementation
   - Handles agent data entry and editing

3. **`/assets/agents/agents-display-shortcode.php`**
   - Agent display table shortcode implementation
   - Shows agents in responsive table with modal details

4. **`/assets/agents/js/agents-app.js`**
   - JavaScript functionality for agent features
   - Handles form interactions and modal displays

5. **`/app/Controllers/AgentController.php`**
   - MVC controller for agent operations
   - Listed in config/app.php (line 61) for autoloading
   - To be deprecated in favor of plugin architecture

### Theme Integration Points

1. **`functions.php`**
   - Line 141: `require_once WECOZA_CHILD_DIR . '/assets/agents/agents-functions.php';`
   - Direct inclusion of agent functionality

2. **`/app/Controllers/MainController.php`**
   - Line 145: Agent Absent status option
   - Line 237: `getAgents()` method definition
   - Provides agent data access methods

3. **`/app/Controllers/NavigationController.php`**
   - Lines 90-91: Agents menu item
   - URL: `/agents/`
   - Navigation integration

4. **`/app/Controllers/ShortcodeListController.php`**
   - Lines 138-144: `wecoza_agent_capture` shortcode registration
   - Lines 149-155: `wecoza_agent_display` shortcode registration
   - Lines 160-166: `wecoza_display_agents` shortcode registration
   - Controller mapping: AgentController

5. **`/config/app.php`**
   - Line 61: AgentController class registration
   - Namespace: `WeCoza\Controllers\AgentController`

### CSS References

1. **`/includes/css/ydcoza-styles.css`**
   - Line 2132: `.note-category-agent-absent` class
   - Line 2211: Dark theme variant for agent-absent category
   - Minimal agent-specific styling

### Related Files (Indirect References)

1. **`/assets/clients/clients-functions.php`**
   - Contains agent references (likely shared functionality)
   
2. **`/assets/learners/learners-db.php`**
   - Contains agent references (possibly related to agent assignments)

### AJAX Integration

- **`/app/ajax-handlers.php`**: No direct agent references found
- Agent AJAX functionality likely handled within agent-specific files

### Shortcode Summary

| Shortcode | Purpose | Controller | View File |
|-----------|---------|------------|-----------|
| `[wecoza_agent_capture]` | Agent data entry form | AgentController | - |
| `[wecoza_agent_display]` | Agent information display | AgentController | - |
| `[wecoza_display_agents]` | Agent table with modals | - | agents-display-shortcode.php |

### Migration Considerations

1. **Direct Includes**: Only one direct include in functions.php needs removal
2. **Controller Dependencies**: AgentController needs deprecation notices
3. **Navigation**: Menu item will need to remain functional post-migration
4. **CSS**: Minimal CSS migration required (2 classes)
5. **Database Access**: MainController::getAgents() method used by other components
6. **Shortcode Compatibility**: All three shortcodes must maintain backward compatibility

### Next Investigation Areas

- Database schema and table structures
- JavaScript AJAX endpoints and routes
- Form field definitions and validation rules
- Modal template structures
- User permission checks
- Session/cookie usage
- External API integrations