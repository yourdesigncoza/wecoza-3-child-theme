<?php
   function wecoza_classes_capture_shortcode() {
       ob_start();
       ?>
<!-- Classes Capture Form -->
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
         <!-- Container for all schedule rows -->
         <div id="schedule-container"></div>
         <!-- Hidden Template Row (initially d-none) -->
         <div class="row schedule-row d-none" id="schedule-row-template">
            <!-- Day -->
            <div class="col-md-2 mb-2">
               <label class="form-label fw-bold">Class Schedule <span class="text-danger">*</span></label>
               <select name="schedule_day[]" class="form-select form-select-sm" required>
                  <option value="">Select Day</option>
                  <option value="Monday">Monday</option>
                  <option value="Tuesday">Tuesday</option>
                  <option value="Wednesday">Wednesday</option>
                  <option value="Thursday">Thursday</option>
                  <option value="Friday">Friday</option>
                  <option value="Saturday">Saturday</option>
                  <option value="Sunday">Sunday</option>
               </select>
               <div class="invalid-feedback">Please select a day.</div>
            </div>
            <!-- Start Time -->
            <div class="col-md-2 mb-2">
               <label class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
               <select name="start_time[]" class="form-select form-select-sm start-time" required>
                  <!-- We will populate these options via jQuery -->
               </select>
               <div class="invalid-feedback">Please select a start time.</div>
            </div>
            <!-- End Time -->
            <div class="col-md-2 mb-2">
               <label class="form-label fw-bold">End Time <span class="text-danger">*</span></label>
               <select name="end_time[]" class="form-select form-select-sm end-time" required>
                  <!-- We will populate these options via jQuery -->
               </select>
               <div class="invalid-feedback">Please select an end time.</div>
            </div>

           <div class="col-md-2 mb-2">
             <label class="form-label fw-bold">Status</label>
             <select name="slot_status[]" class="form-select form-select-sm">
               <option value="">Select Status</option>
               <option value="Normal">Normal</option>
               <option value="Cancelled">Cancelled</option>
               <option value="Agent Absent">Agent Absent</option>
               <option value="Exam">Exam</option>
               <!-- Add more statuses as needed -->
             </select>
           </div>

            <!-- Training Schedule -->
            <div class="col-md-3">
               <label for="schedule_notes" class="form-label">Notes/Activities <span class="text-danger">*</span></label>
               <textarea id="schedule_notes" name="schedule_notes[]" class="form-control form-control-sm" style="height:50px" placeholder="Add notes ..." required></textarea>
               <div class="invalid-feedback">Please provide the training schedule.</div>
               <div class="valid-feedback">Looks good!</div>
            </div>
            <!-- Remove Button -->
            <div class="col-md-1 mb-2 mt-8">
               <button type="button" class="btn btn-outline-danger btn-sm remove-row-btn">Remove</button>
            </div>
         </div>
         <!-- Add Row Button -->
         <button type="button" class="btn btn-outline-primary btn-sm" id="add-schedule-row-btn">
         + Add Day/Time
         </button>
      </div>
      <div class="border-top border-opacity-25 border-3 border-discovery my-5 mx-1"></div>
      <!-- ===== Section: Scheduling & Class Info ===== -->
      <div class="row mt-3">
         <!-- Class Type -->
         <div class="col-md-4">
            <label for="class_type" class="form-label">Class Type <span class="text-danger">*</span></label>
            <select id="class_type" name="class_type" class="form-select form-select-sm" required>
               <option value="">Select</option>
               <option value="Employed">Employed</option>
               <option value="Community">Community</option>
               <option value="Package">Package</option>
               <option value="Joiner">Joiner</option>
            </select>
            <div class="invalid-feedback">Please select the class type.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
         <!-- Class Status -->
         <div class="col-md-4">
            <label for="class_status" class="form-label">Class Status <span class="text-danger">*</span></label>
            <select id="class_status" name="class_status" class="form-select form-select-sm" required>
               <option value="">Select</option>
               <option value="New">New</option>
               <option value="Restarted">Restarted</option>
               <option value="Stopped">Stopped</option>
            </select>
            <div class="invalid-feedback">Please select the class status.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
         <!-- Class Original Start Date -->
         <div class="col-md-4">
            <label for="class_start_date" class="form-label">Class Original Start Date <span class="text-danger">*</span></label>
            <input type="date" id="class_start_date" name="class_start_date" class="form-control form-control-sm" required>
            <div class="invalid-feedback">Please select the start date.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
      </div>
      <div class="row mt-3">
         <!-- Class Stop Date -->
         <div class="col-md-4">
            <label for="class_stop_date" class="form-label">Class Stop Date <span class="text-danger">*</span></label>
            <input type="date" id="class_stop_date" name="class_stop_date" class="form-control form-control-sm" required>
            <div class="invalid-feedback">Please select the stop date.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
         <!-- Class Restart Date (if applicable) -->
         <div class="col-md-4">
            <label for="class_restart_date" class="form-label">Class Restart Date</label>
            <input type="date" id="class_restart_date" name="class_restart_date" class="form-control form-control-sm">
            <div class="invalid-feedback">Please select the restart date.</div>
            <div class="valid-feedback">Looks good!</div>
         </div>
         <!-- Class Subjects (Multi-select) -->
         <div class="col-md-4">
            <label for="course_id" class="form-label">Class Subjects <span class="text-danger">*</span></label>
            <select id="course_id" name="course_id[]" class="form-select form-select-sm" size="2" multiple required>
               <option value="CL1b">AET Communication level 1 Basic</option>
               <option value="CL1">AET Communication level 1</option>
               <option value="CL2">AET Communication level 2</option>
               <option value="CL3">AET Communication level 3</option>
               <option value="CL4">AET Communication level 4</option>
               <option value="NL1B">AET Numeracy level 1 Basic</option>
               <option value="NL1">AET Numeracy level 1</option>
               <option value="NL2">AET Numeracy level 2</option>
               <option value="NL3">AET Numeracy level 3</option>
               <option value="NL4">AET Numeracy level 4</option>
               <option value="LO4">AET level 4 Life Orientation</option>
               <option value="HSS4">AET level 4 Human & Social Sciences</option>
               <option value="EMS4">AET level 4 Economic & Management Sciences</option>
               <option value="NS4">AET level 4 Natural Sciences</option>
               <option value="SMME4">AET level 4 Small Micro Medium Enterprises</option>
               <option value="RLC">REALLL Communication</option>
               <option value="RLN">REALLL Numeracy</option>
               <option value="RLF">REALLL Finance</option>
               <option value="BA2LP1">Business Admin NQF 2 - LP1</option>
               <!-- Additional options omitted for brevity -->
            </select>
            <div class="invalid-feedback">Please select at least one subject.</div>
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
           if (!form.checkValidity()) {
             event.preventDefault()
             event.stopPropagation()
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
   
     // Pre-generate the time options for efficiency
     const timeOptions = generateTimeOptions();
   
     // 3. References to the template & container
     const $templateRow = $('#schedule-row-template');
     const $container = $('#schedule-container');
   
     // 4. Function to add a new row
     function addScheduleRow() {
       // Clone the template
       let $newRow = $templateRow.clone(true);
   
       // Make it visible & remove the template ID
       $newRow.removeClass('d-none').removeAttr('id');
   
       // Clear any existing values
       $newRow.find('select[name="schedule_day[]"]').val('');
       
       // Populate the time selects with the generated 30-min increments
       $newRow.find('.start-time').html(timeOptions).val('');
       $newRow.find('.end-time').html(timeOptions).val('');
   
       // Attach remove-row handler
       $newRow.find('.remove-row-btn').on('click', function() {
         $(this).closest('.schedule-row').remove();
       });
   
       // Append the new row to the container
       $container.append($newRow);
     }
   
     // 5. Click handler to add new rows
     $('#add-schedule-row-btn').on('click', function() {
       addScheduleRow();
     });
   
     // Optionally, add the first row automatically on page load
     addScheduleRow();
   });
</script>
<?php
return ob_get_clean();
}
add_shortcode('wecoza_capture_class', 'wecoza_classes_capture_shortcode');