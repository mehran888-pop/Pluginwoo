<?php
/**
 * Template: Slider Product Display
 * Shortcode: [pluginwoo_product_display type="slider" ...]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$atts    = $atts ?? array();
$wp_query = PluginWoo_Product_Display::get_products( $atts );
?>
<div class="pluginwoo-product-display pluginwoo-product-display--slider">
    <div class="pw-slider-track" style="transform:translateX(0);">
        <?php if ( $wp_query->have_posts() ) : ?>
            <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                <?php
                $product = wc_get_product( get_the_ID() );
                if ( ! $product ) continue;
                $thumbnail = $product->get_image_id();
                $src = wp_get_attachment_image_url( $thumbnail, 'woocommerce_single' );
                if ( ! $src ) $src = wc_placeholder_img_src();
                $price_html = wc_price( $product->get_price() );
                $on_sale = $product->is_on_sale();
                ?>
                <div class="pw-slider-slide">
                    <div class="pw-slider-content">
                        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                            <div style="flex-shrink:0;">
                                <img src="<?php echo esc_url( $src ); ?>"
                                     style="width:100px;height:100px;object-fit:cover;border-radius:12px;box-shadow:var(--pw-shadow);"
                                     alt="<?php echo esc_attr( $product->get_name() ); ?>" />
                            </div>
                            <div style="flex:1;min-width:200px;">
                                <div class="pw-pd-badge <?php echo $on_sale ? 'pluginwoo-badge--sale' : 'pluginwoo-badge--primary'; ?>" style="margin-bottom:8px;">
                                    <?php echo $on_sale ? esc_html__( 'فروش적합 — تخفیف دارد', 'pluginwoo' ) : esc_html__( 'برگزار', 'pluginwoo' ); ?>
                                </div>
                                <h3 style="font-size:18px;margin-bottom:4px;font-family:var(--pw-font);font-weight:700;">
                                    <?php echo esc_html( $product->get_name() ); ?>
                                </h3>
                                <p style="font-size:14px;color:var(--pw-text-muted);margin-bottom:12px;line-height:1.6;">
                                    <?php echo esc_html( $product->get_short_description() ); ?>
                                </p>
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <span style="font-size:22px;font-weight:800;color:var(--pw-primary);font-family:var(--pw-font);">
                                        <?php echo $price_html; ?>
                                    </span>
                                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="pluginwoo-btn pluginwoo-btn--primary" style="padding:8px 20px;font-size:13px;display:inline-flex;">
                                        <?php esc_html_e( 'مشاهده محصول', 'pluginwoo' ); ?>
                                    </a>
                                    <?php if ( $product->is_in_stock() ) : ?>
                                    <span class="pluginwoo-badge pluginwoo-badge--secondary" style="font-size:12px;">
                                        <?php esc_html_e( 'قابل خرید', 'pluginwoo' ); ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>
