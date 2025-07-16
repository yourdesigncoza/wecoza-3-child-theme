# Product Requirements Document (PRD)
# WeCoza Agents Plugin Extraction

## 1. Executive Summary

### Project Overview
Extract all agent-related functionality from the WeCoza 3 Child Theme into a standalone WordPress plugin named "wecoza-agents-plugin". This plugin will manage agent information including capture, display, and future CRUD operations while maintaining the existing PostgreSQL database structure.

### Business Objectives
- Decouple agent functionality from the theme for better modularity
- Enable agent management independent of theme selection
- Maintain existing functionality while preparing for future enhancements
- Follow established patterns from the wecoza-classes-plugin extraction

### Success Criteria
- All agent functionality works identically after extraction
- Plugin operates independently without theme dependency
- Existing shortcodes continue functioning
- No data loss during migration
- Clean separation with proper deprecation notices

## 2. Current State Analysis

### Existing Agent Functionality

#### Files and Structure
```
/assets/agents/
├── agents-capture-shortcode.php    # Form for capturing agent information
├── agents-display-shortcode.php    # Display agents table with modals
├── agents-functions.php           # Core loading and initialization
└── js/
    └── agents-app.js             # Form validation and UI interactions

/app/Controllers/
└── AgentController.php           # MVC controller (placeholder implementation)
```

#### Implemented Features
1. **Agent Capture Form** (`[wecoza_capture_agents]`)
   - Comprehensive form with validation
   - Fields: personal info, contact, SACE registration, banking, quantum tests
   - SA ID/Passport validation
   - File upload for signed agreements
   - Bootstrap 5 styling

2. **Agent Display** (`[wecoza_display_agents]`)
   - Responsive Bootstrap table
   - Search functionality
   - Column visibility toggle
   - Pagination
   - Detailed modal view with tabs
   - Currently shows static demo data

3. **JavaScript Functionality**
   - Form validation
   - SA ID checksum validation
   - Dynamic field toggling
   - Select2 integration
   - Loader animations

#### Missing/Incomplete Features
- No database insert/update/delete operations
- No AJAX handlers for data operations
- Static demo data instead of dynamic content
- File upload handling not implemented
- Edit/Delete buttons non-functional

### Database Schema
PostgreSQL tables (existing):
- `agents` - Main agent information
- `agent_absences` - Absence tracking
- `agent_notes` - Historical notes
- `agent_orders` - Order information
- `agent_products` - Product training associations
- `agent_qa_visits` - QA visit records
- `agent_replacements` - Replacement tracking
- `class_agents` - Class associations

## 3. Plugin Architecture Design

### Plugin Structure
```
wecoza-agents-plugin/
├── wecoza-agents-plugin.php       # Main plugin file
├── composer.json                  # PSR-4 autoloading
├── README.md                      # Plugin documentation
├── uninstall.php                  # Clean uninstall handler
├── includes/
│   ├── class-plugin.php          # Main plugin class
│   ├── class-activator.php       # Activation hooks
│   └── class-deactivator.php     # Deactivation hooks
├── src/
│   ├── Database/
│   │   ├── DatabaseService.php   # Database abstraction (PostgreSQL/MySQL)
│   │   └── AgentQueries.php      # Agent-specific queries
│   ├── Shortcodes/
│   │   ├── CaptureAgentShortcode.php
│   │   └── DisplayAgentShortcode.php
│   ├── Controllers/
│   │   └── AgentController.php   # Future AJAX/CRUD operations
│   ├── Models/
│   │   └── Agent.php            # Agent data model
│   └── Helpers/
│       └── ValidationHelper.php  # ID/Passport validation
├── assets/
│   ├── js/
│   │   └── agents-app.js        # Frontend JavaScript
│   └── css/
│       └── agents-extracted.css  # Agent-specific styles (if any)
├── templates/
│   ├── agent-capture-form.php
│   └── agent-display-table.php
└── deprecation-log.txt           # Track deprecated theme files
```

### Technical Architecture

#### Database Layer
- Duplicate DatabaseService from theme
- Support PostgreSQL (primary) and MySQL (fallback)
- Use WordPress options for PostgreSQL connection settings
- Prepared statements for all queries

#### Shortcode Implementation
- Maintain existing shortcode names for compatibility
- Use OOP approach with dedicated classes
- Template-based rendering
- Proper nonce verification

#### Security Considerations
- Role-based access (Editors and Admins only)
- Nonce verification on all forms
- Prepared database statements
- Input validation and sanitization
- File upload security (future implementation)

## 4. Migration Strategy

### Phase 1: Plugin Creation
1. Create plugin structure and boilerplate
2. Implement PSR-4 autoloading
3. Set up activation/deactivation hooks
4. Duplicate DatabaseService from theme

### Phase 2: Code Migration
1. Extract agent-specific code from theme
2. Refactor shortcodes into OOP classes
3. Migrate JavaScript and styles
4. Update asset enqueueing
5. Implement template system

### Phase 3: Theme Cleanup
1. Add deprecation notices to theme files
2. Comment out agent-related includes
3. Create deprecation log
4. Remove agent registrations from theme

### Phase 4: Testing & Validation
1. Test both shortcodes functionality
2. Verify database connections
3. Test with different user roles
4. Validate deprecation notices
5. Ensure no theme dependencies

## 5. Implementation Details

### Shortcode Registration
```php
// Main plugin class
public function register_shortcodes() {
    add_shortcode('wecoza_capture_agents', [$this->capture_shortcode, 'render']);
    add_shortcode('wecoza_display_agents', [$this->display_shortcode, 'render']);
}
```

### Database Connection
```php
// Follow theme pattern: PostgreSQL primary, MySQL fallback
$pg_settings = get_option('wecoza_agents_pg_settings');
if ($pg_settings) {
    // Connect to PostgreSQL
} else {
    // Use WordPress MySQL
}
```

### Access Control
```php
// Check user capabilities
if (!current_user_can('edit_posts')) {
    return 'Insufficient permissions';
}
```

### Asset Management
- Enqueue scripts/styles only when shortcodes are present
- Reference theme's ydcoza-styles.css for main styling
- Include extracted agent-specific styles if needed

## 6. Future Enhancements (Post-Migration)

### To Be Implemented Later
1. **CRUD Operations**
   - Create new agents (form submission)
   - Update agent information
   - Delete agents
   - Bulk operations

2. **AJAX Handlers**
   - Dynamic data loading
   - Real-time search
   - Async form submission
   - File upload processing

3. **Reporting & Analytics**
   - Agent performance metrics
   - Attendance reports
   - Training completion stats
   - Export functionality

4. **Integration Points**
   - APIs for other plugins
   - Webhook support
   - Event system for agent actions
   - Integration with classes plugin

5. **Enhanced Features**
   - Agent document management
   - Communication log
   - Automated notifications
   - Batch import/export

## 7. Testing Strategy

### Functional Testing
1. Shortcode rendering on pages/posts
2. Form validation and submission
3. Data display and search
4. Modal functionality
5. User permission checks

### Compatibility Testing
1. Theme independence
2. WordPress version compatibility
3. PHP version requirements (7.4+)
4. Database connection fallback
5. Plugin conflict testing

### Performance Testing
1. Page load times with shortcodes
2. Database query optimization
3. Asset loading efficiency
4. Memory usage monitoring

## 8. Documentation Requirements

### User Documentation
- README with installation instructions
- Shortcode usage examples
- Troubleshooting guide
- FAQ section

### Developer Documentation
- Code architecture overview
- Database schema reference
- Hook and filter documentation
- API documentation (future)

### Migration Guide
- Step-by-step migration process
- Deprecation notice explanations
- Rollback procedures
- Common issues and solutions

## 9. Risk Assessment

### Technical Risks
- **Database Connection Issues**: Mitigated by duplicating proven DatabaseService
- **Theme Dependency**: Eliminated through complete extraction
- **Data Loss**: Prevented by read-only migration approach
- **Breaking Changes**: Avoided by maintaining shortcode names

### Business Risks
- **Downtime**: Minimal - plugin can be tested before theme cleanup
- **User Confusion**: Addressed through clear documentation
- **Feature Gaps**: Documented for future implementation

## 10. Timeline & Milestones

### Week 1: Foundation
- Create plugin structure
- Set up autoloading and core classes
- Implement database layer
- Begin code extraction

### Week 2: Migration
- Complete code migration
- Refactor into OOP structure
- Implement shortcodes
- Migrate assets

### Week 3: Integration & Testing
- Theme cleanup with deprecation
- Comprehensive testing
- Documentation creation
- Bug fixes and optimization

### Week 4: Finalization
- Final testing and validation
- Documentation review
- Deployment preparation
- Post-deployment monitoring

## 11. Success Metrics

### Immediate Success Indicators
- Plugin activates without errors
- Shortcodes render correctly
- No functionality regression
- Clean deprecation implementation

### Long-term Success Indicators
- Successful CRUD implementation
- Improved maintainability
- Easier feature additions
- Reduced theme complexity

## 12. Appendices

### A. Database Schema Reference
```sql
-- Main agents table structure
CREATE TABLE agents (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50),
    id_number VARCHAR(20),
    -- ... additional fields
);
```

### B. Shortcode Examples
```
[wecoza_capture_agents]
[wecoza_display_agents]
```

### C. File Mapping
| Theme Location | Plugin Location |
|---------------|-----------------|
| /assets/agents/agents-capture-shortcode.php | /src/Shortcodes/CaptureAgentShortcode.php |
| /assets/agents/agents-display-shortcode.php | /src/Shortcodes/DisplayAgentShortcode.php |
| /assets/agents/js/agents-app.js | /assets/js/agents-app.js |

---

## Document Version
- Version: 1.0
- Date: 2025-01-16
- Author: Development Team
- Status: Ready for Implementation