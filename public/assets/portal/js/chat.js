$(document).ready(function () {
    $('.back-chat').on('click', function () {
        $('.chat-box-relative').addClass('hidden');
        $('.box-content-relative').removeClass('hidden');
    });
});


var disabled_ajax = false

function selectUser(id) {
    if ($(window).width() < 650) {
        $('.chat-box-relative').removeClass('hidden');
        $('.box-content-relative').addClass('hidden');
    }

    var chat_box = $('.chat-box-content');

    if (!disabled_ajax) {
        disabled_ajax = true;
        $.ajax({
            url: BaseUrl + 'portal/chat/select/user',
            type: "post",
            data: {
                contact_id: id
            },
            success: (response => {
                disabled_ajax = false;
                $('.chat-req-box').empty();
                $('.chat-req-box').append(response.view);
                var chat_box = $('.chat-box-content');
                chat_box.scrollTop(chat_box.prop('scrollHeight'))
                loadData(id);
            }),
            error: ((jqXHR) => {
                disabled_ajax = false;
                toastr.error('', 'خطا در دریافت اطلاعات', {
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": true,
                });
            })
        });
    }
}

function loadData(id) {

    $('.onclick-btn').click(function () {
        var value = $('.message-input').val();
        var chat_box = $('.chat-box-content');

        if (!disabled_ajax) {
            $.ajax({
                url: BaseUrl + 'portal/chat/store',
                type: "post",
                data: {
                    contact_id: id,
                    message: value
                },
                success: (response => {
                    disabled_ajax = false;
                    $('.message-input').val('');
                    $('.messages-list').last().append(response.view);
                    chat_box.animate({scrollTop: chat_box.prop("scrollHeight")})
                }),
                error: ((jqXHR) => {
                    disabled_ajax = false;
                    toastr.error('', 'خطا در دریافت اطلاعات', {
                        "progressBar": true,
                        "positionClass": "toast-top-center",
                        "preventDuplicates": true,
                    });
                })
            });
        }

    });

}
