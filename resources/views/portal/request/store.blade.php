@extends('layouts.portal')
@section('navbar')

@endsection
@section('css')
@endsection
@section('body')

    <section class="content my-5">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="sm:col-span-2 step-level bg-white p-3 rounded-lg shadow-sm">
                <p class="text-md">
                    <i class="fa fa-paperclip"></i>
                    درخواست خرید محصول
                </p>
                <div class="grid grid-cols-1 md:grid-cols-6 gap-5 mt-5">
                    <div class="md:col-span-2">
                        <div class="steps-store-product">
                            <ul class="gap-5 justify-start bg-gray-100 rounded-md p-2">
                                <li id="cat-step-li-1"
                                    class="item-cat-model bg-custom-900 w-full text-center rounded-md">
                                    <span class="text-xs text-white"> دسته بندی محصول </span>
                                </li>
                                <li id="cat-step-li-2"
                                    class="item-cat-model bg-gray-200 w-full text-center rounded-md mt-2">
                                    <span class="text-xs text-gray-800"> اطلاعات درخواست </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:col-span-4">
                        <div class="bg-gray-100 rounded-md p-2">

                            <div id="cat-step-1" class="cat-step-1 levels">
                                {{--                                <div class="search relative">--}}
                                {{--                                    <input class="w-full rounded-md px-3 text-xs sm:text-xs py-3"--}}
                                {{--                                           placeholder="جستجو کنید ( مثلا : برنج ) ">--}}
                                {{--                                    <i class="fal fa-search text-gray-300 absolute left-2 top-3"></i>--}}
                                {{--                                </div>--}}
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
                                        <input readonly class="w-full bg-transparent text-xs sm:text-md" id="category">
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
                                            <label> نوع <strong class="text-custom-900 category-name"> </strong>
                                                را بنویسید<span class="text-custom-900"> * </span>

                                            </label>
                                            <input class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm placeholder-value"
                                                   name="type" placeholder=""/>
                                        </div>

                                        <div class="md:col-span-2">
                                            <label>
                                                مقدار مورد نیاز
                                                <strong class="text-custom-900 unit-text"></strong>
                                                <span class="text-custom-900"> * </span>

                                            </label>
                                            <input type="number"
                                                   class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm inventory-input"
                                                   name="inventory" placeholder=""/>
                                        </div>


                                    </div>

                                    <div class="next-step-5 max-w-[800px] mx-auto flex items-center justify-between mt-5 ltr"
                                         dir="ltr">
                                        <button disabled
                                                class="btn-level-2 bg-custom-900 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2"
                                                onclick="storeData()">
                                            <i class="fal fa-arrow-left text-white"></i>
                                            تایید نهایی

                                            <span class="hidden sm:block text-white"> و ثبت درخواست</span>
                                        </button>
                                        <button
                                                class="prev-level bg-blue-500 px-4 rounded-md py-2 text-white text-sm flex items-center gap-2"
                                                data-to="#cat-step-1" data-step="4">
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
            <div class="sm:col-span-1 step-level bg-white p-3 rounded-lg shadow-sm">
                <p class="text-md">
                    <i class="fa fa-pager"></i>
                    لیست درخواست ها
                </p>

                <div class="grid grid-cols-1 gap-3 mt-5">
                    @if(count($requests) > 0)
                        @foreach($requests as $value)
                            <div class="item bg-gray-50 shadow-sm p-5 rounded-md">
                                <p class="text-sm">
                                    درخواست خرید :
                                    <strong class="text-blue-500">{{$value->category->title}}</strong>
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-1 items-center">
                                    <p class="text-sm mt-2">
                                        از نوع :
                                        <strong class="text-blue-500">{{$value->type}}</strong>
                                        به مقدار :
                                        <strong class="text-blue-500">{{number_format($value->inventory)}}</strong>
                                        <span class="text-xs">{{$value->category->unit}}</span>
                                    </p>
                                    <p class="text-xs mt-2">
                                        @if($value->status == 'confirm')
                                            <i class="fa fa-check text-green-500"></i>
                                            <strong class="text-green-500">تایید شده</strong>
                                        @elseif($value->status == 'waiting')
                                            <i class="fa fa-watch text-yellow-500"></i>
                                            <strong class="text-yellow-500">در انتظار تایید</strong>
                                        @elseif($value->status == 'reject')
                                            <i class="fa fa-ban text-red-500"></i>
                                            <strong class="text-red-500">رد شده</strong>
                                        @endif
                                        توسط واحد پشتیبانی
                                    </p>
                                </div>
                                <p class="text-left">
                                    <button onclick="$(this).parent().find('small').toggleClass('hidden')"
                                            class="text-red-500 text-xs rounded-sm">
                                        حذف درخواست
                                    </button>
                                    <small class="text-xs hidden">

                                        <a href="{{route('portal.request.delete' , $value->id)}}"
                                           class="text-green-500 font-bold">
                                            تایید کنید
                                        </a>
                                        تا درخواست شما حذف شود
                                    </small>

                                    <button class="text-blue-500 text-xs rounded-sm mr-2"
                                            onclick="$(this).parent().parent().find('.edit-box').toggleClass('hidden')">
                                        ویرایش
                                    </button>
                                </p>

                                <div class="edit-box gap-3 grid grid-cols-1 hidden">
                                    <form action="{{route('portal.request.update' , $value->id)}}" method="post">
                                        @csrf
                                        <div class="grid grid-cols-1 gap-1">
                                            <label class="text-sm text-gray-700">نوح محصول</label>
                                            <input class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm" type="text"
                                                   value="{{$value->type}}"
                                                   name="type" placeholder=""/>
                                        </div>
                                        <div class="grid grid-cols-1 gap-1 mt-3">
                                            <label class="text-sm text-gray-700">مقدار مورد نیاز
                                                ({{$value->category ? $value->category->unit : ''}})
                                            </label>
                                            <input class="w-full px-2 py-3 bg-white rounded-md mt-3 text-sm"
                                                   value="{{$value->inventory}}"
                                                   type="number"
                                                   name="inventory" placeholder=""/>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <button class="bg-blue-500 rounded-md text-white text-xs py-3"> ویرایش
                                                درخواست
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                @endforeach
                                @else
                                    <div class="text-center">
                                        <img class="mx-auto" src="{{asset('assets/portal/img/in_process_buyad.svg')}}">
                                        <p class="text-xs text-gray-500"> شما هنوز درخواستی ثبت نکرده اید </p>
                                    </div>
                                @endif
                            </div>

                </div>
            </div>
    </section>

@endsection
@section('js')
    <script src="{{asset('assets/portal/js/request.js')}}" type="text/javascript"></script>
@endsection
