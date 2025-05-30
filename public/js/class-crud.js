/**
 * Class CRUD Operations JavaScript
 * 
 * Optimized JavaScript for handling class CRUD operations with the new RESTful architecture
 * Replaces mixed-mode logic with dedicated functions for each operation
 */

class ClassCRUD {
    constructor() {
        this.baseUrl = window.location.origin;
        this.ajaxUrl = wecozaClass?.ajaxUrl || '/wp-admin/admin-ajax.php';
        this.nonce = wecozaClass?.nonce || '';
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.initializeFormValidation();
        this.setupAjaxDefaults();
    }
    
    /**
     * Bind event listeners
     */
    bindEvents() {
        // Form submissions
        document.addEventListener('submit', (e) => {
            if (e.target.matches('#create-class-form')) {
                e.preventDefault();
                this.handleCreateForm(e.target);
            } else if (e.target.matches('#edit-class-form')) {
                e.preventDefault();
                this.handleUpdateForm(e.target);
            }
        });
        
        // Delete buttons
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-action="delete-class"]') || 
                e.target.closest('[data-action="delete-class"]')) {
                e.preventDefault();
                const button = e.target.matches('[data-action="delete-class"]') ? 
                    e.target : e.target.closest('[data-action="delete-class"]');
                const classId = button.dataset.classId;
                this.handleDelete(classId);
            }
        });
        
        // Navigation buttons
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-action="view-class"]')) {
                e.preventDefault();
                const classId = e.target.dataset.classId;
                this.navigateToView(classId);
            } else if (e.target.matches('[data-action="edit-class"]')) {
                e.preventDefault();
                const classId = e.target.dataset.classId;
                this.navigateToEdit(classId);
            }
        });
        
        // Filter form
        const filterForm = document.getElementById('classes-filter-form');
        if (filterForm) {
            filterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleFilter(filterForm);
            });
        }
    }
    
    /**
     * Initialize form validation
     */
    initializeFormValidation() {
        // Bootstrap validation
        const forms = document.querySelectorAll('.needs-validation');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    }
    
    /**
     * Setup AJAX defaults
     */
    setupAjaxDefaults() {
        // Add nonce to all AJAX requests
        const originalFetch = window.fetch;
        window.fetch = function(url, options = {}) {
            if (url.includes('admin-ajax.php')) {
                options.headers = options.headers || {};
                if (options.body instanceof FormData) {
                    if (!options.body.has('nonce')) {
                        options.body.append('nonce', wecozaClass.nonce);
                    }
                }
            }
            return originalFetch(url, options);
        };
    }
    
    /**
     * Handle create form submission
     */
    async handleCreateForm(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        try {
            // Show loading state
            this.setButtonLoading(submitBtn, 'Creating...');
            
            // Prepare form data
            const formData = new FormData(form);
            formData.append('action', 'save_class');
            
            // Submit via AJAX
            const response = await fetch(this.ajaxUrl, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showMessage('success', data.data.message || 'Class created successfully!');
                
                // Redirect after short delay
                setTimeout(() => {
                    if (data.data.class_id) {
                        this.navigateToView(data.data.class_id);
                    } else {
                        this.navigateToIndex();
                    }
                }, 1500);
            } else {
                this.showMessage('error', data.data || 'Failed to create class. Please try again.');
                this.restoreButton(submitBtn, originalText);
            }
        } catch (error) {
            console.error('Error creating class:', error);
            this.showMessage('error', 'An unexpected error occurred. Please try again.');
            this.restoreButton(submitBtn, originalText);
        }
    }
    
    /**
     * Handle update form submission
     */
    async handleUpdateForm(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        try {
            // Show loading state
            this.setButtonLoading(submitBtn, 'Updating...');
            
            // Prepare form data
            const formData = new FormData(form);
            formData.append('action', 'save_class');
            
            // Submit via AJAX
            const response = await fetch(this.ajaxUrl, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showMessage('success', data.data.message || 'Class updated successfully!');
                
                // Redirect after short delay
                setTimeout(() => {
                    this.navigateToView(data.data.class_id);
                }, 1500);
            } else {
                this.showMessage('error', data.data || 'Failed to update class. Please try again.');
                this.restoreButton(submitBtn, originalText);
            }
        } catch (error) {
            console.error('Error updating class:', error);
            this.showMessage('error', 'An unexpected error occurred. Please try again.');
            this.restoreButton(submitBtn, originalText);
        }
    }
    
    /**
     * Handle class deletion
     */
    async handleDelete(classId) {
        if (!confirm('Are you sure you want to delete this class? This action cannot be undone.')) {
            return;
        }
        
        try {
            const formData = new FormData();
            formData.append('action', 'delete_class');
            formData.append('class_id', classId);
            formData.append('nonce', this.nonce);
            
            const response = await fetch(this.ajaxUrl, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showMessage('success', 'Class deleted successfully.');
                
                // Remove from DOM if on index page, otherwise redirect
                const classRow = document.querySelector(`[data-class-id="${classId}"]`);
                if (classRow) {
                    classRow.remove();
                } else {
                    setTimeout(() => this.navigateToIndex(), 1500);
                }
            } else {
                this.showMessage('error', data.data || 'Failed to delete class.');
            }
        } catch (error) {
            console.error('Error deleting class:', error);
            this.showMessage('error', 'An unexpected error occurred while deleting the class.');
        }
    }
    
    /**
     * Handle filter form submission
     */
    handleFilter(form) {
        const formData = new FormData(form);
        const params = new URLSearchParams();
        
        for (let [key, value] of formData.entries()) {
            if (value.trim() !== '') {
                params.append(key, value);
            }
        }
        
        // Navigate to filtered results
        const url = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.location.href = url;
    }
    
    /**
     * Navigation methods
     */
    navigateToIndex() {
        window.location.href = this.baseUrl + '/classes';
    }
    
    navigateToCreate() {
        window.location.href = this.baseUrl + '/classes/create';
    }
    
    navigateToView(classId) {
        window.location.href = this.baseUrl + '/classes/' + classId;
    }
    
    navigateToEdit(classId) {
        window.location.href = this.baseUrl + '/classes/' + classId + '/edit';
    }
    
    /**
     * Utility methods
     */
    setButtonLoading(button, text) {
        button.innerHTML = `<i class="bi bi-hourglass-split me-2"></i>${text}`;
        button.disabled = true;
    }
    
    restoreButton(button, originalText) {
        button.innerHTML = originalText;
        button.disabled = false;
    }
    
    showMessage(type, message) {
        const container = document.getElementById('form-messages') || this.createMessageContainer();
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
        
        // Auto-hide success messages after 5 seconds
        if (type === 'success') {
            setTimeout(() => {
                const alert = container.querySelector('.alert');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }
    }
    
    createMessageContainer() {
        const container = document.createElement('div');
        container.id = 'form-messages';
        container.className = 'mt-3';
        
        // Insert after main content
        const mainContent = document.querySelector('.container-fluid, .container, main') || document.body;
        mainContent.appendChild(container);
        
        return container;
    }
}

// Global functions for backward compatibility
window.createNewClass = function() {
    window.classCRUD.navigateToCreate();
};

window.viewClass = function(classId) {
    window.classCRUD.navigateToView(classId);
};

window.editClass = function(classId) {
    window.classCRUD.navigateToEdit(classId);
};

window.deleteClass = function(classId) {
    window.classCRUD.handleDelete(classId);
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.classCRUD = new ClassCRUD();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ClassCRUD;
}
