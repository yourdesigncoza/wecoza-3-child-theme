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
   <div class="col-md-3 mb-3">
      <div class="form-floating">
         <select id="seta_funded" name="seta_funded" class="form-select" required>
            <option value="">Select</option>
            <?php foreach ($data['yes_no_options'] as $option): ?>
               <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
            <?php endforeach; ?>
         </select>
         <label for="seta_funded">SETA Funded? <span class="text-danger">*</span></label>
         <div class="invalid-feedback">Please select if the class is SETA funded.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <!-- SETA (conditionally displayed) -->
   <div class="col-md-3 mb-3" id="seta_container" style="display: none;">
      <div class="form-floating">
         <select id="seta_id" name="seta_id" class="form-select">
            <option value="">Select</option>
            <?php foreach ($data['setas'] as $seta): ?>
               <option value="<?php echo $seta['id']; ?>"><?php echo $seta['name']; ?></option>
            <?php endforeach; ?>
         </select>
         <label for="seta_id">SETA <span class="text-danger">*</span></label>
         <div class="invalid-feedback">Please select a SETA.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <!-- Exam Class -->
   <div class="col-md-3 mb-3">
      <div class="form-floating">
         <select id="exam_class" name="exam_class" class="form-select" required>
            <option value="">Select</option>
            <?php foreach ($data['yes_no_options'] as $option): ?>
               <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
            <?php endforeach; ?>
         </select>
         <label for="exam_class">Exam Class <span class="text-danger">*</span></label>
         <div class="invalid-feedback">Please select if this is an exam class.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <!-- Exam Type (conditionally displayed) -->
   <div class="col-md-3 mb-3">
      <div id="exam_type_container" style="display: none;">
         <div class="form-floating">
            <input type="text" id="exam_type" name="exam_type" class="form-control" placeholder="Enter exam type">
            <label for="exam_type">Exam Type</label>
            <div class="invalid-feedback">Please provide the exam type.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>
   </div>
</div>
