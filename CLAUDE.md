# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a WordPress child theme for WeCoza based on Bootscore, implementing a modern MVC architecture for educational platform functionality. The theme includes custom dashboards with timeline views, data visualization, and specialized features for tracking educational progress.

## Development Commands

### Theme Packaging
```bash
# Package theme for WordPress upload
./package-theme.sh
```

### Common WordPress Development
```bash
# View WordPress debug logs
tail -f /opt/lampp/logs/php_error_log

# Check database connectivity
php -f /opt/lampp/htdocs/wecoza/wp-content/themes/wecoza_3_child_theme/includes/functions/db.php

# Clear WordPress cache (if using cache plugins)
wp cache flush
```

## Architecture & Code Structure

### MVC Framework
The theme implements a custom MVC architecture under the `WeCoza` namespace:

**Bootstrap System**: 
- Entry point: `app/bootstrap.php`
- Autoloader for `WeCoza\*` classes
- Configuration loader via `config()` function
- View renderer via `view()` function

**Controllers** (`app/Controllers/`):
- `NavigationController.php` - Menu and navigation management
- Controllers auto-initialize via `config/app.php` configuration

**Services** (`app/Services/`):
- `DatabaseService.php` - PostgreSQL connection singleton with PDO
- Clean separation between data layer and business logic

**Views** (`app/Views/`):
- `.view.php` extension for view files  
- Data passed via extract() in view helper
- Bootstrap 5 UI components

### Database Architecture

**Dual Database System**:
1. **PostgreSQL** (Primary) - DigitalOcean hosted for main application data
2. **MySQL** (Logger) - SQL query storage and logging system

**Connection Classes**:
- `Wecoza3_DB` - PostgreSQL connection with graceful error handling
- `Wecoza3_Logger` - MySQL singleton for query logging and execution

**Key Features**:
- Base64 encoded SQL storage for security
- Comprehensive error logging to `wp-content/wecoza-error.log`
- Prepared statements for all database operations
- SSL connections required for PostgreSQL

### Asset Management

**CSS Loading Order** (critical for styling):
1. Parent Bootscore styles (dequeued)
2. `ydcoza-bootstrap-demo.css` 
3. Bootstrap Icons CDN
4. `ydcoza-theme.css`
5. **`ydcoza-styles.css` (loads last at priority 99)**

**JavaScript Dependencies**:
- jQuery (WordPress core)
- Bootstrap 5 (from parent theme)
- Chart.js, Select2, Popper.js (CDN)
- Custom `app.js` with AJAX handlers

### Shortcode System

**Data Visualization**:
- `[wecoza_echart]` - ECharts integration (tree/sunburst charts)
- `[wecoza_dynamic_table]` - AJAX data tables with Bootstrap styling

**Navigation**:
- `[wecoza_sidebar_menu]` - Bootstrap sidebar with custom walker

**Implementation**: All shortcodes use database SQL ID references for dynamic data loading.

## Development Guidelines

### Styling Rules
- **ALL CSS** must go in `/includes/css/ydcoza-styles.css`
- Never create separate CSS files in plugin directories
- Always append new styles to existing ydcoza-styles.css
- Respect the CSS loading priority order (ydcoza-styles.css loads last)

### Database Development
- Use `DatabaseService::getInstance()` for PostgreSQL operations
- Use `Wecoza3_Logger` static methods for MySQL operations
- Always wrap database operations in try-catch blocks
- Log errors to `wp-content/wecoza-error.log`

### MVC Development Patterns
```php
// Controller registration in config/app.php
'controllers' => [
    'WeCoza\\Controllers\\NewController',
],

// View rendering
return \WeCoza\view('component-name', ['data' => $data]);

// Service usage  
$db = \WeCoza\Services\Database\DatabaseService::getInstance();
$result = $db->query("SELECT * FROM table WHERE id = ?", [$id]);
```

### Namespace Conventions
- All classes use `WeCoza\` namespace
- Autoloader handles `WeCoza\Controllers\`, `WeCoza\Services\`, etc.
- WordPress functions called with `\` prefix in namespaced files

## File Locations

### Critical Files
- `functions.php` - WordPress integration and asset loading
- `app/bootstrap.php` - MVC system initialization
- `config/app.php` - Application configuration
- `includes/css/ydcoza-styles.css` - **Primary stylesheet**

### WordPress Integration
- `style.css` - Theme header (WordPress requirement)
- `screenshot.png` - Theme screenshot
- `templates/` - Custom page templates
- `includes/functions/` - WordPress helper functions

### Database Scripts
- `includes/functions/db.php` - Database connection classes
- `includes/admin/sql-manager.php` - SQL query management interface
- `includes/db-migrations.php` - Database migrations

## Configuration

### Database Settings
Database credentials stored in WordPress options:
- `wecoza_postgres_*` - PostgreSQL settings
- `wecoza_mysql_*` - MySQL logger settings

### Theme Constants
```php
WECOZA_PLUGIN_VERSION  // Random version for cache busting
WECOZA_CHILD_DIR       // Theme directory path  
WECOZA_CHILD_URL       // Theme URL
WECOZA_PATH            // App path constants
```

## Common Tasks

### Adding New Controller
1. Create `app/Controllers/NewController.php` 
2. Add to `config/app.php` controllers array
3. Register WordPress hooks in constructor

### Adding Database Functionality
1. Use `DatabaseService::getInstance()` for PostgreSQL
2. Use `Wecoza3_Logger::execute_sql_query()` for stored queries
3. Add error handling and logging

### Creating New Views
1. Create `.view.php` file in `app/Views/`
2. Use `\WeCoza\view('name', $data)` to render
3. Access data via extracted variables

### Debugging
- Check `/opt/lampp/logs/php_error_log` for PHP errors
- Check `wp-content/wecoza-error.log` for database errors  
- Use `error_log()` for custom debugging output
- WordPress debug: `WP_DEBUG` and `WP_DEBUG_LOG` in wp-config.php