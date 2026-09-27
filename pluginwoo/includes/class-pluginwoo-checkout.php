<?php
/**
 * PluginWoo Checkout Class.
 */

if ( ! class_exists( 'PluginWoo_Checkout' ) ) :

class PluginWoo_Checkout {

    public function __construct() {
        add_filter( 'woocommerce_get_checkout_page_order_total_html', array( $this, 'modify_order_total_html' ), 10, 1 );
        add_action( 'wp_enqueue_scripts', array( $this, 'load_checkout_assets' ) );
    }

    public function load_checkout_assets() {
        if ( ! is_checkout() ) {
            return;
        }
        wp_enqueue_style(
            'pluginwoo-checkout-custom',
            PLUGINWOO_ASSETS_URL . 'css/checkout.css',
            array(),
            PLUGINWOO_VERSION
        );
    }

    public function modify_order_total_html( $html ) {
        $template = get_option( 'pluginwoo_settings', array() );
        $selected = isset( $template['checkout_template'] ) ? $template['checkout_template'] : 'modern';

        // Add custom wrapper class.
        return '<div class="pluginwoo-checkout-order-total pluginwoo-checkout-' . esc_attr( $selected ) . '">' . $html . '</div>';
    }
}

endif;
