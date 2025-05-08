# Monthly Training Hours Visibility & Export

## Description
Implement functionality to display and export monthly training hours for classes. This feature will calculate and display the total monthly training hours based on class schedules, and provide export capabilities for reporting purposes.

The system should calculate training hours based on class days and times, accounting for exceptions such as public holidays and class breaks. Users should be able to view monthly hour totals directly in the calendar interface and export this data in various formats for reporting.

As shown in the UI:
- Monthly hours summary displayed in the calendar view
- Export button with options for report format and filters
- Filtering options for selecting specific classes, all classes, or a subset of classes
- Progress indicator during report generation
- Download prompt for the generated report

## Subtasks
- [ ] WEC-75-1: Implement Monthly Hours Calculation Service
  - Create a service class for calculating monthly training hours
  - Implement logic to group class sessions by month
  - Calculate total hours for each month based on session durations
  - Handle exceptions like holidays and class breaks
  - Support filtering by class, client, or date range
  - Implement caching for performance optimization
  - Add unit tests for the calculation logic
  - Ensure accurate handling of timezone differences
  - Optimize for performance with large datasets

- [ ] WEC-75-2: Add Monthly Hours Display to Calendar UI
  - Add a monthly hours summary section to the calendar view
  - Display total hours for the current month by default
  - Implement navigation to view different months
  - Add visual indicators for monthly totals in the calendar
  - Ensure responsive design for all screen sizes
  - Add tooltips for additional information
  - Implement client-side caching for better performance
  - Follow Bootstrap styling conventions
  - Ensure accessibility compliance

- [ ] WEC-75-3: Create Monthly Hours Export Service
  - Implement a service for generating monthly hours reports
  - Support multiple export formats (PDF, CSV, Excel)
  - Create templates for each export format
  - Implement proper formatting and styling for reports
  - Add headers, footers, and pagination for PDF reports
  - Include filtering options in the export service
  - Optimize for handling large datasets
  - Implement error handling and logging
  - Add unit tests for the export functionality

- [ ] WEC-75-4: Implement Export UI and AJAX Handlers
  - Create a modal dialog for selecting export options
  - Implement class selection interface (single, multiple, all)
  - Add date range selection for reports
  - Create format selection options (PDF, CSV, Excel)
  - Implement progress indicator for export generation
  - Add success/error messaging
  - Create AJAX endpoints for export requests
  - Implement proper response handling
  - Add security with nonce verification
  - Optimize for handling large data requests

- [ ] WEC-75-5: Database Optimization
  - Analyze query performance for hours calculation
  - Create optimized views or calculated fields if needed
  - Implement indexing strategy for frequently queried data
  - Add caching layer for report generation
  - Optimize joins for class schedule data
  - Implement query pagination for large datasets
  - Add database logging for performance monitoring
  - Create maintenance scripts for cache clearing
  - Document database optimizations

- [ ] WEC-75-6: Testing and Documentation
  - Test hours calculation with various scenarios
  - Test export functionality with different filters
  - Verify report formatting and accuracy
  - Test with large datasets for performance
  - Create user documentation for the new feature
  - Add inline code documentation
  - Create usage examples
  - Document API endpoints
  - Prepare release notes

## Files
- app/Services/Hours/MonthlyHoursCalculationService.php
- app/Services/Export/MonthlyHoursExportService.php
- app/Controllers/MonthlyHoursController.php
- app/Views/components/monthly-hours-summary.view.php
- app/Views/components/export-options-modal.view.php
- app/ajax-handlers.php (update)
- public/js/monthly-hours-display.js
- public/js/monthly-hours-export.js
- includes/css/monthly-hours-styles.css
- app/database/views/monthly_hours_view.sql

## Related Issues
- WEC-52: Yearly Calendar View
- WEC-73: Export to PDF Feature
