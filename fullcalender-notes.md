# FullCalendar Integration Notes

## Date Handling Issues

### Problem: Holiday Date Display

**Issue Description:**
- Holidays are correctly displayed in the calendar grid (e.g., Youth Day on June 16th)
- However, when clicking the "+1 more" link, the popover shows the wrong date (e.g., "June 15, 2025" instead of "June 16, 2025")

**Root Cause:**
- In `PublicHolidaysController.php`, we subtract one day from holiday dates to compensate for timezone/display issues:
  ```php
  // IMPORTANT: DO NOT CHANGE THIS ADJUSTMENT!
  // Subtract one day from the date to compensate for the timezone shift
  // Removing or changing this adjustment will cause holidays to display on the wrong dates
  $dateObj = new \DateTime($date);
  $dateObj->modify('-1 day');
  $adjustedDate = $dateObj->format('Y-m-d');
  ```
- This adjustment is necessary for holidays to display on the correct date in the calendar grid
- However, it also affects the date shown in the popover title

**Attempted Solutions:**
1. **Custom moreLinkClick Callback:**
   - Added a callback to adjust the date in the popover by adding one day back
   - Implementation added to both `class-schedule-form.js` and `class-capture.js`
   - This approach didn't resolve the issue

## FullCalendar Configuration

### Current Setup
- Using FullCalendar version 6.x
- Primary views: multiMonthYear, dayGridMonth, timeGridDay
- Default view: multiMonthYear (3 months side by side)
- Public holidays are added as events with special styling

### Key Configuration Options
```javascript
calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'multiMonthYear',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'multiMonthYear,dayGridMonth'
    },
    // Other options...
});
```

## Next Steps to Investigate

1. **Examine Event Creation:**
   - Review how holiday events are created and added to the calendar
   - Check if there's a discrepancy between the event date and display date

2. **Explore Alternative Date Handling:**
   - Consider handling the date adjustment in JavaScript instead of PHP
   - Investigate if FullCalendar has built-in timezone handling that could help

3. **Popover Customization Options:**
   - Research if FullCalendar provides more direct ways to customize the popover content and title
   - Look into using CSS to modify the popover appearance

4. **Debug Date Objects:**
   - Add logging to track date objects throughout the process
   - Compare PHP date strings with JavaScript Date objects

## Resources

- [FullCalendar Documentation](https://fullcalendar.io/docs)
- [FullCalendar Date & Time Handling](https://fullcalendar.io/docs/date-library)
- [FullCalendar More-Link Handling](https://fullcalendar.io/docs/more-link-render-hooks)

## What Works Correctly (Do Not Change)

### Public Holiday Display in Calendar Grid

The current implementation correctly displays public holidays in the calendar grid:

- Youth Day appears on June 16th with the correct styling (red background)
- The calendar cell for June 16th is properly highlighted to indicate it's a holiday
- The visual indicator in the month view clearly shows holidays on their correct dates
- This functionality must be preserved in any solution

The key part that makes this work is the date adjustment in `PublicHolidaysController.php`:

```php
// IMPORTANT: DO NOT CHANGE THIS ADJUSTMENT!
// Subtract one day from the date to compensate for the timezone shift
// Removing or changing this adjustment will cause holidays to display on the wrong dates
$dateObj = new \DateTime($date);
$dateObj->modify('-1 day');
$adjustedDate = $dateObj->format('Y-m-d');
```

This adjustment is essential for the correct display of holidays in the calendar grid and should not be modified.
