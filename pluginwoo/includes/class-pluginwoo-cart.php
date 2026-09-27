<?php
/**
 * PluginWoo Cart Class.
 * Customizes cart layout templates.
 */

if ( ! class_exists( 'PluginWoo_Cart' ) ) :

class PluginWoo_Cart {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_cart_assets' ) );
    }

    public function load_cart_assets() {
        if ( ! is_cart() ) {
            return;
        }
        wp_enqueue_style(
            'pluginwoo-cart-custom',
            PLUGINWOO_ASSETS_URL . 'css/cart.css',
            array(),
            PLUGINWOO_VERSION
        );
    }

    public static function get_template_path( $template ) {
        $file = PLUGINWOO_TEMPLATE_DIR . "cart/cart-{$template}.php";
        if ( file_exists( $file ) ) {
            return $file;
        }
        return PLUGINWOO_TEMPLATE_DIR . 'cart/cart-default.php';
    }
}

endif;
