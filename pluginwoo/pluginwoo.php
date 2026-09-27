<?php
/**
 * Plugin Name:       PluginWoo - Professional WooCommerce Templates & Elements
 * Plugin URI:        https://pluginwoo.com
 * Description:       افزونه حرفه‌ای ووکامرسی با قالب‌های متفاوت سبد خرید، صورتحساب، پنل کاربری، المان‌های اختصاصی، بنر، افکت سبد خرید، تلگرام و ناو موبایل
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            PluginWoo Team
 * Author URI:        https://pluginwoo.com
 * License:           GPL v2 or later
 * Text Domain:       pluginwoo
 * Domain Path:       languages
 * WooCommerce Tested: 11.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define plugin constants.
define( 'PLUGINWOO_VERSION', '1.0.0' );
define( 'PLUGINWOO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLUGINWOO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PLUGINWOO_ASSETS_URL', PLUGINWOO_PLUGIN_URL . 'assets/' );
define( 'PLUGINWOO_TEMPLATE_DIR', PLUGINWOO_PLUGIN_DIR . 'templates/' );

// Check for WooCommerce.
if ( ! class_exists( 'WooCommerce' ) ) {
    add_action( 'admin_notices', 'pluginwoo_wc_missing_notice' );
    return;
}

// Load classes.
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-admin.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-cart.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-checkout.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-myaccount.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-product-display.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-banner.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-product-banner.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-add-to-cart-effect.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-header-footer.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-store-page.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-product-page.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-telegram.php';
require_once PLUGINWOO_PLUGIN_DIR . 'includes/class-pluginwoo-mobile-nav.php';

/**
 * Helper function to get the main plugin instance.
 */
function pluginwoo() {
    static $instance = null;
    if ( null === $instance ) {
        $instance = new PluginWoo();
    }
    return $instance;
}

/**
 * Admin notice if WooCommerce is missing.
 */
function pluginwoo_wc_missing_notice() {
    ?>
    <div class="notice notice-error">
        <p><?php esc_html_e( 'PluginWoo requires WooCommerce to be installed and activated.', 'pluginwoo' ); ?></p>
    </div>
    <?php
}

// Initialize on plugins_loaded.
add_action( 'plugins_loaded', 'pluginwoo_init', 10 );
function pluginwoo_init() {
    // Init text domain.
    load_plugin_textdomain( 'pluginwoo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

    pluginwoo()->init();
}
