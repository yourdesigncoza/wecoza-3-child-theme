<?php
/**
 * Bootstrap_Sidebar_Walker.php
 *
 * Custom Walker class for Bootstrap sidebar navigation
 *
 * @package WeCoza
 */
namespace WeCoza\Walkers;

use Walker_Nav_Menu;

class Bootstrap_Sidebar_Walker extends Walker_Nav_Menu {
    /**
     * The ID of the current parent item whose submenu is being rendered.
     *
     * @var int
     */
    private $current_item_id;

    /**
     * Whether the current parent item should render its submenu open.
     *
     * @var bool
     */
    private $active_submenu = false;

    /**
     * Starts the submenu level.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);

        if ( $depth === 0 ) {
            $submenu_id  = 'submenu-' . esc_attr( $this->current_item_id );
            // Add 'show' class if this submenu is active
            $show_class  = $this->active_submenu ? ' show' : '';
            $output     .= "\n{$indent}<div class=\"collapse{$show_class}\" id=\"{$submenu_id}\">\n";
            $output     .= "{$indent}\t<ul class=\"nav flex-column\">\n";
        } else {
            // deeper levels if needed
            $output .= "\n{$indent}<ul class=\"nav flex-column\">\n";
        }
    }

    /**
     * Ends the submenu level.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);

        if ( $depth === 0 ) {
            $output .= "{$indent}\t</ul>\n";
            $output .= "{$indent}</div>\n";
            // reset for next sibling
            $this->active_submenu = false;
        } else {
            $output .= "{$indent}</ul>\n";
        }
    }

    /**
     * Starts the element output for a menu item.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = $depth ? str_repeat("\t", $depth) : '';

        // Determine if this item has children
        $has_children = ! empty( $args->walker->has_children );

        // For top‐level items with children, mark if it's the current active submenu
        if ( $depth === 0 && $has_children ) {
            $this->current_item_id = $item->ID;
            $classes = empty( $item->classes ) ? [] : (array) $item->classes;
            $this->active_submenu = in_array( 'current-menu-ancestor', $classes, true )
                                 || in_array( 'current-menu-parent',   $classes, true );
        }

        // Build <li> classes
        $classes[] = 'nav-item';
        if ( in_array( 'current-menu-item',     $item->classes, true )
          || in_array( 'current-menu-ancestor', $item->classes, true ) ) {
            $classes[] = 'active';
        }
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        // Open the <li>
        $output .= "{$indent}<li{$class_names}>";

        // Build <a> attributes
        $atts            = [];
        $atts['href']    = $item->url ? $item->url : '';
        $link_classes    = 'nav-link nav-id-' . $item->ID;

        if ( $has_children ) {
            $submenu_id = 'submenu-' . $item->ID;

            // Toggle attributes: expanded or collapsed?
            $expanded         = $this->active_submenu ? 'true' : 'false';
            $collapsed_class  = $this->active_submenu ? '' : ' collapsed';

            $atts['href']           = '#' . $submenu_id;
            $atts['data-bs-toggle'] = 'collapse';
            $atts['aria-expanded']  = $expanded;
            $atts['aria-controls']  = $submenu_id;
            $atts['role']           = 'button';
            $link_classes          .= $collapsed_class;
        }

        $atts['class'] = $link_classes;
        if ( $item->target ) {
            $atts['target'] = $item->target;
        }
        if ( $item->xfn ) {
            $atts['rel'] = $item->xfn;
        }
        if ( $item->attr_title ) {
            $atts['title'] = $item->attr_title;
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value_attr = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= " {$attr}=\"{$value_attr}\"";
            }
        }

        // Build the link
        $item_output  = $args->before;
        $item_output .= "<a{$attributes}>";

        // Add the caret‐right SVG before the link text for parents
        if ( $has_children ) {
            $item_output .= '<svg class="svg-inline--fa fa-caret-right dropdown-indicator-icon" '
                          . 'aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" '
                          . 'role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg>'
                          . '<path fill="currentColor" '
                          . 'd="M246.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128'
                          . 'c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 256'
                          . 'c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l128-128z">'
                          . '</path></svg> ';
        }

        $item_output .= $args->link_before
                      . '<span class="nav-link-text">'
                      . apply_filters( 'the_title', $item->title, $item->ID )
                      . '</span>'
                      . $args->link_after
                      . '</a>'
                      . $args->after;

        // Append to output
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    // end_el is inherited and outputs the closing </li>
}
