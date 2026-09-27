/**
 * PluginWoo — Utility Module
 */

(function () {
    'use strict';

    window.PluginWoo = window.PluginWoo || {};

    var PW = window.PluginWoo;

    /**
     * Format price in Toman.
     */
    PW.formatPrice = function (price, currency) {
        if (!price && price !== 0) return '';
        currency = currency || 'تومان';
        var num = parseFloat(price);
        if (isNaN(num)) return '';
        // Convert Rial to Toman if needed (WC stores in Rial usually).
        var inToman = num;
        if (num > 10000000) {
            inToman = Math.round(num / 10);
        }
        return inToman.toLocaleString('fa-IR').replace(/,/g, '،');
    };

    /**
     * Render star rating HTML.
     */
    PW.renderStars = function (rating, total) {
        total = total || 5;
        var full = Math.floor(rating);
        var half = (rating - full) >= 0.25 && (rating - full) < 0.75 ? 1 : 0;
        var empty = total - full - half;

        var html = '<span class="pluginwoo-stars" aria-label="' + rating + ' از ' + total + '">';
        for (var i = 0; i < full; i++) html += '★';
        if (half) html += '½';
        for (var j = 0; j < empty; j++) html += '☆';
        html += '</span>';
        if (typeof rating === 'number' && rating > 0) {
            html += '<span class="pw-rating-text">(' + rating.toFixed(1) + ')</span>';
        }
        return html;
    };

    /**
     * Init tabs from DOM.
     */
    PW.initTabs = function (selector) {
        selector = selector || '.pluginwoo-tabs';
        var tabs = document.querySelectorAll(selector);
        tabs.forEach(function (tabContainer) {
            var btns = tabContainer.querySelectorAll('.pluginwoo-tab-btn');
            btns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    btns.forEach(function (b) { b.classList.remove('active'); });
                    btn.classList.add('active');
                    // Find target panel.
                    var targetId = btn.getAttribute('data-tab-target');
                    if (targetId) {
                        var target = document.getElementById(targetId);
                        if (target) {
                            tabContainer.querySelectorAll('.tab-content').forEach(function (tc) {
                                tc.style.display = 'none';
                            });
                            target.style.display = 'block';
                        }
                    }
                });
            });
            // Activate first on load.
            var firstActive = tabContainer.querySelector('.pluginwoo-tab-btn.active');
            if (firstActive && firstActive.getAttribute('data-tab-target')) {
                var target = document.getElementById(firstActive.getAttribute('data-tab-target'));
                if (target) target.style.display = 'block';
            }
        });
    };

    /**
     * Initialize accordion.
     */
    PW.initAccordion = function (selector) {
        selector = selector || '.pluginwoo-accordion';
        var accordions = document.querySelectorAll(selector);
        accordions.forEach(function (acc) {
            var triggers = acc.querySelectorAll('.pluginwoo-acc-trigger');
            triggers.forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    var panel = this.nextElementSibling;
                    var isOpen = panel.classList.contains('open');
                    // Close all.
                    acc.querySelectorAll('.pluginwoo-acc-panel').forEach(function (p) {
                        p.classList.remove('open');
                        p.style.maxHeight = null;
                    });
                    triggers.forEach(function (t) { t.classList.remove('active'); });
                    if (!isOpen) {
                        panel.classList.add('open');
                        panel.style.maxHeight = panel.scrollHeight + 'px';
                        this.classList.add('active');
                    }
                });
            });
        });
    };

    /**
     * Toast notification.
     */
    PW.toast = function (message, type) {
        type = type || 'success';
        var colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b',
            info: '#4f46e5'
        };
        var color = colors[type] || colors.info;

        var id = 'pw-toast-' + Date.now();
        var $toast = document.createElement('div');
        $toast.id = id;
        $toast.style.cssText = [
            'position:fixed',
            'bottom:20px',
            'right:20px',
            'background:' + color,
            'color:#fff',
            'padding:12px 20px',
            'border-radius:12px',
            'box-shadow:0 4px 16px rgba(0,0,0,.25)',
            'z-index:9999',
            'font-family:Vazirmatn,sans-serif',
            'font-size:14px',
            'font-weight:600',
            'display:flex',
            'align-items:center',
            'gap:8px',
            'transform:translateY(10px)',
            'opacity:0',
            'transition:all .3s ease'
        ].join(';');

        $toast.textContent = message;
        document.body.appendChild($toast);

        requestAnimationFrame(function () {
            $toast.style.transform = 'translateY(0)';
            $toast.style.opacity = '1';
        });

        setTimeout(function () {
            $toast.style.transform = 'translateY(10px)';
            $toast.style.opacity = '0';
            setTimeout(function () {
                if ($toast.parentNode) {
                    $toast.parentNode.removeChild($toast);
                }
            }, 300);
        }, 3500);

        return id;
    };

    /**
     * Debounce helper.
     */
    PW.debounce = function (fn, delay) {
        var timer;
        return function () {
            var context = this;
            var args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                fn.apply(context, args);
            }, delay);
        };
    };

    /**
     * Observe element visibility.
     */
    PW.onVisible = function (selector, callback) {
        if (!('IntersectionObserver' in window)) {
            callback();
            return;
        }
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    callback(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        var elements = document.querySelectorAll(selector);
        elements.forEach(function (el) {
            observer.observe(el);
        });
    };

    // Init on DOM ready.
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            PW.initTabs();
            PW.initAccordion();
        });
    } else {
        PW.initTabs();
        PW.initAccordion();
    }

})();
