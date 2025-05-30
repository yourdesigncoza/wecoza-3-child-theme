<?php
/**
 * ClassRoutes.php
 *
 * RESTful routing system for class operations
 * Provides clean URL structure and route handling for WordPress
 */

namespace WeCoza\Routes;

use WeCoza\Controllers\ClassController;

class ClassRoutes {
    
    private $controller;
    private $baseSlug;
    
    public function __construct(ClassController $controller = null, string $baseSlug = 'classes') {
        $this->controller = $controller ?? new ClassController();
        $this->baseSlug = $baseSlug;
    }
    
    /**
     * Initialize routing system
     */
    public function init() {
        // Add rewrite rules for clean URLs
        $this->addRewriteRules();
        
        // Add query vars
        add_filter('query_vars', [$this, 'addQueryVars']);
        
        // Handle template redirect
        add_action('template_redirect', [$this, 'handleRoutes']);
        
        // Register AJAX handlers
        $this->registerAjaxHandlers();
    }
    
    /**
     * Add rewrite rules for clean URLs
     */
    private function addRewriteRules() {
        // Classes index: /classes
        add_rewrite_rule(
            '^' . $this->baseSlug . '/?$',
            'index.php?wecoza_route=classes&wecoza_action=index',
            'top'
        );
        
        // Create class: /classes/create
        add_rewrite_rule(
            '^' . $this->baseSlug . '/create/?$',
            'index.php?wecoza_route=classes&wecoza_action=create',
            'top'
        );
        
        // Show class: /classes/{id}
        add_rewrite_rule(
            '^' . $this->baseSlug . '/([0-9]+)/?$',
            'index.php?wecoza_route=classes&wecoza_action=show&wecoza_id=$matches[1]',
            'top'
        );
        
        // Edit class: /classes/{id}/edit
        add_rewrite_rule(
            '^' . $this->baseSlug . '/([0-9]+)/edit/?$',
            'index.php?wecoza_route=classes&wecoza_action=edit&wecoza_id=$matches[1]',
            'top'
        );
        
        // Classes with pagination: /classes/page/{page}
        add_rewrite_rule(
            '^' . $this->baseSlug . '/page/([0-9]+)/?$',
            'index.php?wecoza_route=classes&wecoza_action=index&wecoza_page=$matches[1]',
            'top'
        );
        
        // Classes with filters: /classes/client/{client_id}
        add_rewrite_rule(
            '^' . $this->baseSlug . '/client/([0-9]+)/?$',
            'index.php?wecoza_route=classes&wecoza_action=index&wecoza_client_id=$matches[1]',
            'top'
        );
        
        // Classes with type filter: /classes/type/{type}
        add_rewrite_rule(
            '^' . $this->baseSlug . '/type/([^/]+)/?$',
            'index.php?wecoza_route=classes&wecoza_action=index&wecoza_class_type=$matches[1]',
            'top'
        );
    }
    
    /**
     * Add custom query variables
     */
    public function addQueryVars($vars) {
        $vars[] = 'wecoza_route';
        $vars[] = 'wecoza_action';
        $vars[] = 'wecoza_id';
        $vars[] = 'wecoza_page';
        $vars[] = 'wecoza_client_id';
        $vars[] = 'wecoza_class_type';
        $vars[] = 'wecoza_search';
        return $vars;
    }
    
    /**
     * Handle route requests
     */
    public function handleRoutes() {
        $route = get_query_var('wecoza_route');
        
        if ($route === 'classes') {
            $this->handleClassRoutes();
        }
    }
    
    /**
     * Handle class-specific routes
     */
    private function handleClassRoutes() {
        $action = get_query_var('wecoza_action', 'index');
        $id = get_query_var('wecoza_id');
        
        // Prepare attributes from query vars
        $atts = [
            'page' => get_query_var('wecoza_page', 1),
            'client_id' => get_query_var('wecoza_client_id'),
            'class_type' => get_query_var('wecoza_class_type'),
            'search' => get_query_var('wecoza_search'),
            'class_id' => $id
        ];
        
        // Remove empty attributes
        $atts = array_filter($atts, function($value) {
            return $value !== '' && $value !== null;
        });
        
        $content = '';
        
        switch ($action) {
            case 'index':
                $content = $this->controller->index($atts);
                break;
                
            case 'create':
                $content = $this->controller->create($atts);
                break;
                
            case 'show':
                if (!$id) {
                    $this->redirect404();
                    return;
                }
                $content = $this->controller->show($atts);
                break;
                
            case 'edit':
                if (!$id) {
                    $this->redirect404();
                    return;
                }
                $content = $this->controller->edit($atts);
                break;
                
            default:
                $this->redirect404();
                return;
        }
        
        // Output the content and exit
        $this->renderPage($content, $action, $id);
        exit;
    }
    
    /**
     * Register AJAX handlers
     */
    private function registerAjaxHandlers() {
        // Save/Update class
        add_action('wp_ajax_save_class', [ClassController::class, 'saveClassAjax']);
        add_action('wp_ajax_nopriv_save_class', [ClassController::class, 'saveClassAjax']);
        
        // Delete class
        add_action('wp_ajax_delete_class', [ClassController::class, 'destroy']);
        add_action('wp_ajax_nopriv_delete_class', [ClassController::class, 'destroy']);
        
        // Get class subjects (for dynamic dropdowns)
        add_action('wp_ajax_get_class_subjects', [$this->controller, 'getClassSubjectsAjax']);
        add_action('wp_ajax_nopriv_get_class_subjects', [$this->controller, 'getClassSubjectsAjax']);
    }
    
    /**
     * Render page with content
     */
    private function renderPage($content, $action, $id = null) {
        // Set page title based on action
        $pageTitle = $this->getPageTitle($action, $id);
        
        // Get WordPress header
        get_header();
        
        echo '<div class="container-fluid mt-4">';
        echo '<div class="row">';
        echo '<div class="col-12">';
        
        // Add breadcrumbs
        echo $this->renderBreadcrumbs($action, $id);
        
        // Output the main content
        echo $content;
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
        
        // Get WordPress footer
        get_footer();
    }
    
    /**
     * Get page title based on action
     */
    private function getPageTitle($action, $id = null) {
        switch ($action) {
            case 'index':
                return 'Classes Management';
            case 'create':
                return 'Create New Class';
            case 'show':
                return 'Class Details';
            case 'edit':
                return 'Edit Class';
            default:
                return 'Classes';
        }
    }
    
    /**
     * Render breadcrumbs navigation
     */
    private function renderBreadcrumbs($action, $id = null) {
        $breadcrumbs = ['<a href="' . home_url() . '">Home</a>'];
        
        // Always include classes index
        if ($action !== 'index') {
            $breadcrumbs[] = '<a href="' . $this->getUrl('index') . '">Classes</a>';
        } else {
            $breadcrumbs[] = 'Classes';
        }
        
        // Add specific action breadcrumb
        switch ($action) {
            case 'create':
                $breadcrumbs[] = 'Create New Class';
                break;
            case 'show':
                $breadcrumbs[] = '<a href="' . $this->getUrl('show', $id) . '">Class #' . $id . '</a>';
                break;
            case 'edit':
                $breadcrumbs[] = '<a href="' . $this->getUrl('show', $id) . '">Class #' . $id . '</a>';
                $breadcrumbs[] = 'Edit';
                break;
        }
        
        return '<nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">' . implode('</li><li class="breadcrumb-item">', $breadcrumbs) . '</li>
                    </ol>
                </nav>';
    }
    
    /**
     * Generate URL for specific action
     */
    public function getUrl($action, $id = null, $params = []) {
        $baseUrl = home_url('/' . $this->baseSlug);
        
        switch ($action) {
            case 'index':
                $url = $baseUrl;
                break;
            case 'create':
                $url = $baseUrl . '/create';
                break;
            case 'show':
                $url = $baseUrl . '/' . $id;
                break;
            case 'edit':
                $url = $baseUrl . '/' . $id . '/edit';
                break;
            default:
                $url = $baseUrl;
        }
        
        // Add query parameters if provided
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        return $url;
    }
    
    /**
     * Redirect to 404 page
     */
    private function redirect404() {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        get_template_part(404);
        exit;
    }
    
    /**
     * Flush rewrite rules (call this on activation/deactivation)
     */
    public static function flushRewriteRules() {
        // Re-add rules
        $routes = new self();
        $routes->addRewriteRules();
        
        // Flush
        flush_rewrite_rules();
    }
    
    /**
     * Get current route information
     */
    public function getCurrentRoute() {
        return [
            'route' => get_query_var('wecoza_route'),
            'action' => get_query_var('wecoza_action'),
            'id' => get_query_var('wecoza_id'),
            'page' => get_query_var('wecoza_page'),
            'client_id' => get_query_var('wecoza_client_id'),
            'class_type' => get_query_var('wecoza_class_type'),
            'search' => get_query_var('wecoza_search')
        ];
    }
    
    /**
     * Check if current request is a class route
     */
    public function isClassRoute() {
        return get_query_var('wecoza_route') === 'classes';
    }
}
