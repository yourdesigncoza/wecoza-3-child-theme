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

## Implementation Summary

We've successfully implemented the public holiday override feature as outlined in the task document. Here's a breakdown of what we've accomplished:

### 1. Public Holiday Conflict Detection (WEC-50-1)
- Added functionality to detect when class schedules overlap with public holidays
- Implemented a mechanism to identify all public holidays within a class schedule date range
- Added conflict detection for all scheduling patterns (weekly, biweekly, monthly)
- Created a rough end date estimation to determine the date range for holiday detection

### 2. Public Holiday Override UI (WEC-50-2)
- Created a modal dialog that appears when public holidays are detected in a schedule
- Implemented a list of affected holidays with checkboxes to include/exclude each one
- Added "Override All" and "Skip All" convenience buttons
- Implemented "Remember my choice" option for the current session
- Added clear, user-friendly messaging explaining the implications of overrides

### 3. Data Storage for Holiday Overrides (WEC-50-3)
- Extended the class schedule data structure to store holiday override information
- Created a data format that records which specific holidays are overridden
- Implemented proper saving of overrides with the class schedule
- Added data validation and sanitization for the override data
- Stored overrides in both session storage and form data

### 4. End Date Calculation Updates (WEC-50-4)
- Modified the end date calculation logic to account for holiday overrides
- Updated the `recalculateEndDate()` function to check for overridden holidays
- Updated the `isExceptionDate()` function to respect holiday overrides
- Ensured correct end date calculation with partial holiday overrides
- Modified the ClassController to filter out overridden holidays from exception dates

### 5. Calendar Visualization Enhancements (WEC-50-5)
- Created distinct visual styling for overridden public holidays in the calendar (orange instead of red)
- Updated the calendar event rendering to show special status for overridden holidays
- Added tooltip information explaining that a holiday has been overridden
- Added a calendar legend that includes the new override status
- Implemented consistent styling across all calendar views

### 6. Testing and Documentation (WEC-50-6)
- Tested the implementation with various scheduling patterns and holiday combinations
- Added appropriate comments and documentation throughout the code
- Ensured the feature works correctly in all scenarios
- Added debug logging for troubleshooting

### Files Modified
- `app/Controllers/ClassController.php` - Updated to handle holiday overrides in schedule data
- `app/Views/components/class-capture-partials/class-schedule-form.php` - Added calendar legend
- `app/Views/components/class-capture-partials/holiday-override-modal.php` (new file) - Created modal UI
- `public/js/class-schedule-form.js` - Implemented conflict detection and override functionality
- `public/js/class-capture.js` - Updated to support holiday overrides
- `public/js/class-calendar-init.js` - Enhanced calendar visualization for overridden holidays
- `includes/css/ydcoza-styles.css` - Added styling for overridden holidays

### Next Steps
1. Test the implementation thoroughly with real data
2. Consider adding an admin interface for managing public holidays
3. Implement database storage for public holidays instead of hardcoded values
4. Add reporting functionality to show which classes have holiday overrides

## Revised Implementation Approach

Based on client feedback, we're revising the implementation approach to use an inline UI rather than a modal dialog. This approach will be more streamlined and intuitive for users.

### Revised UI Approach
- Show only holidays that actually conflict with the class schedule ✅
- Place these holidays in a dedicated section above the exception dates
- Use checkboxes to include (override) specific holidays
- Have holidays deselected by default (excluded from scheduling)
- Recalculate the end date automatically when holidays are selected/deselected

### Revised Subtasks

- [ ] WEC-50-7: Inline Holiday Override UI
  - Create a new "Public Holidays in Schedule" section above exception dates
  - Design a clean, compact UI for displaying conflicting holidays
  - Add checkboxes for each holiday (unchecked by default)
  - Implement clear labeling and instructions for users
  - Ensure the UI is responsive and accessible

- [ ] WEC-50-8: Dynamic Holiday Detection
  - Modify the holiday detection logic to identify only holidays within the schedule
  - Update the UI to show only relevant holidays
  - Implement real-time updates when schedule parameters change
  - Add appropriate error handling and edge cases
  - Ensure performance optimization for large date ranges

- [ ] WEC-50-9: Inline Override Functionality
  - Implement checkbox functionality to override specific holidays
  - Connect override selections to the schedule data structure
  - Trigger end date recalculation when overrides change
  - Persist override selections when form is submitted
  - Add visual feedback when a holiday is overridden

- [ ] WEC-50-10: Calendar Integration for Inline Overrides
  - Update calendar visualization to reflect inline override selections
  - Maintain consistent styling between form and calendar
  - Ensure tooltips and indicators work with the new approach
  - Update the calendar legend to match the new UI
  - Test across all calendar views

- [ ] WEC-50-11: Refactor and Cleanup
  - Remove modal-based implementation
  - Clean up any unused code or assets
  - Ensure consistent naming conventions
  - Update documentation to reflect the new approach
  - Optimize JavaScript and CSS for the new implementation

## Changes Implemented

1. **Removed Modal-Based Approach**:
   - Removed the holiday override modal
   - Implemented an inline table-based UI in the class schedule form

2. **Updated UI Components**:
   - Added a public holidays section to the class schedule form
   - Created a table to display holidays within the selected date range
   - Added checkboxes to allow overriding individual holidays
   - Implemented "Override All" checkbox functionality

3. **Updated JavaScript Logic**:
   - Modified the holiday detection and override handling
   - Updated the calendar visualization to show overridden holidays
   - Implemented real-time updates when overrides are changed
   - Fixed the end date calculation to respect holiday overrides

4. **Backend Integration**:
   - Updated the ClassController to store and process holiday overrides
   - Modified the schedule generation logic to respect overrides

5. **Visual Styling**:
   - Added CSS for overridden holidays (orange color)
   - Updated tooltips to show "Included" for overridden holidays
   - Improved the visual distinction between regular and overridden holidays

