<?php
/**
 * Template: Modern Store Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$products = new WP_Query( array(
    'post_type'      => 'product',
    'posts_per_page' => 12,
    'status'         => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
) );
?>
<div class="pluginwoo-store-modern">
    <div class="pw-modern-header">
        <h1>
            <?php
            $shop_name = get_option( 'woocommerce_shop_page_title', '' );
            echo $shop_name ?: esc_html__( 'فروشگاه', 'pluginwoo' );
            ?>
        </h1>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="pluginwoo-btn pluginwoo-btn--primary" style="padding:10px 20px;font-size:14px;display:inline-flex;">
            <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm13-2h-4v-2h-4v2H2v-4h2v10zm0-12h-4V4h-4v2H2v4h2v4zm0 4h-4v2H2v-2H0v-4h2v4zm11-5H9v2h4V7zm-4 2h2v2h-2V9zm6 6h-2v2h2v-2zm-2-6h-2V9h2v2z"/></svg>
            <?php esc_html_e( 'سبد خرید', 'pluginwoo' ); ?>
            <span id="pw-cart-count" style="background:var(--pw-accent);color:#fff;font-size:11px;font-weight:700;width:18px;height:18px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-left:4px;">
                <?php echo WC()->cart->get_cart_contents_count(); ?>
            </span>
        </a>
    </div>

    <div class="pw-modern-toolbar">
        <div class="pw-toolbar-left">
            <button class="pw-filter-btn active" onclick="this.classList.toggle('active')">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M10 4h4v4h-4V4zm2 9c0 .552-.448 1-1 1s-1-.448-1-1 .448-1 1-1 1 .448 1 1zm-9 4c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zm4 5c0 .552-.448 1-1 1s-1-.448-1-1 .448-1 1-1 1 .448 1 1z"/></svg>
                <?php esc_html_e( 'فیلتر', 'pluginwoo' ); ?>
            </button>
            <select class="pw-sort-select" style="padding:6px 10px;border:1px solid var(--pw-border);border-radius:6px;font-size:12px;font-family:var(--pw-font);background:#fff;">
                <option value="date"><?php esc_html_e( 'جدیدترین', 'pluginwoo' ); ?></option>
                <option value="price-desc"><?php esc_html_e( 'گران‌ترین', 'pluginwoo' ); ?></option>
                <option value="price-asc"><?php esc_html_e( 'ارزان‌ترین', 'pluginwoo' ); ?></option>
            </select>
        </div>
        <div style="font-size:13px;color:var(--pw-text-muted);">
            <?php echo $products->found_posts; ?>
            <?php esc_html_e( 'محصول', 'pluginwoo' ); ?>
        </div>
    </div>

    <div class="pw-store-grid-modern">
        <?php if ( $products->have_posts() ) : ?>
            <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                <?php
                $product = wc_get_product( get_the_ID() );
                if ( ! $product ) continue;
                $thumbnail = $product->get_image_id();
                $imgUrl    = $thumbnail ? wp_get_attachment_image_url( $thumbnail, 'woocommerce_thumbnail' ) : wc_placeholder_img_src();
                $on_sale   = $product->is_on_sale();
                ?>
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="pw-store-card pw-store-card-modern"
                   style="background:var(--pw-bg-card);border-radius:var(--pw-radius);overflow:hidden;box-shadow:var(--pw-shadow-sm);text-decoration:none;color:inherit;transition:all .25s;display:block;">
                    <div class="pw-sc-img" style="position:relative;overflow:hidden;aspect-ratio:1;background:var(--pw-bg-light);">
                        <img src="<?php echo esc_url( $imgUrl ); ?>"
                             style="width:100%;height:100%;object-fit:cover;transition:transform .35s;"
                             alt="" loading="lazy" />
                        <div style="position:absolute;top:10px;left:10px;">
                            <?php if ( $on_sale ) : ?>
                            <span class="pw-pd-badge pluginwoo-badge--sale" style="padding:3px 10px;border-radius:50px;font-size:11px;font-weight:700;">
                                <?php esc_html_e( 'تخفیف', 'pluginwoo' ); ?>
                            </span>
                            <?php elseif ( $product->is_featured() ) : ?>
                            <span class="pw-pd-badge pluginwoo-badge--primary" style="padding:3px 10px;border-radius:50px;font-size:11px;font-weight:700;">
                                <?php esc_html_e( 'برجسته', 'pluginwoo' ); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="pw-sc-actions" style="position:absolute;bottom:0;left:0;right:0;padding:8px;background:linear-gradient(to top,rgba(0,0,0,.7) 0%,transparent 100%);display:flex;gap:6px;opacity:0;transition:opacity .25s;">
                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>"
                               style="flex:1;padding:8px;border-radius:50px;background:#fff;text-decoration:none;color:var(--pw-primary);font-size:11px;font-weight:600;display:flex;align-items:center;justify-content:center;font-family:var(--pw-font);transition:all .15s;"
                               onmouseover="this.style.background='var(--pw-primary)';this.style.color='#fff';"
                               onmouseout="this.style.background='#fff';this.style.color='var(--pw-primary)';">
                                <?php esc_html_e( 'مشاهده', 'pluginwoo' ); ?>
                            </a>
                        </div>
                    </div>
                    <div class="pw-sc-info" style="padding:12px;">
                        <div style="font-size:13px;font-weight:600;margin-bottom:4px;line-height:1.4;font-family:var(--pw-font);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            <?php echo esc_html( $product->get_name() ); ?>
                        </div>
                        <div style="font-size:15px;font-weight:800;color:var(--pw-primary);font-family:var(--pw-font);">
                            <?php echo wc_price( $product->get_price() ); ?>
                            <?php if ( $on_sale && $product->get_regular_price() ) : ?>
                                <del style="font-size:12px;color:var(--pw-text-muted);font-weight:400;margin-left:4px;">
                                    <?php echo wc_price( $product->get_regular_price() ); ?>
                                </del>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>
