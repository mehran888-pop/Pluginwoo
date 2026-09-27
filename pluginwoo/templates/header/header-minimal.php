<?php
/**
 * Template: Minimal Header
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$cart_count = WC()->cart->get_cart_contents_count();
?>
<header class="pluginwoo-header pluginwoo-header--minimal" role="banner">
    <div class="pw-hdr-inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pw-hdr-logo"
           style="font-size:17px;font-weight:700;color:var(--pw-text);text-decoration:none;font-family:var(--pw-font);">
            <?php echo esc_html( get_bloginfo( 'name' ) ?: 'فروشگاه' ); ?>
        </a>

        <nav class="pw-hdr-nav" aria-label="<?php esc_attr_e( 'Navigation', 'pluginwoo' ); ?>">
            <?php wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => '',
                'fallback_cb'    => 'pluginwoo_default_nav',
            ) ); ?>
        </nav>

        <div class="pw-hdr-actions" style="display:flex;align-items:center;gap:8px;">
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
               style="text-decoration:none;color:var(--pw-primary);font-size:13px;font-weight:600;font-family:var(--pw-font);padding:6px 10px;border-radius:var(--pw-radius-sm);transition:all .15s;"
               aria-label="<?php esc_attr_e( 'Cart', 'pluginwoo' ); ?>">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm13-2h-4v-2h-4v2H2v-4h2v10zm0-12h-4V4h-4v2H2v4h2v4zm0 4h-4v2H2v-2H0v-4h2v4zm11-5H9v2h4V7zm-4 2h2v2h-2V9zm6 6h-2v2h2v-2zm-2-6h-2V9h2v2z"/></svg>
                <?php if ( $cart_count > 0 ) : ?>
                <span style="font-weight:700;font-size:13px;"><?php echo esc_html( $cart_count ); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo esc_url( wc_get_account_endpoint_url() ); ?>"
               style="text-decoration:none;color:var(--pw-text-muted);font-size:13px;font-family:var(--pw-font);padding:6px 10px;border-radius:var(--pw-radius-sm);transition:all .15s;"
               aria-label="<?php esc_attr_e( 'Account', 'pluginwoo' ); ?>">
                حساب
            </a>
        </div>
    </div>
</header>
