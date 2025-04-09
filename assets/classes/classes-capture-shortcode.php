<?php
   function wecoza_classes_capture_shortcode() {
       ob_start();
       ?>
<!-- FullCalendar CSS and JS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<!-- Classes Capture Form -->
<style>
   /* Calendar Event Type Styling */
   .event-type-class {
      background-color: #4285f4 !important;
      border-color: #4285f4 !important;
   }
   .event-type-exam {
      background-color: #ea4335 !important;
      border-color: #ea4335 !important;
   }
   .event-type-assessment {
      background-color: #fbbc05 !important;
      border-color: #fbbc05 !important;
   }
   .event-type-break {
      background-color: #34a853 !important;
      border-color: #34a853 !important;
   }
   #class-calendar {
      background-color: #fff;
      border-radius: 4px;
      box-shadow: 0 1px 2px rgba(0,0,0,0.1);
   }
   .fc-event {
      cursor: pointer;
   }
   .fc-timegrid-event .fc-event-main {
      padding: 4px;
   }
</style>
<form id="classes-form" class="needs-validation ydcoza-compact-form" novalidate method="POST" enctype="multipart/form-data">
   <!-- Hidden Auto-generated Class ID -->
   <input type="hidden" id="class_id" name="class_id" value="auto-generated">
   <!-- ===== Section: Basic Details ===== -->
   <div class="container container-md classes-form">
      <div class="row">
         <!-- Client Name (ID) -->
         <div class="col-md-3">
            <label for="client_id" class="form-label">Client Name (ID) <span class="text-danger">*</span></label>
            <select id="client_id" name="client_id" class="form-select form-select-sm" required>
               <option value="">Select</option>
               <option value="11">Aspen Pharmacare</option>
               <option value="14">Barloworld</option>
               <option value="9">Bidvest Group</option>
               <option value="8">FirstRand</option>
               <option value="4">MTN Group</option>
               <option value="15">Multichoice Group</option>
               <option value="5">Naspers</option>
               <option value="12">Nedbank Group</option>
               <option value="10">Sanlam</option>
               <option value="1">Sasol Limited</option>
               <option value="3">Shoprite Holdings</option>
               <option value="2">Standard Bank Group</option>
               <option value="13">Tiger Brands</option>
               <option value="6">Vodacom Group</option>
               <option value="7">Woolworths Holdings</option>
            </select>
            <div class="invalid-feedback">Please select a client.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
         <!-- Class/Site Name -->
         <div class="col-md-3">
            <label for="site_id" class="form-label">Class/Site Name <span class="text-danger">*</span></label>
            <select id="site_id" name="site_id" class="form-select form-select-sm" required>
               <option value="">Select Site</option>
               <optgroup label="Aspen Pharmacare">
                  <option value="11_1">Aspen Pharmacare - Head Office</option>
                  <option value="11_2">Aspen Pharmacare - Production Unit</option>
                  <option value="11_3">Aspen Pharmacare - Research Centre</option>
               </optgroup>
               <optgroup label="Barloworld">
                  <option value="14_1">Barloworld - Northern Branch</option>
                  <option value="14_2">Barloworld - Southern Branch</option>
                  <option value="14_3">Barloworld - Central Branch</option>
               </optgroup>
               <optgroup label="Bidvest Group">
                  <option value="9_1">Bidvest Group - Logistics Hub</option>
                  <option value="9_2">Bidvest Group - Corporate Office</option>
                  <option value="9_3">Bidvest Group - Industrial Park</option>
               </optgroup>
               <optgroup label="FirstRand">
                  <option value="8_1">FirstRand - Main Office</option>
                  <option value="8_2">FirstRand - Regional Office</option>
                  <option value="8_3">FirstRand - Satellite Office</option>
               </optgroup>
               <optgroup label="MTN Group">
                  <option value="4_1">MTN Group - Midrand</option>
                  <option value="4_2">MTN Group - Cape Town</option>
                  <option value="4_3">MTN Group - Johannesburg</option>
               </optgroup>
               <optgroup label="Multichoice Group">
                  <option value="15_1">Multichoice Group - Head Office</option>
                  <option value="15_2">Multichoice Group - Studio Complex</option>
                  <option value="15_3">Multichoice Group - Satellite Office</option>
               </optgroup>
               <optgroup label="Naspers">
                  <option value="5_1">Naspers - Digital Hub</option>
                  <option value="5_2">Naspers - Corporate Centre</option>
                  <option value="5_3">Naspers - Innovation Lab</option>
               </optgroup>
               <optgroup label="Nedbank Group">
                  <option value="12_1">Nedbank Group - Downtown Branch</option>
                  <option value="12_2">Nedbank Group - Uptown Office</option>
                  <option value="12_3">Nedbank Group - Financial District</option>
               </optgroup>
               <optgroup label="Sanlam">
                  <option value="10_1">Sanlam - Main Branch</option>
                  <option value="10_2">Sanlam - Regional Office</option>
                  <option value="10_3">Sanlam - International Office</option>
               </optgroup>
               <optgroup label="Sasol Limited">
                  <option value="1_1">Sasol Limited - Industrial Park</option>
                  <option value="1_2">Sasol Limited - R&amp;D Centre</option>
                  <option value="1_3">Sasol Limited - Corporate Office</option>
               </optgroup>
               <optgroup label="Shoprite Holdings">
                  <option value="3_1">Shoprite Holdings - Distribution Centre</option>
                  <option value="3_2">Shoprite Holdings - Corporate Office</option>
                  <option value="3_3">Shoprite Holdings - Outlet</option>
               </optgroup>
               <optgroup label="Standard Bank Group">
                  <option value="2_1">Standard Bank Group - Head Office</option>
                  <option value="2_2">Standard Bank Group - Branch Office</option>
                  <option value="2_3">Standard Bank Group - Digital Office</option>
               </optgroup>
               <optgroup label="Tiger Brands">
                  <option value="13_1">Tiger Brands - Manufacturing Unit</option>
                  <option value="13_2">Tiger Brands - Distribution Hub</option>
                  <option value="13_3">Tiger Brands - Corporate Office</option>
               </optgroup>
               <optgroup label="Vodacom Group">
                  <option value="6_1">Vodacom Group - Data Centre</option>
                  <option value="6_2">Vodacom Group - Tech Hub</option>
                  <option value="6_3">Vodacom Group - Service Centre</option>
               </optgroup>
               <optgroup label="Woolworths Holdings">
                  <option value="7_1">Woolworths Holdings - Retail Hub</option>
                  <option value="7_2">Woolworths Holdings - Distribution Centre</option>
                  <option value="7_3">Woolworths Holdings - Corporate Office</option>
               </optgroup>
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
         <p class="text-muted small mb-3">Manage class schedules visually. Drag and drop to adjust times.</p>

         <!-- Calendar Container -->
         <div id="class-calendar" class="mb-3"></div>

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
                           <label class="form-label">Event Type</label>
                           <select class="form-select form-select-sm" id="eventType" required>
                              <option value="class">Regular Class</option>
                              <option value="exam">Examination</option>
                              <option value="assessment">Assessment</option>
                              <option value="break">Break Period</option>
                           </select>
                        </div>
                        <div class="mb-3">
                           <label class="form-label">Description</label>
                           <textarea class="form-control form-control-sm" id="eventDescription" required></textarea>
                        </div>
                        <div class="row">
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Date</label>
                              <input type="date" class="form-control form-control-sm" id="eventDate" readonly required>
                              <small class="text-muted">Date is set from calendar selection</small>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Day</label>
                              <input type="text" class="form-control form-control-sm" id="eventDay" readonly required>
                              <small class="text-muted">Day is automatically determined</small>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Start Time</label>
                              <select class="form-select form-select-sm" id="eventStartTime" required>
                                 <!-- Will be populated via JavaScript -->
                              </select>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">End Time</label>
                              <select class="form-select form-select-sm" id="eventEndTime" required>
                                 <!-- Will be populated via JavaScript -->
                              </select>
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

         <!-- Calendar events can be added by clicking on the calendar -->
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
         <!-- Class Notes (Multi-select) -->
         <div class="col-md-6">
            <label for="class_notes" class="form-label">Class Notes</label>
            <select id="class_notes" name="class_notes[]" class="form-select form-select-sm" size="2" multiple>
               <option value="1">Class Ended Early</option>
               <option value="2">Class Did Not Resume</option>
               <option value="3">Facilitator Did Not Show Up</option>
               <option value="4">Low Learner Attendance</option>
               <option value="5">No Learners Showed Up</option>
               <option value="6">Client Canceled the Class</option>
               <option value="7">Venue Unavailable</option>
               <option value="8">Materials Not Delivered</option>
               <option value="9">Technical Issues</option>
               <option value="10">Security Concern</option>
               <option value="11">Power Outage</option>
               <option value="12">Learners Arrived Late</option>
               <option value="13">Facilitator Arrived Late</option>
               <option value="14">Classroom Too Noisy</option>
               <option value="15">Insufficient Seating</option>
               <option value="16">Wrong Course Material Issued</option>
               <option value="17">Learner Engagement Low</option>
               <option value="18">Client Staff Disruptions</option>
               <option value="19">Health &amp; Safety Issue</option>
               <option value="20">Learners Request Additional Support</option>
            </select>
            <div class="invalid-feedback">Please select class notes if applicable.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
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
               <option value="1">Michael M. van der Berg</option>
               <option value="2">Thandi T. Nkosi</option>
               <option value="3">Rajesh R. Patel</option>
               <option value="4">Lerato L. Moloi</option>
               <option value="5">Johannes J. Pretorius</option>
               <option value="6">Nomvula N. Dlamini</option>
               <option value="7">David D. O'Connor</option>
               <option value="8">Zanele Z. Mthembu</option>
               <option value="9">Pieter P. van Zyl</option>
               <option value="10">Fatima F. Ismail</option>
               <option value="11">Sipho S. Ndlovu</option>
               <option value="12">Anita A. van Rensburg</option>
               <option value="13">Themba T. Mkhize</option>
               <option value="14">Sarah S. Botha</option>
               <option value="15">Lwazi L. Zuma</option>
            </select>
            <div class="invalid-feedback">Please select a class agent.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
         <!-- Project Supervisor -->
         <div class="col-md-4">
            <label for="project_supervisor" class="form-label">Project Supervisor <span class="text-danger">*</span></label>
            <select id="project_supervisor" name="project_supervisor" class="form-select form-select-sm" required>
               <option value="">Select</option>
               <option value="1">Ethan J. Williams</option>
               <option value="2">Aisha K. Mohamed</option>
               <option value="3">Carlos M. Rodriguez</option>
               <option value="4">Emily R. Thompson</option>
               <option value="5">Samuel B. Johnson</option>
               <option value="6">Lungile T. Mthethwa</option>
               <option value="7">David C. Martins</option>
               <option value="8">Zanele P. Khumalo</option>
               <option value="9">Johan D. Venter</option>
               <option value="10">Fatima H. Desai</option>
               <option value="11">Sipho M. Zondi</option>
               <option value="12">Annelize S. du Preez</option>
               <option value="13">Themba L. Sithole</option>
               <option value="14">Sophia V. Naidoo</option>
               <option value="15">Mandla N. Dube</option>
            </select>
            <div class="invalid-feedback">Please select a project supervisor.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
         <!-- Add Learner (Multi-select) -->
         <div class="col-md-4">
            <label for="add_learner" class="form-label">Add Learner <span class="text-danger">*</span></label>
            <select id="add_learner" name="add_learner[]" class="form-select form-select-sm" size="2" multiple required>
               <option value="1">John J.M. Smith</option>
               <option value="2">Nosipho N. Dlamini</option>
               <option value="3">Ahmed A. Patel</option>
               <option value="4">Lerato L. Moloi</option>
               <option value="5">Pieter P. van der Merwe</option>
               <option value="6">Thandi T. Nkosi</option>
               <option value="7">Daniel D. O'Connor</option>
               <option value="8">Zinhle Z. Mthembu</option>
               <option value="9">Willem W. Botha</option>
               <option value="10">Nomsa N. Tshabalala</option>
               <option value="11">Raj R. Singh</option>
               <option value="12">Emma E. van Wyk</option>
               <option value="13">Sibusiso S. Ngcobo</option>
               <option value="14">Charmaine C. Pillay</option>
               <option value="15">Themba T. Maseko</option>
               <option value="23">Sibusiso eryery. Montgomery</option>
               <option value="24">John2 ey. Montgomery</option>
               <option value="25">John2 y ery. Montgomery3</option>
               <option value="35">Peter P.J. Wessels</option>
               <option value="36">Peter 2 P.J. Wessels2</option>
               <option value="37">Comm Nume. Wessels</option>
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
               <option value="1">Michael M. van der Berg</option>
               <option value="2">Thandi T. Nkosi</option>
               <option value="3">Rajesh R. Patel</option>
               <option value="4">Lerato L. Moloi</option>
               <option value="5">Johannes J. Pretorius</option>
               <option value="6">Nomvula N. Dlamini</option>
               <option value="7">David D. O'Connor</option>
               <option value="8">Zanele Z. Mthembu</option>
               <option value="9">Pieter P. van Zyl</option>
               <option value="10">Fatima F. Ismail</option>
               <option value="11">Sipho S. Ndlovu</option>
               <option value="12">Anita A. van Rensburg</option>
               <option value="13">Themba T. Mkhize</option>
               <option value="14">Sarah S. Botha</option>
               <option value="15">Lwazi L. Zuma</option>
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
<!-- JavaScript to toggle Exam Type field based on Exam Class selection and handle Bootstrap validation -->
<script>
   document.getElementById('exam_class').addEventListener('change', function() {
     var examTypeContainer = document.getElementById('exam_type_container');
     if (this.value === 'Yes') {
       examTypeContainer.style.display = 'block';
       document.getElementById('exam_type').setAttribute('required', 'required');
     } else {
       examTypeContainer.style.display = 'none';
       document.getElementById('exam_type').removeAttribute('required');
     }
   });

   // Bootstrap custom validation example
   (function () {
     'use strict'
     var forms = document.querySelectorAll('.needs-validation')
     Array.prototype.slice.call(forms)
       .forEach(function (form) {
         form.addEventListener('submit', function (event) {
           // Make sure the modal is closed before submission
           if (typeof closeModal === 'function') {
             closeModal();
           }

           // Update calendar data before validation
           if (typeof updateHiddenFields === 'function') {
             updateHiddenFields();
           }

           if (!form.checkValidity()) {
             event.preventDefault()
             event.stopPropagation()
           } else {
             console.log('Form is valid, submitting with calendar data');
             console.log('Hidden fields:', $('#schedule-data-container').html());

             // Final check to ensure we have calendar data
             if ($('#schedule-data-container').children().length === 0) {
               console.warn('No calendar events found before submission. Attempting to update hidden fields again.');
               if (typeof updateHiddenFields === 'function') {
                 updateHiddenFields();
               }
             }
           }
           form.classList.add('was-validated')
         }, false)
       })
   })();
</script>
<script>
   jQuery(document).ready(function($) {

     // 1) Define addresses for each site option value
     var siteAddresses = {
       // Aspen Pharmacare
       "11_1": "Aspen Pharmacare - Head Office, 100 Pharma Rd, Durban, 4001",
       "11_2": "Aspen Pharmacare - Production Unit, 101 Pharma Rd, Durban, 4001",
       "11_3": "Aspen Pharmacare - Research Centre, 102 Pharma Rd, Durban, 4001",

       // Barloworld
       "14_1": "Barloworld - Northern Branch, 10 Northern Ave, Johannesburg, 2001",
       "14_2": "Barloworld - Southern Branch, 20 Southern St, Johannesburg, 2002",
       "14_3": "Barloworld - Central Branch, 30 Central Blvd, Johannesburg, 2003",

       // Bidvest Group
       "9_1":  "Bidvest Group - Logistics Hub, 50 Transport Ln, Sandton, 2196",
       "9_2":  "Bidvest Group - Corporate Office, 51 Finance St, Sandton, 2196",
       "9_3":  "Bidvest Group - Industrial Park, 52 Warehouse Rd, Sandton, 2196",

       // FirstRand
       "8_1":  "FirstRand - Main Office, 1 Banking Pl, Johannesburg, 2000",
       "8_2":  "FirstRand - Regional Office, 2 Banking Pl, Pretoria, 0002",
       "8_3":  "FirstRand - Satellite Office, 3 Banking Pl, Durban, 4000",

       // MTN Group
       "4_1":  "MTN Group - Midrand, 14 Telecom Blvd, Midrand, 1682",
       "4_2":  "MTN Group - Cape Town, 15 Telecom Blvd, Cape Town, 8000",
       "4_3":  "MTN Group - Johannesburg, 16 Telecom Blvd, Johannesburg, 2001",

       // Multichoice Group
       "15_1": "Multichoice Group - Head Office, 123 Media Rd, Randburg, 2194",
       "15_2": "Multichoice Group - Studio Complex, 124 Media Rd, Randburg, 2194",
       "15_3": "Multichoice Group - Satellite Office, 125 Media Rd, Randburg, 2194",

       // Naspers
       "5_1":  "Naspers - Digital Hub, 99 Tech St, Cape Town, 8001",
       "5_2":  "Naspers - Corporate Centre, 100 Tech St, Cape Town, 8001",
       "5_3":  "Naspers - Innovation Lab, 101 Tech St, Cape Town, 8001",

       // Nedbank Group
       "12_1": "Nedbank Group - Downtown Branch, 201 Bank Ln, Cape Town, 8001",
       "12_2": "Nedbank Group - Uptown Office, 202 Bank Ln, Cape Town, 8001",
       "12_3": "Nedbank Group - Financial District, 203 Bank Ln, Cape Town, 8001",

       // Sanlam
       "10_1": "Sanlam - Main Branch, 10 Finance Rd, Bellville, 7530",
       "10_2": "Sanlam - Regional Office, 11 Finance Rd, Bellville, 7530",
       "10_3": "Sanlam - International Office, 12 Finance Rd, Bellville, 7530",

       // Sasol Limited
       "1_1":  "Sasol Limited - Industrial Park, 1 Chemical Dr, Secunda, 2302",
       "1_2":  "Sasol Limited - R&D Centre, 2 Chemical Dr, Secunda, 2302",
       "1_3":  "Sasol Limited - Corporate Office, 3 Chemical Dr, Secunda, 2302",

       // Shoprite Holdings
       "3_1":  "Shoprite Holdings - Distribution Centre, 1 Grocery Ln, Brackenfell, 7560",
       "3_2":  "Shoprite Holdings - Corporate Office, 2 Grocery Ln, Brackenfell, 7560",
       "3_3":  "Shoprite Holdings - Outlet, 3 Grocery Ln, Brackenfell, 7560",

       // Standard Bank Group
       "2_1":  "Standard Bank Group - Head Office, 10 Bank St, Johannesburg, 2001",
       "2_2":  "Standard Bank Group - Branch Office, 11 Bank St, Pretoria, 0002",
       "2_3":  "Standard Bank Group - Digital Office, 12 Bank St, Durban, 4001",

       // Tiger Brands
       "13_1": "Tiger Brands - Manufacturing Unit, 1 Food Dr, Bryanston, 2191",
       "13_2": "Tiger Brands - Distribution Hub, 2 Food Dr, Bryanston, 2191",
       "13_3": "Tiger Brands - Corporate Office, 3 Food Dr, Bryanston, 2191",

       // Vodacom Group
       "6_1":  "Vodacom Group - Data Centre, 20 Telecom Pl, Midrand, 1685",
       "6_2":  "Vodacom Group - Tech Hub, 21 Telecom Pl, Midrand, 1685",
       "6_3":  "Vodacom Group - Service Centre, 22 Telecom Pl, Midrand, 1685",

       // Woolworths Holdings
       "7_1":  "Woolworths Holdings - Retail Hub, 1 Fashion Rd, Cape Town, 8000",
       "7_2":  "Woolworths Holdings - Distribution Centre, 2 Fashion Rd, Cape Town, 8000",
       "7_3":  "Woolworths Holdings - Corporate Office, 3 Fashion Rd, Cape Town, 8000"
     };

     // 2) On change of the select, look up the address and show/hide accordingly
     $("#site_id").on("change", function() {
       var selectedValue = $(this).val();
       var $addressWrapper = $("#address-wrapper");
       var $addressInput   = $("#site_address");

       // If there's a matching address, populate and show
       if (siteAddresses[selectedValue]) {
         $addressInput.val(siteAddresses[selectedValue]);
         $addressWrapper.show();
       } else {
         // Otherwise clear and hide
         $addressInput.val("");
         $addressWrapper.hide();
       }
     });

   });
</script>


<script>
   jQuery(document).ready(function($) {
     // 1. Generate 30-min increments from 6:00 AM to 8:00 PM
     function generateTimeOptions() {
       let optionsHTML = '';
       for (let hour = 6; hour <= 20; hour++) {
         for (let min = 0; min < 60; min += 30) {
           let label = formatTime(hour, min);  // e.g. "6:00 AM", "6:30 AM", etc.
           optionsHTML += '<option value="' + label + '">' + label + '</option>';
         }
       }
       return optionsHTML;
     }

     // 2. Helper function to format times in 12-hour format
     function formatTime(hour24, minute) {
       let period = (hour24 < 12) ? 'AM' : 'PM';
       let hour12 = hour24 % 12;
       hour12 = (hour12 === 0) ? 12 : hour12; // 0 => 12 AM
       let minuteStr = minute < 10 ? '0' + minute : minute;
       return hour12 + ':' + minuteStr + ' ' + period;
     }

     // 3. Helper function to convert 12-hour format to 24-hour format
     function convertTo24Hour(time12h) {
       const [time, modifier] = time12h.split(' ');
       let [hours, minutes] = time.split(':');

       if (hours === '12') {
         hours = '00';
       }

       if (modifier === 'PM') {
         hours = parseInt(hours, 10) + 12;
       }

       return `${hours}:${minutes}`;
     }

     // 4. Helper function to get day of week from date
     function getDayOfWeek(date) {
       const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
       return days[date.getDay()];
     }

     // 5. Helper function to format date as YYYY-MM-DD
     function formatDate(date) {
       const d = new Date(date);
       let month = '' + (d.getMonth() + 1);
       let day = '' + d.getDate();
       const year = d.getFullYear();

       if (month.length < 2) month = '0' + month;
       if (day.length < 2) day = '0' + day;

       return [year, month, day].join('-');
     }

     // 6. Helper function to combine date and time
     function combineDateTime(dateStr, timeStr) {
       const date = new Date(dateStr + 'T' + convertTo24Hour(timeStr) + ':00');
       return date;
     }

     // Populate time dropdowns in the modal
     const timeOptions = generateTimeOptions();
     $('#eventStartTime').html(timeOptions);
     $('#eventEndTime').html(timeOptions);

     // Initialize FullCalendar
     const calendarEl = document.getElementById('class-calendar');
     const calendar = new FullCalendar.Calendar(calendarEl, {
       initialView: 'timeGridWeek',
       headerToolbar: {
         left: 'prev,next today',
         center: 'title',
         right: 'dayGridMonth,timeGridWeek,timeGridDay'
       },
       height: 500,
       allDaySlot: false,
       slotMinTime: '06:00:00',
       slotMaxTime: '20:00:00',
       slotDuration: '00:30:00',
       editable: true,
       selectable: true,
       selectMirror: true,
       dayMaxEvents: true,
       businessHours: {
         daysOfWeek: [1, 2, 3, 4, 5], // Monday - Friday
         startTime: '08:00',
         endTime: '17:00',
       },
       eventClassNames: function(arg) {
         // Add custom classes based on event type
         return ['event-type-' + arg.event.extendedProps.type];
       },
       select: function(arg) {
         // Open modal for new event
         const startDate = formatDate(arg.start);
         const endDate = formatDate(arg.end);
         const dayOfWeek = getDayOfWeek(arg.start);

         // Set default values in the form
         $('#eventId').val(''); // New event
         $('#eventType').val('class');
         $('#eventDescription').val('');
         $('#eventDate').val(startDate);
         $('#eventDay').val(dayOfWeek);

         // Set times based on selection
         const startHour = arg.start.getHours();
         const startMinute = arg.start.getMinutes();
         const endHour = arg.end.getHours();
         const endMinute = arg.end.getMinutes();

         const startTime = formatTime(startHour, startMinute);
         const endTime = formatTime(endHour, endMinute);

         $('#eventStartTime').val(startTime);
         $('#eventEndTime').val(endTime);

         // Show the modal using JavaScript instead of Bootstrap's modal method
         const modal = document.getElementById('eventModal');
         modal.style.display = 'block';
         modal.classList.add('show');
         document.body.classList.add('modal-open');

         // Create backdrop if it doesn't exist
         if (!document.querySelector('.modal-backdrop')) {
           const backdrop = document.createElement('div');
           backdrop.className = 'modal-backdrop fade show';
           document.body.appendChild(backdrop);
         }
       },
       eventClick: function(arg) {
         // Open modal with existing event data
         const event = arg.event;
         const dayOfWeek = event.extendedProps.day || getDayOfWeek(event.start);

         $('#eventId').val(event.id);
         $('#eventType').val(event.extendedProps.type || 'class');
         $('#eventDescription').val(event.title);
         $('#eventDate').val(formatDate(event.start));
         $('#eventDay').val(dayOfWeek);

         // Format times for the dropdowns
         const startHour = event.start.getHours();
         const startMinute = event.start.getMinutes();
         const endHour = event.end.getHours();
         const endMinute = event.end.getMinutes();

         const startTime = formatTime(startHour, startMinute);
         const endTime = formatTime(endHour, endMinute);

         $('#eventStartTime').val(startTime);
         $('#eventEndTime').val(endTime);

         // Show the modal using JavaScript instead of Bootstrap's modal method
         const modal = document.getElementById('eventModal');
         modal.style.display = 'block';
         modal.classList.add('show');
         document.body.classList.add('modal-open');

         // Create backdrop if it doesn't exist
         if (!document.querySelector('.modal-backdrop')) {
           const backdrop = document.createElement('div');
           backdrop.className = 'modal-backdrop fade show';
           document.body.appendChild(backdrop);
         }
       },
       eventDrop: function(arg) {
         updateHiddenFields();
       },
       eventResize: function(arg) {
         updateHiddenFields();
       }
     });

     calendar.render();

     // Initialize hidden fields
     updateHiddenFields();

     // Add event listener for calendar changes
     calendar.on('eventChange', function() {
       updateHiddenFields();
     });

     // Function to close modal properly
     function closeModal() {
       const modal = document.getElementById('eventModal');
       modal.style.display = 'none';
       modal.classList.remove('show');
       document.body.classList.remove('modal-open');

       // Remove backdrop
       const backdrop = document.querySelector('.modal-backdrop');
       if (backdrop) {
         backdrop.parentNode.removeChild(backdrop);
       }
     }



     // Close button handler
     $('#closeModalBtn, #cancelEvent').on('click', function() {
       closeModal();
     });

     // Save event handler
     $('#saveEvent').on('click', function() {
       const eventId = $('#eventId').val();
       const eventType = $('#eventType').val();
       const description = $('#eventDescription').val();
       const eventDate = $('#eventDate').val();
       const eventDay = $('#eventDay').val();
       const startTime = $('#eventStartTime').val();
       const endTime = $('#eventEndTime').val();

       // Validate form
       if (!description || !eventDate || !startTime || !endTime) {
         alert('Please fill in all required fields');
         return;
       }

       try {
         // Create event object
         const eventData = {
           id: eventId || Date.now().toString(), // Use timestamp as ID for new events
           title: description,
           start: combineDateTime(eventDate, startTime),
           end: combineDateTime(eventDate, endTime),
           extendedProps: {
             type: eventType,
             day: eventDay
           }
         };

         // If editing an existing event, remove the old one
         if (eventId) {
           const existingEvent = calendar.getEventById(eventId);
           if (existingEvent) {
             existingEvent.remove();
           }
         }

         // Add the event to the calendar
         calendar.addEvent(eventData);

         // Update hidden fields
         updateHiddenFields();

         // Close modal
         closeModal();

         // Log success for debugging
         console.log('Event saved successfully:', eventData);
         console.log('Calendar events after save:', calendar.getEvents());
       } catch (error) {
         console.error('Error saving event:', error);
         alert('There was an error saving the event. Please try again.');
       }
     });

     // Delete event handler
     $('#deleteEvent').on('click', function() {
       const eventId = $('#eventId').val();

       if (eventId) {
         try {
           // Remove the event from the calendar
           const existingEvent = calendar.getEventById(eventId);
           if (existingEvent) {
             existingEvent.remove();
           }

           // Update hidden fields
           updateHiddenFields();

           // Close modal
           closeModal();

           console.log('Event deleted successfully');
           console.log('Calendar events after delete:', calendar.getEvents());
         } catch (error) {
           console.error('Error deleting event:', error);
           alert('There was an error deleting the event. Please try again.');
         }
       } else {
         // Just close the modal if there's no event to delete
         closeModal();
       }
     });

     // Update hidden fields with calendar data
     function updateHiddenFields() {
       try {
         const events = calendar.getEvents();
         const scheduleContainer = $('#schedule-data-container');

         // Clear existing hidden fields
         scheduleContainer.empty();

         console.log('Updating hidden fields with events:', events);

         // Create hidden fields for each event
         events.forEach(function(event, index) {
           if (!event.start || !event.end) {
             console.error('Event missing start or end time:', event);
             return;
           }

           const startDate = formatDate(event.start);
           const startHour = event.start.getHours();
           const startMinute = event.start.getMinutes();
           const endHour = event.end.getHours();
           const endMinute = event.end.getMinutes();

           const startTime = formatTime(startHour, startMinute);
           const endTime = formatTime(endHour, endMinute);

           // Get day from extendedProps or calculate it
           const day = event.extendedProps && event.extendedProps.day ?
                      event.extendedProps.day :
                      getDayOfWeek(event.start);

           // Get type from extendedProps or default to 'class'
           const type = event.extendedProps && event.extendedProps.type ?
                       event.extendedProps.type :
                       'class';

           // Create hidden inputs with the same names as the original form
           scheduleContainer.append(`<input type="hidden" name="schedule_day[]" value="${day}">`);
           scheduleContainer.append(`<input type="hidden" name="schedule_date[]" value="${startDate}">`);
           scheduleContainer.append(`<input type="hidden" name="start_time[]" value="${startTime}">`);
           scheduleContainer.append(`<input type="hidden" name="end_time[]" value="${endTime}">`);
           scheduleContainer.append(`<input type="hidden" name="schedule_notes[]" value="${event.title}">`);
           scheduleContainer.append(`<input type="hidden" name="event_type[]" value="${type}">`);

           console.log('Added hidden fields for event:', {
             day: day,
             date: startDate,
             startTime: startTime,
             endTime: endTime,
             title: event.title,
             type: type
           });
         });

         // Add a debug message to show the number of events processed
         console.log(`Updated hidden fields for ${events.length} events`);
       } catch (error) {
         console.error('Error updating hidden fields:', error);
       }
     }

     // ===== Date History Functionality =====
     // References to the date history template & container
     const $dateHistoryTemplate = $('#date-history-row-template');
     const $dateHistoryContainer = $('#date-history-container');

     // Function to add a new date history row
     function addDateHistoryRow() {
       // Clone the template
       let $newRow = $dateHistoryTemplate.clone(true);

       // Make it visible & remove the template ID
       $newRow.removeClass('d-none').removeAttr('id');

       // Clear any existing values
       $newRow.find('input[name="stop_dates[]"]').val('');
       $newRow.find('input[name="restart_dates[]"]').val('');

       // Attach remove-row handler
       $newRow.find('.remove-date-row-btn').on('click', function() {
         $(this).closest('.date-history-row').remove();
       });

       // Append the new row to the container
       $dateHistoryContainer.append($newRow);
     }

     // Click handler to add new date history rows
     $('#add-date-history-btn').on('click', function() {
       addDateHistoryRow();
     });
   });
</script>
<?php
return ob_get_clean();
}
add_shortcode('wecoza_capture_class', 'wecoza_classes_capture_shortcode');