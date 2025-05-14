# Update #classes-form to use Bootstrap 5 floating labels

## Description
This task is related to WEC-84 UI redesign. We need to update the form fields in the #classes-form to use Bootstrap 5's floating labels structure instead of the current standard label-above-input structure.

## Requirements
- Update all form fields in the #classes-form to use Bootstrap 5's floating labels structure
- Follow the example from Bootstrap documentation: https://getbootstrap.com/docs/5.1/forms/floating-labels/#example
- Ensure all validation functionality continues to work properly
- Maintain required field indicators (red asterisks)
- Update all form partials in app/Views/components/class-capture-partials/

## Example Structure
Current structure:
```html
<div class="col-md-3">
  <label for="client_id" class="form-label">Client Name (ID) <span class="text-danger">*</span></label>
  <select id="client_id" name="client_id" class="form-select form-select-sm" required>
    <option value="">Select</option>
    <!-- Options here -->
  </select>
  <div class="invalid-feedback">Please select a client.</div>
  <div class="valid-feedback">Looks good!</div>
</div>
```

New structure (for inputs):
```html
<div class="form-floating mb-3">
  <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
  <label for="floatingInput">Email address</label>
  <div class="invalid-feedback">Please provide a valid email.</div>
  <div class="valid-feedback">Looks good!</div>
</div>
```

New structure (for selects):
```html
<div class="form-floating mb-3">
  <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
    <option selected>Open this select menu</option>
    <option value="1">One</option>
    <option value="2">Two</option>
    <option value="3">Three</option>
  </select>
  <label for="floatingSelect">Works with selects</label>
  <div class="invalid-feedback">Please select an option.</div>
  <div class="valid-feedback">Looks good!</div>
</div>
```

## Files Updated
- app/Views/components/class-capture-partials/basic-details.php
- app/Views/components/class-capture-partials/class-info.php
- app/Views/components/class-capture-partials/class-schedule-form.php (including exception dates)
- app/Views/components/class-capture-partials/funding-exam-details.php
- app/Views/components/class-capture-partials/class-learners.php (including add_learner[] multi-select)
- app/Views/components/class-capture-partials/exam-learners.php (including exam_learner_select[] multi-select)
- app/Views/components/class-capture-partials/class-notes-qa.php (including class_notes[] multi-select and QA visit dates)
- app/Views/components/class-capture-partials/assignments-dates.php (including initial_class_agent, agent replacements, project supervisor, and backup agents)

## Files Still Needing Updates
- app/Views/components/class-capture-partials/date-history.php

## Implementation Notes
- Added a wrapper `<div class="form-floating">` around each input/select
- Moved the label after the input/select element
- Added a placeholder attribute to inputs
- Updated CSS classes from form-control-sm/form-select-sm to form-control/form-select
- Added mb-3 margin class to container divs for proper spacing
- Maintained all existing functionality while updating the visual appearance
- For exception dates, updated the template row to use floating labels
- For multi-select elements (add_learner[], exam_learner_select[], class_notes[]):
  * Used a custom approach with floating labels
  * Added the multiple attribute to the select element
  * Removed the disabled selected option to allow proper multi-select functionality
  * Added aria-label for accessibility
  * Added instructions to hold Ctrl/Cmd to select multiple options
- For file inputs in QA reports, updated to use floating labels
- For remove buttons, used a flex container with align-items-end to align them with the bottom of the form fields
- For agent replacements and backup agents, updated the template rows to use floating labels

## Testing Notes
- Verify that all form validation still works correctly
- Check that required field indicators are visible
- Ensure that conditional fields still show/hide properly
- Test form submission to confirm data is correctly captured
- Verify that the floating labels appear correctly when fields are focused/filled
- Test adding and removing exception dates to ensure the functionality works with the new structure
- Test multi-select functionality for learners and class notes
- Test file upload functionality for QA reports
- Test adding and removing agent replacements and backup agents

## Related Tasks
- WEC-84: UI Redesign
