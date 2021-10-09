;(function ($) {
    "use strict";

    $(document).ready(function(){

        //ab-testimonial-style-one

        $('.ab-one-slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            slide: true,
            asNavFor: '.ab-one-slider-nav'
        });

        $('.ab-one-slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.ab-one-slider-for',
            arrows: true,
            dots: false,
            focusOnSelect: true
        });

        //ab-testimonial-style-two

        $('.testimonials-two').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            infinite: true,
            cssEase: 'linear',
            slide: 'li',
            arrows: true,
        });


        //ab-testimonial-style-three
        $(".testimonial-reel").slick({
            centerMode: true,
            centerPadding: "40px",
            dots: true,
            slidesToShow: 2,
            autoplay: true,
            autoplaySpeed: 2000,
            infinite: true,
            arrows: false,
            lazyLoad: "ondemand",
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        centerMode: false
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });


        $('.testimonial_owlCarousel').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            infinite: true,
            cssEase: 'linear',
            slide: 'li',
            arrows: true,
        });

        
    });

}) (jQuery);