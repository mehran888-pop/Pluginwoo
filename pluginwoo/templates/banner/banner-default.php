<?php
/**
 * Template: Default Banner
 * Shortcode: [pluginwoo_banner banner_id="" template="default" link="" height="400"]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$banner     = PluginWoo_Banner::get_banner( $banner_id );
$link       = $banner_link ?: ( $banner ? get_permalink( $banner->ID ) : '' );
$height     = $banner_height ?: '400';
$imageId    = $banner ? (int) get_post_thumbnail_id( $banner->ID ) : 0;
$imgUrl     = $imageId ? wp_get_attachment_image_url( $imageId, 'large' ) : '';
$bannerTitle = $banner ? $banner->post_title : '';
$bannerDesc  = $banner ? $banner->post_excerpt : '';
?>
<div class="pluginwoo-banner pluginwoo-banner--default" style="min-height:<?php echo esc_attr( $height ); ?>px;">
    <?php if ( $imgUrl ) : ?>
    <img src="<?php echo esc_url( $imgUrl ); ?>" alt="" style="width:100%;height:100%;object-fit:cover;display:block;" />
    <?php endif; ?>
    <div class="pw-banner-overlay">
        <?php if ( $bannerTitle ) : ?>
        <div class="pw-banner-title">
            <?php echo esc_html( $bannerTitle ); ?>
        </div>
        <?php endif; ?>
        <?php if ( $bannerDesc ) : ?>
        <div class="pw-banner-desc">
            <?php echo esc_html( $bannerDesc ); ?>
        </div>
        <?php endif; ?>
        <?php if ( $link ) : ?>
        <a href="<?php echo esc_url( $link ); ?>"
           class="pw-banner-btn"
           style="display:inline-flex;align-items:center;background:#fff;color:var(--pw-primary);padding:10px 24px;border-radius:50px;font-weight:700;text-decoration:none;font-size:14px;transition:all .2s;">
            <span style="display:flex;align-items:center;gap:6px;">
                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M5 12h14M12 5l7 7-7 7"/></svg>
                <?php esc_html_e( 'بیشتر بدانید', 'pluginwoo' ); ?>
            </span>
        </a>
        <?php endif; ?>
    </div>
</div>
