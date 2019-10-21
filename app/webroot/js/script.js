jQuery(document).ready(function ($) {

    //доп класс на хэдер при скролле на десктопе
    $(window).scroll(function () {
        if ($(window).width() > 1190) {
            if ($(this).scrollTop() > 180) {
                $('.with-header-banner').addClass('header-fixed');
            }
            else {
                $('.with-header-banner').removeClass('header-fixed');
            }
        }
    });

    //поиск на странице результатов работ
    var quickFilter = function (searchInput, searchSel) {
        $(searchInput).on('change keyup paste mouseup', function () {
            var inputData = $(this).val();
            filter(inputData);
        });
        var filter = function (inputData) {
            $(searchSel).each(function () {
                var $this = $(this);
                var txt = $this.text();
                if (txt.toLowerCase().indexOf(inputData.toLowerCase()) < 0) {
                    $this.parent('.work-results-main-list-item-text').parent('.work-results-main-list-item').addClass('hidden');
                } else {
                    $this.parent('.work-results-main-list-item-text').parent('.work-results-main-list-item').removeClass('hidden');
                }
            });
        };
    };
    quickFilter('#search-photo', '.work-results-main-list-item-text-title');


    //инициализация fancybox. видео в попапе
    $('.video-popup').fancybox({
        openEffect: 'none',
        closeEffect: 'none',
        helpers: {
            media: {}
        }
    });

//работа логина на мобилке
    if ($(window).width() < 700) {
        $(document).on('touchstart', 'header .login', function () {
            $('header .login').toggleClass('opened');
        });
    }


    //инициализация magnific popup
    $(document).on('click', '.ajax-mfp', function () {
        var a = $(this);
        $.magnificPopup.open({
            //items: { src: a.attr( 'data-href' ) },
            items: {src: '#template-login'},
            type: 'inline',
            overflowY: 'scroll',
            //removalDelay: 300,
            closeOnBgClick: false,
            closeMarkup: '<button title="Close (Esc)" type="button" class="mfp-close" style="color: #42415E">&#215;</button>',
            mainClass: 'my-mfp-zoom-in',
            callbacks: {
                beforeClose: function (e) {
                    console.log($(this));
                },
                close: function (e) {
                    console.log(e);
                }
            }
        });
        return false;
    });

    //инициализация слайдера на главной на первом экране
    $('.problems-slider').slick({
        dots: true
    });

    //инициализация нижнего слайдера на главной с вопросами
    $('.questions-slider').slick({
        arrows: false,
        autoplay: true,
        autoplayspeed: 4000,
        slidesToShow: 5,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 770,
                settings: {
                    slidesToShow: 2,
                    centerMode: true
                }
            },
            {
                breakpoint: 550,
                settings: {
                    centerMode: true,
                    slidesToShow: 2,
                    centerPadding: '10px'
                }
            },
            {
                breakpoint: 400,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    centerPadding: '40px'
                }
            }
        ]
    });

    //инициализация слайдера с отзывами на главной
    $('.reviews-slider').slick({
        dots: true
    });

    //инициализация слайдера с новостями на главной
    $('.news-slider').slick({
        slidesToShow: 4,
        dots: true,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 770,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 650,
                settings: "unslick"
            }
        ]
    });

    //инициализация табов
    $('.js-tabs ul li a').tabs();

    //клик на фильтры на странице отзывы
    $(document).on('click', '.reviews-page-filters ul li', function () {
        $(this).toggleClass('active');
    });

    //инициализация слайдера в асайде
    $('.aside-slider').slick({
        dots: true
    });

    //инициализация стайлера
    $('.styler').styler({
        'selectSmartPositioning': false,
    });

    //выбор бюджета на странице поиска
    $(document).on('click', '.request-verification .bottom .budget .list-of-budgets div', function () {
        $('.request-verification .bottom .budget .list-of-budgets div').removeClass('active');
        $(this).addClass('active');
    });

    //инициализация слайдера до и после
    $('.before-after-slider').slick({
        dots: true
    });

    //инициализация слайдера другие статьи
    $('.other-articles-slider').slick({
        dots: true
    });

    //инициализация слайдера фотографий клиники на страницы клиники
    $('.clinic-slider').slick({
        dots: true
    });

    //инициализация слайдера фотографий клиники на страницы клиники
    $('.other-clinics-slider').slick({
        dots: true,
        slidesToShow: 3,
        responsive: [
            {
                breakpoint: 650,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 450,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });

    //работа input на странице вопросов
    $('.questions-page-1 .right input').focusin(function () {
        $('.questions-page-1 .right').addClass('focused');
    });
    $('.questions-page-1 .right input').focusout(function () {
        $('.questions-page-1 .right').removeClass('focused');
    });

    //якоря
    $(document).ready(function () {
        $("a.yak").click(function () {
            var elementClick = $(this).attr("href")
            var destination = $(elementClick).offset().top;
            jQuery("html:not(:animated),body:not(:animated)").animate({
                scrollTop: destination
            }, 800);
            return false;
        });
    });

    //перемещение якорей на fixed при скролле
    let scrollElement = document.querySelector('.scrolled-element-for-fixed');

    document.addEventListener('scroll', handleScroll);

    function handleScroll(e) {
        let pageOffset = window.pageYOffset;
        if (scrollElement) {
            let blockOffset = scrollElement.offsetTop;
            let blockHeight = scrollElement.offsetHeight;
            if ((pageOffset - blockOffset) > -54) {
                scrollElement.classList.add('fixed');
            } else {
                scrollElement.classList.remove('fixed');
            }
        }
        //console.log(pageOffset - blockOffset);
    }

    //работа меню в хэдере на мобилке
    $(document).on('click', 'header nav .dropdown-menu', function () {
        if ($(this).hasClass('opened')) {
            $(this).removeClass('opened');
            $('header nav > ul').slideUp('slow');
            $('header .login').removeClass('white');
        } else {
            $(this).addClass('opened');
            $('header nav > ul').slideDown('slow');
            $('header .login').addClass('white');
        }
    });
    $(document).on('click', 'header nav ul li.services-list span', function () {
        if ($(this).hasClass('opened')) {
            $(this).removeClass('opened');
            $('header nav ul li.services-list ul').slideUp('slow');
        } else {
            $(this).addClass('opened');
            $('header nav ul li.services-list ul').slideDown('slow');
        }
    });

    //работа асайда на мобилке
    $(document).on('click', '.content-with-aside aside .aside-button-mobile', function () {
        if ($(this).hasClass('opened')) {
            $(this).removeClass('opened');
            $('.content-with-aside aside .aside-button-mobile + div').slideUp('slow');
        } else {
            $(this).addClass('opened');
            $('.content-with-aside aside .aside-button-mobile + div').slideDown('slow');
        }
    });

    //работа поля для ввода поиска на мобилке
    $(document).on('click', '.questions-page-1 .right button', function () {
        if ($(this).hasClass('opened')) {
            $(this).removeClass('opened');
            $('.questions-page-1 .right').removeClass('focused');
        } else {
            $(this).addClass('opened');
            $('.questions-page-1 .right').addClass('focused');
        }
    });

    //инициализация слайдера на станице врача в месте работ
    $('.place-of-work-slider').slick({
        dots: true,
        responsive: [
            {
                breakpoint: 650,
                settings: {
                    arrows: false
                }
            }
        ]
    });

    //инициализация слайдера с врачами на главной
    $('.list-of-doctors-on-main-slider').slick({
        slidesToShow: 5,
        autoplay: true,
        autoplayspeed: 2500,
        centerMode: true,
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 750,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });

    // jquery extend function
    $.extend(
        {
            redirectPost: function (location, args) {
                var form = '';
                $.each(args, function (key, value) {
                    form += '<input type="hidden" name="' + key + '" value="' + value + '">';
                });
                $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body').submit();
            }
        });

    $('.maintenance').click(function () {

        $.magnificPopup.open({
            //items: { src: a.attr( 'data-href' ) },
            items: {src: '#template-maintenance'},
            type: 'inline',
            overflowY: 'scroll',
            //removalDelay: 300,
            closeMarkup: '<button title="Close (Esc)" type="button" class="mfp-close" style="color: #42415E">&#215;</button>',
            mainClass: 'my-mfp-zoom-in',
            callbacks: {
                beforeClose: function (e) {
                    console.log($(this));
                },
                close: function (e) {
                    console.log(e);
                }
            }
        });

        return false;

    });

    $(".fancybox").fancybox({
        openEffect: 'fade', /* none, fade, elastic */
        closeEffect: 'fade',
        openSpeed: 1000, /* ms, "slow", "normal", "fast"*/
        closeSpeed: 1000,
        /* mouseWheel : false,*/
        helpers: {
            /*title : null */
            title: {
                type: 'inside' /* 'float', 'inside', 'outside', 'over', 'null' */
            }
        }
    });

    $(document).on('click', '.reviews-page-filters ul li.plus', function () {
        $('.reviews-page-filters ul li').removeClass('display-none');
        $(this).hide();
    });

    //звезды
    $('#example-css').barrating({
        theme: 'css-stars',
        showSelectedRating: false
    });


    //работа кнопки показать все на странице клиники
    $(document).on('click', '.page-clinic-3 .btn', function () {
        $('.page-clinic-3 .list-of-doctors .item').removeClass('display-none');
        $(this).hide();
    });

    $('#frm-main-search').on('submit', function (e) {
        e.preventDefault();
        let url = $('#input-main-search').attr('data-url');
        if (url) {
            return window.location.href = '/reviews/' + url;
        }

        return window.location.href = '/reviews/';
    });

    $('#input-main-search').autocomplete({hint: true},
        {
            source: function (request, response) {
                $.ajax({
                    url: '/api/get_services/?value=' + request,
                    dataType: 'json',

                    success: function (data) {
                        lines = $.map(data, function (item, index) {
                            return {
                                value: item.title,
                                id: index,
                                alias: item.alias,
                                specialization_alias: item.specialization_alias
                            }
                        });
                        response(lines);
                    }
                })
            },
            displayKey: 'value',
            templates: {
                suggestion: function (suggestion) {
                    return suggestion.value;
                }
            }
        }
    ).on('autocomplete:selected', function (event, suggestion, dataset, context) {
        $('#input-main-search')
            .attr('data-url', suggestion.specialization_alias + '/' + suggestion.alias + '/');
        $('#frm-main-search').submit();
    });


});



















































