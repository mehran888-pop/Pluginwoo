<?php
/**
 * Template: Minimal Cart
 * Shortcode: [pluginwoo_cart template="minimal"]
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pluginwoo-wrapper pluginwoo-cart-minimal">
    <div style="text-align:center;padding:20px 0;font-family:var(--pw-font);">
        <h1 style="font-size:20px;margin-bottom:4px;font-weight:700;">
            <?php esc_html_e( 'سبد خرید', 'pluginwoo' ); ?>
        </h1>
        <p style="font-size:13px;color:var(--pw-text-muted);margin:0 0 16px;">
            <?php
            $count = WC()->cart->get_cart_contents_count();
            echo $count . ' ' . esc_html__( 'آیتم', 'pluginwoo' );
            ?>
        </p>
    </div>

    <?php if ( WC()->cart->is_empty() ) : ?>
    <div style="text-align:center;padding:40px 0;color:var(--pw-text-muted);">
        <?php esc_html_e( 'سبد خرید شما خالی است', 'pluginwoo' ); ?>
        <br />
        <a href="<?php echo esc_url( wc_get_shop_url() ); ?>" class="pluginwoo-btn pluginwoo-btn--primary" style="display:inline-flex;padding:10px 24px;">
            <?php esc_html_e( 'مشاهده فروشگاه', 'pluginwoo' ); ?>
        </a>
    </div>
    <?php else : ?>
    <table style="width:100%;max-width:700px;margin:0 auto;border-collapse:collapse;">
        <thead style="border-bottom:2px solid var(--pw-border);">
            <tr>
                <th style="text-align:right;padding:8px 12px;font-size:11px;text-transform:uppercase;color:var(--pw-text-muted);font-weight:700;">
                    <?php esc_html_e( 'محصول', 'pluginwoo' ); ?>
                </th>
                <th style="text-align:right;padding:8px 12px;font-size:11px;text-transform:uppercase;color:var(--pw-text-muted);font-weight:700;width:60px;">
                    <?php esc_html_e( 'Qty', 'pluginwoo' ); ?>
                </th>
                <th style="text-align:right;padding:8px 12px;font-size:11px;text-transform:uppercase;color:var(--pw-text-muted);font-weight:700;width:100px;">
                    <?php esc_html_e( 'قیمت', 'pluginwoo' ); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                $_product = wc_get_product( $cart_item['data']->get_id() );
                $price = WC()->cart->get_product_price( $_product, $cart_item['variation'] );
            ?>
            <tr>
                <td style="text-align:right;padding:10px 12px;border-bottom:1px solid var(--pw-border);vertical-align:middle;">
                    <div style="display:flex;justify-content:flex-end;gap:8px;align-items:center;">
                        <span style="font-size:13px;font-weight:600;font-family:var(--pw-font);">
                            <a href="<?php echo esc_url( $_product->get_permalink() ); ?>" style="color:var(--pw-text);text-decoration:none;">
                                <?php echo esc_html( $_product->get_name() ); ?>
                            </a>
                        </span>
                    </div>
                </td>
                <td style="text-align:right;padding:10px 12px;border-bottom:1px solid var(--pw-border);">
                    <?php echo esc_html( $cart_item['qty'] ); ?>
                </td>
                <td style="text-align:right;padding:10px 12px;border-bottom:1px solid var(--pw-border);font-weight:600;color:var(--pw-primary);">
                    <?php echo wc_price( $price ); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="max-width:700px;margin:20px auto;padding:16px 0;text-align:right;">
        <div style="display:flex;justify-content:space-between;align-items:center;font-size:16px;font-weight:700;padding:12px 0;border-top:2px solid var(--pw-border);font-family:var(--pw-font);">
            <span><?php esc_html_e( 'جمع کل', 'pluginwoo' ); ?></span>
            <span style="font-size:20px;color:var(--pw-primary);">
                <?php echo wc_price( WC()->cart->get_cart_total() ); ?>
            </span>
        </div>
        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="pluginwoo-btn pluginwoo-btn--primary" style="display:inline-flex;width:100%;justify-content:center;margin-top:8px;">
            <?php esc_html_e( 'قدم بعدی: صورت‌حساب', 'pluginwoo' ); ?>
        </a>
    </div>
    <?php endif; ?>
</div>
