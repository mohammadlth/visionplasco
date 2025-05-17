var routeMap = [];

$(document).ready(function () {

    var typingTimer;
    var doneTypingInterval = 700;
    var $input = $('input[name=search]');

    $input.on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
        $('.loading-data-spin').removeClass('hidden');
        $('.loading-data-search').addClass('hidden');
    });

    $input.on('keydown', function () {
        clearTimeout(typingTimer);
    });

    $('.list-category li').click(function () {
        $('.steps').addClass('hidden');
        $('.prev-step-category').removeClass('hidden')

        var id = $(this).data('id');
        var item = '#child-' + id;
        $(item).removeClass('hidden');

        parentCat = $(this).parent().attr('id');

        $('.prev-step-category').attr('data-step', parentCat);
        $('.prev-step-category span').text($(this).find('span').text())

        routeMap.push({
            'text': $(this).find('span').text(),
            'item': '#child-' + $(this).parent().data('child')
        });

        var step = '.step-' + $(this).parent().data('step');
        $(step).addClass('hidden');
        var value = ''
        routeMap.map(function (val) {
            value += '> ' + val.text;
        });
        $('#category').val(value);

        var haveChild = $(this).attr('have-child');
        if (haveChild == 'false') {
            $('.category-select').addClass('hidden');

        }

    });
    $('.prev-step-category').click(function () {
        var item = routeMap[routeMap.length - 1];
        $('.steps').addClass('hidden');
        $('.prev-step-category span').text(item.text);
        $(item.item).removeClass('hidden')
        routeMap.pop();

        if (routeMap.length == 0) {
            $('.prev-step-category').addClass('hidden')
        }

        var value = ''
        routeMap.map(function (val) {
            value += '> ' + val.text;
        });
        $('#category').val(value);


    });
    $('#category').click(function () {
        $('.category-select').removeClass('hidden');

    });
    $('.close-modal').click(function () {
        $('.category-select').addClass('hidden');
    });
    new Swiper('.swiper-products', {
        spaceBetween: 20,
        slidesPerView: 5,
        loop: true,
        dir: 'rtl',
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 2000,
        },
        breakpoints: {
            100: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            800: {
                slidesPerView: 2,
                spaceBetween: 12,
            },
            900: {
                slidesPerView: 3,
                spaceBetween: 13,
            },
            1000: {
                slidesPerView: 5,
                spaceBetween: 15,
            },
            1500: {
                slidesPerView: 5,
                spaceBetween: 20,
            },
            2500: {
                slidesPerView: 5,
                spaceBetween: 20,
            }
        },

    });

    new Swiper('.swiper-products-2', {
        spaceBetween: 20,
        slidesPerView: 5,
        loop: true,
        dir: 'rtl',
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 2000,
        },
        breakpoints: {
            100: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            800: {
                slidesPerView: 2,
                spaceBetween: 12,
            },
            900: {
                slidesPerView: 3,
                spaceBetween: 13,
            },
            1000: {
                slidesPerView: 7,
                spaceBetween: 15,
            },
            1500: {
                slidesPerView: 7,
                spaceBetween: 20,
            },
            2500: {
                slidesPerView: 7,
                spaceBetween: 20,
            }
        },

    });
});

function doneTyping() {

    var value = $('input[name=search]').val();

    $.ajax({
        url: BaseUrl + 'search',
        type: "post",
        data: {
            s: value
        },
        success: (response => {
            $('.loading-data-spin').addClass('hidden');
            $('.loading-data-search').removeClass('hidden');
            if (response.success) {
                $('.search-content').removeClass('hidden').empty().append(response.view);
            }
        }),
    });

}
