<?php
/**
 * Template: Creative Header
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$has_wc     = function_exists( 'WC' );
$cart_count = $has_wc && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
$account_url = $has_wc ? wc_get_account_endpoint_url() : home_url( 'my-account' );
$cart_url   = $has_wc ? wc_get_cart_url() : home_url( 'cart' );
?>
<header class="pluginwoo-header pluginwoo-header--creative" role="banner">
    <div class="pw-hdr-inner">
        <!-- Logo Area -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pw-hdr-logo"
           style="font-size:24px;font-weight:800;color:var(--pw-primary);text-decoration:none;font-family:var(--pw-font);display:flex;align-items:center;gap:10px;">
            <div class="pw-hdr-logo-icon"
                 style="width:40px;height:40px;background:linear-gradient(135deg,var(--pw-primary),var(--pw-secondary));border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;font-weight:800;">
                P
            </div>
            <?php echo esc_html( get_bloginfo( 'name' ) ?: 'فروشگاه' ); ?>
        </a>

        <!-- Search -->
        <div class="pw-hdr-search" style="flex:1;max-width:420px;margin:0 16px;">
            <div class="pw-hdr-search-wrap" style="position:relative;">
                <svg style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:var(--pw-text-muted);" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M15.5 14h-.79l-.28-.27C15.45 12.78 16 11.85 16 10.5s-1.55-1.41-1.55-2.18c0-.94.74-1.61 1.54-1.61.9 0 1.38.67 1.38 1.54 0 .88-.49 1.35-.82 1.64l-.27.28v.79l6.09 6.09c.27.27.41.67.41 1.08s-.14.82-.41 1.08c-.27.27-.68.42-1.08.42-1.48 0-2.77-1.21-2.77-3.02 0-1.82 1.27-3.08 2.81-3.08 1.42 0 2.26 1.14 2.26 2.46 0 1.6-.87 2.72-2.06 2.72-1.34 0-2.06-1.03-2.06-2.26v-.07L14.5 8.5c-.14-.14-.27-.31-.27-.48 0-.17.13-.35.27-.48L16.5 7.5c.14-.14.31-.27.48-.27.17 0 .35.13.48.27l6.09 6.09-.01.01zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                </svg>
                <?php $search_url = $has_wc ? wc_get_search_url() : home_url( '?s=' ); ?>
                <form action="<?php echo esc_url( $search_url ); ?>" method="get" style="display:flex;align-items:center;">
                    <input type="search" name="s" placeholder="<?php esc_attr_e( 'جستجو...', 'pluginwoo' ); ?>"
                           class="pw-hdr-search-input"
                           style="width:100%;padding:10px 14px 10px 40px;border:1.5px solid var(--pw-border);border-radius:50px;font-size:14px;font-family:var(--pw-font);background:var(--pw-bg-light);color:var(--pw-text);transition:all .2s;"
                           onfocus="this.style.borderColor='var(--pw-primary)';this.style.boxShadow='0 0 0 3px rgba(79,70,229,.12)';this.style.outline='none';"
                           onblur="this.style.borderColor='var(--pw-border)';this.style.boxShadow='none';" />
                </form>
            </div>
        </div>

        <!-- Actions -->
        <div class="pw-hdr-actions">
            <?php if ( $has_wc ) : ?>
            <a href="<?php echo esc_url( $account_url ); ?>"
               class="pw-hdr-btn"
               style="padding:8px 14px;border-radius:50px;border:1.5px solid var(--pw-border);background:#fff;font-size:13px;cursor:pointer;font-family:var(--pw-font);font-weight:600;color:var(--pw-text);transition:all .15s;text-decoration:none;display:flex;align-items:center;gap:6px;"
               aria-label="<?php esc_attr_e( 'My account', 'pluginwoo' ); ?>">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <?php esc_html_e( 'اکانت', 'pluginwoo' ); ?>
            </a>
            <?php endif; ?>
            <a href="<?php echo esc_url( $cart_url ); ?>"
               class="pw-hdr-cart-btn"
               style="position:relative;padding:8px 14px;background:var(--pw-primary);color:#fff;border:none;border-radius:50px;cursor:pointer;display:flex;align-items:center;gap:6px;font-family:var(--pw-font);font-weight:600;transition:all .2s;text-decoration:none;"
               aria-label="<?php esc_attr_e( 'Cart', 'pluginwoo' ); ?>">
                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm13-2h-4v-2h-4v2H2v-4h2v10zm0-12h-4V4h-4v2H2v4h2v4zm0 4h-4v2H2v-2H0v-4h2v4zm11-5H9v2h4V7zm-4 2h2v2h-2V9zm6 6h-2v2h2v-2zm-2-6h-2V9h2v2z"/></svg>
                <?php if ( $cart_count > 0 ) : ?>
                <span class="pw-hdr-cart-count" style="background:var(--pw-accent);color:#fff;font-size:11px;font-weight:700;width:18px;height:18px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;position:absolute;top:-6px;right:-4px;transition:transform .15s;">
                    <?php echo esc_html( $cart_count ); ?>
                </span>
                <?php endif; ?>
                <span style="font-size:12px;visibility:hidden;"><?php echo esc_html( $cart_count ); ?></span>
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
