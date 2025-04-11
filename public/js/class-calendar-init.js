/**
 * Class Calendar Initialization
 * 
 * This file handles the initialization of the class calendar
 * when the page loads or when a tab containing the calendar is activated.
 */

(function($) {
    'use strict';

    /**
     * Initialize the calendar when the document is ready
     */
    $(document).ready(function() {
        initCalendarWithDelay();
        
        // Also initialize when a tab containing the calendar is clicked
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            var targetId = $(e.target).attr('href');
            if ($(targetId).find('#class-calendar').length > 0) {
                initCalendarWithDelay();
            }
        });
    });

    /**
     * Initialize the calendar with a short delay
     * This helps ensure all dependencies are loaded
     */
    function initCalendarWithDelay() {
        setTimeout(function() {
            if (typeof initializeClassCalendar === 'function') {
                initializeClassCalendar();
            }
        }, 500);
    }

})(jQuery);
