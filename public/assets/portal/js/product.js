var routeMap = [];

var fields = {
    category: null,
    type: null,
    region: null,
    city: null,
    inventory: null,
    min_inventory: null,
    min_price: null,
    photos: [],
    description: null,
}

var cities = [];
var city = [];
var city_child = [];

$(document).ready(function () {

    $.ajax({
        url: BaseUrl + 'city/list',
        type: "post",
        data: {},
        success: (response => {
            cities = response.city
            $.each(cities, function (index, value) {
                $('select[name=region]').append('<option value="' + value.id + '">' + value.name + '</option>');
                city_child[value.id] = value.child
            });
        }),
        error: ((jqXHR) => {
            toastr.error('', 'خطا در دریافت اطلاعات', {
                "progressBar": true,
                "positionClass": "toast-top-left",
                "preventDuplicates": true,
            });
        })
    });

    $('select[name=region]').on('change', function () {
        var val = $(this).val();
        $('select[name=city]').empty();
        fields.region = val
        $.each(city_child[val], function (index, value) {
            $('select[name=city]').append('<option value="' + value.id + '">' + value.name + '</option>');
        });
    });

    $('select[name=city]').on('change', function () {
        fields.city = $(this).val()
    });

    $("#uploadFile").uploadFile({
        url: BaseUrl + "portal/upload/file",
        fileName: "image",
        uploadStr: "فایل خود را انتخاب کنید با به اینجا بکشید",
        acceptFiles: "image/jpg",
        maxFileCount: 4,
        maxFileSize: 5000 * 1024,
        dragDropStr: "",
        sizeErrorStr: "حجم فایل غیر مجاز",
        uploadErrorStr: "خطایی رخ داد",
        multiple: true,
        dragDrop: true,
        formData: {"csrf": csrf},
        returnType: "json",
        showDelete: true,
        showDownload: false,
        showPreview: true,
        previewHeight: "50px",
        previewWidth: "50px",
        onSuccess: function (files, data, xhr, pd) {
            if (data.success) {
                $('.btn-level-4').attr('disabled', false);
                fields.photos.push(data.image)
            } else {
                toastr.error('', 'خطا در ثبت اطلاعات', {
                    "progressBar": true,
                    "positionClass": "toast-top-left",
                    "preventDuplicates": true,
                });
            }
        },
        deleteCallback: function (data, pd) {
            const index = fields.photos.indexOf(data.image);
            if (index > -1) {
                fields.photos.splice(index, 1);
            }
            pd.statusbar.hide(); //You choice.
        },

    });
    $('.search-box').on('click', function () {

        var search = $(this).val();

        if (search == '') {
            $('.dropdown-menu').addClass('hidden');
            return false
        }

        $.ajax({
            url: BaseUrl + 'portal/search/category',
            type: "post",
            data: {
                search: search
            },
            success: (response => {
                // drop-down-list
                $('.drop-down-list').empty();
                $('.dropdown-menu').removeClass('hidden');
                if (response.success) {
                    $.each(response.data, function (key, value) {
                        $('.drop-down-list').append('<li data-id="' + value.id + '" data-title="' + value.title + '" class="cursor-pointer search-click text-sm" data-id="' + value.id + '">' +
                            '<p>' + value.title + '</p>' +
                            '</li>');
                    });

                    $('.search-click').click(function () {
                        var id = $(this).data('id');
                        var title = $(this).data('title');
                        $('#category').val('').val(title);
                        setCatValue(id, id, title, '#list-cat-0', 0, 1);
                        $('.dropdown-menu').addClass('hidden');

                    });

                }
            }),
        });
    });

    $('.search-box').on('keyup', function () {


        var search = $(this).val();

        if (search == '') {
            $('.dropdown-menu').addClass('hidden');
            return false
        }

        $.ajax({
            url: BaseUrl + 'portal/search/category',
            type: "post",
            data: {
                search: search
            },
            success: (response => {
                // drop-down-list
                $('.drop-down-list').empty();
                $('.dropdown-menu').removeClass('hidden');
                if (response.success) {
                    $.each(response.data, function (key, value) {
                        $('.drop-down-list').append('<li data-id="' + value.id + '" data-title="' + value.title + '" class="cursor-pointer search-click text-sm" data-id="' + value.id + '">' +
                            '<p>' + value.title + '</p>' +
                            '</li>');
                    });

                    $('.search-click').click(function () {
                        var id = $(this).data('id');
                        var title = $(this).data('title');
                        $('#category').val('').val(title);
                        setCatValue(id, id, title, '#list-cat-0', 0, 1);
                        $('.dropdown-menu').addClass('hidden');

                    });

                }
            }),
        });

    });

    $('.search').mouseleave(function () {
        $('.dropdown-menu').addClass('hidden');
    });


});

function setCatValue(parent_id, id, title, prev, next, ajax = 0) {

    $.ajax({
        url: BaseUrl + 'portal/category/detail',
        type: "post",
        data: {
            id: id
        },
        success: (response => {
            if (response.success) {
                $('input[name=type]').attr('placeholder', 'مثلا : ' + response.data.placeholder);
                $('.unit-text').empty();
                $('.unit-text').text(response.data.unit);
            }
        }),
    });

    $('.list-category').addClass('hidden');
    $(next).removeClass('hidden');

    setValueCat(title, next, ajax);
    if (next == 0) {
        $('.next-step-1').removeClass('hidden');
    }
}


function setValueCat(title, next, ajax = 0) {

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

    if (ajax == 0) {
        $('#category').val(value)
    }

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
    $('input[name=type]').keyup(function () {
        if ($(this).val() != '' && $(this).val().length >= 3) {
            $('.btn-level-2').attr('disabled', false);
            fields.type = $(this).val();
            fields.region = $('select[name=region]').val();
            fields.city = $('select[name=city]').val();
        } else {
            $('.btn-level-2').attr('disabled', true);
        }

    });

    // step 3
    $('input[name=inventory],input[name=min_inventory],input[name=min_price]').keyup(function () {
        if ($('input[name=inventory]').val() != '' && $('input[name=min_inventory]').val() != '' && $('input[name=min_price]').val() != '') {
            $('.btn-level-3').attr('disabled', false);
            fields.inventory = $('input[name=inventory]').val();
            fields.min_inventory = $('input[name=min_inventory]').val();
            fields.min_price = $('input[name=min_price]').val();
        } else {
            $('.btn-level-3').attr('disabled', true);

        }
    });

    // step 5
    $('textarea[name=description]').keyup(function () {
        if ($(this).val() != '' && $(this).val().length >= 10) {
            $('.btn-level-5').attr('disabled', false);
            fields.description = $(this).val();
        } else {
            $('.btn-level-5').attr('disabled', true);

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
    if (fields.region == null || fields.region == '') {
        showError('استان مبدا را انتخاب کنید')
    }
    if (fields.city == null || fields.city == '') {
        showError('شهر مبدا را انتخاب کنید')
    }
    if (fields.inventory == null || fields.inventory == '') {
        showError(' موجودی کالا را وارد کنید')
    }
    if (fields.min_inventory == null || fields.min_inventory == '') {
        showError('حداقل موجودی کالا را وارد کنید')
    }
    if (fields.min_price == null || fields.min_price == '') {
        showError('قیمت را وارد کنید')
    }
    if (fields.description == null || fields.description == '') {
        showError('توضیحات را وارد کنید')
    }

    $.ajax({
        url: BaseUrl + 'portal/product/insert',
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

                routeMap = []
                $('.levels').addClass('hidden');
                $('#cat-step-1').removeClass('hidden');

                $('.steps').addClass('hidden');
                $('.list-category').eq(0).removeClass('hidden');
                $('#category').val('');
                $('.next-step-1').addClass('hidden');

                $('.item-cat-model').addClass('bg-gray-200').removeClass('bg-custom-900');
                $('#cat-step-li-1').removeClass('bg-gray-200').addClass('bg-custom-900');

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
