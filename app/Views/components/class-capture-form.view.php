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

      <?php echo section_divider(); ?>

      <!-- Day/Time Schedule Section -->
      <div class="mb-3">
         <h5 class="mb-3">Class Schedule Calendar</h5>
         <p class="text-muted small mb-3">Manage class schedules visually.</p>

         <!-- Calendar Container -->
         <div id="class-calendar" class="mb-3" data-calendar-init="true"></div>

         <!-- Event Form Modal -->
         <div class="modal" id="eventModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="eventModalLabel">Add/Edit Class Event</h5>
                     <button type="button" class="btn-close" id="closeModalBtn" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                     <form id="eventForm">
                        <input type="hidden" id="eventId">
                        <div class="mb-3">
                           <label class="form-label">Class Type</label>
                           <select class="form-select form-select-sm" id="eventType" required>
                              <option value="">Select</option>
                              <?php foreach ($data['class_types'] as $class_type): ?>
                                 <option value="<?php echo esc_attr($class_type['id']); ?>"><?php echo esc_html($class_type['name']); ?></option>
                              <?php endforeach; ?>
                           </select>
                           <div class="invalid-feedback">Please select a class type.</div>
                           <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="mb-3">
                           <label class="form-label">Description</label>
                           <textarea class="form-control form-control-sm" id="eventDescription" required></textarea>
                           <div class="invalid-feedback">Please enter a description.</div>
                           <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="row">
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Date</label>
                              <input type="date" class="form-control form-control-sm readonly-field" id="eventDate" readonly required>
                              <small class="text-muted">Date is set from calendar selection</small>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Day</label>
                              <input type="text" class="form-control form-control-sm readonly-field" id="eventDay" readonly required>
                              <small class="text-muted">Day is automatically determined</small>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Start Time</label>
                              <select class="form-select form-select-sm" id="eventStartTime" required>
                                 <!-- Will be populated via JavaScript -->
                              </select>
                              <div class="invalid-feedback">Please select a start time.</div>
                              <div class="valid-feedback">Looks good!</div>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">End Time</label>
                              <select class="form-select form-select-sm" id="eventEndTime" required>
                                 <!-- Will be populated via JavaScript -->
                              </select>
                              <div class="invalid-feedback">Please select an end time.</div>
                              <div class="valid-feedback">Looks good!</div>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary btn-sm" id="cancelEvent">Cancel</button>
                     <button type="button" class="btn btn-danger btn-sm" id="deleteEvent">Delete</button>
                     <button type="button" class="btn btn-primary btn-sm" id="saveEvent">Save Event</button>
                  </div>
               </div>
            </div>
         </div>

         <!-- Hidden inputs to store calendar events data in the format expected by the backend -->
         <div id="schedule-data-container">
            <!-- These will be populated dynamically via JavaScript -->
         </div>
      </div>

      <?php echo section_divider(); ?>

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

      <!-- Class Date History Section -->
      <div class="mb-4 mt-3">
         <h5 class="mb-3">Class Date History</h5>
         <p class="text-muted small mb-3">Add stop and restart dates for this class. A class can have multiple stop and restart dates.</p>

         <!-- Container for all date history rows -->
         <div id="date-history-container"></div>

         <!-- Hidden Template Row (initially d-none) -->
         <div class="row date-history-row d-none" id="date-history-row-template">
            <!-- Stop Date -->
            <div class="col-md-5 mb-2">
               <label class="form-label">Stop Date</label>
               <input type="date" name="stop_dates[]" class="form-control form-control-sm">
               <div class="invalid-feedback">Please select a valid date.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>

            <!-- Restart Date -->
            <div class="col-md-5 mb-2">
               <label class="form-label fw-bold">Restart Date</label>
               <input type="date" name="restart_dates[]" class="form-control form-control-sm">
               <div class="invalid-feedback">Please select a valid date.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>

            <!-- Remove Button -->
            <div class="col-md-2 mb-2">
               <label class="form-label fw-bold invisible">&nbsp;</label>
               <button type="button" class="btn btn-outline-danger btn-sm remove-date-row-btn form-control date-remove-btn">Remove</button>
            </div>
         </div>

         <!-- Add Row Button -->
         <button type="button" class="btn btn-outline-primary btn-sm" id="add-date-history-btn">
         + Add Stop/Restart Dates
         </button>
      </div>

      <?php echo section_divider(); ?>

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

      <!-- Class Learners Section -->
      <?php echo section_divider(); ?>
      <?php echo section_header('Class Learners', 'Select learners for this class and manage their status.'); ?>

      <div class="row mb-4">
         <!-- Learner Selection -->
         <div class="col-md-4">
            <label for="add_learner" class="form-label">Select Learners <span class="text-danger">*</span></label>
            <select id="add_learner" name="add_learner[]" class="form-select form-select-sm" size="5" multiple required>
               <?php foreach ($data['learners'] as $learner): ?>
                  <option value="<?php echo esc_attr($learner['id']); ?>"><?php echo esc_html($learner['name']); ?></option>
               <?php endforeach; ?>
            </select>
            <div class="form-text">Select multiple learners to add to this class.</div>
            <div class="invalid-feedback">Please select at least one learner.</div>
            <div class="valid-feedback">Looks good!</div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-selected-learners-btn">
               Add Selected Learners
            </button>
         </div>

         <!-- Learners Table -->
         <div class="col-md-8">
            <label class="form-label">Class Learners</label>
            <div id="class-learners-container" class="border rounded p-3">
               <div class="alert alert-info" id="no-learners-message">
                  No learners added to this class yet. Select learners from the list and click "Add Selected Learners".
               </div>
               <table class="table table-sm d-none" id="class-learners-table">
                  <thead>
                     <tr>
                        <th>Learner</th>
                        <th>Host/Walk-in Status</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody id="class-learners-tbody">
                     <!-- Learner rows will be added here dynamically -->
                  </tbody>
               </table>
            </div>
            <!-- Hidden field to store learner data -->
            <input type="hidden" id="class_learners_data" name="class_learners_data" value="">
         </div>
      </div>

      <!-- Exam Learners (conditionally displayed) -->
      <div class="row mt-5" id="exam_learners_container" style="display: none;">
      <?php echo section_divider(); ?>
         <div class="col-12">
            <h5 class="mb-3">Select Learners Taking Exams</h5>
            <p class="text-muted small mb-3">Not all learners in an exam class necessarily take exams. Select which learners will take exams.</p>

            <div class="row mb-4">
               <!-- Exam Learner Selection -->
               <div class="col-md-4">
                  <label for="exam_learner_select" class="form-label">Select Learners Taking Exams <span class="text-danger">*</span></label>
                  <select id="exam_learner_select" name="exam_learner_select[]" class="form-select form-select-sm" size="5" multiple>
                     <!-- Will be populated dynamically with class learners -->
                  </select>
                  <div class="form-text">Select learners who will take exams in this class.</div>
                  <div class="invalid-feedback">Please select at least one learner for exams.</div>
                  <div class="valid-feedback">Looks good!</div>
                  <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-selected-exam-learners-btn">
                     Add Selected Exam Learners
                  </button>
               </div>

               <!-- Exam Learners List -->
               <div class="col-md-8">
                  <label class="form-label">Learners Taking Exams</label>
                  <div id="exam-learners-list" class="border rounded p-3 mb-3">
                     <div class="alert alert-info" id="no-exam-learners-message">
                        No exam learners added yet. Select learners from the list and click "Add Selected Exam Learners".
                     </div>
                     <table class="table table-sm d-none" id="exam-learners-table">
                        <thead>
                           <tr>
                              <th>Learner</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody id="exam-learners-tbody">
                           <!-- Exam learner rows will be added here dynamically -->
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>

            <!-- Hidden field to store exam learners data -->
            <input type="hidden" id="exam_learners" name="exam_learners" value="">
         </div>
      </div>

      <?php echo section_divider(); ?>
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

      <?php echo section_divider(); ?>

      <!-- ===== Section: Assignments & Dates ===== -->
      <?php echo section_header('Assignments & Dates', 'Assign staff to this class and track agent changes.'); ?>

      <!-- Class Agents Section -->
      <div class="mb-4">
         <h5 class="mb-3">Class Agents</h5>
         <p class="text-muted small mb-3">Assign the primary class agent. If the agent changes during the class, the history will be tracked.</p>

         <!-- Initial Class Agent -->
         <div class="row mb-3">
            <div class="col-md-5">
               <label for="initial_class_agent" class="form-label">Initial Class Agent <span class="text-danger">*</span></label>
               <select id="initial_class_agent" name="initial_class_agent" class="form-select form-select-sm" required>
                  <option value="">Select</option>
                  <?php foreach ($data['agents'] as $agent): ?>
                     <option value="<?php echo esc_attr($agent['id']); ?>"><?php echo esc_html($agent['name']); ?></option>
                  <?php endforeach; ?>
               </select>
               <div class="invalid-feedback">Please select the initial class agent.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-5">
               <label for="initial_agent_start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
               <input type="date" id="initial_agent_start_date" name="initial_agent_start_date" class="form-control form-control-sm" required>
               <div class="invalid-feedback">Please select the start date.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>
         </div>

         <!-- Agent Replacements -->
         <h6 class="mb-3">Agent Replacements</h6>
         <p class="text-muted small mb-3">If the class agent changes, add the replacement agent and takeover date here.</p>

         <!-- Container for all agent replacement rows -->
         <div id="agent-replacements-container"></div>

         <!-- Hidden Template Row (initially d-none) -->
         <div class="row agent-replacement-row d-none" id="agent-replacement-row-template">
            <!-- Replacement Agent -->
            <div class="col-md-5 mb-2">
               <label class="form-label">Replacement Agent</label>
               <select name="replacement_agent_ids[]" class="form-select form-select-sm replacement-agent-select">
                  <option value="">Select</option>
                  <?php foreach ($data['agents'] as $agent): ?>
                     <option value="<?php echo esc_attr($agent['id']); ?>"><?php echo esc_html($agent['name']); ?></option>
                  <?php endforeach; ?>
               </select>
               <div class="invalid-feedback">Please select a replacement agent.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>

            <!-- Takeover Date -->
            <div class="col-md-5 mb-2">
               <label class="form-label">Takeover Date</label>
               <input type="date" name="replacement_agent_dates[]" class="form-control form-control-sm">
               <div class="invalid-feedback">Please select a valid takeover date.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>

            <!-- Remove Button -->
            <div class="col-md-2 mb-2">
               <label class="form-label invisible">&nbsp;</label>
               <button type="button" class="btn btn-outline-danger btn-sm remove-agent-replacement-btn form-control date-remove-btn">Remove</button>
            </div>
         </div>

         <!-- Add Row Button -->
         <button type="button" class="btn btn-outline-primary btn-sm" id="add-agent-replacement-btn">
         + Add Agent Replacement
         </button>
      </div>

      <!-- Project Supervisor -->
      <div class="row mb-4">
         <div class="col-md-5">
            <label for="project_supervisor" class="form-label">Project Supervisor <span class="text-danger">*</span></label>
            <select id="project_supervisor" name="project_supervisor" class="form-select form-select-sm" required>
               <option value="">Select</option>
               <?php foreach ($data['supervisors'] as $supervisor): ?>
                  <option value="<?php echo esc_attr($supervisor['id']); ?>"><?php echo esc_html($supervisor['name']); ?></option>
               <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please select a project supervisor.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <!-- Backup Agents Section -->
      <div class="mt-4 mb-4">
         <h5 class="mb-3">Backup Agents</h5>
         <p class="text-muted small mb-3">Add backup agents with specific dates when they will be available.</p>

         <!-- Container for all backup agent rows -->
         <div id="backup-agents-container"></div>

         <!-- Hidden Template Row (initially d-none) -->
         <div class="row backup-agent-row d-none" id="backup-agent-row-template">
            <!-- Backup Agent -->
            <div class="col-md-5 mb-2">
               <label class="form-label">Backup Agent</label>
               <select name="backup_agent_ids[]" class="form-select form-select-sm backup-agent-select">
                  <option value="">Select</option>
                  <?php foreach ($data['agents'] as $agent): ?>
                     <option value="<?php echo esc_attr($agent['id']); ?>"><?php echo esc_html($agent['name']); ?></option>
                  <?php endforeach; ?>
               </select>
               <div class="invalid-feedback">Please select a backup agent.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>

            <!-- Backup Date -->
            <div class="col-md-5 mb-2">
               <label class="form-label">Backup Date</label>
               <input type="date" name="backup_agent_dates[]" class="form-control form-control-sm">
               <div class="invalid-feedback">Please select a valid date.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>

            <!-- Remove Button -->
            <div class="col-md-2 mb-2">
               <label class="form-label invisible">&nbsp;</label>
               <button type="button" class="btn btn-outline-danger btn-sm remove-backup-agent-btn form-control date-remove-btn">Remove</button>
            </div>
         </div>

         <!-- Add Row Button -->
         <button type="button" class="btn btn-outline-primary btn-sm" id="add-backup-agent-btn">
         + Add Backup Agent
         </button>
      </div>

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
