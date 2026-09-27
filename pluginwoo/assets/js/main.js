/**
 * PluginWoo — Main Utilities
 */

document.addEventListener('DOMContentLoaded', function () {

    'use strict';

    /**
     * Rating stars display
     */
    if (typeof wc && wc.formatPrice) {
        // WC already loaded
    }

    /**
     * Smooth scroll for internal links
     */
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            var target = document.querySelector(link.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    /**
     * Rating helper
     */
    window.PluginWoo = window.PluginWoo || {};

    PluginWoo.renderStars = function (rating, count) {
        var full = Math.floor(rating);
        var half = rating % 1 >= 0.5 ? 1 : 0;
        var empty = count - full - half;
        var html = '';
        for (var i = 0; i < full; i++) {
            html += '<span class="pw-star-filled">★</span>';
        }
        if (half) {
            html += '<span class="pw-star-half">★</span>';
        }
        for (var j = 0; j < empty; j++) {
            html += '<span class="pw-star-empty">★</span>';
        }
        return html;
    };

    PluginWoo.formatPrice = function (price, currencySymbol) {
        if (!price) return '';
        currencySymbol = currencySymbol || 'تومان';
        var num = parseFloat(price);
        if (isNaN(num)) return '';
        return num.toLocaleString('fa-IR').replace(/,/g, '،') + ' ' + currencySymbol;
    };

    PluginWoo.formatRial = function (rial) {
        if (!rial) return '';
        var tomans = Math.round(rial / 10);
        return tomans.toLocaleString('fa-IR').replace(/,/g, '،') + ' تومان';
    };

    /**
     * Tab switching
     */
    PluginWoo.initTabs = function () {
        document.querySelectorAll('.pluginwoo-tabs').forEach(function (tabContainer) {
            tabContainer.querySelectorAll('.pluginwoo-tab-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    tabContainer.querySelectorAll('.pluginwoo-tab-btn').forEach(function (b) {
                        b.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });
        });
    };

    PluginWoo.initTabs();

    /**
     * Quantity controls
     */
    PluginWoo.initQtyControls = function () {
        document.querySelectorAll('.pw-qty-minus, .pw-qty-plus').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = this.closest('.pluginwoo-cart-modern') ?
                    this.closest('.pluginwoo-cart-modern').querySelector('.pw-qty-input') :
                    document.querySelector('.pw-qty-input');
                if (!input) return;
                var val = parseInt(input.value) || 0;
                if (this.classList.contains('pw-qty-minus') && val > 1) {
                    input.value = val - 1;
                } else if (this.classList.contains('pw-qty-plus')) {
                    input.value = val + 1;
                }
            });
        });
    };

    PluginWoo.initQtyControls();

    /**
     * Remove item from cart (frontend)
     */
    PluginWoo.initCartRemove = function () {
        document.querySelectorAll('.pw-cart-remove').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var row = this.closest('tr');
                if (row) {
                    row.style.transition = 'opacity .3s, transform .3s';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(20px)';
                    setTimeout(function () { row.remove(); }, 300);
                }
            });
        });
    };

    PluginWoo.initCartRemove();

});
