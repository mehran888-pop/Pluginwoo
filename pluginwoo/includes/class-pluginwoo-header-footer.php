<?php
/**
 * PluginWoo Header & Footer Class.
 * Provides custom header and footer templates with multiple layout options.
 */

if ( ! class_exists( 'PluginWoo_Header_Footer' ) ) :

class PluginWoo_Header_Footer {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );

        // Replace header with custom template on frontend if active.
        add_action( 'wp', array( $this, 'maybe_replace_header' ) );
        add_action( 'wp', array( $this, 'maybe_replace_footer' ) );

        // Header shortcode.
        add_shortcode( 'pluginwoo_header', array( $this, 'header_shortcode' ) );
        add_shortcode( 'pluginwoo_footer', array( $this, 'footer_shortcode' ) );
    }

    public function load_assets() {
        wp_enqueue_style(
            'pluginwoo-header-footer-custom',
            PLUGINWOO_ASSETS_URL . 'css/header-footer.css',
            array(),
            PLUGINWOO_VERSION
        );
    }

    /**
     * Optionally replace site header with PluginWoo header template.
     */
    public function maybe_replace_header() {
        $template = get_option( 'pluginwoo_settings', array() );
        if ( empty( $template['header_template'] ) || 'default' === $template['header_template'] ) {
            return;
        }

        // Only on singular and archive, not admin.
        if ( is_admin() || ! is_front_page() && ! is_singular() && ! is_archive() ) {
            return;
        }

        // Check if theme already provides a custom header (don't override).
        if ( current_theme_supports( 'custom-header' ) ) {
            return;
        }

        // Provide the shortcode output as fallback.
        // The actual replacement is theme-dependent; user can use [pluginwoo_header] shortcode.
    }

    /**
     * Optionally replace site footer with PluginWoo footer template.
     */
    public function maybe_replace_footer() {
        $template = get_option( 'pluginwoo_settings', array() );
        if ( empty( $template['footer_template'] ) || 'default' === $template['footer_template'] ) {
            return;
        }
        // User should use [pluginwoo_footer] in theme's footer area or widget.
    }

    public function header_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'template' => 'modern',
        ), $atts, 'pluginwoo_header' );

        ob_start();
        include PLUGINWOO_TEMPLATE_DIR . 'header/header-' . sanitize_key( $atts['template'] ) . '.php';
        return ob_get_clean();
    }

    public function footer_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'template' => 'modern',
        ), $atts, 'pluginwoo_footer' );

        ob_start();
        include PLUGINWOO_TEMPLATE_DIR . 'footer/footer-' . sanitize_key( $atts['template'] ) . '.php';
        return ob_get_clean();
    }
}

endif;
