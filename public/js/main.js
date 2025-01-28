(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.navbar').addClass('sticky-top shadow-sm');
        } else {
            $('.navbar:not(.sticky-top-always)').removeClass('sticky-top shadow-sm');
        }
    });

    //
    // // Dropdown on mouse hover
     const $dropdown = $(".dropdown");
    const $dropdown_sub = $("ul.submenu li");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu,.dropdown-sub-menu");
    const showClass = "show";

    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                if($this.hasClass('has-submenu')){
                    $('.submenu-popup-container').html($this.find('.dropdown-sub-menu-content').html());
                    $('.submenu-popup-container').find('ul.submenu li').hover(
                        function() {

                            const $this = $(this);
                            if($this.hasClass('show'))
                                return;
                            $this.parent().find('.show').removeClass(showClass);

                            $this.addClass(showClass);
                            const $products= $this.parent().parent().find('.productWrapper');
                            $products.find('.show').removeClass(showClass);
                            $products.children().eq($this.data('id')).addClass(showClass)

                        },
                        function() {
                        }
                    );
                    $('.submenu-popup-container').addClass(showClass);
                }
                else {
                    $('.submenu-popup-container').removeClass(showClass);
                    $this.children($dropdownToggle).attr("aria-expanded", "true");
                    $this.children($dropdownMenu).addClass(showClass);
                }
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
            console.log($dropdown_sub);
            $('.submenu-popup-container').parent().hover(function(){

            },function(){
                $('.submenu-popup-container').html('');
                $('.submenu-popup-container').removeClass('show');
            });

        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1000, 'easeInOutExpo');
        return false;
    });


    // Testimonials carousel

    var owl = $('.testimonial-carousel');
    owl.owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        autoHeight: true,
        center: true,
        margin: 24,
        dots: true,
        loop: true,
        nav : true,
        responsive: {
            0:{
                items:2
            },
            768:{
                items:3
            },
            992:{
                items:5
            }
        }
    });
    owl.on('mousewheel', '.owl-stage', function (e) {
        e.preventDefault();

        if (e.deltaX>0) {
            owl.trigger('next.owl');
        } else {
            owl.trigger('prev.owl');
        }
    });

})(jQuery);

