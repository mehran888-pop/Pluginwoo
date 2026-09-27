<?php
/**
 * PluginWoo Product Display Element Class.
 * Shortcode: [pluginwoo_product_display type="carousel|slider|grid|list" ids="" category="" per_page="8" columns="4" template="default"]
 */

if ( ! class_exists( 'PluginWoo_Product_Display' ) ) :

class PluginWoo_Product_Display {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
    }

    public function load_assets() {
        // Load when shortcode is present on page.
        if ( has_shortcode( get_post()->post_content ?? '', 'pluginwoo_product_display' ) ||
             ( is_shop() || is_product_category() ) ) {
            wp_enqueue_style(
                'pluginwoo-product-display-custom',
                PLUGINWOO_ASSETS_URL . 'css/product-display.css',
                array(),
                PLUGINWOO_VERSION
            );
        }
    }

    /**
     * Get products based on shortcode attributes.
     */
    public static function get_products( $atts ) {
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => isset( $atts['per_page'] ) ? absint( $atts['per_page'] ) : 8,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'status'         => 'publish',
        );

        if ( ! empty( $atts['ids'] ) ) {
            $ids = array_map( 'absint', explode( ',', $atts['ids'] ) );
            if ( ! empty( $ids ) ) {
                $args['post__in'] = $ids;
                $args['orderby']  = 'post__in';
            }
        }

        if ( ! empty( $atts['category'] ) ) {
            $cats = array_map( 'sanitize_text_field', explode( ',', $atts['category'] ) );
            if ( ! empty( $cats ) ) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $cats,
                    ),
                );
            }
        }

        return new WP_Query( $args );
    }
}

endif;
