/**
 * Class Validation JavaScript
 *
 * Handles all client-side validation for the class capture form
 */

(function($) {
    'use strict';

    // Initialize validation when document is ready
    $(document).ready(function() {
        initializeValidation();
    });

    /**
     * Initialize all validation functionality
     */
    function initializeValidation() {
        // Initialize Bootstrap custom validation
        initializeBootstrapValidation();

        // Initialize date pair validation
        initializeDatePairValidation();

        // Initialize QA visit validation
        initializeQAVisitValidation();

        // Initialize takeover date validation
        initializeTakeoverDateValidation();

        // Initialize event form validation
        initializeEventFormValidation();
    }

    /**
     * Initialize Bootstrap custom validation
     */
    function initializeBootstrapValidation() {
        // Bootstrap custom validation
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    // Prevent default form submission
                    event.preventDefault();

                    // Update calendar data before validation if function exists
                    if (typeof updateHiddenFields === 'function') {
                        updateHiddenFields();
                    }

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

                    if (!form.checkValidity() || !dateHistoryValid || !qaVisitsValid || !takeoverDatesValid) {
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

                        // Show error message if takeover dates validation failed
                        if (!takeoverDatesValid) {
                            $('#form-messages').html('<div class="alert alert-danger">Please ensure all agent takeover dates are after the initial agent start date.</div>');
                            // Scroll to the agent replacements section
                            $('html, body').animate({
                                scrollTop: $('#agent-replacements-container').offset().top - 100
                            }, 500);
                        }
                    } else {
                        // Form is valid, proceed with AJAX submission
                        submitFormViaAjax(form);
                    }
                });
            });
    }

    /**
     * Submit form via AJAX
     * 
     * @param {HTMLFormElement} form The form element to submit
     */
    function submitFormViaAjax(form) {
        // Show loading message
        $('#form-messages').html('<div class="alert alert-info">Submitting class data, please wait...</div>');

        // Create FormData object
        const formData = new FormData(form);

        // Add action for WordPress AJAX
        formData.append('action', 'wecoza_save_class');

        // AJAX request
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
                    
                    // Redirect if URL is provided
                    if (response.data.redirect_url) {
                        setTimeout(function() {
                            window.location.href = response.data.redirect_url;
                        }, 1500);
                    }
                } else {
                    // Show error message
                    $('#form-messages').html('<div class="alert alert-danger">' + response.data.message + '</div>');
                    
                    // Scroll to error message
                    $('html, body').animate({
                        scrollTop: $('#form-messages').offset().top - 100
                    }, 500);
                }
            },
            error: function(xhr, status, error) {
                // Show error message
                $('#form-messages').html('<div class="alert alert-danger">An error occurred while saving the class. Please try again.</div>');
                
                // Log error for debugging
                console.error('AJAX Error:', xhr, status, error);
                
                // Scroll to error message
                $('html, body').animate({
                    scrollTop: $('#form-messages').offset().top - 100
                }, 500);
            }
        });
    }

    /**
     * Initialize date pair validation for stop/restart dates
     */
    function initializeDatePairValidation() {
        // Function to validate date pairs
        window.validateDatePair = function($row) {
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
        };

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

        // Attach validation to date inputs
        $(document).on('change', 'input[name="stop_dates[]"], input[name="restart_dates[]"]', function() {
            validateDatePair($(this).closest('.date-history-row'));
        });
    }

    /**
     * Initialize QA visit validation
     */
    function initializeQAVisitValidation() {
        // Function to validate QA visit date and report
        window.validateQAVisit = function($row) {
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
        };

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

        // Attach validation to QA visit inputs
        $(document).on('change', 'input[name="qa_visit_dates[]"], input[name="qa_reports[]"]', function() {
            validateQAVisit($(this).closest('.qa-visit-row'));
        });
    }

    /**
     * Initialize takeover date validation
     */
    function initializeTakeoverDateValidation() {
        // Function to validate takeover date
        window.validateTakeoverDate = function($row) {
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
        };

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

        // Attach validation to takeover date inputs
        $(document).on('change', 'input[name="replacement_agent_dates[]"]', function() {
            validateTakeoverDate($(this).closest('.agent-replacement-row'));
        });

        // Event handler for initial agent start date changes
        $('#initial_agent_start_date').on('change', function() {
            // Validate all takeover dates when initial date changes
            $('.agent-replacement-row:not(#agent-replacement-row-template)').each(function() {
                validateTakeoverDate($(this));
            });
        });
    }

    /**
     * Initialize event form validation
     */
    function initializeEventFormValidation() {
        // Function to reset validation state
        window.resetValidationState = function() {
            $('#eventType, #eventDescription, #eventStartTime, #eventEndTime').removeClass('is-invalid is-valid');
        };

        // Validate event form on save
        $('#saveEvent').on('click', function() {
            const eventType = $('#eventType').val();
            const description = $('#eventDescription').val();
            const startTime = $('#eventStartTime').val();
            const endTime = $('#eventEndTime').val();
            const eventDate = $('#eventDate').val();

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
                return false;
            }

            return true;
        });
    }

})(jQuery);
