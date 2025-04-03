<?php
/**
 * Shortcode to capture and edit agent information with Bootstrap (needs-validation) style.
 * Includes server-side validation and example client-side markup for valid/invalid feedback.
 */

function agents_capture_shortcode($atts) {
    // global $wpdb;
    $agent_id='';
    $locations='';

    // Initialize variables for form errors and data
    $form_error = false;
    $error_messages = [];
    $data = [];

    // Fetch locations and employers for dropdowns outside the form submission block
    $db = new learner_DB();
    // Below calls are now called via Ajax
    // $locations = $db->get_locations();
    // $qualifications = $db->get_qualifications();
    // $employers = $db->get_employers();
    // $placement_levels = $db->get_placement_level();

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wecoza_agents_form_nonce']) && wp_verify_nonce($_POST['wecoza_agents_form_nonce'], 'submit_learners_form')) {

        // /*------------------YDCOZA-----------------------*/
        // /* Handle file upload                            */
        // /* This block handles the uploaded scanned       */
        // /* portfolio, ensuring only PDF files are allowed*/
        // /*-----------------------------------------------*/
        // // Initialize variables
        // $scanned_portfolio_path = ''; // Initialize this before the data array
        // $form_error = false;
        // $error_messages = [];

        /*------------------YDCOZA-----------------------*/
        /* Sanitize and prepare form inputs              */
        /* Ensures all input fields are properly         */
        /* sanitized before inserting them into the DB   */
        /*-----------------------------------------------*/
        // $scanned_portfolio_path = '';
        $data = [
            'first_name' => sanitize_text_field($_POST['first_name']),
            'initials' => sanitize_text_field($_POST['initials']),
            'surname' => sanitize_text_field($_POST['surname']),
            'gender' => sanitize_text_field($_POST['gender']),
            'race' => sanitize_text_field($_POST['race']),
            'sa_id_no' => sanitize_text_field($_POST['sa_id_no']),
            'passport_number' => sanitize_text_field($_POST['passport_number']),
            'tel_number' => sanitize_text_field($_POST['tel_number']),
            'alternative_tel_number' => sanitize_text_field($_POST['alternative_tel_number']),
            'email_address' => sanitize_email($_POST['email_address']),
            'address_line_1' => sanitize_text_field($_POST['address_line_1']),
            'address_line_2' => sanitize_text_field($_POST['address_line_2']),
            'city_town_id' => intval($_POST['city_town_id']),
            'province_region_id' => intval($_POST['province_region_id']),
            'postal_code' => sanitize_text_field($_POST['postal_code']),
            'highest_qualification' => sanitize_text_field($_POST['highest_qualification']),
            'assessment_status' => sanitize_text_field($_POST['assessment_status']),
            'placement_assessment_date' => sanitize_text_field($_POST['placement_assessment_date']),
            'numeracy_level' => intval($_POST['numeracy_level']), 
            'communication_level' => intval($_POST['communication_level']),
            'employment_status' => isset($_POST['employment_status']) && $_POST['employment_status'] !== '' ? (int) filter_var($_POST['employment_status'], FILTER_VALIDATE_BOOLEAN) : 0,
            'employer_id' => intval($_POST['employer_id']),
            'disability_status' => isset($_POST['disability_status']) && $_POST['disability_status'] !== '' ? (int) filter_var($_POST['disability_status'], FILTER_VALIDATE_BOOLEAN) : 0,
            'scanned_portfolio' => $scanned_portfolio_path,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];


        /*------------------YDCOZA-----------------------*/
        /* Validate SA ID or Passport                    */
        /* Ensure that either SA ID or Passport is       */
        /* provided. If both are missing, show error.    */
        /*-----------------------------------------------*/

        if (empty($_POST['sa_id_no']) && empty($_POST['passport_number'])) {
            $form_error = true;
            $error_messages[] = 'You must provide either SA ID Number or Passport Number.';
        }

        // Proceed only if there are no errors
        // In learners-capture-shortcode.php, replace the form submission handling section:

        if (!$form_error) {
            // Ensure date fields are valid
            $data['placement_assessment_date'] = !empty($data['placement_assessment_date']) ? $data['placement_assessment_date'] : null;

            // Initialize scanned_portfolio as empty string
            $data['scanned_portfolio'] = '';

            // Validate employer_id and numeracy_level
            $data['employer_id'] = !empty($data['employer_id']) ? $data['employer_id'] : null;
            $data['numeracy_level'] = !empty($data['numeracy_level']) ? $data['numeracy_level'] : null;
            $data['communication_level'] = !empty($data['communication_level']) ? $data['communication_level'] : null;

            // Insert learner using learner_DB class and get learner ID
            // $learner_id = $db->insert_learner($data);
            
            if ($learner_id) {
                echo '<div class="alert alert-success alert-dismissible fade show ydcoza-notification ydcoza-auto-close" role="alert"><div class="d-flex gap-4"><span><i class="fa-solid fa-circle-check icon-success"></i></span><div>Learner Added successfully!</div></div><button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                
                // Handle file uploads if files were submitted
                if (isset($_FILES['scanned_portfolio']) && !empty($_FILES['scanned_portfolio']['name'][0])) {
                    $upload_result = $db->saveLearnerPortfolios($learner_id, $_FILES['scanned_portfolio']);
                if ($upload_result['success']) {
                    // Verify the update
                    $current_value = $db->verifyPortfolioUpdate($learner_id);
                    error_log("Verification result: " . ($current_value ?: 'NULL'));
                } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show ydcoza-notification" role="alert"><button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button><div class="d-flex gap-4"><span><i class="fa-solid fa-circle-exclamation icon-danger"></i></span><div class="d-flex flex-column gap-2"><h6 class="mb-0">ERROR !</h6><p class="mb-0">Some files could not be uploaded: ' . $upload_result['message'] . '</p></div></div></div>';
                    }
                }
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show ydcoza-notification" role="alert"><button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button><div class="d-flex gap-4"><span><i class="fa-solid fa-circle-exclamation icon-danger"></i></span><div class="d-flex flex-column gap-2"><h6 class="mb-0">ERROR !</h6><p class="mb-0">There was an error inserting the learner. Please try again.</p></div></div></div>';
            }
        } else {
            // Display all error messages
            foreach ($error_messages as $message) {
                echo '<p class="text-danger">' . esc_html($message) . '</p>';
            }
        }


    }

    // Build the form
    ob_start(); 
    ?>
    <!--
      Example of combining the row/col approach from your snippet.
      Add or remove columns as fits your layout.
      Note: The 'needs-validation' class and the HTML5 'required' attributes
      support client-side validation, but the final authority is our server-side checks above.
    -->

<form id="agents-form" class="needs-validation ydcoza-compact-form" novalidate method="POST" enctype="multipart/form-data">
   <?php wp_nonce_field('submit_learners_form', 'wecoza_agents_form_nonce'); ?>
   <?php wp_nonce_field('save_agent_data', 'agent_form_nonce'); ?>

   <!-- Agent ID (read-only if editing) -->
   <?php if ($agent_id) : ?>
   <div class="col-md-3">
      <label for="id" class="form-label">Agent ID</label>
      <input type="text" id="id" name="id" class="form-control form-control-sm" value="<?php echo esc_attr($agent_id); ?>" readonly>
      <div class="valid-feedback">Looks good!</div>
   </div>
   <?php endif; ?>

   <div class="row">
      <!-- First Name -->
      <div class="col-md-3">
         <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
         <input type="text" id="first_name" name="first_name" class="form-control form-control-sm" value="<?php echo esc_attr($agent['first_name'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the first name.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Initials -->
      <div class="col-md-2">
         <label for="initials" class="form-label">Initials <span class="text-danger">*</span></label>
         <input type="text" id="initials" name="initials" class="form-control form-control-sm" value="<?php echo esc_attr($agent['initials'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide your initials.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Surname -->
      <div class="col-md-3">
         <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
         <input type="text" id="surname" name="surname" class="form-control form-control-sm" value="<?php echo esc_attr($agent['surname'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the surname.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Gender -->
      <div class="col-md-2">
         <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
         <select id="gender" name="gender" class="form-select form-select-sm" required>
            <option value="">Select</option>
            <option value="M" <?php selected($agent['gender'] ?? '', 'M'); ?>>Male</option>
            <option value="F" <?php selected($agent['gender'] ?? '', 'F'); ?>>Female</option>
         </select>
         <div class="invalid-feedback">Please select your gender.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Race -->
      <div class="col-md-2">
         <label for="race" class="form-label">Race <span class="text-danger">*</span></label>
         <select id="race" name="race" class="form-select form-select-sm" required>
            <option value="">Select</option>
            <option value="African" <?php selected($agent['race'] ?? '', 'African'); ?>>African</option>
            <option value="Coloured" <?php selected($agent['race'] ?? '', 'Coloured'); ?>>Coloured</option>
            <option value="White" <?php selected($agent['race'] ?? '', 'White'); ?>>White</option>
            <option value="Indian" <?php selected($agent['race'] ?? '', 'Indian'); ?>>Indian</option>
         </select>
         <div class="invalid-feedback">Please select your race.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>
   
   <div class="row">
      <div class="col-md-3">
         <!-- Radio buttons for ID or Passport selection -->
         <div class="mb-1">
            <label class="form-label">Identification Type <span class="text-danger">*</span></label>
            <div class="row">
               <div class="col">
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="id_type" id="sa_id_option" value="sa_id" required>
                     <label class="form-check-label" for="sa_id_option">SA ID</label>
                  </div>
               </div>
               <div class="col">
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="id_type" id="passport_option" value="passport" required>
                     <label class="form-check-label" for="passport_option">Passport</label>
                  </div>
               </div>
            </div>
            <div class="invalid-feedback">Please select an identification type.</div>
         </div>
      </div>
      <div class="col-md-3">
         <!-- SA ID Number (Initially Hidden) -->
         <div id="sa_id_field" class="mb-3 d-none">
            <label for="sa_id_no" class="form-label">SA ID Number <span class="text-danger">*</span></label>
            <input type="text" id="sa_id_no" name="sa_id_no" class="form-control form-control-sm" maxlength="13" required>
            <div class="invalid-feedback">Please provide a valid SA ID number.</div>
            <div class="valid-feedback">Valid ID number!</div>
         </div>
         <!-- Passport Number (Initially Hidden) -->
         <div id="passport_field" class="mb-3 d-none">
            <label for="passport_number" class="form-label">Passport Number <span class="text-danger">*</span></label>
            <input type="text" id="passport_number" name="passport_number" class="form-control form-control-sm" maxlength="12" required>
            <div class="invalid-feedback">Please provide a valid passport number.</div>
            <div class="valid-feedback">Valid passport number!</div>
         </div>
      </div>
      <!-- Telephone Number -->
      <div class="col-md-3">
         <label for="tel_number" class="form-label">Telephone Number <span class="text-danger">*</span></label>
         <input type="text" id="tel_number" name="tel_number" class="form-control form-control-sm" value="<?php echo esc_attr($agent['tel_number'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide a telephone number.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Email -->
      <div class="col-md-3">
         <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
         <input type="email" id="email" name="email" class="form-control form-control-sm" value="<?php echo esc_attr($agent['email'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide a valid email address.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

   <div class="row">
      <div class="col-md-6">
         <!-- Address Line 1 -->
         <div class="mb-1">
            <label for="address_line_1" class="form-label">Address Line 1 <span class="text-danger">*</span></label>
            <input type="text" id="address_line_1" name="address_line_1" class="form-control form-control-sm" required>
            <div class="invalid-feedback">Please provide Address Line 1.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>
      <div class="col-md-6">
         <!-- Address Line 2 (Not Required) -->
         <div class="mb-1">
            <label for="address_line_2" class="form-label">Address Line 2</label>
            <input type="text" id="address_line_2" name="address_line_2" class="form-control form-control-sm">
            <!-- No invalid-feedback since this field is optional -->
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-4">
         <!-- City/Town -->
         <div class="mb-1">
            <label for="city_town_id" class="form-label">City/Town <span class="text-danger">*</span></label>
            <select id="city_town_id" name="city_town_id" class="form-select form-select-sm" required=""><option value="">Select</option><option value="9">Bloemfontein</option><option value="2">Cape Town</option><option value="3">Durban</option><option value="15">East London</option><option value="10">Gqeberha</option><option value="1">Johannesburg</option><option value="7">Kimberley</option><option value="8">Mbombela</option><option value="13">Paarl</option><option value="14">Pietermaritzburg</option><option value="6">Polokwane</option><option value="4">Pretoria</option><option value="5">Stellenbosch</option></select>
            <div class="invalid-feedback">Please select a city or town.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>
      <div class="col-md-4">
         <!-- Province/Region -->
         <div class="mb-1">
            <label for="province_region_id" class="form-label">Province/Region <span class="text-danger">*</span></label>
            <select id="province_region_id" name="province_region_id" class="form-select form-select-sm" required=""><option value="">Select</option><option value="10">Eastern Cape</option><option value="9">Free State</option><option value="1">Gauteng</option><option value="3">KwaZulu-Natal</option><option value="6">Limpopo</option><option value="8">Mpumalanga</option><option value="7">Northern Cape</option><option value="2">Western Cape</option></select>
            <div class="invalid-feedback">Please select a province or region.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>
      <div class="col-md-4">
         <!-- Postal Code -->
         <div class="mb-1">
            <label for="postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
            <input type="text" id="postal_code" name="postal_code" class="form-control form-control-sm" required>
            <div class="invalid-feedback">Please provide a postal code.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>
   </div>

   <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

   <div class="row">
      <!-- Preferred Working Area 1 -->
      <div class="col-md-4">
         <label for="preferred_working_area_1" class="form-label">Preferred Working Area 1 <span class="text-danger">*</span></label>
            <select id="preferred_working_area_1" name="preferred_working_area_1" class="form-select form-select-sm" data-placeholder="Select Location" required>
               <option value="">Select</option>
               <option value="1">Sandton, Johannesburg, Gauteng, 2196</option>
               <option value="2">Durbanville, Cape Town, Western Cape, 7551</option>
               <option value="3">Durban, Durban, KwaZulu-Natal, 4320</option>
               <option value="4">Hatfield, Pretoria, Gauteng, 0028</option>
               <option value="5">Stellenbosch, Stellenbosch, Western Cape, 7600</option>
               <option value="6">Polokwane, Polokwane, Limpopo, 0699</option>
               <option value="7">Kimberley, Kimberley, Northern Cape, 8301</option>
               <option value="8">Nelspruit, Mbombela, Mpumalanga, 1200</option>
               <option value="9">Bloemfontein, Bloemfontein, Free State, 9300</option>
               <option value="10">Port Elizabeth, Gqeberha, Eastern Cape, 6001</option>
               <option value="11">Soweto, Johannesburg, Gauteng, 1804</option>
               <option value="12">Paarl, Paarl, Western Cape, 7620</option>
               <option value="13">Pietermaritzburg, Pietermaritzburg, KwaZulu-Natal, 3201</option>
               <option value="14">East London, East London, Eastern Cape, 5201</option>
            </select>
         <div class="invalid-feedback">Please select a preferred working area.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Preferred Working Area 2 -->
      <div class="col-md-4">
         <label for="preferred_working_area_2" class="form-label">Preferred Working Area 2 <span class="text-danger">*</span></label>
            <select id="preferred_working_area_2" name="preferred_working_area_2" class="form-select form-select-sm" data-placeholder="Select Location" required>
               <option value="">Select</option>
               <option value="1">Sandton, Johannesburg, Gauteng, 2196</option>
               <option value="2">Durbanville, Cape Town, Western Cape, 7551</option>
               <option value="3">Durban, Durban, KwaZulu-Natal, 4320</option>
               <option value="4">Hatfield, Pretoria, Gauteng, 0028</option>
               <option value="5">Stellenbosch, Stellenbosch, Western Cape, 7600</option>
               <option value="6">Polokwane, Polokwane, Limpopo, 0699</option>
               <option value="7">Kimberley, Kimberley, Northern Cape, 8301</option>
               <option value="8">Nelspruit, Mbombela, Mpumalanga, 1200</option>
               <option value="9">Bloemfontein, Bloemfontein, Free State, 9300</option>
               <option value="10">Port Elizabeth, Gqeberha, Eastern Cape, 6001</option>
               <option value="11">Soweto, Johannesburg, Gauteng, 1804</option>
               <option value="12">Paarl, Paarl, Western Cape, 7620</option>
               <option value="13">Pietermaritzburg, Pietermaritzburg, KwaZulu-Natal, 3201</option>
               <option value="14">East London, East London, Eastern Cape, 5201</option>
            </select>
         <div class="invalid-feedback">Please select a second preferred working area.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Preferred Working Area 3 -->
      <div class="col-md-4">
         <label for="preferred_working_area_3" class="form-label">Preferred Working Area 3 <span class="text-danger">*</span></label>
            <select id="preferred_working_area_3" name="preferred_working_area_3" class="form-select form-select-sm" data-placeholder="Select Location" required>
               <option value="">Select</option>
               <option value="1">Sandton, Johannesburg, Gauteng, 2196</option>
               <option value="2">Durbanville, Cape Town, Western Cape, 7551</option>
               <option value="3">Durban, Durban, KwaZulu-Natal, 4320</option>
               <option value="4">Hatfield, Pretoria, Gauteng, 0028</option>
               <option value="5">Stellenbosch, Stellenbosch, Western Cape, 7600</option>
               <option value="6">Polokwane, Polokwane, Limpopo, 0699</option>
               <option value="7">Kimberley, Kimberley, Northern Cape, 8301</option>
               <option value="8">Nelspruit, Mbombela, Mpumalanga, 1200</option>
               <option value="9">Bloemfontein, Bloemfontein, Free State, 9300</option>
               <option value="10">Port Elizabeth, Gqeberha, Eastern Cape, 6001</option>
               <option value="11">Soweto, Johannesburg, Gauteng, 1804</option>
               <option value="12">Paarl, Paarl, Western Cape, 7620</option>
               <option value="13">Pietermaritzburg, Pietermaritzburg, KwaZulu-Natal, 3201</option>
               <option value="14">East London, East London, Eastern Cape, 5201</option>
            </select>
         <div class="invalid-feedback">Please select a third preferred working area.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>

   </div>

   <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

   <div class="row">
      <!-- SACE Registration Number -->
      <div class="col-md-3">
         <label for="sace_registration_number" class="form-label">SACE Registration Number <span class="text-danger">*</span></label>
         <input type="text" id="sace_registration_number" name="sace_registration_number" class="form-control form-control-sm" value="<?php echo esc_attr($agent['sace_registration_number'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the SACE registration number.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- SACE Registration Date -->
      <div class="col-md-3">
         <label for="sace_registration_date" class="form-label">SACE Registration Date <span class="text-danger">*</span></label>
         <input type="date" id="sace_registration_date" name="sace_registration_date" class="form-control form-control-sm" value="<?php echo esc_attr($agent['sace_registration_date'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the SACE registration date.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- SACE Expiry Date -->
      <div class="col-md-3">
         <label for="sace_expiry_date" class="form-label">SACE Expiry Date <span class="text-danger">*</span></label>
         <input type="date" id="sace_expiry_date" name="sace_expiry_date" class="form-control form-control-sm" value="<?php echo esc_attr($agent['sace_expiry_date'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the SACE expiry date.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Date Loaded -->
<!--       <div class="col-md-3">
         <label for="date_loaded" class="form-label">Date Loaded <span class="text-danger">*</span></label>
         <input type="date" id="date_loaded" name="date_loaded" class="form-control form-control-sm" value="<?php echo esc_attr($agent['date_loaded'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the date loaded.</div>
         <div class="valid-feedback">Looks good!</div>
      </div> -->
   </div>

   <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

   <div class="row">
      <!-- Quantum (Communications) -->
      <div class="col-md-3">
         <label for="quantum_communications" class="form-label">Quantum Result (Communications) <span class="text-danger">*</span></label>
         <input type="number" id="quantum_communications" step="0.01" name="quantum_communications" class="form-control form-control-sm" value="<?php echo esc_attr($agent['quantum_communications'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the quantum result for Communications.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Quantum (Mathematics) -->
      <div class="col-md-3">
         <label for="quantum_mathematics" class="form-label">Quantum Result (Mathematics) <span class="text-danger">*</span></label>
         <input type="number" id="quantum_mathematics" step="0.01" name="quantum_mathematics" class="form-control form-control-sm" value="<?php echo esc_attr($agent['quantum_mathematics'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the quantum result for Mathematics.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Quantum (Training) -->
      <div class="col-md-3">
         <label for="quantum_training" class="form-label">Quantum Result (Training) <span class="text-danger">*</span></label>
         <input type="number" id="quantum_training" step="0.01" name="quantum_training" class="form-control form-control-sm" value="<?php echo esc_attr($agent['quantum_training'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the quantum result for Training.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Agent Training Date -->
      <div class="col-md-3">
         <label for="agent_training_date" class="form-label">Agent Training Date <span class="text-danger">*</span></label>
         <input type="date" id="agent_training_date" name="agent_training_date" class="form-control form-control-sm" value="<?php echo esc_attr($agent['agent_training_date'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the agent training date.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

   <div class="row">
      <!-- Bank Name -->
      <div class="col-md-3">
         <label for="bank_name" class="form-label">Bank Name <span class="text-danger">*</span></label>
         <input type="text" id="bank_name" name="bank_name" class="form-control form-control-sm" value="<?php echo esc_attr($agent['bank_name'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the bank name.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Bank Branch Code -->
      <div class="col-md-3">
         <label for="bank_branch_code" class="form-label">Bank Branch Code <span class="text-danger">*</span></label>
         <input type="text" id="bank_branch_code" name="bank_branch_code" class="form-control form-control-sm" value="<?php echo esc_attr($agent['bank_branch_code'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the bank branch code.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Bank Account Number -->
      <div class="col-md-3">
         <label for="bank_account_number" class="form-label">Bank Account Number <span class="text-danger">*</span></label>
         <input type="text" id="bank_account_number" name="bank_account_number" class="form-control form-control-sm" value="<?php echo esc_attr($agent['bank_account_number'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the bank account number.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

   <div class="row">
      <!-- Highest Qualification -->
      <div class="col-md-3">
         <label for="highest_qualification" class="form-label">Highest Qualification <span class="text-danger">*</span></label>
         <input type="text" id="highest_qualification" name="highest_qualification" class="form-control form-control-sm" value="<?php echo esc_attr($agent['highest_qualification'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide your highest qualification.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Signed Agreement (checkbox) -->
      <div class="col-md-3">
         <div class="form-check">
            <input class="form-check-input form-check-input-sm" type="checkbox" id="signed_agreement" name="signed_agreement" value="Y" <?php checked($agent['signed_agreement'] ?? '', 'Y'); ?> required>
            <label class="form-check-label" for="signed_agreement">
               Signed Agreement
            </label>
            <div class="invalid-feedback">Please confirm the signed agreement.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>
      <!-- Signed Agreement Date -->
      <div class="col-md-3 d-none">
         <label for="signed_agreement_date" class="form-label">Signed Agreement Date <span class="text-danger">*</span></label>
         <input type="date" id="signed_agreement_date" name="signed_agreement_date" class="form-control form-control-sm" value="<?php echo esc_attr($agent['signed_agreement_date'] ?? ''); ?>" required>
         <div class="invalid-feedback">Please provide the signed agreement date.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
      <!-- Signed Agreement File -->
      <div class="col-md-3 d-none">
         <label for="signed_agreement_file" class="form-label">Upload Signed Agreement <span class="text-danger">*</span></label>
         <input type="file" id="signed_agreement_file" name="signed_agreement_file" class="form-control form-control-sm" required>
         <?php if (!empty($agent['signed_agreement_file'])): ?>
         <p class="mt-1">
            Current file:
            <a href="<?php echo esc_url($agent['signed_agreement_file']); ?>" target="_blank">View</a>
         </p>
         <?php endif; ?>
         <div class="invalid-feedback">Please upload the signed agreement file.</div>
         <div class="valid-feedback">Looks good!</div>
      </div>
   </div>

   <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>
   <!-- Submit -->
   <div class="col-md-3">
      <button type="submit" class="btn btn-primary mt-3">Add New Agent</button>
   </div>
</form>




    <?php
    return ob_get_clean();
}

add_shortcode('wecoza_capture_agents', 'agents_capture_shortcode');
