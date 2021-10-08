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







        
    });

}) (jQuery);