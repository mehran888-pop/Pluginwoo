<?php
/**
 * Template: Grid Product Display
 * Shortcode: [pluginwoo_product_display type="grid" ids="" category="" per_page="8" columns="4" template="default"]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$atts     = $atts ?? array();
$wp_query = PluginWoo_Product_Display::get_products( $atts );

$columns = isset( $atts['columns'] ) ? absint( $atts['columns'] ) : 4;
$col_class = 'cols-' . min( $columns, 4 );
?>
<div class="pluginwoo-product-display pluginwoo-product-display--grid <?php echo esc_attr( $col_class ); ?>">
    <?php if ( $wp_query->have_posts() ) : ?>
        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <?php
            $product = wc_get_product( get_the_ID() );
            if ( ! $product ) continue;
            $thumbnail = $product->get_image_id();
            $src = wp_get_attachment_image_url( $thumbnail, 'woocommerce_thumbnail' );
            if ( ! $src ) $src = wc_placeholder_img_src();
            $badge = '';
            if ( $product->get_sale_price() && $product->get_regular_price() ) {
                $badge = '<span class="pw-pd-badge pluginwoo-badge--sale">'
                    . round( ( 1 - $product->get_sale_price() / $product->get_regular_price() ) * 100 )
                    . '% ' . esc_html__( 'تخفیف', 'pluginwoo' )
                    . '</span>';
            }
            ?>
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="pluginwoo-pd-card">
                <div class="pw-pd-img-wrap">
                    <?php echo $badge; ?>
                    <img src="<?php echo esc_url( $src ); ?>" class="pw-pd-img" alt="" width="300" height="300" />
                </div>
                <div class="pw-pd-content">
                    <div class="pw-pd-title"><?php echo esc_html( $product->get_name() ); ?></div>
                    <div class="pw-pd-price">
                        <?php echo wc_price( $product->get_price() ); ?>
                        <?php if ( $product->get_price() !== $product->get_regular_price() && $product->get_regular_price() ) : ?>
                            <del><?php echo wc_price( $product->get_regular_price() ); ?></del>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endwhile; ?>
    <?php else : ?>
    <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--pw-text-muted);">
        <?php esc_html_e( 'محصولی پیدا نشد.', 'pluginwoo' ); ?>
    </div>
    <?php endif; ?>
</div>
