# WeCoza Agents Plugin - Task Breakdown

## Phase 1: Plugin Foundation

### 1. Create Plugin Structure
- Create wecoza-agents-plugin directory in wp-content/plugins
- Set up main plugin file with WordPress headers
- Create directory structure (includes, src, assets, templates)
- Set up composer.json for PSR-4 autoloading
- Create README.md with basic documentation

### 2. Core Plugin Classes
- Create Plugin.php main class
- Implement Activator.php for activation hooks
- Implement Deactivator.php for deactivation hooks
- Create uninstall.php for clean removal
- Set up plugin initialization and hooks

### 3. Database Service Layer
- Duplicate DatabaseService.php from theme
- Create AgentQueries.php for agent-specific queries
- Implement database connection logic (PostgreSQL primary, MySQL fallback)
- Add WordPress options integration for PostgreSQL settings
- Test database connectivity

## Phase 2: Code Migration

### 4. Shortcode Migration
- Create CaptureAgentShortcode.php class
- Create DisplayAgentShortcode.php class
- Migrate agent capture form logic
- Migrate agent display table logic
- Implement shortcode registration in main plugin

### 5. Asset Migration
- Move agents-app.js to plugin assets/js/
- Extract agent-specific CSS (if any) to agents-extracted.css
- Update asset enqueueing to use plugin URLs
- Implement conditional loading (only when shortcodes present)
- Update JavaScript localization for AJAX

### 6. Template System
- Create agent-capture-form.php template
- Create agent-display-table.php template
- Implement template loading system
- Migrate HTML from shortcode files to templates
- Add template override capability

### 7. Helper Classes
- Create ValidationHelper.php for SA ID/Passport validation
- Migrate validation logic from JavaScript PHP equivalent
- Create Agent.php model class for data structure
- Implement any additional utility functions

## Phase 3: Theme Cleanup

### 8. Deprecation Implementation
- Add deprecation notices to theme agent files
- Create deprecation-log.txt in plugin
- Comment out agent-related includes in functions.php
- Update theme's ajax-handlers.php to remove agent references
- Add admin notices for deprecated functionality

### 9. Theme File Cleanup
- Remove agent shortcode registrations from theme
- Clean up AgentController.php in theme (mark as deprecated)
- Remove agent-related constants and globals
- Update theme documentation
- Test theme without agent functionality

## Phase 4: Testing & Finalization

### 10. Comprehensive Testing
- Test agent capture form functionality
- Test agent display table with demo data
- Verify user role permissions (Editors and Admins)
- Test with PostgreSQL and MySQL configurations
- Cross-browser testing for JavaScript functionality
- Test plugin activation/deactivation/uninstall
- Verify no conflicts with theme or other plugins

### 11. Documentation & Polish
- Complete README.md with usage instructions
- Create CHANGELOG.md
- Add inline code documentation
- Create user guide for shortcode usage
- Document future enhancement plans
- Add WordPress plugin repository headers (if applicable)

## Future Enhancements (Post-Migration Notes)

### 12. CRUD Operations (To Do Later)
- Implement agent creation from form submission
- Add update functionality for existing agents
- Implement delete operations with confirmation
- Add bulk operations support
- Create AJAX handlers for all operations

### 13. Reporting Features (To Do Later)
- Agent listing with filters
- Performance metrics dashboard
- Attendance tracking
- Training completion reports
- Export functionality (CSV, PDF)

### 14. Integration Points (To Do Later)
- REST API endpoints for agent data
- Hooks and filters for extensibility
- Integration with wecoza-classes-plugin
- Event system for agent-related actions
- Webhook support for external systems