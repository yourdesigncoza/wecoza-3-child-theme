/**
 * Calendar Export JavaScript
 * 
 * This file contains the JavaScript functionality for exporting calendar data
 * to iCalendar format for use with external calendar applications.
 */

(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        initExportFunctionality();
    });

    /**
     * Initialize export functionality
     */
    function initExportFunctionality() {
        // Export calendar button click handler
        $('#export-calendar-btn').on('click', function() {
            exportCalendar();
        });
    }

    /**
     * Export calendar data to iCalendar format
     */
    function exportCalendar() {
        // Show loading indicator
        showLoading('Preparing calendar export...');

        // Get class IDs to export (empty array means all classes)
        const classIds = [];

        // Create form data
        const formData = new FormData();
        formData.append('action', 'export_calendar');
        formData.append('nonce', wecozaClass.nonce);
        formData.append('class_ids', JSON.stringify(classIds));

        // Create a temporary form and submit it to trigger the download
        const form = document.createElement('form');
        form.method = 'post';
        form.action = wecozaClass.ajaxUrl;
        form.target = '_blank';

        // Add action parameter
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'export_calendar';
        form.appendChild(actionInput);

        // Add nonce parameter
        const nonceInput = document.createElement('input');
        nonceInput.type = 'hidden';
        nonceInput.name = 'nonce';
        nonceInput.value = wecozaClass.nonce;
        form.appendChild(nonceInput);

        // Add class IDs parameter
        const classIdsInput = document.createElement('input');
        classIdsInput.type = 'hidden';
        classIdsInput.name = 'class_ids';
        classIdsInput.value = JSON.stringify(classIds);
        form.appendChild(classIdsInput);

        // Submit the form
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Hide loading indicator after a short delay
        setTimeout(function() {
            hideLoading();
        }, 1000);
    }

    /**
     * Show loading indicator
     * 
     * @param {string} message Loading message to display
     */
    function showLoading(message) {
        // Create loading overlay if it doesn't exist
        if ($('#loading-overlay').length === 0) {
            $('body').append(`
                <div id="loading-overlay" style="display:none;">
                    <div class="loading-content">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div id="loading-message" class="mt-2"></div>
                    </div>
                </div>
            `);

            // Add CSS for loading overlay
            $('head').append(`
                <style>
                    #loading-overlay {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.5);
                        z-index: 9999;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    .loading-content {
                        background-color: white;
                        padding: 20px;
                        border-radius: 5px;
                        text-align: center;
                    }
                </style>
            `);
        }

        // Set loading message
        $('#loading-message').text(message);

        // Show loading overlay
        $('#loading-overlay').fadeIn(200);
    }

    /**
     * Hide loading indicator
     */
    function hideLoading() {
        $('#loading-overlay').fadeOut(200);
    }

})(jQuery);
