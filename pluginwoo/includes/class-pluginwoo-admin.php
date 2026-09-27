<?php
/**
 * PluginWoo Admin Settings Class.
 * Handles the WordPress admin settings panel with professional design.
 */

if ( ! class_exists( 'PluginWoo_Admin_Settings' ) ) :

class PluginWoo_Admin_Settings {

    private $page_hook = null;

    public function init() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function add_admin_menu() {
        $this->page_hook = add_options_page(
            __( 'تنظیمات-pluginwoo', 'pluginwoo' ),
            __( 'PluginWoo', 'pluginwoo' ),
            'manage_options',
            'pluginwoo-settings',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        $settings = apply_filters( 'pluginwoo_settings_array', array() );

        if ( empty( $settings ) ) {
            return;
        }

        foreach ( $settings as $section ) {
            $section_id = sanitize_key( str_replace( ' ', '-', strtolower( $section['title'] ) ) );

            add_settings_section(
                $section_id,
                '',
                null,
                'pluginwoo-settings'
            );

            foreach ( $section['fields'] as $field ) {
                $field_id = 'pluginwoo_' . sanitize_key( $field['id'] );

                $args = array(
                    'id'         => $field_id,
                    'title'      => $field['label'],
                    'section'    => $section_id,
                    'settings'   => 'pluginwoo_settings',
                    'type'       => isset( $field['type'] ) ? $field['type'] : 'text',
                    'options'    => isset( $field['options'] ) ? $field['options'] : array(),
                    'desc'       => isset( $field['desc'] ) ? $field['desc'] : '',
                    'default'    => isset( $field['default'] ) ? $field['default'] : '',
                );

                add_settings_field(
                    $field_id,
                    $field['label'],
                    array( $this, 'render_field' ),
                    'pluginwoo-settings',
                    $section_id,
                    $args
                );

                register_setting(
                    'pluginwoo_settings',
                    $field_id,
                    array( $this, 'sanitize_field' )
                );
            }
        }
    }

    public function render_field( $args ) {
        $option_name = 'pluginwoo_settings';
        $value       = get_option( $option_name );
        $id          = $args['id'];
        $type        = $args['type'];
        $options     = $args['options'];
        $desc        = $args['desc'];
        $default     = $args['default'];
        $current     = isset( $value[ $id ] ) ? $value[ $id ] : $default;

        $class = 'pluginwoo-field-' . esc_attr( $type );
        ?>
        <div class="<?php echo esc_attr( $class ); ?>">
            <?php switch ( $type ) :

                case 'select' :
                    ?>
                    <select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $id ); ?>]" class="regular-select">
                        <?php foreach ( $options as $opt_val => $opt_label ) : ?>
                            <option value="<?php echo esc_attr( $opt_val ); ?>"
                                <?php selected( $current, $opt_val ); ?>>
                                <?php echo esc_html( $opt_label ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php
                    break;

                case 'checkbox' :
                    ?>
                    <label class="wp-on-off-switch">
                        <input type="checkbox" id="<?php echo esc_attr( $id ); ?>"
                               name="<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $id ); ?>]"
                               value="1"
                               <?php checked( $current, 1 ); ?> />
                        <div class="wp-switch-toggle-switch"></div>
                    </label>
                    <?php
                    break;

                case 'color' :
                    ?>
                    <input type="color" id="<?php echo esc_attr( $id ); ?>"
                           name="<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $id ); ?>]"
                           value="<?php echo esc_attr( $current ); ?>"
                           class="color-picker" />
                    <input type="text" id="<?php echo esc_attr( $id ); ?>-text"
                           name="<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $id ); ?>]"
                           value="<?php echo esc_attr( $current ); ?>"
                           style="width:100%;margin-top:5px;"
                           class="regular-text" />
                    <?php
                    break;

                case 'textarea' :
                    ?>
                    <textarea id="<?php echo esc_attr( $id ); ?>"
                              name="<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $id ); ?>]"
                              rows="8" cols="50"
                              class="large-text code"><?php echo esc_textarea( $current ); ?></textarea>
                    <?php
                    break;

                case 'text' :
                default :
                    ?>
                    <input type="text" id="<?php echo esc_attr( $id ); ?>"
                           name="<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $id ); ?>]"
                           value="<?php echo esc_attr( $current ); ?>"
                           class="regular-text" />
                    <?php
                    break;

            endswitch; ?>
            <?php if ( ! empty( $desc ) ) : ?>
                <p class="description"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    public function sanitize_field( $value ) {
        return sanitize_text_field( $value );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap pluginwoo-admin-wrap">
            <div class="pluginwoo-admin-header">
                <div class="pluginwoo-logo">
                    <span class="pluginwoo-logo-icon">P</span>
                    <span class="pluginwoo-logo-text">PluginWoo</span>
                </div>
                <div class="pluginwoo-version">v<?php echo esc_html( PLUGINWOO_VERSION ); ?></div>
            </div>

            <h1 class="pluginwoo-page-title">
                <?php esc_html_e( 'تنظیمات پلاگین PluginWoo', 'pluginwoo' ); ?>
            </h1>

            <p class="pluginwoo-intro">
                <?php esc_html_e( 'شخصی‌سازی قالب‌ها، افکت‌ها، هدر، فوتر و یکپارچگی‌ها با گزینه‌های زیر.', 'pluginwoo' ); ?>
            </p>

            <form method="post" action="options.php">
                <?php
                settings_fields( 'pluginwoo_settings' );
                do_settings_sections( 'pluginwoo-settings' );
                ?>
                <button type="submit" class="button button-primary button-large pluginwoo-save-btn">
                    <span class="dashicons dashicons-heart"></span>
                    <?php esc_html_e( 'ذخیره تنظیمات', 'pluginwoo' ); ?>
                </button>
            </form>

            <div class="pluginwoo-footer-info">
                <p><strong><?php esc_html_e( 'سازگاری:', 'pluginwoo' ); ?></strong> <?php esc_html_e( 'هماهنگ با ووکامرس ۱۱.۱.۱ به بالا', 'pluginwoo' ); ?></p>
            </div>
        </div>
        <?php
    }
}

endif;
