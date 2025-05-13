# Update UI Design with Phoenix Theme

## Description

Implement a modern UI design update based on the Phoenix theme, focusing first on the sidebar navigation. This update will refresh the visual appearance of the dashboard, improve user experience, and provide a more consistent design system across the application.

The implementation will follow the Phoenix design system with customizations to match WeCoza's brand colors and styling requirements. The sidebar navigation will be the first component to be updated, followed by the overall layout structure, UI components, and theme toggle functionality.

## Implementation Plan

### Task 1: CSS Variables and Theme Colors
- Extract Phoenix theme variables from phoenix.css
- Create phoenix-theme.css with the extracted variables
- Update ydcoza-styles.css to use the new variables
- Update functions.php for CSS enqueuing
- Add Nunito Sans font family

### Task 2: Sidebar Navigation (Priority)
- Extract and analyze Phoenix navbar structure
- Update dashboard-template.php with the new navbar
- Implement navigation icons and styling
- Add collapsible functionality
- Ensure mobile responsiveness
- Integrate with existing content

### Task 3: Layout Structure
- Update main content container structure
- Replace grid classes with Phoenix grid classes
- Adjust spacing and margins
- Ensure responsive behavior

### Task 4: UI Components
- Update card styles
- Update button styles
- Update form elements
- Update alerts and notification components
- Update table styles

### Task 5: Dark/Light Mode Toggle
- Add theme toggle button
- Implement toggle functionality
- Add dark mode styles
- Store theme preference

### Task 6: Testing and Refinement
- Test on different devices
- Test all functionality
- Document and fix issues
- Get feedback and make refinements

## Files to Modify

- includes/css/phoenix-theme.css (new file)
- includes/css/ydcoza-styles.css
- functions.php
- templates/dashboard-template.php
- includes/js/phoenix-sidebar.js (new file)
- includes/js/theme-toggle.js (new file)

## Technical Approach

The implementation will follow a component-based approach, starting with the foundational CSS variables and theme colors, then moving on to the sidebar navigation as the primary focus. Each component will be updated incrementally to ensure backward compatibility and maintain existing functionality.

The Phoenix theme will serve as the reference for the new design, with customizations to match WeCoza's brand colors and styling requirements. The implementation will leverage Bootstrap 5 components and grid system, which are already in use in the current codebase.

For the sidebar navigation, we'll replace the current vertical tabs with the Phoenix navbar component, ensuring all current functionality is preserved. The navigation will be collapsible and responsive, with proper icons and styling.

The CSS variables will be organized in a new phoenix-theme.css file, which will be enqueued in functions.php. The existing ydcoza-styles.css will be updated to use these variables for consistent styling across the application.

The dark/light mode toggle will be implemented using JavaScript to switch between themes, with theme preference stored in local storage for persistence across page loads.

Throughout the implementation, we'll maintain a focus on accessibility, performance, and cross-browser compatibility to ensure a high-quality user experience.

## Color Palette and Styling Requirements

### Color Palette
- Primary Accent: `#1d7afc`
- Alert Background: `#44546f`
- Form Field Styling:
  - Border: 1px solid #b3b9c4
  - Border-radius: 2px
  - Padding: 5px 10px
- Form Label:
  - Background: none
  - Font-weight: bold
- Buttons:
  - Background: `#1d7afc`
  - Padding: 0.5em 1.5em
  - Hover: Outline effect
- Main Button (Bottom of Section):
  - Background: `#216e4e`
  - Hover: Filled with outline effect
- H5 Headings:
  - Margin-top: 2em
- Icons (Dark background):
  - Color: `#94c748`

## Implementation Steps

### Step 1: Create phoenix-theme.css
1. Extract color variables from phoenix.css
2. Organize variables by category (colors, typography, spacing)
3. Add custom variables for WeCoza's brand colors
4. Include font definitions for Nunito Sans

### Step 2: Update functions.php
1. Add code to enqueue phoenix-theme.css
2. Add Google Fonts for Nunito Sans
3. Ensure proper loading order for CSS files

### Step 3: Implement Sidebar Navigation
1. Extract navbar structure from new-look.html
2. Modify dashboard-template.php to replace current sidebar
3. Add proper icons and styling
4. Implement collapsible functionality

### Step 4: Update Layout and Components
1. Update container structure in dashboard-template.php
2. Update card, button, and form styles
3. Implement responsive behavior

### Step 5: Add Theme Toggle
1. Add toggle button to header
2. Implement JavaScript for theme switching
3. Add dark mode styles

### Step 6: Test and Refine
1. Test across different devices and browsers
2. Fix any issues or bugs
3. Make refinements based on feedback
