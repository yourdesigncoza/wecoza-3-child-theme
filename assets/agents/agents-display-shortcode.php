<?php
/**
 * Display agents shortcode functionality
 *
 * @deprecated 1.0.0 This file has been moved to the WeCoza Agents Plugin.
 *                   Please remove this file after confirming the plugin is active.
 */

// Deprecation notice
_deprecated_file( 
    basename(__FILE__), 
    '1.0.0', 
    'WeCoza Agents Plugin', 
    'This functionality has been moved to the WeCoza Agents Plugin. Please activate the plugin and remove this theme file.'
);

// Only execute if plugin is not active
if (!defined('WECOZA_AGENTS_VERSION')) {

   function wecoza_display_agents_shortcode() {
       ob_start();
       ?>
<!-- Alert Container -->
<div id="alert-container" class="alert-container"></div>
<!-- Loader -->
<div id="wecoza-agents-loader-container">
   <button id="wecoza-loader-02" class="btn btn-primary mt-7" type="button">
   <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
   Loading...
   </button>
</div>
<!-- Main Content Container -->
<div id="agents-container">
   <div class="table-responsive">
      <div class="bootstrap-table bootstrap5">
         <div class="fixed-table-toolbar">
            <div class="columns columns-right btn-group float-right">
               <button class="btn btn-secondary" type="button" name="refresh" aria-label="Refresh" title="Refresh">
               <i class="bi bi-arrow-clockwise"></i>
               </button>
               <div class="keep-open btn-group">
                  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-label="Columns" title="Columns">
                  <i class="bi bi-list-ul"></i>
                  <span class="caret"></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                     <label class="dropdown-item dropdown-item-marker"><input type="checkbox" data-field="0" value="0" checked="checked"> <span>First Name</span></label>
                     <label class="dropdown-item dropdown-item-marker"><input type="checkbox" data-field="1" value="1" checked="checked"> <span>Initials</span></label>
                     <label class="dropdown-item dropdown-item-marker"><input type="checkbox" data-field="2" value="2" checked="checked"> <span>Surname</span></label>
                     <label class="dropdown-item dropdown-item-marker"><input type="checkbox" data-field="3" value="3" checked="checked"> <span>Gender</span></label>
                     <label class="dropdown-item dropdown-item-marker"><input type="checkbox" data-field="4" value="4" checked="checked"> <span>Race</span></label>
                     <label class="dropdown-item dropdown-item-marker"><input type="checkbox" data-field="5" value="5" checked="checked"> <span>Tel Number</span></label>
                     <label class="dropdown-item dropdown-item-marker"><input type="checkbox" data-field="6" value="6" checked="checked"> <span>Email Address</span></label>
                     <label class="dropdown-item dropdown-item-marker"><input type="checkbox" data-field="7" value="7" checked="checked"> <span>City/Town</span></label>
                     <label class="dropdown-item dropdown-item-marker"><input type="checkbox" data-field="8" value="8" checked="checked"> <span>Actions</span></label>
                  </div>
               </div>
            </div>
            <div class="float-right search btn-group">
               <input class="form-control search-input" type="search" aria-label="Search" placeholder="Search" autocomplete="off">
            </div>
         </div>
         <div class="fixed-table-container" style="padding-bottom: 0px;">
            <div class="fixed-table-header" style="display: none;">
               <table></table>
            </div>
            <div class="fixed-table-body">
               <div class="fixed-table-loading table table-bordered table-hover borderless-table" style="top: 1px;">
                  <span class="loading-wrap">
                  <span class="loading-text">Loading, please wait</span>
                  <span class="animation-wrap"><span class="animation-dot"></span></span>
                  </span>
               </div>
               <table id="agents-display-data" class="table table-bordered ydcoza-compact-table table-hover borderless-table">
                  <thead>
                     <tr>
                        <th data-field="0">
                           <div class="th-inner sortable both">First Name</div>
                           <div class="fht-cell"></div>
                        </th>
                        <th data-field="1">
                           <div class="th-inner sortable both">Initials</div>
                           <div class="fht-cell"></div>
                        </th>
                        <th data-field="2">
                           <div class="th-inner sortable both">Surname</div>
                           <div class="fht-cell"></div>
                        </th>
                        <th data-field="3">
                           <div class="th-inner sortable both">Gender</div>
                           <div class="fht-cell"></div>
                        </th>
                        <th data-field="4">
                           <div class="th-inner sortable both">Race</div>
                           <div class="fht-cell"></div>
                        </th>
                        <th data-field="5">
                           <div class="th-inner sortable both">Tel Number</div>
                           <div class="fht-cell"></div>
                        </th>
                        <th data-field="6">
                           <div class="th-inner sortable both">Email Address</div>
                           <div class="fht-cell"></div>
                        </th>
                        <th data-field="7">
                           <div class="th-inner sortable both">City/Town</div>
                           <div class="fht-cell"></div>
                        </th>
                        <th class="text-nowrap text-center ydcoza-width-150" data-field="8">
                           <div class="th-inner">Actions</div>
                           <div class="fht-cell"></div>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr data-index="0">
                        <td>Peter</td>
                        <td>P.</td>
                        <td>Wessels</td>
                        <td>Male</td>
                        <td>White</td>
                        <td>0123456789</td>
                        <td>peter.w@example.com</td>
                        <td>Cape Town</td>
                        <td class="text-nowrap text-center ydcoza-width-150">
                           <div class="btn-group btn-group-sm" role="group">
                              <!-- <button type="button" class="btn bg-discovery-subtle view-details" data-id="1">View</button>
                                 <button class="btn bg-discovery-subtle view-details" data-bs-toggle="modal" data-bs-target="#agentModal" data-id="1">View</button> -->
                              <button class="btn bg-discovery-subtle" data-bs-toggle="modal" data-bs-target="#agentModal">View</button>
                              <a href="#?agent_id=1" class="btn bg-warning-subtle">Edit</a>
                              <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="1">Delete</button>
                           </div>
                        </td>
                     </tr>
                     <tr data-index="1">
                        <td>Sarah</td>
                        <td>S.</td>
                        <td>Johnson</td>
                        <td>Female</td>
                        <td>African</td>
                        <td>0987654321</td>
                        <td>sarah.j@example.com</td>
                        <td>Johannesburg</td>
                        <td class="text-nowrap text-center ydcoza-width-150">
                           <div class="btn-group btn-group-sm" role="group">
                              <button class="btn bg-discovery-subtle" data-bs-toggle="modal" data-bs-target="#agentModal">View</button>
                              <a href="#?agent_id=2" class="btn bg-warning-subtle">Edit</a>
                              <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="2">Delete</button>
                           </div>
                        </td>
                     </tr>
                     <tr data-index="2">
                        <td>David</td>
                        <td>D.</td>
                        <td>Smith</td>
                        <td>Male</td>
                        <td>Coloured</td>
                        <td>0212223344</td>
                        <td>david.s@example.com</td>
                        <td>Durban</td>
                        <td class="text-nowrap text-center ydcoza-width-150">
                           <div class="btn-group btn-group-sm" role="group">
                              <button class="btn bg-discovery-subtle" data-bs-toggle="modal" data-bs-target="#agentModal">View</button>
                              <a href="#?agent_id=3" class="btn bg-warning-subtle">Edit</a>
                              <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="3">Delete</button>
                           </div>
                        </td>
                     </tr>
                     <tr data-index="3">
                        <td>Maria</td>
                        <td>M.</td>
                        <td>Garcia</td>
                        <td>Female</td>
                        <td>Indian</td>
                        <td>0334455667</td>
                        <td>maria.g@example.com</td>
                        <td>Pretoria</td>
                        <td class="text-nowrap text-center ydcoza-width-150">
                           <div class="btn-group btn-group-sm" role="group">
                              <button class="btn bg-discovery-subtle" data-bs-toggle="modal" data-bs-target="#agentModal">View</button>
                              <a href="#?agent_id=4" class="btn bg-warning-subtle">Edit</a>
                              <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="4">Delete</button>
                           </div>
                        </td>
                     </tr>
                     <tr data-index="4">
                        <td>John</td>
                        <td>J.</td>
                        <td>Doe</td>
                        <td>Male</td>
                        <td>White</td>
                        <td>0112233445</td>
                        <td>john.d@example.com</td>
                        <td>Bloemfontein</td>
                        <td class="text-nowrap text-center ydcoza-width-150">
                           <div class="btn-group btn-group-sm" role="group">
                              <button class="btn bg-discovery-subtle" data-bs-toggle="modal" data-bs-target="#agentModal">View</button>
                              <a href="#?agent_id=5" class="btn bg-warning-subtle">Edit</a>
                              <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="5">Delete</button>
                           </div>
                        </td>
                     </tr>
                     <tr data-index="5">
                        <td>Emily</td>
                        <td>E.</td>
                        <td>Davis</td>
                        <td>Female</td>
                        <td>African</td>
                        <td>0445566778</td>
                        <td>emily.d@example.com</td>
                        <td>Port Elizabeth</td>
                        <td class="text-nowrap text-center ydcoza-width-150">
                           <div class="btn-group btn-group-sm" role="group">
                              <button class="btn bg-discovery-subtle" data-bs-toggle="modal" data-bs-target="#agentModal">View</button>
                              <a href="#?agent_id=6" class="btn bg-warning-subtle">Edit</a>
                              <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="6">Delete</button>
                           </div>
                        </td>
                     </tr>
                     <tr data-index="6">
                        <td>Michael</td>
                        <td>M.</td>
                        <td>Brown</td>
                        <td>Male</td>
                        <td>Coloured</td>
                        <td>0556677889</td>
                        <td>michael.b@example.com</td>
                        <td>East London</td>
                        <td class="text-nowrap text-center ydcoza-width-150">
                           <div class="btn-group btn-group-sm" role="group">
                              <button class="btn bg-discovery-subtle" data-bs-toggle="modal" data-bs-target="#agentModal">View</button>
                              <a href="#?agent_id=7" class="btn bg-warning-subtle">Edit</a>
                              <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="7">Delete</button>
                           </div>
                        </td>
                     </tr>
                     <tr data-index="7">
                        <td>Linda</td>
                        <td>L.</td>
                        <td>Taylor</td>
                        <td>Female</td>
                        <td>Indian</td>
                        <td>0667788990</td>
                        <td>linda.t@example.com</td>
                        <td>Kimberley</td>
                        <td class="text-nowrap text-center ydcoza-width-150">
                           <div class="btn-group btn-group-sm" role="group">
                              <button class="btn bg-discovery-subtle" data-bs-toggle="modal" data-bs-target="#agentModal">View</button>
                              <a href="#?agent_id=8" class="btn bg-warning-subtle">Edit</a>
                              <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="8">Delete</button>
                           </div>
                        </td>
                     </tr>
                     <tr data-index="8">
                        <td>Robert</td>
                        <td>R.</td>
                        <td>Wilson</td>
                        <td>Male</td>
                        <td>White</td>
                        <td>0778899001</td>
                        <td>robert.w@example.com</td>
                        <td>Polokwane</td>
                        <td class="text-nowrap text-center ydcoza-width-150">
                           <div class="btn-group btn-group-sm" role="group">
                              <button class="btn bg-discovery-subtle" data-bs-toggle="modal" data-bs-target="#agentModal">View</button>
                              <a href="#?agent_id=9" class="btn bg-warning-subtle">Edit</a>
                              <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="9">Delete</button>
                           </div>
                        </td>
                     </tr>
                     <tr data-index="9">
                        <td>Jessica</td>
                        <td>J.</td>
                        <td>Lee</td>
                        <td>Female</td>
                        <td>African</td>
                        <td>0889900112</td>
                        <td>jessica.l@example.com</td>
                        <td>Nelspruit</td>
                        <td class="text-nowrap text-center ydcoza-width-150">
                           <div class="btn-group btn-group-sm" role="group">
                              <button class="btn bg-discovery-subtle" data-bs-toggle="modal" data-bs-target="#agentModal">View</button>
                              <a href="#?agent_id=10" class="btn bg-warning-subtle">Edit</a>
                              <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="10">Delete</button>
                           </div>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="fixed-table-footer"></div>
         </div>
         <div class="fixed-table-pagination">
            <div class="float-left pagination-detail">
               <span class="pagination-info">
               Showing 1 to 10 of 10 rows
               </span>
               <div class="page-list">
                  <div class="btn-group dropdown dropup">
                     <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                     <span class="page-size">10</span>
                     <span class="caret"></span>
                     </button>
                     <div class="dropdown-menu">
                        <a class="dropdown-item active" href="#">10</a>
                        <a class="dropdown-item" href="#">25</a>
                        <a class="dropdown-item" href="#">50</a>
                     </div>
                  </div>
                  rows per page
               </div>
            </div>
            <div class="float-right pagination">
               <ul class="pagination">
                  <li class="page-item page-pre"><a class="page-link" aria-label="previous page" href="javascript:void(0)">‹</a></li>
                  <li class="page-item active"><a class="page-link" aria-label="to page 1" href="javascript:void(0)">1</a></li>
                  <li class="page-item page-next"><a class="page-link" aria-label="next page" href="javascript:void(0)">›</a></li>
               </ul>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
   </div>
</div>
<!-- Main Modal -->
<!-- Agent Details Modal -->
<div id="agentModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-modal="true" role="dialog">
   <div class="modal-dialog modal-dialog-scrollable modal-xl modal-fullscreen-xxl-down">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h6 class="modal-title" id="modalTitle">Agent Details</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <!-- Modal Body -->
         <div class="modal-body ydcoza-compact-content" id="modalContent">
            <!-- TOP SUMMARY ROW (like your example) -->
            <div class="container-fluid lh-1 mb-2">
               <div class="row border">
                  <div class="col-1 p-2 text-black fw-medium border-end">First Name</div>
                  <div class="col-1 p-2 text-black fw-medium border-end">Initials</div>
                  <div class="col-1 p-2 text-black fw-medium border-end">Surname</div>
                  <div class="col-1 p-2 text-black fw-medium border-end">Gender</div>
                  <div class="col-1 p-2 text-black fw-medium border-end">Race</div>
                  <div class="col-2 p-2 text-black fw-medium border-end">Tel Number</div>
                  <div class="col-2 p-2 text-black fw-medium border-end">Email Address</div>
                  <div class="col-1 p-2 text-black fw-medium border-end">City/Town</div>
                  <div class="col-2 p-2 text-black fw-medium">Actions</div>
               </div>
               <div class="row border border-top-0">
                  <div class="col-1 p-2 border-end">John</div>
                  <div class="col-1 p-2 border-end">J.</div>
                  <div class="col-1 p-2 border-end">Doe</div>
                  <div class="col-1 p-2 border-end">Male</div>
                  <div class="col-1 p-2 border-end">White</div>
                  <div class="col-2 p-2 border-end">0123456789</div>
                  <div class="col-2 p-2 border-end">john.doe@example.com</div>
                  <div class="col-1 p-2 border-end">Cape Town</div>
                  <div class="col-2 p-1">
                     <a href="#" class="btn btn-sm bg-warning-subtle">Edit</a>
                     <button class="btn btn-sm bg-danger-subtle delete-agent-btn" data-id="1001">Delete</button>
                  </div>
               </div>
            </div>
            <!-- TABBED SECTIONS -->
            <div class="gtabs ydcoza-tab mb-3">
               <!-- Tab Buttons -->
               <div class="ydcoza-tab-buttons mb-2">
                  <button data-toggle="tab" data-tabs=".gtabs.ydcoza-tab" data-tab=".tab-1" class="active">
                  <span class="ydcoza-badge">Agent Info.</span>
                  </button>
                  <button data-toggle="tab" data-tabs=".gtabs.ydcoza-tab" data-tab=".tab-2">
                  <span class="ydcoza-badge">Identification &amp; Contact</span>
                  </button>
                  <button data-toggle="tab" data-tabs=".gtabs.ydcoza-tab" data-tab=".tab-3">
                  <span class="ydcoza-badge">Current Status</span>
                  </button>
                  <button data-toggle="tab" data-tabs=".gtabs.ydcoza-tab" data-tab=".tab-4">
                  <span class="ydcoza-badge">Progression History</span>
                  </button>
               </div>
               <div class="clearfix"></div>
               <!-- TAB 1: Agent Info. -->
               <div class="container-fluid gtab tab-1 border-top border-bottom lh-1 mb-2 active">
                  <!-- Row 1 -->
                  <div class="row border-start">
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Agent ID</div>
                     <div class="col border-end p-2 d-flex align-items-center">1001</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Highest Qualification</div>
                     <div class="col border-end p-2 d-flex align-items-center">B.Ed</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Date Loaded</div>
                     <div class="col border-end p-2 d-flex align-items-center">2025-01-07</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Agent Notes</div>
                     <div class="col p-2 d-flex align-items-center">Good Quality Agent</div>
                  </div>
                  <!-- Row 2 -->
                  <div class="row border-top border-start">
                     <div class="col border-end p-2 bg-light d-flex align-items-center">SACE Reg. Number</div>
                     <div class="col border-end p-2 d-flex align-items-center">SACE-12345</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Reg Date</div>
                     <div class="col border-end p-2 d-flex align-items-center">2024-02-01</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Expiry Date</div>
                     <div class="col border-end p-2 d-flex align-items-center">2026-02-01</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Training Date</div>
                     <div class="col p-2 d-flex align-items-center">2024-03-10</div>
                  </div>
                  <!-- Row 3 -->
                  <div class="row border-top border-start">
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Quantum (Comm)</div>
                     <div class="col border-end p-2 d-flex align-items-center">85%</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Quantum (Math)</div>
                     <div class="col border-end p-2 d-flex align-items-center">78%</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Quantum (Training)</div>
                     <div class="col border-end p-2 d-flex align-items-center">90%</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Signed Agreement</div>
                     <div class="col p-2 d-flex align-items-center">Y</div>
                  </div>
                  <!-- Row 4 -->
                  <div class="row border-top border-start">
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Signed Agreement Date</div>
                     <div class="col border-end p-2 d-flex align-items-center">2025-01-05</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Bank Name</div>
                     <div class="col border-end p-2 d-flex align-items-center">ABC Bank</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Branch Code</div>
                     <div class="col border-end p-2 d-flex align-items-center">123</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Account Number</div>
                     <div class="col p-2 d-flex align-items-center">9876543210</div>
                  </div>
               </div>
               <!-- TAB 2: Identification & Contact -->
               <div class="container-fluid gtab tab-2 border-top border-bottom lh-1 mb-2">
                  <!-- Row 1 -->
                  <div class="row border-start">
                     <div class="col border-end p-2 bg-light d-flex align-items-center">SA ID No</div>
                     <div class="col border-end p-2 d-flex align-items-center">3401015800086</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Passport No</div>
                     <div class="col border-end p-2 d-flex align-items-center">N/A</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Tel Number</div>
                     <div class="col border-end p-2 d-flex align-items-center">0123456789</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Email Address</div>
                     <div class="col p-2 d-flex align-items-center">john.doe@example.com</div>
                  </div>
                  <!-- Row 2: Address -->
                  <div class="row border-top border-start">
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Address Line 1</div>
                     <div class="col border-end p-2 d-flex align-items-center">10 Oak Street</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Suburb</div>
                     <div class="col border-end p-2 d-flex align-items-center">Sandton</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Town</div>
                     <div class="col border-end p-2 d-flex align-items-center">Cape Town</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Postal Code</div>
                     <div class="col p-2 d-flex align-items-center">8001</div>
                  </div>
                  <!-- Row 3: Preferred Working Areas -->
                  <div class="row border-top border-start">
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Preferred Area 1</div>
                     <div class="col border-end p-2 d-flex align-items-center">Cape Town CBD</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Preferred Area 2</div>
                     <div class="col border-end p-2 d-flex align-items-center">Southern Suburbs</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Preferred Area 3</div>
                     <div class="col border-end p-2 d-flex align-items-center">Northern Suburbs</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">&nbsp;</div>
                     <div class="col p-2 d-flex align-items-center">&nbsp;</div>
                  </div>
               </div>
               <!-- TAB 3: Current Status (Class Table Fields) -->
               <div class="container-fluid gtab tab-3 border-top border-bottom lh-1 mb-2">
                  <!-- Row 1: Class Info -->
                  <div class="row border-start">
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Agent Absent</div>
                     <div class="col border-end p-2 d-flex align-items-center">N</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Agent Backup</div>
                     <div class="col border-end p-2 d-flex align-items-center">Y</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Agent Replacement</div>
                     <div class="col border-end p-2 d-flex align-items-center">N</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Original Agent</div>
                     <div class="col p-2 d-flex align-items-center">Y</div>
                  </div>
                  <!-- Row 2: Class Order Info -->
                  <div class="row border-top border-start">
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Agent Order Number</div>
                     <div class="col border-end p-2 d-flex align-items-center">ORD-2025-100</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Class Time</div>
                     <div class="col border-end p-2 d-flex align-items-center">08:00 - 10:00</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Class Days</div>
                     <div class="col border-end p-2 d-flex align-items-center">Mon, Wed, Fri</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Agent order hours</div>
                     <div class="col p-2 d-flex align-items-center">6 hrs/week</div>
                  </div>
                  <!-- Row 3: Additional Class Info -->
                  <div class="row border-top border-start">
                     <div class="col border-end p-2 bg-light d-flex align-items-center">Agent Class Allocation</div>
                     <div class="col border-end p-2 d-flex align-items-center">Class #1313</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">QA Reports</div>
                     <div class="col border-end p-2 d-flex align-items-center">None</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">&nbsp;</div>
                     <div class="col border-end p-2 d-flex align-items-center">&nbsp;</div>
                     <div class="col border-end p-2 bg-light d-flex align-items-center">&nbsp;</div>
                     <div class="col p-2 d-flex align-items-center">
                        <!-- Example "Agent History" Offcanvas Trigger -->
                        <button class="btn btn-sm btn-outline-discovery" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasHistory" aria-controls="offcanvasHistory">
                        History
                        </button>
                     </div>
                  </div>
               </div>
               <!-- TAB 4: Progressions (Product Table Fields) -->
               <div class="container-fluid gtab tab-4 border-top border-bottom mb-2 lh-1">
                  <!-- Start Accordions for each product area (similar to your example’s “Portfolio of Evidence”) -->
                  <div class="accordion accordion-flush ml-0 mr-2" style="margin:0 -11px" id="accordionProducts">
                     <div class="accordion-item">
                        <h2 class="accordion-header">
                           <button class="accordion-button collapsed btn btn-light border-start border-end" type="button"
                              data-bs-toggle="collapse" data-bs-target="#collapseAETComm1" aria-expanded="false">
                           AET Communication Level 1
                           </button>
                        </h2>
                        <div id="collapseAETComm1" class="accordion-collapse collapse" data-bs-parent="#accordionProducts">
                           <div class="accordion-body pb-0">
                              <!-- Demo row -->
                              <div class="container-fluid">
                                 <div class="row border">
                                    <div class="col-1 border-end p-2 bg-light d-flex align-items-center">Last Facilitated</div>
                                    <div class="col-1 border-end p-2 d-flex align-items-center">2023-03-15</div>
                                    <div class="col-1 border-end p-2 bg-light d-flex align-items-center">First Facilitated</div>
                                    <div class="col-1 border-end p-2 d-flex align-items-center">2020-01-16</div>
                                    <div class="col-1 border-end p-2 bg-light d-flex align-items-center">Result/Notes</div>
                                    <div class="col p-2 d-flex align-items-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eros ipsum, ullamcorper ut volutpat sit amet, consectetur ut orci. Donec massa tellus, pellentesque id pretium id, auctor bibendum mauris. </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header">
                           <button class="accordion-button collapsed btn btn-light border-start border-end" type="button"
                              data-bs-toggle="collapse" data-bs-target="#collapseBA2LP1" aria-expanded="false">
                           Business Admin NQF 2 - LP1
                           </button>
                        </h2>
                        <div id="collapseBA2LP1" class="accordion-collapse collapse" data-bs-parent="#accordionProducts">
                           <div class="accordion-body pb-0">
                              <!-- Demo row -->
                              <div class="container-fluid">
                                 <div class="row border">
                                    <div class="col-1 border-end p-2 bg-light d-flex align-items-center">Last Facilitated</div>
                                    <div class="col-1 border-end p-2 d-flex align-items-center">2025-01-18</div>
                                    <div class="col-1 border-end p-2 bg-light d-flex align-items-center">First Facilitated</div>
                                    <div class="col-1 border-end p-2 d-flex align-items-center">2022-09-12</div>
                                    <div class="col-1 border-end p-2 bg-light d-flex align-items-center">Result/Notes</div>
                                    <div class="col p-2 d-flex align-items-center">Good Feedback | Sed tristique orci nisl, auctor porta nunc vulputate accumsan. Nam volutpat est eu mi porttitor euismod.</div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Add more accordion items for each product line as needed -->
                     <div class="accordion-item">
                        <h2 class="accordion-header">
                           <button class="accordion-button collapsed btn btn-light border-start border-end" style="background-color: #6e5dc6; color: white" type="button" data-bs-toggle="collapse" data-bs-target="#update-1" aria-expanded="false">Update Agents Progression</button>
                        </h2>
                        <div id="update-1" class="accordion-collapse collapse" data-bs-parent="#accordionProducts">
                           <div class="accordion-body pb-0">
                              <div class="container-fluid">
                                 <form id="agents-progression-form" class="needs-validation ydcoza-compact-form" novalidate method="POST" enctype="multipart/form-data">
                                    <div class="row border">
                                       <div class="col-2 border-end p-2 bg-light d-flex align-items-center">Agent product trained start date</div>
                                       <div class="col-4 border-end p-2 d-flex align-items-center">
                                          <input type="date" class="form-control" id="startDateAETComm1" name="startDateAETComm1" aria-describedby="startDateHelp" />
                                       </div>
                                       <div class="col-2 border-end p-2 bg-light d-flex align-items-center">Agent product trained end date</div>
                                       <div class="col-4 p-2 d-flex align-items-center">
                                          <input type="date" class="form-control" id="endDateAETComm1" name="endDateAETComm1" aria-describedby="endDateHelp" />
                                       </div>
                                    </div>
                                    <div class="row border border-top-0">
                                       <div class="col-2 border-end p-2 bg-light d-flex align-items-center">Select Training Module</div>
                                       <div class="col-4 border-end p-2 d-flex align-items-center">
                                          <select class="form-select" id="productSelect" name="productSelect">
                                             <option value="" disabled selected>-- Select an option --</option>
                                             <option value="AET Communication level 1 Basic">AET Communication level 1 Basic</option>
                                             <option value="AET Communication level 1">AET Communication level 1</option>
                                             <option value="AET Communication level 2">AET Communication level 2</option>
                                             <option value="AET Communication level 3">AET Communication level 3</option>
                                             <option value="AET Communication level 4">AET Communication level 4</option>
                                             <option value="AET Numeracy level 1 Basic">AET Numeracy level 1 Basic</option>
                                             <option value="AET Numeracy level 1">AET Numeracy level 1</option>
                                             <option value="AET Numeracy level 2">AET Numeracy level 2</option>
                                             <option value="AET Numeracy level 3">AET Numeracy level 3</option>
                                             <option value="AET Numeracy level 4">AET Numeracy level 4</option>
                                             <option value="AET level 4 Life Orientation">AET level 4 Life Orientation</option>
                                             <option value="AET level 4 Human & Social Sciences">AET level 4 Human & Social Sciences</option>
                                             <option value="AET level 4 Economic & Management Sciences">AET level 4 Economic & Management Sciences</option>
                                             <option value="AET level 4 Natural Sciences">AET level 4 Natural Sciences</option>
                                             <option value="AET level 4 Small Micro Medium Enterprises">AET level 4 Small Micro Medium Enterprises</option>
                                             <option value="REALLL Communication">REALLL Communication</option>
                                             <option value="REALLL Numeracy">REALLL Numeracy</option>
                                             <option value="REALLL Finance">REALLL Finance</option>
                                             <option value="Business Admin NQF 2 - LP1">Business Admin NQF 2 - LP1</option>
                                             <option value="Business Admin NQF 2 - LP2">Business Admin NQF 2 - LP2</option>
                                             <option value="Business Admin NQF 2 - LP3">Business Admin NQF 2 - LP3</option>
                                             <option value="Business Admin NQF 2 - LP4">Business Admin NQF 2 - LP4</option>
                                             <option value="Business Admin NQF 2 - LP5">Business Admin NQF 2 - LP5</option>
                                             <option value="Business Admin NQF 2 - LP6">Business Admin NQF 2 - LP6</option>
                                             <option value="Business Admin NQF 2 - LP7">Business Admin NQF 2 - LP7</option>
                                             <option value="Business Admin NQF 2 - LP8">Business Admin NQF 2 - LP8</option>
                                             <option value="Business Admin NQF 2 - LP9">Business Admin NQF 2 - LP9</option>
                                             <option value="Business Admin NQF 2 - LP10">Business Admin NQF 2 - LP10</option>
                                             <option value="Business Admin NQF 3 - LP1">Business Admin NQF 3 - LP1</option>
                                             <option value="Business Admin NQF 3 - LP2">Business Admin NQF 3 - LP2</option>
                                             <option value="Business Admin NQF 3 - LP3">Business Admin NQF 3 - LP3</option>
                                             <option value="Business Admin NQF 3 - LP4">Business Admin NQF 3 - LP4</option>
                                             <option value="Business Admin NQF 3 - LP5">Business Admin NQF 3 - LP5</option>
                                             <option value="Business Admin NQF 3 - LP6">Business Admin NQF 3 - LP6</option>
                                             <option value="Business Admin NQF 3 - LP7">Business Admin NQF 3 - LP7</option>
                                             <option value="Business Admin NQF 3 - LP8">Business Admin NQF 3 - LP8</option>
                                             <option value="Business Admin NQF 3 - LP9">Business Admin NQF 3 - LP9</option>
                                             <option value="Business Admin NQF 3 - LP10">Business Admin NQF 3 - LP10</option>
                                             <option value="Business Admin NQF 3 - LP11">Business Admin NQF 3 - LP11</option>
                                             <option value="Business Admin NQF 4 - LP1">Business Admin NQF 4 - LP1</option>
                                             <option value="Business Admin NQF 4 - LP2">Business Admin NQF 4 - LP2</option>
                                             <option value="Business Admin NQF 4 - LP3">Business Admin NQF 4 - LP3</option>
                                             <option value="Business Admin NQF 4 - LP4">Business Admin NQF 4 - LP4</option>
                                             <option value="Business Admin NQF 4 - LP5">Business Admin NQF 4 - LP5</option>
                                             <option value="Business Admin NQF 4 - LP6">Business Admin NQF 4 - LP6</option>
                                             <option value="Business Admin NQF 4 - LP7">Business Admin NQF 4 - LP7</option>
                                             <option value="Introduction to Computers">Introduction to Computers</option>
                                             <option value="Email Etiquette">Email Etiquette</option>
                                             <option value="Time Management">Time Management</option>
                                             <option value="Supervisory Skills">Supervisory Skills</option>
                                          </select>
                                       </div>
                                       <div class="col-2 border-end p-2 bg-light d-flex align-items-center">Comments / Notes</div>
                                       <div class="col-4 p-2 d-flex align-items-center">
                                          <textarea class="form-control" id="commentsAETComm1" name="commentsAETComm1" rows="1"></textarea>
                                       </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                       <div class="col">
                                          <button type="submit" class="btn btn-primary">Update Profile</button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
return ob_get_clean();
}
add_shortcode('wecoza_display_agents', 'wecoza_display_agents_shortcode');

} // End plugin check