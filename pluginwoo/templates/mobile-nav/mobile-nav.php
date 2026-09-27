<?php
/**
 * Template: Mobile Navigation (Bottom Nav Bar)
 * Appears on mobile devices instead of the regular footer.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$home_url    = home_url( '/' );
$shop_url    = wc_get_shop_url();
$cart_url    = wc_get_cart_url();
$account_url = wc_get_account_endpoint_url();
$cart_count  = WC()->cart->get_cart_contents_count();
$home_active = is_front_page() || is_home() || is_main_query();
$shop_active = is_shop() || is_product_category();
$cart_active = is_cart();
$account_active = is_account_page();

// Format page title for nav item.
$home_text   = __( 'خانه', 'pluginwoo' );
$shop_text   = __( 'فروشگاه', 'pluginwoo' );
$cart_text   = __( 'سبد خرید', 'pluginwoo' );
$account_text = __( 'اکانت', 'pluginwoo' );
$contact_text = __( 'تماس', 'pluginwoo' );
?>
<nav class="pluginwoo-mobile-nav"
     role="navigation"
     aria-label="<?php esc_attr_e( 'Mobile navigation', 'pluginwoo' ); ?>">

    <a href="<?php echo esc_url( $home_url ); ?>"
       class="pw-mn-item <?php echo $home_active ? 'active' : ''; ?>"
       data-pw-nav-link="<?php echo esc_url_raw( $home_url ); ?>">
        <span class="pw-mn-icon">
            <svg width="20" height="20" viewBox="0 0 24 24">
                <path fill="currentColor" d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
            </svg>
        </span>
        <span style="font-family:var(--pw-font);"><?php echo $home_text; ?></span>
    </a>

    <a href="<?php echo esc_url( $shop_url ); ?>"
       class="pw-mn-item <?php echo $shop_active ? 'active' : ''; ?>"
       data-pw-nav-link="<?php echo esc_url_raw( $shop_url ); ?>"
       aria-label="<?php esc_attr_e( 'Shop', 'pluginwoo' ); ?>">
        <span class="pw-mn-icon">
            <svg width="20" height="20" viewBox="0 0 24 24">
                <path fill="currentColor" d="M4 8h16v12.785c0 .538-.404.976-.905.976H4.905c-.5 0-.905-.438-.905-.976V8zm16 .712V20H4V8h16v.712c0 .636-.433 1.137-.99 1.268l.07.022c.228.056.352.326.126.326H4.174c-.226 0-.1.27-.1.27v.002l.001-.001h.042c.219.066.462.154.707.262l.015.006c.234.076.412.348.336.582.135 1.609 1.381 2.887 2.994 2.887 1.463 0 2.673 1.065 2.908 2.4.036.186.21.324.44.288l.014-.012c.106-.093.195-.196.274-.31.178-.258.3-.616.3-.954v-.003c0-.568-.453-1.022-.998-1.022l-.004-.001c-.474 0-.878.364-.994.885L19.995 9H4V8.5l15.995.5z"/>
            </svg>
        </span>
        <span style="font-family:var(--pw-font);"><?php echo $cart_count; ?> ... <?php echo $shop_text; ?></span>
    </a>

    <a href="<?php echo esc_url( $cart_url ); ?>"
       class="pw-mn-item <?php echo $cart_active ? 'active' : ''; ?>"
       data-pw-nav-link="<?php echo esc_url_raw( $cart_url ); ?>"
       aria-label="<?php esc_attr_e( 'Cart', 'pluginwoo' ); ?>">
        <span class="pw-mn-icon">
            <svg width="20" height="20" viewBox="0 0 24 24">
                <path fill="currentColor" d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm13-2h-4v-2h-4v2H2v-4h2v10zm0-12h-4V4h-4v2H2v4h2v4zm0 4h-4v2H2v-2H0v-4h2v4zm11-5H9v2h4V7zm-4 2h2v2h-2V9zm6 6h-2v2h2v-2zm-2-6h-2V9h2v2z"/>
            </svg>
        </span>
        <span style="font-family:var(--pw-font);"><?php echo $cart_text; ?></span>
        <?php if ( $cart_count > 0 ) : ?>
        <span class="pw-mn-badge"><?php echo esc_html( $cart_count ); ?></span>
        <?php endif; ?>
    </a>

    <a href="<?php echo esc_url( $account_url ); ?>"
       class="pw-mn-item <?php echo $account_active ? 'active' : ''; ?>"
       data-pw-nav-link="<?php echo esc_url_raw( $account_url ); ?>"
       aria-label="<?php esc_attr_e( 'Account', 'pluginwoo' ); ?>">
        <span class="pw-mn-icon">
            <svg width="20" height="20" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
        </span>
        <span style="font-family:var(--pw-font);"><?php echo $account_text; ?></span>
    </a>

    <a href="<?php echo esc_url( wc_get_page_id( 'contact' ) ? get_permalink( wc_get_page_id( 'contact' ) ) : $home_url . '?page=contact' ); ?>"
       class="pw-mn-item"
       data-pw-nav-link="<?php echo esc_url_raw( wc_get_page_id( 'contact' ) ? get_permalink( wc_get_page_id( 'contact' ) ) : $home_url ); ?>"
       aria-label="<?php esc_attr_e( 'Contact', 'pluginwoo' ); ?>">
        <span class="pw-mn-icon">
            <svg width="20" height="20" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-4v2l-2 1z"/>
            </svg>
        </span>
        <span style="font-family:var(--pw-font);"><?php echo $contact_text; ?></span>
    </a>
</nav>
