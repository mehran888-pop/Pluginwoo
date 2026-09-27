<?php
/**
 * PluginWoo Add to Cart Effect Class.
 * AJAX-driven creative effects when products are added to cart.
 */

if ( ! class_exists( 'PluginWoo_Add_To_Cart_Effect' ) ) :

class PluginWoo_Add_To_Cart_Effect {

    public function __construct() {
        add_action( 'wp_ajax_pluginwoo_atc_start', array( $this, 'atc_start_ajax' ) );
        add_action( 'wp_ajax_nopriv_pluginwoo_atc_start', array( $this, 'atc_start_ajax' ) );
        add_action( 'wp_ajax_pluginwoo_atc_finish', array( $this, 'atc_finish_ajax' ) );
        add_action( 'wp_ajax_nopriv_pluginwoo_atc_finish', array( $this, 'atc_finish_ajax' ) );
        add_filter( 'woocommerce_single_product_summary', array( $this, 'wrap_add_to_cart_button' ), 5 );
    }

    /**
     * Wrap the add-to-cart button with tracking data.
     */
    public function wrap_add_to_cart_button( $content ) {
        if ( ! is_product() ) {
            return $content;
        }
        $product = wc_get_product();
        if ( ! $product ) {
            return $content;
        }
        $pid = $product->get_id();

        // Only add if ATC effect is enabled.
        $settings = get_option( 'pluginwoo_settings', array() );
        if ( empty( $settings['atc_effect_enabled'] ) ) {
            return $content;
        }

        return str_replace(
            '<div class="woocommerce-product-details">',
            '<div class="woocommerce-product-details pluginwoo-atc-target" ' .
            'data-product-id="' . esc_attr( $pid ) . '" ' .
            'data-nonce="' . esc_attr( wp_create_nonce( 'pluginwoo_atc_nonce_' . $pid ) ) . '">',
            $content
        );
    }

    public function atc_start_ajax() {
        check_ajax_referer( 'pluginwoo_atc_nonce', 'nonce' );

        $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
        if ( ! $product_id ) {
            wp_send_json_error( 'Invalid product' );
        }

        $product = wc_get_product( $product_id );
        if ( ! $product ) {
            wp_send_json_error( 'Product not found' );
        }

        // Start animation state.
        wp_send_json_success( array(
            'status'    => 'start',
            'product_id' => $product_id,
            'product_name' => $product->get_name(),
            'product_price' => $product->get_price(),
            'product_image' => $product->get_image_id(),
            'settings' => get_option( 'pluginwoo_settings', array() ),
        ) );
    }

    public function atc_finish_ajax() {
        check_ajax_referer( 'pluginwoo_atc_nonce', 'nonce' );

        $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
        $quantity   = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1;

        if ( ! $product_id ) {
            wp_send_json_error( 'Invalid product' );
        }

        // Add to cart programmatically.
        $cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity );

        if ( $cart_item_key ) {
            do_action( 'woocommerce_add_to_cart', $product_id, $quantity, $cart_item_key );
        }

        wp_send_json_success( array(
            'status'    => 'finish',
            'cart_hash' => WC()->cart->get_cart_hash(),
            'cart_url'  => wc_get_cart_url(),
        ) );
    }
}

endif;
