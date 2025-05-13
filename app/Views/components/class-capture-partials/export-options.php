<?php
/**
 * Export Options Partial
 *
 * This partial contains the export options for the class calendar.
 * It provides a button to export the calendar data to iCalendar format.
 */
?>
<div class="export-options mb-4">
    <h5 class="mb-3">Export Options</h5>
    <p class="text-muted small mb-3">Export your class schedule to use in external calendar applications.</p>

    <div class="row">
        <div class="col-md-6">
            <button type="button" id="export-calendar-btn" class="btn btn-primary">
                <i class="bi bi-calendar-event me-2"></i>Export to Google Calendar
            </button>
            <div class="form-text mt-2">
                Exports all classes as iCalendar (.ics) file that can be imported into Google Calendar and other calendar applications.
            </div>
        </div>
    </div>
</div>
