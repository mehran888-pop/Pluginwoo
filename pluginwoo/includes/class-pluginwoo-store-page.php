<?php
/**
 * PluginWoo Store Page Class.
 * Creative and professional store page template.
 */

if ( ! class_exists( 'PluginWoo_Store_Page' ) ) :

class PluginWoo_Store_Page {

    public function __construct() {
        add_filter( 'woocommerce_shop_page_template', array( $this, 'override_shop_template' ) );
        add_filter( 'woocommerce_product_query', array( $this, 'modify_product_query' ) );
    }

    public function override_shop_template( $template ) {
        $settings = get_option( 'pluginwoo_settings', array() );
        $selected = isset( $settings['store_page_template'] ) ? $settings['store_page_template'] : 'creative';

        $file = PLUGINWOO_TEMPLATE_DIR . "store-page/store-{$selected}.php";
        if ( file_exists( $file ) ) {
            return $file;
        }
        return $template;
    }

    public function modify_product_query( $query ) {
        // Allow per-template custom queries.
        $settings = get_option( 'pluginwoo_settings', array() );
        $selected = isset( $settings['store_page_template'] ) ? $settings['store_page_template'] : 'creative';

        if ( 'creative' === $selected ) {
            // Featured products first.
            $query->set( 'meta_key', '_featured' );
            $query->set( 'orderby', array( 'meta_value' => 'DESC', 'date' => 'DESC' ) );
        }
    }
}

endif;
