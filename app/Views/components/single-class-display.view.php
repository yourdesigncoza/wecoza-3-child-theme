<?php
/**
 * Single Class Display View
 *
 * This view displays detailed information for a single class from the database in a Bootstrap 5 compatible format.
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
            
            <!-- Header Section -->
            <div class="card shadow-none border mb-4">
                <div class="card-header bg-primary bg-opacity-10 border-bottom">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="text-primary mb-1">
                                <i class="bi bi-calendar-event me-2"></i>
                                <?php echo esc_html($class['class_subject'] ?? 'Class Details'); ?>
                            </h3>
                            <p class="text-muted mb-0">
                                <strong>Class Code:</strong> <?php echo esc_html($class['class_code'] ?? 'N/A'); ?>
                                <span class="mx-2">•</span>
                                <strong>ID:</strong> #<?php echo esc_html($class['class_id']); ?>
                            </p>
                        </div>
                        <div class="col-auto">
                            <span class="badge fs-6 badge-phoenix badge-phoenix-primary">
                                <?php echo esc_html($class['class_type'] ?? 'Unknown Type'); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Information Grid -->
            <div class="row">
                <!-- Basic Information -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-header bg-body border-bottom">
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Basic Information
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-hash me-2"></i>Class ID</td>
                                        <td><?php echo esc_html($class['class_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-tag me-2"></i>Class Code</td>
                                        <td><?php echo esc_html($class['class_code'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-book me-2"></i>Subject</td>
                                        <td><?php echo esc_html($class['class_subject'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-layers me-2"></i>Type</td>
                                        <td>
                                            <?php if (!empty($class['class_type'])): ?>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                <?php echo esc_html($class['class_type']); ?>
                                            </span>
                                            <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-clock me-2"></i>Duration</td>
                                        <td>
                                            <?php if (!empty($class['class_duration'])): ?>
                                                <?php echo esc_html($class['class_duration']); ?> hours
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-geo-alt me-2"></i>Address</td>
                                        <td><?php echo esc_html($class['class_address_line'] ?? 'N/A'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Dates & Schedule -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-header bg-body border-bottom">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar-date me-2"></i>
                                Dates & Schedule
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-calendar-plus me-2"></i>Start Date</td>
                                        <td>
                                            <?php if (!empty($class['original_start_date'])): ?>
                                                <?php echo esc_html(date('M j, Y', strtotime($class['original_start_date']))); ?>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-truck me-2"></i>Delivery Date</td>
                                        <td>
                                            <?php if (!empty($class['delivery_date'])): ?>
                                                <?php echo esc_html(date('M j, Y', strtotime($class['delivery_date']))); ?>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-calendar-check me-2"></i>Created</td>
                                        <td>
                                            <?php if (!empty($class['created_at'])): ?>
                                                <?php echo esc_html(date('M j, Y g:i A', strtotime($class['created_at']))); ?>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-calendar-event me-2"></i>Last Updated</td>
                                        <td>
                                            <?php if (!empty($class['updated_at'])): ?>
                                                <?php echo esc_html(date('M j, Y g:i A', strtotime($class['updated_at']))); ?>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-calendar3 me-2"></i>QA Visit Dates</td>
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
                </div>
            </div>

            <!-- Client & Staff Information -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-header bg-body border-bottom">
                            <h5 class="mb-0">
                                <i class="bi bi-people me-2"></i>
                                Client & Staff
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-building me-2"></i>Client</td>
                                        <td>
                                            <?php if (!empty($class['client_name'])): ?>
                                                <strong><?php echo esc_html($class['client_name']); ?></strong>
                                                <br><small class="text-muted">ID: <?php echo esc_html($class['client_id']); ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-person-badge me-2"></i>Agent</td>
                                        <td>
                                            <?php if (!empty($class['agent_name'])): ?>
                                                <strong><?php echo esc_html($class['agent_name']); ?></strong>
                                                <br><small class="text-muted">ID: <?php echo esc_html($class['class_agent']); ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-person-gear me-2"></i>Supervisor</td>
                                        <td>
                                            <?php if (!empty($class['supervisor_name'])): ?>
                                                <strong><?php echo esc_html($class['supervisor_name']); ?></strong>
                                                <br><small class="text-muted">ID: <?php echo esc_html($class['project_supervisor_id']); ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SETA & Exam Information -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-header bg-body border-bottom">
                            <h5 class="mb-0">
                                <i class="bi bi-award me-2"></i>
                                SETA & Exam Details
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-check-circle me-2"></i>SETA Funded</td>
                                        <td>
                                            <?php if ($class['seta_funded']): ?>
                                            <span class="badge fs-6 badge-phoenix badge-phoenix-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Yes
                                            </span>
                                            <?php else: ?>
                                            <span class="badge fs-6 badge-phoenix badge-phoenix-secondary">
                                                <i class="bi bi-x-circle me-1"></i>
                                                No
                                            </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-building-gear me-2"></i>SETA Name</td>
                                        <td><?php echo esc_html($class['seta'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-mortarboard me-2"></i>Exam Class</td>
                                        <td>
                                            <?php if ($class['exam_class']): ?>
                                            <span class="badge fs-6 badge-phoenix badge-phoenix-warning">
                                                <i class="bi bi-mortarboard me-1"></i>
                                                Yes
                                            </span>
                                            <?php else: ?>
                                            <span class="badge fs-6 badge-phoenix badge-phoenix-secondary">
                                                <i class="bi bi-x-circle me-1"></i>
                                                No
                                            </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"><i class="bi bi-file-earmark-text me-2"></i>Exam Type</td>
                                        <td><?php echo esc_html($class['exam_type'] ?? 'N/A'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
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
</script>
