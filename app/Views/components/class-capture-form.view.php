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

      <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

      <!-- Day/Time Schedule Section -->
      <div class="mb-3">
         <h5 class="mb-3">Class Schedule Calendar</h5>
         <p class="text-muted small mb-3">Manage class schedules visually.</p>

         <!-- Calendar Container -->
         <div id="class-calendar" class="mb-3"></div>

         <!-- Hidden initialization script -->
         <script>
            jQuery(document).ready(function($) {
               // Try to initialize calendar after a short delay
               setTimeout(function() {
                  if (typeof initializeClassCalendar === 'function') {
                     initializeClassCalendar();
                  }
               }, 500);
            });
         </script>

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
                              <option value="AET">AET</option>
                              <option value="GETC">GETC</option>
                              <option value="Business Admin">Business Admin</option>
                              <option value="Package">Package</option>
                              <option value="Joiner">Joiner</option>
                              <option value="EEP">EEP</option>
                              <option value="Skills Programs">Skills Programs</option>
                              <option value="Amended Senior Certificate">Amended Senior Certificate</option>
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

      <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

      <!-- ===== Section: Scheduling & Class Info ===== -->
      <div class="row mt-3">
         <!-- Class Type -->
         <div class="col-md-6">
            <label for="class_type" class="form-label">Class Type <span class="text-danger">*</span></label>
            <select id="class_type" name="class_type" class="form-select form-select-sm" required>
               <option value="">Select</option>
               <option value="AET">AET</option>
               <option value="GETC">GETC</option>
               <option value="Business Admin">Business Admin</option>
               <option value="Package">Package</option>
               <option value="Joiner">Joiner</option>
               <option value="EEP">EEP</option>
               <option value="Skills Programs">Skills Programs</option>
               <option value="Amended Senior Certificate">Amended Senior Certificate</option>
            </select>
            <div class="invalid-feedback">Please select the class type.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

         <!-- Class Original Start Date -->
         <div class="col-md-6">
            <label for="class_start_date" class="form-label">Class Original Start Date <span class="text-danger">*</span></label>
            <input type="date" id="class_start_date" name="class_start_date" class="form-control form-control-sm" required>
            <div class="invalid-feedback">Please select the start date.</div>
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
            </div>

            <!-- Restart Date -->
            <div class="col-md-5 mb-2">
               <label class="form-label fw-bold">Restart Date</label>
               <input type="date" name="restart_dates[]" class="form-control form-control-sm">
               <div class="invalid-feedback">Please select a valid date.</div>
            </div>

            <!-- Remove Button -->
            <div class="col-md-2 mb-2 mt-8">
               <button type="button" class="btn btn-outline-danger btn-sm remove-date-row-btn">Remove</button>
            </div>
         </div>

         <!-- Add Row Button -->
         <button type="button" class="btn btn-outline-primary btn-sm" id="add-date-history-btn">
         + Add Stop/Restart Dates
         </button>
      </div>

      <div class="row mt-3">
         <!-- Class Subjects -->
         <div class="col-md-6">
            <label for="course_id" class="form-label">Class Subjects <span class="text-danger">*</span></label>
            <select id="course_id" name="course_id[]" class="form-select form-select-sm" size="4" multiple required>
               <option value="AET Communication">AET Communication</option>
               <option value="AET Numeracy">AET Numeracy</option>
               <option value="AET: GETC">AET: GETC</option>
               <option value="Business Administration NQF 2">Business Administration NQF 2</option>
               <option value="Business Administration NQF 3">Business Administration NQF 3</option>
               <option value="Business Administration NQF 4">Business Administration NQF 4</option>
               <option value="Employee Enhancement Program">Employee Enhancement Program</option>
               <option value="Skills Program">Skills Program</option>
               <option value="Mixed Subjects">Mixed Subjects</option>
               <option value="Amended Senior Certificate">Amended Senior Certificate</option>
            </select>
            <div class="invalid-feedback">Please select at least one subject.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

         <!-- Class Notes -->
         <div class="col-md-6">
            <label for="class_notes" class="form-label">Class Notes</label>
            <select id="class_notes" name="class_notes[]" class="form-select form-select-sm" size="4" multiple>
               <option value="Agent Absent">Agent Absent</option>
               <option value="Client Cancelled">Client Cancelled</option>
               <option value="Poor attendance">Poor attendance</option>
               <option value="Learners behind schedule">Learners behind schedule</option>
               <option value="Learners unhappy">Learners unhappy</option>
               <option value="Client unhappy">Client unhappy</option>
               <option value="Learners too fast">Learners too fast</option>
               <option value="Class on track">Class on track</option>
               <option value="Bad QA report">Bad QA report</option>
               <option value="Good QA report">Good QA report</option>
               <option value="Incomplete workbooks">Incomplete workbooks</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

      <!-- ===== Section: Funding & Exam Details ===== -->
      <div class="row">
         <!-- SETA Funded -->
         <div class="col-md-4">
            <label for="seta_funded" class="form-label">SETA Funded <span class="text-danger">*</span></label>
            <select id="seta_funded" name="seta_funded" class="form-select form-select-sm" required>
               <option value="">Select</option>
               <option value="Yes">Yes</option>
               <option value="No">No</option>
            </select>
            <div class="invalid-feedback">Please select if the class is SETA funded.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

         <!-- SETA -->
         <div class="col-md-4">
            <label for="seta_id" class="form-label">SETA <span class="text-danger">*</span></label>
            <select id="seta_id" name="seta_id" class="form-select form-select-sm" required>
               <option value="">Select</option>
               <option value="AgriSETA">AgriSETA</option>
               <option value="BANKSETA">BANKSETA</option>
               <option value="CATHSSETA">CATHSSETA</option>
               <option value="CETA">CETA</option>
               <option value="CHIETA">CHIETA</option>
               <option value="ETDP SETA">ETDP SETA</option>
               <option value="EWSETA">EWSETA</option>
               <option value="FASSET">FASSET</option>
               <option value="FP&M SETA">FP&M SETA</option>
               <option value="FoodBev SETA">FoodBev SETA</option>
               <option value="HWSETA">HWSETA</option>
               <option value="INSETA">INSETA</option>
               <option value="LGSETA">LGSETA</option>
               <option value="MICT SETA">MICT SETA</option>
               <option value="MQA">MQA</option>
               <option value="PSETA">PSETA</option>
               <option value="SASSETA">SASSETA</option>
               <option value="Services SETA">Services SETA</option>
               <option value="TETA">TETA</option>
               <option value="W&RSETA">W&RSETA</option>
               <option value="merSETA">merSETA</option>
            </select>
            <div class="invalid-feedback">Please select a SETA.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

         <!-- Exam Class -->
         <div class="col-md-4">
            <label for="exam_class" class="form-label">Exam Class <span class="text-danger">*</span></label>
            <select id="exam_class" name="exam_class" class="form-select form-select-sm" required>
               <option value="">Select</option>
               <option value="Yes">Yes</option>
               <option value="No">No</option>
            </select>
            <div class="invalid-feedback">Please select if this is an exam class.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <!-- Exam Type (conditionally displayed) -->
      <div class="row mt-3" id="exam_type_container" style="display: none;">
         <div class="col-md-4">
            <label for="exam_type" class="form-label">Exam Type</label>
            <input type="text" id="exam_type" name="exam_type" class="form-control form-control-sm" placeholder="Enter exam type">
            <div class="invalid-feedback">Please provide the exam type.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

      <!-- ===== Section: Class Notes & QA ===== -->
      <div class="row">
         <!-- QA Visit Dates -->
         <div class="col-md-6">
            <label for="qa_visit_dates" class="form-label">QA Visit Dates</label>
            <textarea id="qa_visit_dates" name="qa_visit_dates" class="form-control form-control-sm" style="height:50px" placeholder="Enter QA visit dates separated by commas"></textarea>
            <div class="invalid-feedback">Please enter the QA visit dates.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <!-- QA Reports (File Upload) -->
      <div class="row mt-3">
         <div class="col-md-6">
            <label for="qa_reports" class="form-label">QA Reports</label>
            <input type="file" id="qa_reports" name="qa_reports[]" class="form-control form-control-sm" accept="application/pdf" multiple>
            <div class="invalid-feedback">Please upload valid QA reports.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>

      <!-- ===== Section: Assignments & Dates ===== -->
      <div class="row">
         <!-- Class Agent -->
         <div class="col-md-4">
            <label for="class_agent" class="form-label">Class Agent <span class="text-danger">*</span></label>
            <select id="class_agent" name="class_agent" class="form-select form-select-sm" required>
               <option value="">Select</option>
               <?php foreach ($data['agents'] as $agent): ?>
                  <option value="<?php echo esc_attr($agent['id']); ?>"><?php echo esc_html($agent['name']); ?></option>
               <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please select a class agent.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

         <!-- Project Supervisor -->
         <div class="col-md-4">
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

         <!-- Add Learner (Multi-select) -->
         <div class="col-md-4">
            <label for="add_learner" class="form-label">Add Learner <span class="text-danger">*</span></label>
            <select id="add_learner" name="add_learner[]" class="form-select form-select-sm" size="2" multiple required>
               <?php foreach ($data['learners'] as $learner): ?>
                  <option value="<?php echo esc_attr($learner['id']); ?>"><?php echo esc_html($learner['name']); ?></option>
               <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please add at least one learner.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <div class="row mt-3">
         <!-- Delivery Date (Now Required) -->
         <div class="col-md-4">
            <label for="delivery_date" class="form-label">SORS/Learnerpacks Delivery Date <span class="text-danger">*</span></label>
            <input type="date" id="delivery_date" name="delivery_date" class="form-control form-control-sm" required>
            <div class="invalid-feedback">Please select a delivery date.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>

         <!-- Backup Agent (Multi-select) -->
         <div class="col-md-4">
            <label for="backup_agent" class="form-label">Backup Agent <span class="text-danger">*</span></label>
            <select id="backup_agent" name="backup_agent[]" class="form-select form-select-sm" size="2" multiple required>
               <?php foreach ($data['agents'] as $agent): ?>
                  <option value="<?php echo esc_attr($agent['id']); ?>"><?php echo esc_html($agent['name']); ?></option>
               <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please select a backup agent.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>

      <!-- Submit Button -->
      <div class="row mt-4">
         <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Add New Class</button>
         </div>
      </div>
   </div>
</form>

<!-- Alert container for form messages -->
<div id="form-messages" class="mt-3"></div>
