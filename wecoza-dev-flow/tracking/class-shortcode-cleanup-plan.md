# Class Shortcode Cleanup Plan

**Task**: Remove all non-functional class-related shortcodes while preserving the working `[wecoza_capture_class]` shortcode

**Date**: Created from comprehensive analysis
**Status**: Planning Phase
**Priority**: High - Code cleanup and maintenance

## Overview

The WeCoza theme currently has multiple class-related shortcodes, but only one is functional. This cleanup will remove all non-functional implementations while preserving the working functionality.

## Shortcode Analysis

### ✅ PRESERVE - Working Shortcode
- **`[wecoza_capture_class]`** - Fully functional class capture form
  - Supports create mode and update mode
  - Has complete form functionality, validation, AJAX submission
  - Used in production

### ❌ REMOVE - Non-Functional Shortcodes

#### WEC-90 Implementation (Modern/RESTful - Non-functional)
- **`[wecoza_classes_index]`** - List all classes functionality
- **`[wecoza_class_create]`** - Modern create form with redirect capability
- **`[wecoza_class_show]`** - Individual class display functionality  
- **`[wecoza_class_edit]`** - Class editing functionality

#### Legacy Implementation (Non-functional)
- **`[wecoza_display_class]`** - Legacy class display functionality

#### Phase 1 Implementation (Non-functional)
- **`[wecoza_create_class]`** - Phase 1 create form
- **`[wecoza_update_class]`** - Phase 1 update form

## Files Analysis

### Files to DELETE COMPLETELY

#### WEC-90 Implementation Files
```
app/Views/classes/
├── index.php          # Class listing view
├── create.php         # Create form view
├── edit.php           # Edit form view
└── show.php           # Class details view

app/Services/
└── ClassService.php   # Business logic layer

app/Repositories/
└── ClassRepository.php # Data access layer

app/Contracts/
└── ClassRepositoryInterface.php # Repository contract

app/Validators/
└── ClassValidator.php # Validation layer

app/Routes/
└── ClassRoutes.php    # RESTful routing

app/Migrations/
└── WEC-90-Migration.php # Migration script

public/js/
└── class-crud.js      # CRUD operations JavaScript

tests/
└── WEC-90-1-repository-test.php # Tests

docs/
└── WEC-90-Implementation-Guide.md # Documentation

wecoza-dev-flow/tracking/
└── WEC-90-task.md     # Task tracking
```

### Files to MODIFY

#### Controller Updates
- **`app/Controllers/ClassController.php`**
  - Remove non-functional shortcode registrations
  - Remove non-functional methods
  - Keep working shortcode methods

#### AJAX Handler Updates  
- **`app/ajax-handlers.php`**
  - Remove non-functional shortcode registrations
  - Keep working shortcode registration

#### CSS Cleanup
- **`includes/css/ydcoza-styles.css`**
  - Remove WEC-90 specific styles
  - Keep working form styles

### Files to PRESERVE (Used by working shortcode)
```
app/Controllers/ClassController.php (modified)
app/Models/Assessment/ClassModel.php
app/Views/components/class-capture-form.view.php
app/Views/components/class-capture-partials/*.php
public/js/class-capture.js
assets/js/class-types.js
includes/css/ydcoza-styles.css (cleaned)
```

## Implementation Plan

### Phase 1: Backup Strategy 🔒
```bash
git add .
git commit -m "Backup before removing non-functional class shortcodes"
git push origin master
```

### Phase 2: File Removal (in order)
1. Delete view files: `app/Views/classes/`
2. Delete JavaScript: `public/js/class-crud.js`
3. Delete services: `app/Services/ClassService.php`
4. Delete repositories: `app/Repositories/ClassRepository.php`
5. Delete contracts: `app/Contracts/ClassRepositoryInterface.php`
6. Delete validators: `app/Validators/ClassValidator.php`
7. Delete routes: `app/Routes/ClassRoutes.php`
8. Delete migrations: `app/Migrations/WEC-90-Migration.php`
9. Delete tests: `tests/WEC-90-1-repository-test.php`
10. Delete documentation: `docs/WEC-90-Implementation-Guide.md`
11. Delete task tracking: `wecoza-dev-flow/tracking/WEC-90-task.md`

### Phase 3: Code Modifications

#### ClassController.php Changes
**Remove from `registerShortcodes()` method:**
```php
// REMOVE these registrations:
\add_shortcode('wecoza_display_class', [$this, 'displayClassShortcode']);
\add_shortcode('wecoza_classes_index', [$this, 'index']);
\add_shortcode('wecoza_class_create', [$this, 'create']);
\add_shortcode('wecoza_class_show', [$this, 'show']);
\add_shortcode('wecoza_class_edit', [$this, 'edit']);

// KEEP this registration:
\add_shortcode('wecoza_capture_class', [$this, 'captureClassShortcode']);
```

**Remove these entire methods:**
- `displayClassShortcode()`
- `index()` (WEC-90)
- `create()` (WEC-90)
- `show()` (WEC-90)
- `edit()` (WEC-90)
- `createClassShortcode()` (Phase 1)
- `updateClassShortcode()` (Phase 1)

**Keep these methods:**
- `captureClassShortcode()`
- `handleCreateMode()`
- `handleUpdateMode()`
- All data retrieval methods
- All AJAX handlers for working form

#### ajax-handlers.php Changes
**Remove these registrations:**
```php
// REMOVE:
\add_shortcode('wecoza_display_class', [$classController, 'displayClassShortcode']);
\add_shortcode('wecoza_create_class', [$classController, 'createClassShortcode']);
\add_shortcode('wecoza_update_class', [$classController, 'updateClassShortcode']);

// KEEP:
\add_shortcode('wecoza_capture_class', [$classController, 'captureClassShortcode']);
```

### Phase 4: Testing Checklist
- [ ] `[wecoza_capture_class]` loads without errors
- [ ] Form submission works via AJAX
- [ ] File uploads function correctly
- [ ] Client/site dropdowns populate
- [ ] Class type/subject selection works
- [ ] Calendar functionality intact
- [ ] Validation messages display
- [ ] Redirect functionality works
- [ ] No JavaScript console errors
- [ ] No PHP errors in debug.log

## Safety Considerations

### Rollback Strategy
- Git commit provides complete rollback capability
- All changes are tracked and reversible

### Shared Dependencies
**Preserved components used by working shortcode:**
- Core ClassModel
- Working form view and partials
- Working JavaScript files
- AJAX handlers for functional features
- CSS styles for working form

### Monitoring
- WordPress debug.log for PHP errors
- Browser console for JavaScript errors
- Test with different user roles

## Expected Outcome

**After cleanup:**
- Single functional shortcode: `[wecoza_capture_class]`
- Significantly reduced codebase complexity
- No broken references or dependencies
- Maintained full functionality for working shortcode
- Cleaner, more maintainable code structure

**Benefits:**
- Reduced maintenance overhead
- Clearer codebase for developers
- Eliminated confusion about which shortcodes work
- Improved performance (fewer unused files)
- Better code organization

## Next Steps

1. **Get approval** for cleanup plan
2. **Create backup** via Git commit/push
3. **Execute removal** in planned phases
4. **Test thoroughly** to ensure working shortcode intact
5. **Document completion** and update any references

## Notes

- This cleanup removes approximately 15+ files
- Focuses on preserving production functionality
- Eliminates experimental/incomplete implementations
- Maintains backward compatibility for working shortcode
- Supports both create and update modes of working form
