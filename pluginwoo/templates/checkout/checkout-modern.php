<?php
/**
 * Template: Modern Checkout
 * Wraps WooCommerce's native checkout form with a modern two-column layout.
 *
 * Note: WooCommerce's default checkout already handles all form fields, nonces,
 * validation, payment methods, and order submission. This template adds custom
 * layout and styling only.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pluginwoo-checkout-modern">
    <?php
    // Custom wrapper to apply layout + styles without breaking WC's form.
    // WooCommerce hooks into woocommerce_checkout_form so we just output that.

    if ( WC()->cart->is_empty() ) :
        ?>
        <div style="text-align:center;padding:60px 20px;color:var(--pw-text-muted);font-family:var(--pw-font);">
            <?php esc_html_e( 'سبد खरهای شما خالی است. برای شروع، محصولی را اضافه کنید.', 'pluginwoo' ); ?>
            <br />
            <a href="<?php echo esc_url( wc_get_shop_url() ); ?>" class="pluginwoo-btn pluginwoo-btn--primary" style="display:inline-flex;margin-top:12px;">
                <?php esc_html_e( 'مشاهده فروشگاه', 'pluginwoo' ); ?>
            </a>
        </div>
        <?php
        return;
    endif;
    ?>

    <div class="pw-checkout-grid">
        <!-- Left: WC Checkout Form (includes all fields + order review) -->
        <div class="pw-checkout-form-section">
            <?php
            // Add custom heading.
            ?>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
                <h2>
                    <?php esc_html_e( 'صورت‌حساب', 'pluginwoo' ); ?>
                </h2>
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="pluginwoo-btn pluginwoo-btn--secondary" style="padding:8px 16px;font-size:13px;display:inline-flex;">
                    <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm13-2h-4v-2h-4v2H2v-4h2v10zm0-12h-4V4h-4v2H2v4h2v4zm0 4h-4v2H2v-2H0v-4h2v4zm11-5H9v2h4V7zm-4 2h2v2h-2V9zm6 6h-2v2h2v-2zm-2-6h-2V9h2v2z"/></svg>
                    <?php esc_html_e( 'بازگشت به سبد خرید', 'pluginwoo' ); ?>
                </a>
            </div>

            <?php do_action( 'woocommerce_checkout_before_form' ); ?>

            <form id="checkout-form" method="post" action="<?php echo esc_url( wc_get_checkout_url() ); ?>">
                <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                <div style="margin-bottom:24px;">
                    <h3 class="pw-checkout-section-title">
                        <?php esc_html_e( 'اطلاعات پرداخت‌كردگر', 'pluginwoo' ); ?>
                    </h3>
                    <?php
                    // WC renders all checkout fields inside this hook.
                    woocommerce_form_field( 'billing_first_name', array(
                        'type'  => 'text',
                        'label' => esc_html__( 'نام', 'pluginwoo' ),
                        'required' => true,
                        'class' => array( 'pw-form-input' ),
                    ) );
                    woocommerce_form_field( 'billing_last_name', array(
                        'type'  => 'text',
                        'label' => esc_html__( 'نام خانوادگی', 'pluginwoo' ),
                        'required' => true,
                        'class' => array( 'pw-form-input' ),
                    ) );
                    woocommerce_form_field( 'billing_email', array(
                        'type'  => 'email',
                        'label' => esc_html__( 'ایمیل', 'pluginwoo' ),
                        'required' => true,
                        'class' => array( 'pw-form-input' ),
                    ) );
                    woocommerce_form_field( 'billing_phone', array(
                        'type'  => 'tel',
                        'label' => esc_html__( 'شماره تماس', 'pluginwoo' ),
                        'class' => array( 'pw-form-input' ),
                    ) );
                    woocommerce_form_field( 'billing_address_1', array(
                        'type'  => 'text',
                        'label' => esc_html__( 'آدرس', 'pluginwoo' ),
                        'required' => true,
                        'class' => array( 'pw-form-input' ),
                    ) );
                    woocommerce_form_field( 'billing_address_2', array(
                        'type'  => 'text',
                        'label' => esc_html__( 'آدرس تکمیلی', 'pluginwoo' ),
                        'class' => array( 'pw-form-input' ),
                    ) );
                    woocommerce_form_field( 'billing_city', array(
                        'type'  => 'text',
                        'label' => esc_html__( 'شهر', 'pluginwoo' ),
                        'class' => array( 'pw-form-input' ),
                    ) );
                    woocommerce_form_field( 'billing_postcode', array(
                        'type'  => 'text',
                        'label' => esc_html__( 'کد پستی', 'pluginwoo' ),
                        'class' => array( 'pw-form-input' ),
                    ) );
                    woocommerce_form_field( 'billing_country', array(
                        'type'        => 'select',
                        'label'       => esc_html__( 'کشور', 'pluginwoo' ),
                        'required'    => true,
                        'class'       => array( 'pw-form-select' ),
                        'options'     => WC()->countries->get_allowed_countries(),
                    ) );
                    ?>
                </div>

                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div class="pw-checkout-section-title" style="margin-top:16px;">
                    <?php esc_html_e( 'جزئیات سفارش', 'pluginwoo' ); ?>
                </div>

                <?php do_action( 'woocommerce_checkout_order_review' ); ?>

                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
            </form>

            <?php do_action( 'woocommerce_checkout_after_form' ); ?>
        </div>

        <!-- Right: Order Summary (custom styled) -->
        <div class="pw-order-summary">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <div style="width:44px;height:44px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;">📦</div>
                <h3 style="margin:0;font-family:var(--pw-font);font-size:17px;">
                    <?php esc_html_e( 'جزئیات سفارش', 'pluginwoo' ); ?>
                </h3>
            </div>

            <div class="pw-os-items">
                <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                    $_product = wc_get_product( $cart_item['data']->get_id() );
                    $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'thumbnail' );
                    $image = $thumbnail ? $thumbnail[0] : wc_placeholder_img_src();
                ?>
                <div class="pw-os-row">
                    <div class="pw-os-product">
                        <img src="<?php echo esc_url( $image ); ?>" alt="" />
                        <div>
                            <p style="margin:0;font-size:13px;font-weight:600;font-family:var(--pw-font);">
                                <?php echo esc_html( $_product->get_name() ); ?>
                            </p>
                            <p style="margin:0;font-size:12px;opacity:.75;">
                                <?php echo esc_html( $cart_item['qty'] ); ?>×
                            </p>
                        </div>
                    </div>
                    <span style="font-weight:700;font-size:14px;">
                        <?php echo wc_price( WC()->cart->get_product_price( $_product, $cart_item['variation'] ) * $cart_item['qty'] ); ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="pw-os-total">
                <span><?php esc_html_e( 'جمع کل', 'pluginwoo' ); ?></span>
                <span style="font-size:22px;font-weight:800;">
                    <?php echo wc_price( WC()->cart->get_cart_total() ); ?>
                </span>
            </div>

            <?php if ( WC()->cart->get_cart_discount() > 0 ) : ?>
            <div style="background:rgba(255,255,255,.15);border-radius:8px;padding:8px 12px;margin-bottom:12px;font-size:13px;display:flex;justify-content:space-between;">
                <span><?php esc_html_e( 'تخفیفActivate', 'pluginwoo' ); ?></span>
                <span style="color:var(--pw-secondary);font-weight:700;">
                    - <?php echo wc_price( WC()->cart->get_cart_discount() ); ?>
                </span>
            </div>
            <?php endif; ?>

            <button type="submit" class="pw-os-button" style="margin-top:16px;">
                <svg width="16" height="16" viewBox="0 0 24 24" style="margin-right:6px;"><path fill="currentColor" d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                <?php esc_html_e( 'ثبت سفارش نهایی', 'pluginwoo' ); ?>
            </button>
            <p style="font-size:12px;margin-top:8px;opacity:.7;text-align:center;">
                <?php esc_html_e( 'با کلیک بر روی ثبت سفارش، شرایط و قوانین را تایید کرده‌اید.', 'pluginwoo' ); ?>
            </p>

            <?php if ( class_exists( 'WC_Payment_Gateways' ) ) : ?>
            <div style="margin-top:16px;font-size:13px;opacity:.8;text-align:center;">
                <?php esc_html_e( 'پیش از پرداخت، روش‌های پرداخت را انتخاب کنید.', 'pluginwoo' ); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
