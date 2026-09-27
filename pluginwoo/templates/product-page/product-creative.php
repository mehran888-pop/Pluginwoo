<?php
/**
 * Template: Creative Product Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;

global $product;
if ( ! $product ) return;
?>
<div class="pluginwoo-product-creative">
    <div class="pw-pc-grid">
        <!-- Left Gallery -->
        <div class="pw-pc-gallery">
            <?php echo $product->get_image( 'woocommerce_single' ); ?>
            <?php if ( $product->is_on_sale() ) : ?>
            <div style="position:absolute;top:16px;left:16px;background:var(--pw-secondary);color:#fff;padding:6px 14px;border-radius:50px;font-size:12px;font-weight:700;box-shadow:0 2px 8px rgba(0,0,0,.2);z-index:2;">
                <?php esc_html_e( 'فروش適合', 'pluginwoo' ); ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right Info -->
        <div class="pw-pc-info">
            <div style="margin-bottom:12px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                <div style="font-size:12px;color:var(--pw-primary);font-weight:600;text-transform:uppercase;letter-spacing:.06em;">
                    <?php
                    $cats = $product->get_category_ids();
                    if ( ! empty( $cats ) ) {
                        $cat = get_term( $cats[0], 'product_cat' );
                        if ( $cat ) echo esc_html( $cat->name );
                    }
                    ?>
                </div>
                <div style="display:flex;gap:6px;">
                    <?php if ( $product->get_rating() ) : ?>
                    <span class="pluginwoo-stars" style="font-size:13px;color:var(--pw-accent);letter-spacing:1px;">★<?php echo esc_html( $product->get_average_rating() ); ?></span>
                    <?php endif; ?>
                    <?php if ( $product->is_featured() ) : ?>
                    <span class="pluginwoo-badge pluginwoo-badge--primary" style="font-size:11px;">
                        <?php esc_html_e( 'برجسته', 'pluginwoo' ); ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <h1 style="font-size:22px;font-weight:800;margin-bottom:12px;line-height:1.4;font-family:var(--pw-font);">
                <?php echo esc_html( $product->get_name() ); ?>
            </h1>

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;flex-wrap:wrap;">
                <span style="font-size:22px;font-weight:800;color:var(--pw-primary);font-family:var(--pw-font);">
                    <?php echo $product->get_price_html(); ?>
                </span>
                <?php if ( $product->get_regular_price() && $product->get_price() !== $product->get_regular_price() ) : ?>
                <span style="font-size:14px;color:var(--pw-text-muted);text-decoration:line-through;">
                    <?php echo wc_price( $product->get_regular_price() ); ?>
                </span>
                <?php endif; ?>
                <?php if ( $product->is_in_stock() ) : ?>
                <span style="background:#d1fae5;color:#065f46;padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                    <?php esc_html_e( 'موجود در انبار', 'pluginwoo' ); ?>
                </span>
                <?php else : ?>
                <span style="background:#fef2f2;color:#dc2626;padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                    <?php esc_html_e( 'Out of stock', 'pluginwoo' ); ?>
                </span>
                <?php endif; ?>
            </div>

            <div style="padding:14px;background:var(--pw-bg-light);border-radius:10px;margin-bottom:16px;font-size:14px;line-height:1.7;color:var(--pw-text-muted);">
                <?php
                $short_desc = $product->get_short_description();
                echo $short_desc ? esc_html( $short_desc ) : esc_html__( 'این محصول با بهترین کیفیت برای شما طراحی شده است. برای مطالعه بیشتر، بخش توضیحات را بررسی کنید.', 'pluginwoo' );
                ?>
            </div>

            <div style="display:flex;gap:10px;align-items:center;margin-bottom:20px;flex-wrap:wrap;">
                <div class="pw-pm-qty" style="display:flex;align-items:center;border:1.5px solid var(--pw-border);border-radius:var(--pw-radius-sm);overflow:hidden;">
                    <button type="button" class="pw-pm-qty-btn" style="width:38px;height:38px;border:none;background:var(--pw-bg-light);cursor:pointer;font-size:16px;font-weight:700;color:var(--pw-text);transition:all .15s;display:flex;align-items:center;justify-content:center;">−</button>
                    <input type="number" class="pw-pm-qty-input" id="pw-creative-qty" value="1" min="1" max="99"
                           style="width:52px;text-align:center;font-weight:700;font-size:14px;border:none;background:#fff;padding:6px 4px;font-family:var(--pw-font);" />
                    <button type="button" class="pw-pm-qty-btn" style="width:38px;height:38px;border:none;background:var(--pw-bg-light);cursor:pointer;font-size:16px;font-weight:700;color:var(--pw-text);transition:all .15s;display:flex;align-items:center;justify-content:center;">+</button>
                </div>
                <button type="submit" class="pluginwoo-btn pluginwoo-btn--primary single_add_to_cart_button"
                        style="flex:1;padding:12px 20px;font-size:14px;display:inline-flex;align-items:center;justify-content:center;gap:8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    <?php esc_html_e( 'افزودن به سبد خرید', 'pluginwoo' ); ?>
                </button>
            </div>

            <!-- Tabs Area -->
            <div class="pw-pm-tabs" style="border-top:1px solid var(--pw-border);margin-top:12px;padding-top:12px;">
                <button class="pw-pm-tab-btn active" data-tab-target="pc-desc" onclick="switchProductTab(this)">
                    <?php esc_html_e( 'توضیحات', 'pluginwoo' ); ?>
                </button>
                <button class="pw-pm-tab-btn" data-tab-target="pc-spec" onclick="switchProductTab(this)">
                    <?php esc_html_e( 'ویژگی‌ها', 'pluginwoo' ); ?>
                </button>
                <button class="pw-pm-tab-btn" data-tab-target="pc-review" onclick="switchProductTab(this)">
                    <?php esc_html_e( 'نظرات', 'pluginwoo' ); ?>
                </button>
            </div>

            <div id="pc-desc" class="pw-pm-tab-content" style="display:block;padding:12px 0;font-size:14px;line-height:1.7;color:var(--pw-text-muted);">
                <?php echo $product->get_description(); ?>
            </div>
            <div id="pc-spec" class="pw-pm-tab-content" style="display:none;padding:12px 0;font-size:13px;">
                <?php
                $attrs = $product->get_attributes();
                foreach ( $attrs as $attr ) :
                    if ( ! $attr->is_variation() ) :
                        ?>
                        <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px dashed var(--pw-border);">
                            <strong style="color:var(--pw-text);font-family:var(--pw-font);">
                                <?php echo esc_html( $attr->get_name() ); ?>
                            </strong>
                            <span style="color:var(--pw-text-muted);">
                                <?php echo esc_html( implode( ', ', (array) $attr->get_options() ) ); ?>
                            </span>
                        </div>
                        <?php
                    endif;
                endforeach;
                ?>
            </div>
            <div id="pc-review" class="pw-pm-tab-content" style="display:none;padding:12px 0;">
                <?php echo $product->get_reviews(); ?>
            </div>
        </div>
    </div>
</div>

<script>
function switchProductTab(btn) {
    btn.closest('.pw-pm-tabs').querySelectorAll('.pw-pm-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const id = btn.getAttribute('data-tab-target');
    document.querySelectorAll('.pw-pm-tab-content').forEach(p => p.style.display = 'none');
    document.getElementById(id).style.display = 'block';
}
</script>
