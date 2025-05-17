<div class="check-exist text-center">

    <div class="mt-3 text-right">
        <input type="hidden" name="mobile" value="{{$mobile}}">
        <label class="text-xs text-gray-800 my-1"> پیامک ارسالی به شماره :
            {{$mobile}}
        </label>
        <input type="text" name="code"
               class="border w-full mt-2 border-gray-200 p-3 rounded-md text-center"
               dir="ltr" placeholder="xxxxx : کد پیامک شده">
    </div>
    <div class="mt-3">
        <button onclick="Register()"
                class="bg-green-500 flex text-center justify-center items-center gap-3 text-white rounded-md w-full p-3 btn-ajax">
            <i class="fa fa-spinner fa-spin hidden"></i>
            <span> تایید کد و مرحله بعد </span>
        </button>
    </div>
</div>