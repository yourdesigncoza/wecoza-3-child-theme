# WeCoza Agents Plugin - Implementation Tasks

Generated from: `docs/agents-plugin-prd-v2.md`  
Date: 2025-01-16

## Relevant Files

### Theme Files to Migrate/Modify
- `wp-content/themes/wecoza_3_child_theme/assets/agents/agents-capture-shortcode.php` - Agent capture form shortcode (to be migrated)
- `wp-content/themes/wecoza_3_child_theme/assets/agents/agents-display-shortcode.php` - Agent display table shortcode (to be migrated)
- `wp-content/themes/wecoza_3_child_theme/assets/agents/agents-functions.php` - Core agent functions (to be migrated)
- `wp-content/themes/wecoza_3_child_theme/assets/agents/js/agents-app.js` - JavaScript functionality (to be migrated)
- `wp-content/themes/wecoza_3_child_theme/app/Controllers/AgentController.php` - MVC controller (to be deprecated)
- `wp-content/themes/wecoza_3_child_theme/app/Services/Database/DatabaseService.php` - Database service (to be copied)
- `wp-content/themes/wecoza_3_child_theme/functions.php` - Main theme functions (to be updated)
- `wp-content/themes/wecoza_3_child_theme/app/ajax-handlers.php` - AJAX handlers (to be checked/updated)
- `wp-content/themes/wecoza_3_child_theme/includes/css/ydcoza-styles.css` - Theme styles (extract agent-specific CSS)

### Plugin Files to Create
- `wp-content/plugins/wecoza-agents-plugin/wecoza-agents-plugin.php` - Main plugin file
- `wp-content/plugins/wecoza-agents-plugin/composer.json` - Composer configuration
- `wp-content/plugins/wecoza-agents-plugin/uninstall.php` - Uninstall handler
- `wp-content/plugins/wecoza-agents-plugin/README.md` - Plugin documentation
- `wp-content/plugins/wecoza-agents-plugin/CHANGELOG.md` - Version history
- `wp-content/plugins/wecoza-agents-plugin/.gitignore` - Git ignore configuration
- `wp-content/plugins/wecoza-agents-plugin/phpcs.xml` - PHP coding standards

### Core Plugin Classes
- `wp-content/plugins/wecoza-agents-plugin/includes/class-plugin.php` - Main plugin class
- `wp-content/plugins/wecoza-agents-plugin/includes/class-activator.php` - Activation handler
- `wp-content/plugins/wecoza-agents-plugin/includes/class-deactivator.php` - Deactivation handler
- `wp-content/plugins/wecoza-agents-plugin/includes/class-constants.php` - Plugin constants

### Database Layer
- `wp-content/plugins/wecoza-agents-plugin/src/Database/DatabaseService.php` - Database abstraction
- `wp-content/plugins/wecoza-agents-plugin/src/Database/AgentQueries.php` - Agent-specific queries
- `wp-content/plugins/wecoza-agents-plugin/src/Database/DatabaseLogger.php` - Query logging

### Shortcode Classes
- `wp-content/plugins/wecoza-agents-plugin/src/Shortcodes/AbstractShortcode.php` - Base shortcode class
- `wp-content/plugins/wecoza-agents-plugin/src/Shortcodes/CaptureAgentShortcode.php` - Capture form shortcode
- `wp-content/plugins/wecoza-agents-plugin/src/Shortcodes/DisplayAgentShortcode.php` - Display table shortcode

### Models and Helpers
- `wp-content/plugins/wecoza-agents-plugin/src/Models/Agent.php` - Agent data model
- `wp-content/plugins/wecoza-agents-plugin/src/Helpers/ValidationHelper.php` - SA ID/Passport validation
- `wp-content/plugins/wecoza-agents-plugin/src/Helpers/ArrayHelper.php` - Array utilities
- `wp-content/plugins/wecoza-agents-plugin/src/Helpers/StringHelper.php` - String utilities

### Forms
- `wp-content/plugins/wecoza-agents-plugin/src/Forms/AgentCaptureForm.php` - Form processor
- `wp-content/plugins/wecoza-agents-plugin/src/Forms/FormValidator.php` - Form validation

### Assets
- `wp-content/plugins/wecoza-agents-plugin/assets/js/agents-app.js` - Main JavaScript
- `wp-content/plugins/wecoza-agents-plugin/assets/js/agents-app.min.js` - Minified JavaScript
- `wp-content/plugins/wecoza-agents-plugin/assets/css/agents-extracted.css` - Agent styles
- `wp-content/plugins/wecoza-agents-plugin/assets/css/agents-extracted.min.css` - Minified CSS

### Templates
- `wp-content/plugins/wecoza-agents-plugin/templates/forms/agent-capture-form.php` - Capture form template
- `wp-content/plugins/wecoza-agents-plugin/templates/display/agent-display-table.php` - Display table template
- `wp-content/plugins/wecoza-agents-plugin/templates/display/agent-modal.php` - Modal template
- `wp-content/plugins/wecoza-agents-plugin/templates/partials/agent-fields.php` - Reusable field components

### Test Files (Future Implementation)
- `wp-content/plugins/wecoza-agents-plugin/tests/test-plugin.php` - Main plugin tests
- `wp-content/plugins/wecoza-agents-plugin/tests/test-database.php` - Database connectivity tests
- `wp-content/plugins/wecoza-agents-plugin/tests/test-shortcodes.php` - Shortcode functionality tests
- `wp-content/plugins/wecoza-agents-plugin/tests/test-validation.php` - SA ID/Passport validation tests

### Translation Files
- `wp-content/plugins/wecoza-agents-plugin/languages/wecoza-agents-plugin.pot` - Translation template
- `wp-content/plugins/wecoza-agents-plugin/languages/README.md` - Translation guide

### Security Files
- `wp-content/plugins/wecoza-agents-plugin/index.php` - Root security file
- `wp-content/plugins/wecoza-agents-plugin/*/index.php` - Directory security files (multiple)
- `wp-content/plugins/wecoza-agents-plugin/logs/.htaccess` - Log directory access control

### Notes

- This is a plugin extraction project - all agent functionality currently exists in the theme and must be moved to a standalone plugin
- The plugin must maintain 100% backward compatibility with existing shortcodes: `[wecoza_capture_agents]` and `[wecoza_display_agents]`
- Database structure already exists in PostgreSQL - no schema changes needed during migration
- The plugin must support both PostgreSQL (primary) and MySQL (fallback) databases
- All JavaScript dependencies (Bootstrap 5, Select2) are already loaded by the theme
- Security files (index.php) must be placed in every directory to prevent direct access
- Use WordPress coding standards and PSR-4 autoloading for all PHP classes
- Implement proper deprecation notices in theme files before removal
- Testing should focus on ensuring identical functionality before and after migration

## Tasks

- [ ] 1.0 Investigation & Pre-Migration Analysis
  - [ ] 1.1 Search and document all agent-related references in theme files using grep
  - [ ] 1.2 Analyze functions.php for agent-related includes, hooks, and filters
  - [ ] 1.3 Check ajax-handlers.php for agent AJAX endpoints and document them
  - [ ] 1.4 Extract and document agent-specific CSS selectors from ydcoza-styles.css
  - [ ] 1.5 Verify PostgreSQL database schema matches PRD specifications
  - [ ] 1.6 Document all JavaScript dependencies and third-party libraries used
  - [ ] 1.7 Create inventory of all agent-related images and assets
  - [ ] 1.8 Test existing shortcodes and document current functionality
  - [ ] 1.9 Identify any theme-specific functions that agent code depends on

- [ ] 2.0 Plugin Foundation & Architecture Setup
  - [ ] 2.1 Create plugin directory structure at wp-content/plugins/wecoza-agents-plugin/
  - [ ] 2.2 Write main plugin file with WordPress headers and version checks
  - [ ] 2.3 Set up composer.json with PSR-4 autoloading for WeCoza\Agents namespace
  - [ ] 2.4 Create .gitignore with proper exclusions (vendor/, node_modules/, etc.)
  - [ ] 2.5 Add index.php security files in all directories
  - [ ] 2.6 Create phpcs.xml for WordPress coding standards
  - [ ] 2.7 Initialize README.md with basic plugin information
  - [ ] 2.8 Set up CHANGELOG.md with initial version entry
  - [ ] 2.9 Create plugin constants file with version, paths, and URLs
  - [ ] 2.10 Configure .editorconfig for consistent code formatting

- [ ] 3.0 Database Service & Core Infrastructure
  - [ ] 3.1 Create includes/class-plugin.php with singleton pattern implementation
  - [ ] 3.2 Implement includes/class-activator.php with database checks and options
  - [ ] 3.3 Implement includes/class-deactivator.php for cleanup operations
  - [ ] 3.4 Create uninstall.php for complete plugin removal
  - [ ] 3.5 Copy DatabaseService.php from theme and update namespace
  - [ ] 3.6 Create AgentQueries.php with CRUD method stubs
  - [ ] 3.7 Implement DatabaseLogger.php for query debugging
  - [ ] 3.8 Add database connection fallback logic (PostgreSQL to MySQL)
  - [ ] 3.9 Set up WordPress options for PostgreSQL configuration
  - [ ] 3.10 Create database error handling and logging system

- [ ] 4.0 Code Migration & Refactoring
  - [ ] 4.1 Create AbstractShortcode.php base class with common functionality
  - [ ] 4.2 Refactor agents-capture-shortcode.php into CaptureAgentShortcode class
  - [ ] 4.3 Refactor agents-display-shortcode.php into DisplayAgentShortcode class
  - [ ] 4.4 Create Agent.php model with data structure and validation rules
  - [ ] 4.5 Extract validation logic into ValidationHelper.php class
  - [ ] 4.6 Create AgentCaptureForm.php for form processing logic
  - [ ] 4.7 Implement FormValidator.php for centralized validation
  - [ ] 4.8 Create helper classes (ArrayHelper.php, StringHelper.php)
  - [ ] 4.9 Migrate agent-related functions from agents-functions.php
  - [ ] 4.10 Update all function calls to use new class methods

- [ ] 5.0 Asset Transfer & Template System
  - [ ] 5.1 Copy agents-app.js to plugin assets/js/ directory
  - [ ] 5.2 Update JavaScript AJAX endpoints to use plugin URLs
  - [ ] 5.3 Add WordPress script localization for AJAX configuration
  - [ ] 5.4 Create minified version of agents-app.js
  - [ ] 5.5 Extract agent-specific CSS into agents-extracted.css
  - [ ] 5.6 Create minified version of CSS file
  - [ ] 5.7 Implement template loading system with theme override support
  - [ ] 5.8 Extract HTML from capture shortcode into agent-capture-form.php template
  - [ ] 5.9 Extract HTML from display shortcode into agent-display-table.php template
  - [ ] 5.10 Create agent-modal.php template for detailed agent view
  - [ ] 5.11 Create agent-fields.php partial for reusable form fields
  - [ ] 5.12 Implement conditional asset loading (only when shortcodes present)

- [ ] 6.0 Theme Integration & Deprecation Strategy
  - [ ] 6.1 Add _deprecated_file() notices to all theme agent files
  - [ ] 6.2 Create deprecation log file in plugin for tracking usage
  - [ ] 6.3 Comment out agent includes in theme functions.php with removal date
  - [ ] 6.4 Remove agent shortcode registrations from theme
  - [ ] 6.5 Update AgentController.php with deprecation notice
  - [ ] 6.6 Remove agent AJAX handlers from theme ajax-handlers.php
  - [ ] 6.7 Create admin notices for deprecated functionality
  - [ ] 6.8 Document all removed hooks and filters for migration guide
  - [ ] 6.9 Test theme functionality without agent components
  - [ ] 6.10 Create backwards compatibility layer for any breaking changes

- [ ] 7.0 Testing, Security & Performance Optimization
  - [ ] 7.1 Test plugin activation on fresh WordPress installation
  - [ ] 7.2 Test plugin deactivation and data persistence
  - [ ] 7.3 Test agent capture form with all field validations
  - [ ] 7.4 Test agent display table with search and pagination
  - [ ] 7.5 Verify modal functionality and tab switching
  - [ ] 7.6 Test user role permissions (Editors and Admins only)
  - [ ] 7.7 Test database failover from PostgreSQL to MySQL
  - [ ] 7.8 Perform cross-browser testing (Chrome, Firefox, Safari, Edge)
  - [ ] 7.9 Implement nonce verification on all forms
  - [ ] 7.10 Add input sanitization and output escaping
  - [ ] 7.11 Optimize database queries with proper indexes
  - [ ] 7.12 Implement caching for frequently accessed data

- [ ] 8.0 Documentation & Deployment Preparation
  - [ ] 8.1 Complete README.md with installation instructions
  - [ ] 8.2 Document all shortcode attributes and usage examples
  - [ ] 8.3 Create developer documentation for hooks and filters
  - [ ] 8.4 Document database schema and relationships
  - [ ] 8.5 Create migration guide from theme to plugin
  - [ ] 8.6 Add inline PHPDoc comments to all classes and methods
  - [ ] 8.7 Create translation template (.pot file)
  - [ ] 8.8 Document configuration options and constants
  - [ ] 8.9 Prepare deployment checklist and rollback procedures
  - [ ] 8.10 Create support documentation and FAQ
  - [ ] 8.11 Test complete installation and configuration process
  - [ ] 8.12 Final code review and WordPress coding standards check