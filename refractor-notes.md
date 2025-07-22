Refactoring code means restructuring existing source code to improve its internal structure without changing its external behavior. It focuses on enhancing readability, maintainability, and efficiency.

The codebase follows an MVC architecture:

### Controllers (`/app/Controllers/`)
- `LearnerController.php` - Learner data operations  

### Models (`/app/Models/`)
- `Learner/LearnerModel.php` - Learner data model

### Views (`/app/Views/`)
- `learner/learner-form.view.php` - Learner form templates

### Learner Management

**`[wecoza_display_learners]`**
- **Purpose**: Displays all learners in responsive Bootstrap table with modal details
- **Parameters**: None
- **Example**: `[wecoza_display_learners]`

**`[wecoza_learners_form]`**
- **Purpose**: Comprehensive learner registration form with file upload
- **Parameters**: Various form configuration options
- **Example**: `[wecoza_learners_form]`

**`[wecoza_learners_update_form]`**
- **Purpose**: Form for updating existing learner information
- **Parameters**: Uses URL parameter `learner_id`
- **Example**: `[wecoza_learners_update_form]`

### MVC-Based Shortcodes (Development)

The following shortcodes are implemented as stubs in the MVC controllers:

- `[wecoza_learner_capture]` - Learner capture form (placeholder)
- `[wecoza_learner_display]` - Learner display functionality (placeholder)  
- `[wecoza_learner_update]` - Learner update form (placeholder)
- `[wecoza_assessment_capture]` - Assessment capture form (placeholder)
- `[wecoza_assessment_display]` - Assessment display functionality (placeholder)

