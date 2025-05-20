<?php
/**
 * Class Schedule Calendar Partial View
 *
 * This partial view renders the schedule data as a table view.
 * The table is hidden by default and shown when the user clicks the "View Calendar" button.
 *
 * @var array $data View data passed from ClassController
 */
?>
   <!-- View Calendar Button -->
   <div class="mt-4">
      <button type="button" class="btn bg-success-subtle border-success-subtle mt-5" id="view-calendar-btn">
         <i class="bi bi-calendar3"></i> View Schedule
      </button>
      <div class="clearfix"></div>
      <small class="text-muted ms-2">Click to view a visual representation of the schedule</small>
   </div>
<!-- Schedule Reference View (hidden by default) -->
<div class="d-none card my-3" id="calendar-reference-container">
   <div class="card-body px-5 position-relative">

   <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">Class Schedule Details</h5>
      <button type="button" class="btn btn-sm btn-outline-secondary" id="hide-calendar-btn">
         <i class="bi bi-x-lg"></i> Hide Schedule
      </button>
   </div>
   <p class="text-muted small mb-3">Visual representation of the class schedule. This view is for reference only.</p>

   <!-- Schedule Summary Section -->
   <div class="mb-4">
      <h6 class="mb-3">Schedule Summary</h6>
      <div class="table-responsive">
         <table class="table table-bordered">
            <tbody>
               <tr>
                  <th style="width: 200px;">Pattern</th>
                  <td id="schedule-summary-pattern"></td>
               </tr>
               <tr>
                  <th>Start Date</th>
                  <td id="schedule-summary-start-date"></td>
               </tr>
               <tr>
                  <th>End Date</th>
                  <td id="schedule-summary-end-date"></td>
               </tr>
               <tr>
                  <th>Class Time</th>
                  <td id="schedule-summary-class-time"></td>
               </tr>
               <tr>
                  <th>Selected Days</th>
                  <td id="schedule-summary-days"></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>

   <!-- Exception Dates Section -->
   <div class="mb-4">
      <h6 class="mb-3">Exception Dates</h6>
      <div class="table-responsive">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>Date</th>
                  <th>Reason</th>
               </tr>
            </thead>
            <tbody id="exception-dates-table">
               <!-- Will be populated by JavaScript -->
               <tr id="no-exception-dates-row">
                  <td colspan="2" class="text-center">No exception dates have been added.</td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>

   <!-- Public Holidays Section -->
   <div class="mb-4">
      <h6 class="mb-3">Public Holidays in Schedule</h6>
      <div class="table-responsive">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>Date</th>
                  <th>Holiday</th>
                  <th>Status</th>
               </tr>
            </thead>
            <tbody id="holidays-table">
               <!-- Will be populated by JavaScript -->
               <tr id="no-holidays-row">
                  <td colspan="3" class="text-center">No public holidays that conflict with your class schedule were found.</td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>

   <!-- Table Legend -->
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
         <small>Public Holiday (Skipped)</small>
      </div>
      <div class="d-flex align-items-center">
         <div class="color-box" style="width: 15px; height: 15px; background-color: #ff9800; margin-right: 5px;"></div>
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
</div>
