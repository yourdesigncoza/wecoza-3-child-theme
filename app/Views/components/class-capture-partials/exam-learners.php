<?php
/**
 * Exam Learners Partial View
 *
 * This partial view renders the exam learners section of the class capture form,
 * allowing users to select which learners will take exams in an exam class.
 * This section is conditionally displayed based on whether the class is an exam class.
 *
 * @var array $data View data passed from ClassController
 */
?>
<!-- Exam Learners (conditionally displayed) -->
<div class="row mt-5" id="exam_learners_container" style="display: none;">
<?php echo section_divider(); ?>
   <div class="col-12">
      <h5 class="mb-3">Select Learners Taking Exams</h5>
      <p class="text-muted small mb-3">Not all learners in an exam class necessarily take exams. Select which learners will take exams.</p>

      <div class="row mb-4">
         <!-- Exam Learner Selection -->
         <div class="col-md-4">
            <label for="exam_learner_select" class="form-label">Select Learners Taking Exams <span class="text-danger">*</span></label>
            <select id="exam_learner_select" name="exam_learner_select[]" class="form-select form-select-sm" size="5" multiple>
               <!-- Will be populated dynamically with class learners -->
            </select>
            <div class="form-text">Select learners who will take exams in this class.</div>
            <div class="invalid-feedback">Please select at least one learner for exams.</div>
            <div class="valid-feedback">Looks good!</div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-selected-exam-learners-btn">
               Add Selected Exam Learners
            </button>
         </div>

         <!-- Exam Learners List -->
         <div class="col-md-8">
            <label class="form-label">Learners Taking Exams</label>
            <div id="exam-learners-list" class="border rounded p-3 mb-3">
               <div class="alert alert-info" id="no-exam-learners-message">
                  No exam learners added yet. Select learners from the list and click "Add Selected Exam Learners".
               </div>
               <table class="table table-sm d-none" id="exam-learners-table">
                  <thead>
                     <tr>
                        <th>Learner</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody id="exam-learners-tbody">
                     <!-- Exam learner rows will be added here dynamically -->
                  </tbody>
               </table>
            </div>
         </div>
      </div>

      <!-- Hidden field to store exam learners data -->
      <input type="hidden" id="exam_learners" name="exam_learners" value="">
   </div>
</div>
