<?php
/**
 * Date History Partial View
 *
 * This partial view renders the date history section of the class capture form,
 * allowing users to add stop and restart dates for the class.
 *
 * @var array $data View data passed from ClassController
 */
?>
<!-- Class Date History Section -->
<div class="mb-4 mt-3">
   <h5 class="mb-3">Class Date History</h5>
   <p class="text-muted small mb-3">Add stop and restart dates for this class. A class can have multiple stop and restart dates.</p>

   <!-- Container for all date history rows -->
   <div id="date-history-container"></div>

   <!-- Hidden Template Row (initially d-none) -->
   <div class="row date-history-row d-none" id="date-history-row-template">
      <!-- Stop Date -->
      <div class="col-md-5 mb-2">
         <label class="form-label">Stop Date</label>
         <input type="date" name="stop_dates[]" class="form-control form-control-sm">
         <div class="invalid-feedback">Please select a valid date.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

      <!-- Restart Date -->
      <div class="col-md-5 mb-2">
         <label class="form-label">Restart Date</label>
         <input type="date" name="restart_dates[]" class="form-control form-control-sm">
         <div class="invalid-feedback">Please select a valid date.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

      <!-- Remove Button -->
      <div class="col-md-2 mb-2">
         <label class="form-label invisible">&nbsp;</label>
         <button type="button" class="btn btn-outline-danger btn-sm remove-date-row-btn form-control date-remove-btn">Remove</button>
      </div>
   </div>

   <!-- Add Row Button -->
   <button type="button" class="btn btn-outline-primary btn-sm" id="add-date-history-btn">
   + Add Stop/Restart Dates
   </button>
</div>
