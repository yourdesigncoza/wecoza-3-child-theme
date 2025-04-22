<?php
/**
 * Class Schedule Calendar Partial View
 *
 * This partial view renders the calendar section of the class capture form as a view-only reference.
 * The calendar is hidden by default and shown when the user clicks the "View Calendar" button.
 *
 * @var array $data View data passed from ClassController
 */
?>
<!-- Calendar Reference View (hidden by default) -->
<div class="mb-3 d-none" id="calendar-reference-container">
   <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">Class Schedule Calendar</h5>
      <button type="button" class="btn btn-sm btn-outline-secondary" id="hide-calendar-btn">
         <i class="bi bi-x-lg"></i> Hide Calendar
      </button>
   </div>
   <p class="text-muted small mb-3">Visual representation of the class schedule. This calendar is for reference only.</p>

   <!-- Calendar Container -->
   <div id="class-calendar" class="mb-3" data-calendar-init="false" style="background-color: var(--base);"></div>

   <!-- Calendar Legend -->
   <div class="d-flex flex-wrap gap-3 mb-3">
      <div class="d-flex align-items-center">
         <div class="color-box" style="width: 15px; height: 15px; background-color: #6e5dc6; margin-right: 5px;"></div>
         <small>Regular Class</small>
      </div>
      <div class="d-flex align-items-center">
         <div class="color-box" style="width: 15px; height: 15px; background-color: #f3a712; margin-right: 5px;"></div>
         <small>Exam</small>
      </div>
      <div class="d-flex align-items-center">
         <div class="color-box" style="width: 15px; height: 15px; background-color: #4caf50; margin-right: 5px;"></div>
         <small>Material Delivery</small>
      </div>
      <div class="d-flex align-items-center">
         <div class="color-box" style="width: 15px; height: 15px; background-color: #f44336; margin-right: 5px;"></div>
         <small>Exception Date</small>
      </div>
   </div>

   <!-- Calendar Export Options -->
   <div class="export-options mb-3">
      <h6 class="mb-2">Export Options</h6>
      <p class="text-muted small mb-2">Export your class schedule to use in external calendar applications.</p>

      <div class="row">
         <div class="col-md-6">
            <button type="button" id="export-calendar-btn" class="btn btn-primary btn-sm">
               <i class="bi bi-calendar-event me-2"></i>Export to Google Calendar
            </button>
            <div class="form-text mt-2">
               Exports all classes as iCalendar (.ics) file that can be imported into Google Calendar and other calendar applications.
            </div>
         </div>
      </div>
   </div>
</div>
