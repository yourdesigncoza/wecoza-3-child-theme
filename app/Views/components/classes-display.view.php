<?php
/**
 * Classes Display View
 *
 * This view displays all classes from the database in a Bootstrap 5 compatible format.
 * Used by the [wecoza_display_classes] shortcode.
 *
 * Available Variables:
 *   - $classes: Array of class data from the database
 *   - $show_loading: Boolean indicating whether to show loading indicator
 *   - $total_count: Total number of classes found
 *
 * @package WeCoza
 * @see \WeCoza\Controllers\ClassController::displayClassesShortcode() For the controller method that renders this view
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Ensure we have the classes data
$classes = $classes ?? [];
$show_loading = $show_loading ?? true;
$total_count = $total_count ?? 0;
?>

<div class="wecoza-classes-display">
    <!-- Loading Indicator -->
    <?php if ($show_loading): ?>
    <div id="classes-loading" class="d-flex justify-content-center align-items-center py-4">
        <div class="spinner-border text-primary me-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="text-muted">Loading classes...</span>
    </div>
    <?php endif; ?>

    <!-- Classes Content -->
    <div id="classes-content" class="<?php echo $show_loading ? 'd-none' : ''; ?>">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">
                            <i class="bi bi-calendar-event me-2 text-primary"></i>
                            All Classes
                        </h4>
                        <p class="text-muted mb-0">
                            <?php echo $total_count; ?> class<?php echo $total_count !== 1 ? 'es' : ''; ?> found
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm" onclick="refreshClasses()">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Refresh
                        </button>
                        <button class="btn btn-outline-primary btn-sm" onclick="exportClasses()">
                            <i class="bi bi-download me-1"></i>
                            Export
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php if (empty($classes)): ?>
            <!-- No Classes Found -->
            <div class="alert alert-info d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                <div>
                    <h6 class="alert-heading mb-1">No Classes Found</h6>
                    <p class="mb-0">There are currently no classes in the database. Create a new class to get started.</p>
                </div>
            </div>
        <?php else: ?>
            <!-- Classes Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="classes-table" class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="border-0 ps-4">
                                        <i class="bi bi-hash me-1"></i>
                                        ID
                                    </th>
                                    <th scope="col" class="border-0">
                                        <i class="bi bi-building me-1"></i>
                                        Client
                                    </th>
                                    <th scope="col" class="border-0">
                                        <i class="bi bi-tag me-1"></i>
                                        Type
                                    </th>
                                    <th scope="col" class="border-0">
                                        <i class="bi bi-book me-1"></i>
                                        Subject
                                    </th>
                                    <th scope="col" class="border-0">
                                        <i class="bi bi-calendar-date me-1"></i>
                                        Start Date
                                    </th>
                                    <th scope="col" class="border-0">
                                        <i class="bi bi-truck me-1"></i>
                                        Delivery Date
                                    </th>
                                    <th scope="col" class="border-0">
                                        <i class="bi bi-person me-1"></i>
                                        Agent
                                    </th>
                                    <th scope="col" class="border-0">
                                        <i class="bi bi-award me-1"></i>
                                        SETA
                                    </th>
                                    <th scope="col" class="border-0 pe-4">
                                        <i class="bi bi-gear me-1"></i>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($classes as $class): ?>
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-light text-dark border">
                                            #<?php echo esc_html($class['class_id']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium">
                                                <?php echo esc_html($class['client_name'] ?? 'Unknown Client'); ?>
                                            </span>
                                            <?php if (!empty($class['site_name'])): ?>
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                <?php echo esc_html($class['site_name']); ?>
                                            </small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($class['class_type'])): ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <?php echo esc_html($class['class_type']); ?>
                                        </span>
                                        <?php else: ?>
                                        <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium">
                                                <?php echo esc_html($class['class_subject'] ?? 'No Subject'); ?>
                                            </span>
                                            <?php if (!empty($class['class_code'])): ?>
                                            <small class="text-muted">
                                                Code: <?php echo esc_html($class['class_code']); ?>
                                            </small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($class['original_start_date'])): ?>
                                        <span class="text-nowrap">
                                            <?php echo esc_html(date('M j, Y', strtotime($class['original_start_date']))); ?>
                                        </span>
                                        <?php else: ?>
                                        <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($class['delivery_date'])): ?>
                                        <span class="text-nowrap">
                                            <?php echo esc_html(date('M j, Y', strtotime($class['delivery_date']))); ?>
                                        </span>
                                        <?php else: ?>
                                        <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($class['agent_name'])): ?>
                                        <span class="text-nowrap">
                                            <i class="bi bi-person-circle me-1"></i>
                                            <?php echo esc_html($class['agent_name']); ?>
                                        </span>
                                        <?php else: ?>
                                        <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($class['seta_funded']): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            SETA Funded
                                        </span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Not SETA
                                        </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="?mode=update&class_id=<?php echo $class['class_id']; ?>">
                                                        <i class="bi bi-pencil me-2"></i>
                                                        Edit Class
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="viewClassDetails(<?php echo $class['class_id']; ?>)">
                                                        <i class="bi bi-eye me-2"></i>
                                                        View Details
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" onclick="deleteClass(<?php echo $class['class_id']; ?>)">
                                                        <i class="bi bi-trash me-2"></i>
                                                        Delete Class
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card border-0 bg-primary bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar-event fs-1 text-primary mb-2"></i>
                            <h5 class="card-title text-primary"><?php echo $total_count; ?></h5>
                            <p class="card-text text-muted small mb-0">Total Classes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-check-circle fs-1 text-success mb-2"></i>
                            <h5 class="card-title text-success">
                                <?php echo count(array_filter($classes, function($c) { return $c['seta_funded']; })); ?>
                            </h5>
                            <p class="card-text text-muted small mb-0">SETA Funded</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-award fs-1 text-warning mb-2"></i>
                            <h5 class="card-title text-warning">
                                <?php echo count(array_filter($classes, function($c) { return $c['exam_class']; })); ?>
                            </h5>
                            <p class="card-text text-muted small mb-0">Exam Classes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-info bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-people fs-1 text-info mb-2"></i>
                            <h5 class="card-title text-info">
                                <?php echo count(array_unique(array_column($classes, 'client_id'))); ?>
                            </h5>
                            <p class="card-text text-muted small mb-0">Unique Clients</p>
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
        const loading = document.getElementById('classes-loading');
        const content = document.getElementById('classes-content');
        
        if (loading) loading.classList.add('d-none');
        if (content) content.classList.remove('d-none');
    }, 500);
    <?php endif; ?>
});

function refreshClasses() {
    location.reload();
}

function exportClasses() {
    // Placeholder for export functionality
    alert('Export functionality will be implemented soon.');
}

function viewClassDetails(classId) {
    // Placeholder for view details functionality
    alert('View details for class ID: ' + classId);
}

function deleteClass(classId) {
    if (confirm('Are you sure you want to delete this class? This action cannot be undone.')) {
        // Placeholder for delete functionality
        alert('Delete functionality will be implemented soon.');
    }
}
</script>

<!-- Custom CSS for enhanced styling -->
<style>
.wecoza-classes-display .table th {
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
}

.wecoza-classes-display .table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.wecoza-classes-display .card {
    border-radius: 0.75rem;
}

.wecoza-classes-display .badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.wecoza-classes-display .dropdown-toggle::after {
    display: none;
}

.wecoza-classes-display .spinner-border {
    width: 2rem;
    height: 2rem;
}
</style>
