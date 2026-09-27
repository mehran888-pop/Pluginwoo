<?php
/**
 * Template: Modern Header
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$has_wc     = function_exists( 'WC' );
$cart_count = $has_wc && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
$account_url = $has_wc ? wc_get_account_endpoint_url() : home_url( 'my-account' );
$checkout_url = $has_wc ? wc_get_checkout_url() : home_url( 'checkout' );
$cart_url      = $has_wc ? wc_get_cart_url() : home_url( 'cart' );
?>
<header class="pluginwoo-header pluginwoo-header--modern" role="banner">
    <div class="pw-hdr-inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pw-hdr-logo"
           style="font-size:22px;font-weight:800;color:#fff;text-decoration:none;font-family:var(--pw-font);letter-spacing:.01em;">
            <?php echo esc_html( get_bloginfo( 'name' ) ?: 'فروشگاه ما' ); ?>
        </a>

        <nav class="pw-hdr-nav" aria-label="<?php esc_attr_e( 'Main navigation', 'pluginwoo' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => '',
                'fallback_cb'    => 'pluginwoo_default_nav',
            ) );
            ?>
        </nav>

        <div class="pw-hdr-actions">
            <?php if ( $has_wc ) : ?>
            <a href="<?php echo esc_url( $account_url ); ?>"
               class="pw-hdr-btn"
               style="padding:8px 16px;border-radius:50px;border:1px solid rgba(255,255,255,.4);background:rgba(255,255,255,.1);cursor:pointer;font-size:13px;font-family:var(--pw-font);font-weight:600;color:#fff;display:flex;align-items:center;gap:6px;transition:all .2s;text-decoration:none;">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <?php esc_html_e( 'اکانت', 'pluginwoo' ); ?>
            </a>
            <a href="<?php echo esc_url( $checkout_url ); ?>"
               class="pw-hdr-btn"
               style="padding:8px 16px;border-radius:50px;border:1px solid rgba(255,255,255,.4);background:rgba(255,255,255,.1);cursor:pointer;font-size:13px;font-family:var(--pw-font);font-weight:600;color:#fff;display:flex;align-items:center;gap:6px;transition:all .2s;text-decoration:none;">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M3 7h6v13H3V7zm9-4h3v13h-3V3zm-3 9h6v3h-6v-3zm0-5h6v3h-6V7z"/></svg>
                <?php esc_html_e( 'صورت‌حساب', 'pluginwoo' ); ?>
            </a>
            <?php endif; ?>
            <a href="<?php echo esc_url( $cart_url ); ?>"
               class="pw-hdr-cart-btn"
               style="position:relative;padding:8px 16px;background:#fff;color:var(--pw-primary);border:none;border-radius:50px;cursor:pointer;display:flex;align-items:center;gap:6px;font-family:var(--pw-font);font-weight:700;transition:all .2s;text-decoration:none;transform:translateY(-1px);"
               aria-label="<?php esc_attr_e( 'My cart', 'pluginwoo' ); ?>">
                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm13-2h-4v-2h-4v2H2v-4h2v10zm0-12h-4V4h-4v2H2v4h2v4zm0 4h-4v2H2v-2H0v-4h2v4zm11-5H9v2h4V7zm-4 2h2v2h-2V9zm6 6h-2v2h2v-2zm-2-6h-2V9h2v2z"/></svg>
                <?php if ( $cart_count > 0 ) : ?>
                <span class="pw-hdr-cart-count" style="background:var(--pw-accent);color:#fff;font-size:11px;font-weight:700;width:18px;height:18px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;">
                    <?php echo esc_html( $cart_count ); ?>
                </span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</header>

<?php
if ( ! function_exists( 'pluginwoo_default_nav' ) ) :
    function pluginwoo_default_nav() {
        $shop_url_fb    = $has_wc ? wc_get_shop_url() : home_url( 'shop' );
        $cart_url_fb   = $has_wc ? wc_get_cart_url() : home_url( 'cart' );
        $account_url_fb = $has_wc ? wc_get_account_endpoint_url() : home_url( 'my-account' );
        ?>
        <ul style="list-style:none;margin:0;padding:0;display:flex;gap:4px;">
            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="text-decoration:none;color:var(--pw-text);font-size:14px;padding:6px 12px;border-radius:var(--pw-radius-sm);transition:all .15s;font-family:var(--pw-font);">خانه</a></li>
            <li><a href="<?php echo esc_url( $shop_url_fb ); ?>" style="text-decoration:none;color:var(--pw-text);font-size:14px;padding:6px 12px;border-radius:var(--pw-radius-sm);transition:all .15s;font-family:var(--pw-font);">فروشگاه</a></li>
            <li><a href="<?php echo esc_url( $cart_url_fb ); ?>" style="text-decoration:none;color:var(--pw-text);font-size:14px;padding:6px 12px;border-radius:var(--pw-radius-sm);transition:all .15s;font-family:var(--pw-font);">سبد خرید</a></li>
            <li><a href="<?php echo esc_url( $account_url_fb ); ?>" style="text-decoration:none;color:var(--pw-text);font-size:14px;padding:6px 12px;border-radius:var(--pw-radius-sm);transition:all .15s;font-family:var(--pw-font);">حساب کاربری</a></li>
        </ul>
        <?php
    }
endif;
