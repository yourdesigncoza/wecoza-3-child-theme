/**
 * Class Capture JavaScript
 *
 * Handles the client-side functionality for the class capture form
 */
var calendar;
var calendarInitialized = false;

/**
 * Helper function to get day index from day name
 * @param {string} dayName - The name of the day (e.g., 'Monday')
 * @returns {number} - The index of the day (0-6, where 0 is Sunday)
 */
function getDayIndex(dayName) {
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    return days.indexOf(dayName);
}

/**
 * Helper function to get day of week from date
 * @param {Date} date - The date object
 * @returns {string} - The name of the day
 */
function getDayOfWeek(date) {
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    return days[date.getDay()];
}

/**
 * Helper function to format date as YYYY-MM-DD
 * @param {Date} date - The date object
 * @returns {string} - The formatted date string
 */
function formatDate(date) {
    const d = new Date(date);
    let month = '' + (d.getMonth() + 1);
    let day = '' + d.getDate();
    const year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

/**
 * Helper function to format time in 12-hour format
 * @param {Date|number} dateOrHour - Either a Date object or an hour (0-23)
 * @param {number} [minute] - The minute (0-59), only used if dateOrHour is a number
 * @returns {string} - The formatted time string (e.g., "6:30 AM")
 */
function formatTime(dateOrHour, minute) {
    let hours, minutes;

    if (dateOrHour instanceof Date) {
        // If a Date object is passed
        hours = dateOrHour.getHours();
        minutes = dateOrHour.getMinutes();
    } else {
        // If hour and minute are passed separately
        hours = dateOrHour;
        minutes = minute;
    }

    const ampm = hours >= 12 ? 'PM' : 'AM';
    const hour12 = hours % 12 || 12; // Convert 0 to 12 for 12 AM
    const minuteStr = minutes < 10 ? '0' + minutes : minutes;

    return hour12 + ':' + minuteStr + ' ' + ampm;
}

// Make the initialization function globally available
function initializeClassCalendar() {
    console.log('Manual calendar initialization triggered');
}

/**
 * Show a custom alert dialog instead of using the browser's native alert
 * @param {string} message - The message to display
 */
function showCustomAlert(message) {
    // Create the modal HTML if it doesn't exist
    if ($('#custom-alert-modal').length === 0) {
        const modalHTML = `
            <div class="modal fade" id="custom-alert-modal" tabindex="-1" aria-labelledby="custom-alert-modal-label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="custom-alert-modal-label">localhost says</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="custom-alert-message">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHTML);
    }

    // Set the message and show the modal
    $('#custom-alert-message').text(message);
    const modal = new bootstrap.Modal(document.getElementById('custom-alert-modal'));
    modal.show();
}

// Initialize calendar when it's in a tab
(function() {
    if (jQuery('#class-calendar').length) {
        setTimeout(function() {
            if (typeof initializeCalendarInTab === 'function') {
                initializeCalendarInTab();
            } else {
                console.log('Calendar initialization function not found, trying direct initialization');
                if (calendar) {
                    calendar.updateSize();
                    calendarInitialized = true;
                    console.log('Calendar size updated');
                } else {
                    console.log('Calendar object not found, initializing from scratch');
                    initClassCaptureForm();
                }
            }
        }, 100);
    } else {
        console.log('Calendar container not found');
    }
})();

(function($) {
    'use strict';

    // These variables are now declared globally at the top of the file
    // to make them accessible outside the IIFE

    /**
     * Initialize the class capture form
     */
    window.initClassCaptureForm = function() {
        // Initialize the calendar if the container has the data-calendar-init attribute
        if ($('#class-calendar[data-calendar-init="true"]').length) {
            initializeCalendar();
        }

        // Initialize the site address lookup
        initializeSiteAddressLookup();

        // Initialize day of week restriction for start date
        initializeDayOfWeekRestriction();

        // Initialize the exam type toggle
        initializeExamTypeToggle();

        // Initialize the SETA field toggle
        initializeSetaToggle();

        // Initialize the date history functionality
        initializeDateHistory();

        // Initialize the QA visit dates functionality
        initializeQAVisits();

        // Initialize the class learners functionality
        initializeClassLearners();

        // Initialize the backup agents functionality
        initializeBackupAgents();

        // Initialize the agent replacements functionality
        initializeAgentReplacements();

        // Initialize form submission
        initializeFormSubmission();
    }

    /**
     * Initialize the calendar
     */
    function initializeCalendar() {
        // 1. Generate 30-min increments from 6:00 AM to 8:00 PM
        function generateTimeOptions() {
            let optionsHTML = '';
            for (let hour = 6; hour <= 20; hour++) {
                for (let min = 0; min < 60; min += 30) {
                    let label = formatTime(hour, min);  // e.g. "6:00 AM", "6:30 AM", etc.
                    optionsHTML += '<option value="' + label + '">' + label + '</option>';
                }
            }
            return optionsHTML;
        }

        // 2. Use the global formatTime function

        // 3. Helper function to convert 12-hour format to 24-hour format
        function convertTo24Hour(time12h) {
            const [time, modifier] = time12h.split(' ');
            let [hours, minutes] = time.split(':');

            if (hours === '12') {
                hours = '00';
            }

            if (modifier === 'PM') {
                hours = parseInt(hours, 10) + 12;
            }

            return `${hours}:${minutes}`;
        }

        // 4. Use the global getDayOfWeek function

        // 5. Use the global formatDate function

        // 6. Helper function to combine date and time
        function combineDateTime(dateStr, timeStr) {
            const date = new Date(dateStr + 'T' + convertTo24Hour(timeStr) + ':00');
            return date;
        }

        // Populate time dropdowns in the modal
        const timeOptions = generateTimeOptions();
        $('#eventStartTime').html(timeOptions);
        $('#eventEndTime').html(timeOptions);

        // Initialize FullCalendar
        const calendarEl = document.getElementById('class-calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Today',
                month: 'Month',
                week: 'Week',
                day: 'Day'
            },
            height: 500,
            allDaySlot: false,
            slotMinTime: '06:00:00',
            slotMaxTime: '20:00:00',
            slotDuration: '00:30:00',
            editable: true,
            selectable: true,
            selectMirror: true,
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
            select: function(arg) {
                // Reset validation state
                resetValidationState();

                // Open modal for new event
                const startDate = formatDate(arg.start);
                const endDate = formatDate(arg.end);
                const dayOfWeek = getDayOfWeek(arg.start);

                // Set default values in the form
                $('#eventId').val(''); // New event
                $('#eventType').val(''); // Empty to force selection
                $('#eventDescription').val('');
                $('#eventDate').val(startDate);
                $('#eventDay').val(dayOfWeek);

                // Set times based on selection
                const startHour = arg.start.getHours();
                const startMinute = arg.start.getMinutes();
                const endHour = arg.end.getHours();
                const endMinute = arg.end.getMinutes();

                const startTime = formatTime(startHour, startMinute);
                const endTime = formatTime(endHour, endMinute);

                $('#eventStartTime').val(startTime);
                $('#eventEndTime').val(endTime);

                // Show the modal using JavaScript instead of Bootstrap's modal method
                const modal = document.getElementById('eventModal');
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.classList.add('modal-open');

                // Create backdrop if it doesn't exist
                if (!document.querySelector('.modal-backdrop')) {
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    document.body.appendChild(backdrop);
                }
            },
            eventClick: function(arg) {
                // Reset validation state
                resetValidationState();

                // Open modal with existing event data
                const event = arg.event;
                const dayOfWeek = event.extendedProps.day || getDayOfWeek(event.start);

                $('#eventId').val(event.id);
                $('#eventType').val(event.extendedProps.type || ''); // Empty if not set to force selection
                $('#eventDescription').val(event.title);
                $('#eventDate').val(formatDate(event.start));
                $('#eventDay').val(dayOfWeek);

                // Format times for the dropdowns
                const startHour = event.start.getHours();
                const startMinute = event.start.getMinutes();
                const endHour = event.end.getHours();
                const endMinute = event.end.getMinutes();

                const startTime = formatTime(startHour, startMinute);
                const endTime = formatTime(endHour, endMinute);

                $('#eventStartTime').val(startTime);
                $('#eventEndTime').val(endTime);

                // Show the modal using JavaScript instead of Bootstrap's modal method
                const modal = document.getElementById('eventModal');
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.classList.add('modal-open');

                // Create backdrop if it doesn't exist
                if (!document.querySelector('.modal-backdrop')) {
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    document.body.appendChild(backdrop);
                }
            },
            eventDrop: function(arg) {
                updateHiddenFields();
            },
            eventResize: function(arg) {
                updateHiddenFields();
            }
        });

        // Render the calendar
        calendar.render();

        // Initialize hidden fields
        updateHiddenFields();

        // Add event listener for calendar changes
        calendar.on('eventChange', function() {
            updateHiddenFields();
        });

        // Function to properly initialize calendar when it becomes visible
        window.initializeCalendarInTab = function() {
            if (!calendarInitialized) {
                calendar.updateSize();
                calendarInitialized = true;
                console.log('Calendar fully initialized');
            } else {
                // Even if already initialized, update size to ensure proper display
                calendar.updateSize();
                console.log('Calendar size updated');
            }
        }

        // The initialization function is now defined globally at the top of the file

        // Specifically target the vertical tab that contains our calendar
        $(document).on('click', '[href="#vertical-tabpanel-6"], [data-bs-target="#vertical-tabpanel-6"]', function() {
            console.log('Calendar tab clicked');
            // Small delay to let the tab become visible
            setTimeout(function() {
                initializeCalendarInTab();
            }, 100);
        });

        // Also listen for any tab changes that might affect our calendar
        $(document).on('click', '[data-toggle="tab"]', function() {
            if ($('#class-calendar').is(':visible')) {
                console.log('Calendar became visible via tab change');
                setTimeout(function() {
                    initializeCalendarInTab();
                }, 100);
            }
        });

        // Check if we're already on the calendar tab on page load
        if (window.location.hash === '#vertical-tabpanel-6' || $('#vertical-tabpanel-6').is(':visible')) {
            console.log('Calendar tab is active on page load');
            setTimeout(function() {
                initializeCalendarInTab();
            }, 200);
        }

        // Listen for Bootstrap's tab shown event
        $(document).on('shown.bs.tab', function(e) {
            var target = $(e.target).attr('data-bs-target') || $(e.target).attr('href');
            if (target === '#vertical-tabpanel-6') {
                console.log('Bootstrap tab event: calendar tab shown');
                setTimeout(function() {
                    initializeCalendarInTab();
                }, 100);
            }
        });

        // Function to reset validation state
        function resetValidationState() {
            $('#eventType, #eventDescription, #eventStartTime, #eventEndTime').removeClass('is-invalid is-valid');
        }

        // Function to close modal properly
        function closeModal() {
            const modal = document.getElementById('eventModal');
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.classList.remove('modal-open');

            // Remove backdrop
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.parentNode.removeChild(backdrop);
            }

            // Reset validation state
            resetValidationState();
        }

        // Close button handler
        $('#closeModalBtn, #cancelEvent').on('click', function() {
            closeModal();
        });

        // Save event handler
        $('#saveEvent').on('click', function() {
            const eventId = $('#eventId').val();
            const eventType = $('#eventType').val();
            const description = $('#eventDescription').val();
            const eventDate = $('#eventDate').val();
            const eventDay = $('#eventDay').val();
            const startTime = $('#eventStartTime').val();
            const endTime = $('#eventEndTime').val();

            // Validate form
            let isValid = true;

            // Check each required field and add visual indication
            if (!eventType) {
                $('#eventType').addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            } else {
                $('#eventType').removeClass('is-invalid').addClass('is-valid');
            }

            if (!description) {
                $('#eventDescription').addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            } else {
                $('#eventDescription').removeClass('is-invalid').addClass('is-valid');
            }

            if (!startTime) {
                $('#eventStartTime').addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            } else {
                $('#eventStartTime').removeClass('is-invalid').addClass('is-valid');
            }

            if (!endTime) {
                $('#eventEndTime').addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            } else {
                $('#eventEndTime').removeClass('is-invalid').addClass('is-valid');
            }

            if (!eventDate) {
                isValid = false;
            }

            if (!isValid) {
                alert('Please fill in all required fields');
                return;
            }

            try {
                // Create event object
                const eventData = {
                    id: eventId || Date.now().toString(), // Use timestamp as ID for new events
                    title: description,
                    start: combineDateTime(eventDate, startTime),
                    end: combineDateTime(eventDate, endTime),
                    extendedProps: {
                        type: eventType,
                        day: eventDay
                    }
                };

                // If editing an existing event, remove the old one
                if (eventId) {
                    const existingEvent = calendar.getEventById(eventId);
                    if (existingEvent) {
                        existingEvent.remove();
                    }
                }

                // Add the event to the calendar
                calendar.addEvent(eventData);

                // Update hidden fields
                updateHiddenFields();

                // Close modal
                closeModal();

                // Log success for debugging
                console.log('Event saved successfully:', eventData);
                console.log('Calendar events after save:', calendar.getEvents());
            } catch (error) {
                console.error('Error saving event:', error);
                alert('There was an error saving the event. Please try again.');
            }
        });

        // Delete event handler
        $('#deleteEvent').on('click', function() {
            const eventId = $('#eventId').val();

            if (eventId) {
                try {
                    // Remove the event from the calendar
                    const existingEvent = calendar.getEventById(eventId);
                    if (existingEvent) {
                        existingEvent.remove();
                    }

                    // Update hidden fields
                    updateHiddenFields();

                    // Close modal
                    closeModal();

                    console.log('Event deleted successfully');
                    console.log('Calendar events after delete:', calendar.getEvents());
                } catch (error) {
                    console.error('Error deleting event:', error);
                    alert('There was an error deleting the event. Please try again.');
                }
            } else {
                // Just close the modal if there's no event to delete
                closeModal();
            }
        });

        // Update hidden fields with calendar data
        function updateHiddenFields() {
            try {
                const events = calendar.getEvents();
                const scheduleContainer = $('#schedule-data-container');

                // Clear existing hidden fields
                scheduleContainer.empty();

                console.log('Updating hidden fields with events:', events);

                // Create hidden fields for each event
                events.forEach(function(event, index) {
                    if (!event.start || !event.end) {
                        console.error('Event missing start or end time:', event);
                        return;
                    }

                    const startDate = formatDate(event.start);
                    const startHour = event.start.getHours();
                    const startMinute = event.start.getMinutes();
                    const endHour = event.end.getHours();
                    const endMinute = event.end.getMinutes();

                    const startTime = formatTime(startHour, startMinute);
                    const endTime = formatTime(endHour, endMinute);

                    // Get day from extendedProps or calculate it
                    const day = event.extendedProps && event.extendedProps.day ?
                               event.extendedProps.day :
                               getDayOfWeek(event.start);

                    // Get type from extendedProps or default to 'class'
                    const type = event.extendedProps && event.extendedProps.type ?
                                event.extendedProps.type :
                                'class';

                    // Create hidden inputs with the same names as the original form
                    scheduleContainer.append(`<input type="hidden" name="schedule_day[]" value="${day}">`);
                    scheduleContainer.append(`<input type="hidden" name="schedule_date[]" value="${startDate}">`);
                    scheduleContainer.append(`<input type="hidden" name="start_time[]" value="${startTime}">`);
                    scheduleContainer.append(`<input type="hidden" name="end_time[]" value="${endTime}">`);
                    scheduleContainer.append(`<input type="hidden" name="schedule_notes[]" value="${event.title}">`);
                    scheduleContainer.append(`<input type="hidden" name="event_type[]" value="${type}">`);

                    console.log('Added hidden fields for event:', {
                        day: day,
                        date: startDate,
                        startTime: startTime,
                        endTime: endTime,
                        title: event.title,
                        type: type
                    });
                });

                // Add a debug message to show the number of events processed
                console.log(`Updated hidden fields for ${events.length} events`);
            } catch (error) {
                console.error('Error updating hidden fields:', error);
            }
        }
    }

    /**
     * Initialize day of week restriction for start date
     */
    function initializeDayOfWeekRestriction() {
        const $scheduleDay = $('#schedule_day');
        const $startDate = $('#schedule_start_date');

        // Function to restrict start date based on selected day
        function restrictStartDateByDay() {
            const selectedDay = $scheduleDay.val();

            if (selectedDay && $scheduleDay.is(':visible')) {
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
                    }
                }
            }
        }

        // Apply restriction when day changes
        $scheduleDay.on('change', function() {
            restrictStartDateByDay();
        });

        // Apply restriction when date changes
        $startDate.on('change', function() {
            const selectedDay = $scheduleDay.val();

            if (selectedDay && $scheduleDay.is(':visible')) {
                const date = new Date($(this).val());
                const dayIndex = getDayIndex(selectedDay);

                if (date.getDay() !== dayIndex) {
                    // Find the next occurrence of the selected day
                    while (date.getDay() !== dayIndex) {
                        date.setDate(date.getDate() + 1);
                    }

                    // Update the start date
                    $(this).val(date.toISOString().split('T')[0]);
                }
            }
        });

        // Initial check
        restrictStartDateByDay();
    }

    /**
     * Initialize the site address lookup
     */
    function initializeSiteAddressLookup() {
        // Get site addresses from localized script
        const siteAddresses = wecozaClass.siteAddresses || {};

        // On change of the select, look up the address and show/hide accordingly
        $("#site_id").on("change", function() {
            var selectedValue = $(this).val();
            var $addressWrapper = $("#address-wrapper");
            var $addressInput = $("#site_address");

            // If there's a matching address, populate and show
            if (siteAddresses[selectedValue]) {
                $addressInput.val(siteAddresses[selectedValue]);
                $addressWrapper.show();
            } else {
                // Otherwise clear and hide
                $addressInput.val("");
                $addressWrapper.hide();
            }
        });
    }

    /**
     * Initialize the SETA field toggle
     */
    function initializeSetaToggle() {
        // Handle SETA Funded selection change
        document.getElementById('seta_funded').addEventListener('change', function() {
            var setaContainer = document.getElementById('seta_container');
            var setaSelect = document.getElementById('seta_id');

            if (this.value === 'Yes') {
                // Show SETA field and make it required
                setaContainer.style.display = 'block';
                setaSelect.setAttribute('required', 'required');
            } else {
                // Hide SETA field and remove required attribute
                setaContainer.style.display = 'none';
                setaSelect.removeAttribute('required');
                // Reset the SETA selection
                setaSelect.value = '';
            }
        });

        // Check initial state on page load
        var setaFunded = document.getElementById('seta_funded');
        if (setaFunded.value === 'Yes') {
            var setaContainer = document.getElementById('seta_container');
            var setaSelect = document.getElementById('seta_id');
            setaContainer.style.display = 'block';
            setaSelect.setAttribute('required', 'required');
        }
    }

    /**
     * Initialize the exam type toggle and exam learners functionality
     */
    function initializeExamTypeToggle() {
        // References to DOM elements
        const $examTypeContainer = $('#exam_type_container');
        const $examLearnersContainer = $('#exam_learners_container');
        const $examLearnerSelect = $('#exam_learner_select');
        const $addSelectedExamLearnersBtn = $('#add-selected-exam-learners-btn');
        const $examLearnersTable = $('#exam-learners-table');
        const $examLearnersTbody = $('#exam-learners-tbody');
        const $noExamLearnersMessage = $('#no-exam-learners-message');
        const $examLearnersData = $('#exam_learners');

        // Array to store exam learner data
        let examLearners = [];

        // Handle exam class selection change
        document.getElementById('exam_class').addEventListener('change', function() {
            if (this.value === 'Yes') {
                // Show exam type field and make it required
                $examTypeContainer.show();
                document.getElementById('exam_type').setAttribute('required', 'required');

                // Show exam learners container
                $examLearnersContainer.show();

                // Update the exam learner select options based on class learners
                updateExamLearnerOptions();

                // Validate exam learners immediately
                if (typeof validateExamLearners === 'function') {
                    validateExamLearners();
                }
            } else {
                // Hide exam type field and remove required attribute
                $examTypeContainer.hide();
                document.getElementById('exam_type').removeAttribute('required');

                // Hide exam learners container
                $examLearnersContainer.hide();

                // Clear exam learners data
                examLearners = [];
                updateExamLearnersData();

                // Remove any validation styling
                $('#exam_learners_container').removeClass('border-danger');
                $('#no-exam-learners-message').removeClass('alert-danger').addClass('alert-info');
            }
        });

        // Function to update the exam learner select options based on class learners
        function updateExamLearnerOptions() {
            // Get the current class learners
            const classLearnersData = JSON.parse($('#class_learners_data').val() || '[]');

            // Clear the current options
            $examLearnerSelect.empty();

            // Add options for each class learner
            classLearnersData.forEach(function(learner) {
                // Skip learners that are already in the exam learners list
                if (!examLearners.some(el => el.id === learner.id)) {
                    $examLearnerSelect.append(`<option value="${learner.id}">${learner.name}</option>`);
                }
            });
        }

        // Function to add an exam learner to the table
        function addExamLearnerToTable(learnerId, learnerName) {
            // Check if learner already exists in the table
            if (examLearners.some(learner => learner.id === learnerId)) {
                return false; // Learner already exists
            }

            // Add learner to the array
            examLearners.push({
                id: learnerId,
                name: learnerName,
                takes_exam: true
            });

            // Create table row
            const $row = $(`
                <tr data-learner-id="${learnerId}">
                    <td>${learnerName}</td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-exam-learner-btn" data-learner-id="${learnerId}">
                            Remove
                        </button>
                    </td>
                </tr>
            `);

            // Add row to table
            $examLearnersTbody.append($row);

            // Show table if it was hidden
            if (examLearners.length > 0) {
                $examLearnersTable.removeClass('d-none');
                $noExamLearnersMessage.addClass('d-none');
            }

            // Update hidden field with JSON data
            updateExamLearnersData();

            return true;
        }

        // Function to remove an exam learner from the table
        function removeExamLearnerFromTable(learnerId) {
            // Remove from array
            examLearners = examLearners.filter(learner => learner.id !== learnerId);

            // Remove row from table
            $(`tr[data-learner-id="${learnerId}"]`).remove();

            // Show message if no learners left
            if (examLearners.length === 0) {
                $examLearnersTable.addClass('d-none');
                $noExamLearnersMessage.removeClass('d-none');
            }

            // Update hidden field with JSON data
            updateExamLearnersData();

            // Add the learner back to the select options
            const classLearnersData = JSON.parse($('#class_learners_data').val() || '[]');
            const learner = classLearnersData.find(l => l.id === learnerId);
            if (learner) {
                $examLearnerSelect.append(`<option value="${learner.id}">${learner.name}</option>`);
            }
        }

        // Function to update the hidden field with exam learner data
        function updateExamLearnersData() {
            // Log for debugging
            console.log('Updating exam learners data:', examLearners);

            // Stringify the exam learners array and store in hidden field
            const jsonData = JSON.stringify(examLearners);
            $examLearnersData.val(jsonData);

            // Log the JSON data for debugging
            console.log('Exam learners JSON:', jsonData);

            // Update the exam learner count hidden input if it exists
            if ($('#exam_learner_count').length) {
                $('#exam_learner_count').val(examLearners.length);
                console.log('Updated existing exam learner count:', examLearners.length);
            } else {
                // Create a hidden input for exam learner count if it doesn't exist
                $('<input>').attr({
                    type: 'hidden',
                    id: 'exam_learner_count',
                    name: 'exam_learner_count',
                    value: examLearners.length
                }).appendTo('#classes-form');
                console.log('Created new exam learner count field:', examLearners.length);
            }

            // Immediately validate the exam learner section if exam class is Yes
            if ($('#exam_class').val() === 'Yes' && typeof validateExamLearners === 'function') {
                validateExamLearners();
            }
        }

        // Event handler for adding selected exam learners
        $addSelectedExamLearnersBtn.on('click', function() {
            const selectedOptions = $examLearnerSelect.find('option:selected');

            if (selectedOptions.length === 0) {
                alert('Please select at least one learner to add for exams.');
                return;
            }

            let addedCount = 0;

            selectedOptions.each(function() {
                const learnerId = $(this).val();
                const learnerName = $(this).text();

                if (addExamLearnerToTable(learnerId, learnerName)) {
                    addedCount++;
                    // Remove from select options
                    $(this).remove();
                }
            });

            // Clear selection
            $examLearnerSelect.val([]);

            if (addedCount === 0) {
                alert('No new exam learners added. All selected learners are already taking exams.');
            }
        });

        // Event delegation for remove buttons
        $examLearnersTbody.on('click', '.remove-exam-learner-btn', function() {
            const learnerId = $(this).data('learner-id');
            removeExamLearnerFromTable(learnerId);
        });

        // Listen for changes to the class learners data
        $(document).on('classLearnersUpdated', function() {
            if ($('#exam_class').val() === 'Yes') {
                updateExamLearnerOptions();
            }
        });

        // Function to validate exam learners
        window.validateExamLearners = function() {
            console.log('Validating exam learners...');

            // Only validate if exam class is Yes
            if ($('#exam_class').val() !== 'Yes') {
                console.log('Exam class is not Yes, skipping validation');
                return true;
            }

            const examLearnersData = $('#exam_learners').val();
            const examLearnerCount = parseInt($('#exam_learner_count').val() || '0');
            const $examLearnersContainer = $('#exam_learners_container');
            const $noExamLearnersMessage = $('#no-exam-learners-message');

            console.log('Exam learners data:', examLearnersData);
            console.log('Exam learner count:', examLearnerCount);

            let examLearnersValid = true;

            if ((!examLearnersData || examLearnersData === '[]') && examLearnerCount === 0) {
                examLearnersValid = false;
                // Add validation styling
                $examLearnersContainer.addClass('border-danger');
                $noExamLearnersMessage.removeClass('alert-info').addClass('alert-danger');
                console.log('Exam learners validation failed');
            } else {
                // Remove validation styling
                $examLearnersContainer.removeClass('border-danger');
                $noExamLearnersMessage.removeClass('alert-danger').addClass('alert-info');
                console.log('Exam learners validation passed');
            }

            return examLearnersValid;
        };
    }

    /**
     * Initialize the date history functionality
     */
    function initializeDateHistory() {
        // References to the date history template & container
        const $dateHistoryTemplate = $('#date-history-row-template');
        const $dateHistoryContainer = $('#date-history-container');

        // Function to validate date pairs
        function validateDatePair($row) {
            const $stopDate = $row.find('input[name="stop_dates[]"]');
            const $restartDate = $row.find('input[name="restart_dates[]"]');

            const stopDateValue = $stopDate.val();
            const restartDateValue = $restartDate.val();

            // Skip validation if either field is empty
            if (!stopDateValue || !restartDateValue) {
                return true;
            }

            // Convert to Date objects for comparison
            const stopDate = new Date(stopDateValue);
            const restartDate = new Date(restartDateValue);

            // Check if restart date is after stop date
            const isValid = restartDate > stopDate;

            // Update validation classes
            if (isValid) {
                $restartDate.removeClass('is-invalid').addClass('is-valid');
                $stopDate.removeClass('is-invalid').addClass('is-valid');
                $restartDate.siblings('.invalid-feedback').text('Please select a valid date.');
            } else {
                $restartDate.removeClass('is-valid').addClass('is-invalid');
                $restartDate.siblings('.invalid-feedback').text('Restart date must be after stop date.');
                $stopDate.removeClass('is-invalid').addClass('is-valid');
            }

            return isValid;
        }

        // Function to add a new date history row
        function addDateHistoryRow() {
            // Clone the template
            let $newRow = $dateHistoryTemplate.clone(true);

            // Make it visible & remove the template ID
            $newRow.removeClass('d-none').removeAttr('id');

            // Clear any existing values
            $newRow.find('input[name="stop_dates[]"]').val('');
            $newRow.find('input[name="restart_dates[]"]').val('');

            // Attach remove-row handler
            $newRow.find('.remove-date-row-btn').on('click', function() {
                $(this).closest('.date-history-row').remove();
            });

            // Attach date validation handlers
            $newRow.find('input[name="stop_dates[]"], input[name="restart_dates[]"]').on('change', function() {
                validateDatePair($(this).closest('.date-history-row'));
            });

            // Append the new row to the container
            $dateHistoryContainer.append($newRow);
        }

        // Click handler to add new date history rows
        $('#add-date-history-btn').on('click', function() {
            addDateHistoryRow();
        });

        // Function to validate all date pairs
        window.validateAllDatePairs = function() {
            let allValid = true;
            $('.date-history-row:not(#date-history-row-template)').each(function() {
                if (!validateDatePair($(this))) {
                    allValid = false;
                }
            });
            return allValid;
        };
    }

    /**
     * Initialize the class learners functionality
     */
    function initializeClassLearners() {
        // References to DOM elements
        const $addLearnerSelect = $('#add_learner');
        const $addSelectedLearnersBtn = $('#add-selected-learners-btn');
        const $classLearnersTable = $('#class-learners-table');
        const $classLearnersTbody = $('#class-learners-tbody');
        const $noLearnersMessage = $('#no-learners-message');
        const $classLearnersData = $('#class_learners_data');

        // Array to store learner data
        let classLearners = [];

        // Status options for learners
        const learnerStatusOptions = [
            'Host Company Learner',
            'Walk-in Learner',
            'Transferred'
        ];

        // Function to generate status dropdown
        function generateStatusDropdown(learnerId, currentStatus = 'Host Company Learner') {
            let html = `<select class="form-select form-select-sm learner-status" data-learner-id="${learnerId}">`;

            learnerStatusOptions.forEach(status => {
                const selected = status === currentStatus ? 'selected' : '';
                html += `<option value="${status}" ${selected}>${status}</option>`;
            });

            html += '</select>';
            return html;
        }

        // Function to add a learner to the table
        function addLearnerToTable(learnerId, learnerName, status = 'Active') {
            // Check if learner already exists in the table
            if (classLearners.some(learner => learner.id === learnerId)) {
                return false; // Learner already exists
            }

            // Add learner to the array
            classLearners.push({
                id: learnerId,
                name: learnerName,
                status: status
            });

            // Create table row
            const $row = $(`
                <tr data-learner-id="${learnerId}">
                    <td>${learnerName}</td>
                    <td>${generateStatusDropdown(learnerId, status)}</td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-learner-btn" data-learner-id="${learnerId}">
                            Remove
                        </button>
                    </td>
                </tr>
            `);

            // Add row to table
            $classLearnersTbody.append($row);

            // Show table if it was hidden
            if (classLearners.length > 0) {
                $classLearnersTable.removeClass('d-none');
                $noLearnersMessage.addClass('d-none');
            }

            // Update hidden field with JSON data
            updateClassLearnersData();

            return true;
        }

        // Function to remove a learner from the table
        function removeLearnerFromTable(learnerId) {
            // Remove from array
            classLearners = classLearners.filter(learner => learner.id !== learnerId);

            // Remove row from table
            $(`tr[data-learner-id="${learnerId}"]`).remove();

            // Show message if no learners left
            if (classLearners.length === 0) {
                $classLearnersTable.addClass('d-none');
                $noLearnersMessage.removeClass('d-none');
            }

            // Update hidden field with JSON data
            updateClassLearnersData();
        }

        // Function to update the hidden field with learner data
        function updateClassLearnersData() {
            // Log for debugging
            console.log('Updating class learners data:', classLearners);

            // Stringify the learners array and store in hidden field
            const jsonData = JSON.stringify(classLearners);
            $classLearnersData.val(jsonData);

            // Log the JSON data for debugging
            console.log('Class learners JSON:', jsonData);

            // Update the learner count hidden input if it exists
            if ($('#learner_count').length) {
                $('#learner_count').val(classLearners.length);
                console.log('Updated existing learner count:', classLearners.length);
            } else {
                // Create a hidden input for learner count if it doesn't exist
                $('<input>').attr({
                    type: 'hidden',
                    id: 'learner_count',
                    name: 'learner_count',
                    value: classLearners.length
                }).appendTo('#classes-form');
                console.log('Created new learner count field:', classLearners.length);
            }

            // Immediately validate the learner section
            validateClassLearners();

            // Trigger an event to notify other components that class learners have been updated
            $(document).trigger('classLearnersUpdated');
        }

        // Event handler for adding selected learners
        $addSelectedLearnersBtn.on('click', function() {
            // Get all selected options
            const selectedOptions = $addLearnerSelect.find('option:selected');
            console.log('Selected options:', selectedOptions.length);

            // Check if any learners are selected
            if (selectedOptions.length === 0) {
                // Show a custom modal dialog instead of an alert
                showCustomAlert('Please select at least one learner to add.');
                return;
            }

            let addedCount = 0;
            let alreadyAddedLearners = [];

            // Process each selected learner
            selectedOptions.each(function() {
                const learnerId = $(this).val();
                const learnerName = $(this).text();

                // Try to add the learner to the table
                if (addLearnerToTable(learnerId, learnerName)) {
                    addedCount++;
                } else {
                    // Keep track of learners that were already added
                    alreadyAddedLearners.push(learnerName);
                }
            });

            // Clear the selection
            $addLearnerSelect.val([]);

            // Show appropriate message based on results
            if (addedCount === 0 && alreadyAddedLearners.length > 0) {
                showCustomAlert('No new learners added. All selected learners are already in the class.');
            } else if (addedCount > 0 && alreadyAddedLearners.length > 0) {
                // Some learners were added, some were already in the class
                const message = `Added ${addedCount} learner(s). ${alreadyAddedLearners.length} learner(s) were already in the class.`;
                // No need to show an alert for partial success
                console.log(message);
            }
            // No alert needed for complete success
        });

        // Event delegation for remove buttons
        $classLearnersTbody.on('click', '.remove-learner-btn', function() {
            const learnerId = $(this).data('learner-id');
            removeLearnerFromTable(learnerId);
        });

        // Event delegation for status changes
        $classLearnersTbody.on('change', '.learner-status', function() {
            const learnerId = $(this).data('learner-id');
            const newStatus = $(this).val();

            // Update status in the array
            const learner = classLearners.find(l => l.id === learnerId);
            if (learner) {
                learner.status = newStatus;
                updateClassLearnersData();
            }
        });

        // Function to validate class learners
        window.validateClassLearners = function() {
            console.log('Validating class learners...');

            const classLearnersData = $('#class_learners_data').val();
            const learnerCount = parseInt($('#learner_count').val() || '0');
            const $classLearnersContainer = $('#class-learners-container');
            const $noLearnersMessage = $('#no-learners-message');

            console.log('Class learners data:', classLearnersData);
            console.log('Learner count:', learnerCount);

            let classLearnersValid = true;

            if ((!classLearnersData || classLearnersData === '[]') && learnerCount === 0) {
                classLearnersValid = false;
                // Add validation styling
                $classLearnersContainer.addClass('border-danger');
                $noLearnersMessage.removeClass('alert-info').addClass('alert-danger');
                console.log('Class learners validation failed');
            } else {
                // Remove validation styling
                $classLearnersContainer.removeClass('border-danger');
                $noLearnersMessage.removeClass('alert-danger').addClass('alert-info');
                console.log('Class learners validation passed');
            }

            return classLearnersValid;
        };
    }

    /**
     * Initialize the QA visit dates functionality
     */
    function initializeQAVisits() {
        // References to the QA visit template & container
        const $qaVisitTemplate = $('#qa-visit-row-template');
        const $qaVisitsContainer = $('#qa-visits-container');

        // Function to validate QA visit date and report
        function validateQAVisit($row) {
            const $visitDate = $row.find('input[name="qa_visit_dates[]"]');
            const $reportFile = $row.find('input[name="qa_reports[]"]');

            const visitDateValue = $visitDate.val();
            const reportFileValue = $reportFile.val();

            let isValid = true;

            // Validate date
            if (!visitDateValue) {
                $visitDate.addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            } else {
                $visitDate.addClass('is-valid').removeClass('is-invalid');
            }

            // Validate report file
            if (!reportFileValue) {
                $reportFile.addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            } else {
                $reportFile.addClass('is-valid').removeClass('is-invalid');
            }

            return isValid;
        }

        // Function to add a new QA visit row
        function addQAVisitRow() {
            // Clone the template
            let $newRow = $qaVisitTemplate.clone(true);

            // Make it visible & remove the template ID
            $newRow.removeClass('d-none').removeAttr('id');

            // Clear any existing values
            $newRow.find('input[name="qa_visit_dates[]"]').val('');
            $newRow.find('input[name="qa_reports[]"]').val('');

            // Attach remove-row handler
            $newRow.find('.remove-qa-visit-btn').on('click', function() {
                $(this).closest('.qa-visit-row').remove();
            });

            // Attach validation handlers
            $newRow.find('input[name="qa_visit_dates[]"], input[name="qa_reports[]"]').on('change', function() {
                validateQAVisit($(this).closest('.qa-visit-row'));
            });

            // Append the new row to the container
            $qaVisitsContainer.append($newRow);
        }

        // Click handler to add new QA visit rows
        $('#add-qa-visit-btn').on('click', function() {
            addQAVisitRow();
        });

        // Function to validate all QA visits
        window.validateAllQAVisits = function() {
            let allValid = true;
            $('.qa-visit-row:not(#qa-visit-row-template)').each(function() {
                if (!validateQAVisit($(this))) {
                    allValid = false;
                }
            });
            return allValid;
        };

        // Add an initial row if container is empty
        if ($qaVisitsContainer.children().length === 0) {
            addQAVisitRow();
        }
    }

    /**
     * Initialize the backup agents functionality
     */
    function initializeBackupAgents() {
        // References to DOM elements
        const $backupAgentTemplate = $('#backup-agent-row-template');
        const $backupAgentsContainer = $('#backup-agents-container');

        // Function to validate backup agent
        function validateBackupAgent($row) {
            const $backupAgent = $row.find('select[name="backup_agent_ids[]"]');
            const $backupDate = $row.find('input[name="backup_agent_dates[]"]');

            const backupAgentValue = $backupAgent.val();
            const backupDateValue = $backupDate.val();

            let isValid = true;

            // Validate agent selection
            if (!backupAgentValue) {
                $backupAgent.addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            } else {
                $backupAgent.addClass('is-valid').removeClass('is-invalid');
            }

            // Validate date
            if (!backupDateValue) {
                $backupDate.addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            } else {
                $backupDate.addClass('is-valid').removeClass('is-invalid');
            }

            return isValid;
        }

        // Function to add a new backup agent row
        function addBackupAgentRow() {
            // Clone the template
            let $newRow = $backupAgentTemplate.clone(true);

            // Make it visible & remove the template ID
            $newRow.removeClass('d-none').removeAttr('id');

            // Clear any existing values
            $newRow.find('select[name="backup_agent_ids[]"]').val('');
            $newRow.find('input[name="backup_agent_dates[]"]').val('');

            // Attach remove-row handler
            $newRow.find('.remove-backup-agent-btn').on('click', function() {
                $(this).closest('.backup-agent-row').remove();
            });

            // Attach validation handlers
            $newRow.find('select[name="backup_agent_ids[]"], input[name="backup_agent_dates[]"]').on('change', function() {
                validateBackupAgent($(this).closest('.backup-agent-row'));
            });

            // Append the new row to the container
            $backupAgentsContainer.append($newRow);
        }

        // Click handler to add new backup agent rows
        $('#add-backup-agent-btn').on('click', function() {
            addBackupAgentRow();
        });

        // Function to validate all backup agents
        window.validateAllBackupAgents = function() {
            let allValid = true;
            $('.backup-agent-row:not(#backup-agent-row-template)').each(function() {
                if (!validateBackupAgent($(this))) {
                    allValid = false;
                }
            });
            return allValid;
        };

        // Add an initial row if container is empty
        if ($backupAgentsContainer.children().length === 0) {
            addBackupAgentRow();
        }
    }

    /**
     * Initialize the agent replacements functionality
     */
    function initializeAgentReplacements() {
        // References to DOM elements
        const $agentReplacementTemplate = $('#agent-replacement-row-template');
        const $agentReplacementsContainer = $('#agent-replacements-container');

        // Function to validate takeover date
        function validateTakeoverDate($row) {
            const $takeoverDate = $row.find('input[name="replacement_agent_dates[]"]');
            const initialStartDate = $('#initial_agent_start_date').val();

            const takeoverDateValue = $takeoverDate.val();

            // Skip validation if either field is empty
            if (!takeoverDateValue || !initialStartDate) {
                return true;
            }

            // Convert to Date objects for comparison
            const takeoverDate = new Date(takeoverDateValue);
            const startDate = new Date(initialStartDate);

            // Check if takeover date is after initial start date
            const isValid = takeoverDate > startDate;

            // Update validation classes
            if (isValid) {
                $takeoverDate.removeClass('is-invalid').addClass('is-valid');
                $takeoverDate.siblings('.invalid-feedback').text('Please select a valid takeover date.');
            } else {
                $takeoverDate.removeClass('is-valid').addClass('is-invalid');
                $takeoverDate.siblings('.invalid-feedback').text('Takeover date must be after the initial agent start date.');
            }

            return isValid;
        }

        // Function to add a new agent replacement row
        function addAgentReplacementRow() {
            // Clone the template
            let $newRow = $agentReplacementTemplate.clone(true);

            // Make it visible & remove the template ID
            $newRow.removeClass('d-none').removeAttr('id');

            // Clear any existing values
            $newRow.find('select[name="replacement_agent_ids[]"]').val('');
            $newRow.find('input[name="replacement_agent_dates[]"]').val('');

            // Attach remove-row handler
            $newRow.find('.remove-agent-replacement-btn').on('click', function() {
                $(this).closest('.agent-replacement-row').remove();
            });

            // Attach date validation handlers
            $newRow.find('input[name="replacement_agent_dates[]"]').on('change', function() {
                validateTakeoverDate($(this).closest('.agent-replacement-row'));
            });

            // Append the new row to the container
            $agentReplacementsContainer.append($newRow);
        }

        // Click handler to add new agent replacement rows
        $('#add-agent-replacement-btn').on('click', function() {
            addAgentReplacementRow();
        });

        // Event handler for initial agent start date changes
        $('#initial_agent_start_date').on('change', function() {
            // Validate all takeover dates when initial date changes
            $('.agent-replacement-row:not(#agent-replacement-row-template)').each(function() {
                validateTakeoverDate($(this));
            });
        });

        // Function to validate all takeover dates
        window.validateAllTakeoverDates = function() {
            let allValid = true;
            $('.agent-replacement-row:not(#agent-replacement-row-template)').each(function() {
                if (!validateTakeoverDate($(this))) {
                    allValid = false;
                }
            });
            return allValid;
        };
    }

    /**
     * Check for class schedule conflicts
     */
    function checkClassConflicts(callback) {
        // Skip if conflict checking is disabled
        if (!wecozaClass.conflictCheckEnabled) {
            if (typeof callback === 'function') {
                callback(null);
            }
            return;
        }

        // Get schedule data from calendar
        const events = calendar ? calendar.getEvents() : [];
        if (!events.length) {
            if (typeof callback === 'function') {
                callback(null);
            }
            return;
        }

        // Format schedule data for the server
        const scheduleData = events.map(function(event) {
            if (!event.start || !event.end) {
                return null;
            }

            return {
                date: formatDate(event.start),
                start_time: formatTime(event.start),
                end_time: formatTime(event.end),
                type: event.extendedProps && event.extendedProps.type ? event.extendedProps.type : 'class'
            };
        }).filter(Boolean); // Remove null entries

        // Get class ID if editing an existing class
        const classId = $('#class_id').val() !== 'auto-generated' ? $('#class_id').val() : null;

        // Get agent ID
        const agentId = $('#class_agent').val();

        // Get learner IDs
        const classLearnersData = $('#class_learners_data').val();
        const learnerIds = classLearnersData ? JSON.parse(classLearnersData).map(learner => learner.id) : [];

        // Send AJAX request to check for conflicts
        $.ajax({
            url: wecozaClass.ajaxUrl,
            type: 'POST',
            data: {
                action: 'check_class_conflicts',
                nonce: wecozaClass.nonce,
                schedule_data: JSON.stringify(scheduleData),
                class_id: classId,
                agent_id: agentId,
                learner_ids: JSON.stringify(learnerIds)
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.conflicts) {
                        // Process conflicts
                        if (typeof callback === 'function') {
                            callback(response.data.conflicts);
                        }
                    } else {
                        // No conflicts
                        if (typeof callback === 'function') {
                            callback(null);
                        }
                    }
                } else {
                    console.error('Error checking conflicts:', response.data.message);
                    if (typeof callback === 'function') {
                        callback(null);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error checking conflicts:', error);
                if (typeof callback === 'function') {
                    callback(null);
                }
            }
        });
    }

    /**
     * Display conflict warnings to the user
     */
    function displayConflictWarnings(conflicts) {
        if (!conflicts) {
            return;
        }

        let warningHtml = '<div class="alert alert-warning"><strong>Potential Schedule Conflicts Detected:</strong><ul>';

        // Process agent conflicts
        if (conflicts.agent && conflicts.agent.length > 0) {
            warningHtml += '<li><strong>Agent Conflicts:</strong><ul>';
            conflicts.agent.forEach(function(conflict) {
                warningHtml += `<li>On ${conflict.date} from ${conflict.start_time} to ${conflict.end_time}, the selected agent has ${conflict.conflicts.length} other class(es) scheduled.</li>`;
            });
            warningHtml += '</ul></li>';
        }

        // Process learner conflicts
        if (conflicts.learner && conflicts.learner.length > 0) {
            warningHtml += '<li><strong>Learner Conflicts:</strong><ul>';
            conflicts.learner.forEach(function(conflict) {
                const learnersWithConflicts = Object.keys(conflict.conflicts).length;
                warningHtml += `<li>On ${conflict.date} from ${conflict.start_time} to ${conflict.end_time}, ${learnersWithConflicts} learner(s) have other classes scheduled.</li>`;
            });
            warningHtml += '</ul></li>';
        }

        warningHtml += '</ul><p>You can still save this class, but please review the schedule to avoid conflicts.</p></div>';

        // Display the warning at the top of the form
        $('#form-messages').html(warningHtml);

        // Scroll to the warning
        $('html, body').animate({
            scrollTop: $('#form-messages').offset().top - 100
        }, 500);
    }

    /**
     * Initialize form submission
     */
    function initializeFormSubmission() {
        // Bootstrap custom validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        // Prevent default form submission
                        event.preventDefault();

                        // Reset validation state
                        resetValidationState();

                        // Update calendar data before validation
                        updateHiddenFields();

                        // Add custom validation for date pairs
                        let dateHistoryValid = true;
                        if (typeof validateAllDatePairs === 'function') {
                            dateHistoryValid = validateAllDatePairs();
                        }

                        // Add custom validation for QA visits
                        let qaVisitsValid = true;
                        if (typeof validateAllQAVisits === 'function') {
                            qaVisitsValid = validateAllQAVisits();
                        }

                        // Add custom validation for agent replacements
                        let takeoverDatesValid = true;
                        if (typeof validateAllTakeoverDates === 'function') {
                            takeoverDatesValid = validateAllTakeoverDates();
                        }

                        // Add custom validation for backup agents
                        let backupAgentsValid = true;
                        if (typeof validateAllBackupAgents === 'function') {
                            backupAgentsValid = validateAllBackupAgents();
                        }

                        // Add custom validation for class learners
                        let classLearnersValid = true;
                        if (typeof validateClassLearners === 'function') {
                            classLearnersValid = validateClassLearners();
                        }

                        // Add custom validation for exam learners if exam class is Yes
                        let examLearnersValid = true;
                        if ($('#exam_class').val() === 'Yes' && typeof validateExamLearners === 'function') {
                            examLearnersValid = validateExamLearners();
                        }

                        if (!form.checkValidity() || !dateHistoryValid || !qaVisitsValid || !takeoverDatesValid || !backupAgentsValid || !classLearnersValid || !examLearnersValid) {
                            event.stopPropagation();
                            form.classList.add('was-validated');

                            // Collect all validation errors
                            const validationErrors = [];

                            // Check for required fields that are missing
                            $(form).find(':required').each(function() {
                                if (!this.validity.valid) {
                                    const fieldName = $(this).prev('label').text().trim().replace(' *', '') || $(this).attr('name');
                                    validationErrors.push(`The ${fieldName} field is required.`);
                                }
                            });

                            // Add custom validation errors
                            if (!dateHistoryValid) {
                                validationErrors.push('Please ensure all restart dates are after their corresponding stop dates.');
                            }

                            if (!takeoverDatesValid) {
                                validationErrors.push('Please ensure all agent takeover dates are after the initial agent start date.');
                            }

                            if (!classLearnersValid) {
                                validationErrors.push('Please add at least one class learner.');
                            }

                            if (!examLearnersValid && $('#exam_class').val() === 'Yes') {
                                validationErrors.push('Please add at least one exam learner.');
                            }

                            if (!qaVisitsValid) {
                                validationErrors.push('Please ensure all QA visit dates have associated reports.');
                            }

                            if (!backupAgentsValid) {
                                validationErrors.push('Please ensure all backup agents have both an agent selected and a date.');
                            }

                            // Show error summary
                            if (validationErrors.length > 0) {
                                let errorHtml = '<div class="alert alert-danger"><strong>Please correct the following errors:</strong><ul>';
                                validationErrors.forEach(error => {
                                    errorHtml += `<li>${error}</li>`;
                                });
                                errorHtml += '</ul></div>';
                                $('#form-messages').html(errorHtml);
                            }

                            // Determine which section to scroll to
                            let scrollTarget = null;

                            // Find the first invalid field
                            const $firstInvalid = $(form).find('.is-invalid').first();
                            if ($firstInvalid.length) {
                                scrollTarget = $firstInvalid;
                            } else if (!dateHistoryValid) {
                                scrollTarget = $('#date-history-container');
                            } else if (!takeoverDatesValid) {
                                scrollTarget = $('#agent-replacements-container');
                            } else if (!classLearnersValid) {
                                scrollTarget = $('#class-learners-container');
                            } else if (!examLearnersValid && $('#exam_class').val() === 'Yes') {
                                scrollTarget = $('#exam_learners_container');
                            } else if (!backupAgentsValid) {
                                scrollTarget = $('#backup-agents-container');
                            }

                            // Scroll to the appropriate section
                            if (scrollTarget) {
                                $('html, body').animate({
                                    scrollTop: scrollTarget.offset().top - 100
                                }, 500);
                            }
                        } else {
                            // Form is valid, check for conflicts before submitting
                            checkClassConflicts(function(conflicts) {
                                if (conflicts) {
                                    // Display conflict warnings
                                    displayConflictWarnings(conflicts);

                                    // Ask user if they want to proceed
                                    if (confirm('Schedule conflicts were detected. Do you still want to save this class?')) {
                                        submitFormViaAjax(form);
                                    } else {
                                        // Reset button state if user cancels
                                        const submitBtn = $(form).find('button[type="submit"]');
                                        submitBtn.prop('disabled', false);
                                    }
                                } else {
                                    // No conflicts, proceed with submission
                                    submitFormViaAjax(form);
                                }
                            });
                        }
                    }, false)
                })
        })();

        // Function to update hidden fields
        function updateHiddenFields() {
            if (typeof calendar !== 'undefined') {
                try {
                    const events = calendar.getEvents();
                    const scheduleContainer = $('#schedule-data-container');

                    // Clear existing hidden fields
                    scheduleContainer.empty();

                    // Create hidden fields for each event
                    events.forEach(function(event) {
                        if (!event.start || !event.end) {
                            return;
                        }

                        const startDate = formatDate(event.start);
                        const day = event.extendedProps && event.extendedProps.day ?
                                   event.extendedProps.day :
                                   getDayOfWeek(event.start);
                        const startTime = formatTime(event.start);
                        const endTime = formatTime(event.end);
                        const type = event.extendedProps && event.extendedProps.type ?
                                    event.extendedProps.type :
                                    'class';

                        scheduleContainer.append(`<input type="hidden" name="schedule_day[]" value="${day}">`);
                        scheduleContainer.append(`<input type="hidden" name="schedule_date[]" value="${startDate}">`);
                        scheduleContainer.append(`<input type="hidden" name="start_time[]" value="${startTime}">`);
                        scheduleContainer.append(`<input type="hidden" name="end_time[]" value="${endTime}">`);
                        scheduleContainer.append(`<input type="hidden" name="schedule_notes[]" value="${event.title}">`);
                        scheduleContainer.append(`<input type="hidden" name="event_type[]" value="${type}">`);
                    });
                } catch (error) {
                    console.error('Error updating hidden fields:', error);
                }
            }
        }

        // Use the global formatDate function

        // Use the global getDayOfWeek function

        // Use the global formatTime function

        // Function to submit form via AJAX
        function submitFormViaAjax(form) {
            // Show loading state
            const submitBtn = $(form).find('button[type="submit"]');
            const originalBtnText = submitBtn.text();
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            // Get form data
            const formData = new FormData(form);
            formData.append('action', 'save_class');

            // Send AJAX request
            $.ajax({
                url: wecozaClass.ajaxUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        $('#form-messages').html('<div class="alert alert-success">' + response.data.message + '</div>');

                        // Redirect if URL provided
                        const redirectUrl = $('#redirect_url').val();
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    } else {
                        // Show error message
                        $('#form-messages').html('<div class="alert alert-danger">' + response.data.message + '</div>');

                        // Handle validation errors
                        if (response.data && response.data.errors) {
                            handleValidationErrors(response.data.errors);
                        }
                    }
                },
                error: function() {
                    // Show error message
                    $('#form-messages').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                },
                complete: function() {
                    // Restore button state
                    submitBtn.prop('disabled', false).text(originalBtnText);
                }
            });
        }
    }

    /**
     * Reset all validation states
     */
    function resetValidationState() {
        // Clear all validation classes
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');
        $('.invalid-feedback').hide();
        $('.valid-feedback').hide();

        // Reset form validation class
        $('#classes-form').removeClass('was-validated');

        // Reset border styling
        $('#class-learners-container').removeClass('border-danger');
        $('#exam_learners_container').removeClass('border-danger');

        // Reset alert styling
        $('#no-learners-message').removeClass('alert-danger').addClass('alert-info');
        $('#no-exam-learners-message').removeClass('alert-danger').addClass('alert-info');

        // Clear error messages
        $('#form-messages').empty();
    }

    /**
     * Handle validation errors from the server
     *
     * @param {Object} errors Validation errors
     */
    function handleValidationErrors(errors) {
        // Reset all validation states
        resetValidationState();

        // Add form validation class
        $('#classes-form').addClass('was-validated');

        // Process each field with errors
        for (const field in errors) {
            const fieldSelector = '#' + field;
            const fieldElement = $(fieldSelector);

            if (fieldElement.length) {
                // Mark the field as invalid
                fieldElement.addClass('is-invalid');

                // Find or create feedback element
                let feedbackElement = fieldElement.next('.invalid-feedback');
                if (!feedbackElement.length) {
                    feedbackElement = $('<div class="invalid-feedback"></div>');
                    fieldElement.after(feedbackElement);
                }

                // Set the error message
                feedbackElement.text(errors[field][0]).show();

                // Scroll to the first error field
                if (field === Object.keys(errors)[0]) {
                    $('html, body').animate({
                        scrollTop: fieldElement.offset().top - 100
                    }, 500);
                }
            }
        }

        // Show a summary of errors at the top
        let errorSummary = '<div class="alert alert-danger"><strong>Please correct the following errors:</strong><ul>';
        for (const field in errors) {
            errors[field].forEach(error => {
                errorSummary += '<li>' + error + '</li>';
            });
        }
        errorSummary += '</ul></div>';

        $('#form-messages').html(errorSummary);
    }

    // Initialize when document is ready
    $(document).ready(function() {
        initClassCaptureForm();
    });

})(jQuery);
