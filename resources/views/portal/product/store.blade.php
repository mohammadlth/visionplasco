@extends('layouts.portal')
@section('navbar')

@endsection
@section('css')
    <link href="{{asset('assets/portal/plugins/upload/upload.css')}}" rel="stylesheet">
@endsection
@section('body')

    <section class="content my-5">
        <div class="step-level bg-white p-3 rounded-lg shadow-sm">
            <p class="text-md">
                <i class="fa fa-paperclip"></i>
                ثبت محصول
            </p>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-5 mt-5">
                <div class="md:col-span-1">
                    <div class="steps-store-product">
                        <ul class="gap-2 justify-start bg-gray-100 rounded-md p-2 grid grid-cols-2 sm:grid-cols-1">
                            <li id="cat-step-li-1"
                                class="item-cat-model bg-custom-900 w-full text-center rounded-md">
                                <span class="text-xs text-white"> دسته بندی محصول </span>
                            </li>
                            <li id="cat-step-li-2"
                                class="item-cat-model bg-gray-200 w-full text-center rounded-md">
                                <span class="text-xs text-gray-800"> اطلاعات محصول </span>
                            </li>
                            <li id="cat-step-li-3"
                                class="item-cat-model bg-gray-200 w-full text-center rounded-md">
                                <span class="text-xs text-gray-800"> موجودی و قیمت </span>
                            </li>
                            <li id="cat-step-li-4"
                                class="item-cat-model bg-gray-200 w-full text-center rounded-md">
                                <span class="text-xs text-gray-800"> تصویر محصول </span>
                            </li>
                            <li id="cat-step-li-5"
                                class="item-cat-model bg-gray-200 w-full text-center rounded-md">
                                <span class="text-xs text-gray-800"> توضیحات تکمیلی </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="md:col-span-4">
                    <div class="bg-gray-100 rounded-md p-2">

                        <div id="cat-step-1" class="cat-step-1 levels">
                            <div class="search relative">
                                <input class="w-full px-3 text-xs py-3 search-box"
                                       placeholder="جستجو کنید ( مثلا : برنج ) ">
                                <i class="fal fa-search text-gray-300 absolute left-2 top-3"></i>
                                <div class="dropdown-menu hidden">
                                    <ul class="drop-down-list bg-white max-h-[350px] absolute overflow-auto left-0 right-0 p-5"
                                        style="z-index: 99">
                                        <li>
                                            <p class="text-sm text-gray-500">چیزی پیدا نشد</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="content px-1 sm:px-5">
                                <div class="category-select">
                                    <div class="items-content">

                                        <div class="category-content mt-3">

                                            <ul id="list-cat-0" class="steps px-2 grid gap-2 mt-3 list-category">
                                                @foreach($categories as $value)
                                                    <li id="cat-{{$value->id}}"
                                                        class="cursor-pointer">
                                                        <div class="flex justify-between items-center"
                                                             onclick="setCatValue({{$value->id}} , {{$value->id}} , '{{$value->title}}' , 0  , {{ count($value->children) > 0 ?"'#list-cat-$value->id'" : 0}})">
                                                            <span class=""> {{$value->title}} </span>
                                                            <i class="fal fa-arrow-left text-gray-500"></i>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            @foreach($categories as $value)
                                                @if(count($value->children) > 0)
                                                    @include('components.product.category' , ['item' => $value , 'prev' => '#list-cat-0'])
                                                @endif
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="cat mt-2 bg-gray-50 rounded-md p-3 relative flex">
                                    <input readonly class="w-full bg-transparent am:text-md text-xs" id="category" value="">
                                    <button
                                            class="border-red-500 border-2 text-white rounded-sm clear-category flex items-center justify-center"
                                            type="button">
                                        <i class="fa fa-times text-red-500 px-3"></i>
                                    </button>
                                </div>
                                <div class="next-step-1 flex items-center mt-3 ltr hidden" dir="ltr">
                                    <button
                                            class="add-level btn-level-1 bg-custom-900 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2"
                                            data-to="#cat-step-2" data-step="2">
                                        <i class="fal fa-arrow-left text-white"></i>
                                        مرحله بعد
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="cat-step-2" class="cat-step-2 levels hidden">
                            <div class="content max-w-[500px] mx-auto p-5">
                                <div class="items-content grid grid-cols-1 md:grid-cols-2 gap-5">

                                    <div class="md:col-span-2">
                                        <label>
                                            نوع
                                            <strong class="text-custom-900 category-name"></strong>
                                            را بنویسید
                                            <span class="text-custom-900"> * </span>

                                        </label>
                                        <input class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm"
                                               name="type" placeholder=""/>
                                    </div>

                                    <div class="md:col-span-1">
                                        <label> استان مبدا </label>
                                        <select class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm" name="region">
                                            <option value="">استان مبدا را انتخاب کنید</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-1">
                                        <label> شهر مبدا </label>
                                        <select class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm" name="city">
                                        </select>
                                    </div>
                                </div>
                                <div class="next-step-2 max-w-[500px] mx-auto flex items-center justify-between mt-5 ltr"
                                     dir="ltr">
                                    <button disabled
                                            class="add-level btn-level-2 bg-custom-900 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2"
                                            data-to="#cat-step-3" data-step="3">
                                        <i class="fal fa-arrow-left text-white"></i>
                                        مرحله بعد

                                    </button>
                                    <button
                                            class="prev-level bg-blue-500 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2"
                                            data-to="#cat-step-1" data-step="1">
                                        بازگشت
                                        <i class="fal fa-arrow-right text-white"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                        <div id="cat-step-3" class="cat-step-3 levels hidden">
                            <div class="content max-w-[500px] mx-auto p-5">
                                <div class="items-content grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="md:col-span-2 relative">
                                        <label> میزان موجودی (کیلوگرم)
                                            <span class="text-custom-900"> * </span>
                                        </label>
                                        <input class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm"
                                               type="number" name="inventory" placeholder="مثلا : 50"/>
                                        <span
                                                class="absolute border-r bottom-[13px] left-2 border-gray-400 text-gray-400 text-xs px-2 unit-text"></span>
                                    </div>
                                    <div class="md:col-span-2 relative">
                                        <label> حداقل میزان فروش (کیلوگرم)
                                            <span class="text-custom-900"> * </span>
                                        </label>
                                        <input class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm"
                                               type="number" name="min_inventory" placeholder="مثلا : 5"/>
                                        <span
                                                class="absolute border-r bottom-[13px] left-2 border-gray-400 text-gray-400 text-xs px-2 unit-text"></span>

                                    </div>
                                    <div class="md:col-span-2 relative">
                                        <label> حداقل قیمت فروش (تومان)
                                            <span class="text-custom-900"> * </span>
                                        </label>
                                        <input class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm"
                                               type="number" name="min_price" placeholder="مثلا : 500000"/>
                                        <span
                                                class="absolute border-r bottom-[13px] left-2 border-gray-400 text-gray-400 text-xs px-2">
                                                    هر
                                        <span class="unit-text text-gray-400"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="next-step-3 max-w-[500px] mx-auto flex items-center justify-between mt-5 ltr"
                                     dir="ltr">
                                    <button disabled
                                            class="add-level btn-level-3 bg-custom-900 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2 "
                                            data-to="#cat-step-4" data-step="4">
                                        <i class="fal fa-arrow-left text-white"></i>
                                        مرحله بعد

                                    </button>
                                    <button
                                            class="prev-level bg-blue-500 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2"
                                            data-to="#cat-step-2" data-step="2">
                                        بازگشت
                                        <i class="fal fa-arrow-right text-white"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                        <div id="cat-step-4" class="cat-step-4 levels hidden">
                            <div class="content max-w-[800px] mx-auto p-5">
                                <div class="items-content grid grid-cols-1 md:grid-cols-2 gap-7 items-center justify-center">
                                    <div class="file upload">
                                        <div id="uploadFile"></div>
                                    </div>
                                    <div class="role">
                                        <ul class="text-xs list-dot">
                                            <li style="list-style-type: decimal">
                                                فقط تصاویر مرتبط با محصول را بارگذاری کنید.
                                            </li>
                                            <li style="list-style-type: decimal">
                                                از درج شماره تماس یا لوگو بر روی تصاویر خودداری کنید.

                                            </li>
                                            <li style="list-style-type: decimal">
                                                حداکثر مجاز به انتخاب 4 تصویر هستید.

                                            </li>
                                            <li style="list-style-type: decimal">
                                                حجم هر تصویر باید کمتر از 5 مگابایت باشد.
                                            </li>
                                            <li style="list-style-type: decimal">
                                                تصویر از نوع jpeg یا jpg باشد .

                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="next-step-4 max-w-[800px] mx-auto flex items-center justify-between mt-5 ltr"
                                     dir="ltr">
                                    <button
                                            class="add-level btn-level-4 bg-custom-900 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2"
                                            data-to="#cat-step-5" data-step="5" disabled>
                                        <i class="fal fa-arrow-left text-white"></i>
                                        مرحله بعد

                                    </button>
                                    <button
                                            class="prev-level bg-blue-500 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2"
                                            data-to="#cat-step-3" data-step="3">
                                        بازگشت
                                        <i class="fal fa-arrow-right text-white"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                        <div id="cat-step-5" class="cat-step-5 levels hidden">
                            <div class="content max-w-[800px] mx-auto p-5">
                                <div class="items-content grid grid-cols-1 md:grid-cols-2 gap-7 items-center">

                                    <div class="md:col-span-2 relative">
                                        <label>توضیحات تکمیلی
                                            <span class="text-custom-900"> * </span>
                                        </label>
                                        <textarea class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm"
                                                  name="description" rows="10"
                                                  placeholder="توضیحات تکمیلی در مورد محصول"></textarea>

                                    </div>

                                </div>

                                <div class="next-step-5 max-w-[800px] mx-auto flex items-center justify-between mt-5 ltr"
                                     dir="ltr">
                                    <button disabled
                                            class="btn-level-5 bg-custom-900 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2"
                                            onclick="storeData()">
                                        <i class="fal fa-arrow-left text-white"></i>
                                        تایید نهایی و ثبت اطلاعات

                                    </button>
                                    <button
                                            class="prev-level bg-blue-500 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2"
                                            data-to="#cat-step-4" data-step="4">
                                        بازگشت
                                        <i class="fal fa-arrow-right text-white"></i>
                                    </button>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
@section('js')
    <script src="{{asset('assets/portal/js/product.js?ver=1.1')}}" type="text/javascript"></script>
    <script src="{{asset('assets/portal/plugins/upload/index.min.js')}}" type="text/javascript"></script>
@endsection
