<?php
/**
 * Template: Modern Cart
 * Shortcode: [pluginwoo_cart template="modern"]
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pluginwoo-wrapper pluginwoo-cart-modern">
    <!-- Header -->
    <div class="pluginwoo-cart-header">
        <h2><?php esc_html_e( 'سبد خرید شما', 'pluginwoo' ); ?></h2>
        <p>
            <?php
            $count = WC()->cart->get_cart_contents_count();
            echo sprintf( esc_html__( '%d محصول در سبد خرید', 'pluginwoo' ), $count );
            ?>
        </p>
    </div>

    <div class="pluginwoo-cart-items">
        <!-- Items Table -->
        <div class="pluginwoo-cart-table-wrap">
            <?php if ( WC()->cart->is_empty() ) : ?>
            <div style="text-align:center;padding:60px 20px;color:var(--pw-text-muted);">
                <div style="font-size:48px;margin-bottom:12px;">🛒</div>
                <h3 style="font-size:18px;margin:0 0 6px;font-family:var(--pw-font);">
                    <?php esc_html_e( 'سبد خرید خالی است', 'pluginwoo' ); ?>
                </h3>
                <p style="margin:0 0 20px;font-size:14px;">
                    <?php esc_html_e( 'برای شروع، محصولی را اضافه کنید.', 'pluginwoo' ); ?>
                </p>
                <a href="<?php echo esc_url( wc_get_shop_url() ); ?>" class="pluginwoo-btn pluginwoo-btn--primary">
                    <?php esc_html_e( 'مشاهده فروشگاه', 'pluginwoo' ); ?>
                </a>
            </div>
            <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th style="padding:14px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.05em;color:var(--pw-text-muted);font-weight:700;font-family:var(--pw-font);">
                            <?php esc_html_e( 'محصول', 'pluginwoo' ); ?>
                        </th>
                        <th style="padding:14px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.05em;color:var(--pw-text-muted);font-weight:700;font-family:var(--pw-font);">
                            <?php esc_html_e( 'تعداد', 'pluginwoo' ); ?>
                        </th>
                        <th style="padding:14px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.05em;color:var(--pw-text-muted);font-weight:700;font-family:var(--pw-font);">
                            <?php esc_html_e( 'قیمت', 'pluginwoo' ); ?>
                        </th>
                        <th style="padding:14px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.05em;color:var(--pw-text-muted);font-weight:700;font-family:var(--pw-font);width:60px;">
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                        $_product = wc_get_product( $cart_item['data']->get_id() );
                        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'medium' );
                        $image = $thumbnail ? $thumbnail[0] : wc_placeholder_img_src();
                        $variation_attributes = '';
                        if ( $_product->is_type( 'variable' ) ) {
                            $variation_attributes = implode( ', ', array_map( function ( $v ) {
                                return $v['name'];
                            }, $cart_item['variation'] ) );
                        }
                    ?>
                    <tr>
                        <td>
                            <div class="pw-cart-product-info">
                                <img src="<?php echo esc_url( $image ); ?>"
                                     class="pw-cart-product-thumb"
                                     alt="<?php echo esc_attr( $_product->get_name() ); ?>" />
                                <div style="margin-left:14px;">
                                    <h4 style="font-size:15px;margin:0 0 2px;font-family:var(--pw-font);">
                                        <a href="<?php echo esc_url( $_product->get_permalink() ); ?>" style="color:var(--pw-text);text-decoration:none;">
                                            <?php echo esc_html( $_product->get_name() ); ?>
                                        </a>
                                    </h4>
                                    <?php if ( ! empty( $variation_attributes ) ) : ?>
                                    <p style="font-size:12px;color:var(--pw-text-muted);margin:0;">
                                        <?php echo esc_html( $variation_attributes ); ?>
                                    </p>
                                    <?php endif; ?>
                                    <?php if ( $_product->get_sku() ) : ?>
                                    <p style="font-size:11px;color:var(--pw-text-muted);margin:2px 0 0;">
                                        SKU: <?php echo esc_html( $_product->get_sku() ); ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px;">
                                <button class="pw-qty-minus" data-cart-item="<?php echo esc_attr( $cart_item_key ); ?>"
                                    style="width:30px;height:30px;border-radius:50%;border:1px solid var(--pw-border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:var(--pw-text);transition:all .15s;"
                                    aria-label="<?php esc_attr_e( 'Reduce', 'pluginwoo' ); ?>">−</button>
                                <input type="number" class="pw-qty-input"
                                    value="<?php echo esc_attr( $cart_item['qty'] ); ?>" min="1"
                                    style="width:44px;text-align:center;font-weight:700;font-size:14px;border:1px solid var(--pw-border);border-radius:6px;padding:4px 8px;"
                                    data-cart-item="<?php echo esc_attr( $cart_item_key ); ?>" />
                                <button class="pw-qty-plus" data-cart-item="<?php echo esc_attr( $cart_item_key ); ?>"
                                    style="width:30px;height:30px;border-radius:50%;border:1px solid var(--pw-border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:var(--pw-text);transition:all .15s;"
                                    aria-label="<?php esc_attr_e( 'Increase', 'pluginwoo' ); ?>">+</button>
                            </div>
                        </td>
                        <td>
                            <span class="pw-price" style="font-weight:700;color:var(--pw-primary);font-size:16px;font-family:var(--pw-font);">
                                <?php echo wc_price( WC()->cart->get_product_price( $_product, $cart_item['variation'] ) ); ?>
                            </span>
                        </td>
                        <td>
                            <button class="pw-cart-remove"
                                data-cart-item="<?php echo esc_attr( $cart_item_key ); ?>"
                                style="background:none;border:none;cursor:pointer;color:var(--pw-text-muted);font-size:18px;padding:6px;transition:color .15s;"
                                aria-label="<?php esc_attr_e( 'Remove item', 'pluginwoo' ); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Cart Actions Row -->
            <div style="padding:16px 20px;border-top:1px solid var(--pw-border);display:flex;align-items:center;gap:12px;flex-wrap:wrap;background:var(--pw-bg-light);">
                <a href="<?php echo esc_url( wc_get_continue_shopping_url() ); ?>"
                   class="pluginwoo-btn pluginwoo-btn--secondary"
                   style="padding:10px 20px;font-size:14px;display:inline-flex;">
                    <?php esc_html_e( 'حق오산 خريد', 'pluginwoo' );
                    ?>
                </a>
                <button id="pluginwoo-update-cart" style="padding:10px 20px;background:var(--pw-bg-light);border:1px solid var(--pw-border);border-radius:50px;cursor:pointer;font-size:14px;font-family:var(--pw-font);font-weight:600;display:inline-flex;align-items:center;gap:6px;">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12h-2v-2H9v2H7v2h2v2h2v-2h2v-2h-2zM5 12h2v2H5V7h2v5z"/></svg>
                    <?php esc_html_e( 'بروزرساني', 'pluginwoo' ); ?>
                </button>
            </div>

            <!-- Coupons -->
            <?php if ( WC()->cart->has_coupons() ) : ?>
            <div style="padding:16px 20px;border-top:1px solid var(--pw-border);display:flex;align-items:center;gap:10px;flex-wrap:wrap;background:var(--pw-bg-light);">
                <?php foreach ( WC()->cart->get_coupons() as $coupon ) : ?>
                <span class="pluginwoo-badge pluginwoo-badge--secondary" style="font-size:12px;">
                    <?php echo esc_html( $coupon->get_code() ); ?>
                    <button type="button" class="pw-cart-remove" data-coupon="<?php echo esc_attr( $coupon->get_code() ); ?>"
                            style="margin-left:6px;background:none;border:none;cursor:pointer;color:#fff;padding:0;font-size:12px;"
                            aria-label="<?php esc_attr_e( 'Remove coupon', 'pluginwoo' ); ?>">✕</button>
                </span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Summary Sidebar -->
        <div class="pluginwoo-cart-summary">
            <h3><?php esc_html_e( 'جمع‌يابي سبد', 'pluginwoo' ); ?></h3>

            <div class="pw-summary-row">
                <span style="font-size:13px;color:var(--pw-text-muted);">
                    <?php esc_html_e( 'محصولات', 'pluginwoo' ); ?>
                </span>
                <span style="font-weight:600;">
                    <?php echo $count; ?>
                    <?php esc_html_e( 'آیتم', 'pluginwoo' ); ?>
                </span>
            </div>

            <div class="pw-summary-row">
                <span style="font-size:13px;color:var(--pw-text-muted);">
                    <?php esc_html_e( 'تخفيف‌ها', 'pluginwoo' ); ?>
                </span>
                <span style="color:var(--pw-secondary);font-weight:600;">
                    <?php echo wc_price( WC()->cart->get_cart_discount() ); ?>
                </span>
            </div>

            <div class="pw-summary-row">
                <span style="font-size:13px;color:var(--pw-text-muted);">
                    <?php esc_html_e( ' shipping ', 'pluginwoo' ); ?>
                </span>
                <span style="color:var(--pw-text-muted);">
                    <?php esc_html_e( 'محاسبه مي‌شود در مرحله بعد', 'pluginwoo' ); ?>
                </span>
            </div>

            <div class="pw-summary-row">
                <span style="font-size:13px;color:var(--pw-text-muted);">
                    <?php esc_html_e( 'ضرایب', 'pluginwoo' ); ?>
                </span>
                <span style="color: var(--pw-text-muted);">
                    <?php echo wc_price( WC()->cart->get_cart_tax() ); ?>
                </span>
            </div>

            <div class="pw-summary-total">
                <span style="font-family:var(--pw-font);font-size:15px;">
                    <?php esc_html_e( 'جمع کل', 'pluginwoo' ); ?>
                </span>
                <span style="font-family:var(--pw-font);font-size:22px;font-weight:800;">
                    <?php echo wc_price( WC()->cart->get_cart_total() ); ?>
                </span>
            </div>

            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
               class="pluginwoo-btn pluginwoo-btn--primary"
               style="width:100%;margin-top:16px;justify-content:center;display:inline-flex;">
                <?php esc_html_e( 'ثبت سفارش را تکمیل کنید', 'pluginwoo' );
                ?>
            </a>

            <p style="font-size:12px;color:var(--pw-text-muted);text-align:center;margin-top:10px;">
                <?php esc_html_e( 'برای اطلاعات بیشتر، به صفحه حساب کاربری مراجعه کنید.', 'pluginwoo' ); ?>
            </p>
        </div>
    </div>
</div>
