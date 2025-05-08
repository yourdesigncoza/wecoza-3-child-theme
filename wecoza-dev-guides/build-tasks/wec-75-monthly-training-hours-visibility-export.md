# Monthly Training Hours Visibility & Export (WEC-75)

## Description
Implement functionality to display and export monthly training hours for classes. This feature will calculate and display the total monthly training hours based on class schedules, and provide export capabilities for reporting purposes.

The system should calculate training hours based on class days and times, accounting for exceptions such as public holidays and class breaks. Users should be able to view monthly hour totals directly in the calendar interface and export this data in various formats for reporting.

As shown in the UI:
- Monthly hours summary displayed in the calendar view
- Export button with options for report format and filters
- Filtering options for selecting specific classes, all classes, or a subset of classes
- Progress indicator during report generation
- Download prompt for the generated report

## Current Codebase Analysis

The codebase already has:
- ClassModel with schedule data storage and methods for managing class schedules
- CalendarExportService for iCalendar exports that can be adapted for other formats
- PublicHolidaysController for holiday management and exclusion from schedules
- Database tables for classes (wecoza_classes) and schedules (wecoza_class_schedule)
- Basic duration calculation functions in JavaScript and PHP
- Class stop/restart dates functionality that needs to be considered for calculations

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

## Technical Approach

### Hours Calculation Logic

1. Retrieve class schedules from the database:
   ```php
   $sql = "SELECT cs.* FROM wecoza_class_schedule cs
           JOIN wecoza_classes c ON cs.class_id = c.id
           WHERE c.id IN (?) AND cs.date BETWEEN ? AND ?";
   ```

2. For each scheduled session:
   - Calculate duration based on start and end times:
     ```php
     $startTime = strtotime($schedule['start_time']);
     $endTime = strtotime($schedule['end_time']);
     $durationHours = ($endTime - $startTime) / 3600;
     ```
   - Check if the session falls on a holiday (skip unless overridden):
     ```php
     $holidayController = new PublicHolidaysController();
     $isHoliday = $holidayController->isPublicHoliday($schedule['date']);
     $isOverridden = in_array($schedule['date'], $holidayOverrides);
     if ($isHoliday && !$isOverridden) {
         continue; // Skip this session
     }
     ```
   - Check if the session falls within a class break (skip):
     ```php
     $isInBreak = false;
     foreach ($breakPeriods as $break) {
         if ($schedule['date'] >= $break['stop_date'] && $schedule['date'] <= $break['restart_date']) {
             $isInBreak = true;
             break;
         }
     }
     if ($isInBreak) {
         continue; // Skip this session
     }
     ```

3. Group sessions by month:
   ```php
   $month = date('Y-m', strtotime($schedule['date']));
   if (!isset($monthlyHours[$month])) {
       $monthlyHours[$month] = 0;
   }
   $monthlyHours[$month] += $durationHours;
   ```

4. Implement caching for performance:
   ```php
   $cacheKey = 'monthly_hours_' . md5(json_encode($classIds) . $startDate . $endDate);
   $cachedData = get_transient($cacheKey);
   if ($cachedData !== false) {
       return $cachedData;
   }
   // ... calculation logic ...
   set_transient($cacheKey, $monthlyHours, 12 * HOUR_IN_SECONDS);
   ```

### Export Implementation

For PDF generation, we'll need to select a PDF library. The recommended approach is to use TCPDF or mPDF:

```php
// Using mPDF
require_once(ABSPATH . 'vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf([
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 16,
    'margin_bottom' => 16,
    'margin_header' => 9,
    'margin_footer' => 9
]);
$mpdf->SetTitle('Monthly Training Hours Report');
$mpdf->WriteHTML($html);
return $mpdf->Output('monthly_hours_report.pdf', 'S');
```

For Excel generation, PhpSpreadsheet is recommended:

```php
// Using PhpSpreadsheet
require_once(ABSPATH . 'vendor/autoload.php');
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Monthly Training Hours Report');
// ... add data to spreadsheet ...
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
ob_start();
$writer->save('php://output');
return ob_get_clean();
```

### AJAX Implementation

```javascript
function exportMonthlyHours() {
    // Show loading indicator
    showLoading('Preparing export...');

    // Get selected options
    const format = $('#export-format').val();
    const classIds = getSelectedClassIds();
    const startDate = $('#export-start-date').val();
    const endDate = $('#export-end-date').val();

    // Create form data
    const formData = new FormData();
    formData.append('action', 'export_monthly_hours');
    formData.append('nonce', wecozaClass.nonce);
    formData.append('format', format);
    formData.append('class_ids', JSON.stringify(classIds));
    formData.append('start_date', startDate);
    formData.append('end_date', endDate);

    // Send AJAX request
    $.ajax({
        url: wecozaClass.ajaxUrl,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            hideLoading();
            if (response.success) {
                // Trigger download
                window.location.href = response.data.download_url;
            } else {
                showError(response.data.message);
            }
        },
        error: function() {
            hideLoading();
            showError('An error occurred during export.');
        }
    });
}
```

## Implementation Timeline

The implementation will follow these phases:

1. **Phase 1: Core Calculation Service** (2-3 days)
   - Implement MonthlyHoursCalculationService
   - Create unit tests for calculation logic
   - Optimize and add caching

2. **Phase 2: UI Components** (2-3 days)
   - Create monthly hours summary component
   - Add display to calendar view
   - Implement client-side functionality

3. **Phase 3: Export Service** (3-4 days)
   - Implement export service for different formats
   - Create templates for reports
   - Add formatting and styling

4. **Phase 4: Export UI and Integration** (2-3 days)
   - Create export options modal
   - Implement AJAX handlers
   - Connect UI to export service

5. **Phase 5: Testing and Optimization** (2-3 days)
   - Test with various scenarios
   - Optimize database queries
   - Fix any issues found during testing

Total estimated time: 11-16 days

## Related Issues
- WEC-52: Yearly Calendar View
- WEC-73: Export to PDF Feature
