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
<?php echo section_header('Class Learners <span class="text-danger">*</span>', 'Select learners for this class and manage their status.'); ?>

<div class="row mb-4">
   <!-- Learner Selection -->
   <div class="col-md-4">
      <!-- For multi-select with floating labels, we need a custom approach -->
      <div class="form-floating mb-3">
         <select id="add_learner" name="add_learner[]" class="form-select" aria-label="Learner selection" multiple>
            <?php foreach ($data['learners'] as $learner): ?>
               <option value="<?php echo $learner['id']; ?>"><?php echo $learner['name']; ?></option>
            <?php endforeach; ?>
         </select>
         <label for="add_learner">Select Learners</label>
         <div class="form-text">Select multiple learners to add to this class. Hold Ctrl/Cmd to select multiple.</div>
         <div class="invalid-feedback">Please select at least one learner.</div>
         <div class="valid-feedback">Looks good!</div>
         <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-selected-learners-btn">
            Add Selected Learners
         </button>
      </div>
   </div>

   <!-- Learners Table -->
   <div class="col-md-8">
      <div class="mb-3">
         <div class="form-label mb-2">Class Learners</div>
         <div id="class-learners-container" class="border rounded p-3">
            <div class="bd-callout bd-callout-info" id="no-learners-message">
               No learners added to this class yet. At least one learner is required. Select learners from the list and click "Add Selected Learners".
            </div>
            <table class="table table-sm d-none" id="class-learners-table">
               <thead>
                  <tr>
                     <th>Learner</th>
                     <th>Level/Module</th>
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
</div>
