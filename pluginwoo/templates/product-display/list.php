<?php
/**
 * Template: List Product Display
 * Shortcode: [pluginwoo_product_display type="list" ...]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$atts     = $atts ?? array();
$wp_query = PluginWoo_Product_Display::get_products( $atts );
?>
<div class="pluginwoo-product-display pluginwoo-product-display--list">
    <?php if ( $wp_query->have_posts() ) : ?>
        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <?php
            $product = wc_get_product( get_the_ID() );
            if ( ! $product ) continue;
            $thumbnail = $product->get_image_id();
            $src = wp_get_attachment_image_url( $thumbnail, 'woocommerce_thumbnail' );
            if ( ! $src ) $src = wc_placeholder_img_src();
            $price = wc_price( $product->get_price() );
            $on_sale = $product->is_on_sale() && $product->get_regular_price() > $product->get_sale_price();
            ?>
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="pw-list-item">
                <img src="<?php echo esc_url( $src ); ?>" alt="" style="width:100px;height:100px;object-fit:cover;border-radius:8px;flex-shrink:0;background:var(--pw-bg-light);" />
                <div style="flex:1;text-align:right;">
                    <div style="font-size:14px;font-weight:600;margin-bottom:2px;font-family:var(--pw-font);">
                        <?php echo esc_html( $product->get_name() ); ?>
                    </div>
                    <?php if ( ! empty( $product->get_attributes() ) ) : ?>
                    <div style="font-size:12px;color:var(--pw-text-muted);margin-bottom:4px;">
                        <?php
                        $attrs = $product->get_attributes();
                        $parts = [];
                        foreach ( $attrs as $attr ) {
                            if ( $attr->is_variation() ) continue;
                            $parts[] = $attr->get_name() . ': ' . implode( ', ', $attr->get_options() );
                        }
                        echo implode( ' | ', $parts );
                        ?>
                    </div>
                    <?php endif; ?>
                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:10px;">
                        <span style="font-size:18px;font-weight:800;color:var(--pw-primary);font-family:var(--pw-font);">
                            <?php echo $price; ?>
                            <?php if ( $on_sale ) : ?>
                                <del style="font-size:13px;color:var(--pw-text-muted);font-weight:400;margin-left:4px;">
                                    <?php echo wc_price( $product->get_regular_price() ); ?>
                                </del>
                            <?php endif; ?>
                        </span>
                        <?php if ( $product->rating ) : ?>
                        <span class="pluginwoo-stars" style="font-size:12px;color:var(--pw-accent);">
                            ★<?php echo esc_html( $product->get_average_rating() ); ?> (<?php echo absint( $product->get_rating_count() ); ?>)
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div style="width:70px;text-align:center;flex-shrink:0;">
                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>"
                       style="display:inline-flex;align-items:center;justify-content:center;width:48px;height:48px;border-radius:50%;background:var(--pw-primary);color:#fff;border:none;cursor:pointer;font-size:20px;text-decoration:none;transition:all .2s;"
                       aria-label="<?php esc_attr_e( 'مشاهده', 'pluginwoo' ); ?>">
                        👁
                    </a>
                </div>
            </a>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
