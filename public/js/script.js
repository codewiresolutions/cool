"use strict";

(function ($) {

    /* ==== Init Testimonials Slider ==== */
    function initTestimonialsSlider() {
        const carousel = $('.testimonials-carousel');
        if (!carousel.length) return;

        carousel.owlCarousel({
            items: 2,
            loop: true,
            margin: 20,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            dots: false,
            nav: false,
            responsive: {
                0: {items: 1},
                768: {items: 2},
                1200: {items: 2}
            }
        });

        $('.custom-prev').on('click', function () {
            const target = $(this).data('carousel');
            $(target).trigger('prev.owl.carousel');
        });
        $('.custom-next').on('click', function () {
            const target = $(this).data('carousel');
            $(target).trigger('next.owl.carousel');
        });


        $('.btn-read-more').on('click', function () {
            const wrapper = $(this).closest('.testimonial-text-wrapper');
            wrapper.find('.short-text, .full-text').toggleClass('d-none');
            $(this).text(wrapper.find('.full-text').hasClass('d-none') ? 'Read more' : 'Read less');
        });
    }

    /* ==== Init Employers Marquee ==== */
    function initEmployersMarquee() {
        const marquees = document.querySelectorAll('.company-marquee-container');
        if (!marquees.length) return;

        marquees.forEach(container => {
            const track = container.querySelector('.company-marquee-track');
            const groups = track?.querySelectorAll('.marquee-group');
            if (!groups?.length) return;

            let groupWidth = groups[0].offsetWidth;
            const AUTO_SPEED = 1;
            let rafId;
            let STEP = groupWidth / groups[0].children.length;

            const recalcWidths = () => {
                groupWidth = groups[0].offsetWidth;
                STEP = groupWidth / groups[0].children.length;
            };

            const autoScroll = () => {
                container.scrollLeft += AUTO_SPEED;
                if (container.scrollLeft >= groupWidth) container.scrollLeft = 0;
                rafId = requestAnimationFrame(autoScroll);
            };

            const startAutoScroll = () => {
                if (rafId) cancelAnimationFrame(rafId);
                autoScroll();
            };
            const stopAutoScroll = () => {
                if (rafId) cancelAnimationFrame(rafId);
            };

            // Hover pause/resume
            container.addEventListener('mouseenter', stopAutoScroll);
            container.addEventListener('mouseleave', startAutoScroll);

            // Recalculate on resize/load
            window.addEventListener('resize', recalcWidths);
            window.addEventListener('load', recalcWidths);

            const wrapper = container.closest('.company-marquee-wrapper');
            const nextBtn = wrapper.querySelector('.carousel-next');
            const prevBtn = wrapper.querySelector('.carousel-prev');


            nextBtn?.addEventListener('click', () => {
                container.scrollBy({left: STEP, behavior: 'smooth'});
            });

            prevBtn?.addEventListener('click', () => {
                container.scrollBy({left: -STEP, behavior: 'smooth'});
            });

            // Start scrolling
            startAutoScroll();
        });
    }

    /* ==== Init Featured Jobs Slider ==== */
    function initFeaturedJobsSlider() {
        const jobList = $(".featured-job-list");
        if (!jobList.length) return;

        const owl = jobList.owlCarousel({
            loop: true,
            margin: 15,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            responsive: {
                0: {items: 1},
                768: {items: 2},
                992: {items: 3}
            }
        });

        const carouselId = jobList.data('carousel-id');
        $(`.carousel-next[data-carousel-id='${carouselId}']`).click(() => owl.trigger('next.owl.carousel'));
        $(`.carousel-prev[data-carousel-id='${carouselId}']`).click(() => owl.trigger('prev.owl.carousel'));
    }

    /* ==== Init Revolution Slider ==== */
    function initRevolutionSlider() {
        if ($('.tp-banner').length) {
            $('.tp-banner').show().revolution({
                delay: 6000,
                startheight: 550,
                startwidth: 1140,
                hideThumbs: 1000,
                navigationType: 'none',
                touchenabled: 'on',
                onHoverStop: 'on',
                navOffsetHorizontal: 0,
                navOffsetVertical: 0,
                dottedOverlay: 'none',
                fullWidth: 'on'
            });
        }
    }

    /* ==== Init Search Bar ==== */
    function initSearchBar() {
        if (!$('.srchbox').hasClass("searchStayOpen")) {
            $("#jbsearch").click(() => {
                $(".srchbox").addClass("openSearch");
                $(".additional_fields").slideDown();
            });
            $(".srchbox").click(e => e.stopPropagation());
        }
    }

    /* ==== Init Multi-Item Bootstrap Carousel ==== */
    function initMultiItemCarousel() {
        $('#myCarousel').carousel({interval: 500000});

        $('.carousel .carousel-item').each(function () {
            const minPerSlide = 3;
            let next = $(this).next().length ? $(this).next() : $(this).siblings(':first');
            next.children(':first-child').clone().appendTo($(this));

            for (let i = 0; i < minPerSlide; i++) {
                next = next.next().length ? next.next() : $(this).siblings(':first');
                next.children(':first-child').clone().appendTo($(this));
            }
        });
    }

    /* ==== Init All ==== */
    $(function () {
        initTestimonialsSlider();
        initEmployersMarquee();
        initFeaturedJobsSlider();
        initRevolutionSlider();
        initSearchBar();
        initMultiItemCarousel();
    });

    // Handle bfcache restore
    window.addEventListener('pageshow', e => {
        if (e.persisted) {
            window.location.reload();
        }
    });

})(jQuery);
