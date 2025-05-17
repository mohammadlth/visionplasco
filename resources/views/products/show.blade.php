@extends('layouts.front')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/swiper.css')}}">
@endsection

@section('meta')
    <title>{{$product->full_name}} | زاندس </title>
    <meta name="description"
          content="خرید محصول {{$product->full_name}}   در سایت زاندس از فروشنده {{$product->user ? $product->user->name : ''}} "/>
    <link rel="canonical" href="{{route('product.show' , [$product->id , $product->slug])}}"/>
    <meta property="og:locale" content="fa_IR"/>
    <meta property="og:type" content="product"/>
    <meta property="og:title"
          content="{{$product->full_name}} | زاندس "/>
    <meta property="og:description"
          content="خرید محصول {{$product->full_name}}   در سایت زاندس از فروشنده {{$product->user ? $product->user->name : ''}} "/>
    <meta property="og:url" content="{{route('product.show' , [$product->id , $product->slug])}}"/>
@endsection
@section('body')

    <nav class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">
        <ul class="text-xs text-gray-300 flex gap-3 breadcrumb">
            <li>
                <a href="#">
                    <i class="fal fa-home"></i>
                    <span>خانه</span>
                    <i class="fal fa-angle-left"></i>
                </a>
            </li>
            <li>
                <a href="#">
                    محصولات
                    <i class="fal fa-angle-left"></i>
                </a>
            </li>

            @if($product->category && $product->category->parent && $product->category->parent->parent && $product->category->parent->parent->parent)
                <li>
                    <a href="{{ route('product.category' , [$product->category->parent->parent->parent->id , $product->category->parent->parent->parent->slug]) }}">
                        {{$product->category->parent->parent->parent->title}}
                        <i class="fal fa-angle-left"></i>
                    </a>
                </li>
            @endif

            @if($product->category && $product->category->parent && $product->category->parent->parent)
                <li>
                    <a href="{{ route('product.category' , [$product->category->parent->parent->id , $product->category->parent->parent->slug]) }}">
                        {{$product->category->parent->parent->title}}
                        <i class="fal fa-angle-left"></i>
                    </a>
                </li>
            @endif

            @if($product->category && $product->category->parent)
                <li>
                    <a href="{{ route('product.category' , [$product->category->parent->id , $product->category->parent->slug]) }}">
                        {{$product->category->parent->title}}
                        <i class="fal fa-angle-left"></i>
                    </a>
                </li>
            @endif

            @if($product->category)
                <li>
                    <a href="{{ route('product.category' , [$product->category->id , $product->category->slug]) }}">
                        {{$product->category->title}}
                        <i class="fal fa-angle-left"></i>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{route('product.show' , [$product->id , $product->slug])}}">
                    {{$product->full_name}}
                </a>
            </li>
        </ul>
    </nav>
    <section class="max-w-6xl mx-auto pt-6 md:pt-5 px-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-10">
            <div class="md:col-span-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 md:gap-10">
                    <div class="col-span-1">
                        <div class="swiper-product-single overflow-hidden">
                            <div class="swiper-wrapper">
                                @if(count($product->photos) > 0)
                                    @foreach($product->photos as $value)
                                        <div class="swiper-slide">
                                            <div class="card-product-single w-auto rounded-xl ">
                                                <div class="w-full rounded-md product-img"
                                                     style="background-image: url('{{url($value->path)}}');height: 350px;">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide">
                                        <div class="card-product-single w-auto rounded-xl ">
                                            <div class="w-full rounded-md product-img border-2"
                                                 style="background-image: url('{{url('assets/img/no-image.png')}}');height: 350px;background-size: auto;background-color: #f1f1f1">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>

                    <div class="col-span-1">
                        <h1 class="text-2xl"> {{$product->full_name}} </h1>
                        <div class="detail">
                            <ul class="grid gap-3 my-5">
                                <li class="flex justify-between items-center">
                                    <p>
                                        <i class="fal fa-user ml-2"> </i>
                                        <span class="text-gray-600 text-sm">نام فروشنده : </span>
                                    </p>
                                    <p class="text-sm">
                                        {{$product->user ? $product->user->name : ''}}
                                    </p>
                                </li>
                                <li class="flex justify-between items-center">
                                    <p>
                                        <i class="fal fa-map-pin ml-2"> </i>
                                        <span class="text-gray-600 text-sm"> آدرس : </span>
                                    </p>
                                    <p class="text-sm">
                                        {{$product->region ? $product->region->name : ''}}
                                        - {{$product->city ? $product->city->name : ''}}

                                    </p>
                                </li>

                                <li class="flex justify-between items-center">
                                    <p>
                                        <i class="fal fa-box ml-2"> </i>
                                        <span class="text-gray-600 text-sm"> میزان موجودی : </span>
                                    </p>
                                    @if($product->category)
                                        <p class="text-sm">
                                            {{unit_calculate($product->inventory , $product->category->unit)}}
                                        </p>
                                    @endif
                                </li>
                                <li class="flex justify-between items-center">
                                    <p>
                                        <i class="fal fa-inbox ml-2"> </i>
                                        <span class="text-gray-600 text-sm"> حداقل سفارش : </span>
                                    </p>
                                    @if($product->category)
                                        <p class="text-sm">
                                            {{unit_calculate($product->min_inventory , $product->category->unit)}}
                                        </p>
                                    @endif

                                </li>
                            </ul>
                        </div>
                        <div class="contact">
                            @if($product->min_price <= 0)
                                <button class="btn bg-custom-900 text-center flex items-center justify-center  w-full py-3 px-3 rounded-md shadow-lg text-white">
                                    <i class="fas fa-tag w-8 h-8 bg-white rounded-md text-custom-900 items-center flex justify-center ml-2"></i>
                                    تعیین نشده
                                </button>
                            @else
                                <button class="btn bg-custom-900 text-center flex items-center justify-center  w-full py-3 px-3 rounded-md shadow-lg text-white">
                                    <i class="fas fa-tag w-8 h-8 bg-white rounded-md text-custom-900 items-center flex justify-center ml-2"></i>
                                    {{number_format($product->min_price)}}
                                    تومان
                                    <span class="text-xs text-white mx-1">
                                        (هر {{$product->category->unit}} )
                                    </span>
                                </button>
                            @endif
                            @if(!Auth::check())
                                <div class="item mt-3 flex gap-3">
                                    <a href="{{route('login')}}"
                                       class="btn bg-blue-900 text-center flex items-center justify-center  w-full py-3 px-3 rounded-md shadow-lg text-white">
                                        <i class="fas fa-user w-8 h-8 bg-white rounded-md text-blue-900 items-center flex justify-center ml-2"></i>
                                        استعلام قیمت
                                    </a>
                                </div>
                            @else
                                <div class="item mt-3 flex gap-3">
                                    <button class="btn bg-blue-900 w-full text-center gap-3 rounded-md text-white text-xs px-3 py-4 btn-chat"
                                            onclick="selectUser({{$product->user->id}} , '{{$product->user->name}}' , {{$product->id}})">
                                        <i class="fa fa-comments text-white default mx-1"></i>
                                        <span class="default text-white">گفتگو با فروشنده</span>
                                        <i class="fa fa-spinner fa-spin text-white load hidden"></i>
                                    </button>
                                    @if($product->user->info->show_phone_number)
                                        <button class="btn bg-green-600 w-full text-center gap-2 rounded-md text-white text-xs px-3 py-4 btn-call"
                                                onclick="showPhone({{$product->user->id}} , '{{$product->user->name}}'  , {{$product->id}})">
                                            <i class="fa fa-phone text-white default mx-1"></i>
                                            <span class="default text-white">تماس با فروشنده</span>
                                            <i class="fa fa-spinner fa-spin text-white load hidden"></i>
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-700 border-dashed font-bold">
                            <i class="fal fa-file-text"></i>
                            توضیحات محصول
                        </p>
                        <div class="text mt-3">

                            <p class="text-sm leading-8 text-gray-800 text-justify">
                                {{$product->description}}
                            </p>

                        </div>
                    </div>

                    <div class="shadow-lg rounded-lg p-4 block sm:hidden">
                        <div class="user-info flex gap-3 items-center">
                            @if($product->user && $product->user->info && is_null($product->user->info->profile_pic))
                                <i class="fal fa-user-circle rounded-full text-2xl bg-custom-400 w-12 h-12 flex ring-custom-100 text-white ring-4 justify-center items-center"></i>
                            @else
                                <img src="{{url($product->user->info->profile_pic)}}"
                                     class="h-12 w-12 rounded-full ring-4 ring-green-300">
                            @endif
                            <p>
                                <span class="text-sm"> {{$product->user ? $product->user->name : ''}}</span>
                                <br/>
                                @if($product->user && $product->user->vip_account)
                                    <span class=" bg-yellow-300 text-white rounded-full px-2 py-1"
                                          style="font-size: 10px;">
                                    <i class="fas text-white fa-medal"></i>
                                    فروشنده برتر
                                </span>
                                @endif
                                @if($product->user && $product->user->confirm_identity)
                                    <span class=" bg-green-500 text-white rounded-full px-2 py-1 mr-2"
                                          style="font-size: 10px;">
                                    <i class="fas text-white fa-shield-halved"></i>
                                    احراز شده

                                </span>
                                @else
                                    <span class=" bg-red-500 text-white rounded-full px-2 py-1 mr-2"
                                          style="font-size: 10px;">
                                    <i class="fas text-white fa-shield-halved"></i>
                                    احراز نشده
                                </span>
                                @endif
                            </p>
                        </div>
                        <div class="description mt-5">
                            @if($product->user && $product->user->info)
                                <p class="text-sm"> توضیحات فروشنده </p>
                                <p class="text-xs text-gray-500 mt-3 leading-6 text-justify">
                                    {{$product->user->info->description}}
                                </p>
                            @endif
                        </div>
                        <div class="mt-5">
                            <a href="{{route('profile.show' , $product->user->id)}}" target="_blank"
                               class="text-xs block text-center w-full py-3 font-semibold px-4 text-custom-900 bg-white rounded-md">
                                مشاهده پروفایل کاربری
                                <i class="fa fa-angle-left text-custom-900 mr-2"></i>
                            </a>
                        </div>
                    </div>

                    <div class="shadow-sm bg-blue-100 rounded-lg p-4 mt-5 block sm:hidden">
                        <a href=""
                           class="text-blue-500 font-semibold justify-between flex items-center justify-center text-sm">
                            <span class="text-blue-500 flex items-center gap-2">
                                <i class="text-blue-500 fas fa-warning text-md"></i>
                                خرید امن
                            </span>

                            <i class="text-blue-500 fal fa-angle-left text-2xl"></i>
                        </a>
                        <p class="text-xs my-5 text-gray-900">
                            زاندس هیج گونه مسئولیت و منفعتی در قبال معاملات شما ندارد.
                        </p>
                        <p class="text-xs  text-gray-900">
                            با مطالعه
                            <a href="" target="_blank" class="text-custom-900 font-semibold"> خرید امن </a>
                            آسوده معامله کنید.
                        </p>
                    </div>


                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-700 border-dashed font-bold">
                            <i class="fal fa-comment"></i>
                            نظرات کاربران
                        </p>
                        <div class="mt-3 grid gap-3 max-h-[350px] overflow-y-auto comments-list">
                            @if(count($comments) > 0)
                                @foreach($comments as $value)
                                    @include('components.profile.comment' , ['comment' => $value])
                                @endforeach
                            @else
                                <div class="empty mt-3">
                                    <img class="mx-auto" src="{{asset('assets/portal/img/empty.svg')}}">
                                    <p class="text-gray-400 text-center mt-3 text-xs"> نظری هنوز ثبت نشده است</p>
                                </div>
                            @endif
                        </div>
                    </div>


                    @if(count($similar) > 0)
                        <div class="md:col-span-2">

                            <p class="text-sm text-gray-700 border-dashed font-bold">
                                آخرین محصولات مرتبط
                            </p>

                            <div class="mx-auto relative overflow-hidden mt-3 hidden sm:block">
                                <div class="swiper-products-similar">
                                    <div class="swiper-wrapper py-3">
                                        @foreach($similar as $value)
                                            <div class="swiper-slide">
                                                @include('components.product.card' , ['product'=> $value])
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            </div>

                            <div class="mx-auto mt-3 block sm:hidden">
                                <div class="">
                                    <div class="py-3">
                                        @foreach($similar as $value)
                                            <div class="py-2">
                                                @include('components.product.card' , ['product'=> $value])
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                </div>

            </div>

            <div class="md:col-span-4">
                <div class="shadow-lg rounded-lg p-4 hidden sm:block">
                    <div class="user-info flex gap-3 items-center">
                        @if($product->user && $product->user->info && is_null($product->user->info->profile_pic))
                            <i class="fal fa-user-circle rounded-full text-2xl bg-custom-400 w-12 h-12 flex ring-custom-100 text-white ring-4 justify-center items-center"></i>
                        @else
                            <img src="{{url($product->user->info->profile_pic)}}"
                                 class="h-12 w-12 rounded-full ring-4 ring-green-300">
                        @endif
                        <p>
                            <span class="text-sm"> {{$product->user ? $product->user->name : ''}}</span>
                            <br/>
                            @if($product->user && $product->user->vip_account)
                                <span class=" bg-yellow-300 text-white rounded-full px-2 py-1" style="font-size: 10px;">
                                    <i class="fas text-white fa-medal"></i>
                                    فروشنده برتر
                                </span>
                            @endif
                            @if($product->user && $product->user->confirm_identity)
                                <span class=" bg-green-500 text-white rounded-full px-2 py-1 mr-2"
                                      style="font-size: 10px;">
                                    <i class="fas text-white fa-shield-halved"></i>
                                    احراز شده

                                </span>
                            @else
                                <span class=" bg-red-500 text-white rounded-full px-2 py-1 mr-2"
                                      style="font-size: 10px;">
                                    <i class="fas text-white fa-shield-halved"></i>
                                    احراز نشده
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="description mt-5">
                        @if($product->user && $product->user->info)
                            <p class="text-sm"> توضیحات فروشنده </p>
                            <p class="text-xs text-gray-500 mt-3 leading-6 text-justify">
                                {{$product->user->info->description}}
                            </p>
                        @endif
                    </div>
                    <div class="mt-5">
                        <a href="{{route('profile.show' , $product->user->id)}}" target="_blank"
                           class="text-xs block text-center w-full py-3 font-semibold px-4 text-custom-900 bg-white rounded-md">
                            مشاهده پروفایل کاربری
                            <i class="fa fa-angle-left text-custom-900 mr-2"></i>
                        </a>
                    </div>
                </div>

                <div class="shadow-sm bg-blue-100 rounded-lg p-4 mt-5 hidden sm:block">
                    <a href=""
                       class="text-blue-500 font-semibold justify-between flex items-center justify-center text-sm">
                            <span class="text-blue-500 flex items-center gap-2">
                                <i class="text-blue-500 fas fa-warning text-md"></i>
                                خرید امن
                            </span>

                        <i class="text-blue-500 fal fa-angle-left text-2xl"></i>
                    </a>
                    <p class="text-xs my-5 text-gray-900">
                        زاندس هیج گونه مسئولیت و منفعتی در قبال معاملات شما ندارد.
                    </p>
                    <p class="text-xs  text-gray-900">
                        با مطالعه
                        <a href="" target="_blank" class="text-custom-900 font-semibold"> خرید امن </a>
                        آسوده معامله کنید.
                    </p>
                </div>

                @foreach($banners as $value)
                    <div class="mt-5">
                        <a href="{{$value->link}}" target="_blank">
                            <img src="{{url($value->photo)}}" class="rounded-lg shadow-lg w-full"
                                 alt="{{$value->title}}"/>
                        </a>
                    </div>
                @endforeach
            </div>


        </div>
    </section>
    @if(Auth::check())
        @include('components.chat.box')
        @include('components.modal.phone')
    @endif
@endsection
@section('js')
    <script src="{{asset('assets/js/swiper.js')}}"></script>
    <script src="{{asset('assets/js/product.js?ver=1.6')}}"></script>
    @if(Auth::check())
        <script src="{{asset('assets/portal/js/phone.js')}}" type="text/javascript"></script>
    @endif
@endsection

