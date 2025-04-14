<?php
/**
 * Funding & Exam Details Partial View
 *
 * This partial view renders the funding and exam details section of the class capture form,
 * including SETA funding and exam information.
 *
 * @var array $data View data passed from ClassController
 */
?>
<!-- ===== Section: Funding & Exam Details ===== -->
<?php echo section_header('Funding & Exam Details'); ?>
<div class="row">
   <!-- SETA Funded -->
   <div class="col-md-3">
      <label for="seta_funded" class="form-label">SETA Funded? <span class="text-danger">*</span></label>
      <?php echo select_dropdown('seta_funded', $data['yes_no_options'], [
         'id' => 'seta_funded',
         'required' => true
      ], '', 'Select'); ?>
      <div class="invalid-feedback">Please select if the class is SETA funded.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>

   <!-- SETA (conditionally displayed) -->
   <div class="col-md-3" id="seta_container" style="display: none;">
      <label for="seta_id" class="form-label">SETA <span class="text-danger">*</span></label>
      <?php echo select_dropdown('seta_id', $data['setas'], [
         'id' => 'seta_id'
      ], '', 'Select'); ?>
      <div class="invalid-feedback">Please select a SETA.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>

   <!-- Exam Class -->
   <div class="col-md-3">
      <label for="exam_class" class="form-label">Exam Class <span class="text-danger">*</span></label>
      <?php echo select_dropdown('exam_class', $data['yes_no_options'], [
         'id' => 'exam_class',
         'required' => true
      ], '', 'Select'); ?>
      <div class="invalid-feedback">Please select if this is an exam class.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>

   <!-- Exam Type (conditionally displayed) -->
   <div class="col-md-3">
      <div id="exam_type_container" style="display: none;">
         <?php echo form_input('text', 'exam_type', 'Exam Type', [
            'id' => 'exam_type',
            'placeholder' => 'Enter exam type'
         ], '', false, 'Please provide the exam type.', 'Looks good!'); ?>
      </div>
   </div>
</div>
