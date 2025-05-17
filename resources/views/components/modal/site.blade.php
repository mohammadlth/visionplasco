<div class="check-exist text-center">
    <div class="mt-3 text-right">
        <label class="text-xs text-gray-800 my-1"> عنوان سایت (نام برند یا شرکت یا فروشگاه) </label>
        <input type="text" name="title_site"
               class="border w-full border-gray-200 p-3 rounded-md text-center"
               placeholder="عنوان سایت">
    </div>
    <div class="mt-3 text-right">
        <label class="text-xs text-gray-800 my-1"> نام برند شما به انگلیسی (فقط حروف انگلیسی مجاز میباشد) </label>
        <input type="text" name="subdomain" dir="ltr"
               class="border w-full border-gray-200 p-3 rounded-md text-center"
               placeholder="اسم برند شما به انگلیسی">
    </div>
    <div class="mt-3">
        <button onclick="SiteInfo()"
                class="bg-green-500 flex text-center justify-center items-center gap-3 text-white rounded-md w-full p-3 btn-ajax">
            <i class="fa fa-spinner fa-spin hidden"></i>
            <span>شروع ساخت سایت</span>
        </button>
    </div>
</div>