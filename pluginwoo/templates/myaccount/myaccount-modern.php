<?php
/**
 * Template: Modern My Account
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$user = wp_get_current_user();
$current_user = wc_get_order_count_for_user( $user->ID );
?>
<div class="pluginwoo-wrapper pluginwoo-myaccount-modern">
    <!-- Header -->
    <div class="pw-myaccount-header">
        <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
            <div class="pw-welcome-avatar" style="width:56px;height:56px;font-size:22px;background:linear-gradient(135deg,var(--pw-secondary),var(--pw-secondary-dark));">
                <?php echo esc_html( strtoupper( substr( $user->display_name, 0, 1 ) . substr( $user->last_name ?? '', 0, 1 ) ) ); ?>
            </div>
            <div>
                <h2 style="margin:0;font-size:20px;font-family:var(--pw-font);">
                    <?php esc_html_e( 'به پنل کاربری خوش آمدید,', 'pluginwoo' ); ?>
                    <?php echo esc_html( $user->display_name ); ?>
                </h2>
                <p style="margin:2px 0 0;opacity:.85;">
                    <?php echo esc_html( $user->email ); ?>
                </p>
            </div>
        </div>

        <div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap;">
            <span class="pluginwoo-badge pluginwoo-badge--secondary">
                <?php echo esc_html( $current_user ); ?>
                <?php esc_html_e( ' سفارش', 'pluginwoo' ); ?>
            </span>
            <?php if ( wc_is_customer_wholesale() ) : ?>
            <span class="pluginwoo-badge pluginwoo-badge--primary">
                <?php esc_html_e( 'خریدار صنعتی', 'pluginwoo' ); ?>
            </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="pw-myaccount-body">
        <!-- Sidebar Nav -->
        <nav class="pw-myaccount-nav">
            <?php
            $current = isset( $_GET['view'] ) ? sanitize_key( $_GET['view'] ) : '';
            $menu_links = WC()->nav->get_my_account_menu();

            if ( ! empty( $menu_links ) ) :
                foreach ( $menu_links as $key => $link ) :
                    $active = ( ! empty( $current ) && $key === $current ) || ( empty( $current ) && 'dashboard' === $key );
                    $icon = isset( $link['icon'] ) ? $link['icon'] : '';
                    ?>
                    <a href="<?php echo esc_url( $link['url'] ); ?>"
                       class="pw-nav-item <?php echo $active ? 'active' : ''; ?>"
                       data-shortcut="<?php echo esc_attr( $key ); ?>">
                        <?php if ( $icon ) : ?>
                        <span style="font-size:16px;"><?php echo esc_html( $icon ); ?></span>
                        <?php endif; ?>
                        <span style="font-family:var(--pw-font);"><?php echo esc_html( $link[' label'] ); ?></span>
                    </a>
                    <?php
                endforeach;
            endif;
            ?>
        </nav>

        <!-- Content -->
        <div class="pw-myaccount-content">
            <?php
            // Dashboard view
            if ( empty( $current ) || 'dashboard' === $current ) :
                $last_order = wc_get_orders( array(
                    'customer_id' => get_current_user_id(),
                    'limit'       => 1,
                    'orderby'     => 'date',
                    'order'       => 'DESC',
                ) );
                $last_order = $last_order ? $last_order[0] : null;
                ?>
                <div class="pw-welcome-card">
                    <div class="pw-welcome-avatar">👤</div>
                    <div class="pw-welcome-info">
                        <h3><?php esc_html_e( 'سفارش اخیر', 'pluginwoo' ); ?></h3>
                        <p>
                            <?php if ( $last_order ) : ?>
                            <span class="pluginwoo-badge pluginwoo-badge--primary">
                                <?php echo esc_html( $last_order->get_order_number() ); ?>
                            </span>
                            <span style="margin-left:8px;font-size:13px;color:var(--pw-text-muted);">
                                <?php echo wc_price( $last_order->get_total() ); ?> — <?php echo esc_html( $last_order->get_date()->date( 'Y/m/d' ) ); ?>
                            </span>
                            <?php else : ?>
                            <?php esc_html_e( 'شما هنوز سفارشی ندارید.', 'pluginwoo' ); ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px;">
                    <div class="pluginwoo-card" style="text-align:center;padding:16px;">
                        <div style="font-size:24px;margin-bottom:4px;">📦</div>
                        <div style="font-size:22px;font-weight:800;color:var(--pw-primary);font-family:var(--pw-font);">
                            <?php echo count( wc_get_orders( array( 'customer_id' => get_current_user_id(), 'status' => 'completed', 'limit' => 100 ) ) ); ?>
                        </div>
                        <div style="font-size:11px;color:var(--pw-text-muted);margin:0;">
                            <?php esc_html_e( 'سفارش‌های تکمیل شده', 'pluginwoo' ); ?>
                        </div>
                    </div>
                    <div class="pluginwoo-card" style="text-align:center;padding:16px;background:linear-gradient(135deg,rgba(79,70,229,.08),rgba(16,185,129,.08));">
                        <div style="font-size:24px;margin-bottom:4px;">💳</div>
                        <div style="font-size:22px;font-weight:800;color:var(--pw-secondary);font-family:var(--pw-font);">
                            <?php
                            $total_spent = WC()->customer->get_total_spent();
                            echo wc_price( $total_spent );
                            ?>
                        </div>
                        <div style="font-size:11px;color:var(--pw-text-muted);margin:0;">
                            <?php esc_html_e( 'جمع کل خرید', 'pluginwoo' ); ?>
                        </div>
                    </div>
                    <div class="pluginwoo-card" style="text-align:center;padding:16px;">
                        <div style="font-size:24px;margin-bottom:4px;">⭐</div>
                        <div style="font-size:22px;font-weight:800;color:var(--pw-accent);font-family:var(--pw-font);">
                            <?php echo WC()->customer->get_average_order_value(); ?>
                        </div>
                        <div style="font-size:11px;color:var(--pw-text-muted);margin:0;">
                            <?php esc_html_e( 'میانگین سفارش', 'pluginwoo' ); ?>
                        </div>
                    </div>
                </div>

                <?php if ( $last_order ) : ?>
                <div class="pw-orders-section">
                    <h3 style="font-size:16px;font-weight:700;margin-bottom:12px;font-family:var(--pw-font);border-bottom:1px solid var(--pw-border);padding-bottom:8px;">
                        <?php esc_html_e( '10 سفارش اخیر', 'pluginwoo' ); ?>
                    </h3>
                    <table class="pw-orders-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e( 'شماره', 'pluginwoo' ); ?></th>
                                <th><?php esc_html_e( 'تاریخ', 'pluginwoo' ); ?></th>
                                <th><?php esc_html_e( 'آیتم‌ها', 'pluginwoo' ); ?></th>
                                <th><?php esc_html_e( 'جمع', 'pluginwoo' ); ?></th>
                                <th><?php esc_html_e( 'وضعیت', 'pluginwoo' ); ?></th>
                                <th><?php esc_html_e( 'عملیات', 'pluginwoo' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent_orders = wc_get_orders( array(
                                'customer_id' => get_current_user_id(),
                                'limit'       => 10,
                                'orderby'     => 'date',
                                'order'       => 'DESC',
                            ) );
                            foreach ( $recent_orders as $order ) :
                                $status = $order->get_status();
                                $status_label = wc_get_order_status_name( $status );
                                $status_class = 'pw-order-status--' . sanitize_html_class( $status );
                                ?>
                                <tr>
                                    <td><strong><?php echo esc_html( $order->get_order_number() ); ?></strong></td>
                                    <td style="color:var(--pw-text-muted);font-size:13px;">
                                        <?php echo esc_html( $order->get_date()->date( 'Y/m/d' ) ); ?>
                                    </td>
                                    <td>
                                        <?php echo esc_html( $order->get_formatted_billing_address() ); ?>
                                    </td>
                                    <td style="font-weight:700;color:var(--pw-primary);">
                                        <?php echo wc_price( $order->get_total() ); ?>
                                    </td>
                                    <td>
                                        <span class="pw-order-status <?php echo $status_class; ?>">
                                            <?php echo esc_html( $status_label ); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>"
                                           class="pw-order-btn">
                                            <?php esc_html_e( 'مشاهده', 'pluginwoo' ); ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
                <?php else : ?>
                <?php wc_get_template( 'myaccount/' . $current . '.php', array(
                    'current_user' => $user,
                ) ); ?>
                <?php endif; ?>
        </div>
    </div>
</div>
