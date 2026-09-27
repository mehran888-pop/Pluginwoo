<?php
/**
 * Template: Minimal My Account
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pluginwoo-wrapper pluginwoo-myaccount-minimal">
    <div style="text-align:center;padding:20px 0;">
        <h1 style="font-size:20px;font-family:var(--pw-font);font-weight:700;margin-bottom:4px;">
            <?php esc_html_e( 'ناحیه کاربری', 'pluginwoo' ); ?>
        </h1>
        <p style="font-size:13px;color:var(--pw-text-muted);margin:0 0 20px;">
            <?php
            $user = wp_get_current_user();
            echo sprintf( esc_html__( 'سلام %s — ایمیل شما: %s', 'pluginwoo' ), esc_html( $user->display_name ), esc_html( $user->email ) );
            ?>
        </p>
    </div>

    <style>
    .pw-min-nav { display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px; }
    .pw-min-nav a { text-decoration:none; padding:8px 16px; border:1px solid var(--pw-border); border-radius:8px; color:var(--pw-text); font-size:13px; font-family:var(--pw-font); transition:all .15s; }
    .pw-min-nav a:hover { border-color:var(--pw-primary); color:var(--pw-primary); background:rgba(79,70,229,.06); }
    .pw-min-section { margin-bottom:24px; }
    .pw-min-section h3 { font-size:16px; margin-bottom:10px; padding-bottom:8px; border-bottom:1px solid var(--pw-border); font-family:var(--pw-font); }
    </style>

    <nav class="pw-min-nav">
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>">
            <?php esc_html_e( 'داشبورد', 'pluginwoo' ); ?>
        </a>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>">
            <?php esc_html_e( 'سفارش‌ها', 'pluginwoo' ); ?>
        </a>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'downloads' ) ); ?>">
            <?php esc_html_e( 'دانلودها', 'pluginwoo' ); ?>
        </a>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-address' ) ); ?>">
            <?php esc_html_e( 'آدرس‌ها', 'pluginwoo' ); ?>
        </a>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'payment-methods' ) ); ?>">
            <?php esc_html_e( 'روش‌های پرداخت', 'pluginwoo' ); ?>
        </a>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'account-details' ) ); ?>">
            <?php esc_html_e( 'اطلاعات حساب', 'pluginwoo' ); ?>
        </a>
    </nav>

    <?php woocommerce_my_account(); ?>
</div>
