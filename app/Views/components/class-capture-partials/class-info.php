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
   <!-- Class Type -->
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

   <!-- Class Original Start Date -->
   <div class="col-md-4">
      <label for="class_start_date" class="form-label">Class Original Start Date <span class="text-danger">*</span></label>
      <input type="date" id="class_start_date" name="class_start_date" class="form-control form-control-sm" required>
      <div class="invalid-feedback">Please select the start date.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>

   <!-- Class Subjects -->
   <div class="col-md-4">
      <label for="course_id" class="form-label">Class Subjects <span class="text-danger">*</span></label>
      <select id="course_id" name="course_id[]" class="form-select form-select-sm" required>
         <option value="">Select</option>
         <?php foreach ($data['products'] as $product): ?>
            <option value="<?php echo esc_attr($product['id']); ?>"><?php echo esc_html($product['name']); ?><?php echo !empty($product['learning_area']) ? ' - ' . esc_html($product['learning_area']) : ''; ?></option>
         <?php endforeach; ?>
      </select>
      <div class="invalid-feedback">Please select at least one subject.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>
</div>
