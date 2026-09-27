<?php
/**
 * Template: Carousel Product Display
 * Shortcode: [pluginwoo_product_display type="carousel" ids="" category="" per_page="8" columns="4" template="default"]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$has_wc  = function_exists( 'WC' );
$atts     = $atts ?? array();
$wp_query = PluginWoo_Product_Display::get_products( $atts );
?>
<div class="pluginwoo-product-display pluginwoo-product-display--carousel" id="pluginwoo-product-display-<?php echo esc_attr( md5( json_encode( $atts ) ) ); ?>">
    <div class="pw-carousel-nav pw-carousel-nav--prev" onclick="PWCarousel.prev('<?php echo esc_js( md5( json_encode( $atts ) ) ); ?>')" aria-label="<?php esc_attr_e( 'Previous', 'pluginwoo' ); ?>">
        <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
    </div>

    <div class="pw-carousel-track pluginwoo-scroll" id="pw-carousel-track-<?php echo esc_attr( md5( json_encode( $atts ) ) ); ?>">
        <?php if ( $wp_query->have_posts() ) : ?>
            <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                <?php
                $product = wc_get_product( get_the_ID() );
                if ( ! $product ) continue;
                $thumbnail = $product->get_image_id();
                $src = wp_get_attachment_image_url( $thumbnail, 'woocommerce_thumbnail' );
                if ( ! $src ) {
                    $src = wc_placeholder_img_src();
                }
                $badge_html = '';
                if ( $product->get_sale_price() && $product->get_regular_price() ) {
                    $badge_html = '<span class="pw-pd-badge pluginwoo-badge--sale">'
                        . ( $product->get_price() - $product->get_sale_price() )
                        . '% ' . esc_html__( 'تخفیف', 'pluginwoo' )
                        . '</span>';
                } elseif ( $product->is_on_sale() ) {
                    $badge_html = '<span class="pw-pd-badge pluginwoo-badge--sale">' . esc_html__( 'تخفیف', 'pluginwoo' ) . '</span>';
                }
                ?>
                <div class="pw-carousel-card">
                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="pluginwoo-pd-card">
                        <div class="pw-pd-img-wrap">
                            <?php echo $badge_html; ?>
                            <img src="<?php echo esc_url( $src ); ?>"
                                 class="pw-pd-img"
                                 alt="<?php echo esc_attr( $product->get_name() ); ?>"
                                 width="240" height="240" />
                        </div>
                        <div class="pw-pd-content">
                            <div class="pw-pd-title"><?php echo esc_html( $product->get_name() ); ?></div>
                            <div class="pw-pd-price">
                                <?php echo wc_price( $product->get_price() ); ?>
                                <?php if ( $product->get_regular_price() && $product->get_price() !== $product->get_regular_price() ) : ?>
                                    <del><?php echo wc_price( $product->get_regular_price() ); ?></del>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
            <?php else : ?>
            <div style="text-align:center;padding:40px;color:var(--pw-text-muted);grid-column:1/-1;">
                <?php esc_html_e( 'محصولی یافت نشد', 'pluginwoo' ); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="pw-carousel-nav pw-carousel-nav--next" onclick="PWCarousel.next('<?php echo esc_js( md5( json_encode( $atts ) ) ); ?>')" aria-label="<?php esc_attr_e( 'Next', 'pluginwoo' ); ?>">
        <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M10 5l6 6-6 6-1.41-1.41L13.17 12z"/></svg>
    </div>

    <style>
        .pw-carousel-card { min-width:<?php echo ( $atts['columns'] ?? 4 ) * 60 + 240; ?>px; }
    </style>
</div>

<script>
    var PWCarousel = PWCarousel || {};
    PWCarousel.prev = function (id) {
        var track = document.getElementById('pw-carousel-track-' + id);
        if (track) track.scrollBy({ left: -300, behavior: 'smooth' });
    };
    PWCarousel.next = function (id) {
        var track = document.getElementById('pw-carousel-track-' + id);
        if (track) track.scrollBy({ left: 300, behavior: 'smooth' });
    };
</script>
