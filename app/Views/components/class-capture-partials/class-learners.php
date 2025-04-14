<?php
/**
 * Class Learners Partial View
 *
 * This partial view renders the class learners section of the class capture form,
 * allowing users to select and manage learners for the class.
 *
 * @var array $data View data passed from ClassController
 */
?>
<!-- Class Learners Section -->
<?php echo section_header('Class Learners', 'Select learners for this class and manage their status.'); ?>

<div class="row mb-4">
   <!-- Learner Selection -->
   <div class="col-md-4">
      <label for="add_learner" class="form-label">Select Learners <span class="text-danger">*</span></label>
      <select id="add_learner" name="add_learner[]" class="form-select form-select-sm" size="5" multiple required>
         <?php foreach ($data['learners'] as $learner): ?>
            <option value="<?php echo esc_attr($learner['id']); ?>"><?php echo esc_html($learner['name']); ?></option>
         <?php endforeach; ?>
      </select>
      <div class="form-text">Select multiple learners to add to this class.</div>
      <div class="invalid-feedback">Please select at least one learner.</div>
      <div class="valid-feedback">Looks good!</div>
      <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-selected-learners-btn">
         Add Selected Learners
      </button>
   </div>

   <!-- Learners Table -->
   <div class="col-md-8">
      <label class="form-label">Class Learners</label>
      <div id="class-learners-container" class="border rounded p-3">
         <div class="alert alert-info" id="no-learners-message">
            No learners added to this class yet. Select learners from the list and click "Add Selected Learners".
         </div>
         <table class="table table-sm d-none" id="class-learners-table">
            <thead>
               <tr>
                  <th>Learner</th>
                  <th>Host/Walk-in Status</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody id="class-learners-tbody">
               <!-- Learner rows will be added here dynamically -->
            </tbody>
         </table>
      </div>
      <!-- Hidden field to store learner data -->
      <input type="hidden" id="class_learners_data" name="class_learners_data" value="">
   </div>
</div>
