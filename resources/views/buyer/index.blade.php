@extends('layouts.front')
@section('style')
@endsection
@section('body')

    <section class="max-w-6xl mx-auto pt-6 md:pt-5 px-5">
        <div class="md:col-span-8">
            <div class="header-products relative shadow-lg">
                <img src="{{asset('assets/img/zagrin7.jpg')}}" class="w-full hidden sm:block rounded-md"
                     alt="{{$category ? $category->title : ' خریداران زاندس ' }}">
                <div class="block sm:hidden bg-cover min-h-[200px]"
                     style="background-image: url('{{asset('assets/img/zagrin7.jpg')}}')"></div>
                <div class="absolute top-0 right-0 left-0 bottom-0 p-5 bg-black bg-opacity-25 rounded-lg min-h-[200px]">


                    <div class="">

                        <h3 class="text-xl font-semibold text-white"> {{$category ? $category->title : ' خریداران زاندس  '}} </h3>

                        <nav class="absolute bottom-5">
                            <ul class="text-xs text-gray-300 flex gap-3 breadcrumb">
                                <li class="hidden sm:block">
                                    <a href="{{url('/')}}">
                                        <i class="fal fa-home text-white"></i>
                                        <span class="text-white">خانه</span>
                                        <i class="fal fa-angle-left text-white"></i>
                                    </a>
                                </li>
                                <li class="hidden sm:block">
                                    <a href="{{route('buy-req')}}" class="text-white">
                                        خریداران
                                        @if($category)
                                            <i class="fal fa-angle-left text-white"></i>
                                        @endif
                                    </a>
                                </li>

                                @if($category && $category->parent && $category->parent->parent)
                                    <li>
                                        <a href="{{route('buy-req' , [$category->parent->parent->id])}}"
                                           class="text-white">
                                            {{$category->parent->parent->title}}
                                            <i class="fal fa-angle-left text-white"></i>
                                        </a>
                                    </li>
                                @endif

                                @if($category &&  $category->parent)
                                    <li>
                                        <a href="{{route('buy-req' , [$category->parent->id])}}"
                                           class="text-white">
                                            {{$category->parent->title}}
                                            <i class="fal fa-angle-left text-white"></i>
                                        </a>
                                    </li>
                                @endif

                                @if($category)
                                    <li>
                                        <a href="{{route('buy-req' , [$category->id])}}"
                                           class="text-white">
                                            {{$category->title}}
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="max-w-6xl mx-auto pt-6 md:pt-5 px-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-5">
            <div class="md:col-span-3">


                <div class="filter">
                    @if($category && count($category->children) > 0)
                        <div class="category-filter border border-gray-300  rounded-lg p-3">
                            <h3 class="border-b text-xs py-2 bg-custom-500 rounded-full text-center text-100  text-white">
                                دسته بندی </h3>
                            <p class="text-gray-800 font-semibold mt-3">
                                <i class="fas text-custom-900 mr-1 fa-box"></i>
                                <span class="mr-2">{{$category->title}}</span>
                            </p>
                            <ul class="mr-3 border-r-2 grid gap-3 pr-3 border-custom-400 mt-3 max-h-[350px] overflow-y-auto filter-box-items">
                                @foreach($category->children as $value)
                                    @if($value->status == 1)
                                        <li class="{{count($value->children) > 0 ? ' have-children-filter ' : ''}}">
                                            <a href="{{count($value->children) > 0 ? '#' : route('buy-req' , [$value->id])}}"
                                               class="text-sm flex justify-between"> {{$value->title}}
                                                <i class="fal fa-arrow-left text-gray-500"></i>
                                            </a>
                                            @if(count($value->children) > 0)

                                                <ul class="children-items my-3 border-r-2 border-red-500 pr-3 hidden">
                                                    @foreach($value->children as $val)
                                                        @if($val->status == 1)

                                                            <li class="my-2">
                                                                <a href="{{route('buy-req' , [$val->id])}}"
                                                                   class="text-sm flex justify-between hover:text-red-500 btn-child-category">
                                                                    {{$val->title}}
                                                                </a>
                                                            </li>
                                                        @endif

                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                    @else
                        <div class="category-filter border border-gray-300  rounded-lg p-3">
                            <h3 class="border-b text-xs py-2 bg-custom-500 rounded-full text-center text-100  text-white">
                                دسته بندی </h3>
                            <p class="text-gray-800 font-semibold mt-3">
                                <i class="fas text-custom-900 mr-1 fa-box"></i>
                                <span class="mr-2">محصولات</span>
                            </p>
                            <ul class="mr-3 border-r-2 grid gap-3 pr-3 border-custom-400 mt-3 max-h-[350px] overflow-y-auto filter-box-items">
                                @foreach($categories as $value)
                                    @if($value->status == 1)
                                        <li class="{{count($value->children) > 0 ? ' have-children-filter ' : ''}}">
                                            <a href="{{count($value->children) > 0 ? '#' : route('buy-req' , [$value->id])}}"
                                               class="text-sm flex justify-between"> {{$value->title}}
                                                <i class="fal fa-arrow-left text-gray-500"></i>
                                            </a>
                                            @if(count($value->children) > 0)

                                                <ul class="children-items my-3 border-r-2 border-red-500 pr-3 hidden">
                                                    @foreach($value->children as $val)
                                                        @if($val->status == 1)

                                                            <li class="my-2">
                                                                <a href="{{route('buy-req' , [$val->id])}}"
                                                                   class="text-sm flex justify-between hover:text-red-500 btn-child-category">
                                                                    {{$val->title}}
                                                                </a>
                                                            </li>
                                                        @endif

                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="md:col-span-9">

                <div class="search relative mb-4">
                    <input name="search"
                           class="border border-1 rounded-md w-full px-2 py-4 rounded-lg text-right pr-10 text-xs sm:text-sm bg-gray-100 search-buyers-list"
                           placeholder="محصولی را که به دنبال آن هستید جستجو کنید....">
                    <i class="fa fa-search absolute right-5 top-[17px] text-gray-400"></i>
                    <button class="bg-yellow-500 absolute text-white left-[10px] top-[12px] p-2 rounded-md text-xs flex justify-center gap-1"
                            type="button">
                        <i class="fa fa-spinner fa-spin text-white text-xs loading-data-spin hidden"></i>
                        جستجو کنید
                    </button>
                </div>


                @if($category && count($category->children) > 0)
                    <div class="categories mb-3">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach($category->children as $value)
                                @if($value->status == 1)
                                    <div class="category border border-gray-300 rounded-md p-2">
                                        <a href="{{ route('buy-req' , [$value->id]) }}">
                                            @if($value->photo)
                                                <img src="{{url($value->photo)}}" class="w-full mb-2" alt="">
                                            @endif
                                            <p class="text-sm text-gray-700  text-center"> {{$value->title}} </p>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="content-products">
                    <div class="grid grid-cols-1 gap-3 infinite-scroll">
                        @if(count($requests) > 0)
                            @include('components.buyer.list' , ['requests' => $requests])
                        @else
                            <p> درخواستی هنوز ثبت نشده است </p>
                        @endif
                    </div>
                    <p class="text-center text-sm text-gray-500 my-3 hidden load-product"> در حال دریافت اطلاعات... </p>
                </div>
            </div>

        </div>
    </section>
    @include('components.chat.box')

    @include('components.modal.phone')
@endsection
@section('js')
    <script defer src="{{asset('assets/js/products.js?ver=1.6')}}"></script>
    <script src="{{asset('assets/portal/js/request_list.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/portal/js/phone.js')}}" type="text/javascript"></script>
    <script>

        let current_page = 1;
        let page = {{$lastPage}};
        $(document).ready(function () {

            var csrf = $('meta[name=csrf]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf
                }
            });

            var currentUrl = window.location.href;
            var url = new URL(currentUrl);


            var loadData = false;

            $(window).on("scroll", function () {
                var scrollHeight = $('.content-products').height();
                var scrollPosition = $(window).scrollTop();

                var content2 = scrollHeight - scrollPosition;

                if (content2 <= 0 && !loadData && current_page <= parseInt(page)) {

                    current_page = current_page + 1;

                    if (current_page)

                        url.searchParams.set("page", current_page); // setting your param
                    var newUrl = url.href;

                    loadData = true;
                    $('.load-product').removeClass('hidden');

                    $.ajax({
                        url: newUrl,
                        type: "post",
                        data: {
                            lazy: true
                        },
                        success: (response => {
                            loadData = false;
                            $('.infinite-scroll').append(response.view)
                            $('.load-product').addClass('hidden');
                        }),
                    });

                }

            });


        });
    </script>

@endsection

