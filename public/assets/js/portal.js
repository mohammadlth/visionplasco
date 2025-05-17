var csrf = $('meta[name=csrf]').attr('content');
var BaseUrl = $('meta[name=base_url]').attr('content');

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrf
        }
    });
});
