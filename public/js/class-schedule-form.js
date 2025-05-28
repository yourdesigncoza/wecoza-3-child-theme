/**
 * Class Schedule Form JavaScript
 *
 * Handles the client-side functionality for the class schedule form
 * and the view-only calendar reference.
 */
(function($) {
    'use strict';

    // Holiday override data
    var holidayOverrides = {};

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

        // Initialize holiday overrides
        initHolidayOverrides();

        // Initialize calendar toggle
        initCalendarToggle();

        // Initialize schedule data updates
        initScheduleDataUpdates();

        // Initialize debug JSON toggle
        initDebugJsonToggle();

        // Initialize statistics toggle
        initStatisticsToggle();
    }

    /**
     * Initialize statistics toggle button
     */
    function initStatisticsToggle() {
        const $toggleBtn = $('#toggle-statistics-btn');
        const $statisticsSection = $('#schedule-statistics-section');

        $toggleBtn.on('click', function() {
            if ($statisticsSection.hasClass('d-none')) {
                // Show the statistics section
                $statisticsSection.removeClass('d-none');
                $toggleBtn.html('<i class="bi bi-bar-chart-line me-1"></i> Hide Schedule Statistics');
                $toggleBtn.addClass('btn-primary').removeClass('btn-outline-primary');

                // Update statistics data
                updateScheduleData();
            } else {
                // Hide the statistics section
                $statisticsSection.addClass('d-none');
                $toggleBtn.html('<i class="bi bi-bar-chart-line me-1"></i> View Schedule Statistics');
                $toggleBtn.removeClass('btn-primary').addClass('btn-outline-primary');
            }
        });
    }

    /**
     * Initialize debug JSON toggle button
     */
    function initDebugJsonToggle() {
        const $toggleBtn = $('#toggle-debug-json-btn');
        const $debugJsonDisplay = $('#debug-json-display');

        $toggleBtn.on('click', function() {
            if ($debugJsonDisplay.hasClass('d-none')) {
                // Show the debug JSON display
                $debugJsonDisplay.removeClass('d-none');
                $toggleBtn.addClass('btn-primary').removeClass('btn-outline-secondary');
            } else {
                // Hide the debug JSON display
                $debugJsonDisplay.addClass('d-none');
                $toggleBtn.removeClass('btn-primary').addClass('btn-outline-secondary');
            }
        });
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
                $('#schedule_day_of_month').removeAttr('required');

                // Ensure at least one day is selected for validation
                validateDaySelection();
            } else if (pattern === 'monthly') {
                $dayOfMonth.removeClass('d-none');
                $('#schedule_day_of_month').attr('required', 'required');
            } else if (pattern === 'custom') {
                // For custom pattern, we'll use the calendar view
                $('#view-calendar-btn').trigger('click');
            }

            // Update schedule data
            updateScheduleData();

            // Check for holidays that conflict with the new pattern
            const startDate = $('#schedule_start_date').val();
            const endDate = $('#schedule_end_date').val();
            if (startDate) {
                checkForHolidays(startDate, endDate);
            }

            // Recalculate end date when pattern changes
            recalculateEndDate();
        });

        // Initialize day selection buttons
        $('#select-all-days').on('click', function() {
            dayCheckboxInteracted = true;
            $('.schedule-day-checkbox').prop('checked', true);
            validateDaySelection();
            updateScheduleData();
            restrictStartDateBySelectedDays();
            recalculateEndDate();
        });

        $('#clear-all-days').on('click', function() {
            dayCheckboxInteracted = true;
            $('.schedule-day-checkbox').prop('checked', false);
            validateDaySelection();
            updateScheduleData();
        });

        // Handle day checkbox changes
        $('.schedule-day-checkbox').on('change', function() {
            dayCheckboxInteracted = true;
            validateDaySelection();
            updateScheduleData();
            restrictStartDateBySelectedDays();

            // Check for holidays that conflict with the new day selection
            const startDate = $('#schedule_start_date').val();
            const endDate = $('#schedule_end_date').val();
            if (startDate) {
                checkForHolidays(startDate, endDate);
            }

            // Recalculate end date when day changes
            recalculateEndDate();
        });

        // Handle day of month selection changes
        $('#schedule_day_of_month').on('change', function() {
            updateScheduleData();

            // Check for holidays that conflict with the new day selection
            const startDate = $('#schedule_start_date').val();
            const endDate = $('#schedule_end_date').val();
            if (startDate) {
                checkForHolidays(startDate, endDate);
            }

            // Recalculate end date when day changes
            recalculateEndDate();
        });

        // Restrict start date based on selected days
        function restrictStartDateBySelectedDays() {
            const selectedDays = getSelectedDays();
            const $startDate = $('#schedule_start_date');

            if (selectedDays.length > 0 && !$('#day-selection-container').hasClass('d-none')) {
                // Get the current date value
                const currentDate = $startDate.val();

                if (currentDate) {
                    const date = new Date(currentDate);
                    const dayName = getDayName(date.getDay());

                    // If the current date is not one of the selected days, find the next occurrence
                    if (!selectedDays.includes(dayName)) {
                        // Find the next occurrence of any selected day
                        let daysToAdd = 1;
                        let nextDate = new Date(date);
                        nextDate.setDate(nextDate.getDate() + daysToAdd);

                        while (!selectedDays.includes(getDayName(nextDate.getDay()))) {
                            daysToAdd++;
                            nextDate = new Date(date);
                            nextDate.setDate(nextDate.getDate() + daysToAdd);
                        }

                        // Update the start date
                        $startDate.val(nextDate.toISOString().split('T')[0]);
                        console.log('Start date adjusted to match selected days');
                        // This will trigger recalculateEndDate via the change event handler
                        $startDate.trigger('change');
                    }
                }

                // Add a custom validation to ensure the date is one of the correct days
                $startDate.on('change', function() {
                    const date = new Date($(this).val());
                    const dayName = getDayName(date.getDay());

                    if (!selectedDays.includes(dayName)) {
                        // Find the next occurrence of any selected day
                        let daysToAdd = 1;
                        let nextDate = new Date(date);
                        nextDate.setDate(nextDate.getDate() + daysToAdd);

                        while (!selectedDays.includes(getDayName(nextDate.getDay()))) {
                            daysToAdd++;
                            nextDate = new Date(date);
                            nextDate.setDate(nextDate.getDate() + daysToAdd);
                        }

                        // Update the start date
                        $(this).val(nextDate.toISOString().split('T')[0]);
                        console.log('Start date adjusted to match selected days on change');
                        // Manually call recalculateEndDate since we're not triggering the change event
                        recalculateEndDate();
                    }
                });
            }
        }
    }

    // Flag to track user interaction with day checkboxes
    let dayCheckboxInteracted = false;

    /**
     * Validate that at least one day is selected
     */
    function validateDaySelection() {
        const anyDaySelected = $('.schedule-day-checkbox:checked').length > 0;
        const $daySelectionContainer = $('#day-selection-container');
        const formValidated = $('form').hasClass('was-validated');

        if (!$daySelectionContainer.hasClass('d-none')) {
            // Only show feedback if the form has been validated or user has interacted with checkboxes
            if (formValidated || dayCheckboxInteracted) {
                if (anyDaySelected) {
                    $daySelectionContainer.find('.invalid-feedback').hide();
                    $daySelectionContainer.find('.valid-feedback').show();
                } else {
                    $daySelectionContainer.find('.invalid-feedback').show();
                    $daySelectionContainer.find('.valid-feedback').hide();
                }
            } else {
                // On initial load, ensure both feedback messages are hidden
                $daySelectionContainer.find('.invalid-feedback').hide();
                $daySelectionContainer.find('.valid-feedback').hide();
            }
        }

        return anyDaySelected;
    }

    /**
     * Get all selected days
     */
    function getSelectedDays() {
        const selectedDays = [];
        $('.schedule-day-checkbox:checked').each(function() {
            selectedDays.push($(this).val());
        });
        return selectedDays;
    }

    /**
     * Helper function to get day name from day index
     */
    function getDayName(dayIndex) {
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return days[dayIndex];
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
        const $classType = $('#class_type');

        // Update end date when start date or class type changes
        $startDate.add($classType).on('change', function() {
            console.log('Start date or class type changed, recalculating end date');

            // If start date changed, validate against class original start date
            if ($(this).attr('id') === 'schedule_start_date') {
                const startDate = $(this).val();
                const originalStartDate = $('#class_start_date').val();

                // Validate schedule start date against original start date
                if (startDate && originalStartDate && startDate < originalStartDate) {
                    // Show validation error
                    $(this).addClass('is-invalid');
                    $(this).siblings('.invalid-feedback').text('Start date cannot be before the class original start date');

                    // Add a custom data attribute to track validation state
                    $(this).attr('data-valid', 'false');
                } else {
                    // Clear validation error
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').text('Please select a start date.');

                    // Update data attribute
                    $(this).attr('data-valid', 'true');

                    // Check all exception date rows
                    $('#exception-dates-container .exception-date-row:not(.d-none)').each(function() {
                        const $row = $(this);
                        const exceptionDate = $row.find('input[name="exception_dates[]"]').val();

                        if (exceptionDate && startDate && exceptionDate < startDate) {
                            // Show validation error
                            $row.find('input[name="exception_dates[]"]').addClass('is-invalid');
                            $row.find('.invalid-feedback').text('Exception date cannot be before the class start date');

                            // Add a custom data attribute to track validation state
                            $row.attr('data-valid', 'false');
                        } else {
                            // Clear validation error
                            $row.find('input[name="exception_dates[]"]').removeClass('is-invalid');
                            $row.find('.invalid-feedback').text('Please select a valid date.');

                            // Update data attribute
                            $row.attr('data-valid', 'true');
                        }
                    });
                }
            }

            // Use recalculateEndDate instead of calculateEndDate to account for exception dates
            recalculateEndDate();
            updateScheduleData();
        });

        // Note: calculateEndDate has been replaced by recalculateEndDate which handles exception dates

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

            // Set default validation state to true
            $newRow.attr('data-valid', 'true');

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
                console.log('Current exception date value:', $newRow.find('input[name="exception_dates[]"]').val());

                // Validate exception date against class start date
                const exceptionDate = $newRow.find('input[name="exception_dates[]"]').val();
                const startDate = $('#schedule_start_date').val();

                if (exceptionDate && startDate && exceptionDate < startDate) {
                    // Show validation error
                    $newRow.find('input[name="exception_dates[]"]').addClass('is-invalid');
                    $newRow.find('.invalid-feedback').text('Exception date cannot be before the class start date');

                    // Add a custom data attribute to track validation state
                    $newRow.attr('data-valid', 'false');
                } else {
                    // Clear validation error
                    $newRow.find('input[name="exception_dates[]"]').removeClass('is-invalid');
                    $newRow.find('.invalid-feedback').text('Please select a valid date.');

                    // Update data attribute
                    $newRow.attr('data-valid', 'true');
                }

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

                        // Validate against start date
                        const startDate = $('#schedule_start_date').val();
                        if (exceptionDate.date && startDate && exceptionDate.date < startDate) {
                            // Show validation error
                            $newRow.find('input[name="exception_dates[]"]').addClass('is-invalid');
                            $newRow.find('.invalid-feedback').text('Exception date cannot be before the class start date');

                            // Add a custom data attribute to track validation state
                            $newRow.attr('data-valid', 'false');
                        } else {
                            // Mark as valid
                            $newRow.attr('data-valid', 'true');
                        }

                        // Initialize event handlers
                        $newRow.find('.remove-exception-btn').on('click', function() {
                            console.log('Removing exception date row');
                            $newRow.remove();
                            updateScheduleData();
                            recalculateEndDate();
                        });

                        $newRow.find('input, select').on('change', function() {
                            console.log('Exception date or reason changed');

                            // Validate exception date against class start date
                            const exceptionDate = $newRow.find('input[name="exception_dates[]"]').val();
                            const startDate = $('#schedule_start_date').val();

                            if (exceptionDate && startDate && exceptionDate < startDate) {
                                // Show validation error
                                $newRow.find('input[name="exception_dates[]"]').addClass('is-invalid');
                                $newRow.find('.invalid-feedback').text('Exception date cannot be before the class start date');

                                // Add a custom data attribute to track validation state
                                $newRow.attr('data-valid', 'false');
                            } else {
                                // Clear validation error
                                $newRow.find('input[name="exception_dates[]"]').removeClass('is-invalid');
                                $newRow.find('.invalid-feedback').text('Please select a valid date.');

                                // Update data attribute
                                $newRow.attr('data-valid', 'true');
                            }

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
                console.log('Exception date rows found:', $('#exception-dates-container .exception-date-row:not(.d-none)').length);

                // Check for public holidays in the date range
                // We'll calculate a rough end date first to determine the date range
                let roughEndDate = null;
                if (pattern === 'weekly') {
                    // Rough estimate: 1 session per week
                    const sessionsNeeded = Math.ceil(classHours / sessionDuration);
                    const weeksNeeded = sessionsNeeded;
                    const date = new Date(startDate);
                    date.setDate(date.getDate() + (weeksNeeded * 7));
                    roughEndDate = date.toISOString().split('T')[0];
                } else if (pattern === 'biweekly') {
                    // Rough estimate: 1 session per 2 weeks
                    const sessionsNeeded = Math.ceil(classHours / sessionDuration);
                    const weeksNeeded = sessionsNeeded * 2;
                    const date = new Date(startDate);
                    date.setDate(date.getDate() + (weeksNeeded * 7));
                    roughEndDate = date.toISOString().split('T')[0];
                } else if (pattern === 'monthly') {
                    // Rough estimate: 1 session per month
                    const sessionsNeeded = Math.ceil(classHours / sessionDuration);
                    const monthsNeeded = sessionsNeeded;
                    const date = new Date(startDate);
                    date.setMonth(date.getMonth() + monthsNeeded);
                    roughEndDate = date.toISOString().split('T')[0];
                }

                // Check for holidays in the date range and show override modal if needed
                if (roughEndDate) {
                    checkForHolidays(startDate, roughEndDate);
                }

                // Calculate number of sessions needed
                const sessionsNeeded = Math.ceil(classHours / sessionDuration);
                console.log('Sessions needed:', sessionsNeeded);

                // Calculate end date based on schedule pattern and exception dates
                if (pattern && startDate) {
                    let date = new Date(startDate);
                    let sessionsScheduled = 0;

                    // Weekly pattern
                    if (pattern === 'weekly') {
                        const selectedDays = getSelectedDays();
                        console.log('Weekly pattern, selected days:', selectedDays);

                        if (selectedDays.length === 0) {
                            return; // Can't calculate without selected days
                        }

                        // Convert selected days to day indices
                        const dayIndices = selectedDays.map(day => getDayIndex(day));

                        // Set start date to the first occurrence of any selected day
                        const currentDayIndex = date.getDay();
                        if (!dayIndices.includes(currentDayIndex)) {
                            // Find the next occurrence of any selected day
                            let daysToAdd = 1;
                            let nextDate = new Date(date);
                            nextDate.setDate(nextDate.getDate() + daysToAdd);

                            while (!dayIndices.includes(nextDate.getDay())) {
                                daysToAdd++;
                                nextDate = new Date(date);
                                nextDate.setDate(nextDate.getDate() + daysToAdd);
                            }

                            date = nextDate;
                        }

                        // Add days until we have enough sessions
                        while (sessionsScheduled < sessionsNeeded) {
                            const dateStr = date.toISOString().split('T')[0];
                            const currentDayIndex = date.getDay();

                            // Check if this date is a public holiday
                            let isPublicHoliday = false;
                            let isHolidayOverridden = false;

                            if (typeof wecozaPublicHolidays !== 'undefined' && wecozaPublicHolidays.events) {
                                const matchingHoliday = wecozaPublicHolidays.events.find(holiday => {
                                    // Direct string comparison
                                    return holiday.start === dateStr;
                                });

                                if (matchingHoliday) {
                                    isPublicHoliday = true;

                                    // Check if this holiday has been overridden
                                    if (typeof holidayOverrides === 'object' && holidayOverrides[dateStr] && holidayOverrides[dateStr].override === true) {
                                        isHolidayOverridden = true;
                                    }
                                }
                            }

                            // Skip exception dates and public holidays (unless overridden)
                            // Only count days that are in our selected days list
                            if (dayIndices.includes(currentDayIndex) &&
                                !exceptionDates.includes(dateStr) &&
                                (!isPublicHoliday || isHolidayOverridden)) {
                                sessionsScheduled++;
                                console.log('Session scheduled on:', dateStr, 'Sessions so far:', sessionsScheduled);
                                if (isHolidayOverridden) {
                                    console.log('Holiday overridden:', dateStr);
                                }
                            } else if (isPublicHoliday) {
                                console.log('Public holiday skipped:', dateStr);
                            } else if (exceptionDates.includes(dateStr)) {
                                console.log('Exception date skipped:', dateStr);
                            }

                            // Move to next day
                            date.setDate(date.getDate() + 1);
                        }
                    }
                    // Bi-weekly pattern
                    else if (pattern === 'biweekly') {
                        const selectedDays = getSelectedDays();
                        console.log('Bi-weekly pattern, selected days:', selectedDays);

                        if (selectedDays.length === 0) {
                            return; // Can't calculate without selected days
                        }

                        // Convert selected days to day indices
                        const dayIndices = selectedDays.map(day => getDayIndex(day));

                        // Set start date to the first occurrence of any selected day
                        const currentDayIndex = date.getDay();
                        if (!dayIndices.includes(currentDayIndex)) {
                            // Find the next occurrence of any selected day
                            let daysToAdd = 1;
                            let nextDate = new Date(date);
                            nextDate.setDate(nextDate.getDate() + daysToAdd);

                            while (!dayIndices.includes(nextDate.getDay())) {
                                daysToAdd++;
                                nextDate = new Date(date);
                                nextDate.setDate(nextDate.getDate() + daysToAdd);
                            }

                            date = nextDate;
                        }

                        // Track which week we're in (0 = first week, 1 = second week)
                        let weekCounter = 0;

                        // Add days until we have enough sessions
                        while (sessionsScheduled < sessionsNeeded) {
                            const dateStr = date.toISOString().split('T')[0];
                            const currentDayIndex = date.getDay();

                            // Check if this date is a public holiday
                            let isPublicHoliday = false;
                            let isHolidayOverridden = false;

                            if (typeof wecozaPublicHolidays !== 'undefined' && wecozaPublicHolidays.events) {
                                const matchingHoliday = wecozaPublicHolidays.events.find(holiday => {
                                    // Direct string comparison
                                    return holiday.start === dateStr;
                                });

                                if (matchingHoliday) {
                                    isPublicHoliday = true;

                                    // Check if this holiday has been overridden
                                    if (typeof holidayOverrides === 'object' && holidayOverrides[dateStr] && holidayOverrides[dateStr].override === true) {
                                        isHolidayOverridden = true;
                                    }
                                }
                            }

                            // Skip exception dates and public holidays (unless overridden)
                            // Only count days that are in our selected days list and in the first week of the biweek
                            if (dayIndices.includes(currentDayIndex) &&
                                weekCounter === 0 &&
                                !exceptionDates.includes(dateStr) &&
                                (!isPublicHoliday || isHolidayOverridden)) {
                                sessionsScheduled++;
                                // Note: Removed verbose session logging to keep console clean
                            }

                            // Move to next day
                            date.setDate(date.getDate() + 1);

                            // Update week counter (0 = first week, 1 = second week)
                            if (date.getDay() === 0) { // If it's Sunday
                                weekCounter = (weekCounter + 1) % 2;
                            }
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

                            // Check if this date is a public holiday
                            let isPublicHoliday = false;
                            let isHolidayOverridden = false;

                            if (typeof wecozaPublicHolidays !== 'undefined' && wecozaPublicHolidays.events) {
                                const matchingHoliday = wecozaPublicHolidays.events.find(holiday => {
                                    // Direct string comparison
                                    return holiday.start === dateStr;
                                });

                                if (matchingHoliday) {
                                    isPublicHoliday = true;

                                    // Check if this holiday has been overridden
                                    if (typeof holidayOverrides === 'object' && holidayOverrides[dateStr] && holidayOverrides[dateStr].override === true) {
                                        isHolidayOverridden = true;
                                    }
                                }
                            }

                            // Skip exception dates and public holidays (unless overridden)
                            if (!exceptionDates.includes(dateStr) && (!isPublicHoliday || isHolidayOverridden)) {
                                sessionsScheduled++;
                                console.log('Session scheduled on:', dateStr, 'Sessions so far:', sessionsScheduled);
                                if (isHolidayOverridden) {
                                    console.log('Holiday overridden:', dateStr);
                                }
                            } else if (isPublicHoliday) {
                                console.log('Public holiday skipped:', dateStr);
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

                    // Update schedule tables if visible
                    if (!$('#calendar-reference-container').hasClass('d-none')) {
                        updateScheduleTables();
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

        // Show schedule view when view button is clicked
        $viewButton.on('click', function() {
            $calendarContainer.removeClass('d-none');

            // Update schedule tables with current data
            updateScheduleTables();

            // Update schedule data to trigger statistics calculation
            updateScheduleData();
        });

        // Hide schedule view when hide button is clicked
        $hideButton.on('click', function() {
            $calendarContainer.addClass('d-none');
        });
    }

    /**
     * Update schedule tables with current data
     */
    function updateScheduleTables() {
        // Get schedule data
        const pattern = $('#schedule_pattern').val();
        const startDate = $('#schedule_start_date').val();
        const endDate = $('#schedule_end_date').val();
        const startTime = $('#schedule_start_time').val();
        const endTime = $('#schedule_end_time').val();

        // Format pattern for display
        let patternDisplay = '';
        switch(pattern) {
            case 'weekly':
                patternDisplay = 'Weekly';
                break;
            case 'biweekly':
                patternDisplay = 'Bi-weekly';
                break;
            case 'monthly':
                patternDisplay = 'Monthly';
                break;
            case 'custom':
                patternDisplay = 'Custom';
                break;
            default:
                patternDisplay = pattern;
        }

        // Format dates for display
        const formatDate = function(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-ZA', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        };

        // Update schedule summary table
        $('#schedule-summary-pattern').text(patternDisplay);
        $('#schedule-summary-start-date').text(formatDate(startDate));
        $('#schedule-summary-end-date').text(formatDate(endDate));
        $('#schedule-summary-class-time').text(startTime + ' - ' + endTime);

        // Get selected days
        const selectedDays = getSelectedDays();
        $('#schedule-summary-days').text(selectedDays.join(', '));

        // Update exception dates table
        updateExceptionDatesTable();

        // Update holidays table
        updateHolidaysTable(startDate, endDate);

        // Update debug JSON display
        updateDebugJsonDisplay(pattern, startDate, endDate, startTime, endTime, selectedDays);
    }

    /**
     * Update debug JSON display with current schedule data
     */
    function updateDebugJsonDisplay(pattern, startDate, endDate, startTime, endTime, selectedDays) {
        // Get exception dates
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

        // Get holidays in range
        const holidays = [];
        if (typeof wecozaPublicHolidays !== 'undefined' && wecozaPublicHolidays.events && startDate && endDate) {
            // Convert dates to Date objects for comparison
            const startDateObj = new Date(startDate);
            const endDateObj = new Date(endDate);

            // Filter holidays to only include those within the date range
            wecozaPublicHolidays.events.forEach(holiday => {
                // Parse the date parts to ensure correct date (avoid timezone issues)
                const [year, month, day] = holiday.start.split('-').map(Number);
                const holidayDate = new Date(year, month - 1, day);

                if (holidayDate >= startDateObj && holidayDate <= endDateObj) {
                    // Check if this holiday has been overridden
                    let isOverridden = false;
                    if (typeof holidayOverrides === 'object' && holidayOverrides[holiday.start]) {
                        isOverridden = holidayOverrides[holiday.start].override;
                    }

                    // Check if this holiday conflicts with the schedule
                    const dayName = holidayDate.toLocaleDateString('en-US', { weekday: 'long' });
                    const conflictsWithSchedule = (pattern === 'weekly' || pattern === 'biweekly') && selectedDays.includes(dayName);

                    holidays.push({
                        date: holiday.start,
                        name: holiday.title,
                        isOverridden: isOverridden,
                        conflictsWithSchedule: conflictsWithSchedule
                    });
                }
            });
        }

        // Create the complete JSON data structure
        const jsonData = {
            schedule: {
                pattern: pattern,
                startDate: startDate,
                endDate: endDate,
                selectedDays: selectedDays,
                classTime: {
                    start: startTime,
                    end: endTime
                }
            },
            exceptionDates: exceptionDates,
            holidays: holidays,
            metadata: {
                lastUpdated: new Date().toISOString(),
                version: "1.0"
            }
        };

        // Update the debug JSON display
        $('#debug-json-display').text(JSON.stringify(jsonData, null, 4));

        // Update schedule statistics
        updateScheduleStatistics(jsonData);
    }

    /**
     * Update schedule statistics based on JSON data
     */
    function updateScheduleStatistics(jsonData) {
        if (!jsonData.schedule.startDate || !jsonData.schedule.endDate) {
            return; // Skip if no date range
        }

        // Parse dates
        const startDate = new Date(jsonData.schedule.startDate);
        const endDate = new Date(jsonData.schedule.endDate);

        // 1. Training Duration Statistics

        // Calculate total calendar days
        const totalDays = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
        $('#stat-total-days').text(totalDays + ' days');

        // Calculate total weeks
        const totalWeeks = Math.round(totalDays / 7 * 10) / 10; // Round to 1 decimal place
        $('#stat-total-weeks').text(totalWeeks.toFixed(1) + ' weeks');

        // Calculate total months
        const totalMonths = Math.round((totalDays / 30.44) * 10) / 10; // Average days in a month
        $('#stat-total-months').text(totalMonths.toFixed(1) + ' months');

        // 2. Class Session Statistics

        // Calculate total scheduled classes
        let totalClasses = 0;
        const selectedDays = jsonData.schedule.selectedDays;
        const pattern = jsonData.schedule.pattern;

        if (pattern === 'weekly') {
            // For weekly pattern, count the number of occurrences of each selected day
            totalClasses = countScheduledClasses(startDate, endDate, selectedDays, 7, jsonData);
        } else if (pattern === 'biweekly') {
            // For biweekly pattern, count every other week
            totalClasses = countScheduledClasses(startDate, endDate, selectedDays, 14, jsonData);
        } else if (pattern === 'monthly') {
            // For monthly pattern, count once per month
            totalClasses = countMonthlyClasses(startDate, endDate, jsonData);
        }

        $('#stat-total-classes').text(totalClasses + ' sessions');

        // Calculate total training hours
        const startTime = jsonData.schedule.classTime.start;
        const endTime = jsonData.schedule.classTime.end;
        let sessionHours = 0;

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
            sessionHours = durationHours + (durationMinutes / 60);
        }

        const totalHours = Math.round(totalClasses * sessionHours * 10) / 10;
        $('#stat-total-hours').text(totalHours.toFixed(1) + ' hours');

        // Calculate average hours per month
        const avgHoursPerMonth = totalMonths > 0 ? Math.round((totalHours / totalMonths) * 10) / 10 : 0;
        $('#stat-avg-hours-month').text(avgHoursPerMonth.toFixed(1) + ' hours/month');

        // 3. Attendance Impact Statistics

        // Count holidays affecting classes
        const holidaysAffectingClasses = countHolidaysAffectingClasses(jsonData);
        $('#stat-holidays-affecting').text(holidaysAffectingClasses + ' holidays');

        // Count exception dates
        const exceptionDatesCount = jsonData.exceptionDates.length;
        $('#stat-exception-dates').text(exceptionDatesCount + ' dates');

        // Use totalClasses directly as actual training days since it already accounts for
        // both exception dates and holiday overrides correctly
        const actualTrainingDays = totalClasses;
        $('#stat-actual-days').text(actualTrainingDays + ' days');
    }

    /**
     * Count scheduled classes between start and end dates
     */
    function countScheduledClasses(startDate, endDate, selectedDays, interval, jsonData) {
        let count = 0;
        const current = new Date(startDate);
        const dayIndices = selectedDays.map(day => getDayIndex(day));

        // Get exception dates
        const exceptionDates = jsonData.exceptionDates.map(exception => exception.date);

        // Loop through each day in the range
        while (current <= endDate) {
            const dateStr = current.toISOString().split('T')[0];
            const dayOfWeek = current.getDay();

            // Check if this day is in our selected days
            if (dayIndices.includes(dayOfWeek)) {
                // Check if this is a scheduled class day (based on interval)
                const daysSinceStart = Math.round((current - startDate) / (1000 * 60 * 60 * 24));

                if (daysSinceStart % interval === 0 || interval === 7) {
                    // Skip exception dates and public holidays (unless overridden)
                    if (!isExceptionDateOrHoliday(dateStr, exceptionDates, jsonData.holidays)) {
                        count++;
                    }
                }
            }

            // Move to next day
            current.setDate(current.getDate() + 1);
        }

        return count;
    }

    /**
     * Count monthly classes between start and end dates
     */
    function countMonthlyClasses(startDate, endDate, jsonData) {
        let count = 0;
        const current = new Date(startDate);

        // Get exception dates
        const exceptionDates = jsonData.exceptionDates.map(exception => exception.date);

        // Loop through each month in the range
        while (current <= endDate) {
            const dateStr = current.toISOString().split('T')[0];

            // Skip exception dates and public holidays (unless overridden)
            if (!isExceptionDateOrHoliday(dateStr, exceptionDates, jsonData.holidays)) {
                count++;
            }

            // Move to next month
            current.setMonth(current.getMonth() + 1);
        }

        return count;
    }

    /**
     * Check if a date is an exception date or holiday
     */
    function isExceptionDateOrHoliday(dateStr, exceptionDates, holidays) {
        // Check if it's an exception date
        if (exceptionDates.includes(dateStr)) {
            return true;
        }

        // Check if it's a public holiday that hasn't been overridden
        const holiday = holidays.find(h => h.date === dateStr);
        if (holiday && !holiday.isOverridden) {
            return true;
        }

        return false;
    }

    /**
     * Count holidays that affect class schedule
     */
    function countHolidaysAffectingClasses(jsonData) {
        if (!jsonData.holidays || !jsonData.schedule.selectedDays) {
            return 0;
        }

        let count = 0;
        const selectedDays = jsonData.schedule.selectedDays;
        const dayIndices = selectedDays.map(day => getDayIndex(day));

        // Loop through each holiday
        jsonData.holidays.forEach(holiday => {
            const holidayDate = new Date(holiday.date);
            const dayOfWeek = holidayDate.getDay();

            // Check if this holiday falls on a selected day
            if (dayIndices.includes(dayOfWeek) && !holiday.isOverridden) {
                count++;
            }
        });

        return count;
    }

    /**
     * Count overridden holidays
     */
    function countOverriddenHolidays(jsonData) {
        if (!jsonData.holidays) {
            return 0;
        }

        // Count holidays that are overridden and fall on selected days
        let count = 0;
        const selectedDays = jsonData.schedule.selectedDays;
        const dayIndices = selectedDays.map(day => getDayIndex(day));

        jsonData.holidays.forEach(holiday => {
            if (holiday.isOverridden) {
                const holidayDate = new Date(holiday.date);
                const dayOfWeek = holidayDate.getDay();

                if (dayIndices.includes(dayOfWeek)) {
                    count++;
                }
            }
        });

        return count;
    }





    /**
     * Initialize holiday override functionality
     */
    function initHolidayOverrides() {
        const $holidaysList = $('#holidays-list');
        const $overrideAllCheckbox = $('#override-all-holidays');
        const $skipAllBtn = $('#skip-all-holidays-btn');
        const $overrideAllBtn = $('#override-all-holidays-btn');
        const $holidayOverridesInput = $('#holiday_overrides');

        // Initialize holidayOverrides object if not already initialized
        if (typeof holidayOverrides !== 'object' || holidayOverrides === null) {
            holidayOverrides = {};
        }

        // Load existing overrides if available
        try {
            const existingOverrides = $holidayOverridesInput.val();
            if (existingOverrides) {
                holidayOverrides = JSON.parse(existingOverrides);
            }
        } catch (e) {
            console.error('Error parsing holiday overrides:', e);
        }

        // Handle "Override All" button click
        $overrideAllBtn.on('click', function() {
            batchUpdateHolidayOverrides(true);
        });

        // Handle "Skip All" button click
        $skipAllBtn.on('click', function() {
            batchUpdateHolidayOverrides(false);
        });

        // Handle "Override All" checkbox
        $overrideAllCheckbox.on('change', function() {
            const isChecked = $(this).prop('checked');
            batchUpdateHolidayOverrides(isChecked);
        });

        // Handle individual holiday checkbox changes - CONSOLIDATED HANDLER
        // Fix for WEC-82: Consolidated the two separate event handlers into one to prevent
        // the need to click multiple times on checkboxes
        $holidaysList.on('change', '.holiday-override-checkbox', function() {
            const $checkbox = $(this);
            const date = $checkbox.data('date');
            const isChecked = $checkbox.prop('checked');
            const $row = $checkbox.closest('tr');

            // Update the visual status
            $row.find('.holiday-skipped').toggleClass('d-none', isChecked);
            $row.find('.holiday-overridden').toggleClass('d-none', !isChecked);

            // Update the overrides object
            if (!holidayOverrides[date]) {
                const holidayName = $row.find('.holiday-name').text();
                holidayOverrides[date] = {
                    date: date,
                    name: holidayName,
                    override: isChecked
                };
            } else {
                holidayOverrides[date].override = isChecked;
            }

            // Save overrides to hidden input
            $holidayOverridesInput.val(JSON.stringify(holidayOverrides));

            // Update "Override All" checkbox state
            updateOverrideAllCheckbox();

            // Recalculate end date with the new overrides
            recalculateEndDate();

            // Update schedule tables if visible
            if (!$('#calendar-reference-container').hasClass('d-none')) {
                updateScheduleTables();
            } else {
                // Always update the debug JSON display even if the tables aren't visible
                const pattern = $('#schedule_pattern').val();
                const startDate = $('#schedule_start_date').val();
                const endDate = $('#schedule_end_date').val();
                const startTime = $('#schedule_start_time').val();
                const endTime = $('#schedule_end_time').val();
                const selectedDays = getSelectedDays();
                updateDebugJsonDisplay(pattern, startDate, endDate, startTime, endTime, selectedDays);
            }
        });

        // Check for holidays when start date changes
        $('#schedule_start_date').on('change', function() {
            const startDate = $(this).val();
            const endDate = $('#schedule_end_date').val();
            const pattern = $('#schedule_pattern').val();
            const scheduleDay = $('#schedule_day').val();
            const dayOfMonth = $('#schedule_day_of_month').val();

            if (startDate && pattern && ((pattern !== 'monthly' && scheduleDay) || (pattern === 'monthly' && dayOfMonth))) {
                checkForHolidays(startDate, endDate);
            }
        });

        // Update the "Override All" checkbox based on individual checkboxes
        function updateOverrideAllCheckbox() {
            const totalHolidays = $('.holiday-override-checkbox').length;
            const checkedHolidays = $('.holiday-override-checkbox:checked').length;

            if (checkedHolidays === 0) {
                $overrideAllCheckbox.prop('checked', false);
                $overrideAllCheckbox.prop('indeterminate', false);
            } else if (checkedHolidays === totalHolidays) {
                $overrideAllCheckbox.prop('checked', true);
                $overrideAllCheckbox.prop('indeterminate', false);
            } else {
                $overrideAllCheckbox.prop('indeterminate', true);
            }
        }

        /**
         * Batch update all holiday overrides - fixes issue where "Override All" only affected first holiday
         * @param {boolean} isChecked - Whether to check (override) or uncheck (skip) all holidays
         */
        function batchUpdateHolidayOverrides(isChecked) {
            const $checkboxes = $('.holiday-override-checkbox');

            // If no checkboxes found, return early
            if ($checkboxes.length === 0) {
                return;
            }

            // Set all checkboxes to the desired state without triggering change events
            $checkboxes.prop('checked', isChecked);

            // Update all holiday overrides and visual states in one batch
            $checkboxes.each(function() {
                const $checkbox = $(this);
                const date = $checkbox.data('date');
                const $row = $checkbox.closest('tr');

                // Update the visual status
                $row.find('.holiday-skipped').toggleClass('d-none', isChecked);
                $row.find('.holiday-overridden').toggleClass('d-none', !isChecked);

                // Update the overrides object
                if (!holidayOverrides[date]) {
                    const holidayName = $row.find('.holiday-name').text();
                    holidayOverrides[date] = {
                        date: date,
                        name: holidayName,
                        override: isChecked
                    };
                } else {
                    holidayOverrides[date].override = isChecked;
                }
            });

            // Save overrides to hidden input (once for all changes)
            $holidayOverridesInput.val(JSON.stringify(holidayOverrides));

            // Update "Override All" checkbox state
            updateOverrideAllCheckbox();

            // Recalculate end date with the new overrides (once for all changes)
            recalculateEndDate();

            // Update schedule tables if visible (once for all changes)
            if (!$('#calendar-reference-container').hasClass('d-none')) {
                updateScheduleTables();
            } else {
                // Always update the debug JSON display even if the tables aren't visible
                const pattern = $('#schedule_pattern').val();
                const startDate = $('#schedule_start_date').val();
                const endDate = $('#schedule_end_date').val();
                const startTime = $('#schedule_start_time').val();
                const endTime = $('#schedule_end_time').val();
                const selectedDays = getSelectedDays();
                updateDebugJsonDisplay(pattern, startDate, endDate, startTime, endTime, selectedDays);
            }
        }
    }

    /**
     * Check for public holidays in date range and show only holidays that conflict with the schedule
     */
    function checkForHolidays(startDate, endDate) {
        // If no public holidays data, return
        if (typeof wecozaPublicHolidays === 'undefined' || !wecozaPublicHolidays.events) {
            return;
        }

        // If no start date, return
        if (!startDate) {
            return;
        }

        // If no end date, use 3 months from start date
        if (!endDate) {
            const date = new Date(startDate);
            date.setMonth(date.getMonth() + 3);
            endDate = date.toISOString().split('T')[0];
        }

        // Get schedule pattern and related data
        const pattern = $('#schedule_pattern').val();
        const selectedDays = getSelectedDays();

        // Convert dates to Date objects for comparison
        const startDateObj = new Date(startDate);
        const endDateObj = new Date(endDate);

        // Filter holidays to only include those within the date range
        const allHolidaysInRange = wecozaPublicHolidays.events.filter(holiday => {
            // Parse the date parts to ensure correct date (avoid timezone issues)
            const [year, month, day] = holiday.start.split('-').map(Number);
            const holidayDate = new Date(year, month - 1, day);
            return holidayDate >= startDateObj && holidayDate <= endDateObj;
        });

        // If no holidays in range, show the no holidays message
        if (allHolidaysInRange.length === 0) {
            $('#holidays-table-container').addClass('d-none');
            $('#no-holidays-message').removeClass('d-none');
            return;
        }

        // Note: Removed verbose holiday logging to keep console clean

        // Check which holidays conflict with the class schedule
        allHolidaysInRange.forEach(holiday => {
            // Mark if this holiday conflicts with the schedule
            const holidayDate = new Date(holiday.start);
            const dayName = holidayDate.toLocaleDateString('en-US', { weekday: 'long' });

            // For weekly/biweekly patterns, check if the holiday falls on a selected day
            if ((pattern === 'weekly' || pattern === 'biweekly') && selectedDays.includes(dayName)) {
                holiday.conflictsWithSchedule = true;
            } else {
                holiday.conflictsWithSchedule = false;
            }
        });

        console.log('Holidays with conflict status:', allHolidaysInRange);

        // Load any saved overrides from session storage
        try {
            const savedOverrides = sessionStorage.getItem('holidayOverrides');
            if (savedOverrides) {
                holidayOverrides = JSON.parse(savedOverrides);
                $('#holiday_overrides').val(savedOverrides);
                console.log('Using saved holiday overrides:', holidayOverrides);
            }
        } catch (e) {
            console.error('Error parsing saved holiday overrides:', e);
        }

        // Filter to only include holidays that conflict with the schedule
        const conflictingHolidays = allHolidaysInRange.filter(holiday => holiday.conflictsWithSchedule);

        // If no conflicting holidays, show the no holidays message
        if (conflictingHolidays.length === 0) {
            $('#holidays-table-container').addClass('d-none');
            $('#no-holidays-message').removeClass('d-none');
            return;
        }

        // Populate the holidays list with only conflicting holidays
        populateHolidaysList(conflictingHolidays);

        // Show the holidays table
        $('#no-holidays-message').addClass('d-none');
        $('#holidays-table-container').removeClass('d-none');
    }

    /**
     * Check if a holiday conflicts with the class schedule
     * Note: This function is no longer used as we now handle conflicts directly in checkForHolidays
     */
    function holidayConflictsWithSchedule(holidayDate, pattern, scheduleDay, dayOfMonth, startDate) {
        // Parse the holiday date
        const holidayDateObj = new Date(holidayDate);
        const holidayDayOfWeek = holidayDateObj.getDay(); // 0 = Sunday, 1 = Monday, etc.
        const holidayDayOfMonth = holidayDateObj.getDate(); // 1-31

        // For weekly pattern, check if the holiday falls on the scheduled day of the week
        if (pattern === 'weekly') {
            const scheduleDayIndex = getDayIndex(scheduleDay);
            return holidayDayOfWeek === scheduleDayIndex;
        }

        // For bi-weekly pattern, check if the holiday falls on the scheduled day of the week
        // and is in the correct week sequence
        if (pattern === 'biweekly') {
            const scheduleDayIndex = getDayIndex(scheduleDay);

            // First, check if it's the right day of the week
            if (holidayDayOfWeek !== scheduleDayIndex) {
                return false;
            }

            // Then check if it's in the correct bi-weekly sequence
            const startDateObj = new Date(startDate);

            // Set start date to the first occurrence of the scheduled day
            while (startDateObj.getDay() !== scheduleDayIndex) {
                startDateObj.setDate(startDateObj.getDate() + 1);
            }

            // Calculate days between start date and holiday
            const daysDiff = Math.round((holidayDateObj - startDateObj) / (1000 * 60 * 60 * 24));

            // Check if the difference is divisible by 14 (bi-weekly)
            return daysDiff % 14 === 0;
        }

        // For monthly pattern, check if the holiday falls on the scheduled day of the month
        if (pattern === 'monthly') {
            if (dayOfMonth === 'last') {
                // Check if it's the last day of the month
                const lastDayOfMonth = new Date(holidayDateObj.getFullYear(), holidayDateObj.getMonth() + 1, 0).getDate();
                return holidayDayOfMonth === lastDayOfMonth;
            } else {
                // Check if it's the specified day of the month
                return holidayDayOfMonth === parseInt(dayOfMonth);
            }
        }

        // For custom pattern, we can't determine conflicts automatically
        if (pattern === 'custom') {
            // For custom patterns, we'll show all holidays in the range
            return true;
        }

        return false;
    }

    /**
     * Populate the holidays list in the public holidays section
     */
    function populateHolidaysList(holidays) {
        const $holidaysList = $('#holidays-list');
        const $template = $('#holiday-row-template');
        const $noHolidaysAlert = $('#no-holidays-message');
        const $holidaysTableContainer = $('#holidays-table-container');

        // Clear existing rows
        $holidaysList.empty();

        // Show/hide no holidays alert and table container
        if (holidays.length === 0) {
            $noHolidaysAlert.removeClass('d-none');
            $holidaysTableContainer.addClass('d-none');
            return;
        } else {
            $noHolidaysAlert.addClass('d-none');
            $holidaysTableContainer.removeClass('d-none');
        }

        // Add a row for each holiday
        holidays.forEach((holiday, index) => {
            // Get template content
            const templateHtml = $template.html();

            // Format the date for display
            const [year, month, day] = holiday.start.split('-').map(Number);
            const holidayDate = new Date(year, month - 1, day);
            const formattedDate = holidayDate.toLocaleDateString('en-ZA', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            // Replace placeholders
            let rowHtml = templateHtml
                .replace(/{id}/g, index)
                .replace(/{date}/g, holiday.start)
                .replace(/{formatted_date}/g, formattedDate)
                .replace(/{name}/g, holiday.title);

            // Add to list
            $holidaysList.append(rowHtml);

            // Get the row we just added
            const $row = $holidaysList.find(`[data-date="${holiday.start}"]`).closest('tr');

            // Check if this holiday has an existing override
            let isOverridden = false;
            if (holidayOverrides[holiday.start]) {
                isOverridden = holidayOverrides[holiday.start].override;

                // Update checkbox
                $row.find('.holiday-override-checkbox').prop('checked', isOverridden);
            }

            // Update status badges based on override status
            $row.find('.holiday-skipped').toggleClass('d-none', isOverridden);
            $row.find('.holiday-overridden').toggleClass('d-none', !isOverridden);

            // Add highlight for all rows (all are conflicts now)
            // $row.addClass('table-warning');
        });

        // Update "Override All" checkbox state
        const $overrideAllCheckbox = $('#override-all-holidays');
        const totalHolidays = $('.holiday-override-checkbox').length;
        const checkedHolidays = $('.holiday-override-checkbox:checked').length;

        if (checkedHolidays === 0) {
            $overrideAllCheckbox.prop('checked', false);
            $overrideAllCheckbox.prop('indeterminate', false);
        } else if (checkedHolidays === totalHolidays) {
            $overrideAllCheckbox.prop('checked', true);
            $overrideAllCheckbox.prop('indeterminate', false);
        } else {
            $overrideAllCheckbox.prop('indeterminate', true);
        }
    }

    /**
     * Get day index from day name
     */
    function getDayIndex(dayName) {
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return days.indexOf(dayName);
    }

    /**
     * Update exception dates table
     */
    function updateExceptionDatesTable() {
        const $exceptionDatesTable = $('#exception-dates-table');
        const $noExceptionDatesRow = $('#no-exception-dates-row');

        // Get all exception date rows
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

        // Clear existing rows except the "no exception dates" row
        $exceptionDatesTable.find('tr:not(#no-exception-dates-row)').remove();

        // Show/hide "no exception dates" row
        if (exceptionDates.length === 0) {
            $noExceptionDatesRow.show();
            return;
        } else {
            $noExceptionDatesRow.hide();
        }

        // Format dates for display
        const formatDate = function(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-ZA', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        };

        // Add a row for each exception date
        exceptionDates.forEach(function(exceptionDate) {
            const formattedDate = formatDate(exceptionDate.date);
            const reasonText = exceptionDate.reason || 'No reason specified';

            const $row = $('<tr></tr>');
            $row.append('<td>' + formattedDate + '</td>');
            $row.append('<td>' + reasonText + '</td>');

            $exceptionDatesTable.append($row);
        });
    }

    /**
     * Update holidays table
     */
    function updateHolidaysTable(startDate, endDate) {
        const $holidaysTable = $('#holidays-table');
        const $noHolidaysRow = $('#no-holidays-row');
        const selectedDays = getSelectedDays();
        const pattern = $('#schedule_pattern').val();

        // If no public holidays data, show "no holidays" row and return
        if (typeof wecozaPublicHolidays === 'undefined' || !wecozaPublicHolidays.events) {
            $holidaysTable.find('tr:not(#no-holidays-row)').remove();
            $noHolidaysRow.show();
            return;
        }

        // If no start date or end date, show "no holidays" row and return
        if (!startDate || !endDate) {
            $holidaysTable.find('tr:not(#no-holidays-row)').remove();
            $noHolidaysRow.show();
            return;
        }

        // Convert dates to Date objects for comparison
        const startDateObj = new Date(startDate);
        const endDateObj = new Date(endDate);

        // Filter holidays to only include those within the date range
        const holidaysInRange = wecozaPublicHolidays.events.filter(holiday => {
            // Parse the date parts to ensure correct date (avoid timezone issues)
            const [year, month, day] = holiday.start.split('-').map(Number);
            const holidayDate = new Date(year, month - 1, day);
            return holidayDate >= startDateObj && holidayDate <= endDateObj;
        });

        // Filter to only include holidays that conflict with the schedule
        const conflictingHolidays = holidaysInRange.filter(holiday => {
            const holidayDate = new Date(holiday.start);
            const dayName = holidayDate.toLocaleDateString('en-US', { weekday: 'long' });

            // For weekly/biweekly patterns, check if the holiday falls on a selected day
            return (pattern === 'weekly' || pattern === 'biweekly') && selectedDays.includes(dayName);
        });

        // Clear existing rows except the "no holidays" row
        $holidaysTable.find('tr:not(#no-holidays-row)').remove();

        // Show/hide "no holidays" row
        if (conflictingHolidays.length === 0) {
            $noHolidaysRow.show();
            return;
        } else {
            $noHolidaysRow.hide();
        }

        // Format dates for display
        const formatDate = function(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-ZA', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        };

        // Add a row for each holiday
        // conflictingHolidays.forEach(function(holiday) {
        //     const formattedDate = formatDate(holiday.start);
        //     const holidayName = holiday.title;

        //     // Check if this holiday has been overridden
        //     let isOverridden = false;
        //     if (typeof holidayOverrides === 'object' && holidayOverrides[holiday.start]) {
        //         isOverridden = holidayOverrides[holiday.start].override;
        //     }

        //     const $row = $('<tr></tr>');
        //     $row.append('<td>' + formattedDate + '</td>');
        //     $row.append('<td>' + holidayName + '</td>');

        //     // Add status badge
        //     if (isOverridden) {
        //         $row.append('<td><span class="badge bg-warning text-dark">Included</span></td>');
        //     } else {
        //         $row.append('<td><span class="badge bg-danger">Skipped</span></td>');
        //     }

        //     $holidaysTable.append($row);
        // });
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
        const $container = $('#schedule-data-container');
        $container.empty();

        // Get form data
        const pattern = $('#schedule_pattern').val();
        const selectedDays = getSelectedDays();
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

        // Store selected days as JSON array
        if (selectedDays.length > 0) {
            $container.append('<input type="hidden" name="schedule_data[days]" value=\'' + JSON.stringify(selectedDays) + '\'>');
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

        // Update schedule tables if visible
        if (!$('#calendar-reference-container').hasClass('d-none')) {
            updateScheduleTables();

            // Create JSON data for statistics
            const jsonData = {
                schedule: {
                    pattern: pattern,
                    startDate: startDate,
                    endDate: endDate,
                    selectedDays: selectedDays,
                    classTime: {
                        start: startTime,
                        end: endTime
                    }
                },
                exceptionDates: exceptionDates,
                holidays: getHolidaysInRange(startDate, endDate),
                metadata: {
                    lastUpdated: new Date().toISOString(),
                    version: "1.0"
                }
            };

            // Update schedule statistics if the statistics section is visible
            if (!$('#schedule-statistics-section').hasClass('d-none')) {
                updateScheduleStatistics(jsonData);
            }
        } else {
            // Always update the debug JSON display even if the tables aren't visible
            updateDebugJsonDisplay(pattern, startDate, endDate, startTime, endTime, selectedDays);
        }
    }

    /**
     * Get holidays in date range
     */
    function getHolidaysInRange(startDate, endDate) {
        const holidays = [];

        if (typeof wecozaPublicHolidays !== 'undefined' && wecozaPublicHolidays.events && startDate && endDate) {
            // Convert dates to Date objects for comparison
            const startDateObj = new Date(startDate);
            const endDateObj = new Date(endDate);

            // Filter holidays to only include those within the date range
            wecozaPublicHolidays.events.forEach(holiday => {
                // Parse the date parts to ensure correct date (avoid timezone issues)
                const [year, month, day] = holiday.start.split('-').map(Number);
                const holidayDate = new Date(year, month - 1, day);

                if (holidayDate >= startDateObj && holidayDate <= endDateObj) {
                    // Check if this holiday has been overridden
                    let isOverridden = false;
                    if (typeof holidayOverrides === 'object' && holidayOverrides[holiday.start]) {
                        isOverridden = holidayOverrides[holiday.start].override;
                    }

                    holidays.push({
                        date: holiday.start,
                        name: holiday.title,
                        isOverridden: isOverridden
                    });
                }
            });
        }

        return holidays;
    }

    /**
     * Validate the form before submission
     */
    function validateForm() {
        let isValid = true;

        // Check if schedule start date is invalid
        const $scheduleStartDate = $('#schedule_start_date');
        if ($scheduleStartDate.attr('data-valid') === 'false') {
            // Scroll to the schedule start date
            $('html, body').animate({
                scrollTop: $scheduleStartDate.offset().top - 100
            }, 200);

            // Focus on the input
            $scheduleStartDate.focus();

            // Return false to prevent form submission
            return false;
        }

        // Check if any exception date is invalid
        const $invalidExceptionDates = $('#exception-dates-container .exception-date-row[data-valid="false"]');

        if ($invalidExceptionDates.length > 0) {
            // Scroll to the first invalid exception date
            $('html, body').animate({
                scrollTop: $invalidExceptionDates.first().offset().top - 100
            }, 200);

            // Focus on the invalid input
            $invalidExceptionDates.first().find('input[name="exception_dates[]"]').focus();

            // Return false to prevent form submission
            return false;
        }

        // Validate day selection for weekly/biweekly patterns
        const pattern = $('#schedule_pattern').val();
        if ((pattern === 'weekly' || pattern === 'biweekly') && !$('#day-selection-container').hasClass('d-none')) {
            const anyDaySelected = $('.schedule-day-checkbox:checked').length > 0;
            if (!anyDaySelected) {
                // Show validation error
                $('#day-selection-container').find('.invalid-feedback').show();
                $('#day-selection-container').find('.valid-feedback').hide();

                // Scroll to the day selection container
                $('html, body').animate({
                    scrollTop: $('#day-selection-container').offset().top - 100
                }, 200);

                isValid = false;
            } else {
                $('#day-selection-container').find('.invalid-feedback').hide();
                $('#day-selection-container').find('.valid-feedback').show();
            }

            // Set the interaction flag to true since we're validating the form
            dayCheckboxInteracted = true;
        }

        return isValid;
    }

    /**
     * Initialize validation for class original start date
     */
    function initOriginalStartDateValidation() {
        // Set initial validation state for schedule start date
        $('#schedule_start_date').attr('data-valid', 'true');

        // When class original start date changes, validate schedule start date
        $('#class_start_date').on('change', function() {
            const originalStartDate = $(this).val();
            const scheduleStartDate = $('#schedule_start_date').val();

            if (scheduleStartDate && originalStartDate && scheduleStartDate < originalStartDate) {
                // Show validation error on schedule start date
                $('#schedule_start_date').addClass('is-invalid');
                $('#schedule_start_date').siblings('.invalid-feedback').text('Start date cannot be before the class original start date');
                $('#schedule_start_date').attr('data-valid', 'false');
            } else if (scheduleStartDate) {
                // Clear validation error
                $('#schedule_start_date').removeClass('is-invalid');
                $('#schedule_start_date').siblings('.invalid-feedback').text('Please select a start date.');
                $('#schedule_start_date').attr('data-valid', 'true');
            }
        });

        // Initial validation check
        setTimeout(function() {
            const originalStartDate = $('#class_start_date').val();
            const scheduleStartDate = $('#schedule_start_date').val();

            if (scheduleStartDate && originalStartDate && scheduleStartDate < originalStartDate) {
                // Show validation error on schedule start date
                $('#schedule_start_date').addClass('is-invalid');
                $('#schedule_start_date').siblings('.invalid-feedback').text('Start date cannot be before the class original start date');
                $('#schedule_start_date').attr('data-valid', 'false');
            }
        }, 100);
    }

    /**
     * Initialize feedback messages to be hidden on page load
     */
    function initFeedbackMessages() {
        // Hide all feedback messages on initial load
        $('#day-selection-container').find('.invalid-feedback').hide();
        $('#day-selection-container').find('.valid-feedback').hide();
    }

    // Initialize when document is ready
    $(document).ready(function() {
        initFeedbackMessages();
        initClassScheduleForm();
        initOriginalStartDateValidation();

        // Initialize debug JSON display
        const pattern = $('#schedule_pattern').val();
        const startDate = $('#schedule_start_date').val();
        const endDate = $('#schedule_end_date').val();
        const startTime = $('#schedule_start_time').val();
        const endTime = $('#schedule_end_time').val();
        const selectedDays = getSelectedDays();
        updateDebugJsonDisplay(pattern, startDate, endDate, startTime, endTime, selectedDays);

        // Check for holidays if we have start and end dates
        if (startDate && endDate) {
            checkForHolidays(startDate, endDate);
        }

        // Add form validation before submission
        $('form').on('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    });

})(jQuery);
