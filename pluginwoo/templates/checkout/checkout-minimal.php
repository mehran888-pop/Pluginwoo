<?php
/**
 * Template: Minimal Checkout
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pluginwoo-checkout-minimal">
    <h1 style="font-size:20px;margin-bottom:4px;font-family:var(--pw-font);font-weight:700;">
        <?php esc_html_e( 'صورت‌حساب', 'pluginwoo' ); ?>
    </h1>
    <p style="font-size:13px;color:var(--pw-text-muted);margin-bottom:20px;">
        <?php
        $count = WC()->cart->get_cart_contents_count();
        echo sprintf( esc_html__( '%d محصول — %s', 'pluginwoo' ), $count, wc_price( WC()->cart->get_cart_total() ) );
        ?>
    </p>

    <form method="post" id="minimal-checkout-form">
        <div class="pw-min-field">
            <label><?php esc_html_e( 'نام و نام خانوادگی', 'pluginwoo' ); ?></label>
            <input type="text" name="billing_name" class="pw-form-input"
                   value="<?php echo esc_attr( WC()->customer->get_billing_first_name() . ' ' . WC()->customer->get_billing_last_name() ); ?>" />
        </div>
        <div class="pw-min-field">
            <label><?php esc_html_e( 'ایمیل', 'pluginwoo' ); ?></label>
            <input type="email" name="billing_email" class="pw-form-input"
                   value="<?php echo esc_attr( WC()->customer->get_billing_email() ); ?>" />
        </div>
        <div class="pw-min-field">
            <label><?php esc_html_e( 'آدرس', 'pluginwoo' ); ?></label>
            <input type="text" name="billing_address" class="pw-form-input" />
        </div>
        <div class="pw-min-field">
            <label><?php esc_html_e( 'کد پستی', 'pluginwoo' ); ?></label>
            <input type="text" name="billing_postcode" class="pw-form-input" />
        </div>

        <div style="margin-top:16px;border-top:1px solid var(--pw-border);padding-top:16px;">
            <div style="display:flex;justify-content:space-between;font-weight:600;margin-bottom:4px;">
                <span><?php esc_html_e( 'جمع کل', 'pluginwoo' ); ?></span>
                <span style="color:var(--pw-primary);font-size:18px;font-weight:800;">
                    <?php echo wc_price( WC()->cart->get_cart_total() ); ?>
                </span>
            </div>
        </div>

        <button type="submit" class="pluginwoo-btn pluginwoo-btn--primary"
                style="width:100%;margin-top:16px;justify-content:center;display:inline-flex;">
            <?php esc_html_e( 'ثبت سفارش', 'pluginwoo' ); ?>
        </button>
    </form>
</div>
