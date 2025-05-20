<?php
/**
 * Class Notes & QA Partial View
 *
 * This partial view renders the class notes and quality assurance section of the class capture form,
 * including operational notes and QA visit dates with report uploads.
 *
 * @var array $data View data passed from ClassController
 */
?>
<?php echo section_header('Class Notes & QA', 'Add operational notes and quality assurance information for this class.'); ?>

<!-- Class Notes & QA Information -->
<div class="row">
   <!-- Class Notes (Multi-select) -->
   <div class="col-md-6">
      <!-- For multi-select with floating labels, we need a custom approach -->
      <div class="mb-3">
      <label for="class_notes" class="form-label">Class Notes</label>
      <select
         id="class_notes"
         name="class_notes[]"
         class="form-select"
         size="5"
         multiple
         aria-label="Class notes selection"
      >
         <?php foreach ($data['class_notes_options'] as $option): ?>
            <option value="<?= $option['id'] ?>"><?= $option['name'] ?></option>
         <?php endforeach; ?>
      </select>
      <div class="form-text">
         Select multiple operational notes that apply to this class. Hold Ctrl/Cmd to select.
      </div>
      <div class="invalid-feedback">Please select at least one note.</div>
      <div class="valid-feedback">Looks good!</div>
      </div>

      
   </div>
</div>

<!-- QA Visit Dates and Reports Section -->
<div class="mt-4">
   <h6 class="mb-3">QA Visit Dates & Reports</h6>
   <p class="text-muted small mb-3">Add QA visit dates and upload corresponding reports for each visit.</p>

   <!-- Container for all QA visit date rows -->
   <div id="qa-visits-container"></div>

   <!-- Hidden Template Row (initially d-none) -->
   <div class="row qa-visit-row align-items-center d-none" id="qa-visit-row-template">
      <!-- Visit Date -->
      <div class="col-md-4 mb-2">
         <div class="form-floating">
            <input type="date" name="qa_visit_dates[]" class="form-control" placeholder="YYYY-MM-DD">
            <label>Visit Date</label>
            <div class="invalid-feedback">Please select a valid date.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <!-- Report Upload -->
      <div class="col-md-6 mb-2">
         <div class="form-floating ydcoza-upload">
            <input type="file" name="qa_reports[]" class="form-control" accept="application/pdf">
            <label>QA Report</label>
            <div class="invalid-feedback">Please upload a report for this visit.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <!-- Remove Button -->
      <div class="col-md-2 mb-2">
         <div class="d-flex h-100 align-items-end">
            <button type="button" class="btn btn-outline-danger btn-sm remove-qa-visit-btn form-control date-remove-btn">Remove</button>
         </div>
      </div>
   </div>

   <!-- Add Row Button -->
   <button type="button" class="btn btn-outline-primary btn-sm" id="add-qa-visit-btn">
   + Add QA Visit Date
   </button>
</div>
