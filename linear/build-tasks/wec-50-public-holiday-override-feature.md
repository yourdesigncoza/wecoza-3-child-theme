# Public Holiday Override Feature

## Description
Implement a feature that allows users to selectively override public holidays when scheduling classes. Currently, the system automatically excludes public holidays from class schedules, but some clients occasionally need to conduct training on specific public holidays.

This feature will provide a user interface to:
1. Detect when a class schedule includes public holidays
2. Prompt users with options to include or exclude specific public holidays
3. Visually indicate in the calendar which public holidays have been overridden
4. Adjust end date calculations accordingly

As shown in the UI:
- A notification or prompt when scheduling classes that overlap with public holidays
- A list of affected public holidays with checkboxes to include/exclude each one
- Visual indicators in the calendar for overridden public holidays (different styling)
- Updated class schedule information reflecting the overrides

## Subtasks

- [ ] WEC-50-1: Public Holiday Conflict Detection
  - Enhance the class scheduling form to detect when selected dates include public holidays
  - Create a mechanism to identify all public holidays within a class schedule date range
  - Add conflict detection to both initial scheduling and rescheduling workflows
  - Implement detection for all scheduling patterns (weekly, biweekly, monthly)
  - Add appropriate hooks for the conflict resolution UI

- [ ] WEC-50-2: Public Holiday Override UI
  - Create a modal dialog that appears when public holidays are detected in a schedule
  - List all affected public holidays with name, date, and override checkbox
  - Add "Override All" and "Skip All" convenience buttons
  - Implement "Remember my choice" option for the current session
  - Design clear, user-friendly messaging explaining the implications of overrides

- [ ] WEC-50-3: Data Storage for Holiday Overrides
  - Extend the class schedule data structure to store holiday override information
  - Create a data format that records which specific holidays are overridden
  - Implement database schema updates if needed
  - Ensure overrides are properly saved with the class schedule
  - Add data validation and sanitization for the override data

- [ ] WEC-50-4: End Date Calculation Updates
  - Modify the end date calculation logic to account for holiday overrides
  - Update the `recalculateEndDate()` function to check for overridden holidays
  - Ensure the `isExceptionDate()` function respects holiday overrides
  - Test with various scheduling patterns and override combinations
  - Verify correct end date calculation with partial holiday overrides

- [ ] WEC-50-5: Calendar Visualization Enhancements
  - Create distinct visual styling for overridden public holidays in the calendar
  - Update the calendar event rendering to show special status for overridden holidays
  - Add tooltip information explaining that a holiday has been overridden
  - Ensure the calendar legend includes the new override status
  - Test visualization across different calendar views (month, week, day)

- [ ] WEC-50-6: Testing and Documentation
  - Create comprehensive test cases for the override feature
  - Test with various scheduling patterns and holiday combinations
  - Document the feature for end users
  - Update developer documentation
  - Create visual guides for the override workflow

## Files
- `app/Controllers/PublicHolidaysController.php`
- `app/Controllers/ClassController.php`
- `app/Models/PublicHoliday/PublicHolidayModel.php`
- `app/Models/Class/ClassModel.php`
- `app/Models/Class/ClassScheduleModel.php`
- `public/js/class-schedule-form.js`
- `public/js/class-capture.js`
- `public/js/class-calendar-init.js`
- `includes/css/ydcoza-styles.css`
- `app/Views/class/schedule-form.php`
- `app/Views/class/holiday-override-modal.php` (new file)

## Related Issues
- WEC-50: Public Holidays Integration
- WEC-87: Public Holidays Implementation

## Technical Approach

### Data Structure
We'll extend the class schedule data to include holiday override information:
```json
{
  "holiday_overrides": [
    {
      "date": "2025-04-18",
      "name": "Good Friday",
      "override": true
    },
    {
      "date": "2025-05-01",
      "name": "Workers' Day",
      "override": false
    }
  ]
}
```

### UI Flow
1. User selects class schedule parameters (start date, pattern, etc.)
2. System detects public holidays in the date range
3. If holidays are detected, system shows override modal
4. User selects which holidays to override (if any)
5. System saves selections and updates the schedule
6. Calendar displays overridden holidays with special styling

### Override Modal Design
The modal will include:
- Title: "Public Holidays in Schedule"
- Explanation text
- List of holidays with checkboxes
- "Override All" and "Skip All" buttons
- "Remember my choice" checkbox
- "Continue" and "Cancel" buttons

### Calendar Visualization
Overridden holidays will have:
- Different background color (orange instead of red)
- Special icon or indicator
- Tooltip explaining the override status
- Entry in the calendar legend

### End Date Calculation
The `recalculateEndDate()` function will be updated to:
- Check if a date is a public holiday
- If it is, check if it has been overridden
- Only skip non-overridden holidays when calculating the end date
