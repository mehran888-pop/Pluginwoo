<?php
/**
 * Template: Creative Product Banner
 * Shortcode: [pluginwoo_product_banner product_id="" template="creative"]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$product = PluginWoo_Product_Banner::get_product( $product_id );
if ( ! $product ) :
    echo '<p style="text-align:center;padding:20px;color:var(--pw-text-muted);">' . esc_html__( 'محصول یافت نشد.', 'pluginwoo' ) . '</p>';
    return;
endif;

$thumbnail = $product->get_image_id();
$imgUrl    = $thumbnail ? wp_get_attachment_image_url( $thumbnail, 'woocommerce_single' ) : wc_placeholder_img_src();
$price     = wc_price( $product->get_price() );
$on_sale   = $product->get_sale_price() && $product->get_regular_price() && $product->get_price() !== $product->get_regular_price();
$regular   = $product->get_regular_price() ? wc_price( $product->get_regular_price() ) : '';
$rating    = $product->get_average_rating();
$rating_count = $product->get_rating_count();
?>
<div class="pluginwoo-product-banner pluginwoo-product-banner--creative pw-pb-effect-shine">
    <div class="pw-pbc-inner">
        <!-- Left: Image -->
        <div class="pw-pbc-img">
            <img src="<?php echo esc_url( $imgUrl ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" />
        </div>

        <!-- Right: Info -->
        <div class="pw-pbc-info">
            <?php if ( $product->is_on_sale() ) : ?>
            <span class="pw-pbc-label">
                <?php esc_html_e( 'فروش適合', 'pluginwoo' ); ?>
            </span>
            <?php elseif ( $product->is_featured() ) : ?>
            <span class="pw-pbc-label" style="background:var(--pw-primary);color:#fff;">
                <?php esc_html_e( 'محصول برجسته', 'pluginwoo' ); ?>
            </span>
            <?php endif; ?>

            <h3 class="pw-pbc-title">
                <?php echo esc_html( $product->get_name() ); ?>
            </h3>

            <p class="pw-pbc-desc">
                <?php
                $desc = $product->get_short_description();
                echo $desc ? esc_html( $desc ) : esc_html__( 'این محصول با دقت و کیفیت بالا تولید شده است. مشتری‌های ما از کیفیت آن راضی هستند.', 'pluginwoo' );
                ?>
            </p>

            <div class="pw-pbc-price-row">
                <span class="pw-pbc-price"><?php echo $price; ?></span>
                <?php if ( $on_sale ) : ?>
                <span style="font-size:13px;color:var(--pw-text-muted);text-decoration:line-through;">
                    <?php echo $regular; ?>
                </span>
                <?php endif; ?>
                <?php if ( $rating ) : ?>
                <span class="pw-pbc-rating">★ <?php echo esc_html( $rating ); ?></span>
                <?php endif; ?>
            </div>

            <?php if ( $product->is_visible() && $product->is_in_stock() ) : ?>
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>"
               class="pluginwoo-btn pluginwoo-btn--primary"
               style="display:inline-flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:12px;font-size:14px;">
                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M5 12h14M12 5l7 7-7 7"/></svg>
                <?php esc_html_e( 'نمایش محصول', 'pluginwoo' ); ?>
            </a>

            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
               class="pluginwoo-btn pluginwoo-btn--secondary"
               style="display:inline-flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:12px;font-size:14px;margin-top:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm13-2h-4v-2h-4v2H2v-4h2v10zm0-12h-4V4h-4v2H2v4h2v4zm0 4h-4v2H2v-2H0v-4h2v4zm11-5H9v2h4V7zm-4 2h2v2h-2V9zm6 6h-2v2h2v-2zm-2-6h-2V9h2v2z"/></svg>
                <?php esc_html_e( 'افزودن به سبد خرید', 'pluginwoo' ); ?>
            </a>
            <?php else : ?>
            <div style="margin-top:8px;padding:10px 0;border:1px solid var(--pw-border);border-radius:8px;text-align:center;font-size:13px;color:var(--pw-text-muted);font-family:var(--pw-font);">
                <?php esc_html_e( 'این محصول در دسترس نیست.', 'pluginwoo' ); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
