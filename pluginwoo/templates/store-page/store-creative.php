<?php
/**
 * Template: Creative Store Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$products = new WP_Query( array(
    'post_type'      => 'product',
    'posts_per_page' => 16,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'status'         => 'publish',
) );
?>
<div class="pluginwoo-store-creative">
    <!-- Top Banner -->
    <div class="pw-store-top">
        <h1>
            <?php
            $shop_name = get_option( 'woocommerce_shop_page_title', '' );
            echo $shop_name ? esc_html( $shop_name ) : esc_html__( 'فروشگاه خلاقانه ما', 'pluginwoo' );
            ?>
        </h1>
        <p>
            <?php esc_html_e( 'سطح‌های خلاقانه برای نمایش محصولات با تأثیرات بصری جذاب و تجربه کاربری مدرن.', 'pluginwoo' ); ?>
        </p>
    </div>

    <!-- Category Strip -->
    <?php $categories = get_terms( array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'number'     => 12,
    ) ); ?>
    <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
    <div class="pw-store-banner-strip">
        <?php foreach ( $categories as $cat ) : ?>
        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="pw-strip-item <?php echo is_product_category( $cat->term_id ) ? 'active' : ''; ?>"
           style="background:var(--pw-bg-card);border-radius:10px;overflow:hidden;box-shadow:var(--pw-shadow-sm);cursor:pointer;flex-shrink:0;width:220px;text-decoration:none;color:inherit;">
            <?php if ( $cat->image ) : ?>
            <img src="<?php echo esc_url( $cat->image ); ?>" alt="" style="width:100%;height:100px;object-fit:cover;display:block;" />
            <?php else : ?>
            <div style="background:var(--pw-bg-light);height:100px;display:flex;align-items:center;justify-content:center;color:var(--pw-text-muted);font-size:24px;border-bottom:1px solid var(--pw-border);">
                <svg width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M4 8h16v12.785c0 .538-.404.976-.905.976H4.905c-.5.002-.905-.438-.905-.976V8zm16 .712V20H4V8h16v.712c0 .636-.433 1.137-.99 1.268l.07.022c.228.056.352.326.126.326H4.174c-.226 0-.1.27-.1.27v.002l.001-.001h.042c.219.066.462.154.707.262l.015.006c.234.076.412.348.336.582.135-1.609 1.381-2.887 2.994-2.887 1.463 0 2.673 1.065 2.908 2.4.036.186.21.324.44.288l.014-.012c.106-.093.195-.196.274-.31.178-.258.3-.616.3-.954v-.003c0-.568-.453-1.022-.998-1.022l-.004-.001c-.474 0-.878.364-.994.885L19.995 9H4V8.5l15.995.5z"/></svg>
            </div>
            <?php endif; ?>
            <div class="pw-strip-info">
                <h4 style="font-size:13px;font-weight:600;margin-bottom:2px;font-family:var(--pw-font);">
                    <?php echo esc_html( $cat->name ); ?>
                </h4>
                <p style="font-size:11px;color:var(--pw-text-muted);margin:0;">
                    <?php echo absint( $cat->count ); ?>
                    <?php esc_html_e( 'محصول', 'pluginwoo' ); ?>
                </p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Toolbar -->
    <div class="pw-store-toolbar">
        <div class="pw-toolbar-left">
            <button class="pw-filter-btn active" onclick="this.classList.toggle('active')">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M10 4h4v4h-4V4zm2 9c0 .552-.448 1-1 1s-1-.448-1-1 .448-1 1-1 1 .448 1 1zm-9 4c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zm4 5c0 .552-.448 1-1 1s-1-.448-1-1 .448-1 1-1 1 .448 1 1z"/></svg>
                <?php esc_html_e( 'فیلتر', 'pluginwoo' ); ?>
            </button>
            <button class="pw-filter-btn" onclick="this.classList.toggle('active')">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M3 18h6v-2H3v2zm0-5h6V11H3v2zm0-5h6V6H3v2zm6 6v2h6V6h-6zm6 4v2h6v-2h-6zm-6 5v2h6v-2h-6z"/></svg>
                <?php esc_html_e( 'مرتب‌سازی', 'pluginwoo' ); ?>
            </button>
            <select class="pw-sort-select">
                <option value="date"><?php esc_html_e( 'جدیدترین', 'pluginwoo' ); ?></option>
                <option value="price-desc"><?php esc_html_e( 'گران‌ترین', 'pluginwoo' ); ?></option>
                <option value="price-asc"><?php esc_html_e( 'ارزان‌ترین', 'pluginwoo' ); ?>
                <option value="rating"><?php esc_html_e( 'پرفروش‌ترین', 'pluginwoo' ); ?></option>
            </select>
        </div>
        <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--pw-text-muted);">
            <span style="font-family:var(--pw-font);font-weight:600;color:var(--pw-text);">
                <?php echo $products->found_posts; ?>
            </span>
            <?php esc_html_e( 'محصول نشان داده شده', 'pluginwoo' ); ?>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="pw-store-grid">
        <?php if ( $products->have_posts() ) : ?>
            <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                <?php
                $product = wc_get_product( get_the_ID() );
                if ( ! $product ) continue;
                $thumbnail = $product->get_image_id();
                $imgUrl    = $thumbnail ? wp_get_attachment_image_url( $thumbnail, 'woocommerce_thumbnail' ) : wc_placeholder_img_src();
                $on_sale   = $product->is_on_sale();
                $sold_count = $product->get_total_sales();
                ?>
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="pw-store-card"
                   style="background:var(--pw-bg-card);border-radius:var(--pw-radius);overflow:hidden;box-shadow:var(--pw-shadow-sm);text-decoration:none;color:inherit;transition:all .25s;">
                    <div class="pw-sc-img" style="position:relative;overflow:hidden;aspect-ratio:1;background:var(--pw-bg-light);">
                        <img src="<?php echo esc_url( $imgUrl ); ?>"
                             style="width:100%;height:100%;object-fit:cover;transition:transform .35s;"
                             alt="" loading="lazy" />
                        <div class="pw-sc-actions" style="position:absolute;bottom:0;left:0;right:0;padding:10px;background:linear-gradient(to top,rgba(0,0,0,.75) 0%,transparent 100%);display:flex;gap:6px;opacity:0;transition:opacity .25s;">
                            <button type="submit" form="wc-form-<?php echo esc_attr( $product->get_id() ); ?>"
                                    class="pw-sc-add-btn pw-atc-btn"
                                    style="width:38px;height:38px;border-radius:50%;background:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--pw-primary);font-size:18px;box-shadow:0 2px 8px rgba(0,0,0,.2);transition:all .2s;"
                                    data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
                                    aria-label="<?php esc_attr_e( 'افزودن به سبد خرید', 'pluginwoo' ); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            </button>

                            <!-- Hidden WC form for each product (no-js fallback) -->
                            <form method="post" action="<?php echo esc_url( wc_get_cart_url() ); ?>" id="wc-form-<?php echo esc_attr( $product->get_id() ); ?>" style="display:none;">
                                <?php woocommerce_cart_button_inline(); ?>
                                <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
                            </form>
                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>"
                               style="flex:1;padding:8px 10px;border-radius:50px;background:rgba(255,255,255,.9);text-decoration:none;color:var(--pw-text);font-size:12px;font-weight:600;display:flex;align-items:center;justify-content:center;font-family:var(--pw-font);font-size:11px;white-space:nowrap;"
                               aria-label="<?php esc_attr_e( 'مشاهده', 'pluginwoo' ); ?>">
                                <svg width="12" height="12" viewBox="0 0 24 24"><path fill="currentColor" d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                        <?php if ( $on_sale ) : ?>
                        <div class="pw-pd-badge pluginwoo-badge--sale" style="position:absolute;top:10px;left:10px;padding:3px 10px;border-radius:50px;font-size:11px;font-weight:700;background:#ef4444;color:#fff;">
                            <?php esc_html_e( 'تخفیف', 'pluginwoo' ); ?>
                        </div>
                        <?php endif; ?>
                        <?php if ( $sold_count > 0 ) : ?>
                        <div style="position:absolute;top:10px;right:10px;background:rgba(0,0,0,.6);backdrop-filter:blur(4px);color:#fff;padding:3px 10px;border-radius:50px;font-size:11px;font-weight:600;display:flex;align-items:center;gap:4px;">
                            <svg width="10" height="10" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4l-1.41 1.41L10 11.83l1.41 1.41L12 13.66l2.12 2.12 1.41-1.41L14 11.83l-1.41-1.41z"/></svg>
                            <?php echo esc_html( $sold_count ); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="pw-sc-info" style="padding:12px 14px;">
                        <div style="font-size:13px;font-weight:600;margin-bottom:4px;line-height:1.4;font-family:var(--pw-font);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            <?php echo esc_html( $product->get_name() ); ?>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <?php if ( $on_sale ) : ?>
                            <span style="font-size:12px;color:var(--pw-text-muted);text-decoration:line-through;">
                                <?php echo wc_price( $product->get_regular_price() ); ?>
                            </span>
                            <?php endif; ?>
                            <span style="font-size:15px;font-weight:800;color:var(--pw-primary);font-family:var(--pw-font);">
                                <?php echo wc_price( $product->get_price() ); ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
            <?php else : ?>
            <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--pw-text-muted);font-family:var(--pw-font);">
                <?php esc_html_e( 'هنوز محصولی اضافه نشده است.', 'pluginwoo' ); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination hint -->
    <div style="margin-top:32px;text-align:center;font-size:13px;color:var(--pw-text-muted);font-family:var(--pw-font);">
        <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M10 18h10v-2H10v2zm1-8l-5 5v5h5v-5l5-5z"/></svg>
        <?php esc_html_e( 'صفحه بعدی — به زودی', 'pluginwoo' ); ?>
    </div>
</div>
