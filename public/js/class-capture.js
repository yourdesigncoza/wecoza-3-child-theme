/**
 * Class Capture JavaScript
 *
 * Handles the client-side functionality for the class capture form
 */

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


/**
 * Show a custom alert dialog instead of using the browser's native alert
 * @param {string} message - The message to display
 */
function showCustomAlert(message) {
    // Use jQuery instead of $ in the global scope
    // Create the modal HTML if it doesn't exist
    if (jQuery('#custom-alert-modal').length === 0) {
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
        jQuery('body').append(modalHTML);
    }

    // Set the message and show the modal
    jQuery('#custom-alert-message').text(message);
    const modal = new bootstrap.Modal(document.getElementById('custom-alert-modal'));
    modal.show();
}

(function($) {
    'use strict';

    // Global variables for holiday overrides
    var holidayOverrides = {};

    // These variables are now declared globally at the top of the file
    // to make them accessible outside the IIFE

    /**
     * Initialize the class capture form
     */
    window.initClassCaptureForm = function() {
        // Initialize the client-site relationship
        initializeClientSiteRelationship();

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
     * Initialize the client-site relationship
     * Filters the site_id dropdown based on the selected client_id
     */
    function initializeClientSiteRelationship() {
        // Get the client and site dropdowns
        const $clientDropdown = $("#client_id");
        const $siteDropdown = $("#site_id");

        // Add event listener to client dropdown
        $clientDropdown.on("change", function() {
            const selectedClientId = $(this).val();
            const selectedClientName = $(this).find("option:selected").text();

            // Reset site selection
            $siteDropdown.val("");

            // Show all optgroups and options initially
            $siteDropdown.find("optgroup").show();
            $siteDropdown.find("option").prop("disabled", false);

            // If a client is selected, hide other optgroups and disable their options
            if (selectedClientId) {
                $siteDropdown.find("optgroup").each(function() {
                    if ($(this).attr("label") !== selectedClientName) {
                        $(this).hide();
                        $(this).find("option").prop("disabled", true);
                    }
                });
            }

            // Trigger change event on site dropdown to update any dependent fields
            $siteDropdown.trigger("change");
        });

        // Initial filtering on page load if a client is already selected
        if ($clientDropdown.val()) {
            $clientDropdown.trigger("change");
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
        const setaFundedElement = document.getElementById('seta_funded');
        if (setaFundedElement) {
            setaFundedElement.addEventListener('change', function() {
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
        }

        // Check initial state on page load
        var setaFunded = document.getElementById('seta_funded');
        if (setaFunded && setaFunded.value === 'Yes') {
            var setaContainer = document.getElementById('seta_container');
            var setaSelect = document.getElementById('seta_id');
            if (setaContainer && setaSelect) {
                setaContainer.style.display = 'block';
                setaSelect.setAttribute('required', 'required');
            }
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
        const examClassElement = document.getElementById('exam_class');
        if (examClassElement) {
            examClassElement.addEventListener('change', function() {
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
        }

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
            console.log('Adding exam learner to table:', learnerName, 'with ID:', learnerId);
            console.log('Current exam learners:', examLearners);

            // Check if learner already exists in the table
            if (examLearners.some(learner => learner.id === learnerId)) {
                console.log('Learner already exists in exam learners list');
                return false; // Learner already exists
            }

            // Add learner to the array
            examLearners.push({
                id: learnerId,
                name: learnerName,
                takes_exam: true
            });

            console.log('Updated exam learners array:', examLearners);

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
            console.log('Added row to table, row count now:', $examLearnersTbody.find('tr').length);

            // Show table if it was hidden
            if (examLearners.length > 0) {
                $examLearnersTable.removeClass('d-none');
                $noExamLearnersMessage.addClass('d-none');
                console.log('Showing exam learners table, hiding no-learners message');
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
            console.log('Hidden field value after update:', $examLearnersData.val());

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

            // Check if the table is visible and has rows
            const tableRowCount = $examLearnersTbody.find('tr').length;
            if (tableRowCount > 0 && $examLearnersTable.hasClass('d-none')) {
                // Table should be visible but is hidden - fix it
                $examLearnersTable.removeClass('d-none');
                $noExamLearnersMessage.addClass('d-none');
                console.log('Fixed table visibility - table was hidden but has rows');
            } else if (tableRowCount === 0 && !$examLearnersTable.hasClass('d-none')) {
                // Table should be hidden but is visible - fix it
                $examLearnersTable.addClass('d-none');
                $noExamLearnersMessage.removeClass('d-none');
                console.log('Fixed table visibility - table was visible but has no rows');
            }

            // Immediately validate the exam learner section if exam class is Yes
            if ($('#exam_class').val() === 'Yes' && typeof validateExamLearners === 'function') {
                validateExamLearners();
            }
        }

        // Event handler for adding selected exam learners
        $addSelectedExamLearnersBtn.on('click', function() {
            // Get all selected options
            const selectedOptions = $examLearnerSelect.find('option:selected');

            // Debug log to check selection state
            console.log('Selected exam learners:', selectedOptions.length);
            console.log('Available options:', $examLearnerSelect.find('option').length);

            // Check if any learners are selected
            // if (selectedOptions.length === 0) {
            //     // Use custom alert instead of native alert for consistency
            //     showCustomAlert('Please select at least one learner to add for exams.');
            //     return;
            // }

            let addedCount = 0;
            let alreadyAddedLearners = [];

            // Process each selected learner
            selectedOptions.each(function() {
                const learnerId = $(this).val();
                const learnerName = $(this).text();

                console.log('Processing learner:', learnerName, 'with ID:', learnerId);

                // Try to add the learner to the table
                if (addExamLearnerToTable(learnerId, learnerName)) {
                    addedCount++;
                    // Remove from select options
                    $(this).remove();
                } else {
                    // Keep track of learners that were already added
                    alreadyAddedLearners.push(learnerName);
                }
            });

            // Clear selection
            $examLearnerSelect.val([]);

            // Show appropriate message based on results
            if (addedCount === 0 && alreadyAddedLearners.length > 0) {
                showCustomAlert('No new exam learners added. All selected learners are already taking exams.');
            } else if (addedCount > 0 && alreadyAddedLearners.length > 0) {
                // Some learners were added, some were already in the class
                const message = `Added ${addedCount} learner(s). ${alreadyAddedLearners.length} learner(s) were already taking exams.`;
                // No need to show an alert for partial success
                console.log(message);
            }
            // No alert needed for complete success
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
            const $examLearnersTable = $('#exam-learners-table');
            const $examLearnersTbody = $('#exam-learners-tbody');

            console.log('Exam learners data:', examLearnersData);
            console.log('Exam learner count:', examLearnerCount);
            console.log('Exam learners table rows:', $examLearnersTbody.find('tr').length);

            // Check if we have actual rows in the table
            const tableRowCount = $examLearnersTbody.find('tr').length;

            let examLearnersValid = true;

            // Check if we have any exam learners added
            if (tableRowCount > 0) {
                // We have rows in the table, so validation should pass
                examLearnersValid = true;
                // Remove validation styling
                $examLearnersContainer.removeClass('border-danger');
                $noExamLearnersMessage.removeClass('alert-danger').addClass('alert-info');
                console.log('Exam learners validation passed - table has rows');
            } else if ((!examLearnersData || examLearnersData === '[]') && examLearnerCount === 0) {
                // No data in any form, validation fails
                examLearnersValid = false;
                // Add validation styling
                $examLearnersContainer.addClass('border-danger');
                $noExamLearnersMessage.removeClass('alert-info').addClass('alert-danger');
                console.log('Exam learners validation failed - no data');
            } else {
                // We have data but no visible rows - check if the data is valid
                try {
                    const parsedData = JSON.parse(examLearnersData || '[]');
                    if (parsedData.length > 0) {
                        examLearnersValid = true;
                        // Remove validation styling
                        $examLearnersContainer.removeClass('border-danger');
                        $noExamLearnersMessage.removeClass('alert-danger').addClass('alert-info');
                        console.log('Exam learners validation passed - data exists');
                    } else {
                        examLearnersValid = false;
                        // Add validation styling
                        $examLearnersContainer.addClass('border-danger');
                        $noExamLearnersMessage.removeClass('alert-info').addClass('alert-danger');
                        console.log('Exam learners validation failed - empty data array');
                    }
                } catch (e) {
                    console.error('Error parsing exam learners data:', e);
                    examLearnersValid = false;
                    // Add validation styling
                    $examLearnersContainer.addClass('border-danger');
                    $noExamLearnersMessage.removeClass('alert-info').addClass('alert-danger');
                    console.log('Exam learners validation failed - invalid data format');
                }
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

        // Get class subjects for level assignment
        let classSubjects = [];

        // Function to update class subjects when class type changes
        function updateClassSubjects() {
            const classType = $('#class_type').val();
            const classSubject = $('#class_subject').val();

            if (classType && classSubject) {
                // Get subjects for the selected class type from the ClassTypesController
                $.ajax({
                    url: wecozaClass.ajaxUrl,
                    type: 'GET',
                    data: {
                        action: 'get_class_subjects',
                        class_type: classType
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            classSubjects = response.data;
                            // Update existing learner level dropdowns
                            updateLearnerLevelDropdowns();
                        }
                    },
                    error: function() {
                        console.error('Failed to fetch class subjects');
                    }
                });
            }
        }

        // Listen for class type and subject changes
        $('#class_type, #class_subject').on('change', updateClassSubjects);

        // Function to update all learner level dropdowns
        function updateLearnerLevelDropdowns() {
            $('.learner-level').each(function() {
                const learnerId = $(this).data('learner-id');
                const currentLevel = $(this).val();

                // Rebuild the dropdown with updated subjects
                $(this).html(generateLevelOptions(currentLevel));
            });
        }

        // Function to generate level options dropdown
        function generateLevelOptions(currentLevel = '') {
            let html = '<option value="">Select Level</option>';

            if (classSubjects.length > 0) {
                classSubjects.forEach(subject => {
                    const selected = subject.id === currentLevel ? 'selected' : '';
                    html += `<option value="${subject.id}" ${selected}>${subject.name}</option>`;
                });
            }

            return html;
        }

        // Function to generate level dropdown
        function generateLevelDropdown(learnerId, currentLevel = '') {
            let html = `<select class="form-select form-select-sm learner-level" data-learner-id="${learnerId}">`;
            html += generateLevelOptions(currentLevel);
            html += '</select>';
            return html;
        }

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
        function addLearnerToTable(learnerId, learnerName, status = 'Host Company Learner', level = '') {
            console.log('Adding learner to table:', learnerName, 'with ID:', learnerId);
            console.log('Current class learners:', classLearners);

            // Check if learner already exists in the table
            if (classLearners.some(learner => learner.id === learnerId)) {
                console.log('Learner already exists in class learners list');
                return false; // Learner already exists
            }

            // Add learner to the array
            classLearners.push({
                id: learnerId,
                name: learnerName,
                status: status,
                level: level
            });

            // Create table row
            const $row = $(`
                <tr data-learner-id="${learnerId}">
                    <td>${learnerName}</td>
                    <td>${generateLevelDropdown(learnerId, level)}</td>
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
            // Get all selected options - try multiple approaches to ensure we get the selection
            let selectedOptions = $addLearnerSelect.find('option:selected');
            console.log('Selected options (jQuery):', selectedOptions.length);

            // If jQuery method didn't work, try direct DOM approach
            if (selectedOptions.length === 0) {
                const selectElement = document.getElementById('add_learner');
                if (selectElement) {
                    // Try using selectedOptions property
                    const domSelectedOptions = Array.from(selectElement.selectedOptions || []);
                    console.log('Selected options (DOM selectedOptions):', domSelectedOptions.length);

                    // If DOM approach found selections, convert to jQuery collection
                    if (domSelectedOptions.length > 0) {
                        selectedOptions = $(domSelectedOptions);
                    } else {
                        // Try getting the value directly (for multi-select this returns an array)
                        const selectValues = $(selectElement).val();
                        console.log('Selected options (direct value):', selectValues ? selectValues.length : 0);

                        if (selectValues && selectValues.length > 0) {
                            // Create a new jQuery collection from the selected options
                            selectedOptions = $();
                            selectValues.forEach(function(value) {
                                selectedOptions = selectedOptions.add($addLearnerSelect.find('option[value="' + value + '"]'));
                            });
                        }
                    }
                }
            }

            // Log selected values for debugging
            console.log('Selected options values:', selectedOptions.map(function() { return $(this).val(); }).get());

            // Check if any learners are selected
            // if (selectedOptions.length === 0) {
            //     // Check if we already have learners in the table
            //     if (classLearners.length > 0) {
            //         console.log('No new learners selected, but we already have learners in the table:', classLearners.length);
            //         return; // Skip showing alert if we already have learners
            //     }

            //     // Show a custom modal dialog instead of an alert
            //     showCustomAlert('Please select at least one learner to add.');
            //     return;
            // }

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

        // Event delegation for level changes
        $classLearnersTbody.on('change', '.learner-level', function() {
            const learnerId = $(this).data('learner-id');
            const newLevel = $(this).val();

            // Update level in the array
            const learner = classLearners.find(l => l.id === learnerId);
            if (learner) {
                learner.level = newLevel;
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
     * Get schedule data from form fields (replaces calendar-based approach)
     */
    function getScheduleDataFromForm() {
        const scheduleData = [];

        // Get basic schedule information
        const pattern = $('#schedule_pattern').val();
        const startDate = $('#schedule_start_date').val();
        const endDate = $('#schedule_end_date').val();
        const startTime = $('#schedule_start_time').val();
        const endTime = $('#schedule_end_time').val();

        // If we don't have the basic required fields, return empty array
        if (!pattern || !startDate || !startTime || !endTime) {
            return [];
        }

        // For now, create a simple schedule entry
        // This is a simplified approach - you might want to expand this
        // to generate actual dates based on the pattern and selected days
        scheduleData.push({
            date: startDate,
            start_time: startTime,
            end_time: endTime,
            type: 'class'
        });

        return scheduleData;
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

        // Get schedule data from form fields instead of calendar
        const scheduleData = getScheduleDataFromForm();

        // If no schedule data, skip conflict checking
        if (!scheduleData || scheduleData.length === 0) {
            if (typeof callback === 'function') {
                callback(null);
            }
            return;
        }

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
                                // Skip disabled fields
                                if (this.disabled) {
                                    return;
                                }

                                if (!this.validity.valid) {
                                    // For Bootstrap floating labels, the label comes after the input/select
                                    let fieldName = $(this).next('label').text().trim().replace(' *', '');

                                    // If no next label found, try looking for label with matching 'for' attribute
                                    if (!fieldName) {
                                        const fieldId = $(this).attr('id');
                                        if (fieldId) {
                                            fieldName = $(`label[for="${fieldId}"]`).text().trim().replace(' *', '');
                                        }
                                    }

                                    // Fallback to field name if no label found
                                    if (!fieldName) {
                                        fieldName = $(this).attr('name') || 'Unknown field';
                                    }

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

        // Use the global formatDate function

        // Use the global getDayOfWeek function

        // Use the global formatTime function

        // Function to submit form via AJAX
        function submitFormViaAjax(form) {
            // Show loading state
            const submitBtn = $(form).find('button[type="submit"]');
            const originalBtnText = submitBtn.text();
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            // Enable disabled fields temporarily for form submission
            const disabledFields = $(form).find(':disabled');
            disabledFields.prop('disabled', false);

            // Get form data
            const formData = new FormData(form);
            formData.append('action', 'save_class');

            // Re-disable the fields
            disabledFields.prop('disabled', true);

            // Send AJAX request
            $.ajax({
                url: wecozaClass.ajaxUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('AJAX Response:', response);

                    if (response && response.success) {
                        // Show success message
                        const message = (response.data && response.data.message) ? response.data.message : 'Class saved successfully!';
                        $('#form-messages').html('<div class="alert alert-success">' + message + '</div>');

                        // Redirect if URL provided
                        const redirectUrl = $('#redirect_url').val();
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    } else {
                        // Show error message
                        const message = (response && response.data && response.data.message) ?
                            response.data.message :
                            (response && response.message) ? response.message : 'An error occurred while saving the class.';
                        $('#form-messages').html('<div class="alert alert-danger">' + message + '</div>');

                        // Handle validation errors
                        if (response && response.data && response.data.errors) {
                            handleValidationErrors(response.data.errors);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', {xhr: xhr, status: status, error: error});
                    console.error('Response Text:', xhr.responseText);

                    // Show error message
                    let errorMessage = 'An error occurred. Please try again.';
                    if (xhr.responseText) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMessage = response.message;
                            }
                        } catch (e) {
                            // If response is not JSON, show the raw text (truncated)
                            errorMessage = 'Server Error: ' + xhr.responseText.substring(0, 200);
                        }
                    }

                    $('#form-messages').html('<div class="alert alert-danger">' + errorMessage + '</div>');
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
            // Handle both arrays and non-arrays (like debug info)
            if (Array.isArray(errors[field])) {
                errors[field].forEach(error => {
                    errorSummary += '<li>' + error + '</li>';
                });
            } else if (field === 'debug') {
                // Skip debug info in error summary
                console.log('Debug info:', errors[field]);
            } else {
                // Handle single error message
                errorSummary += '<li>' + errors[field] + '</li>';
            }
        }
        errorSummary += '</ul></div>';

        $('#form-messages').html(errorSummary);
    }

    // Initialize when document is ready
    $(document).ready(function() {
        initClassCaptureForm();
    });

})(jQuery);