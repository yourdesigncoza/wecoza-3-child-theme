<?php

/**
 * Class Capture Form View
 *
 * This view file renders a comprehensive form for creating and managing training classes in the WeCoza system.
 * It follows the MVC architecture pattern where this file (View) is responsible only for presentation,
 * while the ClassController handles the business logic and data processing.
 *
 * The form includes multiple sections:
 * - Basic Details: Client and site selection
 * - Class Schedule Calendar: Visual calendar for scheduling class sessions
 * - Class Info: Type, start date, subjects
 * - Date History: Managing stop/restart dates for classes
 * - Funding & Exam Details: SETA funding and exam information
 * - Exam Learners: Selection of learners taking exams (conditionally displayed)
 * - Class Notes & QA: Quality assurance information
 * - Assignments & Dates: Staff assignments and important dates
 *
 * This form uses various view helpers (from app/Helpers/ViewHelpers.php) to generate consistent UI elements:
 * - select_dropdown(): For dropdown menus
 * - form_input(): For input fields
 * - form_textarea(): For textarea fields
 * - form_row(): For complex form rows
 * - section_divider(): For visual section separators
 * - section_header(): For section titles
 * - button(): For form buttons
 *
 * The form includes client-side validation using Bootstrap's validation classes and custom JavaScript.
 * Server-side validation is handled by the ClassController and ValidationService.
 *
 * JavaScript functionality is provided by class-capture.js and class-calendar-init.js, which handle:
 * - Calendar initialization and event management
 * - Dynamic form field behavior (conditional fields, multi-select)
 * - Form submission via AJAX
 * - Validation feedback
 *
 * @var array $data View data passed from ClassController containing:
 *   - clients: Array of client data with 'id' and 'name' keys
 *   - sites: Associative array of sites grouped by client ID
 *   - agents: Array of agent data with 'id' and 'name' keys
 *   - supervisors: Array of supervisor data with 'id' and 'name' keys
 *   - learners: Array of learner data with 'id' and 'name' keys
 *   - setas: Array of SETA data with 'id' and 'name' keys
 *   - products: Array of product/course data with 'id', 'name', and 'learning_area' keys
 *   - class_types: Array of class type data with 'id' and 'name' keys
 *   - yes_no_options: Array of Yes/No options with 'id' and 'name' keys
 *   - redirect_url: URL to redirect to after successful form submission
 *
 * @see \WeCoza\Controllers\ClassController::captureClassShortcode() For the controller method that renders this view
 * @see \WeCoza\Models\Assessment\ClassModel For the data model that stores class information
 * @see \WeCoza\Services\Validation\ValidationService For the validation service used to validate form data
 */
?>
<!-- Classes Capture Form -->
<form id="classes-form" class="needs-validation ydcoza-compact-form" novalidate method="POST" enctype="multipart/form-data">
   <!-- Hidden Auto-generated Class ID -->
   <input type="hidden" id="class_id" name="class_id" value="auto-generated">
   <input type="hidden" id="redirect_url" name="redirect_url" value="<?php echo esc_attr($data['redirect_url'] ?? ''); ?>">
   <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('wecoza_class_nonce'); ?>">

   <!-- ===== Section: Basic Details ===== -->
   <div class="container container-md classes-form">
      <?php include_once('class-capture-partials/basic-details.php'); ?>

      <?php echo section_divider(); ?>

      <!-- ===== Section: Scheduling & Class Info ===== -->
      <?php include_once('class-capture-partials/class-info.php'); ?>

      <!-- Class Schedule Form Section -->
      <?php include_once('class-capture-partials/class-schedule-form.php'); ?>

      <!-- Class Date History Section -->
      <?php include_once('class-capture-partials/date-history.php'); ?>

      <!-- Calendar Reference View (hidden by default) -->
      <?php include_once('class-capture-partials/class-schedule-calendar.php'); ?>

      <?php echo section_divider(); ?>

      <!-- ===== Section: Funding & Exam Details ===== -->
      <?php include_once('class-capture-partials/funding-exam-details.php'); ?>

      <!-- Class Learners Section -->
      <?php echo section_divider(); ?>
      <?php include_once('class-capture-partials/class-learners.php'); ?>

      <!-- Exam Learners (conditionally displayed) -->
      <?php include_once('class-capture-partials/exam-learners.php'); ?>

      <?php echo section_divider(); ?>
      <?php include_once('class-capture-partials/class-notes-qa.php'); ?>

      <?php echo section_divider(); ?>

      <!-- ===== Section: Assignments & Dates ===== -->
      <?php include_once('class-capture-partials/assignments-dates.php'); ?>

      <?php echo section_divider(); ?>
      <!-- Submit Button -->
      <div class="row mt-4">
         <div class="col-md-3">
            <?php echo button('Add New Class', 'submit', 'primary'); ?>
         </div>
      </div>
   </div>
</form>

<!-- Alert container for form messages -->
<div id="form-messages" class="mt-3"></div>
