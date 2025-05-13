/**
 * Theme Toggle Functionality
 * 
 * This file contains the JavaScript functionality for toggling between light and dark themes.
 * It handles theme preference storage in local storage and applies the appropriate theme.
 */

(function($) {
    'use strict';

    // Initialize the theme toggle when the document is ready
    $(document).ready(function() {
        initThemeToggle();
    });

    /**
     * Initialize the theme toggle functionality
     */
    function initThemeToggle() {
        // Create the theme toggle button if it doesn't exist
        if ($('#theme-toggle').length === 0) {
            const $header = $('.site-header .inside-header');
            const $toggleButton = $('<button>', {
                id: 'theme-toggle',
                class: 'theme-toggle-btn',
                'aria-label': 'Toggle dark mode',
                html: '<i class="bi bi-sun-fill light-icon"></i><i class="bi bi-moon-fill dark-icon"></i>'
            });
            
            // Append the toggle button to the header
            $header.append($toggleButton);
        }

        // Get the current theme from local storage or default to light
        const currentTheme = localStorage.getItem('theme') || 'light';
        
        // Apply the current theme
        applyTheme(currentTheme);
        
        // Handle theme toggle button click
        $('#theme-toggle').on('click', function() {
            // Toggle the theme
            const newTheme = $('html').attr('data-bs-theme') === 'dark' ? 'light' : 'dark';
            
            // Apply the new theme
            applyTheme(newTheme);
            
            // Store the theme preference in local storage
            localStorage.setItem('theme', newTheme);
        });
    }

    /**
     * Apply the specified theme
     * 
     * @param {string} theme - The theme to apply ('light' or 'dark')
     */
    function applyTheme(theme) {
        // Set the data-bs-theme attribute on the html element
        $('html').attr('data-bs-theme', theme);
        
        // Update the toggle button state
        if (theme === 'dark') {
            $('#theme-toggle').addClass('dark-mode');
        } else {
            $('#theme-toggle').removeClass('dark-mode');
        }
    }

})(jQuery);
