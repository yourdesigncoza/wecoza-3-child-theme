<!-- Classes Capture Form -->
<form id="classes-form" class="needs-validation ydcoza-compact-form" novalidate method="POST" enctype="multipart/form-data">
   <!-- Hidden fields for update mode -->
   <input type="hidden" id="class_id" name="class_id" value="<?php echo esc_attr($data['class_id'] ?? $_GET['class_id'] ?? ''); ?>">
   <input type="hidden" id="redirect_url" name="redirect_url" value="<?php echo esc_attr($data['redirect_url'] ?? $_GET['redirect_url'] ?? ''); ?>">
   <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('wecoza_class_nonce'); ?>">

   <!-- ===== Section: Basic Details ===== -->
   <div class="container container-md classes-form ps-0">
      <!-- ===== Section: Basic Details ===== -->
         <!-- UPDATE MODE: Display existing client/site info (read-only) -->
         <div class="row">
            <div class="col-md-12 mb-3">
               <div class="alert alert-info">
                  <h6 class="mb-2">Class Information</h6>
                  <p class="mb-1"><strong>Client:</strong> <?php echo isset($data['class_data']) && $data['class_data'] ? esc_html($data['class_data']->client_name ?? 'Not specified') : 'Loading...'; ?></p>
                  <p class="mb-0"><strong>Site:</strong> <?php echo isset($data['class_data']) && $data['class_data'] ? esc_html($data['class_data']->site_name ?? 'Not specified') : 'Loading...'; ?></p>
               </div>
            </div>
         </div> <!-- UPDATE MODE: Display existing schedule info -->
            <div class="alert alert-success mb-3">
               <h6 class="mb-2">Current Schedule</h6>
               <p class="mb-1"><strong>Pattern:</strong> <?php echo isset($data['class_data']) && $data['class_data'] ? esc_html($data['class_data']->schedule_pattern ?? 'Not specified') : 'Loading...'; ?></p>
               <p class="mb-1"><strong>Days:</strong> <?php echo isset($data['class_data']) && $data['class_data'] ? esc_html($data['class_data']->schedule_days ?? 'Not specified') : 'Loading...'; ?></p>
               <p class="mb-0"><strong>Time:</strong> <?php echo isset($data['class_data']) && $data['class_data'] ? esc_html(($data['class_data']->start_time ?? '') . ' - ' . ($data['class_data']->end_time ?? '')) : 'Loading...'; ?></p>
            </div>

      <?php echo section_divider(); ?>


         <!-- Exception Dates -->
         <div class="mb-4">
            <h6 class="mb-2">Exception Dates</h6>
            <p class="text-muted small mb-3">Add dates when classes will not occur (e.g. client closed).</p>

            <!-- Container for all exception date rows -->
            <div id="exception-dates-container"></div>

            <!-- Hidden Template Row (initially d-none) -->
            <div class="row exception-date-row align-items-center d-none" id="exception-date-row-template">
               <!-- Exception Date -->
               <div class="col-md-4 mb-2">
                  <div class="form-floating">
                     <input type="date" name="exception_dates[]" class="form-control" placeholder="YYYY-MM-DD">
                     <label>Date</label>
                     <div class="invalid-feedback">Please select a valid date.</div>
                     <div class="valid-feedback">Looks good!</div>
                  </div>
               </div>

               <!-- Reason -->
               <div class="col-md-6 mb-2">
                  <div class="form-floating">
                     <select name="exception_reasons[]" class="form-select">
                        <option value="">Select</option>
                        <option value="Client Cancelled">Client Cancelled</option>
                        <option value="Agent Absent">Agent Absent</option>
                        <option value="Public Holiday">Public Holiday</option>
                        <option value="Other">Other</option>
                     </select>
                     <label>Reason</label>
                     <div class="invalid-feedback">Please select a reason.</div>
                     <div class="valid-feedback">Looks good!</div>
                  </div>
               </div>

               <!-- Remove Button -->
               <div class="col-md-2 mb-2">
                  <div class="d-flex h-100 align-items-end">
                     <button type="button" class="btn btn-outline-danger btn-sm remove-exception-btn form-control date-remove-btn">Remove</button>
                  </div>
               </div>
            </div>

            <!-- Add Exception Button -->
            <button type="button" class="btn btn-outline-primary btn-sm" id="add-exception-date-btn">
            + Add Exception Date
            </button>
         </div>

         <!-- Public Holidays Section -->
         <div class="mb-4">
            <h6 class="mb-2">Public Holidays in Schedule</h6>
            <p class="text-muted small mb-3">By default, classes are not scheduled on public holidays. The system will only show holidays that conflict with your class schedule (when a holiday falls on a scheduled class day). You can override specific holidays to include them in the schedule.</p>

            <!-- No holidays message -->
            <div id="no-holidays-message" class="bd-callout bd-callout-info">
               No public holidays that conflict with your class schedule were found. Holidays are only shown when they fall on a scheduled class day.
            </div>

            <!-- Holidays table container -->
            <div id="holidays-table-container" class="card-body card-body card px-5 d-none" >
               <div class="table-responsive">
                  <table class="table table-sm fs-9 mb-0 table-hover">
                     <thead>
                        <tr>
                           <th style="width: 50px;">
                              <div class="form-check">&nbsp;</div>
                           </th>
                           <th>Date</th>
                           <th>Holiday</th>
                           <th>Override</th>
                        </tr>
                     </thead>
                     <tbody id="holidays-list">
                        <!-- Holidays will be populated here dynamically -->
                     </tbody>
                  </table>
               </div>

               <div class="d-flex justify-content-between mt-2">
                  <div>
                     <button type="button" class="btn btn-outline-secondary btn-sm" id="skip-all-holidays-btn">Skip All Holidays</button>
                     <button type="button" class="btn btn-outline-primary btn-sm" id="override-all-holidays-btn">Override All Holidays</button>
                  </div>
               </div>
            </div>
         </div>

         <!-- Holiday Row Template (for JavaScript) -->
         <template id="holiday-row-template">
            <tr class="holiday-row">
               <td>
                  <div class="form-check">
                     <input class="form-check-input holiday-override-checkbox" type="checkbox" id="override-holiday-{id}" data-date="{date}">
                     <label class="form-check-label" for="override-holiday-{id}"></label>
                  </div>
               </td>
               <td class="holiday-date">{formatted_date}</td>
               <td class="holiday-name">{name}</td>
               <td class="holiday-status">
                  <span class="badge bg-danger holiday-skipped">Skipped</span>
                  <span class="badge bg-info holiday-overridden d-none">Included</span>
               </td>
            </tr>
         </template>

         <!-- Hidden input to store holiday override data -->
         <input type="hidden" id="holiday_overrides" name="schedule_data[holiday_overrides]" value="">

         <!-- Hidden inputs to store schedule data in the format expected by the backend -->
         <div id="schedule-data-container">
            <!-- These will be populated dynamically via JavaScript -->
         </div>

         <!-- Schedule Statistics Section -->
         <!-- Schedule Statistics Toggle Button -->
         <div class="mt-3 mb-3">
            <button type="button" class="btn btn-outline-primary btn-sm" id="toggle-statistics-btn">
               <i class="bi bi-bar-chart-line me-1"></i> View Schedule Statistics
            </button>
            <div class="clearfix"></div>
            <small class="text-muted">Click to view detailed statistics about the training schedule</small>
         </div>

         <!-- Schedule Statistics Section (hidden by default) -->
         <div class="card shadow-none border mb-3 d-none" id="schedule-statistics-section" data-component-card="data-component-card">
         <div class="card-header p-3 border-bottom bg-body">
            <h4 class="text-body mb-0" data-anchor="schedule-statistics" id="schedule-statistics">
               Schedule Statistics
               <a class="anchorjs-link" aria-label="Anchor" data-anchorjs-icon="#" href="#schedule-statistics" style="margin-left:0.1875em; padding:0 0.1875em;"></a>
            </h4>
         </div>
         <div class="card-body p-4">
            <div class="table-responsive scrollbar mb-3">
               <table class="table table-sm fs-9 mb-0 overflow-hidden">
               <thead class="text-body">
                  <tr>
                     <th class="sort pe-1 align-middle white-space-nowrap">Category</th>
                     <th class="sort pe-1 align-middle white-space-nowrap">Metric</th>
                     <th class="sort pe-1 align-middle white-space-nowrap">Value</th>
                  </tr>
               </thead>
               <tbody id="schedule-statistics-table">
                  <!-- Training Duration Statistics -->
                  <tr class="ydcoza-table-subheader">
                     <th colspan="3">Training Duration</th>
                  </tr>
                  <tr>
                     <td rowspan="3" class="align-middle">Time Period</td>
                     <td>Total Calendar Days</td>
                     <td id="stat-total-days">-</td>
                  </tr>
                  <tr>
                     <td>Total Weeks</td>
                     <td id="stat-total-weeks">-</td>
                  </tr>
                  <tr>
                     <td>Total Months</td>
                     <td id="stat-total-months">-</td>
                  </tr>

                  <!-- Class Session Statistics -->
                  <tr class="ydcoza-table-subheader">
                     <th colspan="3">Class Sessions</th>
                  </tr>
                  <tr>
                     <td rowspan="3" class="align-middle">Sessions</td>
                     <td>Total Scheduled Classes</td>
                     <td id="stat-total-classes">-</td>
                  </tr>
                  <tr>
                     <td>Total Training Hours</td>
                     <td id="stat-total-hours">-</td>
                  </tr>
                  <tr>
                     <td>Average Hours per Month</td>
                     <td id="stat-avg-hours-month">-</td>
                  </tr>

                  <!-- Attendance Impact Statistics -->
                  <tr class="ydcoza-table-subheader">
                     <th colspan="3">Attendance Impact</th>
                  </tr>
                  <tr>
                     <td rowspan="3" class="align-middle">Adjustments</td>
                     <td>Holidays Affecting Classes</td>
                     <td id="stat-holidays-affecting">-</td>
                  </tr>
                  <tr>
                     <td>Exception Dates</td>
                     <td id="stat-exception-dates">-</td>
                  </tr>
                  <tr>
                     <td>Actual Training Days</td>
                     <td id="stat-actual-days">-</td>
                  </tr>
               </tbody>
               </table>
            </div>
         </div>
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
               <label class="form-label">Restart Date</label>
               <input type="date" name="restart_dates[]" class="form-control form-control-sm">
               <div class="invalid-feedback">Please select a valid date.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>

            <!-- Remove Button -->
            <div class="col-md-2 mb-2">
               <label class="form-label invisible">&nbsp;</label>
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
         <div class="col-md-3 mb-3">
            <div class="form-floating">
               <select id="seta_funded" name="seta_funded" class="form-select" required>
                  <option value="">Select</option>
                  <?php foreach ($data['yes_no_options'] as $option): ?>
                     <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                  <?php endforeach; ?>
               </select>
               <label for="seta_funded">SETA Funded? <span class="text-danger">*</span></label>
               <div class="invalid-feedback">Please select if the class is SETA funded.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>
         </div>

         <!-- SETA (conditionally displayed) -->
         <div class="col-md-3 mb-3" id="seta_container" style="display: none;">
            <div class="form-floating">
               <select id="seta_id" name="seta_id" class="form-select">
                  <option value="">Select</option>
                  <?php foreach ($data['setas'] as $seta): ?>
                     <option value="<?php echo $seta['id']; ?>"><?php echo $seta['name']; ?></option>
                  <?php endforeach; ?>
               </select>
               <label for="seta_id">SETA <span class="text-danger">*</span></label>
               <div class="invalid-feedback">Please select a SETA.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>
         </div>

         <!-- Exam Class -->
         <div class="col-md-3 mb-3">
            <div class="form-floating">
               <select id="exam_class" name="exam_class" class="form-select" required>
                  <option value="">Select</option>
                  <?php foreach ($data['yes_no_options'] as $option): ?>
                     <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                  <?php endforeach; ?>
               </select>
               <label for="exam_class">Exam Class <span class="text-danger">*</span></label>
               <div class="invalid-feedback">Please select if this is an exam class.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>
         </div>

         <!-- Exam Type (conditionally displayed) -->
         <div class="col-md-3 mb-3">
            <div id="exam_type_container" style="display: none;">
               <div class="form-floating">
                  <input type="text" id="exam_type" name="exam_type" class="form-control" placeholder="Enter exam type">
                  <label for="exam_type">Exam Type</label>
                  <div class="invalid-feedback">Please provide the exam type.</div>
                  <div class="valid-feedback">Looks good!</div>
               </div>
            </div>
         </div>
      </div>

      <!-- Class Learners Section -->
      <?php echo section_header('Class Learners <span class="text-danger">*</span>', 'Select learners for this class and manage their status.'); ?>

      <div class="row mb-4">
         <!-- Learner Selection -->
         <div class="col-md-4">
            <!-- For multi-select with floating labels, we need a custom approach -->
            <div class="mb-3">
               <label for="add_learner" class="form-label">Select Learners</label>
               <select id="add_learner" name="add_learner[]" class="form-select" aria-label="Learner selection" multiple>
                  <?php foreach ($data['learners'] as $learner): ?>
                     <option value="<?php echo $learner['id']; ?>"><?php echo $learner['name']; ?></option>
                  <?php endforeach; ?>
               </select>
               <div class="form-text">Select multiple learners to add to this class. Hold Ctrl/Cmd to select multiple.</div>
               <div class="invalid-feedback">Please select at least one learner.</div>
               <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-selected-learners-btn">
                  Add Selected Learners
               </button>
            </div>
         </div>

         <!-- Learners Table -->
         <div class="col-md-8">
            <div class="mb-3">
               <div class="form-label mb-2">Class Learners</div>
               <div id="class-learners-container" class="card-body card px-5">
                  <div class="bd-callout bd-callout-info" id="no-learners-message">
                     No learners added to this class yet. At least one learner is required. Select learners from the list and click "Add Selected Learners".
                  </div>
                  <table class="table table-sm fs-9 d-none" id="class-learners-table">
                     <thead>
                        <tr>
                           <th>Learner</th>
                           <th>Level/Module</th>
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
                  <!-- For multi-select with floating labels, we need a custom approach -->
                  <div class="mb-3">
                     <label for="add_learner" class="form-label">Select Learners</label>
                     <select id="exam_learner_select" name="exam_learner_select[]" class="form-select" aria-label="Exam learner selection" multiple>
                        <!-- Will be populated dynamically with class learners -->
                     </select>
                     <div class="form-text">Select learners who will take exams in this class. Hold Ctrl/Cmd to select multiple.</div>
                     <div class="invalid-feedback">Please select at least one learner for exams.</div>
                     <div class="valid-feedback">Looks good!</div>
                     <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-selected-exam-learners-btn">
                        Add Selected Exam Learners
                     </button>
                  </div>
               </div>

               <!-- Exam Learners List -->
               <div class="col-md-8">
                  <div class="mb-3">
                     <div class="form-label mb-2">Learners Taking Exams</div>
                     <div id="exam-learners-list" class="card-body card px-5">
                        <div class="alert alert-info" id="no-exam-learners-message">
                           No exam learners added yet. Select learners from the list and click "Add Selected Exam Learners".
                        </div>
                        <table class="table table-sm fs-9 d-none" id="exam-learners-table">
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
            <!-- For multi-select with floating labels, we need a custom approach -->
            <div class="mb-3">
            <label for="class_notes" class="form-label">Class Notes</label>
            <select
               id="class_notes"
               name="class_notes[]"
               class="form-select"
               size="5"
               multiple
               aria-label="Class notes selection"
            >
               <?php foreach ($data['class_notes_options'] as $option): ?>
                  <option value="<?= $option['id'] ?>"><?= $option['name'] ?></option>
               <?php endforeach; ?>
            </select>
            <div class="form-text">
               Select multiple operational notes that apply to this class. Hold Ctrl/Cmd to select.
            </div>
            <div class="invalid-feedback">Please select at least one note.</div>
            <div class="valid-feedback">Looks good!</div>
            </div>


         </div>
      </div>

      <!-- QA Visit Dates and Reports Section -->
      <div class="mt-4">
         <h6 class="mb-3">QA Visit Dates & Reports</h6>
         <p class="text-muted small mb-3">Add QA visit dates and upload corresponding reports for each visit.</p>

         <!-- Container for all QA visit date rows -->
         <div id="qa-visits-container"></div>

         <!-- Hidden Template Row (initially d-none) -->
         <div class="row qa-visit-row align-items-center d-none" id="qa-visit-row-template">
            <!-- Visit Date -->
            <div class="col-md-4 mb-2">
               <div class="form-floating">
                  <input type="date" name="qa_visit_dates[]" class="form-control" placeholder="YYYY-MM-DD">
                  <label>Visit Date</label>
                  <div class="invalid-feedback">Please select a valid date.</div>
                  <div class="valid-feedback">Looks good!</div>
               </div>
            </div>

            <!-- Report Upload -->
            <div class="col-md-6 mb-2">
               <div class="form-floating ydcoza-upload">
                  <input type="file" name="qa_reports[]" class="form-control" accept="application/pdf">
                  <label>QA Report</label>
                  <div class="invalid-feedback">Please upload a report for this visit.</div>
                  <div class="valid-feedback">Looks good!</div>
               </div>
            </div>

            <!-- Remove Button -->
            <div class="col-md-2 mb-2">
               <div class="d-flex h-100 align-items-end">
                  <button type="button" class="btn btn-outline-danger btn-sm remove-qa-visit-btn form-control date-remove-btn">Remove</button>
               </div>
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
            <div class="col-md-5 mb-3">
               <div class="form-floating">
                  <select id="initial_class_agent" name="initial_class_agent" class="form-select" required>
                     <option value="">Select</option>
                     <?php foreach ($data['agents'] as $agent): ?>
                        <option value="<?php echo $agent['id']; ?>"><?php echo $agent['name']; ?></option>
                     <?php endforeach; ?>
                  </select>
                  <label for="initial_class_agent">Initial Class Agent <span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please select the initial class agent.</div>
                  <div class="valid-feedback">Looks good!</div>
               </div>
            </div>
            <div class="col-md-5 mb-3">
               <div class="form-floating">
                  <input type="date" id="initial_agent_start_date" name="initial_agent_start_date" class="form-control" placeholder="YYYY-MM-DD" required>
                  <label for="initial_agent_start_date">Start Date <span class="text-danger">*</span></label>
                  <div class="invalid-feedback">Please select the start date.</div>
                  <div class="valid-feedback">Looks good!</div>
               </div>
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
               <div class="form-floating">
                  <select name="replacement_agent_ids[]" class="form-select replacement-agent-select">
                     <option value="">Select</option>
                     <?php foreach ($data['agents'] as $agent): ?>
                        <option value="<?php echo $agent['id']; ?>"><?php echo $agent['name']; ?></option>
                     <?php endforeach; ?>
                  </select>
                  <label>Replacement Agent</label>
                  <div class="invalid-feedback">Please select a replacement agent.</div>
                  <div class="valid-feedback">Looks good!</div>
               </div>
            </div>

            <!-- Takeover Date -->
            <div class="col-md-5 mb-2">
               <div class="form-floating">
                  <input type="date" name="replacement_agent_dates[]" class="form-control" placeholder="YYYY-MM-DD">
                  <label>Takeover Date</label>
                  <div class="invalid-feedback">Please select a valid takeover date.</div>
                  <div class="valid-feedback">Looks good!</div>
               </div>
            </div>

            <!-- Remove Button -->
            <div class="col-md-2 mb-2">
               <div class="d-flex h-100 align-items-end">
                  <button type="button" class="btn btn-outline-danger btn-sm remove-agent-replacement-btn form-control date-remove-btn">Remove</button>
               </div>
            </div>
         </div>

         <!-- Add Row Button -->
         <button type="button" class="btn btn-outline-primary btn-sm" id="add-agent-replacement-btn">
         + Add Agent Replacement
         </button>
      </div>

      <!-- Project Supervisor and Delivery Date -->
      <div class="row mb-4">
         <div class="col-md-5 mb-3">
            <div class="form-floating">
               <select id="project_supervisor" name="project_supervisor" class="form-select" required>
                  <option value="">Select</option>
                  <?php foreach ($data['supervisors'] as $supervisor): ?>
                     <option value="<?php echo $supervisor['id']; ?>"><?php echo $supervisor['name']; ?></option>
                  <?php endforeach; ?>
               </select>
               <label for="project_supervisor">Project Supervisor <span class="text-danger">*</span></label>
               <div class="invalid-feedback">Please select a project supervisor.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>
         </div>

         <div class="col-md-5 mb-3">
            <div class="form-floating">
               <input type="date" id="delivery_date" name="delivery_date" class="form-control" placeholder="YYYY-MM-DD" required>
               <label for="delivery_date">Delivery Date <span class="text-danger">*</span></label>
               <div class="invalid-feedback">Please select the delivery date.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>
         </div>
      </div>

      <!-- Backup Agents Section -->
      <div class="mt-4 mb-4">
         <h5 class="mb-3">Backup Agents</h5>
         <p class="text-muted small mb-3">Add backup agents with specific dates when they will be available.</p>

         <!-- Container for all backup agent rows -->
         <div id="backup-agents-container"></div>

         <!-- Hidden Template Row (initially d-none) -->
         <div class="row backup-agent-row align-items-center d-none" id="backup-agent-row-template">
            <!-- Backup Agent -->
            <div class="col-md-5 mb-2">
               <div class="form-floating">
                  <select name="backup_agent_ids[]" class="form-select backup-agent-select">
                     <option value="">Select</option>
                     <?php foreach ($data['agents'] as $agent): ?>
                        <option value="<?php echo $agent['id']; ?>"><?php echo $agent['name']; ?></option>
                     <?php endforeach; ?>
                  </select>
                  <label>Backup Agent</label>
                  <div class="invalid-feedback">Please select a backup agent.</div>
                  <div class="valid-feedback">Looks good!</div>
               </div>
            </div>

            <!-- Backup Date -->
            <div class="col-md-5 mb-2">
               <div class="form-floating">
                  <input type="date" name="backup_agent_dates[]" class="form-control" placeholder="YYYY-MM-DD">
                  <label>Backup Date</label>
                  <div class="invalid-feedback">Please select a valid date.</div>
                  <div class="valid-feedback">Looks good!</div>
               </div>
            </div>

            <!-- Remove Button -->
            <div class="col-md-2 mb-2">
               <div class="d-flex h-100 align-items-end">
                  <button type="button" class="btn btn-outline-danger btn-sm remove-backup-agent-btn form-control date-remove-btn">Remove</button>
               </div>
            </div>
         </div>

         <!-- Add Row Button -->
         <button type="button" class="btn btn-outline-primary btn-sm" id="add-backup-agent-btn">
         + Add Backup Agent
         </button>
      </div>

      <?php echo section_divider(); ?>
      <!-- Submit Button - Mode-aware text -->
      <div class="row mt-4">
         <div class="col-md-3">
               <?php echo button('Update Class', 'submit', 'primary'); ?>
         </div>
      </div>
   </div>
</form>

<!-- Alert container for form messages -->
<div id="form-messages" class="mt-3"></div>
