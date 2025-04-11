<?php
/**
 * Class capture form view
 *
 * @var array $data View data containing clients, sites, agents, supervisors, learners
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
               <label class="form-label fw-bold">Stop Date</label>
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
            <?php echo select_dropdown('seta_funded', $data['yes_no_options'], [
               'id' => 'seta_funded',
               'required' => true
            ], '', 'Select'); ?>
            <div class="invalid-feedback">Please select if the class is SETA funded.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

         <!-- SETA (conditionally displayed) -->
         <div class="col-md-3" id="seta_container" style="display: none;">
            <?php echo select_dropdown('seta_id', $data['setas'], [
               'id' => 'seta_id'
            ], '', 'Select'); ?>
            <div class="invalid-feedback">Please select a SETA.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

         <!-- Exam Class -->
         <div class="col-md-3">
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


      <!-- Exam Learners (conditionally displayed) -->
      <div class="row mt-5" id="exam_learners_container" style="display: none;">
         <div class="col-12">
            <h5 class="mb-3">Select Learners Taking Exams</h5>
            <p class="text-muted small mb-3">Not all learners in an exam class necessarily take exams. Select which learners will take exams.</p>

            <!-- Container for exam learners selection -->
            <div id="exam-learners-list" class="border rounded p-3 mb-3">
               <div class="alert alert-info">
                  Please select learners in the "Add Learner" field below first. The list of selected learners will appear here.
               </div>
            </div>

            <!-- Hidden field to store exam learners data -->
            <input type="hidden" id="exam_learners" name="exam_learners" value="">
         </div>

         <!-- Add Learner (Multi-select) -->
         <div class="col-md-4">
            <label for="add_learner" class="form-label">Add Learner <span class="text-danger">*</span></label>
            <select id="add_learner" name="add_learner[]" class="form-select form-select-sm" size="5" multiple required>
               <?php foreach ($data['learners'] as $learner): ?>
                  <option value="<?php echo esc_attr($learner['id']); ?>"><?php echo esc_html($learner['name']); ?></option>
               <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please add at least one learner.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

      </div>

      <?php echo section_divider(); ?>
      <?php echo section_header('Class Notes & QA', 'Add quality assurance information for this class.'); ?>

      <!-- QA Information -->
      <div class="row">
         <!-- QA Visit Dates -->
         <div class="col-md-6">
            <?php echo form_textarea('qa_visit_dates', 'QA Visit Dates', [
               'id' => 'qa_visit_dates',
               'placeholder' => 'Enter QA visit dates separated by commas',
               'rows' => '2'
            ], '', false, 'Please enter the QA visit dates.', 'Looks good!'); ?>
         </div>
      </div>

      <!-- QA Reports (File Upload) -->
      <div class="row mt-3">
         <div class="col-md-6">
            <?php echo form_input('file', 'qa_reports[]', 'QA Reports', [
               'id' => 'qa_reports',
               'accept' => 'application/pdf',
               'multiple' => 'multiple'
            ], '', false, 'Please upload valid QA reports.', 'Looks good!'); ?>
         </div>
      </div>

      <?php echo section_divider(); ?>

      <!-- ===== Section: Assignments & Dates ===== -->
      <?php echo section_header('Assignments & Dates', 'Assign staff to this class and set important dates.'); ?>
      <?php echo form_row([
         [
            'type' => 'select',
            'name' => 'class_agent',
            'label' => 'Class Agent',
            'col_class' => 'col-md-4',
            'attributes' => [
               'id' => 'class_agent',
               'options' => $data['agents'],
               'required' => true
            ],
            'invalid_feedback' => 'Please select a class agent.'
         ],
         [
            'type' => 'select',
            'name' => 'project_supervisor',
            'label' => 'Project Supervisor',
            'col_class' => 'col-md-4',
            'attributes' => [
               'id' => 'project_supervisor',
               'options' => $data['supervisors'],
               'required' => true
            ],
            'invalid_feedback' => 'Please select a project supervisor.'
         ]
      ]); ?>

      <?php echo form_row([
         [
            'type' => 'date',
            'name' => 'delivery_date',
            'label' => 'SORS/Learnerpacks Delivery Date',
            'col_class' => 'col-md-4',
            'attributes' => [
               'id' => 'delivery_date',
               'required' => true
            ],
            'required' => true,
            'invalid_feedback' => 'Please select a delivery date.'
         ],
         [
            'type' => 'select',
            'name' => 'backup_agent[]',
            'label' => 'Backup Agent',
            'col_class' => 'col-md-4',
            'attributes' => [
               'id' => 'backup_agent',
               'options' => $data['agents'],
               'multiple' => true,
               'size' => 2,
               'required' => true
            ],
            'required' => true,
            'invalid_feedback' => 'Please select a backup agent.'
         ]
      ]); ?>

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
