<?php
/**
 * PluginWoo Telegram Integration Class.
 * Sends new product notifications to Telegram channels using Bot API.
 * Supports @BehalWebz / @BelehWebz arms and Telegram bot integration.
 */

if ( ! class_exists( 'PluginWoo_Telegram' ) ) :

class PluginWoo_Telegram {

    public $token   = '';
    public $chat_id = '';

    public function __construct() {
        // Hook into new product creation.
        add_action( 'woocommerce_new_product', array( $this, 'send_new_product_notification' ), 10, 2 );
        add_action( 'woocommerce_product_set_stock', array( $this, 'send_stock_notification' ), 10, 1 );
        add_action( 'admin_init', array( $this, 'validate_telegram_settings' ) );
    }

    public function validate_telegram_settings() {
        $token = get_option( 'pluginwoo_settings', array() );
        $token = isset( $token['telegram_token'] ) ? $token['telegram_token'] : '';
        $chat_id = isset( $token['telegram_chat_id'] ) ? $token['telegram_chat_id'] : '';

        $this->token   = sanitize_text_field( $token );
        $this->chat_id = sanitize_text_field( $chat_id );
    }

    /**
     * Send new product notification to Telegram.
     */
    public function send_new_product_notification( $product_id, $product ) {
        if ( empty( $this->token ) || empty( $this->chat_id ) ) {
            return;
        }

        $product = wc_get_product( $product_id );
        if ( ! $product || ! $product->get_image_id() ) {
            return;
        }

        $name       = $product->get_name();
        $price      = $product->get_price();
        $short_desc = substr( $product->get_short_description(), 0, 200 ) ?: 'توضیحات‌ 여유를';
        $product_url = get_permalink( $product_id );
        $image_url   = wp_get_attachment_image_url( $product->get_image_id(), 'medium' );

        $caption = sprintf(
            "🛍 *محصول جدید اضافه شد!*\n\n" .
            "*نام:* %s\n" .
            "*قیمت:* %s تومان\n" .
            "*توضیحات:* %s\n\n" .
            "🔗 مشاهده: %s",
            $name,
            number_format( $price ),
            $short_desc,
            $product_url
        );

        $this->send_photo_to_channel( $image_url, $caption );
    }

    /**
     * Send stock status notification.
     */
    public function send_stock_notification( $product ) {
        if ( empty( $this->token ) || empty( $this->chat_id ) ) {
            return;
        }

        if ( ! $product->is_in_stock() ) {
            $msg = sprintf(
                "⚠️ *枵存 充足!*\n\nمحصول «%s» به ├── باخته شده است.\nلطفاً با مشتری‌ها تماس بگیرید.",
                $product->get_name()
            );
            $this->send_message( $msg );
        }
    }

    /**
     * Send a photo message to Telegram channel.
     */
    private function send_photo_to_channel( $photo_url, $caption ) {
        $url = sprintf(
            'https://api.telegram.org/bot%s/sendPhoto',
            $this->token
        );

        $body = array(
            'chat_id' => $this->chat_id,
            'photo'   => $photo_url,
            'caption' => $caption,
            'parse_mode' => 'Markdown',
        );

        $this->telegram_request( $url, $body );
    }

    /**
     * Send a text message to Telegram channel.
     */
    private function send_message( $text ) {
        $url = sprintf(
            'https://api.telegram.org/bot%s/sendMessage',
            $this->token
        );

        $body = array(
            'chat_id'    => $this->chat_id,
            'text'       => $text,
            'parse_mode' => 'Markdown',
        );

        $this->telegram_request( $url, $body );
    }

    /**
     * Make request to Telegram API.
     */
    private function telegram_request( $url, $body ) {
        $response = wp_remote_post( $url, array(
            'method'  => 'POST',
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body'    => json_encode( $body ),
            'timeout' => 15,
        ) );

        if ( is_wp_error( $response ) ) {
            error_log( 'PluginWoo Telegram: ' . $response->get_error_message() );
            return false;
        }

        $code = wp_remote_retrieve_response_code( $response );
        if ( 200 !== $code ) {
            error_log( "PluginWoo Telegram: HTTP {$code}" );
            return false;
        }

        return true;
    }
}

endif;
