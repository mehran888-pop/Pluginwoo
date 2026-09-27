<?php
/**
 * PluginWoo Mobile Nav Class.
 * Bottom navigation bar on mobile instead of footer.
 */

if ( ! class_exists( 'PluginWoo_Mobile_Nav' ) ) :

class PluginWoo_Mobile_Nav {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
        add_shortcode( 'pluginwoo_mobile_nav', array( $this, 'render_shortcode' ) );
        add_action( 'wp_footer', array( $this, 'render_mobile_nav' ) );
    }

    public function load_assets() {
        if ( ! get_option( 'pluginwoo_settings', array() )['mobile_nav_enabled'] ?? false ) {
            return;
        }
        if ( ! wp_is_mobile() ) {
            return;
        }
        wp_enqueue_style(
            'pluginwoo-mobile-nav-custom',
            PLUGINWOO_ASSETS_URL . 'css/mobile-nav.css',
            array(),
            PLUGINWOO_VERSION
        );
    }

    /**
     * Render mobile nav at footer position on mobile devices.
     */
    public function render_mobile_nav() {
        $enabled = get_option( 'pluginwoo_settings', array() );
        $enabled = $enabled['mobile_nav_enabled'] ?? false;

        if ( ! $enabled ) {
            return;
        }

        if ( ! wp_is_mobile() ) {
            return;
        }

        // Don't render if an ACF or theme-specific condition applies.
        include PLUGINWOO_TEMPLATE_DIR . 'mobile-nav/mobile-nav.php';
    }

    public function render_shortcode() {
        ob_start();
        include PLUGINWOO_TEMPLATE_DIR . 'mobile-nav/mobile-nav.php';
        return ob_get_clean();
    }
}

endif;
