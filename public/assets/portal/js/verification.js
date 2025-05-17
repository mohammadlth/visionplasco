$(document).ready(function () {
    $("#verification_pic").uploadFile({
        url: BaseUrl + "portal/upload/file",
        fileName: "image",
        uploadStr: "<strong>بارگذاری تصویر کارت ملی</strong>",
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
        showDelete: true,
        showDownload: false,
        showPreview: true,
        previewHeight: "50px",
        previewWidth: "50px",
        onSuccess: function (files, data, xhr, pd) {
            if (data.success) {
                $.ajax({
                    url: BaseUrl + 'portal/verification/upload',
                    type: "post",
                    data: {
                        image: data.image
                    },
                    success: (response => {
                        if (response.success){
                            toastr.success('', 'اطلاعات شما با موفقیت ذخیره شد و پس از بازبینی اکانت شما تایید خواهد شد', {
                                "progressBar": true,
                                "positionClass": "toast-top-center mt-5",
                                "preventDuplicates": true,
                            });
                        }
                    }),
                    error: ((jqXHR) => {
                        toastr.error('', 'خطا در دریافت اطلاعات', {
                            "progressBar": true,
                            "positionClass": "toast-top-center mt-5",
                            "preventDuplicates": true,
                        });
                    })
                });

            } else {
                toastr.error('', data.message, {
                    "progressBar": true,
                    "positionClass": "toast-top-center mt-5",
                    "preventDuplicates": true,
                });
            }
        },

    });

});