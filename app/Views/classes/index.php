<?php
/**
 * Classes Index View
 *
 * This view displays a paginated list of all classes with filtering and search capabilities.
 * It follows the MVC architecture pattern where this file (View) is responsible only for presentation.
 *
 * Features:
 * - Paginated class listing
 * - Search and filter functionality
 * - Client and class type filtering
 * - Responsive Bootstrap 5 design
 * - Action buttons for view/edit/delete operations
 *
 * @var array $data View data passed from ClassController::index() containing:
 *   - classes: Array of ClassModel objects
 *   - pagination: Pagination information (current_page, per_page, total, total_pages)
 *   - filters: Current filter values
 *   - clients: Array of client data for filter dropdown
 *   - class_types: Array of class type data for filter dropdown
 */
?>

<div class="classes-index-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-list-ul me-2"></i>
            Classes Management
        </h2>
        <a href="#" class="btn btn-primary" onclick="createNewClass()">
            <i class="bi bi-plus-circle me-1"></i>
            Add New Class
        </a>
    </div>

    <!-- Filters Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-funnel me-2"></i>
                Filters & Search
            </h5>
        </div>
        <div class="card-body">
            <form id="classes-filter-form" method="GET">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input 
                                type="text" 
                                id="search" 
                                name="search" 
                                class="form-control" 
                                placeholder="Search classes..."
                                value="<?php echo esc_attr($data['filters']['search'] ?? ''); ?>"
                            >
                            <label for="search">Search Classes</label>
                        </div>
                    </div>

                    <!-- Client Filter -->
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select id="client_id" name="client_id" class="form-select">
                                <option value="">All Clients</option>
                                <?php foreach ($data['clients'] as $client): ?>
                                    <option 
                                        value="<?php echo esc_attr($client['id']); ?>"
                                        <?php selected($data['filters']['client_id'] ?? '', $client['id']); ?>
                                    >
                                        <?php echo esc_html($client['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="client_id">Client</label>
                        </div>
                    </div>

                    <!-- Class Type Filter -->
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select id="class_type" name="class_type" class="form-select">
                                <option value="">All Types</option>
                                <?php foreach ($data['class_types'] as $type): ?>
                                    <option 
                                        value="<?php echo esc_attr($type['id']); ?>"
                                        <?php selected($data['filters']['class_type'] ?? '', $type['id']); ?>
                                    >
                                        <?php echo esc_html($type['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="class_type">Class Type</label>
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100 h-100">
                            <i class="bi bi-search me-1"></i>
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-muted">
            Showing <?php echo count($data['classes']); ?> of <?php echo $data['pagination']['total']; ?> classes
        </div>
        <div class="text-muted">
            Page <?php echo $data['pagination']['current_page']; ?> of <?php echo $data['pagination']['total_pages']; ?>
        </div>
    </div>

    <!-- Classes Table -->
    <?php if (!empty($data['classes'])): ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Class Code</th>
                                <th>Client</th>
                                <th>Type & Subject</th>
                                <th>Start Date</th>
                                <th>Duration</th>
                                <th>Agent</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['classes'] as $class): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo esc_html($class->getClassCode() ?: 'N/A'); ?></strong>
                                    </td>
                                    <td>
                                        <?php echo esc_html($class->client_name ?? 'Unknown Client'); ?>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?php echo esc_html($class->getClassType()); ?></strong>
                                        </div>
                                        <small class="text-muted">
                                            <?php echo esc_html($class->getClassSubject()); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php 
                                        $startDate = $class->getOriginalStartDate();
                                        echo $startDate ? date('M j, Y', strtotime($startDate)) : 'Not set';
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo intval($class->getClassDuration()); ?> hours
                                    </td>
                                    <td>
                                        <?php echo esc_html($class->agent_name ?? 'Not assigned'); ?>
                                    </td>
                                    <td>
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
                                        <span class="badge <?php echo $badgeClass; ?>">
                                            <?php echo $status; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button 
                                                type="button" 
                                                class="btn btn-outline-info" 
                                                onclick="viewClass(<?php echo $class->getId(); ?>)"
                                                title="View Details"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button 
                                                type="button" 
                                                class="btn btn-outline-primary" 
                                                onclick="editClass(<?php echo $class->getId(); ?>)"
                                                title="Edit Class"
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button 
                                                type="button" 
                                                class="btn btn-outline-danger" 
                                                onclick="deleteClass(<?php echo $class->getId(); ?>)"
                                                title="Delete Class"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($data['pagination']['total_pages'] > 1): ?>
            <nav aria-label="Classes pagination" class="mt-4">
                <ul class="pagination justify-content-center">
                    <!-- Previous Page -->
                    <?php if ($data['pagination']['current_page'] > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $data['pagination']['current_page'] - 1; ?>">
                                <i class="bi bi-chevron-left"></i>
                                Previous
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <?php
                    $start = max(1, $data['pagination']['current_page'] - 2);
                    $end = min($data['pagination']['total_pages'], $data['pagination']['current_page'] + 2);
                    
                    for ($i = $start; $i <= $end; $i++):
                    ?>
                        <li class="page-item <?php echo $i === $data['pagination']['current_page'] ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next Page -->
                    <?php if ($data['pagination']['current_page'] < $data['pagination']['total_pages']): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $data['pagination']['current_page'] + 1; ?>">
                                Next
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>

    <?php else: ?>
        <!-- No Classes Found -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                <h4 class="text-muted">No Classes Found</h4>
                <p class="text-muted mb-4">
                    <?php if (!empty($data['filters']['search']) || !empty($data['filters']['client_id']) || !empty($data['filters']['class_type'])): ?>
                        No classes match your current filters. Try adjusting your search criteria.
                    <?php else: ?>
                        There are no classes in the system yet. Create your first class to get started.
                    <?php endif; ?>
                </p>
                <button type="button" class="btn btn-primary" onclick="createNewClass()">
                    <i class="bi bi-plus-circle me-1"></i>
                    Create First Class
                </button>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// JavaScript functions for class actions
function createNewClass() {
    // Navigate to create class page
    window.location.href = '?action=create_class';
}

function viewClass(classId) {
    // Navigate to view class page
    window.location.href = '?action=view_class&class_id=' + classId;
}

function editClass(classId) {
    // Navigate to edit class page
    window.location.href = '?action=edit_class&class_id=' + classId;
}

function deleteClass(classId) {
    if (confirm('Are you sure you want to delete this class? This action cannot be undone.')) {
        // Implement AJAX delete functionality
        // This would call the destroy method via AJAX
        console.log('Delete class:', classId);
    }
}
</script>
