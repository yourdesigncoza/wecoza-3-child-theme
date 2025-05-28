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

   <?php if (isset($data['mode']) && $data['mode'] === 'update'): ?>
      <!-- UPDATE MODE: Display existing schedule info -->
      <div class="alert alert-success mb-3">
         <h6 class="mb-2">Current Schedule</h6>
         <p class="mb-1"><strong>Pattern:</strong> <?php echo isset($data['class_data']) && $data['class_data'] ? esc_html($data['class_data']->schedule_pattern ?? 'Not specified') : 'Loading...'; ?></p>
         <p class="mb-1"><strong>Days:</strong> <?php echo isset($data['class_data']) && $data['class_data'] ? esc_html($data['class_data']->schedule_days ?? 'Not specified') : 'Loading...'; ?></p>
         <p class="mb-0"><strong>Time:</strong> <?php echo isset($data['class_data']) && $data['class_data'] ? esc_html(($data['class_data']->start_time ?? '') . ' - ' . ($data['class_data']->end_time ?? '')) : 'Loading...'; ?></p>
      </div>
      <p class="text-muted small mb-3">Schedule is set. Use exception dates below to manage individual class cancellations.</p>
   <?php else: ?>
      <!-- CREATE MODE: Full schedule setup -->
      <p class="text-muted small mb-3">Set up the recurring schedule for this class.</p>

   <!-- Schedule Pattern Selection -->
   <div class="row mb-3">
      <div class="col-md-4 mb-3">
         <div class="form-floating">
            <select id="schedule_pattern" name="schedule_pattern" class="form-select" required>
               <option value="">Select</option>
               <option value="weekly">Weekly (Every Week)</option>
               <option value="biweekly">Bi-Weekly (Every Two Weeks)</option>
               <option value="monthly">Monthly</option>
               <option value="custom">Custom</option>
            </select>
            <label for="schedule_pattern">Schedule Pattern <span class="text-danger">*</span></label>
            <div class="invalid-feedback">Please select a schedule pattern.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <!-- Day Selection (for weekly/biweekly) -->
      <div class="col-md-12 mb-3" id="day-selection-container">
         <label class="form-label">Days of Week <span class="text-danger">*</span></label>
         <div class="days-checkbox-group">
            <div class="form-check form-check-inline">
               <input class="form-check-input schedule-day-checkbox" type="checkbox" id="schedule_day_monday" name="schedule_days[]" value="Monday">
               <label class="form-check-label" for="schedule_day_monday">Monday</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input schedule-day-checkbox" type="checkbox" id="schedule_day_tuesday" name="schedule_days[]" value="Tuesday">
               <label class="form-check-label" for="schedule_day_tuesday">Tuesday</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input schedule-day-checkbox" type="checkbox" id="schedule_day_wednesday" name="schedule_days[]" value="Wednesday">
               <label class="form-check-label" for="schedule_day_wednesday">Wednesday</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input schedule-day-checkbox" type="checkbox" id="schedule_day_thursday" name="schedule_days[]" value="Thursday">
               <label class="form-check-label" for="schedule_day_thursday">Thursday</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input schedule-day-checkbox" type="checkbox" id="schedule_day_friday" name="schedule_days[]" value="Friday">
               <label class="form-check-label" for="schedule_day_friday">Friday</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input schedule-day-checkbox" type="checkbox" id="schedule_day_saturday" name="schedule_days[]" value="Saturday">
               <label class="form-check-label" for="schedule_day_saturday">Saturday</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input schedule-day-checkbox" type="checkbox" id="schedule_day_sunday" name="schedule_days[]" value="Sunday">
               <label class="form-check-label" for="schedule_day_sunday">Sunday</label>
            </div>
         </div>
         <div class="mt-2">
            <button type="button" class="btn btn-sm btn-outline-primary" id="select-all-days">Select All</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-all-days">Clear All</button>
         </div>
         <div class="invalid-feedback">Please select at least one day.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

      <!-- Day of Month (for monthly) -->
      <div class="col-md-4 mb-3 d-none" id="day-of-month-container">
         <div class="form-floating">
            <select id="schedule_day_of_month" name="schedule_day_of_month" class="form-select">
               <option value="">Select</option>
               <?php for ($i = 1; $i <= 31; $i++): ?>
                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
               <?php endfor; ?>
               <option value="last">Last Day</option>
            </select>
            <label for="schedule_day_of_month">Day of Month <span class="text-danger">*</span></label>
            <div class="invalid-feedback">Please select a day of the month.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>
   </div>

   <!-- Time Selection -->
   <div class="row mb-3">
      <div class="col-md-4 mb-3">
         <div class="form-floating">
            <select id="schedule_start_time" name="schedule_start_time" class="form-select" required>
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
            <label for="schedule_start_time">Start Time <span class="text-danger">*</span></label>
            <div class="invalid-feedback">Please select a start time.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <div class="col-md-4 mb-3">
         <div class="form-floating">
            <select id="schedule_end_time" name="schedule_end_time" class="form-select" required>
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
            <label for="schedule_end_time">End Time <span class="text-danger">*</span></label>
            <div class="invalid-feedback">Please select an end time.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <div class="col-md-4 mb-3">
         <div class="form-floating">
            <input type="text" id="schedule_duration" name="schedule_duration" class="form-control readonly-field" placeholder="Duration" readonly>
            <label for="schedule_duration">Class Duration (Hours)</label>
            <small class="text-muted">Automatically calculated</small>
         </div>
      </div>
   </div>

   <!-- Date Range -->
   <div class="row mb-3">
      <div class="col-md-4 mb-3">
         <div class="form-floating">
            <input type="date" id="schedule_start_date" name="schedule_start_date" class="form-control" placeholder="YYYY-MM-DD" required>
            <label for="schedule_start_date">Start Date <span class="text-danger">*</span></label>
            <div class="invalid-feedback">Please select a start date.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <div class="col-md-4 mb-3">
         <div class="form-floating">
            <input type="date" id="schedule_end_date" name="schedule_end_date" class="form-control readonly-field" placeholder="YYYY-MM-DD" readonly>
            <label for="schedule_end_date">End Date</label>
            <small class="text-muted">Automatically calculated based on class duration</small>
         </div>
      </div>

      <div class="col-md-4 d-none">
         <div class="form-floating">
            <input type="text" id="schedule_total_hours" name="schedule_total_hours" class="form-control readonly-field" placeholder="Total Hours" readonly>
            <label for="schedule_total_hours">Total Hours</label>
            <small class="text-muted">Based on class type</small>
         </div>
      </div>
   </div>
   <?php endif; ?>

   <!-- Exception Dates - UPDATE MODE ONLY -->
   <?php if (isset($data['mode']) && $data['mode'] === 'update'): ?>
   <div class="mb-4">
      <h6 class="mb-2">Exception Dates</h6>
      <p class="text-muted small mb-3">Add dates when classes will not occur (e.g., holidays, client cancellations).</p>

      <!-- Container for all exception date rows -->
      <div id="exception-dates-container"></div>

      <!-- Hidden Template Row (initially d-none) -->
      <div class="row exception-date-row align-items-center d-none" id="exception-date-row-template">
         <!-- Exception Date -->
         <div class="col-md-4 mb-2">
            <div class="form-floating">
               <input type="date" name="exception_dates[]" class="form-control" placeholder="YYYY-MM-DD">
               <label>Date</label>
               <div class="invalid-feedback">Please select a valid date.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>
         </div>

         <!-- Reason -->
         <div class="col-md-6 mb-2">
            <div class="form-floating">
               <select name="exception_reasons[]" class="form-select">
                  <option value="">Select</option>
                  <option value="Client Cancelled">Client Cancelled</option>
                  <option value="Agent Absent">Agent Absent</option>
                  <option value="Public Holiday">Public Holiday</option>
                  <option value="Other">Other</option>
               </select>
               <label>Reason</label>
               <div class="invalid-feedback">Please select a reason.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>
         </div>

         <!-- Remove Button -->
         <div class="col-md-2 mb-2">
            <div class="d-flex h-100 align-items-end">
               <button type="button" class="btn btn-outline-danger btn-sm remove-exception-btn form-control date-remove-btn">Remove</button>
            </div>
         </div>
      </div>

      <!-- Add Exception Button -->
      <button type="button" class="btn btn-outline-primary btn-sm" id="add-exception-date-btn">
      + Add Exception Date
      </button>
   </div>
   <?php endif; ?>

   <!-- Public Holidays Section - UPDATE MODE ONLY -->
   <?php if (isset($data['mode']) && $data['mode'] === 'update'): ?>
   <div class="mb-4">
      <h6 class="mb-2">Public Holidays in Schedule</h6>
      <p class="text-muted small mb-3">By default, classes are not scheduled on public holidays. The system will only show holidays that conflict with your class schedule (when a holiday falls on a scheduled class day). You can override specific holidays to include them in the schedule.</p>

      <!-- No holidays message -->
      <div id="no-holidays-message" class="bd-callout bd-callout-info">
         No public holidays that conflict with your class schedule were found. Holidays are only shown when they fall on a scheduled class day.
      </div>

      <!-- Holidays table container -->
      <div id="holidays-table-container" class="card-body card-body card px-5 d-none" >
         <div class="table-responsive">
            <table class="table table-sm fs-9 mb-0 table-hover">
               <thead>
                  <tr>
                     <th style="width: 50px;">
                        <div class="form-check">&nbsp;</div>
                     </th>
                     <th>Date</th>
                     <th>Holiday</th>
                     <th>Override</th>
                  </tr>
               </thead>
               <tbody id="holidays-list">
                  <!-- Holidays will be populated here dynamically -->
               </tbody>
            </table>
         </div>

         <div class="d-flex justify-content-between mt-2">
            <div>
               <button type="button" class="btn btn-outline-secondary btn-sm" id="skip-all-holidays-btn">Skip All Holidays</button>
               <button type="button" class="btn btn-outline-primary btn-sm" id="override-all-holidays-btn">Override All Holidays</button>
            </div>
         </div>
      </div>
   </div>
   <?php endif; ?>

   <!-- Holiday Row Template (for JavaScript) -->
   <template id="holiday-row-template">
      <tr class="holiday-row">
         <td>
            <div class="form-check">
               <input class="form-check-input holiday-override-checkbox" type="checkbox" id="override-holiday-{id}" data-date="{date}">
               <label class="form-check-label" for="override-holiday-{id}"></label>
            </div>
         </td>
         <td class="holiday-date">{formatted_date}</td>
         <td class="holiday-name">{name}</td>
         <td class="holiday-status">
            <span class="badge bg-danger holiday-skipped">Skipped</span>
            <span class="badge bg-info holiday-overridden d-none">Included</span>
         </td>
      </tr>
   </template>

   <!-- Hidden input to store holiday override data -->
   <input type="hidden" id="holiday_overrides" name="schedule_data[holiday_overrides]" value="">

   <!-- Hidden inputs to store schedule data in the format expected by the backend -->
   <div id="schedule-data-container">
      <!-- These will be populated dynamically via JavaScript -->
   </div>

   <!-- Schedule Statistics Section - UPDATE MODE ONLY -->
   <?php if (isset($data['mode']) && $data['mode'] === 'update'): ?>
   <!-- Schedule Statistics Toggle Button -->
   <div class="mt-3 mb-3">
      <button type="button" class="btn btn-outline-primary btn-sm" id="toggle-statistics-btn">
         <i class="bi bi-bar-chart-line me-1"></i> View Schedule Statistics
      </button>
      <div class="clearfix"></div>
      <small class="text-muted">Click to view detailed statistics about the training schedule</small>
   </div>

   <!-- Schedule Statistics Section (hidden by default) -->
   <div class="card shadow-none border mb-3 d-none" id="schedule-statistics-section" data-component-card="data-component-card">
   <div class="card-header p-3 border-bottom bg-body">
      <h4 class="text-body mb-0" data-anchor="schedule-statistics" id="schedule-statistics">
         Schedule Statistics
         <a class="anchorjs-link" aria-label="Anchor" data-anchorjs-icon="#" href="#schedule-statistics" style="margin-left:0.1875em; padding:0 0.1875em;"></a>
      </h4>
   </div>
   <div class="card-body p-0">
      <div class="table-responsive scrollbar mb-3">
         <table class="table table-sm fs-9 mb-0 overflow-hidden">
         <thead class="text-body">
            <tr>
               <th class="sort pe-1 align-middle white-space-nowrap">Category</th>
               <th class="sort pe-1 align-middle white-space-nowrap">Metric</th>
               <th class="sort pe-1 align-middle white-space-nowrap">Value</th>
            </tr>
         </thead>
         <tbody id="schedule-statistics-table">
            <!-- Training Duration Statistics -->
            <tr class="ydcoza-table-subheader">
               <th colspan="3">Training Duration</th>
            </tr>
            <tr>
               <td rowspan="3" class="align-middle">Time Period</td>
               <td>Total Calendar Days</td>
               <td id="stat-total-days">-</td>
            </tr>
            <tr>
               <td>Total Weeks</td>
               <td id="stat-total-weeks">-</td>
            </tr>
            <tr>
               <td>Total Months</td>
               <td id="stat-total-months">-</td>
            </tr>

            <!-- Class Session Statistics -->
            <tr class="ydcoza-table-subheader">
               <th colspan="3">Class Sessions</th>
            </tr>
            <tr>
               <td rowspan="3" class="align-middle">Sessions</td>
               <td>Total Scheduled Classes</td>
               <td id="stat-total-classes">-</td>
            </tr>
            <tr>
               <td>Total Training Hours</td>
               <td id="stat-total-hours">-</td>
            </tr>
            <tr>
               <td>Average Hours per Month</td>
               <td id="stat-avg-hours-month">-</td>
            </tr>

            <!-- Attendance Impact Statistics -->
            <tr class="ydcoza-table-subheader">
               <th colspan="3">Attendance Impact</th>
            </tr>
            <tr>
               <td rowspan="3" class="align-middle">Adjustments</td>
               <td>Holidays Affecting Classes</td>
               <td id="stat-holidays-affecting">-</td>
            </tr>
            <tr>
               <td>Exception Dates</td>
               <td id="stat-exception-dates">-</td>
            </tr>
            <tr>
               <td>Actual Training Days</td>
               <td id="stat-actual-days">-</td>
            </tr>
         </tbody>
         </table>
      </div>
   </div>
   </div>
   <?php endif; ?>

   <!-- Debug JSON Data Display -->
   <!-- <div id="debug-json-container" class="mb-4">
      <div class="d-flex justify-content-between align-items-center mb-2">
         <button type="button" id="toggle-debug-json-btn" class="btn btn-sm btn-outline-secondary">Debug Dev. Data</button>
      </div>
      <pre id="debug-json-display" class="p-3 fs-10 bg-light border rounded d-none" style="max-height: 300px; overflow-y: auto;"></pre>
   </div> -->

</div>
