<?php
/**
 * PluginWoo Product Banner Element Class.
 * Shortcode: [pluginwoo_product_banner product_id="123" template="default|creative"]
 */

if ( ! class_exists( 'PluginWoo_Product_Banner' ) ) :

class PluginWoo_Product_Banner {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
    }

    public function load_assets() {
        if ( has_shortcode( get_post()->post_content ?? '', 'pluginwoo_product_banner' ) ) {
            wp_enqueue_style(
                'pluginwoo-product-banner-custom',
                PLUGINWOO_ASSETS_URL . 'css/product-banner.css',
                array(),
                PLUGINWOO_VERSION
            );
        }
    }

    public static function get_product( $product_id ) {
        $pid = absint( $product_id );
        if ( ! $pid ) {
            return false;
        }
        $product = wc_get_product( $pid );
        return $product;
    }
}

endif;
