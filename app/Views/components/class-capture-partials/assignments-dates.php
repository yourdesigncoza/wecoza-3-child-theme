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
