# Update UI Design with Phoenix Theme

## Description

Implement a modern UI design update based on the Phoenix theme, focusing first on the sidebar navigation. This update will refresh the visual appearance of the dashboard, improve user experience, and provide a more consistent design system across the application.

The implementation will follow the Phoenix design system with customizations to match WeCoza's brand colors and styling requirements. The sidebar navigation will be the first component to be updated, followed by the overall layout structure, UI components, and theme toggle functionality.

## Quality Assurance Criteria

1. **MVP Scope Adherence**
   * Focus on essential UI updates without changing core functionality.
   * Implement changes incrementally, starting with the sidebar navigation.
   * Maintain all existing features and functionality during the redesign.

2. **Integration Validation**
   * Ensure the new UI integrates seamlessly with existing components.
   * Verify that all current functionality works with the new design.
   * Test navigation between different sections and content display.

3. **No Duplicate Functionality**
   * Reuse existing JavaScript functions where possible.
   * Leverage the Phoenix theme components rather than creating custom ones.
   * Maintain a consistent approach to component styling.

4. **WordPress Best Practices**
   * Follow WordPress coding standards for PHP, JavaScript, and CSS.
   * Properly enqueue scripts and styles through functions.php.
   * Use appropriate hooks and filters for template modifications.

5. **LLM-Friendly Structure**
   * Organize code with clear comments and documentation.
   * Use consistent naming conventions for classes and functions.
   * Structure CSS with logical grouping and clear hierarchy.


## Context & Requirements

The current UI uses a vertical tab navigation system with a dated design. The new Phoenix theme provides a more modern, clean look with improved navigation and component styling.

Key points:
* The sidebar navigation needs to be updated first, replacing the current vertical tabs.
* The color scheme should be updated to match the specified palette (Primary Accent: #1d7afc).
* Form fields, buttons, and other UI components need styling updates.
* The design should support both light and dark modes.
* All existing functionality must be preserved during the redesign.


## Implementation Sequence

1. First implement WEC-84-1 (CSS Variables and Theme Colors) – Provides the foundation for consistent styling across components
2. Then implement WEC-84-2 (Sidebar Navigation) – Primary focus of the update as specified in the ticket
3. Next implement WEC-84-3 (Layout Structure) – Builds on the new styling foundation
4. Then implement WEC-84-4 (UI Components) – Updates individual UI elements to match the new design
5. Next implement WEC-84-5 (Dark/Light Mode Toggle) – Adds theme switching functionality
6. Finally implement WEC-84-6 (Testing and Refinement) – Ensures quality and consistency

## Subtasks

* [ ] **WEC-84-1: CSS Variables and Theme Colors**
  **Quality Assurance Criteria:**

  * **Security:** Ensure no inline scripts or styles that could introduce XSS vulnerabilities.
  * **Compatibility:** Test with different browsers (Chrome, Firefox, Safari, Edge).
  * **Code Readability & Maintainability:** Organize CSS variables logically with clear naming conventions.
  * **WP APIs & Hooks:** Use proper WordPress functions to enqueue stylesheets.
  * **Asset Enqueuing:** Enqueue CSS files with appropriate dependencies and version numbers.
  * **Coding Standards:** Follow WordPress CSS coding standards.
  * **Documentation:** Add comments explaining variable usage and purpose.

  **Implementation Details:**

  * Extract color variables and theme properties from phoenix.css
  * Create phoenix-theme.css with organized variables
  * Update ydcoza-styles.css to use the new variables
  * Add Nunito Sans font family from Google Fonts
  * Update functions.php to enqueue new stylesheets

  **Status Transitions:**

  * Not Started → In Progress: When development begins
  * In Progress → Testing: When CSS variables are implemented and ready for review

* [ ] **WEC-84-2: Sidebar Navigation**
  **Quality Assurance Criteria:**

  * **Security:** Sanitize any dynamic content in the navigation.
  * **Compatibility:** Ensure navigation works across different browsers and devices.
  * **Code Readability & Maintainability:** Use clear class names and structure for the navigation.
  * **WP APIs & Hooks:** Use appropriate WordPress template functions.
  * **Asset Enqueuing:** Properly enqueue any required JavaScript for navigation functionality.
  * **Coding Standards:** Follow WordPress HTML and CSS standards.

  **Implementation Details:**

  * Extract navbar structure from new-look.html
  * Replace current sidebar in dashboard-template.php
  * Implement navigation icons and styling
  * Add collapsible functionality with JavaScript
  * Ensure mobile responsiveness
  * Integrate with existing content panels

  **Status Transitions:**

  * Not Started → In Progress: When development begins
  * In Progress → Testing: When sidebar navigation is implemented and ready for review

* [ ] **WEC-84-3: Layout Structure**
  **Quality Assurance Criteria:**

  * **Security:** Ensure proper escaping of dynamic content in templates.
  * **Compatibility:** Test layout on different screen sizes and devices.
  * **Code Readability & Maintainability:** Use consistent grid classes and structure.
  * **WP APIs & Hooks:** Use appropriate WordPress template functions.
  * **Asset Enqueuing:** Ensure all required CSS for layout is properly loaded.
  * **Coding Standards:** Follow WordPress HTML and CSS standards.

  **Implementation Details:**

  * Update main content container structure in dashboard-template.php
  * Replace current grid classes with Phoenix grid classes
  * Adjust spacing and margins according to the new design
  * Implement responsive behavior for different screen sizes
  * Test layout on desktop, tablet, and mobile devices

  **Status Transitions:**  
  - Not Started → In Progress: When development begins  
  - In Progress → Testing: When layout structure is implemented and ready for review  

* [ ] **WEC-84-4: UI Components**
  **Quality Assurance Criteria:**  
  - Ensure consistent styling across all components  
  - Verify accessibility standards (color contrast, focus states)  
  - Test components on different browsers and devices  
  - Maintain backward compatibility with existing functionality  
  - Follow WordPress coding standards for HTML and CSS  

  **Implementation Details:**  
  - Update card styles to match the Phoenix design
  - Update button styles with the new color scheme and hover effects
  - Update form elements with the specified styling (borders, padding)
  - Update alerts and notification components
  - Update table styles for data display

  **Status Transitions:**  
  - Not Started → In Progress: When development begins  
  - In Progress → Testing: When UI components are updated and ready for review  

* [ ] **WEC-84-5: Dark/Light Mode Toggle**  
  **Quality Assurance Criteria:**  
  - Ensure smooth transition between light and dark modes  
  - Verify all components have appropriate dark mode styling  
  - Test theme persistence across page loads  
  - Ensure accessibility in both light and dark modes  
  - Follow best practices for theme switching  

  **Implementation Details:**  
  - Add theme toggle button to the header
  - Implement toggle functionality with JavaScript
  - Add dark mode styles for all components
  - Store theme preference in local storage
  - Test theme switching on all pages and components

  **Status Transitions:**  
  - Not Started → In Progress: When development begins  
  - In Progress → Testing: When theme toggle is implemented and ready for review  

* [ ] **WEC-84-6: Testing and Refinement**  
  **Quality Assurance Criteria:**  
  - Comprehensive testing across different devices and browsers  
  - Verification of all existing functionality with the new design  
  - Performance testing to ensure no degradation  
  - Accessibility testing for WCAG compliance  
  - User feedback collection and implementation  

  **Implementation Details:**  
  - Test on desktop, tablet, and mobile devices
  - Test all existing functionality with the new design
  - Document and fix any issues or bugs
  - Collect feedback and make refinements
  - Ensure design consistency across all pages

  **Status Transitions:**  
  - Not Started → In Progress: When testing begins  
  - In Progress → Completed: When all issues are resolved and the design is finalized  


## Files

* includes/css/phoenix-theme.css (new file)
* includes/css/ydcoza-styles.css
* functions.php
* templates/dashboard-template.php
* includes/js/phoenix-sidebar.js (new file)
* includes/js/theme-toggle.js (new file)

## Related Issues

* WEC-84: Update design UI (Linear ticket)

## Technical Approach

The implementation will follow a component-based approach, starting with the foundational CSS variables and theme colors, then moving on to the sidebar navigation as the primary focus. Each component will be updated incrementally to ensure backward compatibility and maintain existing functionality.

The Phoenix theme will serve as the reference for the new design, with customizations to match WeCoza's brand colors and styling requirements. The implementation will leverage Bootstrap 5 components and grid system, which are already in use in the current codebase.

For the sidebar navigation, we'll replace the current vertical tabs with the Phoenix navbar component, ensuring all current functionality is preserved. The navigation will be collapsible and responsive, with proper icons and styling.

The CSS variables will be organized in a new phoenix-theme.css file, which will be enqueued in functions.php. The existing ydcoza-styles.css will be updated to use these variables for consistent styling across the application.

The dark/light mode toggle will be implemented using JavaScript to switch between themes, with theme preference stored in local storage for persistence across page loads.

Throughout the implementation, we'll maintain a focus on accessibility, performance, and cross-browser compatibility to ensure a high-quality user experience.
