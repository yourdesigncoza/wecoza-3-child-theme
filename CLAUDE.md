# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

WeCoza 3 Child Theme — a WordPress child theme extending the **Bootscore** parent theme. Built for an educational platform (learner management, assessments, portfolios). Uses a custom MVC architecture on top of WordPress with a PostgreSQL database backend.

- **PHP 8.0+** with `declare(strict_types=1)`
- **Bootstrap 5** (via Bootscore parent) + Phoenix theme styling
- **No build tools** — no Composer, npm, Webpack. All dependencies are CDN or vendored
- **No test suite** — no PHPUnit or automated tests

## Architecture

### Boot Sequence

`functions.php` → loads `includes/functions/*.php` → loads `app/bootstrap.php` → registers SPL autoloader → reads `config/app.php` → instantiates controllers → loads AJAX handlers.

### MVC Layer (`app/`)

Custom PSR-4-style autoloader maps `WeCoza\` namespace to `app/` directory:
- `WeCoza\Controllers\FooController` → `app/Controllers/FooController.php`
- `WeCoza\Services\Database\DatabaseService` → `app/Services/Database/DatabaseService.php`

**Naming conventions:**
- Models: `{Entity}Model.php` (PascalCase, singular)
- Controllers: `{Entity}Controller.php` (register shortcodes/hooks in constructor)
- Views: `{view-name}.view.php` (kebab-case, in `app/Views/`)
- Services: `{Name}Service.php` (PascalCase)

**View rendering:** Use `\WeCoza\view('path/name', $data)` — resolves to `app/Views/path/name.view.php`, runs through output buffering with `extract($data)`.

**Config access:** Use `\WeCoza\config('app')` — loads `config/app.php` returning an array.

### WordPress Integration Layer (`includes/`)

Legacy/utility code that hasn't been migrated to MVC:
- `includes/functions/` — helper PHP (db queries, title visibility, Google Fonts)
- `includes/shortcodes/` — shortcode definitions (echarts, datatable — currently disabled)
- `includes/css/` and `includes/js/` — theme stylesheets and scripts

### Templates (`templates/`)

WordPress page templates registered via `Plugin_Templates_Loader` class. Use `Template Name:` header comment. Templates are auto-discovered from the `templates/` directory.

## Database

**PostgreSQL** via PDO singleton — NOT WordPress's `$wpdb`.

```php
$db = \WeCoza\Services\Database\DatabaseService::getInstance();
$stmt = $db->query("SELECT * FROM table WHERE id = ?", [$id]);
```

Connection credentials come from `wp-config.php` constants (preferred) or WP options:
```
WECOZA_PG_HOST, WECOZA_PG_PORT, WECOZA_PG_DBNAME, WECOZA_PG_USER, WECOZA_PG_PASSWORD
```

Connection is **lazy-loaded** (first `getPdo()` call) with SSL required. Supports transactions via `beginTransaction()`, `commit()`, `rollback()`.

## Key Constants

Defined in `functions.php`:
- `WECOZA_THEME_VERSION` (currently `'6.0.3'`) — bump when changing CSS/JS for cache busting
- `WECOZA_CHILD_DIR` / `WECOZA_CHILD_URL` — filesystem path / URL to child theme

Defined in `app/bootstrap.php`:
- `WECOZA_PATH`, `WECOZA_APP_PATH`, `WECOZA_CONFIG_PATH`, `WECOZA_VIEWS_PATH`

## Asset Management

Assets are enqueued in `functions.php` with a conditional loading strategy:

- **Global assets** (always loaded): Bootstrap Icons, FontAwesome, theme CSS
- **Conditional assets**: Select2 (pages with forms), Chart.js (dashboards), Gradio (learners table)
- **Load order**: `ydcoza-styles.css` loads at priority 99 to override everything
- **Scripts** use WP 6.3+ `'strategy' => 'defer'` to avoid render-blocking

CDN preconnect hints for `cdn.jsdelivr.net` and `cdnjs.cloudflare.com` are added at priority 1 in `wp_head`.

Bootscore parent styles are dequeued (`wp_dequeue_style('bootscore-style')`) and replaced.

## Commit Message Format

Follow the `.gitmessage` template:
```
<type>: <subject>   (max 50 chars)

<body explaining why>   (wrap at 72 chars)
```
Types: `feat`, `fix`, `refactor`, `style`, `doc`, `test`

## Important Patterns

- **Singleton pattern** used for database connections — never instantiate `PostgresConnection` or `DatabaseService` directly
- **AJAX handlers** live in `app/ajax-handlers.php` — use `wp_ajax_` / `wp_ajax_nopriv_` hooks with nonce validation
- **ViewHelpers** (`app/Helpers/ViewHelpers.php`) provides form builders: `select_dropdown()`, `form_input()`, `form_textarea()`, `button()` — all output Bootstrap 5 markup with proper escaping
- **Walker** (`app/Walkers/Bootstrap_Sidebar_Walker.php`) renders Bootstrap 5 collapse menus from WP nav menus
- **Dark/light mode** handled by inline theme-sniffer script reading `localStorage('phoenixTheme')`

## What Lives Where

Much of the domain logic (learner management, etc.) has been **migrated to standalone plugins**. The theme retains:
- MVC framework scaffolding and base services
- Navigation, sidebar menus, dashboard templates
- CSS/JS assets and UI helpers
- Database connection layer

## Performance Notes

See `docs/performance-review-2026-02-01.md` for full audit. Key decisions:
- Removed homepage cron "thundering herd" — use server crontab instead
- Removed admin transient cleanup that forced wordpress.org API calls
- Conditional asset loading to avoid loading Chart.js/Select2 on every page
- PostgreSQL singleton prevents duplicate connections per request
