var photos = [];
$(document).ready(function () {

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
                photos.push(data.image)
                $('.items-photos').append('<input name="photos[]" type="hidden" value="' + data.image + '">')
            } else {
                toastr.error('', 'خطا در ثبت اطلاعات', {
                    "progressBar": true,
                    "positionClass": "toast-top-left",
                    "preventDuplicates": true,
                });
            }
        },
        deleteCallback: function (data, pd) {
            $('.items-photos').empty();
            const index = photos.indexOf(data.image);
            if (index > -1) {
                photos.splice(index, 1);
            }
            $.each(photos , function (index , value){
                $('.items-photos').append('<input name="photos[]" type="hidden" value="' + value + '">')
            });

            pd.statusbar.hide(); //You choice.

        },

    });


});