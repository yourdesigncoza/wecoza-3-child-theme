/**
 * WeCoza FullCalendar Integration
 * 
 * Handles FullCalendar initialization and functionality for class schedules
 * Following WordPress best practices and coding standards
 * 
 * @package WeCoza
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Global calendar instance
    let calendar = null;
    let classData = null;

    /**
     * Load FullCalendar from fallback CDN if not available
     */
    function loadFullCalendarFallback() {
        return new Promise((resolve, reject) => {
            if (typeof FullCalendar !== 'undefined') {
                resolve();
                return;
            }

            const script = document.createElement('script');
            script.src = window.wecozaCalendar?.fallbackCdn || 'https://unpkg.com/fullcalendar/index.global.min.js';
            script.onload = () => {
                resolve();
            };
            script.onerror = () => {
                reject(new Error('FullCalendar failed to load'));
            };
            document.head.appendChild(script);
        });
    }

    /**
     * WeCoza Calendar namespace
     */
    window.WeCozaCalendar = {

        /**
         * Initialize the calendar with class data
         * @param {Object} data - Class data from PHP
         */
        init: function(data) {
            classData = data;

            // Validate required data
            if (!data || !data.id) {
                this.showError('Invalid class data provided');
                return;
            }

            // Check if FullCalendar is loaded, try fallback if not
            if (typeof FullCalendar === 'undefined') {
                loadFullCalendarFallback()
                    .then(() => {
                        this.initializeCalendar();
                    })
                    .catch(() => {
                        this.showError('FullCalendar library not available');
                    });
            } else {
                this.initializeCalendar();
            }
        },

        /**
         * Initialize FullCalendar instance
         */
        initializeCalendar: function() {
            const calendarEl = document.getElementById('classCalendar');

            if (!calendarEl) {
                console.error('Calendar container not found');
                return;
            }

            // Debug: Log the class data being used
            console.log('Class data for calendar:', classData);

            // FullCalendar configuration
            const calendarConfig = {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                height: 'auto',
                aspectRatio: 1.8,

                // Event sources - using AJAX to load real events
                events: {
                    url: classData.ajaxUrl,
                    method: 'POST',
                    extraParams: {
                        action: 'get_class_calendar_events',
                        class_id: classData.id,
                        nonce: classData.nonce
                    },
                    failure: function() {
                        WeCozaCalendar.showError('Failed to load calendar events');
                    }
                },

                // Event rendering
                eventDisplay: 'block',
                eventColor: '#0d6efd',
                eventTextColor: '#ffffff',

                // Event interactions
                eventClick: function(info) {
                    WeCozaCalendar.handleEventClick(info);
                },

                // Date interactions
                dateClick: function(info) {
                    WeCozaCalendar.handleDateClick(info);
                },

                // Loading state
                loading: function(isLoading) {
                    WeCozaCalendar.toggleLoading(isLoading);
                },

                // Error handling
                eventSourceFailure: function() {
                    WeCozaCalendar.showError('Failed to load calendar events');
                }
            };

            // Initialize calendar
            try {
                calendar = new FullCalendar.Calendar(calendarEl, calendarConfig);
                calendar.render();

                // Hide loading state after successful render
                this.hideLoading();

            } catch (error) {
                this.showError('Failed to initialize calendar: ' + error.message);
            }
        },

        /**
         * Handle event click
         * @param {Object} info - Event click info
         */
        handleEventClick: function(info) {
            const event = info.event;
            
            // Create event details modal or tooltip
            const eventDetails = {
                title: event.title,
                start: event.start,
                end: event.end,
                description: event.extendedProps.description || '',
                type: event.extendedProps.type || 'class'
            };

            this.showEventDetails(eventDetails);
        },

        /**
         * Handle date click
         * @param {Object} info - Date click info
         */
        handleDateClick: function(info) {
            // Optional: Add functionality for clicking on dates
            console.log('Date clicked:', info.dateStr);
        },

        /**
         * Show event details in a modal or tooltip
         * @param {Object} eventDetails - Event details object
         */
        showEventDetails: function(eventDetails) {
            // Create a simple alert for now - can be enhanced with Bootstrap modal
            const startDate = eventDetails.start ? eventDetails.start.toLocaleDateString() : 'N/A';
            const startTime = eventDetails.start ? eventDetails.start.toLocaleTimeString() : 'N/A';
            
            let message = `Event: ${eventDetails.title}\n`;
            message += `Date: ${startDate}\n`;
            message += `Time: ${startTime}\n`;
            
            if (eventDetails.description) {
                message += `Description: ${eventDetails.description}`;
            }

            alert(message);
        },

        /**
         * Toggle loading state
         * @param {boolean} isLoading - Loading state
         */
        toggleLoading: function(isLoading) {
            if (isLoading) {
                this.showLoading();
            } else {
                this.hideLoading();
            }
        },

        /**
         * Show loading indicator
         */
        showLoading: function() {
            const loadingEl = document.getElementById('calendar-loading');
            if (loadingEl) {
                loadingEl.style.display = 'block';
            }
        },

        /**
         * Hide loading indicator
         */
        hideLoading: function() {
            const loadingEl = document.getElementById('calendar-loading');
            if (loadingEl) {
                loadingEl.style.display = 'none';
            }
        },

        /**
         * Show error message
         * @param {string} message - Error message
         */
        showError: function(message) {
            console.error('WeCoza Calendar Error:', message);
            
            const loadingEl = document.getElementById('calendar-loading');
            const errorEl = document.getElementById('calendar-error');
            const messageEl = document.getElementById('calendar-error-message');
            
            if (loadingEl) loadingEl.style.display = 'none';
            if (errorEl) {
                errorEl.classList.remove('d-none');
                if (messageEl) messageEl.textContent = message;
            }
        },

        /**
         * Refresh calendar events
         */
        refreshEvents: function() {
            if (calendar) {
                calendar.refetchEvents();
            }
        },

        /**
         * Get calendar instance
         * @returns {Object|null} FullCalendar instance
         */
        getCalendar: function() {
            return calendar;
        }
    };

})(jQuery);
