<?php
/**
 * Template: Default Product Banner
 * Shortcode: [pluginwoo_product_banner product_id="" template="default"]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$product = PluginWoo_Product_Banner::get_product( $product_id );
if ( ! $product ) :
    echo '<p style="text-align:center;padding:20px;color:var(--pw-text-muted);">' . esc_html__( 'محصول یافت نشد.', 'pluginwoo' ) . '</p>';
    return;
endif;

$thumbnail = $product->get_image_id();
$imgUrl    = $thumbnail ? wp_get_attachment_image_url( $thumbnail, 'woocommerce_single' ) : wc_placeholder_img_src();
$badge_html = '';
if ( $product->get_sale_price() && $product->get_regular_price() ) {
    $pct = round( ( 1 - $product->get_sale_price() / $product->get_regular_price() ) * 100 );
    $badge_html = '<span class="pw-pb-img-badge">' . $pct . '% ' . esc_html__( 'تخفیف', 'pluginwoo' ) . '</span>';
}
?>
<div class="pluginwoo-product-banner pluginwoo-product-banner--default">
    <!-- Image Column -->
    <div class="pw-pb-img-col">
        <?php echo $badge_html; ?>
        <img src="<?php echo esc_url( $imgUrl ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" />
    </div>

    <!-- Info Column -->
    <div class="pw-pb-info-col">
        <div class="pw-pb-cat">
            <?php
            $cats = $product->get_category_ids();
            if ( ! empty( $cats ) ) {
                $cat = get_term( $cats[0], 'product_cat' );
                if ( $cat ) {
                    echo esc_html( $cat->name );
                }
            }
            ?>
        </div>

        <h3 class="pw-pb-title">
            <?php echo esc_html( $product->get_name() ); ?>
        </h3>

        <p class="pw-pb-desc">
            <?php
            $desc = $product->get_short_description();
            echo $desc ? esc_html( $desc ) : esc_html__( 'توضیحات محصول در این بخش نمایش داده می‌شود.', 'pluginwoo' );
            ?>
        </p>

        <div class="pw-pb-bottom">
            <div class="pw-pb-price">
                <?php echo wc_price( $product->get_price() ); ?>
                <?php if ( $product->get_regular_price() && $product->get_price() !== $product->get_regular_price() ) : ?>
                    <del style="font-size:14px;color:var(--pw-text-muted);font-weight:400;margin-left:6px;">
                        <?php echo wc_price( $product->get_regular_price() ); ?>
                    </del>
                <?php endif; ?>
            </div>

            <?php if ( $product->is_visible() ) : ?>
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>"
               class="pluginwoo-btn pluginwoo-btn--primary" style="padding:10px 20px;font-size:14px;display:inline-flex;">
                <?php esc_html_e( 'مشاهده محصول', 'pluginwoo' ); ?>
            </a>
            <?php else : ?>
            <button class="pluginwoo-btn pluginwoo-btn--secondary" disabled style="padding:10px 20px;font-size:14px;display:inline-flex;opacity:.6;cursor:not-allowed;">
                <?php esc_html_e( 'Out of stock', 'pluginwoo' ); ?>
            </button>
            <?php endif; ?>
        </div>

        <?php if ( $product->rating ) : ?>
        <div style="margin-top:12px;display:flex;align-items:center;gap:8px;">
            <span class="pluginwoo-stars" style="font-size:14px;color:var(--pw-accent);letter-spacing:1px;">
                ★<?php echo esc_html( $product->get_average_rating() ); ?>
            </span>
            <span style="font-size:12px;color:var(--pw-text-muted);">
                (<?php echo absint( $product->get_rating_count() ); ?>
                <?php esc_html_e( 'amtihan.', 'pluginwoo' ); ?>
                )
            </span>
        </div>
        <?php endif; ?>
    </div>
</div>
