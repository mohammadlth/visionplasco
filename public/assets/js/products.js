var cities = [];
var city_child = [];

var fields = {
    catId: '',
    sort: 'default',
    c : '',
    r : '',
    page : 1
}

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
        fields.r = val;
        urlPush(fields);
        $('select[name=city]').empty().append('<option value=""> انتخاب شهر </option>');
        $.each(city_child[val], function (index, value) {
            $('select[name=city]').append('<option value="' + value.id + '">' + value.name + '</option>');
        });
    });

    $('select[name=city]').on('change', function () {
        var val = $(this).val();
        fields.c = val;
        urlPush(fields);
    });


    $('.have-children-filter').click(function (){

        $(this).find('.children-items').addClass('active').slideDown();
    });

    $('.btn-child-category').click(function (){
        $('.btn-child-category').removeClass('text-custom-900');
        $(this).addClass('text-custom-900');
    })

});


function category_load(id){
    fields.catId = id + '';
    urlPush(fields)
}

function sortSet(item , ele){

    $('.filter-view').removeClass('text-custom-900');
    $(ele).addClass('text-custom-900');

    fields.sort = item;
    urlPush(fields);
}

function urlPush(params) {

    var queryParams = new URLSearchParams(window.location.search);

    $.each(params, function (key, value) {
        if (value.length > 0) {
            queryParams.set(key, value.toString());
        } else {
            queryParams.delete(key);
        }
        return history.replaceState(null, null, "?" + queryParams.toString());
    });

    loadData();
}


function loadData(){
    $('.card-product').addClass('is-loading');
    $.ajax({
        url: window.location.href,
        data: {},
        type: "POST",
        success: function (response) {
            console.log(response);
            $('.content-products').empty().append(response.view);
            $('.card-product').removeClass('is-loading');
        }
    });

}
