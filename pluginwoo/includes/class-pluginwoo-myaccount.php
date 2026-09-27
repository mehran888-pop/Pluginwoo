<?php
/**
 * PluginWoo My Account Class.
 * Customizes the customer dashboard (My Account) with templates and a header button.
 */

if ( ! class_exists( 'PluginWoo_MyAccount' ) ) :

class PluginWoo_MyAccount {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
        add_filter( 'woocommerce_navigation_menu_links', array( $this, 'add_myaccount_menu_link' ), 10, 2 );
    }

    public function load_assets() {
        if ( ! is_account_page() ) {
            return;
        }
        wp_enqueue_style(
            'pluginwoo-myaccount-custom',
            PLUGINWOO_ASSETS_URL . 'css/myaccount.css',
            array(),
            PLUGINWOO_VERSION
        );
    }

    /**
     * Add "My Account" button in header navigation via WooCommerce.
     */
    public function add_myaccount_menu_link( $links, $menu ) {
        if ( 'primary' === $menu ) {
            $myaccount_url = wc_get_account_endpoint_url();
            if ( $myaccount_url ) {
                $template     = get_option( 'pluginwoo_settings', array() );
                $style        = isset( $template['myaccount_template'] ) ? $template['myaccount_template'] : 'modern';
                $links[]      = array(
                    'title'  => __( 'ناحیه کاربری', 'pluginwoo' ),
                    'url'    => $myaccount_url,
                    'class'  => 'pluginwoo-myaccount-link pluginwoo-myaccount-' . esc_attr( $style ),
                );
            }
        }
        return $links;
    }
}

endif;
