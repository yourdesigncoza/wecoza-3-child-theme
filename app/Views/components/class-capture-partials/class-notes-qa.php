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
      <label for="class_notes" class="form-label">Class Notes</label>
      <select id="class_notes" name="class_notes[]" class="form-select form-select-sm" size="5" multiple>
         <?php foreach ($data['class_notes_options'] as $option): ?>
            <option value="<?php echo esc_attr($option['id']); ?>"><?php echo esc_html($option['name']); ?></option>
         <?php endforeach; ?>
      </select>
      <div class="form-text">Select multiple operational notes that apply to this class.</div>
      <div class="invalid-feedback">Please select at least one note.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>
</div>

<!-- QA Visit Dates and Reports Section -->
<div class="mt-4">
   <h6 class="mb-3">QA Visit Dates & Reports</h6>
   <p class="text-muted small mb-3">Add QA visit dates and upload corresponding reports for each visit.</p>

   <!-- Container for all QA visit date rows -->
   <div id="qa-visits-container"></div>

   <!-- Hidden Template Row (initially d-none) -->
   <div class="row qa-visit-row d-none" id="qa-visit-row-template">
      <!-- Visit Date -->
      <div class="col-md-4 mb-2">
         <label class="form-label">Visit Date</label>
         <input type="date" name="qa_visit_dates[]" class="form-control form-control-sm">
         <div class="invalid-feedback">Please select a valid date.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

      <!-- Report Upload -->
      <div class="col-md-6 mb-2">
         <label class="form-label">QA Report</label>
         <input type="file" name="qa_reports[]" class="form-control form-control-sm" accept="application/pdf">
         <div class="invalid-feedback">Please upload a report for this visit.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

      <!-- Remove Button -->
      <div class="col-md-2 mb-2">
         <label class="form-label invisible">&nbsp;</label>
         <button type="button" class="btn btn-outline-danger btn-sm remove-qa-visit-btn form-control date-remove-btn">Remove</button>
      </div>
   </div>

   <!-- Add Row Button -->
   <button type="button" class="btn btn-outline-primary btn-sm" id="add-qa-visit-btn">
   + Add QA Visit Date
   </button>
</div>
