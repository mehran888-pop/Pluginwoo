<?php
/**
 * Template: Default Store Page
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pluginwoo-store-default">
    <?php
    $products = new WP_Query( array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'status'         => 'publish',
    ) );
    ?>
    <?php if ( $products->have_posts() ) : ?>
        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
            <?php wc_get_template( 'content-product.php', array(
                'product' => wc_get_product( get_the_ID() ),
            ) ); ?>
        <?php endwhile; ?>
    <?php else : ?>
        <?php esc_html_e( 'هنوز محصولی اضافه نشده است.', 'pluginwoo' ); ?>
    <?php endif; ?>
</div>
