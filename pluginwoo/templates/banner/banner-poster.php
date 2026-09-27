<?php
/**
 * Template: Poster Banner
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$banner     = PluginWoo_Banner::get_banner( $banner_id );
$link       = $banner_link ?: ( $banner ? get_permalink( $banner->ID ) : '' );
$imageId    = $banner ? (int) get_post_thumbnail_id( $banner->ID ) : 0;
$imgUrl     = $imageId ? wp_get_attachment_image_url( $imageId, 'large' ) : '';
$bannerTitle = $banner ? $banner->post_title : esc_html__( 'بندری مخصوص', 'pluginwoo' );
$bannerDesc  = $banner ? $banner->post_excerpt : '';
?>
<div class="pluginwoo-banner pluginwoo-banner--poster pluginwoo-banner-effect-glow">
    <div class="pw-poster-main">
        <?php if ( $imgUrl ) : ?>
        <img src="<?php echo esc_url( $imgUrl ); ?>" class="pw-poster-img" alt="" />
        <?php endif; ?>
        <div class="pw-poster-text">
            <div class="pw-poster-title">
                <?php echo esc_html( $bannerTitle ); ?>
            </div>
            <?php if ( $bannerDesc ) : ?>
            <p style="font-size:14px;opacity:.85;margin:0 0 8px;">
                <?php echo esc_html( $bannerDesc ); ?>
            </p>
            <?php endif; ?>
            <?php if ( $link ) : ?>
            <a href="<?php echo esc_url( $link ); ?>"
               class="pluginwoo-btn pluginwoo-btn--secondary" style="display:inline-flex;font-size:13px;padding:8px 18px;">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M5 12h14M12 5l7 7-7 7"/></svg>
                <?php esc_html_e( 'بخش خرید', 'pluginwoo' ); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
