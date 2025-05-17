<div class="check-exist text-center">

    <p class="text-small text-center">
        <small class="text-gray-500">حساب کاربری خود را تکمیل کنید </small>
    </p>


    <div class="relative mt-3">
        <input type="hidden" name="mobile" value="{{$mobile}}">
        <input type="text" name="code"
               class="border w-full mt-2 border-gray-200 p-2 rounded-md text-center"
               dir="ltr" placeholder="xxxxx : کد پیامک شده">
        <i class="fal fa-mobile absolute top-6 right-3"></i>

        <p class="text-left">
            <small class="text-xs text-gray-500">
                تادرخواست مجدد کد :
                <span class="timer-control"></span>
                <span class="second-timer">ثانیه دیگر</span>
            </small>
        </p>
    </div>
    <div class="relative my-5 text-right">
        <div class="grid grid-cols-2 gap-3">
            <input name="type" type="hidden" value="">

            <div class="user-type seller text-center w-full border-2 rounded-md p-3 cursor-pointer" id="buyer"
                 onclick="chooseType('buyer')">
                <img class="w-8 invert mx-auto" src="{{asset('assets/img/user-buy.svg')}}">
                <p class="text-xs mt-2 font-bold text-black"> خریدار هستم</p>

            </div>
            <div class="user-type buyer text-center w-full border-2 rounded-md p-3 cursor-pointer" id="seller"
                 onclick="chooseType('seller')">
                <img class="w-8 invert mx-auto" src="{{asset('assets/img/farmer.svg')}}">
                <p class="text-xs mt-2 font-bold text-black"> فروشنده هستم</p>
            </div>
        </div>
    </div>
    <div class="relative mt-3 text-right">
        <label class="text-xs text-gray-800 my-1"> نام و نام خانوادگی </label>
        <input type="text" name="name"
               class="border w-full mt-2 border-gray-200 p-2 rounded-md text-center" placeholder="نام خود را وارد کنید">
    </div>

    <div class="relative mt-3 text-right">
        <label class="text-xs text-gray-800 my-1"> رمز عبور </label>
        <input type="password" name="password"
               class="border w-full mt-2 border-gray-200 p-2 rounded-md text-center"
               placeholder="یک کلمه عبور برای حساب خود وارد کنید">
    </div>
    <div class="relative mt-3 text-right">
        <label class="text-xs text-gray-800 my-1"> تایید رمز عبور </label>
        <input type="password" name="password_confirmation"
               class="border w-full mt-2 border-gray-200 p-2 rounded-md text-center"
               placeholder="کلمه عبور را مجددا وارد کنید">
    </div>
    <div class="relative mt-3">
        <button onclick="Register()"
                class="bg-custom-900 flex text-center justify-center items-center gap-3 text-white rounded-md w-full p-2 btn-ajax">
            <i class="fa fa-spinner text-white fa-spin hidden"></i>
            <span class="text-white">تکمیل و ثبت
            نام</span>
        </button>
    </div>
</div>

<script>

</script>