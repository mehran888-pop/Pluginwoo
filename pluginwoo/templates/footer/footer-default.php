<?php
/**
 * Template: Default Footer
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$has_wc = function_exists( 'WC' );
$cart_url       = $has_wc ? wc_get_cart_url() : home_url( 'cart' );
$checkout_url   = $has_wc ? wc_get_checkout_url() : home_url( 'checkout' );
$account_url    = $has_wc ? wc_get_account_endpoint_url() : home_url( 'my-account' );
$coupon_url     = $has_wc && wc_get_page_id( 'coupon' ) ? get_permalink( wc_get_page_id( 'coupon' ) ) : '#';
$terms_url      = $has_wc && wc_get_page_id( 'terms' ) ? get_permalink( wc_get_page_id( 'terms' ) ) : '#';

$socials = array(
    'instagram' => '#',
    'telegram'  => '#',
    'whatsapp'  => '#',
    'sitemap'   => '#',
);
?>
<footer class="pluginwoo-footer pluginwoo-footer--default" role="contentinfo">
    <div class="pw-ft-inner">
        <!-- About -->
        <div>
            <h4>
                <?php echo esc_html( get_bloginfo( 'name' ) ?: 'فروشگاه ما' ); ?>
            </h4>
            <p>
                <?php
                $description = get_bloginfo( 'description' );
                echo $description ?: esc_html__( 'فروشگاه آنلاین باکیفیت، با بهترین محصولات و قیمت‌های رقابتی.', 'pluginwoo' );
                ?>
            </p>
            <div class="pw-ft-social">
                <?php foreach ( $socials as $network => $url ) : ?>
                <a href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $network ); ?>"
                   style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;transition:all .2s;text-decoration:none;color:rgba(255,255,255,.7);">
                    <?php
                    $icons = array(
                        'instagram' => '📷',
                        'telegram'  => '✈',
                        'whatsapp'  => '💬',
                        'sitemap'   => '🗺',
                    );
                    echo $icons[ $network ] ?? '?';
                    ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Categories -->
        <div>
            <h4>
                <?php esc_html_e( 'دسته‌بندی‌ها', 'pluginwoo' ); ?>
            </h4>
            <?php
            $cats = get_terms( array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'number'     => 6,
            ) );
            if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) :
                foreach ( $cats as $cat ) :
                    $cat_link = $has_wc ? get_term_link( $cat ) : home_url();
                    ?>
                <p><a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat->name ); ?></a></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Quick Links -->
        <div>
            <h4>
                <?php esc_html_e( 'زیرساخت‌ها', 'pluginwoo' ); ?>
            </h4>
            <p><a href="<?php echo esc_url( $cart_url ); ?>"><?php esc_html_e( 'سبد خرید', 'pluginwoo' ); ?></a></p>
            <p><a href="<?php echo esc_url( $checkout_url ); ?>"><?php esc_html_e( 'صورت‌حساب', 'pluginwoo' ); ?></a></p>
            <p><a href="<?php echo esc_url( $account_url ); ?>"><?php esc_html_e( 'حساب کاربری', 'pluginwoo' ); ?></a></p>
            <p><a href="<?php echo esc_url( $coupon_url ); ?>"><?php esc_html_e( 'کوپن‌ها', 'pluginwoo' ); ?></a></p>
            <p><a href="<?php echo esc_url( $terms_url ); ?>"><?php esc_html_e( 'قوانین و شرایط', 'pluginwoo' ); ?></a></p>
        </div>

        <!-- Contact -->
        <div>
            <h4>
                <?php esc_html_e( 'تماس با ما', 'pluginwoo' ); ?>
            </h4>
            <p>
                <svg width="14" height="14" viewBox="0 0 24 24" style="vertical-align:-2px;margin-right:4px;"><path fill="currentColor" d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-4v2l-2 1z"/></svg>
                <?php
                $admin_email = get_option( 'admin_email' );
                echo $admin_email ? esc_html( $admin_email ) : esc_html__( '(ایمیل)', 'pluginwoo' );
                ?>
            </p>
            <p>
                <svg width="14" height="14" viewBox="0 0 24 24" style="vertical-align:-2px;margin-right:4px;"><path fill="currentColor" d="M6.62 10.79c1.44 2.83 3.76 5.02 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .14 1.45-.36 2.48-3.25 3.58-3.57 5.44-5.51l3.34-2.68c1.55-1.21 1.9-2.87.76-4.35-.78-1-2.22-1.63-3.89-1.63h-.04c-2.75 0-4.96 2.21-4.96 4.96 0 2.26.86 4.23 2.31 5.69l2.35 2.35c.34.34.43.85.27 1.28l1.28 1.28c.34.34.85.44 1.28.27.29-.1.57-.26.81-.48l2.17-2.17c.4-.4.4-.94.01-1.34l-1.34-1.34c-.4-.4-.94-.4-.34.01z"/></svg>
                <?php esc_html_e( 'برای پشتیبانی تماس بگیرید.', 'pluginwoo' ); ?>
            </p>
        </div>
    </div>

    <div class="pw-ft-bottom">
        <p>
            <?php esc_html_e( '© ۱۴۰۴ —', 'pluginwoo' ); ?>
            <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
            <?php esc_html_e( '. تمامی حقوق محفوظ است.', 'pluginwoo' ); ?>
        </p>
        <div>
            <a href="#"><?php esc_html_e( 'سیاست حفظ حریم شخصی', 'pluginwoo' ); ?></a>
            |
            <a href="#"><?php esc_html_e( 'سایت‌ست', 'pluginwoo' ); ?></a>
        </div>
    </div>
</footer>
