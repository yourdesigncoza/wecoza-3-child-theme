/**
 * Class Calendar Initialization
 *
 * This file handles the initialization of the class calendar
 * when the page loads or when a tab containing the calendar is activated.
 *
 * Updated to support multiMonthYear view for yearly calendar display.
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

    // Override the global initializeClassCalendar function to ensure multiMonthYear view is used
    window.initializeClassCalendar = function() {
        console.log('Manual calendar initialization triggered with multiMonthYear view');
        if (typeof initializeCalendarInTab === 'function') {
            initializeCalendarInTab();

            // Ensure the calendar is using multiMonthYear view
            if (window.calendar && typeof window.calendar.changeView === 'function') {
                window.calendar.changeView('multiMonthYear');
                console.log('Calendar view set to multiMonthYear');

                // Add public holidays to the calendar if available
                if (typeof wecozaPublicHolidays !== 'undefined' && wecozaPublicHolidays.events) {
                    addPublicHolidaysToCalendar();
                }
            }
        }
    };

    /**
     * Add public holidays to the calendar
     */
    function addPublicHolidaysToCalendar() {
        if (!window.calendar || !wecozaPublicHolidays || !wecozaPublicHolidays.events) {
            console.log('Cannot add public holidays: calendar or holiday data not available');
            return;
        }

        console.log('Adding public holidays to calendar');

        // Debug: Log all holidays
        console.log('All holidays:', JSON.stringify(wecozaPublicHolidays.events));

        // Remove existing public holiday events to avoid duplicates
        const existingEvents = window.calendar.getEvents();
        existingEvents.forEach(event => {
            if (event.extendedProps && event.extendedProps.isPublicHoliday) {
                event.remove();
            }
        });

        // Add public holiday events
        wecozaPublicHolidays.events.forEach(holiday => {
            // Get the date string from the event (YYYY-MM-DD)
            const holidayDate = holiday.start;

            console.log('Adding public holiday:', holiday.title, 'on date:', holidayDate);

            // Parse the date parts to ensure correct date (avoid timezone issues)
            const [year, month, day] = holidayDate.split('-').map(Number);

            // Create a date object using the date parts
            // This preserves the day regardless of timezone
            const eventDate = new Date(year, month - 1, day);

            console.log('Holiday date object:', eventDate.toDateString());

            // Create the event
            window.calendar.addEvent({
                title: holiday.title,
                start: eventDate,
                allDay: true,
                className: 'public-holiday',
                backgroundColor: '#f44336', // Red color for public holidays
                borderColor: '#d32f2f',
                textColor: '#ffffff',
                extendedProps: {
                    isPublicHoliday: true,
                    description: holiday.description,
                    isObserved: holiday.extendedProps && holiday.extendedProps.isObserved
                }
            });
        });

        console.log('Added ' + wecozaPublicHolidays.events.length + ' public holidays to calendar');
    }

})(jQuery);
