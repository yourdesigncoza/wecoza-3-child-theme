# WeCoza 3 Child Theme

A WordPress child theme for WeCoza based on Bootscore, providing custom functionality for learner management through a modern MVC architecture with dashboard analytics and timeline features.

## Overview

This child theme extends the Bootscore parent theme with custom functionality specifically designed for WeCoza's educational platform. It includes learner management systems, custom dashboards with timeline views, and specialized features for tracking educational progress. The codebase follows an MVC (Model-View-Controller) architecture for better organization and maintainability.

## Features

### Core Management Systems
- **Learner Management**
  - Portfolio upload and tracking
  - Assessment management
  - Progress monitoring
  - POE (Portfolio of Evidence) system
  - Class information and scheduling
  - Status tracking and history

### Dashboard & Analytics
- **Dynamic Timeline View**: Interactive timeline with scrolling sidebar navigation
- **Data Visualization**: ECharts integration for charts and analytics
- **Custom Dashboards**: Responsive dashboard templates with real-time data
- **Calendar Integration**: Public holiday tracking and class scheduling

### Technical Features
- **MVC Architecture**: Clean separation of concerns with models, views, and controllers
- **Custom Shortcodes**: Modular functionality embedding for data tables and charts
- **Database Services**: Multi-database support with connection management
- **File Upload Services**: Secure file handling and portfolio management
- **Responsive Design**: Bootstrap 5 integration with Phoenix theme styling
- **Modern UI**: Clean, professional interface with enhanced navigation

## Architecture

The codebase follows an MVC architecture:

### Controllers (`/app/Controllers/`)
- `AssessmentController.php` - Assessment management
- `LearnerController.php` - Learner data operations  
- `MainController.php` - Core application logic
- `NavigationController.php` - Menu and navigation
- `ShortcodeListController.php` - Shortcode management

### Models (`/app/Models/`)
- `Learner/LearnerModel.php` - Learner data model
- `Assessment/` - Assessment-related models
- `PublicHoliday/` - Holiday management models

### Views (`/app/Views/`)
- `learner/learner-form.view.php` - Learner form templates
- `components/` - Reusable UI components
- `class-capture-partials/` - Class-specific view partials

### Services (`/app/Services/`)
- `Database/DatabaseService.php` - Database abstraction layer
- `FileUpload/FileUploadService.php` - File handling
- `Calendar/` - Calendar and scheduling services

## Requirements

- **WordPress**: 6.0+
- **Parent Theme**: Bootscore theme
- **PHP**: 8.0+
- **MySQL**: 5.7+ or MariaDB 10.3+
- **Web Server**: Apache/Nginx with mod_rewrite

## Installation

1. Install and activate the Bootscore parent theme
2. Upload this child theme to `/wp-content/themes/wecoza_3_child_theme/`
3. Activate the "Bootscore Child" theme through WordPress admin
4. Configure settings through the WordPress customizer or theme options

## File Structure

```
/app/                           # MVC application structure
  /Controllers/                 # Request handling logic
  /Models/                      # Data models and business logic
  /Views/                       # Template files and UI components
  /Services/                    # Business services and integrations
  /Helpers/                     # Helper functions and utilities
/assets/                        # Front-end assets
  /css/, /js/, /img/           # Compiled assets
  /scss/                       # Source SCSS files
  /learners/                   # Learner-specific components
/includes/                      # WordPress integration
  /css/                        # Additional stylesheets
  /js/                         # JavaScript libraries
  /functions/                  # PHP utility functions
  /shortcodes/                 # Custom shortcode definitions
  /admin/                      # Admin interface components
/templates/                     # Custom page templates
/config/                        # Configuration files
```

## Recent Updates

### Timeline Dashboard Implementation
- Added dynamic timeline view with scrolling sidebar navigation
- Implemented responsive timeline interface for better data visualization
- Enhanced dashboard template with improved user experience

### Codebase Cleanup
- Removed outdated client and agent management systems
- Cleaned up IDE-specific configuration files
- Streamlined project structure for focus on learner management
- Removed legacy documentation and tracking files

### Technical Improvements
- Enhanced MVC architecture implementation  
- Improved database service layer
- Updated CSS styling for modern interface
- Consolidated functionality around core learner management features

## Development

### Local Development
```bash
# Navigate to theme directory
cd /wp-content/themes/wecoza_3_child_theme/

# Theme packaging (if needed)
./package-theme.sh
```

### Branching Strategy
- `main` - Production-ready code
- `master` - Legacy branch (synchronized with main)
- Feature branches: descriptive names for specific features

## Available Shortcodes

The theme provides a comprehensive set of shortcodes for various functionality:

### Data Visualization & Reporting

**`[wecoza_echart]`**
- **Purpose**: Creates interactive ECharts visualizations (tree, sunburst) from SQL data
- **Parameters**: 
  - `sql_id` (required) - Database query ID
  - `type` (optional, default: "tree") - Chart type: "tree" or "sunburst"
  - `style` (optional, default: "width:600px;height:400px;") - CSS styling
- **Example**: `[wecoza_echart sql_id="9" type="tree" style="width:600px;height:400px;"]`

**`[wecoza_dynamic_table]`**
- **Purpose**: Creates dynamic data tables with AJAX loading and Bootstrap styling
- **Parameters**: 
  - `sql_id` (required) - Database query ID
  - `columns` (optional) - Comma-separated column list
  - `exclude_columns_from_editing` (optional) - Non-editable columns
- **Example**: `[wecoza_dynamic_table sql_id="4" columns="class_id,c.subject,c.start_date"]`

### Learner Management

**`[wecoza_display_learners]`**
- **Purpose**: Displays all learners in responsive Bootstrap table with modal details
- **Parameters**: None
- **Example**: `[wecoza_display_learners]`

**`[wecoza_learners_form]`**
- **Purpose**: Comprehensive learner registration form with file upload
- **Parameters**: Various form configuration options
- **Example**: `[wecoza_learners_form]`

**`[wecoza_learners_update_form]`**
- **Purpose**: Form for updating existing learner information
- **Parameters**: Uses URL parameter `learner_id`
- **Example**: `[wecoza_learners_update_form]`

### Navigation & UI

**`[wecoza_sidebar_menu]`**
- **Purpose**: Renders Bootstrap-styled sidebar navigation menu
- **Parameters**: 
  - `container_class` (optional, default: "sidebar-nav")
  - `menu_class` (optional, default: "nav flex-column")
- **Example**: `[wecoza_sidebar_menu container_class="my-nav"]`


### MVC-Based Shortcodes (Development)

The following shortcodes are implemented as stubs in the MVC controllers:

- `[wecoza_learner_capture]` - Learner capture form (placeholder)
- `[wecoza_learner_display]` - Learner display functionality (placeholder)  
- `[wecoza_learner_update]` - Learner update form (placeholder)
- `[wecoza_assessment_capture]` - Assessment capture form (placeholder)
- `[wecoza_assessment_display]` - Assessment display functionality (placeholder)

### Dependencies

Most shortcodes require:
- **Bootstrap 5** - Styling framework
- **jQuery** - JavaScript functionality
- **ECharts** - Data visualization
- **Bootstrap Table** - Advanced table features

## Configuration Files

- `functions.php` - Core theme functionality and WordPress hooks
- `style.css` - Theme header and basic styles  
- `config/app.php` - Application configuration
- `CLAUDE.md` - Development guidance and codebase instructions

## Support & Development

- **Developer**: John Montgomery
- **Company**: YourDesign.co.za
- **Repository**: Private GitHub repository
- **Current Version**: 0.2

## License

This project is proprietary and confidential. All rights reserved by YourDesign.co.za.

---

*Last updated: January 2025*
