<div class="modal-build fixed top-0 right-0 bottom-0 flex items-center left-0 p-5 bg-black bg-opacity-25 z-50"
     style="display: none">
    <div class="content w-full md:w-2/5 mx-auto p-5 rounded-md bg-white">
        <div class="box-modal">
            <div class="flex justify-between items-center">

                <p class="text-md text-right font-semibold"> قالب
                    <span class="modal-title"> فروشگاهی طلا و جواهر </span>
                </p>
                <div class="close">
                    <button onclick="CloseModal()" class="text-red-500 text-xl">
                        <i class="fa fa-times"></i>
                    </button>
                </div>

            </div>
            <div class="steps mt-5">
                <ul class="progressbar">
                    <li class="step-1 active text-xs">ایجاد حساب</li>
                    <li class="step-2 text-xs">اطلاعات</li>
                    <li class="step-3 text-xs">ساخت سایت</li>
                    <li class="step-4 text-xs">تحویل سایت</li>
                </ul>
            </div>
            <input type="hidden" class="modal_template_id" name="template_id" value="">
            <div class="content-modal my-3">
                <div>
                    <label class="text-xs text-gray-500"> شماره موبایل خود را کنید </label>
                    @if(Auth::check())
                        <input readonly value="{{Auth::user()->mobile}}"
                               class="w-full border p-3 border-gray-100 rounded-md text-center" name="mobile"
                               placeholder="09xxxxxxxxx" dir="ltr">
                    @else
                        <input class="w-full border p-3 border-gray-100 rounded-md text-center" name="mobile"
                               placeholder="09xxxxxxxxx" dir="ltr">
                    @endif

                    @if(Auth::check())
                        <button onclick="Level2()" type="button"
                                class="btn bg-green-500 text-white w-full mt-3 p-3 rounded-md"> مرحله
                            بعد
                        </button>
                    @else
                        <button onclick="RegisterMobile()" type="button"
                                class="btn bg-green-500 flex text-center justify-center items-center gap-3 text-white btn-ajax w-full mt-3 p-3 rounded-md">
                            <i class="fa fa-spinner fa-spin hidden"></i>

                            دریافت کد
                            تایید
                        </button>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
