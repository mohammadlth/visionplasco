var disabled_ajax = false
var BaseUrl = $('meta[name=base_url]').attr('content');

function selectUser(id, name, product_id = null) {

    $('.chat-req-box').empty().append('<div class="text-center justify-center items-center"><i class="fa fa-spinner fa-spin"></i></div>');
    $('.user-chat-name').empty().text(name);

    $('.btn-chat').find('.default').addClass('hidden');
    $('.btn-chat').find('.load').removeClass('hidden');


    if (!disabled_ajax) {
        disabled_ajax = true;
        $.ajax({
            url: BaseUrl + 'portal/chat/select/user/box',
            type: "post",
            data: {
                contact_id: id,
                product_id: product_id
            },
            success: (response => {
                disabled_ajax = false;
                $('.chat-box-content-parent').animate({"bottom": 0}, 500).empty().append(response.view);
                var chat_box = $('.chat-box-content');
                chat_box.scrollTop(chat_box.prop('scrollHeight'))
                loadData(id);
                $('.btn-chat').find('.default').removeClass('hidden');
                $('.btn-chat').find('.load').addClass('hidden');
            }),
            error: ((jqXHR) => {
                disabled_ajax = false;
                $('.chat-box-content-parent').animate({"bottom": '-500px'}, 500);
                toastr.error('', jqXHR.responseJSON.message, {
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": true,
                });
                $('.btn-chat').find('.default').removeClass('hidden');
                $('.btn-chat').find('.load').addClass('hidden');
            })
        });
    }
}

function loadData(id) {

    $('.onclick-btn-box-send').click(function () {
        var value = $('.message-input-box').val();
        var chat_box = $('.chat-box-content');

        if (!disabled_ajax) {
            $.ajax({
                url: BaseUrl + 'portal/chat/store/box',
                type: "post",
                data: {
                    contact_id: id,
                    message: value,
                    product_id: $('input[name=product_chat_id]').length ? $('input[name=product_chat_id]').val() : null
                },
                success: (response => {
                    disabled_ajax = false;
                    $('.message-input-box').val('');
                    $('.messages-list').last().append(response.view);
                    chat_box.animate({scrollTop: chat_box.prop("scrollHeight")});
                    if ($('.box-chat-empty').length) {
                        $('.box-chat-empty').remove();
                    }
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

    $('.close-model-chat').click(function () {
        $('.chat-box-content-parent').animate({"bottom": '-500px'}, 500);
    });

}