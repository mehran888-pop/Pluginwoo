<?php
/**
 * PluginWoo Product Page Class.
 * Custom single product page templates.
 */

if ( ! class_exists( 'PluginWoo_Product_Page' ) ) :

class PluginWoo_Product_Page {

    public function __construct() {
        add_filter( 'woocommerce_single_product_page_template', array( $this, 'override_product_template' ) );
    }

    public function override_product_template( $template ) {
        $settings = get_option( 'pluginwoo_settings', array() );
        $selected = isset( $settings['product_page_template'] ) ? $settings['product_page_template'] : 'modern';

        $file = PLUGINWOO_TEMPLATE_DIR . "product-page/product-{$selected}.php";
        if ( file_exists( $file ) ) {
            return $file;
        }
        return $template;
    }
}

endif;
