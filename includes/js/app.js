(function($) {
    'use strict';


    // /*------------------YDCOZA-----------------------*/
    // /* Initialize Wecoza Table                       */
    // /* Sets up Bootstrap Table with custom config    */
    // /*-----------------------------------------------*/
    // function initializeWecozaTable() {
    //     console.log('Initializing Wecoza Table');
    //     var $table = $('#wecoza-dynamic-table');
        
    //     console.log('Table element found:', $table.length > 0);
    //     console.log('wecozaTableData:', wecozaTableData);

    //     if ($table.length) {
    //         if ($table.data('bootstrap.table')) {
    //             console.log('Table already initialized, destroying previous instance');
    //             $table.bootstrapTable('destroy');
    //         }

    //         console.log('Initializing Bootstrap Table');
            
    //         var columns = wecozaTableData.columns.map(function(column) {
    //             return {
    //                 field: column,
    //                 title: column.replace(/_/g, ' ').replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();})
    //             };
    //         });

    //         // Only add the Actions column if the table is editable
    //         if (wecozaTableData.isEditable) {
    //             columns.push({
    //                 field: 'operate',
    //                 title: 'Actions',
    //                 formatter: operateFormatter,
    //                 events: {
    //                     'click .edit': function (e, value, row, index) {
    //                         console.log('Edit clicked, row:', row);
    //                         openEditModal(row);
    //                     },
    //                     'click .remove': function (e, value, row, index) {
    //                         console.log('Remove clicked, row:', row);
    //                         if (confirm('Are you sure you want to delete this record?')) {
    //                             deleteRecord(row.id);
    //                         }
    //                     }
    //                 }
    //             });
    //         }

    //         $table.bootstrapTable({
    //             pagination: true,
    //             search: true,
    //             showColumns: true,
    //             showRefresh: true,
    //             showToggle: true,
    //             columns: columns
    //         });

    //         console.log('Bootstrap Table initialized');
    //     } else {
    //         console.error('Table element not found');
    //     }
    // }


    // Call to initialize the table
    // initializeWecozaTable();


    /*------------------YDCOZA-----------------------*/
    /* Open Edit Modal                               */
    /* Populates and displays edit modal for a row   */
    /*-----------------------------------------------*/
    function openEditModal(rowData) {
        console.log('openEditModal called with:', rowData);
        var $modal = $('#wecozaEditModal');
        var $form = $('#wecozaEditForm');
        
        if (!$modal.length) {
            console.error('Modal element not found');
            return;
        }

        $form.empty(); // Clear existing form fields

        // Create form fields based on row data
        Object.keys(rowData).forEach(function(key) {
            // Skip fields ending with "_data" and the "operate" field
            if (!key.endsWith('_data') && key !== 'operate' && !wecozaTableData.excludeColumns.includes(key)) {
                var value = rowData[key];
                // Skip object values
                if (typeof value !== 'object') {
                    var $formGroup = $('<div class="mb-3"></div>');
                    var $label = $('<label class="form-label"></label>').attr('for', 'edit_' + key).text(key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()));
                    var $input = $('<input type="text" class="form-control">').attr({
                        id: 'edit_' + key,
                        name: key,
                        value: value
                    });
                    $formGroup.append($label, $input);
                    $form.append($formGroup);
                }
            }
        });

        $form.data('recordId', rowData.id); // Store the record ID

        console.log('Attempting to show modal');
        $modal.modal('show');

        // Bind save changes event
        $('#wecozaSaveChanges').off('click').on('click', function() {
            console.log('Save changes clicked');
            saveChanges();
        });
    }

    /*------------------YDCOZA-----------------------*/
    /* Save Changes                                  */
    /* Handles saving of edited data via AJAX        */
    /*-----------------------------------------------*/
    function saveChanges() {
        console.log('saveChanges function called');
        var $form = $('#wecozaEditForm');
        var recordId = $form.data('recordId');
        var updatedData = {};

        $form.find('input').each(function() {
            var $input = $(this);
            var name = $input.attr('name');
            var value = $input.val();
            // Only include changed values and exclude 'id'
            if (name !== 'id' && value !== $input.data('original-value')) {
                updatedData[name] = value;
            }
        });

        console.log('Updated data:', updatedData);

        if (Object.keys(updatedData).length === 0) {
            showToast('No changes were made.', 'warning');
            return;
        }

        $.ajax({
            url: wecoza_ajax.ajax_url,
            method: 'POST',
            data: {
                action: 'wecoza_update_record',
                nonce: wecoza_ajax.nonce,
                record_id: recordId,
                updated_data: updatedData,
                table_name: wecozaTableData.tableName
            },
            success: function(response) {
                console.log('AJAX success response:', response);
                if (response.success) {
                    $('#wecozaEditModal').modal('hide');
                    showToast('Record updated successfully.', 'success');

                    // Highlight the table after it refreshes
                    // highlightTable();

                    // Refresh the table
                    // var $table = $('#wecoza-dynamic-table');
                    // $table.bootstrapTable('refresh', { silent: true });

                } else {
                    showToast('Failed to update record: ' + response.data, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                showToast('An error occurred while updating the record.', 'error');
            }
        });
    }


    /*------------------WECOZA-----------------------*/
    /* Highlight Table                               */
    /* Adds a highlight effect to the entire table   */
    /*-----------------------------------------------*/
    // function highlightTable() {
    //     var $table = $('#wecoza-dynamic-table');

    //     // Attach a one-time event handler to wait for the table to finish loading
    //     $table.one('load-success.bs.table', function() {
    //         $table.addClass('highlight-update');

    //         // Remove the class after the animation duration (e.g., 2 seconds)
    //         setTimeout(function() {
    //             $table.removeClass('highlight-update');
    //         }, 2000);
    //     });
    // }

    /*------------------YDCOZA-----------------------*/
    /* Show Toast Notification                       */
    /* Displays a Bootstrap toast message to the user*/
    /*-----------------------------------------------*/
    function showToast(message, type) {
        // Remove any existing toasts
        $('.toast').remove();

        // Create the toast container if it doesn't exist
        var $toastContainer = $('#toast-container');
        if ($toastContainer.length === 0) {
            $toastContainer = $('<div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1100;">').appendTo('body');
        }

        var $toast = $(
          '<div class="toast align-items-center text-white border-0 position-fixed top-0 end-0 mt-5 me-3" role="alert" aria-live="assertive" aria-atomic="true">' +
            '<div class="d-flex">' +
              '<div class="toast-body">' +
                'Record updated successfully!' +
              '</div>' +
              '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
            '</div>' +
          '</div>'
        );

        // Set the toast body message
        $toast.find('.toast-body').text(message);

        // Add color class based on the type
        $toast.addClass(type === 'success' ? 'bg-primary text-white' : 
                        type === 'error' ? 'bg-danger text-white' : 
                        'bg-warning');

        // Append the toast to the container
        $toastContainer.append($toast);

        // Initialize and show the toast
        var toastInstance = new bootstrap.Toast($toast[0], {
            delay: 3000
        });
        toastInstance.show();
    }

    /*------------------YDCOZA-----------------------*/
    /* Delete Record                                 */
    /* Handles deletion of a record via AJAX         */
    /*-----------------------------------------------*/
    function deleteRecord(recordId) {
        console.log('deleteRecord function called for ID:', recordId);
        $.ajax({
            url: wecoza_ajax.ajax_url,
            method: 'POST',
            data: {
                action: 'wecoza_delete_record',
                nonce: wecoza_ajax.nonce,
                record_id: recordId,
                table_name: wecozaTableData.tableName
            },
            success: function(response) {
                console.log('AJAX success response:', response);
                if (response.success) {
                    showToast('Record deleted successfully.', 'success');

                    // Highlight the table after it refreshes
                    highlightTable();

                    // Refresh the table
                    var $table = $('#wecoza-dynamic-table');
                    $table.bootstrapTable('refresh', { silent: true });
                } else {
                    showToast('Failed to delete record: ' + response.data, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Delete AJAX error:', status, error);
                showToast('An error occurred while deleting the record.', 'error');
            }
        });
    }


    // /*------------------YDCOZA-----------------------*/
    // /* Client-side form validation using Bootstrap 5  */
    // /* with visual feedback for learners-form only.   */
    // /* Prevents form submission if validation fails   */
    // /* and shows custom Bootstrap feedback styles.    */
    // /*-----------------------------------------------*/

    // const form = $('#learners-form'); // Target the specific learners form

    // if (form.length) {
    //     form.on('submit', function(event) {
    //         // Check if form is valid
    //         if (!this.checkValidity()) {
    //             event.preventDefault();
    //             event.stopPropagation();
    //         }

    //         // Add Bootstrap's 'was-validated' class to trigger validation styles
    //         $(this).addClass('was-validated');
    //     });
    // }

    // /*------------------YDCOZA-----------------------*/
    // /* Generalized toggle function for dynamic fields */
    // /* Toggles visibility and the required attribute  */
    // /* based on another field's value.                */
    // /*-----------------------------------------------*/

    // function toggleFieldVisibility(triggerElement, targetElement, triggerValue, isRequired = false) {
    //     if (triggerElement.val() === triggerValue) {
    //         targetElement.removeClass('d-none'); // Show the field
    //         if (isRequired) {
    //             targetElement.find('input, select').attr('required', 'required'); // Add required attribute
    //         }
    //     } else {
    //         targetElement.addClass('d-none'); // Hide the field
    //         targetElement.find('input, select').removeAttr('required'); // Remove required attribute
    //         targetElement.find('input, select').val(''); // Clear the field value
    //     }
    // }

    // /*------------------YDCOZA-----------------------*/
    // /* Dynamically show/hide Placement Date based on  */
    // /* the Assessment Status selection. If the status */
    // /* is "Not Assessed", hide the date field and     */
    // /* remove its required attribute.                 */
    // /*-----------------------------------------------*/
    // const assessmentStatus = $('#assessment_status');
    // const placementDateField = $('#placement_assessment_date').closest('.mb-3');

    // // Toggle visibility of placement date based on assessment status
    // assessmentStatus.change(function() {
    //     toggleFieldVisibility(assessmentStatus, placementDateField, 'Assessed', true);
    // });
    // toggleFieldVisibility(assessmentStatus, placementDateField, 'Assessed', true); // Initial load check

    // /*------------------YDCOZA-----------------------*/
    // /* Toggle Employer Field Based on Employment Status */
    // /*-----------------------------------------------*/
    // const employmentStatus = $('#employment_status');
    // const employerField = $('#employer_field');

    // employmentStatus.change(function() {
    //     toggleFieldVisibility(employmentStatus, employerField, '1', true); // Assuming 1 is "Employed"
    // });
    // toggleFieldVisibility(employmentStatus, employerField, '1', true); // Initial load check

    // /*------------------YDCOZA-----------------------*/
    // /* Toggle SA ID and Passport Fields Based on Radio*/
    // /*-----------------------------------------------*/
    // const saIdOption = $('#sa_id_option');
    // const passportOption = $('#passport_option');
    // const saIdField = $('#sa_id_field');
    // const passportField = $('#passport_field');

    // $('input[name="id_type"]').change(function() {
    //     if (saIdOption.is(':checked')) {
    //         toggleFieldVisibility(saIdOption, saIdField, 'sa_id', true);
    //     } else if (passportOption.is(':checked')) {
    //         toggleFieldVisibility(passportOption, passportField, 'passport', true);
    //     }
    // });

    // // Trigger the change event on page load to show the correct field if already selected
    // if (saIdOption.is(':checked')) {
    //     toggleFieldVisibility(saIdOption, saIdField, 'sa_id', true);
    // } else if (passportOption.is(':checked')) {
    //     toggleFieldVisibility(passportOption, passportField, 'passport', true);
    // }
    
    /*------------------YDCOZA-----------------------*/
    /* Close Notifications */
    /*-----------------------------------------------*/
    $(document).ready(function() {
      setTimeout(function() {
        $('.ydcoza-auto-close').alert('close');
      }, 5000); // 5000 milliseconds = 5 seconds
    });




    

})(jQuery);


/* chart.js chart examples */

// Updated chart colors to match Discovery theme
var colors = ['#6610f2', '#ede2ff', '#333333', '#c3e6cb', '#dc3545', '#6c757d'];

/* large line chart */
var chLine = document.getElementById("chLine");
var chartData = {
  labels: ["S", "M", "T", "W", "T", "F", "S"],
  datasets: [{
    data: [589, 445, 483, 503, 689, 692, 634],
    backgroundColor: 'transparent',
    borderColor: colors[0], // Main Discovery color
    borderWidth: 4,
    pointBackgroundColor: colors[0] // Main Discovery color
  }]
};
if (chLine) {
  new Chart(chLine, {
    type: 'line',
    data: chartData,
    options: {
      scales: {
        x: { // Updated from xAxes
          ticks: {
            beginAtZero: false
          }
        },
        y: { // Updated from yAxes
          ticks: {
            beginAtZero: true
          }
        }
      },
      plugins: {
        legend: {
          display: false
        }
      },
      responsive: true
    }
  });
}

/* bar chart */
var chBar = document.getElementById("chBar");
if (chBar) {
  new Chart(chBar, {
    type: 'bar',
    data: {
      labels: ["S", "M", "T", "W", "T", "F", "S"],
      datasets: [{
        data: [589, 445, 483, 503, 689, 692, 634],
        backgroundColor: colors[0] // Main Discovery color
      },
      {
        data: [639, 465, 493, 478, 589, 632, 674],
        backgroundColor: colors[1] // Subtle Discovery color
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        x: { // Updated from xAxes
          ticks: {
            beginAtZero: true
          }
        },
        y: { // Updated from yAxes
          ticks: {
            beginAtZero: true
          }
        }
      }
    }
  });
}

