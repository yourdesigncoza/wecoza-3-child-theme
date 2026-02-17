# Security Refactor Plan - Functions Directory

**Date:** 2026-02-01
**Scope:** `/includes/functions/`
**Status:** Completed

---

## Context

The WordPress environment requires authentication via `wecoza_redirect_non_logged_users()`, which blocks all unauthenticated access. This means:
- `nopriv` AJAX hooks are effectively unreachable
- CSRF attacks still require tricking a logged-in user
- Primary risks: privilege escalation, SQL injection, XSS, information disclosure

---

## Implementation Tasks

### Phase 1: Critical Fixes

| # | File | Task | Status |
|---|------|------|--------|
| 1.1 | `main-functions.php` | Remove hardcoded debug settings (lines 6-8) | [x] |
| 1.2 | `main-functions.php` | Fix SQL identifier injection in `wecoza_update_record()` - use whitelist | [x] |
| 1.3 | `main-functions.php` | Sanitize `$_POST['updated_data']` array input | [x] |
| 1.4 | `db.php` | Support credentials from `wp-config.php` constants (fallback to options) | [x] |

### Phase 2: Authorization & Validation

| # | File | Task | Status |
|---|------|------|--------|
| 2.1 | `helper.php` | Add capability check to `fetch_dynamic_table_data()` | [x] |
| 2.2 | `main-functions.php` | Add capability checks to update/delete handlers | [x] |
| 2.3 | `templates-loader.php` | Add null check for `$post` object | [x] |

### Phase 3: Output Escaping (XSS Prevention)

| # | File | Task | Status |
|---|------|------|--------|
| 3.1 | `helper.php` | Escape breadcrumb output (`get_the_title()`, `get_search_query()`) | [x] |
| 3.2 | `helper.php` | Escape ancestor titles in breadcrumb loop | [x] |

### Phase 4: Code Quality

| # | File | Task | Status |
|---|------|------|--------|
| 4.1 | `echarts-functions.php` | Add `defined('ABSPATH')` check | [x] |
| 4.2 | `show-hide-title.php` | Add `defined('ABSPATH')` check | [x] |
| 4.3 | `templates-loader.php` | Add `defined('ABSPATH')` check | [x] |
| 4.4 | `db.php` | Add PHP 8 type declarations to classes | [x] |

---

## Files Modified

- `main-functions.php` - Debug settings, SQL injection fix, sanitization
- `db.php` - wp-config.php support, type declarations, improved error handling
- `helper.php` - Capability checks, XSS fixes in breadcrumbs
- `templates-loader.php` - Null safety, ABSPATH check, type declarations
- `echarts-functions.php` - ABSPATH check, type declarations
- `show-hide-title.php` - ABSPATH check

---

## Summary of Changes

### Security Improvements

1. **SQL Injection Prevention**
   - Replaced improper `PDO::quote()` identifier escaping with whitelist validation
   - Added `wecoza_get_allowed_tables()` and `wecoza_get_allowed_columns()` functions
   - All table/column names validated before use in queries

2. **Credential Security**
   - Database credentials can now be defined in `wp-config.php`:
     ```php
     define( 'WECOZA_PG_HOST', 'your-host' );
     define( 'WECOZA_PG_DBNAME', 'your-db' );
     define( 'WECOZA_PG_PORT', '25060' );
     define( 'WECOZA_PG_USER', 'your-user' );
     define( 'WECOZA_PG_PASSWORD', 'your-password' );

     define( 'WECOZA_MYSQL_HOST', 'your-host' );
     define( 'WECOZA_MYSQL_DBNAME', 'your-db' );
     define( 'WECOZA_MYSQL_USER', 'your-user' );
     define( 'WECOZA_MYSQL_PASSWORD', 'your-password' );
     ```
   - Falls back to `get_option()` if constants not defined

3. **Authorization**
   - Added `current_user_can('read')` check to AJAX data handler
   - Existing nonce/capability checks preserved in update handlers

4. **XSS Prevention**
   - All breadcrumb output now properly escaped
   - `esc_html()`, `esc_url()` applied throughout
   - Translation functions added for i18n support

5. **Debug Settings**
   - Removed hardcoded `display_errors`
   - Now respects `WP_DEBUG` and `WP_DEBUG_DISPLAY` constants

### Code Quality Improvements

1. **PHP 8 Compatibility**
   - Added type declarations to all functions and class methods
   - Used nullable types (`?object`, `?\PDO`)
   - Used union types (`array|WP_Error`, `array|false`)
   - Used `match` expression for cleaner branching

2. **Null Safety**
   - Template loader checks for valid `WP_Post` object
   - PDO connection validation improved

3. **Direct Access Prevention**
   - All files now have `defined('ABSPATH') || exit;`

---

## Recommended Follow-up Actions

1. **Move credentials to wp-config.php** - Add the constants listed above to production config

2. **Update whitelist** - Review `wecoza_get_allowed_tables()` and `wecoza_get_allowed_columns()`
   to include all tables/columns your application uses

3. **Test thoroughly** - Verify all AJAX operations work correctly after changes

4. **Consider removing nopriv hooks** - Since site requires login, nopriv handlers are redundant
