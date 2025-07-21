I'll help you update the README.md file to accurately reflect the current state of the project. Let me first examine the existing README and the codebase structure to ensure I maintain useful information while updating it appropriately.

Now, let me gather more information about the MVC architecture and recent changes to ensure the updated README is accurate:

Let me also check for any testing setup and recent UI changes:

Based on my analysis of the codebase, I'll now create an updated README.md file that accurately reflects the current state of the project:

Now I have all the information I need to create an updated README.md file. Here's the updated content:

# WeCoza 3 Child Theme

A WordPress child theme for WeCoza based on GeneratePress, providing custom functionality for learner management and client management through a modern MVC architecture.

## Overview

This child theme extends the GeneratePress parent theme with custom functionality specifically designed for WeCoza's business needs. It includes custom shortcodes, database integrations, and specialized features for managing learners and clients. The codebase follows a strict MVC (Model-View-Controller) architecture for better organization, maintainability, and testability.

## Features

### Core Management Systems
- **Learner Management**
  - Portfolio upload and tracking
  - Assessment management
  - Progress monitoring
  - POE (Portfolio of Evidence) system
  - Status tracking (CIC, RBE, DRO)

  - Performance tracking
  - Relationship management
  - Reporting tools

- **Client Management**
  - Client tracking
  - Relationship management
  - Permission controls
  - Interaction history

- **Class Management**
  - Class scheduling
  - Public holiday integration
  - Attendance tracking

### Technical Features
- **MVC Architecture**: Clean separation of concerns with models, views, and controllers
- **Custom Dashboards**: Data visualization with ECharts and Chart.js
- **Dynamic Tables**: SQL-powered data tables with Bootstrap Table integration
- **Custom Shortcodes**: Modular functionality embedding
- **Multi-Database Support**: PostgreSQL and MySQL compatibility
- **Advanced Security**: Comprehensive input validation and sanitization
- **Responsive Design**: Bootstrap 5 integration with Phoenix theme
- **Theme Toggle**: Support for light and dark modes

## MVC Architecture

The codebase follows a strict MVC architecture for better organization and maintainability:

### Models
Models represent data structures and business logic. They handle data relationships between entities. Note: Server-side validation has been removed - all validation is handled on the frontend using JavaScript and Bootstrap validation.

```
/app/Models/
  /Learner/
  /Client/
  /Assessment/
  /Portfolio/
```

### Views
Views handle presentation logic. They should not contain business logic and use template partials for reusable components.

```
/app/Views/
  /learner/
  /client/
  /admin/
  /components/
  /layouts/
```

### Controllers
Controllers handle the request/response cycle. They implement WordPress hooks as entry points and use service classes for complex operations.

```
/app/Controllers/
  LearnerController.php
  ClientController.php
  AssessmentController.php
  ClassController.php
  PublicHolidaysController.php
  ...
```

### Services
Services implement business logic and handle complex operations. They manage external integrations, caching, and file operations.

```
/app/Services/
  /Database/
  /FileUpload/
  /Authentication/
  /Export/
```

## Requirements

- WordPress 6.0+
- GeneratePress theme 3.0+ (parent theme)
- PHP 8.0+
- MySQL 5.7+ or MariaDB 10.3+
- PostgreSQL 12+ (optional)
- Node.js 16+ (for development)
- Composer (for PHP dependencies)

## Installation

1. Install and activate the GeneratePress theme
2. Upload the wecoza-3-child-theme to `/wp-content/themes/`
3. Activate the WeCoza 3 Child Theme through WordPress admin
4. Configure theme settings under WeCoza Settings

## Configuration

### Database Setup
1. Navigate to **WeCoza Settings** > **Database**
2. Configure connection parameters
3. Run database migrations
4. Verify connection status

### Theme Settings
1. Configure color schemes
2. Set up user permissions
3. Enable/disable features
4. Configure API integrations

## Development

### Environment Setup
```bash
# Clone repository
git clone https://github.com/yourdesign/wecoza-3-child-theme.git

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Development Workflow
The project follows a Test-Driven Development (TDD) approach:
1. Write tests that define the expected behavior
2. Implement the code to make the tests pass
3. Refactor the code while ensuring tests continue to pass
4. No task should be marked as "Completed" until all associated tests are written and passing

### Branching Strategy
- `main` - Production-ready code
- `develop` - Integration branch
- Feature branches: `feature/WEC-[ticket]-description`
- Hotfix branches: `hotfix/WEC-[ticket]-description`
- Release branches: `release/v[major].[minor].[patch]`

### Build Process
```bash
# Development build
npm run dev

# Production build
npm run build

# Package theme for distribution
./package-theme.sh
```

### Testing
The project uses PHPUnit for PHP testing:

```bash
# Run all tests
vendor/bin/phpunit

# Run specific test suite
vendor/bin/phpunit --testsuite Unit
vendor/bin/phpunit --testsuite Integration
```

## Recent Changes and Improvements

### UI Modernization
- Implemented Phoenix theme for a modern, clean UI design
- Added support for light and dark modes with theme toggle
- Updated form fields to use Bootstrap 5 floating labels
- Improved sidebar navigation with collapsible sections

### Learner Status Tracking System
- Added comprehensive learner status tracking (CIC, RBE, DRO)
- Implemented status history with timestamps and reasons
- Created notification system for status changes
- Integrated status tracking with attendance system

### Class Management Enhancements
- Improved public holiday detection and handling
- Fixed checkbox interaction issues in holiday override UI
- Added schedule export functionality

### Technical Improvements
- Strengthened MVC architecture implementation
- Added comprehensive test suite for critical components
- Improved database service with multi-database support
- Enhanced security with input validation and sanitization

## Documentation

- [Developer Guide](docs/developer-guide.md)
- [API Documentation](docs/api.md)
- [Database Schema](docs/schema.md)
- [Shortcode Reference](docs/shortcodes.md)
- [CLI Commands](docs/cli-commands.md)

## Support

For technical support or feature requests:
- Email: support@yourdesign.co.za
- Issue Tracker: [GitHub Issues](https://github.com/yourdesign/wecoza-3-child-theme/issues)

## Credits

- Developed by [YourDesign.co.za](https://YourDesign.co.za)
- Author: John Montgomery

## License

This project is proprietary and confidential. Unauthorized copying, distribution, or use is strictly prohibited.

---

© 2024 YourDesign.co.za. All rights reserved.
