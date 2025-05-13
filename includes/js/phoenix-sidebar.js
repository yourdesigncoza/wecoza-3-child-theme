/**
 * Phoenix Sidebar Navigation
 * 
 * This file contains the JavaScript functionality for the Phoenix sidebar navigation.
 * It handles collapsible sections, active states, and mobile responsiveness.
 */

(function($) {
    'use strict';

    // Initialize the sidebar when the document is ready
    $(document).ready(function() {
        initSidebar();
    });

    /**
     * Initialize the sidebar navigation
     */
    function initSidebar() {
        // Show the sidebar (it's hidden by default in the CSS)
        $('.navbar-vertical').show();

        // Handle dropdown indicators
        $('.dropdown-indicator-icon').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $parent = $(this).closest('.nav-item-wrapper');
            const $collapse = $parent.find('.parent');
            
            // Toggle the collapse
            $collapse.collapse('toggle');
            
            // Toggle the dropdown indicator icon
            $(this).find('.dropdown-indicator-icon').toggleClass('rotate-180');
        });

        // Handle nav link clicks
        $('.nav-link').on('click', function(e) {
            if ($(this).hasClass('dropdown-indicator')) {
                // If it's a dropdown, only prevent default if the click is on the link itself
                if (e.target === this || $(e.target).hasClass('nav-link-text') || $(e.target).hasClass('dropdown-indicator-icon')) {
                    e.preventDefault();
                }
            }
            
            // Set active state
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            
            // If it's a dropdown, toggle the collapse
            if ($(this).hasClass('dropdown-indicator')) {
                const $parent = $(this).closest('.nav-item-wrapper');
                const $collapse = $parent.find('.parent');
                
                // Toggle the collapse
                $collapse.collapse('toggle');
                
                // Toggle the dropdown indicator icon
                $parent.find('.dropdown-indicator-icon').toggleClass('rotate-180');
            }
        });

        // Handle mobile toggle
        $('.navbar-toggler').on('click', function() {
            const $navbar = $('.navbar-vertical');
            const $navbarCollapse = $('.navbar-collapse');
            
            // Toggle the navbar collapse
            $navbarCollapse.toggleClass('show');
            
            // Toggle the navbar toggler icon
            $(this).find('.navbar-toggler-icon').toggleClass('active');
            
            // Toggle the body class for overflow
            $('body').toggleClass('navbar-vertical-collapsed');
        });

        // Handle window resize
        $(window).on('resize', function() {
            const width = $(window).width();
            
            // If the window width is less than 992px, collapse the navbar
            if (width < 992) {
                $('.navbar-vertical').addClass('navbar-collapsed');
                $('body').addClass('navbar-vertical-collapsed');
            } else {
                $('.navbar-vertical').removeClass('navbar-collapsed');
                $('body').removeClass('navbar-vertical-collapsed');
            }
        }).trigger('resize'); // Trigger resize on load
    }

})(jQuery);
