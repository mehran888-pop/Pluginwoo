<?php
/**
 * Template: Creative Banner
 * Shortcode: [pluginwoo_banner banner_id="" template="creative" link="" height="400"]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$banner     = PluginWoo_Banner::get_banner( $banner_id );
$link       = $banner_link ?: ( $banner ? get_permalink( $banner->ID ) : '' );
$imageId    = $banner ? (int) get_post_thumbnail_id( $banner->ID ) : 0;
$imgUrl     = $imageId ? wp_get_attachment_image_url( $imageId, 'medium_large' ) : '';
$bgColor    = 'linear-gradient(135deg, var(--pw-primary) 0%, var(--pw-secondary-dark) 50%, var(--pw-accent) 100%)';
?>
<div class="pluginwoo-banner pluginwoo-banner--creative pluginwoo-banner-effect-float">
    <div class="pw-creative-inner">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:center;">
            <!-- Left Content -->
            <div class="pw-creative-card">
                <div class="pw-creative-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="white">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="pw-creative-title">
                    <?php echo esc_html( $bannerTitle ?: esc_html__( 'تبلیغ خاص', 'pluginwoo' ) ); ?>
                </h3>
                <p class="pw-creative-desc">
                    <?php echo esc_html( $bannerDesc ?: esc_html__( 'سطح‌های خلاقانه برای تبلیغ محصول جدید یا پیشنهاد ویژه.', 'pluginwoo' ) ); ?>
                </p>
                <?php if ( $link ) : ?>
                <a href="<?php echo esc_url( $link ); ?>" class="pluginwoo-btn pluginwoo-btn--primary">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M5 12h14M12 5l7 7-7 7"/></svg>
                    <?php esc_html_e( 'നടത്തو', 'pluginwoo' ); ?>
                </a>
                <?php endif; ?>
            </div>

            <!-- Right Image -->
            <?php if ( $imgUrl ) : ?>
            <div class="pw-poster-img" style="border-radius:var(--pw-radius);overflow:hidden;box-shadow:var(--pw-shadow-lg);aspect-ratio:1;border:4px solid #fff;position:relative;">
                <img src="<?php echo esc_url( $imgUrl ); ?>" alt="" style="width:100%;height:100%;object-fit:cover;display:block;" />
                <div style="position:absolute;top:10px;left:10px;background:var(--pw-secondary);color:#fff;padding:4px 12px;border-radius:50px;font-size:11px;font-weight:700;box-shadow:0 2px 8px rgba(0,0,0,.3);">
                    <?php esc_html_e( 'جدید', 'pluginwoo' ); ?>
                </div>
            </div>
            <?php else : ?>
            <div class="pw-creative-card" style="background:linear-gradient(135deg,rgba(79,70,229,.1),rgba(16,185,129,.1));border:2px dashed var(--pw-border);border-radius:var(--pw-radius);min-height:200px;display:flex;align-items:center;justify-content:center;color:var(--pw-text-muted);font-size:13px;font-family:var(--pw-font);">
                <svg width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4 4h16v6h-12v4h8v2H4zM4 10v2h16v2H4z"/></svg>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
