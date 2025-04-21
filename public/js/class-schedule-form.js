/**
 * Class Schedule Form JavaScript
 *
 * Handles the client-side functionality for the class schedule form
 * and the view-only calendar reference.
 */
(function($) {
    'use strict';

    // Calendar instance
    var calendar;
    var calendarInitialized = false;

    /**
     * Initialize the class schedule form
     */
    function initClassScheduleForm() {
        // Initialize schedule pattern selection
        initSchedulePatternSelection();

        // Initialize time selection and duration calculation
        initTimeSelection();

        // Initialize exception dates
        initExceptionDates();

        // Initialize calendar toggle
        initCalendarToggle();

        // Initialize schedule data updates
        initScheduleDataUpdates();
    }

    /**
     * Initialize schedule pattern selection
     */
    function initSchedulePatternSelection() {
        const $schedulePattern = $('#schedule_pattern');
        const $daySelection = $('#day-selection-container');
        const $dayOfMonth = $('#day-of-month-container');

        $schedulePattern.on('change', function() {
            const pattern = $(this).val();

            // Reset visibility
            $daySelection.addClass('d-none');
            $dayOfMonth.addClass('d-none');

            // Show appropriate fields based on pattern
            if (pattern === 'weekly' || pattern === 'biweekly') {
                $daySelection.removeClass('d-none');
                $('#schedule_day').attr('required', 'required');
                $('#schedule_day_of_month').removeAttr('required');
            } else if (pattern === 'monthly') {
                $dayOfMonth.removeClass('d-none');
                $('#schedule_day_of_month').attr('required', 'required');
                $('#schedule_day').removeAttr('required');
            } else if (pattern === 'custom') {
                // For custom pattern, we'll use the calendar view
                $('#view-calendar-btn').trigger('click');
            }

            // Update schedule data
            updateScheduleData();

            // Recalculate end date when pattern changes
            recalculateEndDate();
        });

        // Handle day selection changes
        $('#schedule_day, #schedule_day_of_month').on('change', function() {
            updateScheduleData();
            restrictStartDateByDay();
            // Recalculate end date when day changes
            recalculateEndDate();
        });

        // Restrict start date based on selected day
        function restrictStartDateByDay() {
            const selectedDay = $('#schedule_day').val();
            const $startDate = $('#schedule_start_date');

            if (selectedDay && !$('#day-selection-container').hasClass('d-none')) {
                // Get the current date value
                const currentDate = $startDate.val();

                if (currentDate) {
                    const date = new Date(currentDate);
                    const dayIndex = getDayIndex(selectedDay);

                    // If the current date is not the selected day, find the next occurrence
                    if (date.getDay() !== dayIndex) {
                        // Find the next occurrence of the selected day
                        while (date.getDay() !== dayIndex) {
                            date.setDate(date.getDate() + 1);
                        }

                        // Update the start date
                        $startDate.val(date.toISOString().split('T')[0]);
                        console.log('Start date adjusted to match day of week');
                        // This will trigger recalculateEndDate via the change event handler
                        $startDate.trigger('change');
                    }
                }

                // Add a custom validation to ensure the date is the correct day
                $startDate.on('change', function() {
                    const date = new Date($(this).val());
                    const dayIndex = getDayIndex(selectedDay);

                    if (date.getDay() !== dayIndex) {
                        // Find the next occurrence of the selected day
                        while (date.getDay() !== dayIndex) {
                            date.setDate(date.getDate() + 1);
                        }

                        // Update the start date
                        $(this).val(date.toISOString().split('T')[0]);
                        console.log('Start date adjusted to match day of week on change');
                        // Manually call recalculateEndDate since we're not triggering the change event
                        recalculateEndDate();
                    }
                });
            }
        }
    }

    /**
     * Initialize time selection and duration calculation
     */
    function initTimeSelection() {
        const $startTime = $('#schedule_start_time');
        const $endTime = $('#schedule_end_time');
        const $duration = $('#schedule_duration');

        // Calculate duration when times change
        $startTime.add($endTime).on('change', function() {
            calculateDuration();
            updateScheduleData();
            // Recalculate end date when duration changes
            recalculateEndDate();
        });

        // Calculate duration based on selected times
        function calculateDuration() {
            const startTime = $startTime.val();
            const endTime = $endTime.val();

            if (startTime && endTime) {
                // Parse times
                const [startHour, startMinute] = startTime.split(':').map(Number);
                const [endHour, endMinute] = endTime.split(':').map(Number);

                // Calculate duration in hours
                let durationHours = endHour - startHour;
                let durationMinutes = endMinute - startMinute;

                if (durationMinutes < 0) {
                    durationHours--;
                    durationMinutes += 60;
                }

                // Format duration
                const duration = durationHours + (durationMinutes / 60);
                $duration.val(duration.toFixed(1));
            } else {
                $duration.val('');
            }
        }

        // Initialize date fields
        const $startDate = $('#schedule_start_date');
        const $endDate = $('#schedule_end_date');
        const $totalHours = $('#schedule_total_hours');
        const $classType = $('#class_type');

        // Update end date when start date or class type changes
        $startDate.add($classType).on('change', function() {
            console.log('Start date or class type changed, recalculating end date');
            // Use recalculateEndDate instead of calculateEndDate to account for exception dates
            recalculateEndDate();
            updateScheduleData();
        });

        // Calculate end date based on class type and start date
        // This function is now a wrapper for recalculateEndDate which handles exception dates
        function calculateEndDate() {
            console.log('calculateEndDate called, delegating to recalculateEndDate');
            // Call the more comprehensive recalculateEndDate function
            recalculateEndDate();
        }

    }

/**
 * Helper function to get class type hours
 */
function getClassTypeHours(classTypeId) {
    // This would typically come from the server
    // For now, we'll use a simple mapping based on the class types in the meeting transcript
    const classTypeHours = {
        'AET_COMM': 120,
        'AET_NUM': 120,
        'GETC': 120,
        'BA_NQF2': 120,
        'BA_NQF3': 120,
        'BA_NQF4': 120,
        'REALLL': 160,
        'SKILL_PACKAGE': 80,
        'SOFT_SKILL': 40
    };

    // Default to 120 hours if not found
    return classTypeHours[classTypeId] || 120;
}

    /**
     * Initialize exception dates
     */
    function initExceptionDates() {
        const $container = $('#exception-dates-container');
        const $template = $('#exception-date-row-template');
        const $addButton = $('#add-exception-date-btn');

        // Add exception date row
        $addButton.on('click', function() {
            console.log('Adding exception date row');
            const $newRow = $template.clone();
            $newRow.removeClass('d-none').removeAttr('id');
            $container.append($newRow);

            // Initialize remove button
            $newRow.find('.remove-exception-btn').on('click', function() {
                console.log('Removing exception date row');
                $newRow.remove();
                updateScheduleData();
                // Ensure end date is recalculated when an exception date is removed
                recalculateEndDate();
            });

            // Update schedule data when date or reason changes
            $newRow.find('input, select').on('change', function() {
                console.log('Exception date or reason changed');
                updateScheduleData();
                // Ensure end date is recalculated when an exception date is changed
                recalculateEndDate();
            });
        });

        // Check if we have existing exception dates in the hidden field
        const $existingExceptionDates = $('input[name="schedule_data[exception_dates]"]');
        if ($existingExceptionDates.length > 0) {
            try {
                const exceptionDatesData = JSON.parse($existingExceptionDates.val());
                console.log('Found existing exception dates:', exceptionDatesData);

                // Add rows for existing exception dates
                if (Array.isArray(exceptionDatesData) && exceptionDatesData.length > 0) {
                    exceptionDatesData.forEach(function(exceptionDate) {
                        const $newRow = $template.clone();
                        $newRow.removeClass('d-none').removeAttr('id');
                        $container.append($newRow);

                        // Set values
                        $newRow.find('input[name="exception_dates[]"]').val(exceptionDate.date);
                        $newRow.find('select[name="exception_reasons[]"]').val(exceptionDate.reason);

                        // Initialize event handlers
                        $newRow.find('.remove-exception-btn').on('click', function() {
                            console.log('Removing exception date row');
                            $newRow.remove();
                            updateScheduleData();
                            recalculateEndDate();
                        });

                        $newRow.find('input, select').on('change', function() {
                            console.log('Exception date or reason changed');
                            updateScheduleData();
                            recalculateEndDate();
                        });
                    });

                    // Recalculate end date after loading exception dates
                    setTimeout(function() {
                        recalculateEndDate();
                    }, 100);

                    return; // Skip adding initial row if we loaded existing dates
                }
            } catch (e) {
                console.error('Error parsing exception dates:', e);
            }
        }

        // Add initial row if no existing dates were found
        $addButton.trigger('click');

        // Always recalculate end date when initializing
        setTimeout(function() {
            recalculateEndDate();
        }, 100);
    }

    /**
     * Recalculate end date based on class type, start date, and exception dates
     */
    function recalculateEndDate() {
        console.log('Recalculating end date...');
        const startDate = $('#schedule_start_date').val();
        const classType = $('#class_type').val();
        const pattern = $('#schedule_pattern').val();
        const sessionDuration = parseFloat($('#schedule_duration').val() || '0');

        if (startDate && classType && pattern && sessionDuration > 0) {
            // Get total hours for this class type
            const classHours = getClassTypeHours(classType);
            $('#schedule_total_hours').val(classHours);

            if (classHours > 0) {
                // Get exception dates
                const exceptionDates = [];
                $('#exception-dates-container .exception-date-row:not(.d-none)').each(function() {
                    const date = $(this).find('input[name="exception_dates[]"]').val();
                    if (date) {
                        exceptionDates.push(date);
                    }
                });

                console.log('Exception dates:', exceptionDates);

                // Calculate number of sessions needed
                const sessionsNeeded = Math.ceil(classHours / sessionDuration);
                console.log('Sessions needed:', sessionsNeeded);

                // Calculate end date based on schedule pattern and exception dates
                if (pattern && startDate) {
                    const date = new Date(startDate);
                    let sessionsScheduled = 0;

                    // Weekly pattern
                    if (pattern === 'weekly') {
                        const dayIndex = getDayIndex($('#schedule_day').val());
                        console.log('Weekly pattern, day index:', dayIndex);

                        // Set start date to the first occurrence of the selected day
                        while (date.getDay() !== dayIndex) {
                            date.setDate(date.getDate() + 1);
                        }

                        // Add weeks until we have enough sessions
                        while (sessionsScheduled < sessionsNeeded) {
                            const dateStr = date.toISOString().split('T')[0];

                            // Skip exception dates
                            if (!exceptionDates.includes(dateStr)) {
                                sessionsScheduled++;
                                console.log('Session scheduled on:', dateStr, 'Sessions so far:', sessionsScheduled);
                            } else {
                                console.log('Exception date skipped:', dateStr);
                            }

                            // Move to next week
                            date.setDate(date.getDate() + 7);
                        }
                    }
                    // Bi-weekly pattern
                    else if (pattern === 'biweekly') {
                        const dayIndex = getDayIndex($('#schedule_day').val());
                        console.log('Bi-weekly pattern, day index:', dayIndex);

                        // Set start date to the first occurrence of the selected day
                        while (date.getDay() !== dayIndex) {
                            date.setDate(date.getDate() + 1);
                        }

                        // Add two weeks until we have enough sessions
                        while (sessionsScheduled < sessionsNeeded) {
                            const dateStr = date.toISOString().split('T')[0];

                            // Skip exception dates
                            if (!exceptionDates.includes(dateStr)) {
                                sessionsScheduled++;
                                console.log('Session scheduled on:', dateStr, 'Sessions so far:', sessionsScheduled);
                            } else {
                                console.log('Exception date skipped:', dateStr);
                            }

                            // Move to next bi-week
                            date.setDate(date.getDate() + 14);
                        }
                    }
                    // Monthly pattern
                    else if (pattern === 'monthly') {
                        const dayOfMonth = $('#schedule_day_of_month').val();
                        console.log('Monthly pattern, day of month:', dayOfMonth);

                        // Add months until we have enough sessions
                        while (sessionsScheduled < sessionsNeeded) {
                            let dateToUse = new Date(date);

                            if (dayOfMonth === 'last') {
                                // Set to last day of the month
                                dateToUse = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                            } else {
                                // Set to specific day of month
                                dateToUse.setDate(parseInt(dayOfMonth));

                                // If day is beyond the end of the month, move to next month
                                if (dateToUse.getMonth() !== date.getMonth()) {
                                    date.setMonth(date.getMonth() + 1);
                                    date.setDate(1);
                                    continue;
                                }
                            }

                            const dateStr = dateToUse.toISOString().split('T')[0];

                            // Skip exception dates
                            if (!exceptionDates.includes(dateStr)) {
                                sessionsScheduled++;
                                console.log('Session scheduled on:', dateStr, 'Sessions so far:', sessionsScheduled);
                            } else {
                                console.log('Exception date skipped:', dateStr);
                            }

                            // Move to next month
                            date.setMonth(date.getMonth() + 1);
                            date.setDate(1);
                        }
                    }

                    // Format date as YYYY-MM-DD
                    const endDate = date.toISOString().split('T')[0];
                    console.log('Calculated end date:', endDate);
                    $('#schedule_end_date').val(endDate);

                    // Update calendar if visible
                    if (calendarInitialized && !$('#calendar-reference-container').hasClass('d-none')) {
                        updateCalendarEvents();
                    }
                }
            }
        }
    }

    /**
     * Initialize calendar toggle
     */
    function initCalendarToggle() {
        const $viewButton = $('#view-calendar-btn');
        const $hideButton = $('#hide-calendar-btn');
        const $calendarContainer = $('#calendar-reference-container');

        // Show calendar when view button is clicked
        $viewButton.on('click', function() {
            $calendarContainer.removeClass('d-none');

            // Initialize calendar if not already initialized
            if (!calendarInitialized) {
                initializeCalendar();
            } else {
                // Update calendar with current schedule data
                updateCalendarEvents();
            }
        });

        // Hide calendar when hide button is clicked
        $hideButton.on('click', function() {
            $calendarContainer.addClass('d-none');
        });
    }

    /**
     * Initialize the calendar
     */
    function initializeCalendar() {
        const calendarEl = document.getElementById('class-calendar');

        if (!calendarEl) {
            console.error('Calendar element not found');
            return;
        }

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            buttonText: {
                today: 'Today',
                month: 'Month',
                week: 'Week'
            },
            height: 500,
            allDaySlot: false,
            slotMinTime: '06:00:00',
            slotMaxTime: '20:00:00',
            slotDuration: '00:30:00',
            editable: false, // Not editable - view only
            selectable: false, // Not selectable - view only
            dayMaxEvents: true,
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5], // Monday - Friday
                startTime: '08:00',
                endTime: '17:00',
            },
            eventClassNames: function(arg) {
                // Add custom classes based on event type
                return ['event-type-' + arg.event.extendedProps.type];
            },
            eventDidMount: function(info) {
                // Add tooltips to events
                $(info.el).tooltip({
                    title: info.event.extendedProps.description || info.event.title,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            }
        });

        // Render the calendar
        calendar.render();
        calendarInitialized = true;

        // Update calendar with current schedule data
        updateCalendarEvents();
    }

    /**
     * Update calendar events based on form data
     */
    function updateCalendarEvents() {
        if (!calendar || !calendarInitialized) {
            return;
        }

        // Clear existing events
        calendar.removeAllEvents();

        // Get form data
        const pattern = $('#schedule_pattern').val();
        const startDate = $('#schedule_start_date').val();
        const endDate = $('#schedule_end_date').val();
        const startTime = $('#schedule_start_time').val();
        const endTime = $('#schedule_end_time').val();
        const classType = $('#class_type option:selected').text();

        if (!pattern || !startDate || !startTime || !endTime) {
            return;
        }

        // Generate events based on pattern
        const events = generateEvents(pattern, startDate, endDate, startTime, endTime, classType);

        // Add exception dates as events
        const exceptionEvents = generateExceptionEvents();

        // Add all events to calendar
        calendar.addEventSource(events);
        calendar.addEventSource(exceptionEvents);
    }

    /**
     * Generate events based on schedule pattern
     */
    function generateEvents(pattern, startDate, endDate, startTime, endTime, classType) {
        const events = [];

        if (!startDate) {
            return events;
        }

        // Set end date to 3 months from start date if not provided
        if (!endDate) {
            const date = new Date(startDate);
            date.setMonth(date.getMonth() + 3);
            endDate = date.toISOString().split('T')[0];
        }

        // Get day of week for weekly/biweekly patterns
        let dayOfWeek;
        if (pattern === 'weekly' || pattern === 'biweekly') {
            dayOfWeek = $('#schedule_day').val();
            if (!dayOfWeek) {
                return events;
            }
        }

        // Get day of month for monthly pattern
        let dayOfMonth;
        if (pattern === 'monthly') {
            dayOfMonth = $('#schedule_day_of_month').val();
            if (!dayOfMonth) {
                return events;
            }
        }

        // Generate events based on pattern
        const start = new Date(startDate);
        const end = new Date(endDate);

        // Get exception dates to exclude
        const exceptionDates = getExceptionDates();

        // Weekly pattern
        if (pattern === 'weekly') {
            const dayIndex = getDayIndex(dayOfWeek);

            // Set start date to the first occurrence of the selected day
            while (start.getDay() !== dayIndex) {
                start.setDate(start.getDate() + 1);
            }

            // Generate events for each week
            const current = new Date(start);
            while (current <= end) {
                const dateStr = current.toISOString().split('T')[0];

                // Skip exception dates
                if (!isExceptionDate(dateStr, exceptionDates)) {
                    events.push({
                        title: classType,
                        start: dateStr + 'T' + startTime + ':00',
                        end: dateStr + 'T' + endTime + ':00',
                        extendedProps: {
                            type: 'class',
                            description: classType + ' - ' + dayOfWeek
                        }
                    });
                }

                // Move to next week
                current.setDate(current.getDate() + 7);
            }
        }

        // Bi-weekly pattern
        else if (pattern === 'biweekly') {
            const dayIndex = getDayIndex(dayOfWeek);

            // Set start date to the first occurrence of the selected day
            while (start.getDay() !== dayIndex) {
                start.setDate(start.getDate() + 1);
            }

            // Generate events for every other week
            const current = new Date(start);
            while (current <= end) {
                const dateStr = current.toISOString().split('T')[0];

                // Skip exception dates
                if (!isExceptionDate(dateStr, exceptionDates)) {
                    events.push({
                        title: classType,
                        start: dateStr + 'T' + startTime + ':00',
                        end: dateStr + 'T' + endTime + ':00',
                        extendedProps: {
                            type: 'class',
                            description: classType + ' - ' + dayOfWeek + ' (Bi-weekly)'
                        }
                    });
                }

                // Move to next bi-week
                current.setDate(current.getDate() + 14);
            }
        }

        // Monthly pattern
        else if (pattern === 'monthly') {
            // Generate events for each month
            const current = new Date(start);

            while (current <= end) {
                let dateToUse = new Date(current);

                if (dayOfMonth === 'last') {
                    // Set to last day of the month
                    dateToUse = new Date(current.getFullYear(), current.getMonth() + 1, 0);
                } else {
                    // Set to specific day of month
                    dateToUse.setDate(parseInt(dayOfMonth));

                    // If day is beyond the end of the month, move to next month
                    if (dateToUse.getMonth() !== current.getMonth()) {
                        current.setMonth(current.getMonth() + 1);
                        continue;
                    }
                }

                const dateStr = dateToUse.toISOString().split('T')[0];

                // Skip exception dates
                if (!isExceptionDate(dateStr, exceptionDates)) {
                    events.push({
                        title: classType,
                        start: dateStr + 'T' + startTime + ':00',
                        end: dateStr + 'T' + endTime + ':00',
                        extendedProps: {
                            type: 'class',
                            description: classType + ' - Monthly (' + (dayOfMonth === 'last' ? 'Last Day' : dayOfMonth) + ')'
                        }
                    });
                }

                // Move to next month
                current.setMonth(current.getMonth() + 1);
            }
        }

        return events;
    }

    /**
     * Generate exception events
     */
    function generateExceptionEvents() {
        const events = [];

        // Get all exception date rows
        $('#exception-dates-container .exception-date-row:not(.d-none)').each(function() {
            const $row = $(this);
            const date = $row.find('input[name="exception_dates[]"]').val();
            const reason = $row.find('select[name="exception_reasons[]"]').val();

            if (date) {
                events.push({
                    title: reason || 'Exception',
                    start: date,
                    allDay: true,
                    extendedProps: {
                        type: 'exception',
                        description: reason || 'Exception Date'
                    },
                    backgroundColor: '#f44336',
                    borderColor: '#d32f2f'
                });
            }
        });

        return events;
    }

    /**
     * Get exception dates
     */
    function getExceptionDates() {
        const dates = [];

        // Get all exception date rows
        $('#exception-dates-container .exception-date-row:not(.d-none)').each(function() {
            const date = $(this).find('input[name="exception_dates[]"]').val();
            if (date) {
                dates.push(date);
            }
        });

        return dates;
    }

    /**
     * Check if a date is an exception date
     */
    function isExceptionDate(date, exceptionDates) {
        return exceptionDates.includes(date);
    }

    /**
     * Get day index from day name
     */
    function getDayIndex(dayName) {
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return days.indexOf(dayName);
    }

    /**
     * Initialize schedule data updates
     */
    function initScheduleDataUpdates() {
        // Update hidden fields when form changes
        const formFields = [
            '#schedule_pattern',
            '#schedule_day',
            '#schedule_day_of_month',
            '#schedule_start_time',
            '#schedule_end_time',
            '#schedule_start_date',
            '#schedule_end_date',
            '#schedule_total_hours'
        ];

        $(formFields.join(', ')).on('change', function() {
            updateScheduleData();
        });
    }

    /**
     * Update hidden schedule data fields
     */
    function updateScheduleData() {
        console.log('Updating schedule data...');
        const $container = $('#schedule-data-container');
        $container.empty();

        // Get form data
        const pattern = $('#schedule_pattern').val();
        const day = $('#schedule_day').val();
        const dayOfMonth = $('#schedule_day_of_month').val();
        const startTime = $('#schedule_start_time').val();
        const endTime = $('#schedule_end_time').val();
        const startDate = $('#schedule_start_date').val();
        const endDate = $('#schedule_end_date').val();
        const totalHours = $('#schedule_total_hours').val();

        // Create hidden fields
        if (pattern) {
            $container.append('<input type="hidden" name="schedule_data[pattern]" value="' + pattern + '">');
        }

        if (day) {
            $container.append('<input type="hidden" name="schedule_data[day]" value="' + day + '">');
        }

        if (dayOfMonth) {
            $container.append('<input type="hidden" name="schedule_data[day_of_month]" value="' + dayOfMonth + '">');
        }

        if (startTime) {
            $container.append('<input type="hidden" name="schedule_data[start_time]" value="' + startTime + '">');
        }

        if (endTime) {
            $container.append('<input type="hidden" name="schedule_data[end_time]" value="' + endTime + '">');
        }

        if (startDate) {
            $container.append('<input type="hidden" name="schedule_data[start_date]" value="' + startDate + '">');
        }

        if (endDate) {
            $container.append('<input type="hidden" name="schedule_data[end_date]" value="' + endDate + '">');
        }

        if (totalHours) {
            $container.append('<input type="hidden" name="schedule_data[total_hours]" value="' + totalHours + '">');
        }

        // Add exception dates
        const exceptionDates = [];
        $('#exception-dates-container .exception-date-row:not(.d-none)').each(function() {
            const $row = $(this);
            const date = $row.find('input[name="exception_dates[]"]').val();
            const reason = $row.find('select[name="exception_reasons[]"]').val();

            if (date) {
                exceptionDates.push({
                    date: date,
                    reason: reason || ''
                });
            }
        });

        console.log('Exception dates for hidden field:', exceptionDates);

        if (exceptionDates.length > 0) {
            $container.append('<input type="hidden" name="schedule_data[exception_dates]" value=\'' + JSON.stringify(exceptionDates) + '\'>');
        }

        // Update calendar if initialized
        if (calendarInitialized && !$('#calendar-reference-container').hasClass('d-none')) {
            console.log('Updating calendar events after schedule data change');
            updateCalendarEvents();
        }
    }

    // Initialize when document is ready
    $(document).ready(function() {
        initClassScheduleForm();
    });

})(jQuery);
