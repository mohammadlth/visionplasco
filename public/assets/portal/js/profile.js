$(document).ready(function () {

    $('select[name=account_type]').on('change', function () {
        let value = $(this).val();
        if (value == 'personal') {
            $('.company').addClass('hidden');
        } else {
            $('.company').removeClass('hidden');
        }
    });

    $('.change-mobile').click(function () {

        $(this).attr('disabled', true);
        $(this).text('');
        $(this).append('<i class="fa fa-spinner fa-spin text-white"></i>');
        $.ajax({
            url: BaseUrl + 'portal/profile/update/mobile',
            type: "post",
            data: {
                mobile: $('input[name=mobile]').val()
            },
            success: (response => {
                $(this).empty();
                $(this).text('ارسال کد تایید');
                $(this).attr('disabled', false);
                if (response.success) {
                    $('.mobile-box').removeClass('hidden');
                    toastr.success('', response.message, {
                        "progressBar": true,
                        "positionClass": "toast-top-left",
                        "preventDuplicates": true,
                    });
                }

            }),
            error: ((jqXHR) => {
                $(this).empty();
                $(this).text('ارسال کد تایید');
                $(this).attr('disabled', false);
                toastr.error('', jqXHR.responseJSON.message, {
                    "progressBar": true,
                    "positionClass": "toast-top-left",
                    "preventDuplicates": true,
                });
            }),
        });

    });

    $("#profile_pic").uploadFile({
        url: BaseUrl + "portal/upload/file",
        fileName: "image",
        uploadStr: "برای افزودن یا تغییر تصویر کلیک کنید",
        acceptFiles: "image/jpg",
        maxFileCount: 10,
        maxFileSize: 5000 * 1024,
        dragDropStr: "",
        sizeErrorStr: "حجم فایل غیر مجاز",
        uploadErrorStr: "خطایی رخ داد",
        multiple: false,
        dragDrop: false,
        formData: {"csrf": csrf},
        returnType: "json",
        showDelete: false,
        showDownload: false,
        showPreview: false,
        previewHeight: "50px",
        previewWidth: "50px",
        onSuccess: function (files, data, xhr, pd) {
            if (data.success) {
                $.ajax({
                    url: BaseUrl + 'portal/profile/update/pic',
                    type: "post",
                    data: {
                        image: data.image
                    },
                    success: (response => {
                        if (response.success) {
                            $('.image-profile').attr('src', BaseUrl + data.image)
                        }
                    }),
                    error: ((jqXHR) => {
                        toastr.error('', 'خطا در دریافت اطلاعات', {
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": true,
                        });
                    })
                });

            } else {
                toastr.error('', 'خطا در ثبت اطلاعات', {
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": true,
                });
            }
        },

    });

    $("#accounts_pic").uploadFile({
        url: BaseUrl + "portal/upload/file",
        fileName: "image",
        uploadStr: "برای افزودن تصویر کلیک کنید",
        acceptFiles: "image/jpg",
        maxFileCount: 5,
        maxFileSize: 5000 * 1024,
        dragDropStr: "",
        sizeErrorStr: "حجم فایل غیر مجاز",
        uploadErrorStr: "خطایی رخ داد",
        multiple: true,
        dragDrop: true,
        formData: {"csrf": csrf},
        returnType: "json",
        showDelete: false,
        showDownload: false,
        showPreview: true,
        previewHeight: "50px",
        previewWidth: "50px",
        onSuccess: function (files, data, xhr, pd) {
            if (data.success) {
                $.ajax({
                    url: BaseUrl + 'portal/profile/insert/photo',
                    type: "post",
                    data: {
                        image: data.image
                    },
                    success: (response => {
                        if (response.success) {
                            $('.empty-items-photos').addClass('hidden');
                            $('.append-photo-file').append('<div class="photo">' +
                                '<img src="' + BaseUrl + '' + data.image + '" class="w-full" alt="">' +
                                '<a href="" class="bg-red-500 block w-full text-white  py-2 text-center text-xs">حذف تصویر</a>' +
                                '</div>');
                        }
                    }),
                    error: ((jqXHR) => {
                        toastr.error('', 'خطا در دریافت اطلاعات', {
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": true,
                        });
                    })
                });
            } else {
                toastr.error('', 'خطا در ثبت اطلاعات', {
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": true,
                });
            }
        },

    });

    $("#certificate_pic").uploadFile({
        url: BaseUrl + "portal/upload/file",
        fileName: "image",
        uploadStr: "برای افزودن تصویر کلیک کنید",
        acceptFiles: "image/jpg",
        maxFileCount: 5,
        maxFileSize: 5000 * 1024,
        dragDropStr: "",
        sizeErrorStr: "حجم فایل غیر مجاز",
        uploadErrorStr: "خطایی رخ داد",
        multiple: true,
        dragDrop: true,
        formData: {"csrf": csrf},
        returnType: "json",
        showDelete: false,
        showDownload: false,
        showPreview: true,
        previewHeight: "50px",
        previewWidth: "50px",
        onSuccess: function (files, data, xhr, pd) {
            if (data.success) {
                $.ajax({
                    url: BaseUrl + 'portal/profile/insert/certificate',
                    type: "post",
                    data: {
                        image: data.image
                    },
                    success: (response => {
                        if (response.success) {
                            $('.empty-items-certificate').addClass('hidden');
                            $('.append-certificate-file').append('<div class="photo">' +
                                '<img src="' + BaseUrl + '' + data.image + '" class="w-full" alt="">' +
                                '<a href="" class="bg-red-500 block w-full text-white  py-2 text-center text-xs">حذف تصویر</a>' +
                                '</div>');
                        }
                    }),
                    error: ((jqXHR) => {
                        toastr.error('', 'خطا در دریافت اطلاعات', {
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": true,
                        });
                    })
                });
            } else {
                toastr.error('', 'خطا در ثبت اطلاعات', {
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": true,
                });
            }
        },

    });


});