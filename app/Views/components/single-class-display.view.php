<?php
/**
 * Single Class Display View - Modern Layout
 *
 * This view displays detailed information for a single class from the database in a modern Bootstrap 5 layout.
 * Used by the [wecoza_display_single_class] shortcode.
 *
 * Available Variables:
 *   - $class: Array of class data from the database
 *   - $show_loading: Boolean indicating whether to show loading indicator
 *   - $error_message: String containing error message if class not found or invalid
 *
 * Database Fields Displayed:
 *   - class_id, class_code, class_subject, class_type
 *   - original_start_date, delivery_date, class_duration
 *   - client information (name, ID)
 *   - agent information (name, ID)
 *   - supervisor information (name, ID)
 *   - SETA funding status and details
 *   - exam class status and type
 *   - class address and additional details
 *
 * @package WeCoza
 * @see \WeCoza\Controllers\ClassController::displaySingleClassShortcode() For the controller method that renders this view
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Ensure we have the class data
$class = $class ?? null;
$show_loading = $show_loading ?? true;
$error_message = $error_message ?? '';
?>

<div class="wecoza-single-class-display">
    <!-- Loading Indicator -->
    <?php if ($show_loading): ?>
    <div id="single-class-loading" class="d-flex justify-content-center align-items-center py-4">
        <div class="spinner-border text-primary me-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="text-muted">Loading class details...</span>
    </div>
    <?php endif; ?>

    <!-- Class Content -->
    <div id="single-class-content" class="<?php echo $show_loading ? 'd-none' : ''; ?>">

        <?php if (!empty($error_message)): ?>
            <!-- Error Message -->
            <div class="alert alert-danger d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                <div>
                    <h6 class="alert-heading mb-1">Error Loading Class</h6>
                    <p class="mb-0"><?php echo esc_html($error_message); ?></p>
                </div>
            </div>
        <?php elseif (empty($class)): ?>
            <!-- No Class Found -->
            <div class="alert alert-warning d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                <div>
                    <h6 class="alert-heading mb-1">Class Not Found</h6>
                    <p class="mb-0">The requested class could not be found in the database.</p>
                </div>
            </div>
        <?php else: ?>
            <!-- Class Details -->


            <!-- Action Buttons -->
            <?php if (current_user_can('edit_posts') || current_user_can('manage_options')): ?>
            <div class="d-flex justify-content-end mb-4">
                <div class="col-12 col-md-auto d-flex">
                    <?php if (current_user_can('edit_posts') || current_user_can('manage_options')): ?>
                    <button class="btn btn-phoenix-secondary px-3 px-sm-5 me-2" onclick="editClass(<?php echo esc_js($class['class_id']); ?>)">
                        <i class="bi bi-pencil-square me-sm-2"></i>
                        <span class="d-none d-sm-inline">Edit</span>
                    </button>
                    <?php endif; ?>

                    <?php if (current_user_can('manage_options')): ?>
                    <button class="btn btn-phoenix-danger me-2" onclick="deleteClass(<?php echo esc_js($class['class_id']); ?>)">
                        <i class="bi bi-trash me-2"></i>
                        <span>Delete Class</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Top Summary Cards -->
            <div class="card mb-5">
                <div class="card-body">
                    <div class="row g-4 justify-content-between">
                        <!-- Class Subject Card -->
                        <div class="col-sm-auto">
                            <div class="d-flex align-items-center">
                                <div class="d-flex bg-success-subtle rounded flex-center me-3" style="width:32px; height:32px">
                                    <i class="bi bi-book text-success"></i>
                                </div>
                                <div>
                                    <p class="fw-bold mb-1">Class Subject</p>
                                    <h5 class="fw-bolder text-nowrap"><?php echo esc_html($class['class_subject'] ?? 'N/A'); ?></h5>
                                </div>
                            </div>
                        </div>
                        <!-- Class Code Card -->
                        <div class="col-sm-auto">
                            <div class="d-flex align-items-center border-start-sm ps-sm-5">
                                <div class="d-flex bg-info-subtle rounded flex-center me-3" style="width:32px; height:32px">
                                    <i class="bi bi-tag text-info"></i>
                                </div>
                                <div>
                                    <p class="fw-bold mb-1">Class Code</p>
                                    <h5 class="fw-bolder text-nowrap"><?php echo esc_html($class['class_code'] ?? 'N/A'); ?></h5>
                                </div>
                            </div>
                        </div>
                        <!-- Class Type Card -->
                        <div class="col-sm-auto">
                            <div class="d-flex align-items-center border-start-sm ps-sm-5">
                                <div class="d-flex bg-primary-subtle rounded flex-center me-3" style="width:32px; height:32px">
                                    <i class="bi bi-layers text-primary"></i>
                                </div>
                                <div>
                                    <p class="fw-bold mb-1">Class Type</p>
                                    <h5 class="fw-bolder text-nowrap"><?php echo esc_html($class['class_type'] ?? 'Unknown Type'); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Tables -->
            <div class="px-xl-4 mb-7">
                <div class="row mx-0">
                    <!-- Left Column - Basic Information -->
                    <div class="col-sm-12 col-xxl-6 border-bottom border-end-xxl py-3">
                        <table class="w-100 table-stats table table-hover table-sm fs-9 mb-0">
                            <tbody>
                                <tr>
                                    <td class="py-2">
                                        <div class="d-inline-flex align-items-center">
                                            <div class="d-flex bg-primary-subtle rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                <i class="bi bi-hash text-primary" style="font-size: 12px;"></i>
                                            </div>
                                            <p class="fw-bold mb-0">Class ID</p>
                                        </div>
                                    </td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <p class="fw-semibold mb-0">#<?php echo esc_html($class['class_id']); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex bg-warning-subtle rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                <i class="bi bi-clock text-warning" style="font-size: 12px;"></i>
                                            </div>
                                            <p class="fw-bold mb-0">Duration</p>
                                        </div>
                                    </td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <p class="fw-semibold mb-0">
                                            <?php if (!empty($class['class_duration'])): ?>
                                                <?php echo esc_html($class['class_duration']); ?> hours
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex bg-success-subtle rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                <i class="bi bi-geo-alt text-success" style="font-size: 12px;"></i>
                                            </div>
                                            <p class="fw-bold mb-0">Address</p>
                                        </div>
                                    </td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <p class="fw-semibold mb-0"><?php echo esc_html($class['class_address_line'] ?? 'N/A'); ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Right Column - Dates & Schedule -->
                    <div class="col-sm-12 col-xxl-6 border-bottom py-3">
                        <table class="w-100 table-stats table table-hover table-sm fs-9 mb-0">
                            <tbody>
                                <tr>
                                    <td class="py-2">
                                        <div class="d-inline-flex align-items-center">
                                            <div class="d-flex bg-info-subtle rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                <i class="bi bi-calendar-plus text-info" style="font-size: 12px;"></i>
                                            </div>
                                            <p class="fw-bold mb-0">Start Date</p>
                                        </div>
                                    </td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <p class="fw-semibold mb-0">
                                            <?php if (!empty($class['original_start_date'])): ?>
                                                <?php echo esc_html(date('M j, Y', strtotime($class['original_start_date']))); ?>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex bg-warning-subtle rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                <i class="bi bi-truck text-warning" style="font-size: 12px;"></i>
                                            </div>
                                            <p class="fw-bold mb-0">Delivery Date</p>
                                        </div>
                                    </td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <p class="fw-semibold mb-0">
                                            <?php if (!empty($class['delivery_date'])): ?>
                                                <?php echo esc_html(date('M j, Y', strtotime($class['delivery_date']))); ?>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Bottom Left - People & Staff -->
                    <div class="col-sm-12 col-xxl-6 border-end-xxl border-bottom-xxl py-3">
                        <table class="w-100 table-stats table table-hover table-sm fs-9 mb-0">
                            <tbody>
                                <tr>
                                    <td class="py-2">
                                        <div class="d-inline-flex align-items-center">
                                            <div class="d-flex bg-primary-subtle rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                <i class="bi bi-building text-primary" style="font-size: 12px;"></i>
                                            </div>
                                            <p class="fw-bold mb-0">Client</p>
                                        </div>
                                    </td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <div class="fw-semibold mb-0">
                                            <?php if (!empty($class['client_name'])): ?>
                                                <?php echo esc_html($class['client_name']); ?>
                                                <div class="fs-9 text-muted">ID: <?php echo esc_html($class['client_id']); ?></div>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex bg-success-subtle rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                <i class="bi bi-person-badge text-success" style="font-size: 12px;"></i>
                                            </div>
                                            <p class="fw-bold mb-0">Agent</p>
                                        </div>
                                    </td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <div class="fw-semibold mb-0">
                                            <?php if (!empty($class['agent_name'])): ?>
                                                <?php echo esc_html($class['agent_name']); ?>
                                                <div class="fs-9 text-muted">ID: <?php echo esc_html($class['class_agent']); ?></div>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Right - SETA & Exam Information -->
                    <div class="col-sm-12 col-xxl-6 py-3">
                        <table class="w-100 table-stats table table-hover table-sm fs-9 mb-0">
                            <tbody>
                                <tr>
                                    <td class="py-2">
                                        <div class="d-inline-flex align-items-center">
                                            <div class="d-flex bg-success-subtle rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                <i class="bi bi-check-circle text-success" style="font-size: 12px;"></i>
                                            </div>
                                            <p class="fw-bold mb-0">SETA Funded</p>
                                        </div>
                                    </td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <div class="fw-semibold mb-0">
                                            <?php if ($class['seta_funded']): ?>
                                                <span class="badge badge-success fs-10">Yes</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary fs-10">No</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex bg-warning-subtle rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                <i class="bi bi-mortarboard text-warning" style="font-size: 12px;"></i>
                                            </div>
                                            <p class="fw-bold mb-0">Exam Class</p>
                                        </div>
                                    </td>
                                    <td class="py-2">:</td>
                                    <td class="py-2">
                                        <div class="fw-semibold mb-0">
                                            <?php if ($class['exam_class']): ?>
                                                <span class="badge badge-warning fs-10">Yes</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary fs-10">No</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Nav Tabs for Additional Information -->
            <ul class="nav nav-underline fs-9 class-details scrollbar flex-nowrap w-100 pb-1 mb-6" id="classTab" role="tablist">
                <li class="nav-item me-2" role="presentation">
                    <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#tab-details" role="tab">Additional Details</a>
                </li>
                <li class="nav-item me-2" role="presentation">
                    <a class="nav-link" id="seta-tab" data-bs-toggle="tab" href="#tab-seta" role="tab">SETA Information</a>
                </li>
                <li class="nav-item me-2" role="presentation">
                    <a class="nav-link" id="dates-tab" data-bs-toggle="tab" href="#tab-dates" role="tab">Dates & Timeline</a>
                </li>
                <li class="nav-item me-2" role="presentation">
                    <a class="nav-link" id="staff-tab" data-bs-toggle="tab" href="#tab-staff" role="tab">Staff & Supervision</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="classTabContent">
                <!-- Additional Details Pane -->
                <div class="tab-pane fade show active" id="tab-details" role="tabpanel">
                    <h4 class="mb-4">Additional Details</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-geo-alt me-2"></i>Location Information
                                    </h6>
                                    <p class="card-text">
                                        <strong>Address:</strong><br>
                                        <?php echo esc_html($class['class_address_line'] ?? 'N/A'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-clock me-2"></i>Duration & Schedule
                                    </h6>
                                    <p class="card-text">
                                        <strong>Duration:</strong>
                                        <?php if (!empty($class['class_duration'])): ?>
                                            <?php echo esc_html($class['class_duration']); ?> hours
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SETA Information Pane -->
                <div class="tab-pane fade" id="tab-seta" role="tabpanel">
                    <h4 class="mb-4">SETA Information</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm fs-9 mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">SETA Funded</td>
                                    <td>
                                        <?php if ($class['seta_funded']): ?>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Yes
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-x-circle me-1"></i>No
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">SETA Name</td>
                                    <td><?php echo esc_html($class['seta'] ?? 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Exam Class</td>
                                    <td>
                                        <?php if ($class['exam_class']): ?>
                                            <span class="badge bg-warning">
                                                <i class="bi bi-mortarboard me-1"></i>Yes
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-x-circle me-1"></i>No
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Exam Type</td>
                                    <td><?php echo esc_html($class['exam_type'] ?? 'N/A'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dates & Timeline Pane -->
                <div class="tab-pane fade" id="tab-dates" role="tabpanel">
                    <h4 class="mb-4">Dates & Timeline</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm fs-9 mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">
                                        <i class="bi bi-calendar-plus me-2"></i>Start Date
                                    </td>
                                    <td>
                                        <?php if (!empty($class['original_start_date'])): ?>
                                            <?php echo esc_html(date('M j, Y', strtotime($class['original_start_date']))); ?>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">
                                        <i class="bi bi-truck me-2"></i>Delivery Date
                                    </td>
                                    <td>
                                        <?php if (!empty($class['delivery_date'])): ?>
                                            <?php echo esc_html(date('M j, Y', strtotime($class['delivery_date']))); ?>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">
                                        <i class="bi bi-calendar-check me-2"></i>Created
                                    </td>
                                    <td>
                                        <?php if (!empty($class['created_at'])): ?>
                                            <?php echo esc_html(date('M j, Y g:i A', strtotime($class['created_at']))); ?>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">
                                        <i class="bi bi-calendar-event me-2"></i>Last Updated
                                    </td>
                                    <td>
                                        <?php if (!empty($class['updated_at'])): ?>
                                            <?php echo esc_html(date('M j, Y g:i A', strtotime($class['updated_at']))); ?>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">
                                        <i class="bi bi-calendar3 me-2"></i>QA Visit Dates
                                    </td>
                                    <td>
                                        <?php if (!empty($class['qa_visit_dates'])): ?>
                                            <?php echo esc_html($class['qa_visit_dates']); ?>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Staff & Supervision Pane -->
                <div class="tab-pane fade" id="tab-staff" role="tabpanel">
                    <h4 class="mb-4">Staff & Supervision</h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="d-flex bg-primary-subtle rounded-circle flex-center" style="width:48px; height:48px">
                                            <i class="bi bi-building text-primary fs-4"></i>
                                        </div>
                                    </div>
                                    <h6 class="card-title">Client</h6>
                                    <?php if (!empty($class['client_name'])): ?>
                                        <p class="card-text fw-bold"><?php echo esc_html($class['client_name']); ?></p>
                                        <small class="text-muted">ID: <?php echo esc_html($class['client_id']); ?></small>
                                    <?php else: ?>
                                        <p class="card-text text-muted">N/A</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="d-flex bg-success-subtle rounded-circle flex-center" style="width:48px; height:48px">
                                            <i class="bi bi-person-badge text-success fs-4"></i>
                                        </div>
                                    </div>
                                    <h6 class="card-title">Agent</h6>
                                    <?php if (!empty($class['agent_name'])): ?>
                                        <p class="card-text fw-bold"><?php echo esc_html($class['agent_name']); ?></p>
                                        <small class="text-muted">ID: <?php echo esc_html($class['class_agent']); ?></small>
                                    <?php else: ?>
                                        <p class="card-text text-muted">N/A</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="d-flex bg-warning-subtle rounded-circle flex-center" style="width:48px; height:48px">
                                            <i class="bi bi-person-gear text-warning fs-4"></i>
                                        </div>
                                    </div>
                                    <h6 class="card-title">Supervisor</h6>
                                    <?php if (!empty($class['supervisor_name'])): ?>
                                        <p class="card-text fw-bold"><?php echo esc_html($class['supervisor_name']); ?></p>
                                        <small class="text-muted">ID: <?php echo esc_html($class['project_supervisor_id']); ?></small>
                                    <?php else: ?>
                                        <p class="card-text text-muted">N/A</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>
</div>

<!-- JavaScript for functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide loading indicator and show content after a brief delay
    <?php if ($show_loading): ?>
    setTimeout(function() {
        const loading = document.getElementById('single-class-loading');
        const content = document.getElementById('single-class-content');

        if (loading) loading.classList.add('d-none');
        if (content) content.classList.remove('d-none');
    }, 500);
    <?php endif; ?>
});

/**
 * Edit Class Function
 * Redirects to the edit page with the class ID
 */
function editClass(classId) {
    // Check if user has edit permissions
    const canEdit = <?php echo (current_user_can('edit_posts') || current_user_can('manage_options')) ? 'true' : 'false'; ?>;
    if (!canEdit) {
        alert('You do not have permission to edit classes.');
        return;
    }

    <?php
    // 1. Find the page object for "app/new-class" (or just "new-class", depending on where it lives)
    $page = get_page_by_path('app/new-class');
    // If your "new-class" page lives directly under /app/, use exactly that path.
    // If it's a top-level page called "new-class", you can just do get_page_by_path('new-class').

    // 2. Grab its permalink (so WP will automatically use the correct domain/child-theme slug, etc.)
    if ($page) {
        $base_url = get_permalink($page->ID);
    } else {
        // Fallback if page not found:
        $base_url = home_url('/app/new-class/');
    }

    // 3. Append ?mode=update&class_id=… with add_query_arg()
    $edit_url = add_query_arg(
        [
            'mode'     => 'update',
            'class_id' => $class['class_id'],
        ],
        $base_url
    );

    echo "const editUrl = '" . esc_url_raw($edit_url) . "';";
    ?>

    // Redirect to edit page with complete URL
    window.location.href = editUrl;
}

/**
 * Delete Class Function
 * Handles AJAX deletion with proper security checks
 */
function deleteClass(classId) {
    // Check if user is administrator
    const isAdmin = <?php echo current_user_can('manage_options') ? 'true' : 'false'; ?>;
    if (!isAdmin) {
        alert('Only administrators can delete classes.');
        return;
    }

    if (confirm('Are you sure you want to delete this class? This action cannot be undone.')) {
        // Show loading state
        const deleteButton = document.querySelector(`[onclick="deleteClass(${classId})"]`);
        const originalText = deleteButton.innerHTML;
        deleteButton.innerHTML = '<i class="bi bi-spinner-border me-2"></i>Deleting...';
        deleteButton.disabled = true;

        // Make AJAX request to delete class
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'delete_class',
                nonce: '<?php echo wp_create_nonce('wecoza_class_nonce'); ?>',
                class_id: classId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to classes list with success message
                <?php
                // Try to find the all-classes page using WordPress best practices
                $classes_page = get_page_by_path('app/all-classes');
                if ($classes_page) {
                    $classes_url = get_permalink($classes_page->ID);
                    echo "const classesUrl = '" . esc_url_raw($classes_url) . "';";
                } else {
                    // Fallback using home_url for proper domain handling
                    $fallback_url = home_url('/app/all-classes/');
                    echo "const classesUrl = '" . esc_url_raw($fallback_url) . "';";
                }
                ?>

                // Add success parameters to URL for notification (same as all-classes page)
                const successUrl = new URL(classesUrl);
                successUrl.searchParams.set('deleted', 'success');
                successUrl.searchParams.set('class_subject', data.data.class_subject || 'Unknown Class');
                successUrl.searchParams.set('class_code', data.data.class_code || '');
                window.location.href = successUrl.toString();
            } else {
                alert('Error deleting class: ' + (data.data || 'Unknown error'));
                // Restore button state
                deleteButton.innerHTML = originalText;
                deleteButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the class. Please try again.');
            // Restore button state
            deleteButton.innerHTML = originalText;
            deleteButton.disabled = false;
        });
    }
}

/**
 * Show Success Banner Function
 * Same implementation as all-classes page for consistency
 */
function showSuccessBanner(message) {
    // Create success banner
    const banner = document.createElement('div');
    banner.className = 'alert alert-subtle-success alert-dismissible fade show position-fixed';
    banner.style.cssText = 'top: 80px; right: 20px; z-index: 9999; min-width: 300px;';
    banner.innerHTML = `
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>Success!</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Add to page
    document.body.appendChild(banner);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (banner.parentNode) {
            banner.remove();
        }
    }, 5000);
}
</script>
