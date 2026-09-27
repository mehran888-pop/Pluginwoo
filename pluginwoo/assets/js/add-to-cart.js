/**
 * PluginWoo — Add to Cart Creative Effects
 * Animated effects when adding products to cart.
 * Effects: fly, bounce, pulse
 */

(function ($) {
    'use strict';

    $(document).ready(function () {

        var settings = pluginwooAtc;

        /**
         * Intercept WooCommerce add-to-cart buttons.
         */
        $(document).on('click', 'button[name="add_to_cart"], .single_add_to_cart_button, .wc-btn, .pw-atc-btn', function (e) {
            if (!settings || !settings.effect || settings.effect === 'none') {
                return;
            }

            var btn = this;
            var $btn = $(btn);
            var productId = $btn.data('product_id') || $btn.closest('.product').data('id') || $btn.closest('form').find('input[name="add-to-cart"]').val();
            var quantity   = $btn.data('quantity') || 1;

            if (typeof productId === 'undefined' || !productId) {
                // Try to find in form.
                productId = $(this).closest('form').find('input[name="add-to-cart"]').val();
            }

            if (!productId) return;

            // Don't animate if already animating.
            if ($btn.hasClass('pw-atc-animating')) return;

            $btn.addClass('pw-atc-animating').prop('disabled', true);

            // Create flying element.
            var $flyEl = createFlyingElement(productId, $btn);

            // Start animation.
            animateAddToCart($flyEl, $btn, productId, quantity, settings.effect, function () {
                // After animation, trigger WC add-to-cart.
                $.post(settings.ajaxUrl, {
                    action: 'pluginwoo_atc_finish',
                    product_id: productId,
                    quantity: quantity,
                    nonce: settings.nonce
                }).done(function (response) {
                    $btn.removeClass('pw-atc-animating').prop('disabled', false);
                    if (response.success) {
                        showCartNotification(response.data);
                        updateMiniCart(response.data.cart_hash);
                    } else {
                        $btn.removeClass('pw-atc-animating');
                        alert(response.data || 'خطا در افزودن به سبد خرید');
                    }
                }).fail(function () {
                    $btn.removeClass('pw-atc-animating').prop('disabled', false);
                    alert('خطا در اتصال به سرور');
                });
            });
        });

    });

    /**
     * Create a flying clone of the product image.
     */
    function createFlyingElement(productId, $btn) {
        var $productCard = $btn.closest('.product');
        var src = '';

        // Try to find product image.
        var $img = $productCard.find('img');
        if ($img.length) {
            src = $img.attr('src');
        }

        if (!src) {
            // Try WooCommerce main image.
            $img = $('.woocommerce-product-image img');
            if ($img.length) {
                src = $img.attr('src');
            }
        }

        if (!src) return null;

        var $el = $('<div>')
            .css({
                position: 'fixed',
                left: $btn.offset().left + $btn.outerWidth() / 2 - 15,
                top: $btn.offset().top + $btn.outerHeight() / 2 - 15,
                width: 30,
                height: 30,
                background: 'url(' + src + ') center/cover no-repeat',
                borderRadius: '50%',
                zIndex: 10000,
                pointerEvents: 'none',
                boxShadow: '0 2px 10px rgba(0,0,0,.3)'
            });

        $('body').append($el);
        return $el;
    }

    /**
     * Animate the element to the cart icon.
     */
    function animateAddToCart($el, $btn, productId, quantity, effect, callback) {
        var cartIcon = $('#pluginwoo-cart-icon, .woocommerce-cart-form__cart-item, .header-cart-btn, .pw-hdr-cart-btn, [href$="/cart"]');

        var cartOffset = { left: 0, top: 0 };
        if (cartIcon.length) {
            var ci = cartIcon.first();
            cartOffset.left = ci.offset().left + ci.outerWidth() / 2 - 15;
            cartOffset.top  = ci.offset().top + ci.outerHeight() / 2 - 15;
        } else {
            // Fallback: find cart icon in header.
            var $headerCart = $('.pw-hdr-cart-btn, .header-cart, .site-header .cart');
            if ($headerCart.length) {
                var hc = $headerCart.first();
                cartOffset.left = hc.offset().left + hc.outerWidth() / 2 - 15;
                cartOffset.top  = hc.offset().top + hc.outerHeight() / 2 - 15;
            }
        }

        if (effect === 'fly') {
            flyEffect($el, cartOffset, callback);
        } else if (effect === 'bounce') {
            bounceEffect($el, cartOffset, callback);
        } else if (effect === 'pulse') {
            pulseEffect($el, cartOffset, callback);
        } else {
            // Default: simple fade + move.
            simpleMove($el, cartOffset, callback);
        }
    }

    function flyEffect($el, target, callback) {
        var startX = $el.position().left;
        var startY = $el.position().top;
        var dx = target.left - startX;
        var dy = target.top - startY;
        var distance = Math.sqrt(dx * dx + dy * dy);
        var duration = Math.min(Math.max(distance * 0.004, 300), 1200);

        $el.animate({
            left: target.left,
            top: target.top,
            width: 0,
            height: 0,
            opacity: 0
        }, {
            duration: duration,
            easing: 'swing',
            complete: function () {
                $el.remove();
                if (callback) callback();
            }
        });
    }

    function bounceEffect($el, target, callback) {
        var startX = $el.position().left;
        var startY = $el.position().top;
        var dx = target.left - startX;
        var dy = target.top - startY;

        $el.animate({
            left: target.left,
            top: target.top - 80,
            width: 20,
            height: 20,
            opacity: 1
        }, {
            duration: 200,
            easing: 'swing',
            complete: function () {
                $(this).animate({
                    top: target.top,
                    width: 0,
                    height: 0,
                    opacity: 0
                }, {
                    duration: 300,
                    easing: 'bounce',
                    complete: function () {
                        $el.remove();
                        if (callback) callback();
                    }
                });
            }
        });
    }

    function pulseEffect($el, target, callback) {
        var startX = $el.position().left;
        var startY = $el.position().top;

        $el.css({ boxShadow: '0 0 0 0 rgba(79,70,229,.5)' });

        $el.animate({
            left: target.left,
            top: target.top,
            width: 0,
            height: 0,
            opacity: 0
        }, {
            duration: 500,
            easing: 'swing',
            step: function (now, fx) {
                if (fx.prop === 'left' || fx.prop === 'top') {
                    var progress = fx.state === 0 ? 
                        (fx.start - fx.end) / (fx.start - fx.end) : 
                        (fx.pos - fx.end) / (fx.start - fx.end);
                    // pulse radius effect.
                }
            },
            complete: function () {
                $el.remove();
                if (callback) callback();
            }
        });
    }

    function simpleMove($el, target, callback) {
        $el.animate({
            left: target.left,
            top: target.top,
            width: 0,
            height: 0,
            opacity: 0
        }, {
            duration: 400,
            easing: 'swing',
            complete: function () {
                $el.remove();
                if (callback) callback();
            }
        });
    }

    /**
     * Show notification toast.
     */
    function showCartNotification(data) {
        var $notif = $('#pluginwoo-atc-notification');
        if (!$notif.length) {
            $notif = $('<div id="pluginwoo-atc-notification"></div>')
                .css({
                    position: 'fixed',
                    bottom: 80,
                    right: 20,
                    background: '#10b981',
                    color: '#fff',
                    padding: '12px 20px',
                    borderRadius: '12px',
                    boxShadow: '0 4px 20px rgba(16,185,129,.4)',
                    zIndex: 10001,
                    fontFamily: 'Vazirmatn, sans-serif',
                    fontSize: '14px',
                    fontWeight: '600',
                    display: 'flex',
                    alignItems: 'center',
                    gap: '8px',
                    transform: 'translateY(20px)',
                    opacity: 0,
                    transition: 'all .3s ease'
                })
                .appendTo('body');
        }

        $notif.html('✅ محصول به سبد خرید اضافه شد')
            .css({ transform: 'translateY(0)', opacity: 1 });

        setTimeout(function () {
            $notif.css({ transform: 'translateY(20px)', opacity: 0 });
            setTimeout(function () {
                if ($notif.is(':last-child') || $notif.siblings().length === 0) {
                    $notif.remove();
                }
            }, 300);
        }, 3000);
    }

    /**
     * Update mini cart badge/count.
     */
    function updateMiniCart(cartHash) {
        var $badge = $('.pw-hdr-cart-count, .cart-contents .count');
        if ($badge.length) {
            // Trigger WC cart fragment update.
            $badge.addClass('pw-animate-bump');
            setTimeout(function () { $badge.removeClass('pw-animate-bump'); }, 400);
        }
    }

})(jQuery);
