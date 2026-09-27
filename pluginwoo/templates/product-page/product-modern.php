<?php
/**
 * Template: Modern Product Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;

global $product;
if ( ! $product ) return;
?>
<div class="pluginwoo-product-modern">
    <!-- Left Gallery -->
    <div class="pw-pm-gallery">
        <div class="pw-pm-gallery-main">
            <?php echo $product->get_image( 'woocommerce_single' ); ?>
        </div>
        <?php
        $thumb_ids = $product->get_image_ids();
        if ( count( $thumb_ids ) > 1 ) : ?>
        <div class="pw-pm-thumbs">
            <?php foreach ( $thumb_ids as $thumb_id ) : ?>
                <div class="pw-pm-thumb <?php echo ( reset( $thumb_ids ) === $thumb_id ) ? 'active' : ''; ?>">
                    <?php echo wp_get_attachment_image( $thumb_id, 'woocommerce_thumbnail' ); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Right Info -->
    <div class="pw-pm-info">
        <div class="pw-pm-category">
            <?php
            $cats = $product->get_category_ids();
            if ( ! empty( $cats ) ) {
                $cat = get_term( $cats[0], 'product_cat' );
                if ( $cat ) echo esc_html( $cat->name );
            }
            ?>
        </div>

        <h1 class="pw-pm-title">
            <?php echo esc_html( $product->get_name() ); ?>
        </h1>

        <?php if ( $product->get_rating() ) : ?>
        <div class="pw-pm-rating">
            <span class="pw-pm-rating-stars">
                <?php echo wc_get_rating_html( $product->get_average_rating(), $product->get_rating_count() ); ?>
            </span>
            <span class="pw-pm-rating-count">
                (<?php echo absint( $product->get_rating_count() ); ?>
                <?php esc_html_e( '评论<Comment>.', 'pluginwoo' ); ?>
                )
            </span>
        </div>
        <?php endif; ?>

        <?php echo $product->get_price_html(); ?>

        <?php if ( $product->get_sku() ) : ?>
        <p style="font-size:12px;color:var(--pw-text-muted);margin-bottom:12px;">
            SKU: <?php echo esc_html( $product->get_sku() ); ?>
        </p>
        <?php endif; ?>

        <div class="pw-pm-short-desc">
            <?php
            $short_desc = $product->get_short_description();
            echo $short_desc ? esc_html( $short_desc ) : esc_html__( 'این محصول با دقت بالا و کیفیت مورد αξιت تولید شده است. برای اطلاعات بیشتر به بخش توضیحات مراجعه کنید.', 'pluginwoo' );
            ?>
        </div>

        <div class="pw-pm-divider"></div>

        <div class="pw-tags">
            <?php $tags = $product->get_tag_ids(); ?>
            <?php if ( ! empty( $tags ) ) : ?>
                <?php foreach ( $tags as $tag_id ) :
                    $tag = get_term( $tag_id, 'product_tag' );
                    if ( $tag ) : ?>
                    <span class="pw-tag">
                        <a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" style="color:var(--pw-text-muted);">
                            <?php echo esc_html( $tag->name ); ?>
                        </a>
                    </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="pw-pm-atc-section">
            <div class="pw-pm-qty">
                <button type="button" class="pw-pm-qty-btn" aria-label="<?php esc_attr_e( 'Reduce', 'pluginwoo' ); ?>">−</button>
                <input type="number" class="pw-pm-qty-input" id="pw-qty-input" value="1" min="1" max="<?php echo esc_attr( $product->get_max_purchase_qty() ?: 99 ); ?>" />
                <button type="button" class="pw-pm-qty-btn" aria-label="<?php esc_attr_e( 'Increase', 'pluginwoo' ); ?>">+</button>
            </div>
            <button type="submit" class="pw-pm-atc-btn" aria-label="<?php esc_attr_e( 'افزودن به سبد خرید', 'pluginwoo' ); ?>">
                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                <span id="pw-atc-btn-text"><?php esc_html_e( 'افزودن به سبد خرید', 'pluginwoo' ); ?></span>
            </button>
        </div>

        <div class="pw-pm-stock">
            <?php if ( $product->is_in_stock() ) : ?>
            <span class="pw-pm-stock in-stock">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4l-1.41 1.41L10 11.83l1.41 1.41L12 13.66l2.12 2.12 1.41-1.41L14 11.83l-1.41-1.41z"/></svg>
                <?php esc_html_e( 'در انبار موجود است', 'pluginwoo' ); ?>
            </span>
            <?php else : ?>
            <span class="pw-pm-stock out-stock">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M11 3L6 8H3v11h8V8h5L13 3z"/></svg>
                <?php esc_html_e( 'فروخته شده از انبار', 'pluginwoo' ); ?>
            </span>
            <?php endif; ?>
        </div>

        <?php
        // SKU, attributes
        $attrs = $product->get_attributes();
        $non_variation_attrs = array_filter( $attrs, function ( $a ) { return ! $a->is_variation(); } );
        ?>
        <?php if ( ! empty( $non_variation_attrs ) ) : ?>
        <div class="pw-pm-divider"></div>
        <?php foreach ( $non_variation_attrs as $attr ) : ?>
        <div style="margin-bottom:8px;font-size:13px;">
            <span style="font-weight:700;color:var(--pw-text);margin-right:6px;">
                <?php echo esc_html( $attr->get_name() ); ?>:
            </span>
            <span style="color:var(--pw-text-muted);">
                <?php echo esc_html( implode( ', ', (array) $attr->get_options() ) ); ?>
            </span>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- Tabs -->
        <div class="pw-pm-tabs" style="margin-top:16px;">
            <button class="pw-pm-tab-btn active" data-tab-target="pw-desc-tab" onclick="switchProductTab(this)">
                <?php esc_html_e( 'توضیحات', 'pluginwoo' ); ?>
            </button>
            <button class="pw-pm-tab-btn" data-tab-target="pw-rev-tab" onclick="switchProductTab(this)">
                <?php esc_html_e( 'نظرات', 'pluginwoo' ); ?>
            </button>
            <button class="pw-pm-tab-btn" data-tab-target="pw-extra-tab" onclick="switchProductTab(this)">
                <?php esc_html_e( 'اطلاعات اضافی', 'pluginwoo' ); ?>
            </button>
        </div>

        <div id="pw-desc-tab" class="pw-pm-tab-content" style="display:block;">
            <?php echo $product->get_description(); ?>
        </div>
        <div id="pw-rev-tab" class="pw-pm-tab-content" style="display:none;">
            <?php echo $product->get_reviews(); ?>
        </div>
        <div id="pw-extra-tab" class="pw-pm-tab-content" style="display:none;">
            <div style="max-height:200px;overflow-y:auto;padding-right:8px;">
                <?php echo $product->get_ancestors(); ?>
                <?php if ( $product->get_attributes() ) : ?>
                <div style="margin-bottom:12px;font-family:var(--pw-font);">
                    <strong style="color:var(--pw-text);">ویژگی‌های محصول:</strong>
                    <?php foreach ( $attrs as $attr ) : ?>
                    <div style="margin-bottom:4px;color:var(--pw-text-muted);">
                        <?php echo esc_html( $attr->get_name() ); ?>: <?php echo esc_html( implode( ', ', (array) $attr->get_options() ) ); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <form class="pw-hidden-form" method="post" action="<?php echo esc_url( wc_get_cart_url() ); ?>" style="display:none;">
            <?php woocommerce_cart_button_inline(); ?>
        </form>

        <?php do_action( 'woocommerce_single_product_summary' ); ?>
    </div>
</div>

<script>
function switchProductTab(btn) {
    const parent = btn.closest('.pw-pm-tabs');
    parent.querySelectorAll('.pw-pm-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const targetId = btn.getAttribute('data-tab-target');
    parent.parentElement.querySelectorAll('.pw-pm-tab-content').forEach(p => p.style.display = 'none');
    const target = document.getElementById(targetId);
    if (target) target.style.display = 'block';
}
</script>
