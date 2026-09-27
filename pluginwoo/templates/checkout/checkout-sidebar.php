<?php
/**
 * Template: Sidebar Checkout
 * Form on left, summary sidebar on right.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pluginwoo-checkout-sidebar">
    <div class="pw-checkout-sidebar-layout">
        <div class="pw-checkout-form-section">
            <h2><?php esc_html_e( 'صورت‌حساب', 'pluginwoo' ); ?></h2>
            <?php woocommerce_checkout_form(); ?>
        </div>
        <div class="pw-order-summary" style="position:static;">
            <h3><?php esc_html_e( 'جزئیات سفارش', 'pluginwoo' ); ?></h3>
            <?php foreach ( WC()->cart->get_cart() as $item ) : ?>
            <div class="pw-os-row">
                <span style="font-size:13px;"><?php echo esc_html( $item['data']->get_name() ); ?> × <?php echo esc_html( $item['qty'] ); ?></span>
                <span style="font-weight:700;"><?php echo wc_price( $item['line_total'] ); ?></span>
            </div>
            <?php endforeach; ?>
            <div class="pw-os-total">
                <span><?php esc_html_e( 'جمع کل', 'pluginwoo' ); ?></span>
                <span style="font-size:20px;font-weight:800;">
                    <?php echo wc_price( WC()->cart->get_cart_total() ); ?>
                </span>
            </div>
            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="pluginwoo-btn pluginwoo-btn--primary" style="width:100%;justify-content:center;margin-top:12px;display:inline-flex;">
                <?php esc_html_e( 'ثبت سفارش', 'pluginwoo' ); ?>
            </a>
        </div>
    </div>
</div>
