@extends('layouts.front')
@section('style')
@endsection
@section('body')

    <section class="max-w-6xl mx-auto pt-6 md:pt-5 px-5">
        <div class="md:col-span-8">
            <div class="header-products relative shadow-lg">
                @if($category->sub)
                    <img src="{{url($category->sub)}}" class="hidden sm:block w-full rounded-md"
                         alt="{{$category->title}}">
                    <div class="block sm:hidden bg-cover min-h-[200px]"
                         style="background-image: url('{{url($category->sub)}}')"></div>
                @else
                    <img src="{{asset('assets/img/zagrin7.jpg')}}" class="w-full hidden sm:block rounded-md"
                         alt="{{$category->title}}">
                    <div class="block sm:hidden bg-cover min-h-[200px]"
                         style="background-image: url('{{asset('assets/img/zagrin7.jpg')}}')"></div>
                @endif
                <div class="absolute top-0 right-0 left-0 bottom-0 p-5 bg-black bg-opacity-25 rounded-lg min-h-[200px]">

                    <div class="">

                        <p class="text-xl font-semibold text-white"> {{$category->title}} </p>

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
                                    <a href="#" class="text-white">
                                        محصولات
                                        <i class="fal fa-angle-left text-white"></i>
                                    </a>
                                </li>
                                @if($category->parent && $category->parent->parent)
                                    <li>
                                        <a href="{{route('product.category' , [$category->parent->parent->id , $category->parent->parent->slug])}}"
                                           class="text-white">
                                            {{$category->parent->parent->title}}
                                            <i class="fal fa-angle-left text-white"></i>
                                        </a>
                                    </li>
                                @endif
                                @if($category->parent)
                                    <li>
                                        <a href="{{route('product.category' , [$category->parent->id , $category->parent->slug])}}"
                                           class="text-white">
                                            {{$category->parent->title}}
                                            <i class="fal fa-angle-left text-white"></i>
                                        </a>
                                    </li>
                                @endif
                                @if($category)
                                    <li>
                                        <a href="{{route('product.category' , [$category->id , $category->slug])}}"
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
                    @if(count($category->children) > 0)
                        <div class="category-filter border border-gray-300  rounded-lg p-3">
                            <p class="border-b text-xs py-2 bg-custom-500 rounded-full text-center text-100  text-white">
                                دسته بندی </p>
                            <p class="text-gray-800 font-semibold mt-3">
                                <i class="fas text-custom-900 mr-1 fa-box"></i>
                                <span class="mr-2">{{$category->title}}</span>
                            </p>
                            <ul class="mr-3 border-r-2 grid gap-3 pr-3 border-custom-400 mt-3 max-h-[350px] overflow-y-auto filter-box-items">
                                @foreach($category->children as $value)
                                    @if($value->status == 1)
                                        <li class="{{count($value->children) > 0 ? ' have-children-filter ' : ''}}">
                                            <a href="{{count($value->children) > 0 ? '#' : route('product.category' , [$value->id , $value->slug])}}"
                                               class="text-sm flex justify-between"> {{$value->title}}
                                                <i class="fal fa-arrow-left text-gray-500"></i>
                                            </a>
                                            @if(count($value->children) > 0)

                                                <ul class="children-items my-3 border-r-2 border-red-500 pr-3 hidden">
                                                    @foreach($value->children as $val)
                                                        @if($val->status == 1)

                                                            <li class="my-2">
                                                                {{--                                                                <button type="button"--}}
                                                                {{--                                                                        onclick="category_load({{$val->id}})"--}}
                                                                {{--                                                                        class="text-sm flex justify-between hover:text-red-500 btn-child-category">--}}
                                                                {{--                                                                    {{$val->title}}--}}
                                                                {{--                                                                </button>--}}
                                                                <a href="{{route('product.category' , [$val->id , $val->slug])}}"
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
                            <p class="border-b text-xs py-2 bg-custom-500 rounded-full text-center text-100  text-white">
                                دسته بندی </p>
                            <p class="text-gray-800 font-semibold mt-3">
                                <i class="fas text-custom-900 mr-1 fa-box"></i>
                                <span class="mr-2">محصولات</span>
                            </p>
                            <ul class="mr-3 border-r-2 grid gap-3 pr-3 border-custom-400 mt-3 max-h-[350px] overflow-y-auto filter-box-items">
                                @foreach($categories as $value)
                                    @if($value->status == 1)
                                        <li class="{{count($value->children) > 0 ? ' have-children-filter ' : ''}}">
                                            <a href="{{count($value->children) > 0 ? '#' : route('product.category' , [$value->id , $value->slug])}}"
                                               class="text-sm flex justify-between"> {{$value->title}}
                                                <i class="fal fa-arrow-left text-gray-500"></i>
                                            </a>
                                            @if(count($value->children) > 0)

                                                <ul class="children-items my-3 border-r-2 border-red-500 pr-3 hidden">
                                                    @foreach($value->children as $val)
                                                        @if($val->status == 1)

                                                            <li class="my-2">
                                                                <a href="{{route('product.category' , [$val->id , $val->slug])}}"
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

                    <div class="category-filter border border-gray-300 rounded-lg p-3 mt-3">
                        <p class="border-b text-xs py-2 bg-custom-500 rounded-full text-center text-100  text-white">
                            موقعیت جغرافیایی
                        </p>
                        <div class="form-group mt-3">
                            <div class="form-control">
                                <label class="text-xs">
                                    <i class="fal fa-map ml-1"></i>
                                    انتخاب استان </label>
                                <select class="w-full text-sm border rounded-md px-3 py-2 bg-gray-50" name="region">
                                    <option value=""> انتخاب استان</option>
                                </select>
                            </div>
                            <div class="form-control mt-2">
                                <label class="text-xs">
                                    <i class="fal fa-map ml-1"></i>
                                    انتخاب شهر </label>
                                <select class="w-full border text-sm rounded-md px-3 py-2 bg-gray-50" name="city">
                                    <option value=""> انتخاب استان</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-9">

                @if(count($category->children) > 0)
                    <div class="categories mb-3">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach($category->children as $value)
                                @if($value->status == 1)
                                    <div class="category border border-gray-300 rounded-md p-2">
                                        <a href="{{ route('product.category' , [$value->id , $value->slug]) }}">
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

                <div class="filter-change border border-gray-300 rounded-lg p-2">
                    <ul class="flex items-center gap-3">
                        <li>
                            <p class="text-xs">
                                <i class="fal ml-1 fa-sort-amount-asc"></i>
                                ترتیب نمایش :
                            </p>
                        </li>
                        <li>
                            <button onclick="sortSet('default' , $(this))"
                                    class="text-xs filter-view {{!isset($params['sort']) ? ' text-custom-900 ' : ''}}">
                                مرتبط ترین
                            </button>
                        </li>
                        <li>
                            <button onclick="sortSet('new', $(this))"
                                    class="text-xs filter-view {{isset($params['sort']) && $params['sort'] == 'new' ? ' text-custom-900 ' : ''}}">
                                جدیدترین
                            </button>
                        </li>

                    </ul>
                </div>
                <div class="content-products">
                    @include('components.product.list' , ['products' => $products , 'banners' => $banners , 'similar' => $similar])

                    <p class="text-center text-sm text-gray-500 my-3 hidden load-product"> در حال دریافت اطلاعات... </p>
                </div>
            </div>

            @if(!is_null($category->text) && $category->text  != '')
                <div class="md:col-span-12">
                    <div class="text-box border-2 border-dashed border-gray-300 p-3 max-h-[250px] overflow-auto">
                        {!! $category->text !!}
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
@section('js')
    <script defer src="{{asset('assets/js/products.js?ver=1.6')}}"></script>
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

