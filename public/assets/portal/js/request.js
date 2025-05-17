var routeMap = [];

var fields = {
    category: null,
    type: null,
    inventory: null,
}
function setCatValue(parent_id, id, title, prev, next) {

    $.ajax({
        url: BaseUrl + 'portal/category/detail',
        type: "post",
        data: {
            id: id
        },
        success: (response => {
            if (response.success) {
                $('.placeholder-value').attr('placeholder', 'مثلا : ' + response.data.placeholder);
                $('.unit-text').empty();
                $('.unit-text').text(response.data.unit);
            }
        }),
    });

    $('.list-category').addClass('hidden');
    $(next).removeClass('hidden');
    setValueCat(title, next);
    if (next == 0) {
        $('.next-step-1').removeClass('hidden');
    }
}


function setValueCat(title, next) {

    if (next == 0) {
        fields.category = title;
        $('.category-name').text(title)
    }

    if ($.inArray(title, routeMap) == -1) {
        routeMap.push(title);
    }

    var value = '';
    routeMap.map(item => {
        value += ' > ' + item
    });
    $('#category').val(value)

}

$(document).ready(function () {

    $('.prev-level').click(function () {
        var level = $(this).data('to');
        var level_num = $(this).data('step');
        $('.levels').addClass('hidden');
        $(level).removeClass('hidden');

        $('.item-cat-model').removeClass('bg-custom-900');
        $('.item-cat-model span').removeClass('text-white');
        $('.item-cat-model span').addClass('text-gray-800');
        $('.item-cat-model').addClass('bg-gray-200');

        for (var i = level_num; i >= 1; i--) {
            $('#cat-step-li-' + i).addClass('bg-custom-900');
            $('#cat-step-li-' + i).removeClass('bg-gray-200');
            $('#cat-step-li-' + i + ' span').addClass('text-white');
            $('#cat-step-li-' + i + ' span').removeClass('text-gray-800');
        }

    });

    $('.add-level').click(function () {
        if (!$(this).attr('disabled')) {
            var level = $(this).data('to');
            var level_num = $(this).data('step');
            $('.levels').addClass('hidden');
            $(level).removeClass('hidden');

            $('.item-cat-model').removeClass('bg-custom-900');
            $('.item-cat-model span').removeClass('text-white');
            $('.item-cat-model span').addClass('text-gray-800');
            for (var i = level_num; i >= 1; i--) {
                $('#cat-step-li-' + i).addClass('bg-custom-900');
                $('#cat-step-li-' + i).removeClass('bg-gray-200');
                $('#cat-step-li-' + i + ' span').addClass('text-white');
                $('#cat-step-li-' + i + ' span').removeClass('text-gray-800');
            }

        }
    });


    $('.clear-category').click(function () {
        routeMap = []
        $('.steps').addClass('hidden');
        $('.list-category').eq(0).removeClass('hidden');
        $('#category').val('');
        $('.next-step-1').addClass('hidden');

    });

    // step 2
    $('input[name=type] , input[type=number]').keyup(function () {
        if ($(this).val() != '' && $(this).val().length >= 1 && $('.inventory-input').val() != '' && $('.inventory-input').val().length >= 1) {
            $('.btn-level-2').attr('disabled', false);
            fields.type = $('input[name=type]').val();
            fields.inventory =  $('.inventory-input').val();
        } else {
            $('.btn-level-2').attr('disabled', true);
        }

    });

});

function showError(message) {
    toastr.error('', message, {
        "progressBar": true,
        "positionClass": "toast-top-left",
        "preventDuplicates": true,
    });
}

// final level
function storeData() {

    if (fields.category == null || fields.category == '') {
        showError('دسته بندی را به درستی انتخاب کنید')
    }
    if (fields.type == null || fields.type == '') {
        showError('نوع محصول را وارد کنید')
    }
    if (fields.inventory == null || fields.inventory == '') {
        showError(' موجودی مورد نیاز را وارد کنید')
    }

    $.ajax({
        url: BaseUrl + 'portal/request/insert',
        type: "post",
        data: fields,
        success: (response => {
            if (response.success) {

                toastr.success('', 'اطلاعات با موفقیت ثبت شد', {
                    "progressBar": true,
                    "positionClass": "toast-top-left",
                    "preventDuplicates": true,
                });

                $('input').val('');
                $('textarea').val('');

                location.reload()

            } else {

                toastr.error('', response.message, {
                    "progressBar": true,
                    "positionClass": "toast-top-left",
                    "preventDuplicates": true,
                });

            }
        }),
        error: ((jqXHR) => {
            toastr.error('', 'خطا در دریافت اطلاعات', {
                "progressBar": true,
                "positionClass": "toast-top-left",
                "preventDuplicates": true,
            });
        })
    });


}
