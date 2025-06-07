<?php
/**
 * Shortcode List View
 *
 * This view displays a comprehensive list of all available WeCoza shortcodes in a Bootstrap 5 compatible format.
 * Used by the [wecoza_shortcode_list] shortcode to provide documentation and reference for developers.
 *
 * Available Variables:
 *   - $shortcodes: Array of shortcode data with name, description, usage, parameters, etc.
 *   - $show_loading: Boolean indicating whether to show loading indicator
 *   - $total_count: Total number of shortcodes available
 *   - $category_filter: String indicating category filter (future enhancement)
 *
 * Shortcode Data Structure:
 *   Each shortcode array contains:
 *   - name: The shortcode name (e.g., 'wecoza_capture_class')
 *   - category: Functional category (e.g., 'Class Management', 'Reporting')
 *   - description: Brief description of functionality
 *   - usage: Example usage with parameters
 *   - parameters: List of available parameters
 *   - controller: Controller class handling the shortcode
 *   - view: View file path for the shortcode
 *   - url_params: Boolean indicating if shortcode accepts URL parameters
 *   - shortcode_attrs: Boolean indicating if shortcode accepts shortcode attributes
 *
 * Bootstrap Components Used:
 *   - Card layout with header and body
 *   - Responsive table with hover effects
 *   - Badge components for categories and parameter types
 *   - Alert components for status messages
 *   - Icons from Bootstrap Icons
 *
 * Styling:
 *   - Uses existing ydcoza-styles.css for consistent theming
 *   - No inline CSS - all styling through CSS classes
 *   - Responsive design for mobile compatibility
 *   - Consistent with other WeCoza components
 *
 * Security:
 *   - All output is properly escaped using esc_html()
 *   - No user input processing in this view
 *   - Read-only display of static shortcode information
 *
 * @package WeCoza
 * @see \WeCoza\Controllers\ShortcodeListController::displayShortcodeList() For the controller method that renders this view
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Ensure we have the shortcodes data
$shortcodes = $shortcodes ?? [];
$show_loading = $show_loading ?? true;
$total_count = $total_count ?? 0;
$category_filter = $category_filter ?? 'all';

// Group shortcodes by category for better organization
$grouped_shortcodes = [];
foreach ($shortcodes as $shortcode) {
    $category = $shortcode['category'] ?? 'Other';
    if (!isset($grouped_shortcodes[$category])) {
        $grouped_shortcodes[$category] = [];
    }
    $grouped_shortcodes[$category][] = $shortcode;
}
?>

<div class="wecoza-shortcode-list">
    <?php if ($show_loading): ?>
        <!-- Loading Indicator -->
        <div id="shortcode-list-loading" class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading shortcodes...</span>
            </div>
            <p class="text-muted mt-2 mb-0">Loading available shortcodes...</p>
        </div>
    <?php endif; ?>

    <div id="shortcode-list-content" class="<?php echo $show_loading ? 'd-none' : ''; ?>">
        <?php if (empty($shortcodes)): ?>
            <!-- No Shortcodes Found -->
            <div class="alert alert-info d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                <div>
                    <h6 class="alert-heading mb-1">No Shortcodes Found</h6>
                    <p class="mb-0">There are currently no shortcodes available in the system.</p>
                </div>
            </div>
        <?php else: ?>
            <!-- Shortcodes List -->
            <div class="card shadow-none border my-3" data-component-card="data-component-card">
                <div class="card-header p-3 border-bottom bg-body">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-body mb-0" data-anchor="data-anchor" id="shortcodes-table-header">
                                <i class="bi bi-code-square me-2"></i>
                                Available Shortcodes
                            </h4>
                            <p class="text-muted fs-9 mb-0 mt-1">
                                Displaying <?php echo esc_html($total_count); ?> shortcodes across <?php echo count($grouped_shortcodes); ?> categories
                            </p>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="refreshShortcodeList()">
                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                    Refresh
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="printShortcodeList()">
                                    <i class="bi bi-printer me-1"></i>
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php foreach ($grouped_shortcodes as $category => $category_shortcodes): ?>
                        <!-- Category Section -->
                        <div class="category-section">
                            <div class="ydcoza-table-subheader">
                                <h6 class="mb-0 py-2 px-3 text-body-emphasis">
                                    <i class="bi bi-folder me-2"></i>
                                    <?php echo esc_html($category); ?>
                                    <span class="badge bg-secondary ms-2"><?php echo count($category_shortcodes); ?></span>
                                </h6>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover table-sm fs-9 mb-0">
                                    <thead class="border-bottom">
                                        <tr>
                                            <th scope="col" class="border-0 ps-4" style="width: 20%;">
                                                <i class="bi bi-tag me-1"></i>
                                                Shortcode Name
                                            </th>
                                            <th scope="col" class="border-0" style="width: 30%;">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Description
                                            </th>
                                            <th scope="col" class="border-0" style="width: 25%;">
                                                <i class="bi bi-code me-1"></i>
                                                Usage Example
                                            </th>
                                            <th scope="col" class="border-0" style="width: 15%;">
                                                <i class="bi bi-gear me-1"></i>
                                                Parameters
                                            </th>
                                            <th scope="col" class="border-0 pe-4" style="width: 10%;">
                                                <i class="bi bi-arrow-right-circle me-1"></i>
                                                Input Type
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($category_shortcodes as $shortcode): ?>
                                        <tr>
                                            <td class="align-middle ps-4">
                                                <div class="d-flex align-items-center">
                                                    <code class="text-primary fw-bold">[<?php echo esc_html($shortcode['name']); ?>]</code>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <p class="mb-1 text-body-emphasis">
                                                    <?php echo esc_html($shortcode['description']); ?>
                                                </p>
                                                <small class="text-muted">
                                                    Controller: <?php echo esc_html($shortcode['controller']); ?>
                                                </small>
                                            </td>
                                            <td class="align-middle">
                                                <code class="text-dark bg-light p-1 rounded small">
                                                    <?php echo esc_html($shortcode['usage']); ?>
                                                </code>
                                            </td>
                                            <td class="align-middle">
                                                <?php if (!empty($shortcode['parameters'])): ?>
                                                    <small class="text-muted">
                                                        <?php echo esc_html($shortcode['parameters']); ?>
                                                    </small>
                                                <?php else: ?>
                                                    <span class="text-muted">None</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle pe-4">
                                                <div class="d-flex flex-column gap-1">
                                                    <?php if ($shortcode['url_params']): ?>
                                                        <span class="badge bg-primary-subtle text-primary-emphasis">URL Params</span>
                                                    <?php endif; ?>
                                                    <?php if ($shortcode['shortcode_attrs']): ?>
                                                        <span class="badge bg-success-subtle text-success-emphasis">Attributes</span>
                                                    <?php endif; ?>
                                                    <?php if (!$shortcode['url_params'] && !$shortcode['shortcode_attrs']): ?>
                                                        <span class="badge bg-secondary-subtle text-secondary-emphasis">Static</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Summary Information -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card border-0 bg-primary bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-code-square fs-1 text-primary mb-2"></i>
                            <h5 class="card-title text-primary"><?php echo esc_html($total_count); ?></h5>
                            <p class="card-text text-muted small mb-0">Total Shortcodes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-folder fs-1 text-success mb-2"></i>
                            <h5 class="card-title text-success"><?php echo count($grouped_shortcodes); ?></h5>
                            <p class="card-text text-muted small mb-0">Categories</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-info bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-gear fs-1 text-info mb-2"></i>
                            <h5 class="card-title text-info">
                                <?php 
                                $mvc_count = count(array_filter($shortcodes, function($s) { 
                                    return strpos($s['controller'], 'Controller') !== false && $s['controller'] !== 'Legacy implementation'; 
                                }));
                                echo esc_html($mvc_count);
                                ?>
                            </h5>
                            <p class="card-text text-muted small mb-0">MVC Architecture</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-arrow-right-circle fs-1 text-warning mb-2"></i>
                            <h5 class="card-title text-warning">
                                <?php 
                                $url_params_count = count(array_filter($shortcodes, function($s) { 
                                    return $s['url_params']; 
                                }));
                                echo esc_html($url_params_count);
                                ?>
                            </h5>
                            <p class="card-text text-muted small mb-0">URL Parameter Support</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Instructions -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="bi bi-lightbulb me-2"></i>
                    Usage Instructions
                </h6>
                <ul class="mb-0">
                    <li><strong>URL Params:</strong> Shortcodes that accept parameters via URL query strings (e.g., ?mode=create&class_id=123)</li>
                    <li><strong>Attributes:</strong> Shortcodes that accept parameters as shortcode attributes (e.g., [shortcode param="value"])</li>
                    <li><strong>Static:</strong> Shortcodes that require no parameters and display fixed content</li>
                    <li><strong>MVC Architecture:</strong> Modern shortcodes following the WeCoza MVC pattern with dedicated controllers and views</li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($show_loading): ?>
<script>
// Hide loading indicator after page load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const loading = document.getElementById('shortcode-list-loading');
        const content = document.getElementById('shortcode-list-content');
        
        if (loading) loading.style.display = 'none';
        if (content) content.classList.remove('d-none');
    }, 500);
});

// Refresh function
function refreshShortcodeList() {
    location.reload();
}

// Print function
function printShortcodeList() {
    window.print();
}
</script>
<?php endif; ?>
