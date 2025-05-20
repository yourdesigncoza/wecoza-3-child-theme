<?php
/**
 * Assignments & Dates Partial View
 *
 * This partial view renders the assignments and dates section of the class capture form,
 * including class agents, agent replacements, project supervisor, and backup agents.
 *
 * @var array $data View data passed from ClassController
 */
?>
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

<!-- Project Supervisor -->
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
