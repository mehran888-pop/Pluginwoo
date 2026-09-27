<?php
/**
 * Template: Minimal Footer
 */
if ( ! defined( 'ABSPATH' ) ) exit; ?>
<footer class="pluginwoo-footer pluginwoo-footer--minimal" role="contentinfo">
    <div class="pw-ft-inner">
        <div>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="font-weight:700;color:var(--pw-primary);text-decoration:none;font-size:14px;font-family:var(--pw-font);">
                <?php echo esc_html( get_bloginfo( 'name' ) ?: 'فروشگاه'; ?>
            </a>
        </div>
        <div style="font-size:13px;color:var(--pw-text-muted);">
            <?php
            $desc = get_bloginfo( 'description' );
            echo $desc ?: esc_html__( 'فروشگاه آنلاین با بهترین کیفیت.', 'pluginwoo' );
            ?>
        </div>
        <div>
            <div style="display:flex;gap:10px;margin-top:6px;">
                <a href="<?php echo esc_url( wc_get_shop_url() ); ?>" style="text-decoration:none;color:var(--pw-text-muted);font-size:12px;font-family:var(--pw-font);transition:color .15s;">
                    فروشگاه
                </a>
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" style="text-decoration:none;color:var(--pw-text-muted);font-size:12px;font-family:var(--pw-font);transition:color .15s;">
                    سبد خرید
                </a>
                <a href="<?php echo esc_url( wc_get_account_endpoint_url() ); ?>" style="text-decoration:none;color:var(--pw-text-muted);font-size:12px;font-family:var(--pw-font);transition:color .15s;">
                    اکانت
                </a>
            </div>
        </div>
        <div style="text-align:right;font-size:12px;color:var(--pw-text-muted);font-family:var(--pw-font);">
            ©
            <?php echo date_i18n( 'Y' ); ?>
            <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. تمامی حقوق محفوظ است.
        </div>
    </div>
</footer>
