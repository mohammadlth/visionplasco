$(document).ready(function () {
    var typingTimer;                //timer identifier
    var doneTypingInterval = 700;  //time in ms, 5 seconds for example
    var $input = $('.search-buyers');

    $input.on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
        $('.loading-data-spin').removeClass('hidden');
    });

    $input.on('keydown', function () {
        clearTimeout(typingTimer);
    });


    var $inputh = $('.search-buyers-list');

    $inputh.on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping2, doneTypingInterval);
        $('.loading-data-spin').removeClass('hidden');
    });

    $inputh.on('keydown', function () {
        clearTimeout(typingTimer);
    });


});

function doneTyping() {
    var value = $('.search-buyers').val();
    $.ajax({
        url: BaseUrl + 'portal/buyer/request',
        type: "post",
        data: {
            s: value
        },
        success: (response => {
            $('.loading-data-spin').addClass('hidden');
            if (response.success) {
                $('.requests-list').empty().append(response.view);
            }
        }),
    });
}

function doneTyping2() {
    var value = $('.search-buyers-list').val();
    $.ajax({
        url: BaseUrl + 'buy-req/zgr',
        type: "post",
        data: {
            s: value
        },
        success: (response => {
            if (response.success) {
                $('.loading-data-spin').addClass('hidden');
                $('.infinite-scroll').empty().append(response.view);
            }
        }),
    });
}

