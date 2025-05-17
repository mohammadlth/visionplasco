<div class="check-exist text-center">
    <input type="hidden" name="mobile"
           class="border w-full border-gray-200 p-2 rounded-md text-center" value="{{$mobile}}"
           dir="ltr" placeholder="09xxxxxxxxx">
    <div class="mt-3 text-right">
        <label class="text-xs text-gray-800 my-1"> رمز عبور خود را وارد کنید </label>
        <input type="password" name="password"
               class="border w-full border-gray-200 p-3 rounded-md text-center"
               dir="ltr" placeholder="رمز عبور خود را وارد کنید">
    </div>
    <div class="mt-3 text-right">
        <a href="{{route('auth')}}" class="text-right text-xs text-gray-500 cursor-pointer">
            رمز عبور خود را فراموش کردید ؟
        </a>
    </div>

    <div class="mt-3">
        <button onclick="LoginModal()"
                class="bg-green-500 flex text-center justify-center items-center gap-3 text-white rounded-md w-full p-3 btn-ajax">
            <i class="fa fa-spinner fa-spin hidden"></i>
            <span>مرحله بعد</span>
        </button>
    </div>
</div>
