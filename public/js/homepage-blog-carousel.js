(function ($) {
    'use strict';

    $(function () {
        $('.more-posts-carousel').each(function () {
            var $carousel = $(this);
            var itemCount = $carousel.children().length;
            var $controls = $carousel.siblings('.more-posts-controls');
            var $dots = $controls.find('.more-posts-dots');

            function itemsPerView() {
                if (window.innerWidth >= 992) return 3;
                if (window.innerWidth >= 576) return 2;
                return 1;
            }

            function slideStep() {
                var visible = itemsPerView();
                return itemCount > visible ? visible : 1;
            }

            function updateDots(event) {
                var step = slideStep();
                var pageCount = Math.max(1, Math.ceil(itemCount / step));
                var instance = $carousel.data('owl.carousel');
                var relativeIndex = event && event.item && instance
                    ? instance.relative(event.item.index)
                    : 0;
                var activePage = Math.floor(relativeIndex / step) % pageCount;

                if ($dots.children().length !== pageCount) {
                    $dots.empty();
                    for (var i = 0; i < pageCount; i += 1) {
                        $('<button type="button"><span class="sr-only">Go to slide ' + (i + 1) + '</span></button>')
                            .attr('data-page', i)
                            .appendTo($dots);
                    }
                }

                $dots.children().removeClass('is-active').eq(activePage).addClass('is-active');
            }

            function removeNativeControls() {
                $carousel.children('.owl-nav, .owl-dots, .owl-controls').remove();
            }

            function removeUndefinedControls() {
                $carousel.closest('.more-posts-section')
                    .find('*')
                    .filter(function () {
                        return $(this).children().length === 0 &&
                            $.trim($(this).text()).toLowerCase() === 'undefined';
                    })
                    .remove();
            }

            $carousel.owlCarousel({
                items: 3,
                slideBy: itemCount > 3 ? 3 : 1,
                margin: 24,
                nav: false,
                dots: false,
                autoplay: itemCount > 1,
                autoplayTimeout: 2500,
                autoplayHoverPause: true,
                smartSpeed: 650,
                loop: itemCount > 1,
                onInitialized: updateDots,
                onTranslated: updateDots,
                onResized: updateDots,
                responsive: {
                    0: { items: 1, slideBy: 1, margin: 16 },
                    576: { items: 2, slideBy: itemCount > 2 ? 2 : 1, margin: 20 },
                    992: { items: 3, slideBy: itemCount > 3 ? 3 : 1, margin: 24 }
                }
            });

            removeNativeControls();
            window.setTimeout(removeNativeControls, 0);
            removeUndefinedControls();
            window.setTimeout(removeUndefinedControls, 100);
            window.setTimeout(removeUndefinedControls, 500);
            window.setTimeout(removeUndefinedControls, 1000);

            $controls.find('.more-posts-prev').on('click', function () {
                $carousel.trigger('prev.owl.carousel', [650]);
            });

            $controls.find('.more-posts-next').on('click', function () {
                $carousel.trigger('next.owl.carousel', [650]);
            });

            $dots.on('click', 'button', function () {
                $carousel.trigger('to.owl.carousel', [Number($(this).attr('data-page')) * slideStep(), 650]);
            });
        });
    });
})(jQuery);
