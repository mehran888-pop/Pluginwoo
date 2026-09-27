<?php
/**
 * Core Plugin Class.
 * mane core class for PluginWoo.
 */

if ( ! class_exists( 'PluginWoo' ) ) :

class PluginWoo {

    /**
     * The single instance of the class.
     */
    private static $instance = null;

    /**
     * Settings instance.
     */
    public $settings = null;

    /**
     * Get instance.
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor.
     */
    public function __construct() {
        $this->setup_hooks();
    }

    /**
     * Init the plugin.
     */
    public function init() {
        // Load settings.
        $this->settings = new PluginWoo_Admin_Settings();
        $this->settings->init();

        // Register activation/deactivation hooks.
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
    }

    /**
     * Setup action and filter hooks.
     */
    private function setup_hooks() {
        // Shortcodes.
        add_shortcode( 'pluginwoo_cart', array( $this, 'render_cart_shortcode' ) );
        add_shortcode( 'pluginwoo_checkout', array( $this, 'render_checkout_shortcode' ) );
        add_shortcode( 'pluginwoo_myaccount', array( $this, 'render_myaccount_shortcode' ) );
        add_shortcode( 'pluginwoo_product_display', array( $this, 'render_product_display_shortcode' ) );
        add_shortcode( 'pluginwoo_banner', array( $this, 'render_banner_shortcode' ) );
        add_shortcode( 'pluginwoo_product_banner', array( $this, 'render_product_banner_shortcode' ) );
        add_shortcode( 'pluginwoo_store_page', array( $this, 'render_store_page_shortcode' ) );
        add_shortcode( 'pluginwoo_product_page_alt', array( $this, 'render_product_page_alt_shortcode' ) );
        add_shortcode( 'pluginwoo_header', array( $this, 'render_header_shortcode' ) );
        add_shortcode( 'pluginwoo_footer', array( $this, 'render_footer_shortcode' ) );
        add_shortcode( 'pluginwoo_mobile_nav', array( $this, 'render_mobile_nav_shortcode' ) );

        // Filters.
        add_filter( 'woocommerce_cart_page_template', array( $this, 'override_cart_template' ) );
        add_filter( 'woocommerce_checkout_page_template', array( $this, 'override_checkout_template' ) );
        add_filter( 'woocommerce_account_page_template', array( $this, 'override_myaccount_template' ) );
        add_filter( 'woocommerce_shop_page_template', array( $this, 'override_shop_template' ) );
        add_filter( 'woocommerce_single_product_page_template', array( $this, 'override_single_product_template' ) );
        add_filter( 'woocommerce_locate_template', array( $this, 'locate_custom_template' ), 10, 3 );
        add_filter( 'woocommerce_add_to_cart_message', array( $this, 'add_to_cart_custom_message' ), 10, 2 );
        add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );
        add_filter( 'pluginwoo_settings_array', array( $this, 'define_settings' ) );

        // Admin enqueues.
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

        // Frontend enqueues.
        add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ) );

        // AJAX for add-to-cart effects.
        add_action( 'wp_ajax_nopriv_pluginwoo_atc_animation', array( $this, 'atc_animation_ajax' ) );
        add_action( 'wp_ajax_pluginwoo_atc_animation', array( $this, 'atc_animation_ajax' ) );

        // Mobile nav detection.
        add_action( 'wp_footer', array( $this, 'render_mobile_nav_footer' ) );

        // Telegram webhook.
        add_action( 'rest_api_init', array( $this, 'register_telegram_webhook' ) );

        // Register custom post type for banners.
        add_action( 'init', array( $this, 'register_banner_cpt' ) );
    }

    /**
     * Plugin activation.
     */
    public function activate() {
        // Flush rewrite rules for CPT.
        $this->register_banner_cpt();
        flush_rewrite_rules();
        // Create default settings.
        if ( ! get_option( 'pluginwoo_settings' ) ) {
            add_option( 'pluginwoo_settings', $this->get_default_settings() );
        }
    }

    /**
     * Plugin deactivation.
     */
    public function deactivate() {
        flush_rewrite_rules();
    }

    /**
     * Register banner custom post type.
     */
    public function register_banner_cpt() {
        register_post_type( 'pluginwoo_banner', array(
            'labels' => array(
                'name'          => __( 'Banners', 'pluginwoo' ),
                'singular_name' => __( 'Banner', 'pluginwoo' ),
                'add_new'       => __( 'Add New', 'pluginwoo' ),
                'add_new_item'  => __( 'Add New Banner', 'pluginwoo' ),
                'edit_item'     => __( 'Edit Banner', 'pluginwoo' ),
                'search_items'  => __( 'Search Banners', 'pluginwoo' ),
                'not_found'     => __( 'No banners found', 'pluginwoo' ),
            ),
            'public'       => true,
            'show_ui'      => true,
            'show_in_menu' => 'upload.php',
            'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'has_archive'  => true,
            'menu_icon'    => 'dashicons-images-alt2',
            'rewrite'      => array( 'slug' => 'banners' ),
        ) );
    }

    /**
     * Default settings array.
     */
    public function get_default_settings() {
        return array(
            'cart_template'        => 'modern',
            'checkout_template'    => 'modern',
            'myaccount_template'   => 'modern',
            'header_template'      => 'modern',
            'footer_template'      => 'modern',
            'store_page_template'  => 'creative',
            'product_page_template' => 'modern',
            'mobile_nav_enabled'   => 1,
            'telegram_token'       => '',
            'telegram_chat_id'     => '',
            'atc_effect_enabled'   => 1,
            'atc_effect_type'      => 'fly',
            'custom_css'           => '',
            'primary_color'        => '#4f46e5',
            'secondary_color'      => '#10b981',
            'accent_color'         => '#f59e0b',
            'font_family'          => 'Vazirmatn',
        );
    }

    /**
     * Define settings fields.
     */
    public function define_settings( $settings ) {
        $settings = array();

        // Layout Section.
        $settings[] = array(
            'title' => __( 'قالب‌های آماده', 'pluginwoo' ),
            'fields' => array(
                array(
                    'id'      => 'cart_template',
                    'label'   => __( 'قالب سبد خرید', 'pluginwoo' ),
                    'type'    => 'select',
                    'options' => array(
                        'default'  => __( 'پیش‌فرض', 'pluginwoo' ),
                        'modern'   => __( 'مدرن', 'pluginwoo' ),
                        'minimal'  => __( 'مینیمال', 'pluginwoo' ),
                        'sidebar'  => __( 'سایدبار', 'pluginwoo' ),
                    ),
                    'default' => 'modern',
                ),
                array(
                    'id'      => 'checkout_template',
                    'label'   => __( 'قالب صفحه صورت‌حساب', 'pluginwoo' ),
                    'type'    => 'select',
                    'options' => array(
                        'default'  => __( 'پیش‌فرض', 'pluginwoo' ),
                        'modern'   => __( 'مدرن', 'pluginwoo' ),
                        'minimal'  => __( 'مینیمال', 'pluginwoo' ),
                        'sidebar'  => __( 'سایدبار', 'pluginwoo' ),
                    ),
                    'default' => 'modern',
                ),
                array(
                    'id'      => 'myaccount_template',
                    'label'   => __( 'قالب پنل کاربری', 'pluginwoo' ),
                    'type'    => 'select',
                    'options' => array(
                        'default'  => __( 'پیش‌فرض', 'pluginwoo' ),
                        'modern'   => __( 'مدرن', 'pluginwoo' ),
                        'minimal'  => __( 'مینیمال', 'pluginwoo' ),
                    ),
                    'default' => 'modern',
                ),
                array(
                    'id'      => 'header_template',
                    'label'   => __( 'قالب هدر', 'pluginwoo' ),
                    'type'    => 'select',
                    'options' => array(
                        'default'  => __( 'پیش‌فرض', 'pluginwoo' ),
                        'modern'   => __( 'مدرن', 'pluginwoo' ),
                        'minimal'  => __( 'مینیمال', 'pluginwoo' ),
                        'creative' => __( 'خلاقانه', 'pluginwoo' ),
                    ),
                    'default' => 'modern',
                ),
                array(
                    'id'      => 'footer_template',
                    'label'   => __( 'قالب فوتر', 'pluginwoo' ),
                    'type'    => 'select',
                    'options' => array(
                        'default'  => __( 'پیش‌فرض', 'pluginwoo' ),
                        'modern'   => __( 'مدرن', 'pluginwoo' ),
                        'minimal'  => __( 'مینیمال', 'pluginwoo' ),
                    ),
                    'default' => 'modern',
                ),
                array(
                    'id'      => 'store_page_template',
                    'label'   => __( 'قالب صفحه فروشگاه', 'pluginwoo' ),
                    'type'    => 'select',
                    'options' => array(
                        'default'   => __( 'پیش‌فرض', 'pluginwoo' ),
                        'modern'    => __( 'مدرن', 'pluginwoo' ),
                        'creative'  => __( 'خلاقانه', 'pluginwoo' ),
                    ),
                    'default' => 'creative',
                ),
                array(
                    'id'      => 'product_page_template',
                    'label'   => __( 'قالب صفحه محصول', 'pluginwoo' ),
                    'type'    => 'select',
                    'options' => array(
                        'default'   => __( 'پیش‌فرض', 'pluginwoo' ),
                        'modern'    => __( 'مدرن', 'pluginwoo' ),
                        'creative'  => __( 'خلاقانه', 'pluginwoo' ),
                    ),
                    'default' => 'modern',
                ),
            ),
        );

        // Visual Customization.
        $settings[] = array(
            'title' => __( 'شخصی‌سازی بصری', 'pluginwoo' ),
            'fields' => array(
                array(
                    'id'      => 'primary_color',
                    'label'   => __( 'رنگ اصلی', 'pluginwoo' ),
                    'type'    => 'color',
                    'default' => '#4f46e5',
                ),
                array(
                    'id'      => 'secondary_color',
                    'label'   => __( 'رنگ دوم', 'pluginwoo' ),
                    'type'    => 'color',
                    'default' => '#10b981',
                ),
                array(
                    'id'      => 'accent_color',
                    'label'   => __( 'رنگTl emphasis', 'pluginwoo' ),
                    'type'    => 'color',
                    'default' => '#f59e0b',
                ),
                array(
                    'id'      => 'font_family',
                    'label'   => __( 'فونت پیش‌فرض', 'pluginwoo' ),
                    'type'    => 'select',
                    'options' => array(
                        'Vazirmatn'   => __( 'وزیرمتن', 'pluginwoo' ),
                        'Shabnam'     => __( 'شبنم', 'pluginwoo' ),
                        'YekanBakh'   => __( 'یکان بخش', 'pluginwoo' ),
                        'Lalezar'     => __( 'لززار', 'pluginwoo' ),
                        'Vazir'       => __( 'وزیر', 'pluginwoo' ),
                    ),
                    'default' => 'Vazirmatn',
                ),
            ),
        );

        // Effects & Integrations.
        $settings[] = array(
            'title' => __( 'افکت‌ها و یکپارچگی‌ها', 'pluginwoo' ),
            'fields' => array(
                array(
                    'id'      => 'atc_effect_enabled',
                    'label'   => __( 'فعال‌سازی افکت اضافه شدن به سبد خرید', 'pluginwoo' ),
                    'type'    => 'checkbox',
                    'default' => 1,
                ),
                array(
                    'id'      => 'atc_effect_type',
                    'label'   => __( 'نوع افکت', 'pluginwoo' ),
                    'type'    => 'select',
                    'options' => array(
                        'fly'     => __( ' پروانه پروازی', 'pluginwoo' ),
                        'bounce'  => __( ' باز۶ میوه', 'pluginwoo' ),
                        'pulse'   => __( ' پالس انرژی', 'pluginwoo' ),
                    ),
                    'default' => 'fly',
                ),
                array(
                    'id'      => 'mobile_nav_enabled',
                    'label'   => __( 'ناو موبایل (جایگزین فوتر در موبایل)', 'pluginwoo' ),
                    'type'    => 'checkbox',
                    'default' => 1,
                ),
                array(
                    'id'      => 'telegram_token',
                    'label'   => __( 'توکن ربات تلگرام', 'pluginwoo' ),
                    'type'    => 'text',
                    'desc'    => __( 'دنباله توکن ربات از @BotFather', 'pluginwoo' ),
                    'default' => '',
                ),
                array(
                    'id'      => 'telegram_chat_id',
                    'label'   => __( 'شناسه کانال تلگرام', 'pluginwoo' ),
                    'type'    => 'text',
                    'desc'    => __( 'شناسه Canal از @GetIDsbot — برای بله‌ وبz استفاده از @BotFather و ربات تلگرامی', 'pluginwoo' ),
                    'default' => '',
                ),
            ),
        );

        // Custom CSS.
        $settings[] = array(
            'title' => __( 'CSS اختصاصی', 'pluginwoo' ),
            'fields' => array(
                array(
                    'id'      => 'custom_css',
                    'label'   => __( 'کد CSS اختصاصی', 'pluginwoo' ),
                    'type'    => 'textarea',
                    'desc'    => __( 'کد CSS مورد نظر خود را اینجا وارد کنید…', 'pluginwoo' ),
                    'default' => '',
                    'sanitize' => 'wp_kses_data',
                ),
            ),
        );

        return $settings;
    }

    // ─── Shortcodes ─────────────────────────────────────────────────────────

    public function render_cart_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'template' => 'modern',
        ), $atts, 'pluginwoo_cart' );

        ob_start();
        $this->include_template( 'cart/cart-' . sanitize_key( $atts['template'] ) . '.php', array( 'shortcode' => true ) );
        return ob_get_clean();
    }

    public function render_checkout_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'template' => 'modern',
        ), $atts, 'pluginwoo_checkout' );

        ob_start();
        $this->include_template( 'checkout/checkout-' . sanitize_key( $atts['template'] ) . '.php' );
        return ob_get_clean();
    }

    public function render_myaccount_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'template' => 'modern',
        ), $atts, 'pluginwoo_myaccount' );

        ob_start();
        $this->include_template( 'myaccount/myaccount-' . sanitize_key( $atts['template'] ) . '.php' );
        return ob_get_clean();
    }

    public function render_product_display_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'type'      => 'carousel',
            'ids'       => '',
            'category'  => '',
            'per_page'  => 8,
            'columns'   => 4,
            'template'  => 'default',
        ), $atts, 'pluginwoo_product_display' );

        ob_start();
        $this->include_template( 'product-display/' . sanitize_key( $atts['type'] ) . '.php', array(
            'atts'     => $atts,
            'shortcode' => true,
        ) );
        return ob_get_clean();
    }

    public function render_banner_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'id'       => '',
            'banner_id' => '',
            'template' => 'default',
            'link'     => '',
            'height'   => '400',
        ), $atts, 'pluginwoo_banner' );

        ob_start();
        $this->include_template( 'banner/banner-' . sanitize_key( $atts['template'] ) . '.php', array(
            'banner_id' => $atts['banner_id'],
            'banner_link' => $atts['link'],
            'banner_height' => $atts['height'],
            'shortcode' => true,
        ) );
        return ob_get_clean();
    }

    public function render_product_banner_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'product_id' => '',
            'template'   => 'default',
        ), $atts, 'pluginwoo_product_banner' );

        ob_start();
        $this->include_template( 'product-banner/product-banner-' . sanitize_key( $atts['template'] ) . '.php', array(
            'product_id' => $atts['product_id'],
            'shortcode' => true,
        ) );
        return ob_get_clean();
    }

    public function render_store_page_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'template' => 'creative',
        ), $atts, 'pluginwoo_store_page' );

        ob_start();
        $this->include_template( 'store-page/store-' . sanitize_key( $atts['template'] ) . '.php' );
        return ob_get_clean();
    }

    public function render_product_page_alt_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'product_id' => '',
            'template'   => 'modern',
        ), $atts, 'pluginwoo_product_page_alt' );

        ob_start();
        $this->include_template( 'product-page/product-' . sanitize_key( $atts['template'] ) . '.php', array(
            'product_id' => $atts['product_id'],
            'shortcode' => true,
        ) );
        return ob_get_clean();
    }

    public function render_header_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'template' => 'modern',
        ), $atts, 'pluginwoo_header' );

        ob_start();
        $this->include_template( 'header/header-' . sanitize_key( $atts['template'] ) . '.php' );
        return ob_get_clean();
    }

    public function render_footer_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'template' => 'modern',
        ), $atts, 'pluginwoo_footer' );

        ob_start();
        $this->include_template( 'footer/footer-' . sanitize_key( $atts['template'] ) . '.php' );
        return ob_get_clean();
    }

    public function render_mobile_nav_shortcode( $atts ) {
        ob_start();
        $this->include_template( 'mobile-nav/mobile-nav.php' );
        return ob_get_clean();
    }

    // ─── Template Overrides ─────────────────────────────────────────────────

    public function override_cart_template( $template ) {
        $selected = $this->get_setting( 'cart_template' );
        $custom   = $this->get_custom_template_path( 'cart/cart-' . $selected . '.php' );
        if ( $custom ) {
            return $custom;
        }
        return $template;
    }

    public function override_checkout_template( $template ) {
        $selected = $this->get_setting( 'checkout_template' );
        $custom   = $this->get_custom_template_path( 'checkout/checkout-' . $selected . '.php' );
        if ( $custom ) {
            return $custom;
        }
        return $template;
    }

    public function override_myaccount_template( $template ) {
        $selected = $this->get_setting( 'myaccount_template' );
        $custom   = $this->get_custom_template_path( 'myaccount/myaccount-' . $selected . '.php' );
        if ( $custom ) {
            return $custom;
        }
        return $template;
    }

    public function override_shop_template( $template ) {
        $selected = $this->get_setting( 'store_page_template' );
        $custom   = $this->get_custom_template_path( 'store-page/store-' . $selected . '.php' );
        if ( $custom ) {
            return $custom;
        }
        return $template;
    }

    public function override_single_product_template( $template ) {
        $selected = $this->get_setting( 'product_page_template' );
        $custom   = $this->get_custom_template_path( 'product-page/product-' . $selected . '.php' );
        if ( $custom ) {
            return $custom;
        }
        return $template;
    }

    public function locate_custom_template( $template, $template_name, $template_path ) {
        // Only intercept our templates.
        if ( strpos( $template_name, 'pluginwoo' ) !== 0 ) {
            return $template;
        }
        $selected = $this->get_setting( str_replace( 'pluginwoo_', '', $template_name ) . '_template' );
        if ( $selected ) {
            $custom = $this->get_custom_template_path( $template_name . '-' . $selected . '.php' );
            if ( $custom ) {
                return $custom;
            }
        }
        return $template;
    }

    // ─── Add to Cart Effects ───────────────────────────────────────────────

    public function add_to_cart_custom_message( $message, $products ) {
        if ( ! $this->get_setting( 'atc_effect_enabled' ) ) {
            return $message;
        }
        return $message;
    }

    public function add_to_cart_fragments( $fragments ) {
        if ( ! $this->get_setting( 'atc_effect_enabled' ) ) {
            return $fragments;
        }
        // Add custom data for animation.
        $fragments['div.widget_shopping_cart'] = wc_get_template_html(
            'cart/mini-cart.php',
            array(
                'cart_page_url' => wc_get_cart_url(),
                'should_load_cart_fragments' => true,
                'cart_hash' => wc_clean( WC()->cart->get_cart_hash() ),
            ),
            '',
            'pluginwoo'
        );
        $fragments['div#atc-notification'] = '<div id="pluginwoo-atc-notification" class="pluginwoo-atc-notification" style="display:none;"></div>';
        return $fragments;
    }

    public function atc_animation_ajax() {
        check_ajax_referer( 'pluginwoo_atc_nonce', 'nonce' );

        $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
        $quantity   = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1;
        $effect     = $this->get_setting( 'atc_effect_type' );

        if ( ! $product_id ) {
            wp_send_json_error( 'Invalid product ID' );
        }

        // Find DOM element position if possible.
        $product_el = isset( $_POST['element'] ) ? sanitize_text_field( $_POST['element'] ) : '';

        wp_send_json_success( array(
            'product_id' => $product_id,
            'quantity'   => $quantity,
            'effect'     => $effect,
        ) );
    }

    // ─── Mobile Nav ─────────────────────────────────────────────────────────

    public function render_mobile_nav_footer() {
        if ( ! $this->get_setting( 'mobile_nav_enabled' ) ) {
            return;
        }
        // Only on mobile.
        if ( ! wp_is_mobile() ) {
            return;
        }
        // Don't render if a footer shortcode is already in use (let user decide).
        if ( is_page_template() || is_singular() ) {
            // Still render unless explicitly disabled.
        }
        include PLUGINWOO_TEMPLATE_DIR . 'mobile-nav/mobile-nav.php';
    }

    // ─── Telegram Webhook ───────────────────────────────────────────────────

    public function register_telegram_webhook() {
        // Simple webhook handler via WP REST.
        // In production, register a proper webhook endpoint.
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    public function include_template( $template, $data = array() ) {
        $path = PLUGINWOO_TEMPLATE_DIR . $template;
        if ( file_exists( $path ) ) {
            if ( ! empty( $data ) ) {
                extract( $data );
            }
            include $path;
        }
    }

    public function get_custom_template_path( $template ) {
        $path = PLUGINWOO_TEMPLATE_DIR . $template;
        if ( file_exists( $path ) ) {
            return $path;
        }
        return false;
    }

    public function get_setting( $key ) {
        $settings = get_option( 'pluginwoo_settings', array() );
        return isset( $settings[ $key ] ) ? $settings[ $key ] : '';
    }

    public function admin_scripts() {
        $screen = get_current_screen();
        if ( $screen && strpos( $screen->id, 'pluginwoo' ) !== false ) {
            wp_enqueue_style(
                'pluginwoo-admin-css',
                PLUGINWOO_ASSETS_URL . 'css/admin.css',
                array(),
                PLUGINWOO_VERSION
            );
        }
    }

    public function frontend_scripts() {
        if ( ! $this->is_pluginwoo_used() ) {
            return;
        }
        wp_enqueue_script(
            'pluginwoo-utils',
            PLUGINWOO_ASSETS_URL . 'js/utils.js',
            array( 'jquery' ),
            PLUGINWOO_VERSION,
            true
        );
        if ( $this->get_setting( 'atc_effect_enabled' ) ) {
            wp_enqueue_script(
                'pluginwoo-atc',
                PLUGINWOO_ASSETS_URL . 'js/add-to-cart.js',
                array( 'jquery' ),
                PLUGINWOO_VERSION,
                true
            );
            wp_localize_script( 'pluginwoo-atc', 'pluginwooAtc', array(
                'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
                'nonce'     => wp_create_nonce( 'pluginwoo_atc_nonce' ),
                'effect'    => $this->get_setting( 'atc_effect_type' ),
            ) );
        }
        if ( $this->get_setting( 'mobile_nav_enabled' ) && wp_is_mobile() ) {
            wp_enqueue_script(
                'pluginwoo-mobile-nav',
                PLUGINWOO_ASSETS_URL . 'js/mobile-nav.js',
                array( 'jquery' ),
                PLUGINWOO_VERSION,
                true
            );
        }
        wp_enqueue_script(
            'pluginwoo-main',
            PLUGINWOO_ASSETS_URL . 'js/main.js',
            array( 'jquery' ),
            PLUGINWOO_VERSION,
            true
        );
    }

    public function frontend_styles() {
        if ( ! $this->is_pluginwoo_used() ) {
            return;
        }
        wp_enqueue_style(
            'pluginwoo-main',
            PLUGINWOO_ASSETS_URL . 'css/main.css',
            array(),
            PLUGINWOO_VERSION
        );
        wp_enqueue_style(
            'pluginwoo-cart',
            PLUGINWOO_ASSETS_URL . 'css/cart.css',
            array( 'pluginwoo-main' ),
            PLUGINWOO_VERSION
        );
        wp_enqueue_style(
            'pluginwoo-checkout',
            PLUGINWOO_ASSETS_URL . 'css/checkout.css',
            array( 'pluginwoo-main' ),
            PLUGINWOO_VERSION
        );
        wp_enqueue_style(
            'pluginwoo-myaccount',
            PLUGINWOO_ASSETS_URL . 'css/myaccount.css',
            array( 'pluginwoo-main' ),
            PLUGINWOO_VERSION
        );
        wp_enqueue_style(
            'pluginwoo-product-display',
            PLUGINWOO_ASSETS_URL . 'css/product-display.css',
            array( 'pluginwoo-main' ),
            PLUGINWOO_VERSION
        );
        wp_enqueue_style(
            'pluginwoo-banner',
            PLUGINWOO_ASSETS_URL . 'css/banner.css',
            array( 'pluginwoo-main' ),
            PLUGINWOO_VERSION
        );
        wp_enqueue_style(
            'pluginwoo-product-banner',
            PLUGINWOO_ASSETS_URL . 'css/product-banner.css',
            array( 'pluginwoo-main' ),
            PLUGINWOO_VERSION
        );
        wp_enqueue_style(
            'pluginwoo-store-page',
            PLUGINWOO_ASSETS_URL . 'css/store-page.css',
            array( 'pluginwoo-main' ),
            PLUGINWOO_VERSION
        );
        wp_enqueue_style(
            'pluginwoo-product-page',
            PLUGINWOO_ASSETS_URL . 'css/product-page.css',
            array( 'pluginwoo-main' ),
            PLUGINWOO_VERSION
        );
        wp_enqueue_style(
            'pluginwoo-mobile-nav',
            PLUGINWOO_ASSETS_URL . 'css/mobile-nav.css',
            array( 'pluginwoo-main' ),
            PLUGINWOO_VERSION
        );
        wp_enqueue_style(
            'pluginwoo-header-footer',
            PLUGINWOO_ASSETS_URL . 'css/header-footer.css',
            array( 'pluginwoo-main' ),
            PLUGINWOO_VERSION
        );
        // Custom CSS from settings.
        $custom_css = $this->get_setting( 'custom_css' );
        if ( ! empty( $custom_css ) ) {
            wp_add_inline_style( 'pluginwoo-main', $custom_css );
        }
    }

    private function is_pluginwoo_used() {
        global $post;
        if ( ! $post ) {
            return false;
        }
        // Check content for shortcodes.
        if ( has_shortcode( $post->post_content, 'pluginwoo_' ) ) {
            return true;
        }
        // Check if on WooCommerce pages.
        if ( is_cart() || is_checkout() || is_account_page() || is_shop() || is_product() ) {
            return true;
        }
        return false;
    }
}

endif;
