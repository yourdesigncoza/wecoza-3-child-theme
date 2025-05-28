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
<?php if (isset($data['mode']) && $data['mode'] === 'update'): ?>
   <!-- UPDATE MODE: Display existing client/site info (read-only) -->
   <div class="row">
      <div class="col-md-12 mb-3">
         <div class="alert alert-info">
            <h6 class="mb-2">Class Information</h6>
            <p class="mb-1"><strong>Client:</strong> <?php echo isset($data['class_data']) && $data['class_data'] ? esc_html($data['class_data']->client_name ?? 'Not specified') : 'Loading...'; ?></p>
            <p class="mb-0"><strong>Site:</strong> <?php echo isset($data['class_data']) && $data['class_data'] ? esc_html($data['class_data']->site_name ?? 'Not specified') : 'Loading...'; ?></p>
         </div>
      </div>
   </div>
<?php else: ?>
   <!-- CREATE MODE: Full client/site selection -->
   <div class="row">
      <!-- Client Name (ID) -->
      <div class="col-md-3 mb-3">
         <div class="form-floating">
            <select id="client_id" name="client_id" class="form-select" required>
               <option value="">Select</option>
               <?php foreach ($data['clients'] as $client): ?>
                  <option value="<?php echo esc_attr($client['id']); ?>"><?php echo esc_html($client['name']); ?></option>
               <?php endforeach; ?>
            </select>
            <label for="client_id">Client Name (ID) <span class="text-danger">*</span></label>
            <div class="invalid-feedback">Please select a client.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <!-- Class/Site Name -->
      <div class="col-md-3 mb-3">
         <div class="form-floating">
            <select id="site_id" name="site_id" class="form-select" required>
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
            <label for="site_id">Class/Site Name <span class="text-danger">*</span></label>
            <div class="invalid-feedback">Please select a class/site name.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <!-- Single Address Field (initially hidden) -->
      <div class="col-md-6 mb-3" id="address-wrapper" style="display:none;">
         <div class="form-floating">
            <input
               type="text"
               id="site_address"
               name="site_address"
               class="form-control"
               placeholder="Street, Suburb, Town, Postal Code"
               readonly
               />
            <label for="site_address">Address</label>
         </div>
      </div>
   </div>
<?php endif; ?>
