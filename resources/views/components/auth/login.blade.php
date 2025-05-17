<div class="check-exist text-center">

    <p class="text-small text-center">
        <small class="text-gray-500">کلمه عبور را وارد کنید </small>
    </p>

    <div class="relative mt-3">
        <input  name="mobile" class="border pl-12 pr-4 py-2 border-gray-200 rounded-lg  w-full" dir="ltr"
                placeholder="9********" value="{{$mobile}}" />
        <span style="margin-top: 1px;left:1px"
              class="absolute p-2 rounded-l-lg bg-gray-100 text-gray-600  top-0"
              dir="ltr">+98</span>
        <i class="fal fa-mobile absolute top-4 right-3"></i>
    </div>

    <div class="relative mt-5">
        <input  name="password" type="password" class="border text-center pl-2 pr-2 py-2 border-gray-200 rounded-lg  w-full" dir="ltr"
                placeholder="کلمه عبور" value="" />
        <i class="fal fa-key absolute top-4 right-3"></i>
    </div>
    <div class="mt-3">
        <p class="text-right text-xs text-gray-500 cursor-pointer" onclick="ForgetPassword()">
            رمز عبور خود را فراموش کردید ؟
        </p>
    </div>

    <div class="mt-3">
        <button onclick="Login()"
                class="bg-custom-900 flex text-center justify-center items-center gap-3 text-white rounded-md w-full p-2 btn-ajax">
            <i class="fa fa-spinner  text-white fa-spin hidden"></i>
            <span class="text-white">وارد شوید</span>
        </button>
    </div>
</div>