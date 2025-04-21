<?php
/**
 * Class Schedule Form Partial View
 *
 * This partial view renders the form-based class scheduling section of the class capture form,
 * allowing users to set up recurring class schedules with various patterns.
 *
 * @var array $data View data passed from ClassController
 */
?>
<!-- Class Schedule Form Section -->
<div class="mb-4 mt-3">
   <h5 class="mb-3">Class Schedule</h5>
   <p class="text-muted small mb-3">Set up the recurring schedule for this class.</p>

   <!-- Schedule Pattern Selection -->
   <div class="row mb-3">
      <div class="col-md-4">
         <label for="schedule_pattern" class="form-label">Schedule Pattern <span class="text-danger">*</span></label>
         <select id="schedule_pattern" name="schedule_pattern" class="form-select form-select-sm" required>
            <option value="">Select</option>
            <option value="weekly">Weekly (Every Week)</option>
            <option value="biweekly">Bi-Weekly (Every Two Weeks)</option>
            <option value="monthly">Monthly</option>
            <option value="custom">Custom</option>
         </select>
         <div class="invalid-feedback">Please select a schedule pattern.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

      <!-- Day Selection (for weekly/biweekly) -->
      <div class="col-md-4" id="day-selection-container">
         <label for="schedule_day" class="form-label">Day of Week <span class="text-danger">*</span></label>
         <select id="schedule_day" name="schedule_day" class="form-select form-select-sm">
            <option value="">Select</option>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
            <option value="Sunday">Sunday</option>
         </select>
         <div class="invalid-feedback">Please select a day.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

      <!-- Day of Month (for monthly) -->
      <div class="col-md-4 d-none" id="day-of-month-container">
         <label for="schedule_day_of_month" class="form-label">Day of Month <span class="text-danger">*</span></label>
         <select id="schedule_day_of_month" name="schedule_day_of_month" class="form-select form-select-sm">
            <option value="">Select</option>
            <?php for ($i = 1; $i <= 31; $i++): ?>
               <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
            <option value="last">Last Day</option>
         </select>
         <div class="invalid-feedback">Please select a day of the month.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <!-- Time Selection -->
   <div class="row mb-3">
      <div class="col-md-4">
         <label for="schedule_start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
         <select id="schedule_start_time" name="schedule_start_time" class="form-select form-select-sm" required>
            <option value="">Select</option>
            <?php
            // Generate time options from 6:00 AM to 8:00 PM in 30-minute increments
            $start = strtotime('06:00:00');
            $end = strtotime('20:00:00');
            $interval = 30 * 60; // 30 minutes in seconds

            for ($time = $start; $time <= $end; $time += $interval) {
               $timeStr = date('H:i', $time);
               echo '<option value="' . $timeStr . '">' . date('g:i A', $time) . '</option>';
            }
            ?>
         </select>
         <div class="invalid-feedback">Please select a start time.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

      <div class="col-md-4">
         <label for="schedule_end_time" class="form-label">End Time <span class="text-danger">*</span></label>
         <select id="schedule_end_time" name="schedule_end_time" class="form-select form-select-sm" required>
            <option value="">Select</option>
            <?php
            // Generate time options from 6:30 AM to 8:30 PM in 30-minute increments
            $start = strtotime('06:30:00');
            $end = strtotime('20:30:00');
            $interval = 30 * 60; // 30 minutes in seconds

            for ($time = $start; $time <= $end; $time += $interval) {
               $timeStr = date('H:i', $time);
               echo '<option value="' . $timeStr . '">' . date('g:i A', $time) . '</option>';
            }
            ?>
         </select>
         <div class="invalid-feedback">Please select an end time.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

      <div class="col-md-4">
         <label for="schedule_duration" class="form-label">Duration (Hours)</label>
         <input type="text" id="schedule_duration" name="schedule_duration" class="form-control form-control-sm readonly-field" readonly>
         <small class="text-muted">Automatically calculated</small>
      </div>
   </div>

   <!-- Date Range -->
   <div class="row mb-3">
      <div class="col-md-4">
         <label for="schedule_start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
         <input type="date" id="schedule_start_date" name="schedule_start_date" class="form-control form-control-sm" required>
         <div class="invalid-feedback">Please select a start date.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

      <div class="col-md-4">
         <label for="schedule_end_date" class="form-label">End Date</label>
         <input type="date" id="schedule_end_date" name="schedule_end_date" class="form-control form-control-sm readonly-field" readonly>
         <small class="text-muted">Automatically calculated based on class duration</small>
      </div>

      <div class="col-md-4">
         <label for="schedule_total_hours" class="form-label">Total Hours</label>
         <input type="text" id="schedule_total_hours" name="schedule_total_hours" class="form-control form-control-sm readonly-field" readonly>
         <small class="text-muted">Based on class type</small>
      </div>
   </div>

   <!-- Exception Dates -->
   <div class="mb-4">
      <h6 class="mb-2">Exception Dates</h6>
      <p class="text-muted small mb-3">Add dates when classes will not occur (e.g., holidays, client cancellations).</p>

      <!-- Container for all exception date rows -->
      <div id="exception-dates-container"></div>

      <!-- Hidden Template Row (initially d-none) -->
      <div class="row exception-date-row d-none" id="exception-date-row-template">
         <!-- Exception Date -->
         <div class="col-md-4 mb-2">
            <label class="form-label">Date</label>
            <input type="date" name="exception_dates[]" class="form-control form-control-sm">
            <div class="invalid-feedback">Please select a valid date.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

         <!-- Reason -->
         <div class="col-md-6 mb-2">
            <label class="form-label">Reason</label>
            <select name="exception_reasons[]" class="form-select form-select-sm">
               <option value="">Select</option>
               <option value="Client Cancelled">Client Cancelled</option>
               <option value="Agent Absent">Agent Absent</option>
               <option value="Public Holiday">Public Holiday</option>
               <option value="Other">Other</option>
            </select>
            <div class="invalid-feedback">Please select a reason.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

         <!-- Remove Button -->
         <div class="col-md-2 mb-2">
            <label class="form-label invisible">&nbsp;</label>
            <button type="button" class="btn btn-outline-danger btn-sm remove-exception-btn form-control date-remove-btn">Remove</button>
         </div>
      </div>

      <!-- Add Exception Button -->
      <button type="button" class="btn btn-outline-primary btn-sm" id="add-exception-date-btn">
      + Add Exception Date
      </button>
   </div>

   <!-- View Calendar Button -->
   <div class="mt-4">
      <button type="button" class="btn btn-outline-secondary" id="view-calendar-btn">
         <i class="bi bi-calendar3"></i> View Calendar
      </button>
      <small class="text-muted ms-2">Click to view a visual representation of the schedule</small>
   </div>

   <!-- Hidden inputs to store schedule data in the format expected by the backend -->
   <div id="schedule-data-container">
      <!-- These will be populated dynamically via JavaScript -->
   </div>
</div>
