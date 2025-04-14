<?php
/**
 * Class Schedule Calendar Partial View
 *
 * This partial view renders the calendar section of the class capture form,
 * including the calendar container and event modal for scheduling class sessions.
 *
 * @var array $data View data passed from ClassController
 */
?>
<!-- Day/Time Schedule Section -->
<div class="mb-3">
   <h5 class="mb-3">Class Schedule Calendar</h5>
   <p class="text-muted small mb-3">Manage class schedules visually.</p>

   <!-- Calendar Container -->
   <div id="class-calendar" class="mb-3" data-calendar-init="true"></div>

   <!-- Event Form Modal -->
   <div class="modal" id="eventModal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="eventModalLabel">Add/Edit Class Event</h5>
               <button type="button" class="btn-close" id="closeModalBtn" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="eventForm">
                  <input type="hidden" id="eventId">
                  <div class="mb-3">
                     <label class="form-label">Class Type</label>
                     <select class="form-select form-select-sm" id="eventType" required>
                        <option value="">Select</option>
                        <?php foreach ($data['class_types'] as $class_type): ?>
                           <option value="<?php echo esc_attr($class_type['id']); ?>"><?php echo esc_html($class_type['name']); ?></option>
                        <?php endforeach; ?>
                     </select>
                     <div class="invalid-feedback">Please select a class type.</div>
                     <div class="valid-feedback">Looks good!</div>
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Description</label>
                     <textarea class="form-control form-control-sm" id="eventDescription" required></textarea>
                     <div class="invalid-feedback">Please enter a description.</div>
                     <div class="valid-feedback">Looks good!</div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control form-control-sm readonly-field" id="eventDate" readonly required>
                        <small class="text-muted">Date is set from calendar selection</small>
                     </div>
                     <div class="col-md-6 mb-3">
                        <label class="form-label">Day</label>
                        <input type="text" class="form-control form-control-sm readonly-field" id="eventDay" readonly required>
                        <small class="text-muted">Day is automatically determined</small>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 mb-3">
                        <label class="form-label">Start Time</label>
                        <select class="form-select form-select-sm" id="eventStartTime" required>
                           <!-- Will be populated via JavaScript -->
                        </select>
                        <div class="invalid-feedback">Please select a start time.</div>
                        <div class="valid-feedback">Looks good!</div>
                     </div>
                     <div class="col-md-6 mb-3">
                        <label class="form-label">End Time</label>
                        <select class="form-select form-select-sm" id="eventEndTime" required>
                           <!-- Will be populated via JavaScript -->
                        </select>
                        <div class="invalid-feedback">Please select an end time.</div>
                        <div class="valid-feedback">Looks good!</div>
                     </div>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" id="cancelEvent">Cancel</button>
               <button type="button" class="btn btn-danger btn-sm" id="deleteEvent">Delete</button>
               <button type="button" class="btn btn-primary btn-sm" id="saveEvent">Save Event</button>
            </div>
         </div>
      </div>
   </div>

   <!-- Hidden inputs to store calendar events data in the format expected by the backend -->
   <div id="schedule-data-container">
      <!-- These will be populated dynamically via JavaScript -->
   </div>
</div>
