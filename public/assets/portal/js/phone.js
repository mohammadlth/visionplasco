$(document).ready(function (){
    $('.close-model').click(function () {
        $('.modal-contact').fadeOut('fast');
    });
    $('.class-content-modal').click(function (event) {
        event.stopPropagation();
    });
});

function showPhone(contact_id) {
    $('.btn-call').find('.default').addClass('hidden');
    $('.btn-call').find('.load').removeClass('hidden');
    $.ajax({
        url: BaseUrl + 'portal/phone/view',
        type: "post",
        data: {
            contact_id: contact_id
        },
        success: (response => {
            if (response.success) {
                $('.phone-text').text('0' + response.mobile);
                $('.call-buyer').attr('href' , 'tel:' + '0' + response.mobile);
                $('.modal-contact').fadeIn('fast');
            }
            $('.btn-call').find('.default').removeClass('hidden');
            $('.btn-call').find('.load').addClass('hidden');
        }),
    });

}