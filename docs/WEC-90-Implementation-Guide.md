# WEC-90 Implementation Guide: Class CRUD Flow Optimization

## Overview

This document provides a comprehensive guide to the WEC-90 implementation, which transforms the WeCoza class management system from a mixed-mode approach to a proper MVC (Model-View-Controller) architecture with RESTful operations.

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Implementation Phases](#implementation-phases)
3. [File Structure](#file-structure)
4. [Usage Guide](#usage-guide)
5. [Migration Guide](#migration-guide)
6. [Testing](#testing)
7. [Troubleshooting](#troubleshooting)

## Architecture Overview

### Before WEC-90 (Mixed-Mode)
- Single controller handling both create and update operations
- Mixed view templates with conditional logic
- Direct model access from controllers
- No centralized validation
- Complex form handling with mode switching

### After WEC-90 (MVC Architecture)
- **Repository Pattern**: Clean data access layer
- **Service Layer**: Business logic separation
- **Dedicated Controllers**: RESTful CRUD operations
- **Dedicated Views**: Separate templates for each operation
- **Centralized Validation**: Consistent validation rules
- **Clean URLs**: RESTful routing structure

## Implementation Phases

### Phase 1: Repository Pattern & Data Layer (WEC-90-1) ✅
**Files Created:**
- `app/Contracts/ClassRepositoryInterface.php` - Repository contract
- `app/Repositories/ClassRepository.php` - Data access implementation
- `app/Services/ClassService.php` - Business logic layer
- `app/Validators/ClassValidator.php` - Centralized validation

**Key Features:**
- Clean CRUD operations with optimized queries
- Comprehensive validation with business rules
- Transaction support for data integrity
- Error handling and logging

### Phase 2: Dedicated Controller Methods (WEC-90-2) ✅
**Enhancements:**
- Added RESTful methods: `index()`, `create()`, `store()`, `show()`, `edit()`, `update()`, `destroy()`
- Dependency injection for testability
- Proper separation of concerns
- Backward compatibility maintained

### Phase 3: Dedicated View Templates (WEC-90-3) ✅
**Files Created:**
- `app/Views/classes/index.php` - Class listing with pagination and filters
- `app/Views/classes/create.php` - Create new class form
- `app/Views/classes/edit.php` - Edit existing class form
- `app/Views/classes/show.php` - View class details

**Key Features:**
- Bootstrap 5 responsive design
- Form validation and AJAX submission
- Change tracking in edit mode
- Print-friendly layouts

### Phase 4: RESTful Routing (WEC-90-4) ✅
**Files Created:**
- `app/Routes/ClassRoutes.php` - RESTful routing system
- `public/js/class-crud.js` - Optimized JavaScript for CRUD operations

**URL Structure:**
- `GET /classes` - List all classes
- `GET /classes/create` - Show create form
- `POST /classes` - Store new class
- `GET /classes/{id}` - Show class details
- `GET /classes/{id}/edit` - Show edit form
- `PUT /classes/{id}` - Update class
- `DELETE /classes/{id}` - Delete class

### Phase 5: Migration & Testing (WEC-90-5) ✅
**Files Created:**
- `app/Migrations/WEC-90-Migration.php` - Migration script
- `tests/WEC-90-1-repository-test.php` - Basic tests
- `docs/WEC-90-Implementation-Guide.md` - This documentation

## File Structure

```
wecoza_3_child_theme/
├── app/
│   ├── Contracts/
│   │   └── ClassRepositoryInterface.php
│   ├── Controllers/
│   │   └── ClassController.php (refactored)
│   ├── Migrations/
│   │   └── WEC-90-Migration.php
│   ├── Repositories/
│   │   └── ClassRepository.php
│   ├── Routes/
│   │   └── ClassRoutes.php
│   ├── Services/
│   │   └── ClassService.php
│   ├── Validators/
│   │   └── ClassValidator.php
│   └── Views/
│       └── classes/
│           ├── index.php
│           ├── create.php
│           ├── edit.php
│           └── show.php
├── docs/
│   └── WEC-90-Implementation-Guide.md
├── public/
│   └── js/
│       └── class-crud.js
└── tests/
    └── WEC-90-1-repository-test.php
```

## Usage Guide

### For Developers

#### Using the Repository Pattern
```php
// Get repository instance
$repository = new ClassRepository();

// Find a class
$class = $repository->findById(123);

// Get paginated classes
$result = $repository->paginate(1, 10, ['client_id' => 5]);
```

#### Using the Service Layer
```php
// Get service instance
$service = new ClassService($repository, $validator);

// Create a class
$result = $service->createClass($data);
if ($result['success']) {
    $class = $result['data'];
}

// Update a class
$result = $service->updateClass($id, $data);
```

#### Using the Controller
```php
// Initialize controller with dependencies
$controller = new ClassController($service, $repository, $validator);

// Handle index request
$output = $controller->index(['per_page' => 20]);
```

### For Content Managers

#### Shortcodes Available
```
[wecoza_classes_index per_page="10" client_id="5"]
[wecoza_class_create redirect_url="/success"]
[wecoza_class_show class_id="123"]
[wecoza_class_edit class_id="123"]
```

#### URL Structure
- Browse classes: `/classes`
- Create class: `/classes/create`
- View class: `/classes/123`
- Edit class: `/classes/123/edit`

## Migration Guide

### Running the Migration

1. **Backup your database** before running the migration
2. Run the migration script:
```php
$migration = new WEC90Migration();
$result = $migration->migrate();

if ($result['success']) {
    echo "Migration completed successfully";
} else {
    echo "Migration failed: " . $result['message'];
}
```

### Migration Steps
1. **Backup**: Creates `classes_backup_wec90` table
2. **Schema Update**: Adds new columns and indexes
3. **Shortcode Migration**: Updates posts/pages with migration notes
4. **Options Update**: Sets migration flags
5. **Cache Clear**: Flushes rewrite rules and caches

### Rollback Process
```php
$migration = new WEC90Migration();
$result = $migration->rollback();
```

### Backward Compatibility
- Existing shortcodes continue to work
- Old URLs are maintained
- Data structure remains compatible
- Gradual migration path available

## Testing

### Running Tests
```bash
# Basic repository pattern test
php tests/WEC-90-1-repository-test.php

# WordPress integration test (requires WordPress environment)
wp eval-file tests/WEC-90-1-repository-test.php
```

### Test Coverage
- Repository instantiation and methods
- Service layer functionality
- Validation logic
- CRUD operations
- Error handling

### Manual Testing Checklist
- [ ] Create new class via form
- [ ] Edit existing class
- [ ] View class details
- [ ] Delete class
- [ ] Filter and search classes
- [ ] Pagination works correctly
- [ ] AJAX operations function properly
- [ ] Validation prevents invalid data
- [ ] Error messages display correctly

## Troubleshooting

### Common Issues

#### 1. "Class not found" errors
**Cause**: Autoloading issues or missing files
**Solution**: 
- Verify all files are uploaded correctly
- Check namespace declarations
- Ensure proper autoloading setup

#### 2. Database connection errors
**Cause**: Database service not properly configured
**Solution**:
- Check database credentials in `includes/admin/settings.php`
- Verify PostgreSQL connection
- Test database connectivity

#### 3. AJAX requests failing
**Cause**: Nonce verification or URL issues
**Solution**:
- Verify `wecozaClass.ajaxUrl` is properly set
- Check nonce generation and verification
- Ensure AJAX handlers are registered

#### 4. Rewrite rules not working
**Cause**: WordPress rewrite rules not flushed
**Solution**:
```php
// Flush rewrite rules
ClassRoutes::flushRewriteRules();
```

#### 5. Validation errors
**Cause**: Data format or business rule violations
**Solution**:
- Check validation rules in `ClassValidator.php`
- Verify data format matches expectations
- Review business logic requirements

### Debug Mode
Enable debug logging by adding to `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

### Performance Optimization
- Database indexes are automatically added during migration
- Use pagination for large datasets
- Implement caching for frequently accessed data
- Monitor query performance

## Support

For technical support or questions about the WEC-90 implementation:
- Review this documentation
- Check the troubleshooting section
- Examine the migration logs
- Contact the development team

## Version History

- **v1.0.0** - Initial WEC-90 implementation
  - Repository pattern implementation
  - RESTful controller methods
  - Dedicated view templates
  - Clean URL routing
  - Migration system
