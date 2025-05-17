var csrf = $('meta[name=csrf]').attr('content');
var BaseUrl = $('meta[name=base_url]').attr('content');

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrf
        }
    });
});

async function CheckExist() {

    var mobile = $('input[name=mobile]').val();
    $('.btn-ajax').attr('disabled', true);
    $('.fa-spin').removeClass('hidden');

    await $.ajax({
        url: BaseUrl + 'exist/check',
        type: "post",
        data: {
            'mobile': mobile
        },
        success: (response => {
            $('.btn-ajax').attr('disabled', false);
            $('.fa-spin').addClass('hidden');
            $('.content-auth').empty();
            $('.content-auth').append(response.view);

            if (response.timer) {

                let time = response.timer;

                let interval = setInterval(() => {
                    $('.timer-control').text(time)
                    time--;

                    if (time <= 0) {
                        $('.second-timer').addClass('hidden');
                        $('.timer-control').empty();
                        $('.timer-control').append('<span class="text-custom-900 cursor-pointer" onclick="CheckExist()">ارسال مجدد </span>')
                    }

                    if (time < 0) {
                        clearInterval(interval)
                    }


                }, 1000);

            }
        }),
        error: ((jqXHR) => {
            $('.btn-ajax').attr('disabled', false);
            $('.fa-spin').addClass('hidden');
            toastr.error('', jqXHR.responseJSON.message, {
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
            });
        })
    })
}

async function Register() {

    $('.btn-ajax').attr('disabled', true);
    $('.fa-spin').removeClass('hidden');

    var code = $('input[name=code]').val();
    var name = $('input[name=name]').val();
    var mobile = $('input[name=mobile]').val();
    var type = $('input[name=type]').val();
    var password = $('input[name=password]').val();
    var password_confirmation = $('input[name=password_confirmation]').val();


    await $.ajax({
        url: BaseUrl + 'auth/register',
        type: "post",
        data: {
            'mobile': mobile,
            'code': code,
            'name': name,
            'type': type,
            'password': password,
            'password_confirmation': password_confirmation,
        },
        success: (response => {

            if (response.success) {
                location.replace(BaseUrl)
            }

        }),
        error: ((jqXHR) => {
            $('.btn-ajax').attr('disabled', false);
            $('.fa-spin').addClass('hidden');

            toastr.error('', jqXHR.responseJSON.message, {
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
            });
        })
    })
}

async function Login() {

    $('.btn-ajax').attr('disabled', true);
    $('.fa-spin').removeClass('hidden');

    var mobile = $('input[name=mobile]').val();
    var password = $('input[name=password]').val();


    await $.ajax({
        url: BaseUrl + 'auth/login',
        type: "post",
        data: {
            'mobile': mobile,
            'password': password,
        },
        success: (response => {

            if (response.success) {
                location.replace(BaseUrl)
            }

        }),
        error: ((jqXHR) => {
            $('.btn-ajax').attr('disabled', false);
            $('.fa-spin').addClass('hidden');

            toastr.error('', jqXHR.responseJSON.message, {
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
            });
        })
    })
}

async function ForgetPassword() {

    $('.btn-ajax').attr('disabled', true);
    $('.fa-spin').removeClass('hidden');

    var mobile = $('input[name=mobile]').val();

    await $.ajax({
        url: BaseUrl + 'auth/forget/password',
        type: "post",
        data: {
            'mobile': mobile,
        },
        success: (response => {
            $('.btn-ajax').attr('disabled', false);
            $('.fa-spin').addClass('hidden');

            $('.content-auth').empty();
            $('.content-auth').append(response.view);

            if (response.timer) {

                let time = response.timer;

                let interval = setInterval(() => {
                    $('.timer-control').text(time)
                    time--;

                    if (time <= 0) {
                        $('.second-timer').addClass('hidden');
                        $('.timer-control').empty();
                        $('.timer-control').append('<span class="text-custom-900 cursor-pointer" onclick="ForgetPassword()">ارسال مجدد</span>')
                    }

                    if (time < 0) {
                        clearInterval(interval)
                    }


                }, 1000);

            }
        }),
        error: ((jqXHR) => {
            $('.btn-ajax').attr('disabled', false);
            $('.fa-spin').addClass('hidden');

            toastr.error('', jqXHR.responseJSON.message, {
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
            });
        })
    })
}

async function ForgetPasswordConfirm() {

    $('.btn-ajax').attr('disabled', true);
    $('.fa-spin').removeClass('hidden');

    var mobile = $('input[name=mobile]').val();
    var code = $('input[name=code]').val();
    var password = $('input[name=password]').val();
    var password_confirmation = $('input[name=password_confirmation]').val();

    await $.ajax({
        url: BaseUrl + 'auth/forget/password/confirm',
        type: "post",
        data: {
            'mobile': mobile,
            'code': code,
            'password': password,
            'password_confirmation': password_confirmation,
        },
        success: (response => {
            if (response.success) {
                location.replace(BaseUrl)
            }
        }),
        error: ((jqXHR) => {
            $('.btn-ajax').attr('disabled', false);
            $('.fa-spin').addClass('hidden');

            toastr.error('', jqXHR.responseJSON.message, {
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
            });
        })
    })

}

function chooseType(type){
    $('.user-type').removeClass('active');
    $('#'+ type + '').addClass('active');
    $('input[name=type]').val(type)
}