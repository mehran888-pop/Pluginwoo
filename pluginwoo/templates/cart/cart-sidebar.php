<?php
/**
 * Template: Sidebar Cart
 * Shortcode: [pluginwoo_cart template="sidebar"]
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pluginwoo-wrapper pluginwoo-cart-sidebar">
    <div class="pluginwoo-cart-sidebar-layout">
        <!-- Sidebar -->
        <div class="pw-sidebar-cart">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                <h4 style="margin:0;font-family:var(--pw-font);font-size:18px;">
                    <?php esc_html_e( 'سبد خرید', 'pluginwoo' ); ?>
                </h4>
                <span style="font-size:14px;opacity:.8;">
                    <?php echo WC()->cart->get_cart_contents_count(); ?>
                </span>
            </div>
            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                $_product = wc_get_product( $cart_item['data']->get_id() );
                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'thumbnail' );
                $image = $thumbnail ? $thumbnail[0] : wc_placeholder_img_src();
            ?>
            <div class="pw-sc-item">
                <img src="<?php echo esc_url( $image ); ?>" alt="" />
                <div style="flex:1;min-width:0;">
                    <p style="margin:0;font-size:12px;font-weight:600;font-family:var(--pw-font);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        <a href="<?php echo esc_url( $_product->get_permalink() ); ?>" style="color:#fff;text-decoration:none;">
                            <?php echo esc_html( $_product->get_name() ); ?>
                        </a>
                    </p>
                    <p style="margin:2px 0 0;font-size:13px;font-weight:700;color:var(--pw-accent);">
                        ×<?php echo esc_html( $cart_item['qty'] ); ?>
                    </p>
                </div>
                <p style="font-weight:700;font-size:13px;margin:0;color:var(--pw-secondary);align-self:center;">
                    <?php echo wc_price( WC()->cart->get_product_price( $_product, $cart_item['variation'] ) ); ?>
                </p>
            </div>
            <?php endforeach; ?>

            <?php if ( WC()->cart->is_empty() ) : ?>
            <div style="text-align:center;padding:16px 0;color:rgba(255,255,255,.7);font-size:13px;font-family:var(--pw-font);">
                <?php esc_html_e( 'سبد خالی است', 'pluginwoo' ); ?>
            </div>
            <?php endif; ?>

            <div style="margin-top:16px;padding-top:16px;border-top:1px solid rgba(255,255,255,.2);">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:13px;">
                    <span style="opacity:.8;"><?php esc_html_e( 'جمع کل', 'pluginwoo' ); ?></span>
                    <span style="font-weight:700;font-size:16px;color:var(--pw-secondary);">
                        <?php echo wc_price( WC()->cart->get_cart_total() ); ?>
                    </span>
                </div>
                <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
                   class="pluginwoo-btn pluginwoo-btn--secondary" style="width:100%;justify-content:center;margin-top:10px;display:inline-flex;padding:10px;">
                    <?php esc_html_e( 'ثبت سفارش', 'pluginwoo' ); ?>
                </a>
            </div>
        </div>
    </div>
</div>
