/**
 * PluginWoo — Mobile Navigation
 */

(function ($) {
    'use strict';

    $(document).ready(function () {

        // Init active state based on current URL.
        var currentPath = window.location.pathname;
        var currentHash = window.location.hash;

        // Set active item on mobile nav.
        $('[data-pw-nav-link]').each(function () {
            var href = this.getAttribute('data-pw-nav-link');
            if (href === currentPath || href + '/' === currentPath || currentPath.endsWith(href)) {
                $(this).addClass('active');
            }
        });

        // Handle nav click with active switching.
        $(document).on('click', '[data-pw-nav-link]', function () {
            var href = this.getAttribute('data-pw-nav-link');
            if (!href) return;

            // Don't follow link if it's the current page.
            if (href === currentPath || currentPath.endsWith(href)) {
                return;
            }

            $(document).find('[data-pw-nav-link]').removeClass('active');
            $(this).addClass('active');

            // Use ajax if possible for smoother navigation.
            if (typeof window.PluginWoo !== 'undefined' && window.PluginWoo.ajaxNav) {
                $.get(href, function (data) {
                    var $newContent = $(data).find('main, #main, .site-main, #content');
                    if ($newContent.length) {
                        $('body').find('main, #main, .site-main, #content').html($newContent.html());
                        // Update active states.
                        $(document).find('[data-pw-nav-link]').each(function () {
                            var h = this.getAttribute('data-pw-nav-link');
                            if (href === h || h.endsWith(href)) {
                                $(this).addClass('active');
                            } else {
                                $(this).removeClass('active');
                            }
                        });
                    }
                });
            }
        });

        // Scroll to top on "Home" nav tap.
        $(document).on('click', '[data-pw-nav-link="/"]', function () {
            $('html, body').animate({ scrollTop: 0 }, 300);
        });

    });

})(jQuery);
