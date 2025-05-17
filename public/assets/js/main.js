let mode = localStorage.getItem('mode');

var csrf = $('meta[name=csrf]').attr('content');
var BaseUrl = $('meta[name=base_url]').attr('content');

$(document).ready(function () {

    $(window).scroll(function () {
        if ($(window).scrollTop() > 400) {
            $('.nav-2').slideUp(200);
        } else {
            $('.nav-2').slideDown(200);

        }
    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrf
        }
    });

    $('.menu-bar ul .with-child').click(function () {
        $(this).find('ul').toggleClass('hidden');
    })
    $('.icon-bar').click(function () {
        $('.menu-bar').toggleClass('hidden');
    })

    $('.close-modal-login').click(function () {
        $('.modal-login').addClass('hidden');
    });
    $('#login-modal').click(function () {
        $('.modal-login').removeClass('hidden');

    });

    var typingTimerHeader;
    var doneTypingIntervalHeader = 700;
    var $input = $('input[name=search_header]');

    $input.on('keyup', function () {
        clearTimeout(typingTimerHeader);
        typingTimerHeader = setTimeout(doneTypingHeader, doneTypingIntervalHeader);
        $('.loading-data-spin-header').removeClass('hidden');
        $('.loading-data-search-header').addClass('hidden');
    });

    $input.on('keydown', function () {
        clearTimeout(typingTimerHeader);
    });

});

function doneTypingHeader() {

    var value = $('input[name=search_header]').val();

    $.ajax({
        url: BaseUrl + 'search',
        type: "post",
        data: {
            s: value
        },
        success: (response => {
            $('.loading-data-spin-header').addClass('hidden');
            $('.loading-data-search-header').removeClass('hidden');
            if (response.success) {
                $('.search-content-header').removeClass('hidden').empty().append(response.view);
            }
        }),
    });
}
