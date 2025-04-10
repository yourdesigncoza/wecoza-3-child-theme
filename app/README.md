# WeCoza 3 Child Theme - MVC Architecture

This directory contains the MVC (Model-View-Controller) architecture for the WeCoza 3 Child Theme.

## Directory Structure

```
/app
  /Models
    /Learner
    /Agent
    /Client
    /Assessment
    /Portfolio
  /Views
    /learner
    /agent
    /client
    /admin
    /components
    /layouts
  /Controllers
    /LearnerController.php
    /AgentController.php
    /ClientController.php
    /AssessmentController.php
  /Services
    /Database
    /FileUpload
    /Authentication
    /Validation
```

## Models

Models represent data structures and business logic. They handle data validation and relationships between entities.

## Views

Views handle presentation logic. They should not contain business logic and should use template partials for reusable components.

## Controllers

Controllers handle the request/response cycle. They implement WordPress hooks as entry points and use service classes for complex operations.

## Services

Services implement business logic and handle complex operations. They manage external integrations, caching, and file operations.

## Usage

To use the MVC architecture, follow these guidelines:

1. Create models for data entities
2. Create views for presentation
3. Create controllers to handle requests
4. Use services for complex operations

## Example

```php
// Controller
class LearnerController {
    public function displayLearner($atts) {
        // Get learner data
        $learnerModel = LearnerModel::getById($atts['id']);
        
        // Render view
        return view('learner/learner-detail', ['learner' => $learnerModel]);
    }
}

// View (learner/learner-detail.view.php)
<div class="learner-detail">
    <h2><?php echo esc_html($learner->getFirstName() . ' ' . $learner->getLastName()); ?></h2>
    <p>Email: <?php echo esc_html($learner->getEmail()); ?></p>
</div>
```

## Naming Conventions

- Models: Singular, PascalCase (e.g., LearnerModel)
- Controllers: Suffix with 'Controller', PascalCase
- Views: Use kebab-case for files, suffix with .view.php
- Services: Suffix with 'Service', PascalCase

## WordPress Integration

The MVC architecture integrates with WordPress through hooks and shortcodes. Controllers register shortcodes and handle AJAX requests.

## Database Access

Database operations are handled through the DatabaseService class, which provides a PDO interface for database access.

## File Structure

- Models: `/app/Models/{Entity}/{Entity}Model.php`
- Views: `/app/Views/{entity}/{view-name}.view.php`
- Controllers: `/app/Controllers/{Entity}Controller.php`
- Services: `/app/Services/{Category}/{Service}Service.php`
