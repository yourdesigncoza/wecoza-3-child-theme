# Implement Multiple Days of the Week Selection for Class Scheduling

## Description
Currently, in the class schedule form, when selecting weekly or biweekly patterns, users can only select one day of the week. Many clients need to schedule classes on multiple days (e.g., Mondays, Wednesdays, and Fridays). This task involves updating the class scheduling system to allow selecting multiple days of the week for all scheduling patterns.

## Requirements
- Replace the single day dropdown with a checkbox group for days of the week
- Allow selecting multiple days for weekly and biweekly patterns
- Update the schedule generation logic to create classes on all selected days
- Update the calendar preview to show classes on all selected days
- Ensure the end date calculation accounts for multiple days per week
- Maintain backward compatibility with existing classes

## Implementation Details

### UI Changes
**File: app/Views/components/class-capture-partials/class-schedule-form.php**
- Replace the single select dropdown for day selection with a checkbox group
- Add "Select All" and "Clear All" buttons for convenience
- Update form validation to ensure at least one day is selected

Current structure:
```php
<div class="col-md-4 mb-3" id="day-selection-container">
   <div class="form-floating">
      <select id="schedule_day" name="schedule_day" class="form-select">
         <option value="">Select</option>
         <option value="Monday">Monday</option>
         <!-- other days -->
      </select>
      <label for="schedule_day">Day of Week <span class="text-danger">*</span></label>
      <div class="invalid-feedback">Please select a day.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>
</div>
```

New structure:
```php
<div class="col-md-12 mb-3" id="day-selection-container">
   <label class="form-label">Days of Week <span class="text-danger">*</span></label>
   <div class="days-checkbox-group">
      <div class="form-check form-check-inline">
         <input class="form-check-input schedule-day-checkbox" type="checkbox" id="schedule_day_monday" name="schedule_days[]" value="Monday">
         <label class="form-check-label" for="schedule_day_monday">Monday</label>
      </div>
      <!-- Repeat for other days -->
   </div>
   <div class="mt-2">
      <button type="button" class="btn btn-sm btn-outline-primary" id="select-all-days">Select All</button>
      <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-all-days">Clear All</button>
   </div>
   <div class="invalid-feedback">Please select at least one day.</div>
   <div class="valid-feedback">Looks good!</div>
</div>
```

### JavaScript Changes
**File: public/js/class-schedule-form.js**

1. Update the `initSchedulePatternSelection` function to handle multiple day selections
2. Create a new function `getSelectedDays()` to retrieve all selected days
3. Update the `updateScheduleData` function to store multiple days
4. Rename and update `restrictStartDateByDay` to `restrictStartDateBySelectedDays` to work with multiple days
5. Update the `recalculateEndDate` function to account for multiple days per week
6. Update the calendar preview functionality to show classes on all selected days

### Backend Changes
**File: app/Controllers/ClassController.php**

1. Update the `generateScheduleData` method to handle an array of days instead of a single day
2. For each selected day, generate the appropriate schedule entries
3. Ensure backward compatibility with existing classes that use a single day

### CSS Updates
**File: includes/css/ydcoza-styles.css**

Add styling for the day selection checkboxes:
```css
.days-checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.form-check-inline {
    margin-right: 0;
}

#day-selection-container .invalid-feedback,
#day-selection-container .valid-feedback {
    display: block;
    margin-top: 0.5rem;
}
```

## Testing Plan

### UI Testing
- Verify that the day selection checkboxes appear correctly
- Verify that "Select All" and "Clear All" buttons work
- Verify that the day selection is shown/hidden based on the schedule pattern

### Form Validation Testing
- Submit the form with no days selected (should show validation error)
- Submit the form with one day selected (should pass validation)
- Submit the form with multiple days selected (should pass validation)

### Schedule Generation Testing
- Test weekly pattern with one day selected
- Test weekly pattern with multiple days selected
- Test biweekly pattern with one day selected
- Test biweekly pattern with multiple days selected
- Test monthly pattern (should still use day of month, not affected)

### Calendar Preview Testing
- Verify that classes appear on all selected days in the calendar
- Verify that exception dates are respected
- Verify that holiday conflicts are detected correctly

### End Date Calculation Testing
- Verify that the end date is calculated correctly based on class duration and frequency
- Verify that the end date is earlier when more days per week are selected

### Backward Compatibility Testing
- Test with existing classes that use single day selection
- Verify that existing classes still display correctly

## Acceptance Criteria
- Users can select multiple days of the week for weekly and biweekly patterns
- Classes are correctly scheduled on all selected days
- The calendar preview shows classes on all selected days
- The end date is calculated correctly based on the number of days selected
- Existing classes with single day selection continue to work correctly
- All form validation works correctly with multiple day selection

## Related Tasks
- WEC-83: Multiple Days of the Week