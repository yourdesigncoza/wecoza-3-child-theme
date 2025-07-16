# Product Requirements Document (PRD) - Version 2.0
# WeCoza Agents Plugin Extraction

## Document Control
- Version: 2.0
- Date: 2025-01-16
- Status: Complete with Detailed Implementation Plan
- Review: Comprehensive analysis completed

## 1. Executive Summary

### Project Overview
Extract all agent-related functionality from the WeCoza 3 Child Theme into a standalone WordPress plugin named "wecoza-agents-plugin". This plugin will manage agent information including capture, display, and future CRUD operations while maintaining the existing PostgreSQL database structure.

### Business Objectives
- Decouple agent functionality from the theme for better modularity
- Enable agent management independent of theme selection
- Maintain existing functionality while preparing for future enhancements
- Follow established patterns from the wecoza-classes-plugin extraction
- Ensure zero downtime during migration

### Success Criteria
- All agent functionality works identically after extraction
- Plugin operates independently without theme dependency
- Existing shortcodes continue functioning
- No data loss during migration
- Clean separation with proper deprecation notices
- Page load time < 2 seconds with shortcodes
- Zero PHP warnings/errors
- 100% backward compatibility

### Critical Requirements
- PHP 7.4+ compatibility
- WordPress 6.0+ compatibility
- PostgreSQL 12+ with MySQL 5.7+ fallback
- Bootstrap 5 compatibility
- Select2 library integration

## 2. Current State Analysis

### Existing Agent Functionality

#### Complete File Inventory
```
CONFIRMED FILES:
/assets/agents/
├── agents-capture-shortcode.php    # Form for capturing agent information
├── agents-display-shortcode.php    # Display agents table with modals
├── agents-functions.php           # Core loading and initialization
└── js/
    └── agents-app.js             # Form validation and UI interactions

/app/Controllers/
└── AgentController.php           # MVC controller (placeholder implementation)

TO BE INVESTIGATED:
- functions.php (check for agent-related hooks/filters)
- ajax-handlers.php (check for agent AJAX endpoints)
- ydcoza-styles.css (extract agent-specific styles)
- Any agent-related images/assets
```

#### Implemented Features
1. **Agent Capture Form** (`[wecoza_capture_agents]`)
   - Comprehensive form with validation
   - Fields structure:
     ```
     Personal Information:
     - Title (Mr/Mrs/Ms/Dr/Prof)
     - First Name*
     - Last Name*
     - Known As
     - Gender (Male/Female/Other)
     - Race (African/Coloured/Indian/White/Other)
     
     Identification:
     - ID Type (SA ID/Passport)
     - SA ID Number (with checksum validation)
     - Passport Number
     
     Contact Information:
     - Phone Number*
     - Email Address*
     - Street Address
     - City
     - Province
     - Postal Code
     
     SACE Registration:
     - SACE Number
     - Phase Registered
     - Subjects Registered
     
     Quantum Tests:
     - Maths Passed (Yes/No)
     - Science Passed (Yes/No)
     
     Criminal Record:
     - Checked (Yes/No)
     - Check Date
     
     Agreement:
     - Signed (Yes/No)
     - Agreement File Upload
     
     Banking Details:
     - Bank Name
     - Account Holder
     - Account Number
     - Branch Code
     - Account Type
     
     Work Preferences:
     - Preferred Working Areas (Multi-select)
     ```

2. **Agent Display** (`[wecoza_display_agents]`)
   - Responsive Bootstrap 5 table
   - Features:
     - Global search functionality
     - Column visibility toggle (9 columns)
     - Pagination (10/25/50/100 records)
     - Detailed modal view with 4 tabs:
       1. Agent Information
       2. Identification & Contact
       3. Current Status
       4. Progression History
   - Action buttons (Edit/Delete - currently non-functional)
   - Currently shows static demo data

3. **JavaScript Functionality** (`agents-app.js`)
   - Bootstrap 5 form validation
   - SA ID checksum algorithm implementation
   - Passport number format validation
   - Dynamic field toggling (ID type selection)
   - Select2 integration for multi-select
   - Loader animation support
   - Form state management

#### Missing/Incomplete Features
- No database insert/update/delete operations
- No AJAX handlers for data operations
- Static demo data instead of dynamic content
- File upload handling not implemented
- Edit/Delete buttons non-functional
- No data export functionality
- No email notifications
- No audit trail/history tracking

### Database Schema (PostgreSQL)

#### Primary Table: agents
```sql
CREATE TABLE agents (
    id SERIAL PRIMARY KEY,
    title VARCHAR(50),
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    known_as VARCHAR(255),
    gender VARCHAR(20),
    race VARCHAR(50),
    id_number VARCHAR(20),
    passport_number VARCHAR(50),
    phone VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    street_address TEXT,
    city VARCHAR(255),
    province VARCHAR(255),
    postal_code VARCHAR(20),
    sace_number VARCHAR(100),
    phase_registered VARCHAR(100),
    subjects_registered TEXT,
    quantum_maths_passed BOOLEAN DEFAULT FALSE,
    quantum_science_passed BOOLEAN DEFAULT FALSE,
    criminal_record_checked BOOLEAN DEFAULT FALSE,
    criminal_record_date DATE,
    signed_agreement BOOLEAN DEFAULT FALSE,
    agreement_file_path VARCHAR(500),
    bank_name VARCHAR(255),
    account_holder VARCHAR(255),
    account_number VARCHAR(50),
    branch_code VARCHAR(20),
    account_type VARCHAR(50),
    preferred_areas TEXT, -- JSON array
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    CONSTRAINT email_unique UNIQUE (email),
    CONSTRAINT id_number_unique UNIQUE (id_number)
);

-- Related tables (structure TBD during investigation)
CREATE TABLE agent_absences (
    id SERIAL PRIMARY KEY,
    agent_id INT REFERENCES agents(id),
    absence_date DATE,
    reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE agent_notes (
    id SERIAL PRIMARY KEY,
    agent_id INT REFERENCES agents(id),
    note TEXT,
    note_type VARCHAR(50),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE agent_orders (
    id SERIAL PRIMARY KEY,
    agent_id INT REFERENCES agents(id),
    order_number VARCHAR(100),
    order_date DATE,
    amount DECIMAL(10,2),
    status VARCHAR(50)
);

CREATE TABLE agent_products (
    id SERIAL PRIMARY KEY,
    agent_id INT REFERENCES agents(id),
    product_id INT,
    training_date DATE,
    certification_status VARCHAR(50)
);

CREATE TABLE agent_qa_visits (
    id SERIAL PRIMARY KEY,
    agent_id INT REFERENCES agents(id),
    visit_date DATE,
    qa_officer VARCHAR(255),
    rating INT,
    comments TEXT
);

CREATE TABLE agent_replacements (
    id SERIAL PRIMARY KEY,
    original_agent_id INT REFERENCES agents(id),
    replacement_agent_id INT REFERENCES agents(id),
    replacement_date DATE,
    reason TEXT
);

CREATE TABLE class_agents (
    id SERIAL PRIMARY KEY,
    class_id INT,
    agent_id INT REFERENCES agents(id),
    assigned_date DATE,
    role VARCHAR(50)
);
```

## 3. Plugin Architecture Design

### Complete Plugin Structure
```
wecoza-agents-plugin/
├── wecoza-agents-plugin.php       # Main plugin file
├── composer.json                  # PSR-4 autoloading
├── composer.lock                  # Lock file (gitignored)
├── package.json                   # NPM dependencies (if needed)
├── README.md                      # Plugin documentation
├── CHANGELOG.md                   # Version history
├── LICENSE                        # License file
├── uninstall.php                  # Clean uninstall handler
├── .gitignore                     # Git ignore file
├── .editorconfig                  # Editor configuration
├── phpcs.xml                      # PHP CodeSniffer rules
│
├── includes/                      # Core plugin files
│   ├── index.php                 # Security
│   ├── class-plugin.php          # Main plugin class
│   ├── class-activator.php       # Activation hooks
│   ├── class-deactivator.php     # Deactivation hooks
│   └── class-constants.php       # Plugin constants
│
├── src/                          # PSR-4 autoloaded classes
│   ├── index.php                # Security
│   ├── Database/
│   │   ├── index.php
│   │   ├── DatabaseService.php   # Database abstraction
│   │   ├── AgentQueries.php      # Agent-specific queries
│   │   └── DatabaseLogger.php    # Query logging
│   │
│   ├── Shortcodes/
│   │   ├── index.php
│   │   ├── AbstractShortcode.php # Base shortcode class
│   │   ├── CaptureAgentShortcode.php
│   │   └── DisplayAgentShortcode.php
│   │
│   ├── Controllers/
│   │   ├── index.php
│   │   └── AgentController.php   # Future AJAX/CRUD operations
│   │
│   ├── Models/
│   │   ├── index.php
│   │   └── Agent.php            # Agent data model
│   │
│   ├── Forms/
│   │   ├── index.php
│   │   ├── AgentCaptureForm.php # Form processing
│   │   └── FormValidator.php     # Form validation
│   │
│   ├── Helpers/
│   │   ├── index.php
│   │   ├── ValidationHelper.php  # ID/Passport validation
│   │   ├── ArrayHelper.php       # Array utilities
│   │   └── StringHelper.php      # String utilities
│   │
│   └── Admin/                    # Future admin features
│       ├── index.php
│       └── AgentSettings.php     # Settings page
│
├── assets/
│   ├── index.php
│   ├── js/
│   │   ├── index.php
│   │   ├── agents-app.js        # Main JavaScript
│   │   ├── agents-app.min.js    # Minified version
│   │   └── admin/               # Future admin JS
│   │
│   ├── css/
│   │   ├── index.php
│   │   ├── agents-extracted.css  # Agent-specific styles
│   │   ├── agents-extracted.min.css
│   │   └── admin/               # Future admin CSS
│   │
│   └── images/                  # Plugin images
│       └── index.php
│
├── templates/                    # Template files
│   ├── index.php
│   ├── forms/
│   │   ├── index.php
│   │   └── agent-capture-form.php
│   │
│   ├── display/
│   │   ├── index.php
│   │   ├── agent-display-table.php
│   │   └── agent-modal.php
│   │
│   └── partials/                # Reusable template parts
│       ├── index.php
│       └── agent-fields.php
│
├── languages/                    # Translations
│   ├── index.php
│   ├── wecoza-agents-plugin.pot  # Translation template
│   └── README.md                # Translation guide
│
├── logs/                        # Error/debug logs
│   ├── index.php
│   └── .htaccess               # Deny direct access
│
├── vendor/                      # Composer dependencies (gitignored)
│
└── tests/                       # Future unit tests
    ├── index.php
    └── bootstrap.php
```

### Technical Architecture

#### Plugin Header
```php
<?php
/**
 * Plugin Name: WeCoza Agents Plugin
 * Plugin URI: https://wecoza.co.za/plugins/agents
 * Description: Comprehensive agent management system for WeCoza
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: WeCoza Development Team
 * Author URI: https://wecoza.co.za
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wecoza-agents-plugin
 * Domain Path: /languages
 */
```

#### Database Layer
- Singleton pattern for database connection
- Support PostgreSQL (primary) and MySQL (fallback)
- Connection pooling for performance
- Query logging for debugging
- Prepared statements for all queries
- Transaction support
- Error handling with fallback

#### Shortcode Implementation
- OOP approach with AbstractShortcode base class
- Lazy loading - only initialize when shortcode is used
- Template-based rendering with override capability
- Proper attribute parsing and validation
- Nonce verification for forms
- Output buffering for clean rendering

#### Security Architecture
- Role-based access control using WordPress capabilities
- Nonce verification on all forms and AJAX calls
- Input validation and sanitization
- Output escaping
- File upload validation (MIME type, size, extension)
- SQL injection prevention via prepared statements
- XSS prevention via proper escaping

#### Performance Optimization
- Asset loading only when shortcodes are present
- JavaScript and CSS minification
- Database query caching
- Lazy loading of components
- Proper WordPress transients usage

## 4. Detailed Migration Strategy

### Pre-Migration Phase (Critical Path)

#### Investigation Tasks
1. **Complete File Inventory**
   ```bash
   # Search for all agent references
   grep -r "agent" --include="*.php" --include="*.js" .
   grep -r "wecoza_capture_agents" .
   grep -r "wecoza_display_agents" .
   ```

2. **Database Schema Documentation**
   ```sql
   -- Export complete schema
   \d agents
   \d agent_*
   \d class_agents
   ```

3. **CSS Extraction**
   ```bash
   # Search for agent-specific styles
   grep -n "agent" ydcoza-styles.css
   ```

4. **Dependency Analysis**
   - Document all WordPress hooks used
   - List all JavaScript dependencies
   - Identify theme-specific functions

### Phase 1: Plugin Foundation (Week 1)

#### Day 1-2: Basic Structure
1. **Create Plugin Directory**
   ```bash
   mkdir -p wecoza-agents-plugin/{includes,src,assets,templates,languages,logs}
   touch wecoza-agents-plugin/index.php  # Security
   ```

2. **Main Plugin File**
   - Add plugin headers
   - PHP/WordPress version checks
   - Define plugin constants
   - Include autoloader

3. **Composer Setup**
   ```json
   {
     "name": "wecoza/agents-plugin",
     "description": "Agent management plugin for WeCoza",
     "type": "wordpress-plugin",
     "require": {
       "php": ">=7.4"
     },
     "autoload": {
       "psr-4": {
         "WeCoza\\Agents\\": "src/"
       }
     }
   }
   ```

#### Day 3-4: Core Classes
1. **Plugin Class**
   - Singleton pattern
   - Hook registration
   - Component initialization
   - Dependency injection container

2. **Activator/Deactivator**
   - Database table checks
   - Option initialization
   - Capability registration
   - Cache flushing

#### Day 5-7: Database Service
1. **DatabaseService Class**
   - Copy from theme
   - Update namespace
   - Add connection pooling
   - Implement query logging

2. **AgentQueries Class**
   - CRUD method stubs
   - Prepared statement templates
   - Query builder helpers

### Phase 2: Code Migration (Week 2)

#### Day 8-10: Shortcode Classes
1. **AbstractShortcode**
   ```php
   abstract class AbstractShortcode {
       protected $tag;
       protected $defaults = [];
       abstract public function render($atts, $content = '');
       protected function checkPermissions() {}
       protected function loadTemplate($template, $data = []) {}
   }
   ```

2. **Shortcode Implementation**
   - Extract logic from procedural code
   - Implement render methods
   - Add permission checks
   - Set up template loading

#### Day 11-12: Asset Migration
1. **JavaScript Migration**
   - Copy agents-app.js
   - Update AJAX endpoints
   - Add proper localization
   - Create minified version

2. **CSS Extraction**
   - Extract agent styles
   - Create minified version
   - Document remaining styles

#### Day 13-14: Template System
1. **Template Loader**
   - Check theme for overrides
   - Load plugin templates
   - Pass data to templates
   - Handle missing templates

2. **Template Files**
   - Extract HTML from shortcodes
   - Create modular templates
   - Add hooks for customization

### Phase 3: Integration & Testing (Week 3)

#### Day 15-17: Theme Cleanup
1. **Deprecation Implementation**
   ```php
   // In each deprecated file
   _deprecated_file(
       __FILE__,
       '1.0.0',
       'wecoza-agents-plugin',
       'Agent functionality has moved to WeCoza Agents Plugin'
   );
   ```

2. **Safe Removal**
   - Comment includes with dates
   - Add admin notices
   - Log usage to deprecation log

#### Day 18-19: Testing
1. **Functional Testing**
   - Test each shortcode
   - Verify form validation
   - Check modal functionality
   - Test with different roles

2. **Compatibility Testing**
   - Different WordPress versions
   - Various themes
   - Plugin conflicts
   - Browser testing

#### Day 20-21: Performance & Security
1. **Performance Optimization**
   - Query optimization
   - Asset minification
   - Caching implementation

2. **Security Audit**
   - Code review
   - Penetration testing
   - Vulnerability scanning

### Phase 4: Documentation & Deployment (Week 4)

#### Day 22-23: Documentation
1. **User Documentation**
   - Installation guide
   - Shortcode reference
   - FAQ section
   - Troubleshooting

2. **Developer Documentation**
   - Code architecture
   - Hook reference
   - Contributing guide

#### Day 24-25: Final Testing
1. **UAT Testing**
   - Real-world scenarios
   - Edge cases
   - Load testing

#### Day 26-28: Deployment
1. **Deployment Checklist**
   - [ ] All tests passing
   - [ ] Documentation complete
   - [ ] Deprecation notices in place
   - [ ] Backup created
   - [ ] Rollback plan ready

## 5. Implementation Details

### WordPress Integration

#### Hooks and Filters
```php
// Action hooks
do_action('wecoza_agents_before_capture_form', $args);
do_action('wecoza_agents_after_capture_form', $args);
do_action('wecoza_agents_before_display_table', $args);
do_action('wecoza_agents_after_display_table', $args);

// Filter hooks
apply_filters('wecoza_agents_form_fields', $fields);
apply_filters('wecoza_agents_table_columns', $columns);
apply_filters('wecoza_agents_validation_rules', $rules);
```

#### Internationalization
```php
// Load text domain
load_plugin_textdomain(
    'wecoza-agents-plugin',
    false,
    dirname(plugin_basename(__FILE__)) . '/languages'
);

// Usage
__('Agent Name', 'wecoza-agents-plugin');
_e('Save Agent', 'wecoza-agents-plugin');
```

### Error Handling

#### Logging Strategy
```php
class AgentLogger {
    public static function log($message, $level = 'info') {
        if (WP_DEBUG) {
            error_log("[WeCoza Agents] [$level] $message");
        }
        // Also log to custom file
    }
}
```

#### User-Facing Errors
```php
// Display friendly error messages
if ($error) {
    wp_die(
        __('Unable to process your request. Please try again.', 'wecoza-agents-plugin'),
        __('Error', 'wecoza-agents-plugin'),
        ['response' => 500]
    );
}
```

## 6. Testing Requirements

### Unit Testing
- SA ID validation algorithm
- Passport validation rules
- Database connection logic
- Permission checks
- Form validation

### Integration Testing
- Shortcode rendering in posts/pages
- Database failover mechanism
- Theme override functionality
- Plugin activation/deactivation

### User Acceptance Testing
- Form submission workflow
- Data display and search
- Modal interactions
- Permission-based access

### Performance Testing
- Page load with 1000+ agents
- Database query execution time
- Asset loading optimization
- Memory usage profiling

## 7. Risk Mitigation

### Technical Risks

#### Database Connection Failures
- **Risk**: PostgreSQL unavailable
- **Mitigation**: Automatic MySQL fallback
- **Monitoring**: Connection status logging

#### JavaScript Conflicts
- **Risk**: Library version conflicts
- **Mitigation**: Namespace all code, use no-conflict mode
- **Testing**: Test with popular plugins

#### Performance Degradation
- **Risk**: Slow queries with large datasets
- **Mitigation**: Implement pagination, add indexes
- **Monitoring**: Query performance logging

### Security Risks

#### SQL Injection
- **Risk**: Malicious database queries
- **Mitigation**: Use prepared statements exclusively
- **Validation**: Security audit before release

#### XSS Attacks
- **Risk**: Script injection via forms
- **Mitigation**: Escape all output, validate input
- **Testing**: Penetration testing

#### File Upload Vulnerabilities
- **Risk**: Malicious file uploads
- **Mitigation**: Validate MIME types, restrict extensions
- **Implementation**: Use WordPress upload handlers

## 8. Future Roadmap

### Version 1.1 (CRUD Operations)
- Implement form submission to database
- Add update functionality
- Delete with soft delete option
- Bulk operations support

### Version 1.2 (AJAX Enhancement)
- Convert forms to AJAX
- Real-time search
- Inline editing
- Auto-save functionality

### Version 1.3 (Reporting)
- Agent performance dashboard
- Export to CSV/PDF
- Email reports
- Analytics integration

### Version 2.0 (Advanced Features)
- REST API
- Mobile app support
- Multi-language agents
- Advanced permissions

## 9. Appendices

### A. Complete Database Schema
[See Section 2 for full schema]

### B. Demo Data Structure
```php
$demo_agents = [
    [
        'id' => 1,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        // ... complete structure
    ]
];
```

### C. Migration Checklist
- [ ] Pre-migration investigation complete
- [ ] Plugin structure created
- [ ] Database service implemented
- [ ] Shortcodes migrated
- [ ] Assets moved
- [ ] Templates created
- [ ] Security implemented
- [ ] Theme cleaned up
- [ ] Testing complete
- [ ] Documentation finished
- [ ] Deployment successful

### D. Support Resources
- Developer Email: dev@wecoza.co.za
- Documentation: https://docs.wecoza.co.za/agents-plugin
- Issue Tracker: GitHub repository
- Community Forum: https://community.wecoza.co.za

---

## Approval

This PRD has been reviewed and approved for implementation.

**Approved by**: [Pending]  
**Date**: [Pending]  
**Version**: 2.0