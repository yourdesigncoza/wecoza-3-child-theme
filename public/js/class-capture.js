/**
 * Class Capture JavaScript
 *
 * Handles the client-side functionality for the class capture form
 */
var calendar;
var calendarInitialized = false;

// Make the initialization function globally available
function initializeClassCalendar() {
    console.log('Manual calendar initialization triggered');
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
}

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

        // Initialize the exam type toggle
        initializeExamTypeToggle();

        // Initialize the SETA field toggle
        initializeSetaToggle();

        // Initialize the date history functionality
        initializeDateHistory();

        // Initialize the QA visit dates functionality
        initializeQAVisits();

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

        // 2. Helper function to format times in 12-hour format
        function formatTime(hour24, minute) {
            let period = (hour24 < 12) ? 'AM' : 'PM';
            let hour12 = hour24 % 12;
            hour12 = (hour12 === 0) ? 12 : hour12; // 0 => 12 AM
            let minuteStr = minute < 10 ? '0' + minute : minute;
            return hour12 + ':' + minuteStr + ' ' + period;
        }

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

        // 4. Helper function to get day of week from date
        function getDayOfWeek(date) {
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            return days[date.getDay()];
        }

        // 5. Helper function to format date as YYYY-MM-DD
        function formatDate(date) {
            const d = new Date(date);
            let month = '' + (d.getMonth() + 1);
            let day = '' + d.getDate();
            const year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

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
        // Handle exam class selection change
        document.getElementById('exam_class').addEventListener('change', function() {
            var examTypeContainer = document.getElementById('exam_type_container');
            var examLearnersContainer = document.getElementById('exam_learners_container');

            if (this.value === 'Yes') {
                // Show exam type field and make it required
                examTypeContainer.style.display = 'block';
                document.getElementById('exam_type').setAttribute('required', 'required');

                // Show exam learners container
                examLearnersContainer.style.display = 'block';

                // Update the exam learners list based on currently selected learners
                updateExamLearnersList();
            } else {
                // Hide exam type field and remove required attribute
                examTypeContainer.style.display = 'none';
                document.getElementById('exam_type').removeAttribute('required');

                // Hide exam learners container
                examLearnersContainer.style.display = 'none';
            }
        });

        // Listen for changes to the learner selection
        $('#add_learner').on('change', function() {
            // Only update if exam class is Yes
            if ($('#exam_class').val() === 'Yes') {
                updateExamLearnersList();
            }
        });

        // Function to update the exam learners list
        function updateExamLearnersList() {
            var selectedLearners = $('#add_learner').val() || [];
            var $examLearnersList = $('#exam-learners-list');
            var examLearnersData = [];

            // Clear the current list
            $examLearnersList.empty();

            // If no learners selected, show info message
            if (selectedLearners.length === 0) {
                $examLearnersList.html('<div class="alert alert-info">Please select learners in the "Add Learner" field below first. The list of selected learners will appear here.</div>');
                return;
            }

            // Create a checkbox list of selected learners
            var html = '<div class="row">';

            // Get the selected learner names and IDs
            selectedLearners.forEach(function(learnerId) {
                var learnerName = $('#add_learner option[value="' + learnerId + '"]').text();

                html += '<div class="col-md-4 mb-2">' +
                        '<div class="form-check">' +
                        '<input class="form-check-input exam-learner-checkbox" type="checkbox" id="exam_learner_' + learnerId + '" ' +
                        'data-learner-id="' + learnerId + '" checked>' +
                        '<label class="form-check-label" for="exam_learner_' + learnerId + '">' + learnerName + '</label>' +
                        '</div>' +
                        '</div>';

                // Add to the data array (all checked by default)
                examLearnersData.push({
                    id: learnerId,
                    name: learnerName,
                    takes_exam: true
                });
            });

            html += '</div>';
            $examLearnersList.html(html);

            // Update the hidden field with the JSON data
            $('#exam_learners').val(JSON.stringify(examLearnersData));

            // Add event listeners to checkboxes
            $('.exam-learner-checkbox').on('change', function() {
                var learnerId = $(this).data('learner-id');
                var isChecked = $(this).prop('checked');

                // Update the data array
                examLearnersData.forEach(function(learner) {
                    if (learner.id == learnerId) {
                        learner.takes_exam = isChecked;
                    }
                });

                // Update the hidden field
                $('#exam_learners').val(JSON.stringify(examLearnersData));
            });
        }
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

                        if (!form.checkValidity() || !dateHistoryValid || !qaVisitsValid) {
                            event.stopPropagation();
                            form.classList.add('was-validated');

                            // Show error message if date validation failed
                            if (!dateHistoryValid) {
                                $('#form-messages').html('<div class="alert alert-danger">Please ensure all restart dates are after their corresponding stop dates.</div>');
                                // Scroll to the date history section
                                $('html, body').animate({
                                    scrollTop: $('#date-history-container').offset().top - 100
                                }, 500);
                            }

                            // Show error message if QA visits validation failed
                            if (!qaVisitsValid) {
                                $('#form-messages').html('<div class="alert alert-danger">Please ensure all QA visit dates have corresponding reports uploaded.</div>');
                                // Scroll to the QA visits section
                                $('html, body').animate({
                                    scrollTop: $('#qa-visits-container').offset().top - 100
                                }, 500);
                            }
                        } else {
                            // Form is valid, submit via AJAX
                            submitFormViaAjax(form);
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

        // Helper function to format date
        function formatDate(date) {
            const d = new Date(date);
            let month = '' + (d.getMonth() + 1);
            let day = '' + d.getDate();
            const year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

        // Helper function to get day of week
        function getDayOfWeek(date) {
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            return days[date.getDay()];
        }

        // Helper function to format time
        function formatTime(date) {
            const hours = date.getHours();
            const minutes = date.getMinutes();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const hour12 = hours % 12 || 12;
            const minuteStr = minutes < 10 ? '0' + minutes : minutes;
            return `${hour12}:${minuteStr} ${ampm}`;
        }

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
     * Handle validation errors from the server
     *
     * @param {Object} errors Validation errors
     */
    function handleValidationErrors(errors) {
        // Reset all validation states
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').hide();

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
