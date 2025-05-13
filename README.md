# WeCoza 3 Child Theme

A WordPress child theme for WeCoza based on GeneratePress, providing custom functionality for learner management, agent management, and client management.

## Overview

This child theme extends the GeneratePress parent theme with custom functionality specifically designed for WeCoza's business needs. It includes custom shortcodes, database integrations, and specialized features for managing learners, agents, and clients.

## Features

### Core Management Systems
- **Learner Management**
  - Portfolio upload and tracking
  - Assessment management
  - Progress monitoring
  - POE (Portfolio of Evidence) system

- **Agent Management**
  - Registration and verification
  - Performance tracking
  - Relationship management
  - Reporting tools

- **Client Management**
  - Client tracking
  - Relationship management
  - Permission controls
  - Interaction history

### Technical Features
- **Custom Dashboards**: Data visualization with ECharts and Chart.js
- **Dynamic Tables**: SQL-powered data tables with Bootstrap Table integration
- **Custom Shortcodes**: Modular functionality embedding
- **Multi-Database Support**: PostgreSQL and MySQL compatibility
- **Advanced Security**: Comprehensive input validation and sanitization
- **Responsive Design**: Bootstrap 5 integration

## Requirements

- WordPress 6.0+
- GeneratePress theme 3.0+ (parent theme)
- PHP 8.0+
- MySQL 5.7+ or MariaDB 10.3+
- PostgreSQL 12+ (optional)

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

# Install dependencies
composer install
npm install
```

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
```

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
