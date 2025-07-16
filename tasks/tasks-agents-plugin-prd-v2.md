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

### Investigation Documentation
- `wp-content/themes/wecoza_3_child_theme/tasks/agent-references-documentation.md` - Complete analysis of agent references in theme
- `wp-content/themes/wecoza_3_child_theme/tasks/functions-php-analysis.md` - Analysis of agent-related hooks and includes in functions.php
- `wp-content/themes/wecoza_3_child_theme/tasks/ajax-handlers-analysis.md` - Analysis of AJAX endpoints (none found for agents)
- `wp-content/themes/wecoza_3_child_theme/tasks/agent-css-extraction.md` - CSS analysis and extraction documentation
- `wp-content/themes/wecoza_3_child_theme/assets/agents/agents-extracted.css` - Extracted agent-specific CSS (ready for plugin)
- `wp-content/themes/wecoza_3_child_theme/tasks/database-schema-verification.md` - Database schema analysis (no DB usage found)
- `wp-content/themes/wecoza_3_child_theme/tasks/javascript-dependencies-documentation.md` - JavaScript libraries and dependencies
- `wp-content/themes/wecoza_3_child_theme/tasks/agent-assets-inventory.md` - Complete inventory of agent assets
- `wp-content/themes/wecoza_3_child_theme/tasks/shortcode-functionality-testing.md` - Shortcode testing results and functionality
- `wp-content/themes/wecoza_3_child_theme/tasks/theme-dependencies-analysis.md` - Theme-specific functions and dependencies

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

- [x] 1.0 Investigation & Pre-Migration Analysis
  - [x] 1.1 Search and document all agent-related references in theme files using grep
  - [x] 1.2 Analyze functions.php for agent-related includes, hooks, and filters
  - [x] 1.3 Check ajax-handlers.php for agent AJAX endpoints and document them
  - [x] 1.4 Extract and document agent-specific CSS selectors from ydcoza-styles.css
  - [x] 1.5 Verify PostgreSQL database schema matches PRD specifications
  - [x] 1.6 Document all JavaScript dependencies and third-party libraries used
  - [x] 1.7 Create inventory of all agent-related images and assets
  - [x] 1.8 Test existing shortcodes and document current functionality
  - [x] 1.9 Identify any theme-specific functions that agent code depends on

- [x] 2.0 Plugin Foundation & Architecture Setup
  - [x] 2.1 Create plugin directory structure at wp-content/plugins/wecoza-agents-plugin/
  - [x] 2.2 Write main plugin file with WordPress headers and version checks
  - [x] 2.3 Set up composer.json with PSR-4 autoloading for WeCoza\Agents namespace
  - [x] 2.4 Create .gitignore with proper exclusions (vendor/, node_modules/, etc.)
  - [x] 2.5 Add index.php security files in all directories
  - [x] 2.6 Create phpcs.xml for WordPress coding standards
  - [x] 2.7 Initialize README.md with basic plugin information
  - [x] 2.8 Set up CHANGELOG.md with initial version entry
  - [x] 2.9 Create plugin constants file with version, paths, and URLs
  - [x] 2.10 Configure .editorconfig for consistent code formatting

- [x] 3.0 Database Service & Core Infrastructure
  - [x] 3.1 Create includes/class-plugin.php with singleton pattern implementation
  - [x] 3.2 Implement includes/class-activator.php with database checks and options
  - [x] 3.3 Implement includes/class-deactivator.php for cleanup operations
  - [x] 3.4 Create uninstall.php for complete plugin removal
  - [x] 3.5 Copy DatabaseService.php from theme and update namespace
  - [x] 3.6 Create AgentQueries.php with CRUD method stubs
  - [x] 3.7 Implement DatabaseLogger.php for query debugging
  - [x] 3.8 Add database connection fallback logic (PostgreSQL to MySQL)
  - [x] 3.9 Set up WordPress options for PostgreSQL configuration
  - [x] 3.10 Create database error handling and logging system

- [x] 4.0 Code Migration & Refactoring
  - [x] 4.1 Create AbstractShortcode.php base class with common functionality
  - [x] 4.2 Refactor agents-capture-shortcode.php into CaptureAgentShortcode class
  - [x] 4.3 Refactor agents-display-shortcode.php into DisplayAgentShortcode class
  - [x] 4.4 Create Agent.php model with data structure and validation rules
  - [x] 4.5 Extract validation logic into ValidationHelper.php class
  - [x] 4.6 Create AgentCaptureForm.php for form processing logic
  - [x] 4.7 Implement FormValidator.php for centralized validation
  - [x] 4.8 Create helper classes (ArrayHelper.php, StringHelper.php)
  - [x] 4.9 Migrate agent-related functions from agents-functions.php
  - [x] 4.10 Update all function calls to use new class methods

- [x] 5.0 Asset Transfer & Template System
  - [x] 5.1 Copy agents-app.js to plugin assets/js/ directory
  - [x] 5.2 Update JavaScript AJAX endpoints to use plugin URLs
  - [x] 5.3 Add WordPress script localization for AJAX configuration
  - [x] 5.4 Create minified version of agents-app.js
  - [x] 5.5 Extract agent-specific CSS into agents-extracted.css
  - [x] 5.6 Create minified version of CSS file
  - [x] 5.7 Implement template loading system with theme override support
  - [x] 5.8 Extract HTML from capture shortcode into agent-capture-form.php template
  - [x] 5.9 Extract HTML from display shortcode into agent-display-table.php template
  - [x] 5.10 Create agent-modal.php template for detailed agent view
  - [x] 5.11 Create agent-fields.php partial for reusable form fields
  - [x] 5.12 Implement conditional asset loading (only when shortcodes present)

- [x] 6.0 Theme Integration & Deprecation Strategy
  - [x] 6.1 Add _deprecated_file() notices to all theme agent files
  - [x] 6.2 Create deprecation log file in plugin for tracking usage
  - [x] 6.3 Comment out agent includes in theme functions.php with removal date
  - [x] 6.4 Remove agent shortcode registrations from theme
  - [x] 6.5 Update AgentController.php with deprecation notice
  - [x] 6.6 Remove agent AJAX handlers from theme ajax-handlers.php
  - [x] 6.7 Create admin notices for deprecated functionality
  - [x] 6.8 Document all removed hooks and filters for migration guide
  - [x] 6.9 Test theme functionality without agent components
  - [x] 6.10 Create backwards compatibility layer for any breaking changes

- [x] 7.0 Performance Optimization
  - [x] 7.1 Implement nonce verification on all forms
  - [x] 7.2 Add input sanitization and output escaping
  - [x] 7.3 Optimize database queries with proper indexes
  - [x] 7.4 Implement caching for frequently accessed data

- [ ] 8.0 Documentation & Deployment Preparation
  - [ ] 8.1 Complete README.md with installation instructions
  - [ ] 8.2 Document all shortcode attributes and usage examples
  - [ ] 8.3 Create developer documentation for hooks and filters
  - [ ] 8.4 Document database schema and relationships
  