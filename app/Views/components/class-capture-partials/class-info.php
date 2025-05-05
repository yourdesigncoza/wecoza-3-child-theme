<?php
/**
 * Class Info Partial View
 *
 * This partial view renders the class information section of the class capture form,
 * including class type, start date, and subjects.
 *
 * @var array $data View data passed from ClassController
 */
?>
<!-- ===== Section: Scheduling & Class Info ===== -->
<div class="row mt-3">
   <!-- Class Type (Main Category) -->
   <div class="col-md-4">
      <label for="class_type" class="form-label">Class Type <span class="text-danger">*</span></label>
      <select id="class_type" name="class_type" class="form-select form-select-sm" required>
         <option value="">Select</option>
         <?php foreach ($data['class_types'] as $class_type): ?>
            <option value="<?php echo esc_attr($class_type['id']); ?>"><?php echo esc_html($class_type['name']); ?></option>
         <?php endforeach; ?>
      </select>
      <div class="invalid-feedback">Please select the class type.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>

   <!-- Class Subject (Specific Subject/Level/Module) -->
   <div class="col-md-4">
      <label for="class_subject" class="form-label">Class Subject <span class="text-danger">*</span></label>
      <select id="class_subject" name="class_subject" class="form-select form-select-sm" required disabled>
         <option value="">Select Class Type First</option>
      </select>
      <div class="invalid-feedback">Please select the class subject.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>

   <!-- Class Duration (Auto-calculated) -->
   <div class="col-md-4">
      <label for="class_duration" class="form-label">Duration (Hours)</label>
      <input type="number" id="class_duration" name="class_duration" class="form-control form-control-sm" readonly>
      <div class="form-text">Automatically calculated based on class type and subject.</div>
   </div>
</div>

<div class="row mt-3">
   <!-- Class Code (Auto-generated) -->
   <div class="col-md-4">
      <label for="class_code" class="form-label">Class Code</label>
      <input type="text" id="class_code" name="class_code" class="form-control form-control-sm" readonly>
      <div class="form-text">Automatically generated based on selections.</div>
   </div>

   <!-- Class Original Start Date -->
   <div class="col-md-4">
      <label for="class_start_date" class="form-label">Class Original Start Date <span class="text-danger">*</span></label>
      <input type="date" id="class_start_date" name="class_start_date" class="form-control form-control-sm" required>
      <div class="invalid-feedback">Please select the start date.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>


</div>
