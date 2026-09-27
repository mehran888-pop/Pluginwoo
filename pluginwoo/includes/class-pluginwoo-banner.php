<?php
/**
 * PluginWoo Banner Element Class.
 * Shortcode: [pluginwoo_banner banner_id="123" template="default|creative" link="" height="400"]
 */

if ( ! class_exists( 'PluginWoo_Banner' ) ) :

class PluginWoo_Banner {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
    }

    public function load_assets() {
        if ( has_shortcode( get_post()->post_content ?? '', 'pluginwoo_banner' ) ) {
            wp_enqueue_style(
                'pluginwoo-banner-custom',
                PLUGINWOO_ASSETS_URL . 'css/banner.css',
                array(),
                PLUGINWOO_VERSION
            );
        }
    }

    /**
     * Get banner post by ID or query latest.
     */
    public static function get_banner( $banner_id ) {
        if ( ! empty( $banner_id ) ) {
            $post = get_post( absint( $banner_id ) );
            if ( $post && 'pluginwoo_banner' === $post->post_type ) {
                return $post;
            }
        }
        // Fallback: latest banner.
        $posts = get_posts( array(
            'post_type'      => 'pluginwoo_banner',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
        ) );
        return $posts ? $posts[0] : false;
    }
}

endif;
