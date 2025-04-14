<?php
/**
 * Basic Details Partial View
 *
 * This partial view renders the basic details section of the class capture form,
 * including client selection and site selection fields.
 *
 * @var array $data View data passed from ClassController
 */
?>
<!-- ===== Section: Basic Details ===== -->
<div class="row">
   <!-- Client Name (ID) -->
   <div class="col-md-3">
      <label for="client_id" class="form-label">Client Name (ID) <span class="text-danger">*</span></label>
      <select id="client_id" name="client_id" class="form-select form-select-sm" required>
         <option value="">Select</option>
         <?php foreach ($data['clients'] as $client): ?>
            <option value="<?php echo esc_attr($client['id']); ?>"><?php echo esc_html($client['name']); ?></option>
         <?php endforeach; ?>
      </select>
      <div class="invalid-feedback">Please select a client.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>

   <!-- Class/Site Name -->
   <div class="col-md-3">
      <label for="site_id" class="form-label">Class/Site Name <span class="text-danger">*</span></label>
      <select id="site_id" name="site_id" class="form-select form-select-sm" required>
         <option value="">Select Site</option>
         <?php foreach ($data['clients'] as $client): ?>
            <optgroup label="<?php echo esc_attr($client['name']); ?>">
               <?php if (isset($data['sites'][$client['id']])): ?>
                  <?php foreach ($data['sites'][$client['id']] as $site): ?>
                     <option value="<?php echo esc_attr($site['id']); ?>"><?php echo esc_html($site['name']); ?></option>
                  <?php endforeach; ?>
               <?php endif; ?>
            </optgroup>
         <?php endforeach; ?>
      </select>
      <div class="invalid-feedback">Please select a class/site name.</div>
      <div class="valid-feedback">Looks good!</div>
   </div>

   <!-- Single Address Field (initially hidden) -->
   <div class="col-md-6" id="address-wrapper" style="display:none;">
      <label for="site_address" class="form-label">Address</label>
      <input
         type="text"
         id="site_address"
         name="site_address"
         class="form-control form-control-sm"
         placeholder="Street, Suburb, Town, Postal Code"
         readonly
         />
   </div>
</div>
