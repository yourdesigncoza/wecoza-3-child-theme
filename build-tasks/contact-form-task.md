# Implement Simple Contact Form

## Description
Implement a simple contact form with Bootstrap styling that can be used via a shortcode. The form should follow the MVC architecture pattern and include fields for name, ID number, address, and email.

The implementation should follow the existing patterns in the codebase for form handling, validation, and database storage. The contact form will provide a standardized way for users to submit contact information through the website.

As shown in the UI:
- Form with Bootstrap styling and responsive layout
- Fields for name, ID number, address, and email
- Client-side validation with Bootstrap classes and visual feedback
- Server-side validation with error messaging
- Success/error messaging after form submission

## Subtasks
- [ ] WEC-67.1: Create ContactController
  - Implement the ContactController class following the MVC pattern
  - Register the 'wecoza_contact_form' shortcode
  - Handle form rendering through a view
  - Implement AJAX submission handler with proper validation
  - Add validation rules using the ValidationService
  - Follow existing controller patterns in the codebase
  - Ensure proper error handling and response formatting

- [ ] WEC-67.2: Create ContactModel
  - Define the data structure for contact form submissions
  - Implement properties for name, ID, address, email
  - Create getter and setter methods for all properties
  - Implement database operations (save, retrieve)
  - Add validation methods as needed
  - Follow existing model patterns in the codebase
  - Ensure proper error handling for database operations

- [ ] WEC-67.3: Create Contact Form View
  - Implement a Bootstrap-styled form with responsive layout
  - Include fields for name, ID number, address, and email
  - Add client-side validation using Bootstrap classes
  - Implement AJAX submission with loading indicators
  - Add success/error messaging
  - Follow existing view patterns in the codebase
  - Use view helpers for consistent form elements

- [ ] WEC-67.4: Create Database Migration
  - Create a migration to add a contacts table to the database
  - Define columns for id, name, id_number, address, email, created_at, updated_at
  - Add the migration to the existing migration system
  - Ensure compatibility with PostgreSQL
  - Add appropriate indexes for performance
  - Include rollback functionality
  - Test the migration process

- [ ] WEC-67.5: Register AJAX Handler
  - Add AJAX handler to ajax-handlers.php
  - Register both authenticated and non-authenticated endpoints
  - Implement proper response formatting
  - Ensure security with nonce verification
  - Add appropriate error handling
  - Follow existing AJAX handler patterns
  - Test the AJAX endpoints

- [ ] WEC-67.6: Testing and Documentation
  - Test the shortcode functionality in various contexts
  - Test form validation (both client-side and server-side)
  - Test form submission and database storage
  - Document the shortcode usage and parameters
  - Add inline code documentation
  - Create usage examples
  - Verify mobile responsiveness

## Files
- app/Controllers/ContactController.php
- app/Models/Contact/ContactModel.php
- app/Views/components/contact-form.view.php
- includes/db-migrations.php (update)
- app/ajax-handlers.php (update)
- assets/js/contact-form.js (if needed for complex client-side functionality)

## Related Issues
- None
