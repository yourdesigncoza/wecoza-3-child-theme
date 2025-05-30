<?php
/**
 * Create Class View
 *
 * This view displays the form for creating a new class.
 * It follows the MVC architecture pattern where this file (View) is responsible only for presentation.
 *
 * Features:
 * - Clean, dedicated create form
 * - Bootstrap 5 floating labels
 * - Client-side validation
 * - AJAX form submission
 * - Responsive design
 *
 * @var array $data View data passed from ClassController::create() containing:
 *   - class_data: null (for create mode)
 *   - clients: Array of client data
 *   - sites: Array of site data grouped by client
 *   - agents: Array of agent data
 *   - supervisors: Array of supervisor data
 *   - learners: Array of learner data
 *   - setas: Array of SETA data
 *   - class_types: Array of class type data
 *   - yes_no_options: Array of Yes/No options
 *   - class_notes_options: Array of class notes options
 *   - redirect_url: URL to redirect to after successful creation
 */
?>

<div class="create-class-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-plus-circle me-2"></i>
                Create New Class
            </h2>
            <p class="text-muted mb-0">Add a new training class to the system</p>
        </div>
        <div>
            <a href="?action=classes_index" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i>
                Back to Classes
            </a>
            <button type="button" class="btn btn-outline-info" onclick="toggleFormHelp()">
                <i class="bi bi-question-circle me-1"></i>
                Help
            </button>
        </div>
    </div>

    <!-- Help Section (Initially Hidden) -->
    <div id="form-help" class="alert alert-info d-none mb-4">
        <h6><i class="bi bi-info-circle me-2"></i>Form Help</h6>
        <ul class="mb-0">
            <li><strong>Client & Site:</strong> Select the client first, then choose the specific site location</li>
            <li><strong>Class Type & Subject:</strong> Choose the main category, then select the specific subject/level</li>
            <li><strong>SETA Funding:</strong> If Yes, you must specify which SETA is funding the class</li>
            <li><strong>Exam Class:</strong> If Yes, you must specify the type of exam (Written, Practical, etc.)</li>
            <li><strong>Required Fields:</strong> Fields marked with <span class="text-danger">*</span> are mandatory</li>
        </ul>
    </div>

    <!-- Create Class Form -->
    <form id="create-class-form" class="needs-validation ydcoza-compact-form" novalidate method="POST" enctype="multipart/form-data">
        <!-- Hidden Fields -->
        <input type="hidden" id="class_id" name="class_id" value="auto-generated">
        <input type="hidden" id="redirect_url" name="redirect_url" value="<?php echo esc_attr($data['redirect_url'] ?? ''); ?>">
        <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('wecoza_class_nonce'); ?>">

        <!-- Basic Details Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-building me-2"></i>
                    Basic Details
                </h5>
            </div>
            <div class="card-body">
                <?php include_once(get_template_directory() . '/app/Views/components/class-capture-partials/basic-details.php'); ?>
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
                <?php include_once(get_template_directory() . '/app/Views/components/class-capture-partials/class-info.php'); ?>
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
                                Create Class
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-lg" onclick="saveDraft()">
                                <i class="bi bi-save me-2"></i>
                                Save Draft
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-warning btn-lg me-md-2">
                                <i class="bi bi-arrow-clockwise me-2"></i>
                                Reset Form
                            </button>
                            <a href="?action=classes_index" class="btn btn-outline-danger btn-lg">
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
// Form help toggle
function toggleFormHelp() {
    const helpSection = document.getElementById('form-help');
    helpSection.classList.toggle('d-none');
}

// Save draft functionality
function saveDraft() {
    // Implement draft saving logic
    alert('Draft saving functionality will be implemented in a future update.');
}

// Form submission handling
document.getElementById('create-class-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating...';
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
            showMessage('success', data.data.message || 'Class created successfully!');
            
            // Redirect after short delay
            setTimeout(() => {
                if (data.data.class_id) {
                    window.location.href = '?action=view_class&class_id=' + data.data.class_id;
                } else {
                    window.location.href = '?action=classes_index';
                }
            }, 1500);
        } else {
            // Show error message
            showMessage('error', data.data || 'Failed to create class. Please try again.');
            
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
