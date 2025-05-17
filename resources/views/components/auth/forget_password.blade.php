<div class="check-exist text-center">
    <p class="text-small text-center">
        <small class="text-gray-500">

            بازیابی رمز عبور :
            <span class="text-black"> {{$mobile}} </span>

        </small>
    </p>

    <div class="relative mt-3">
        <input type="hidden" name="mobile" value="{{$mobile}}">
        <input type="text" name="code" autocomplete="false"
               class="border w-full border-gray-200 p-2 rounded-md text-center"
               dir="ltr" placeholder="xxxxx : کد ارسال شده   ">
        <i class="fal fa-mobile absolute top-4 right-3"></i>

        <p class="text-left">
            <small class="text-xs text-gray-500">
                تادرخواست مجدد کد :
                <span class="timer-control"></span>
                <span class="second-timer">ثانیه دیگر</span>
            </small>
        </p>

    </div>

    <div class="relative mt-3">
        <input type="password" name="password"
               class="border w-full mt-2 border-gray-200 p-2 rounded-md text-center"
               placeholder="کلمه عبور جدید">
        <i class="fal fa-key absolute top-6 right-3"></i>
    </div>
    <div class="relative mt-3">
        <input type="password" name="password_confirmation" autocomplete="false"
               class="border w-full mt-2 border-gray-200 p-2 rounded-md text-center"
               placeholder="کلمه عبور را مجددا وارد کنید">
        <i class="fal fa-key absolute top-6 right-3"></i>
    </div>

    <div class="mt-3">
        <button onclick="ForgetPasswordConfirm()"
                class="bg-custom-900 flex text-center justify-center items-center gap-3 text-white rounded-md w-full p-2 btn-ajax">
            <i class="fa fa-spinner text-white fa-spin hidden"></i>
            <span class="text-white">بازنشانی رمز عبور</span>
        </button>
    </div>

</div>