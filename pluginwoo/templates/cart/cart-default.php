<?php
/**
 * Template: Default Cart
 * Shortcode: [pluginwoo_cart template="default"]
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pluginwoo-wrapper pluginwoo-cart-default">
    <div class="pluginwoo-cart-header" style="background:var(--pw-primary);padding:24px;border-radius:12px;margin-bottom:24px;color:#fff;">
        <h2 style="font-size:22px;margin:0;font-family:var(--pw-font);">
            <?php esc_html_e( 'سبد خرید', 'pluginwoo' ); ?>
        </h2>
        <p style="opacity:.85;margin:0;font-size:14px;">
            <?php
            $count = WC()->cart->get_cart_contents_count();
            $total = WC()->cart->get_cart_total();
            echo sprintf( esc_html__( '(%d محصول — %s)', 'pluginwoo' ), $count, $total );
            ?>
        </p>
    </div>

    <div class="pw-min-table">
        <table class="pluginwoo-cart-minimal wp-list-table widefat fixed striped" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="text-align:right;padding:10px 14px;font-size:12px;text-transform:uppercase;color:var(--pw-text-muted);font-weight:700;">
                        <?php esc_html_e( 'محصول', 'pluginwoo' ); ?>
                    </th>
                    <th style="text-align:right;padding:10px 14px;font-size:12px;text-transform:uppercase;color:var(--pw-text-muted);font-weight:700;">
                        <?php esc_html_e( 'Qty', 'pluginwoo' ); ?>
                    </th>
                    <th style="text-align:right;padding:10px 14px;font-size:12px;text-transform:uppercase;color:var(--pw-text-muted);font-weight:700;">
                        <?php esc_html_e( 'قیمت', 'pluginwoo' ); ?>
                    </th>
                    <th style="text-align:right;padding:10px 14px;font-size:12px;text-transform:uppercase;color:var(--pw-text-muted);font-weight:700;width:80px;">
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if ( WC()->cart->is_empty() ) : ?>
                <tr>
                    <td colspan="4" style="text-align:center;padding:40px 0;color:var(--pw-text-muted);border:none;">
                        <p style="font-size:16px;margin:0 0 8px;font-family:var(--pw-font);">
                            <?php esc_html_e( 'سبد خرید شما خالی است', 'pluginwoo' ); ?>
                        </p>
                        <a href="<?php echo esc_url( wc_get_shop_url() ); ?>" class="pluginwoo-btn pluginwoo-btn--primary" style="display:inline-flex;">
                            <?php esc_html_e( 'مشاهده محصولات', 'pluginwoo' ); ?>
                        </a>
                    </td>
                </tr>
                <?php else : ?>
                <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                    $_product = wc_get_product( $cart_item['data']->get_id() );
                    $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'thumbnail' );
                    $image = $thumbnail ? $thumbnail[0] : wc_placeholder_img_src();
                ?>
                <tr>
                    <td style="text-align:right;padding:12px 14px;border-bottom:1px solid var(--pw-border);vertical-align:top;">
                        <div style="display:flex;gap:10px;align-items:center;">
                            <img src="<?php echo esc_url( $image ); ?>"
                                 width="56" height="56"
                                 style="object-fit:cover;border-radius:8px;background:var(--pw-bg-light);flex-shrink:0;"
                                 alt="<?php echo esc_attr( $_product->get_name() ); ?>" />
                            <div>
                                <h4 style="font-size:14px;margin:0 0 2px;font-family:var(--pw-font);font-weight:600;">
                                    <a href="<?php echo esc_url( $_product->get_permalink() ); ?>" style="color:var(--pw-text);text-decoration:none;">
                                        <?php echo esc_html( $_product->get_name() ); ?>
                                    </a>
                                </h4>
                                <?php if ( $_product->get_attributes() && count( $_product->get_attributes() ) > 0 ) : ?>
                                <p style="font-size:12px;color:var(--pw-text-muted);margin:0;">
                                    <?php echo esc_html( $_product->get_variation_attributes() ? implode( ', ', array_keys( $_product->get_variation_attributes() ) ) : '' ); ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td style="text-align:right;padding:12px 14px;border-bottom:1px solid var(--pw-border);">
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px;">
                            <?php
                            $qty = $cart_item['qty'];
                            ?>
                            <button class="pw-qty-minus" data-cart-item="<?php echo esc_attr( $cart_item_key ); ?>" style="width:28px;height:28px;border-radius:50%;border:1px solid var(--pw-border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;" aria-label="<?php esc_attr_e( 'Reduce', 'pluginwoo' ); ?>">−</button>
                            <input type="number" class="pw-qty-input" value="<?php echo esc_attr( $qty ); ?>" min="1"
                                   style="width:40px;text-align:center;font-weight:700;font-size:14px;border:1px solid var(--pw-border);border-radius:6px;padding:4px;"
                                   data-cart-item="<?php echo esc_attr( $cart_item_key ); ?>" />
                            <button class="pw-qty-plus" data-cart-item="<?php echo esc_attr( $cart_item_key ); ?>" style="width:28px;height:28px;border-radius:50%;border:1px solid var(--pw-border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;" aria-label="<?php esc_attr_e( 'Increase', 'pluginwoo' ); ?>">+</button>
                        </div>
                    </td>
                    <td style="text-align:right;padding:12px 14px;border-bottom:1px solid var(--pw-border);">
                        <span class="pw-price" style="font-weight:700;color:var(--pw-primary);font-size:15px;">
                            <?php echo WC()->cart->get_product_price( $_product, $cart_item['variation'] ); ?>
                        </span>
                    </td>
                    <td style="text-align:right;padding:12px 14px;border-bottom:1px solid var(--pw-border);">
                        <button class="pw-cart-remove" data-cart-item="<?php echo esc_attr( $cart_item_key ); ?>"
                                style="background:none;border:none;cursor:pointer;color:var(--pw-text-muted);font-size:16px;padding:0;transition:color:.15s;"
                                aria-label="<?php esc_attr_e( 'Remove', 'pluginwoo' ); ?>">
                            ✕
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php do_action( 'woocommerce_cart_collaterals' ); ?>
</div>
