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
   <div class="col-md-4 mb-3">
      <div class="form-floating">
         <select id="class_type" name="class_type" class="form-select" required>
            <option value="">Select</option>
            <?php foreach ($data['class_types'] as $class_type): ?>
               <option value="<?php echo esc_attr($class_type['id']); ?>"><?php echo esc_html($class_type['name']); ?></option>
            <?php endforeach; ?>
         </select>
         <label for="class_type">Class Type <span class="text-danger">*</span></label>
         <div class="invalid-feedback">Please select the class type.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <!-- Class Subject (Specific Subject/Level/Module) -->
   <div class="col-md-4 mb-3">
      <div class="form-floating">
         <select id="class_subject" name="class_subject" class="form-select" required disabled>
            <option value="">Select Class Type First</option>
         </select>
         <label for="class_subject">Class Subject <span class="text-danger">*</span></label>
         <div class="invalid-feedback">Please select the class subject.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <!-- Class Duration (Auto-calculated) -->
   <div class="col-md-4 mb-3">
      <div class="form-floating">
         <input type="number" id="class_duration" name="class_duration" class="form-control" placeholder="Duration" readonly>
         <label for="class_duration">Duration (Hours)</label>
         <div class="form-text">Automatically calculated based on class type and subject.</div>
      </div>
   </div>
</div>

<div class="row">
   <!-- Class Code (Auto-generated) -->
   <div class="col-md-4 mb-3">
      <div class="form-floating">
         <input type="text" id="class_code" name="class_code" class="form-control" placeholder="Class Code" readonly>
         <label for="class_code">Class Code</label>
         <div class="form-text">Automatically generated based on selections.</div>
      </div>
   </div>

   <!-- Class Original Start Date -->
   <div class="col-md-4 mb-3">
      <div class="form-floating">
         <input type="date" id="class_start_date" name="class_start_date" class="form-control" placeholder="YYYY-MM-DD" required>
         <label for="class_start_date">Class Original Start Date <span class="text-danger">*</span></label>
         <div class="invalid-feedback">Please select the start date.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>
</div>
