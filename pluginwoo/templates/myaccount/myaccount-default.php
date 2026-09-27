<?php
/**
 * Template: Default My Account
 * Uses WooCommerce default.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pluginwoo-wrapper pluginwoo-myaccount-default">
    <?php wc_get_template( 'myaccount/my-account.php', array(
        'current_user' => get_user_by( 'id', get_current_user_id() ),
    ) ); ?>
</div>
