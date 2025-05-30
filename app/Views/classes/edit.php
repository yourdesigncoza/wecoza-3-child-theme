<?php
/**
 * Edit Class View
 *
 * This view displays the form for editing an existing class.
 * It follows the MVC architecture pattern where this file (View) is responsible only for presentation.
 *
 * Features:
 * - Pre-populated form with existing class data
 * - Bootstrap 5 floating labels
 * - Client-side validation
 * - AJAX form submission
 * - Responsive design
 * - Change tracking and confirmation
 *
 * @var array $data View data passed from ClassController::edit() containing:
 *   - class_data: ClassModel object with existing data
 *   - clients: Array of client data
 *   - sites: Array of site data grouped by client
 *   - agents: Array of agent data
 *   - supervisors: Array of supervisor data
 *   - learners: Array of learner data
 *   - setas: Array of SETA data
 *   - class_types: Array of class type data
 *   - yes_no_options: Array of Yes/No options
 *   - class_notes_options: Array of class notes options
 *   - redirect_url: URL to redirect to after successful update
 */
?>

<div class="edit-class-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-pencil-square me-2"></i>
                Edit Class
            </h2>
            <p class="text-muted mb-0">
                Modify class details for: 
                <strong><?php echo esc_html($data['class_data']->getClassCode() ?: 'Class #' . $data['class_data']->getId()); ?></strong>
            </p>
        </div>
        <div>
            <a href="?action=view_class&class_id=<?php echo $data['class_data']->getId(); ?>" class="btn btn-outline-info me-2">
                <i class="bi bi-eye me-1"></i>
                View Details
            </a>
            <a href="?action=classes_index" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i>
                Back to Classes
            </a>
            <button type="button" class="btn btn-outline-warning" onclick="toggleChangeLog()">
                <i class="bi bi-clock-history me-1"></i>
                Changes
            </button>
        </div>
    </div>

    <!-- Class Information Summary -->
    <div class="alert alert-info mb-4">
        <div class="row">
            <div class="col-md-3">
                <strong>Client:</strong><br>
                <span class="text-muted"><?php echo esc_html($data['class_data']->client_name ?? 'Unknown'); ?></span>
            </div>
            <div class="col-md-3">
                <strong>Type:</strong><br>
                <span class="text-muted"><?php echo esc_html($data['class_data']->getClassType()); ?></span>
            </div>
            <div class="col-md-3">
                <strong>Start Date:</strong><br>
                <span class="text-muted">
                    <?php 
                    $startDate = $data['class_data']->getOriginalStartDate();
                    echo $startDate ? date('M j, Y', strtotime($startDate)) : 'Not set';
                    ?>
                </span>
            </div>
            <div class="col-md-3">
                <strong>Created:</strong><br>
                <span class="text-muted">
                    <?php 
                    $created = $data['class_data']->getCreatedAt();
                    echo $created ? date('M j, Y', strtotime($created)) : 'Unknown';
                    ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Change Log (Initially Hidden) -->
    <div id="change-log" class="alert alert-warning d-none mb-4">
        <h6><i class="bi bi-exclamation-triangle me-2"></i>Unsaved Changes</h6>
        <ul id="change-list" class="mb-0">
            <!-- Changes will be populated here by JavaScript -->
        </ul>
    </div>

    <!-- Edit Class Form -->
    <form id="edit-class-form" class="needs-validation ydcoza-compact-form" novalidate method="POST" enctype="multipart/form-data">
        <!-- Hidden Fields -->
        <input type="hidden" id="class_id" name="class_id" value="<?php echo esc_attr($data['class_data']->getId()); ?>">
        <input type="hidden" id="redirect_url" name="redirect_url" value="<?php echo esc_attr($data['redirect_url'] ?? ''); ?>">
        <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('wecoza_class_nonce'); ?>">

        <!-- Basic Details Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-building me-2"></i>
                    Basic Details
                </h5>
                <small class="text-muted">Client and site information</small>
            </div>
            <div class="card-body">
                <!-- Note: In edit mode, basic details are typically read-only or restricted -->
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Note:</strong> Client and site information cannot be changed after class creation. 
                    Contact an administrator if changes are needed.
                </div>
                
                <!-- Display current client/site info -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input 
                                type="text" 
                                class="form-control" 
                                value="<?php echo esc_attr($data['class_data']->client_name ?? 'Unknown Client'); ?>" 
                                readonly
                            >
                            <label>Client Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input 
                                type="text" 
                                class="form-control" 
                                value="<?php echo esc_attr($data['class_data']->site_name ?? 'Unknown Site'); ?>" 
                                readonly
                            >
                            <label>Site Name</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Class Information Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-book me-2"></i>
                    Class Information
                </h5>
            </div>
            <div class="card-body">
                <!-- Set mode to update for the partial -->
                <?php 
                $data['mode'] = 'update';
                include_once(get_template_directory() . '/app/Views/components/class-capture-partials/class-info.php'); 
                ?>
            </div>
        </div>

        <!-- Schedule Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-calendar me-2"></i>
                    Class Schedule
                </h5>
            </div>
            <div class="card-body">
                <?php include_once(get_template_directory() . '/app/Views/components/class-capture-partials/class-schedule-form.php'); ?>
            </div>
        </div>

        <!-- Funding & Exam Details Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-cash-stack me-2"></i>
                    Funding & Exam Details
                </h5>
            </div>
            <div class="card-body">
                <?php include_once(get_template_directory() . '/app/Views/components/class-capture-partials/funding-exam-details.php'); ?>
            </div>
        </div>

        <!-- Learners Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-people me-2"></i>
                    Class Learners
                </h5>
            </div>
            <div class="card-body">
                <?php include_once(get_template_directory() . '/app/Views/components/class-capture-partials/class-learners.php'); ?>
                <?php include_once(get_template_directory() . '/app/Views/components/class-capture-partials/exam-learners.php'); ?>
            </div>
        </div>

        <!-- Class Notes & QA Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-clipboard-check me-2"></i>
                    Class Notes & QA
                </h5>
            </div>
            <div class="card-body">
                <?php include_once(get_template_directory() . '/app/Views/components/class-capture-partials/class-notes-qa.php'); ?>
            </div>
        </div>

        <!-- Assignments & Dates Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person-badge me-2"></i>
                    Assignments & Dates
                </h5>
            </div>
            <div class="card-body">
                <?php include_once(get_template_directory() . '/app/Views/components/class-capture-partials/assignments-dates.php'); ?>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-primary btn-lg me-md-2">
                                <i class="bi bi-check-circle me-2"></i>
                                Update Class
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-lg" onclick="previewChanges()">
                                <i class="bi bi-eye me-2"></i>
                                Preview Changes
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-outline-warning btn-lg me-md-2" onclick="resetForm()">
                                <i class="bi bi-arrow-clockwise me-2"></i>
                                Reset Changes
                            </button>
                            <a href="?action=view_class&class_id=<?php echo $data['class_data']->getId(); ?>" class="btn btn-outline-danger btn-lg">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Alert container for form messages -->
    <div id="form-messages" class="mt-3"></div>
</div>

<script>
// Store original form values for change tracking
let originalFormData = {};

// Initialize change tracking
document.addEventListener('DOMContentLoaded', function() {
    // Store original form values
    const form = document.getElementById('edit-class-form');
    const formData = new FormData(form);
    for (let [key, value] of formData.entries()) {
        originalFormData[key] = value;
    }
    
    // Add change listeners to form fields
    form.addEventListener('input', trackChanges);
    form.addEventListener('change', trackChanges);
});

// Track form changes
function trackChanges() {
    const form = document.getElementById('edit-class-form');
    const formData = new FormData(form);
    const changes = [];
    
    for (let [key, value] of formData.entries()) {
        if (originalFormData[key] !== value) {
            changes.push(key);
        }
    }
    
    updateChangeLog(changes);
}

// Update change log display
function updateChangeLog(changes) {
    const changeLog = document.getElementById('change-log');
    const changeList = document.getElementById('change-list');
    
    if (changes.length > 0) {
        changeLog.classList.remove('d-none');
        changeList.innerHTML = changes.map(field => 
            `<li>Modified: ${field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</li>`
        ).join('');
    } else {
        changeLog.classList.add('d-none');
    }
}

// Toggle change log visibility
function toggleChangeLog() {
    const changeLog = document.getElementById('change-log');
    changeLog.classList.toggle('d-none');
}

// Preview changes functionality
function previewChanges() {
    alert('Change preview functionality will be implemented in a future update.');
}

// Reset form to original values
function resetForm() {
    if (confirm('Are you sure you want to reset all changes? This will restore the original values.')) {
        document.getElementById('edit-class-form').reset();
        updateChangeLog([]);
    }
}

// Form submission handling
document.getElementById('edit-class-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Updating...';
    submitBtn.disabled = true;
    
    // Prepare form data
    const formData = new FormData(this);
    formData.append('action', 'save_class');
    
    // Submit via AJAX
    fetch(wecozaClass.ajaxUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showMessage('success', data.data.message || 'Class updated successfully!');
            
            // Update original form data
            const newFormData = new FormData(this);
            originalFormData = {};
            for (let [key, value] of newFormData.entries()) {
                originalFormData[key] = value;
            }
            updateChangeLog([]);
            
            // Redirect after short delay
            setTimeout(() => {
                window.location.href = '?action=view_class&class_id=' + data.data.class_id;
            }, 1500);
        } else {
            // Show error message
            showMessage('error', data.data || 'Failed to update class. Please try again.');
            
            // Restore button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('error', 'An unexpected error occurred. Please try again.');
        
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// Show message function
function showMessage(type, message) {
    const container = document.getElementById('form-messages');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
    
    container.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="bi bi-${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Scroll to message
    container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
</script>
