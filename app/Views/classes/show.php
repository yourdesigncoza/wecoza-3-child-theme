<?php
/**
 * Show Class View
 *
 * This view displays detailed information about a specific class.
 * It follows the MVC architecture pattern where this file (View) is responsible only for presentation.
 *
 * Features:
 * - Comprehensive class information display
 * - Organized sections with clear visual hierarchy
 * - Action buttons for edit/delete operations
 * - Responsive Bootstrap 5 design
 * - Print-friendly layout
 *
 * @var array $data View data passed from ClassController::show() containing:
 *   - class: ClassModel object with class data
 *   - show_header: Boolean to show/hide page header
 */

$class = $data['class'];
$showHeader = $data['show_header'] ?? true;
?>

<div class="show-class-container">
    <?php if ($showHeader): ?>
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">
                    <i class="bi bi-eye me-2"></i>
                    Class Details
                </h2>
                <p class="text-muted mb-0">
                    Viewing details for: 
                    <strong><?php echo esc_html($class->getClassCode() ?: 'Class #' . $class->getId()); ?></strong>
                </p>
            </div>
            <div class="d-print-none">
                <button type="button" class="btn btn-outline-info me-2" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>
                    Print
                </button>
                <a href="?action=edit_class&class_id=<?php echo $class->getId(); ?>" class="btn btn-primary me-2">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Class
                </a>
                <a href="?action=classes_index" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Classes
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Class Status Banner -->
    <div class="alert alert-info mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h5 class="mb-1">
                    <?php echo esc_html($class->getClassSubject()); ?>
                </h5>
                <p class="mb-0">
                    <strong>Type:</strong> <?php echo esc_html($class->getClassType()); ?> | 
                    <strong>Duration:</strong> <?php echo intval($class->getClassDuration()); ?> hours |
                    <strong>Client:</strong> <?php echo esc_html($class->client_name ?? 'Unknown'); ?>
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <?php
                $startDate = $class->getOriginalStartDate();
                $status = 'Scheduled';
                $badgeClass = 'bg-primary';
                
                if ($startDate) {
                    if (strtotime($startDate) <= time()) {
                        $status = 'In Progress';
                        $badgeClass = 'bg-success';
                    }
                }
                ?>
                <span class="badge <?php echo $badgeClass; ?> fs-6">
                    <?php echo $status; ?>
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Basic Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Class Code:</strong><br>
                            <span class="text-muted"><?php echo esc_html($class->getClassCode() ?: 'Not generated'); ?></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Class Type:</strong><br>
                            <span class="text-muted"><?php echo esc_html($class->getClassType()); ?></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Subject:</strong><br>
                            <span class="text-muted"><?php echo esc_html($class->getClassSubject()); ?></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Duration:</strong><br>
                            <span class="text-muted"><?php echo intval($class->getClassDuration()); ?> hours</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Start Date:</strong><br>
                            <span class="text-muted">
                                <?php 
                                $startDate = $class->getOriginalStartDate();
                                echo $startDate ? date('F j, Y', strtotime($startDate)) : 'Not set';
                                ?>
                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Delivery Date:</strong><br>
                            <span class="text-muted">
                                <?php 
                                $deliveryDate = $class->getDeliveryDate();
                                echo $deliveryDate ? date('F j, Y', strtotime($deliveryDate)) : 'Not set';
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client & Site Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-building me-2"></i>
                        Client & Site Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Client:</strong><br>
                            <span class="text-muted"><?php echo esc_html($class->client_name ?? 'Unknown Client'); ?></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Site:</strong><br>
                            <span class="text-muted"><?php echo esc_html($class->site_name ?? 'Unknown Site'); ?></span>
                        </div>
                        <?php if ($class->getClassAddressLine()): ?>
                            <div class="col-12 mb-3">
                                <strong>Address:</strong><br>
                                <span class="text-muted"><?php echo esc_html($class->getClassAddressLine()); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Funding & Exam Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-cash-stack me-2"></i>
                        Funding & Exam Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>SETA Funded:</strong><br>
                            <span class="badge <?php echo $class->getSetaFunded() ? 'bg-success' : 'bg-secondary'; ?>">
                                <?php echo $class->getSetaFunded() ? 'Yes' : 'No'; ?>
                            </span>
                        </div>
                        <?php if ($class->getSetaFunded() && $class->getSeta()): ?>
                            <div class="col-md-6 mb-3">
                                <strong>SETA:</strong><br>
                                <span class="text-muted"><?php echo esc_html($class->getSeta()); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-6 mb-3">
                            <strong>Exam Class:</strong><br>
                            <span class="badge <?php echo $class->getExamClass() ? 'bg-warning' : 'bg-secondary'; ?>">
                                <?php echo $class->getExamClass() ? 'Yes' : 'No'; ?>
                            </span>
                        </div>
                        <?php if ($class->getExamClass() && $class->getExamType()): ?>
                            <div class="col-md-6 mb-3">
                                <strong>Exam Type:</strong><br>
                                <span class="text-muted"><?php echo esc_html($class->getExamType()); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Learners Information -->
            <?php 
            $learnerIds = $class->getLearnerIds();
            if (!empty($learnerIds)): 
            ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-people me-2"></i>
                            Assigned Learners (<?php echo count($learnerIds); ?>)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($learnerIds as $index => $learnerId): ?>
                                <div class="col-md-6 mb-2">
                                    <span class="badge bg-light text-dark">
                                        Learner ID: <?php echo intval($learnerId); ?>
                                    </span>
                                </div>
                                <?php if (($index + 1) % 4 === 0): ?>
                                    </div><div class="row">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Staff Assignments -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-badge me-2"></i>
                        Staff Assignments
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Class Agent:</strong><br>
                        <span class="text-muted">
                            <?php echo esc_html($class->agent_name ?? 'Not assigned'); ?>
                        </span>
                    </div>
                    
                    <?php if ($class->getProjectSupervisorId()): ?>
                        <div class="mb-3">
                            <strong>Project Supervisor:</strong><br>
                            <span class="text-muted">
                                <?php echo esc_html($class->supervisor_name ?? 'ID: ' . $class->getProjectSupervisorId()); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php 
                    $backupAgents = $class->getBackupAgentIds();
                    if (!empty($backupAgents)): 
                    ?>
                        <div class="mb-3">
                            <strong>Backup Agents:</strong><br>
                            <?php foreach ($backupAgents as $agentId): ?>
                                <span class="badge bg-secondary me-1 mb-1">
                                    Agent ID: <?php echo intval($agentId); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- QA Information -->
            <?php 
            $qaVisitDates = $class->getQaVisitDates();
            $qaReports = $class->getQaReports();
            if ($qaVisitDates || !empty($qaReports)): 
            ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-clipboard-check me-2"></i>
                            Quality Assurance
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if ($qaVisitDates): ?>
                            <div class="mb-3">
                                <strong>QA Visit Dates:</strong><br>
                                <span class="text-muted"><?php echo esc_html($qaVisitDates); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($qaReports)): ?>
                            <div class="mb-3">
                                <strong>QA Reports:</strong><br>
                                <?php foreach ($qaReports as $report): ?>
                                    <div class="mb-1">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>
                                        <small><?php echo esc_html($report['name'] ?? 'Report'); ?></small>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Class Notes -->
            <?php 
            $classNotes = $class->getClassNotesData();
            if (!empty($classNotes)): 
            ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-sticky me-2"></i>
                            Class Notes
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($classNotes as $note): ?>
                            <span class="badge bg-info me-1 mb-1">
                                <?php echo esc_html($note); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- System Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-2"></i>
                        System Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Class ID:</strong><br>
                        <span class="text-muted"><?php echo $class->getId(); ?></span>
                    </div>
                    <div class="mb-2">
                        <strong>Created:</strong><br>
                        <span class="text-muted">
                            <?php 
                            $created = $class->getCreatedAt();
                            echo $created ? date('M j, Y g:i A', strtotime($created)) : 'Unknown';
                            ?>
                        </span>
                    </div>
                    <div class="mb-0">
                        <strong>Last Updated:</strong><br>
                        <span class="text-muted">
                            <?php 
                            $updated = $class->getUpdatedAt();
                            echo $updated ? date('M j, Y g:i A', strtotime($updated)) : 'Never';
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons (Print Hidden) -->
    <div class="d-print-none mt-4">
        <div class="d-flex justify-content-center gap-2">
            <a href="?action=edit_class&class_id=<?php echo $class->getId(); ?>" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i>
                Edit This Class
            </a>
            <button type="button" class="btn btn-outline-danger" onclick="deleteClass(<?php echo $class->getId(); ?>)">
                <i class="bi bi-trash me-1"></i>
                Delete Class
            </button>
            <a href="?action=classes_index" class="btn btn-outline-secondary">
                <i class="bi bi-list me-1"></i>
                View All Classes
            </a>
        </div>
    </div>
</div>

<script>
function deleteClass(classId) {
    if (confirm('Are you sure you want to delete this class? This action cannot be undone.')) {
        // Implement AJAX delete functionality
        fetch(wecozaClass.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'delete_class',
                class_id: classId,
                nonce: wecozaClass.nonce
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Class deleted successfully.');
                window.location.href = '?action=classes_index';
            } else {
                alert('Failed to delete class: ' + (data.data || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the class.');
        });
    }
}
</script>
