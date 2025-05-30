/**
 * Class Types & Durations JavaScript
 *
 * Handles the two-level selection system for class types and subjects,
 * and implements automatic duration calculation.
 */

/**
 * Global variable to store the AJAX URL
 * This will be set by WordPress via wp_localize_script
 */
var wecozaClass = wecozaClass || {
    ajaxUrl: '/wp-admin/admin-ajax.php',
    debug: true
};

document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const classTypeSelect = document.getElementById('class_type');
    const classSubjectSelect = document.getElementById('class_subject');
    const classDurationInput = document.getElementById('class_duration');
    const classCodeInput = document.getElementById('class_code');

    // Class subjects data (will be populated via AJAX)
    let classSubjectsData = {};

    // Event listener for class type change
    if (classTypeSelect) {
        classTypeSelect.addEventListener('change', function() {
            const selectedClassType = this.value;

            // Reset subject dropdown
            classSubjectSelect.innerHTML = '<option value="">Select Subject</option>';
            classSubjectSelect.disabled = !selectedClassType;

            // Reset duration and code
            classDurationInput.value = '';
            classCodeInput.value = '';

            if (selectedClassType) {
                // Fetch subjects for the selected class type
                fetchClassSubjects(selectedClassType);
            }
        });
    }

    // Event listener for class subject change
    if (classSubjectSelect) {
        classSubjectSelect.addEventListener('change', function() {
            const selectedClassType = classTypeSelect.value;
            const selectedSubject = this.value;

            if (selectedClassType && selectedSubject) {
                // Find the selected subject in the data
                const subjectData = classSubjectsData[selectedClassType].find(
                    subject => subject.id === selectedSubject
                );

                if (subjectData) {
                    // Set duration
                    classDurationInput.value = subjectData.duration;

                    // Generate class code
                    classCodeInput.value = generateClassCode(selectedClassType, selectedSubject);
                }
            } else {
                // Reset duration and code
                classDurationInput.value = '';
                classCodeInput.value = '';
            }
        });
    }

    /**
     * Fetch class subjects for the selected class type
     *
     * @param {string} classType The selected class type
     */
    function fetchClassSubjects(classType) {
        // Show loading indicator
        classSubjectSelect.innerHTML = '<option value="">Loading...</option>';

        // Get the AJAX URL from WordPress
        const ajaxUrl = (typeof wecozaClass !== 'undefined' && wecozaClass.ajaxUrl)
            ? wecozaClass.ajaxUrl
            : '/wp-admin/admin-ajax.php';

        console.log('Fetching subjects for class type:', classType);
        console.log('Using AJAX URL:', ajaxUrl);

        // Make AJAX request to get subjects
        const requestUrl = `${ajaxUrl}?action=get_class_subjects&class_type=${classType}`;
        console.log('Making AJAX request to:', requestUrl);

        fetch(requestUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                console.log('Processing data:', data);
                if (data.success) {
                    // Extract the subjects array from the response
                    let subjectsArray = [];

                    // Check if data.data exists and is an array
                    if (data.data && Array.isArray(data.data)) {
                        subjectsArray = data.data;
                        console.log('Found subjects array in data.data:', subjectsArray);
                    }
                    // Try to convert object to array if needed
                    else if (data.data) {
                        console.log('Data is not in expected format, attempting to convert:', data.data);
                        if (typeof data.data === 'object') {
                            subjectsArray = Object.values(data.data);
                            console.log('Converted object to array:', subjectsArray);
                        }
                    }

                    // Store subjects data for later use
                    classSubjectsData[classType] = subjectsArray;

                    // Reset dropdown
                    classSubjectSelect.innerHTML = '<option value="">Select Subject</option>';

                    // Add options to dropdown
                    if (subjectsArray.length > 0) {
                        subjectsArray.forEach(subject => {
                            if (subject && subject.id && subject.name) {
                                const option = document.createElement('option');
                                option.value = subject.id;
                                option.textContent = subject.name;
                                classSubjectSelect.appendChild(option);
                            }
                        });
                    } else {
                        console.error('No valid subjects found in the response');
                        classSubjectSelect.innerHTML = '<option value="">No subjects available</option>';
                    }
                } else {
                    // Handle error
                    classSubjectSelect.innerHTML = '<option value="">Error loading subjects</option>';
                    console.error('Error loading class subjects:', data.message || 'Unknown error');
                }
            })
            .catch(error => {
                // Handle error
                classSubjectSelect.innerHTML = '<option value="">Error loading subjects</option>';
                console.error('Error loading class subjects:', error);

                // Show more detailed error in the dropdown for debugging
                if (typeof wecozaClass !== 'undefined' && wecozaClass.debug) {
                    classSubjectSelect.innerHTML = `<option value="">Error: ${error.message}</option>`;
                }
            });
    }

    /**
     * Generate a class code based on class type and subject
     *
     * @param {string} classType The selected class type
     * @param {string} subjectId The selected subject ID
     * @return {string} The generated class code
     */
    function generateClassCode(classType, subjectId) {
        // Format: [ClassType]-[SubjectID]-[CurrentYear]-[DateTimeStamp]
        // DateTimeStamp format: YMDHMM (Year, Month, Day, Hour, Minute)
        const now = new Date();
        const currentYear = now.getFullYear();

        // Create datetime stamp: YMDHMM format
        const year = now.getFullYear().toString().slice(-2); // Last 2 digits of year
        const month = (now.getMonth() + 1).toString().padStart(2, '0'); // Month (01-12)
        const day = now.getDate().toString().padStart(2, '0'); // Day (01-31)
        const hour = now.getHours().toString().padStart(2, '0'); // Hour (00-23)
        const minute = now.getMinutes().toString().padStart(2, '0'); // Minute (00-59)

        const dateTimeStamp = `${year}${month}${day}${hour}${minute}`;

        return `${classType}-${subjectId}-${currentYear}-${dateTimeStamp}`;
    }
});
