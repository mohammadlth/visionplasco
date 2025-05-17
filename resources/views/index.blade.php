@extends('layouts.front')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/swiper.css')}}">
@endsection
@section('body')

    <section class="w-full mx-auto">

        <div class="relative shadow-2xl">

            @if(!is_null($slider))
                <img src="{{url($slider->photo)}}" class="object-cover shadow-sm w-full">
            @endif
            <div class="absolute grid w-full left-0 right-0 top-0 bottom-0 h-full justify-center items-center"
                 style=" background-color:#00000085">
                <div class="content p-2 md:p-10 text-center">
                    <h1 class="text-white font-semibold rounded-md mx-auto  w-fit px-1 sm:px-3  text-md md:text-2xl text-center">
                        <span class="text-white">  زاندس </span>
                        | مرکز خرید فروش عمده محصولات کشاورزی
                    </h1>
                    <div class="hidden sm:block">
                        @include('components.search_box')
                    </div>
                    <p class="text-white text-center text-custom-50  mt-5">

                        <strong class="text-white text-xs sm:text-md">به دنبال خرید / فروش </strong>
                        <strong id="type-animation-home" class="text-white"></strong>
                        <span class="text-white text-xs sm:text-md"> هستید ؟ </span>
                        <small class="text-white text-xs sm:text-md">
                            <span class="bg-custom-900 rounded-md  text-xs p-1 text-white text-xs sm:text-md"> زاندس</span>
                            در خدمت شماست </small>
                    </p>
                    <div class="text-center mt-10 flex gap-3 items-center justify-center">
                        <a class="text-white bg-blue-900 text-sm shadow-2xl flex items-center px-5 py-3  rounded-lg"
                           href="{{route('panel')}}">
                            <i class="far fa-user ml-2 text-white"></i>
                            خریدار هستم
                        </a>
                        <a class="text-white bg-custom-900 shadow-2xl text-sm flex items-center px-5 py-3  rounded-lg"
                           href="{{route('panel')}}">
                            <i class="fas fa-user ml-2 text-white"></i>
                            فروشنده هستم
                        </a>
                    </div>
                </div>
            </div>

        </div>


    </section>
    <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">
        <p class="text-gray-400 text-center text-xs"> دسته بندی محصولات </p>
        <h2 class="text-center text-xl sm:text-2xl font-bold text-gray-900"> هر آنچه که در
            <b class="mx-2 text-custom-900 under-text"> زاندس </b>
            به دنبال آن هستید
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-5 mt-6 sm:mt-16 gap-5 sm:gap-10">
            @foreach($categories as $value)
                <div class="item shadow-xl relative rounded-2xl p-10">
                    <a href="{{route('product.category' , [$value->id,$value->slug])}}">
                        @if($value->photo)
                            <img src="{{url($value->photo)}}" alt="" class="max-w-full w-32  mx-auto">
                        @endif
                        <p class="text-gray-800 font-semibold text-center text-sm mt-3"> {{$value->title}} </p>
                    </a>
                </div>
            @endforeach


        </div>
    </section>

    @if(count($new_products) > 0)
        <section class="max-w-6xl mx-auto pt-6 sm:pt-10 px-5">


            <div class="items-box bg-custom-700 rounded-lg p-5 shadow-xl">
                <div class="head md:flex items-center justify-between">
                    <div class="flex items-center md:gap-10">
                        <h3 class="my-2 border-under"><span class="text-white">تازه های  زاندس</span></h3>
                    </div>
                    <a href="{{route('product.all' , ['sort' => 'new'])}}"
                       class="text-sm text-custom-900 rounded-md items-center flex px-3 py-2 bg-white">
                        مشاهده محصولات بیشتر
                        <i class="fa fa-arrow-left text-custom-900 mr-3"></i>
                    </a>
                </div>
                <div class="border border-red-400 border-dashed"></div>


                <div class="products-box mt-5">


                    <div class=" mx-auto relative overflow-hidden">
                        <div class="swiper-products">
                            <div class="swiper-wrapper">
                                @foreach($new_products as $value)
                                    <div class="swiper-slide">
                                        @include('components.product.card' , ['product' => $value])
                                    </div>
                                @endforeach
                            </div>

                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>


                </div>
            </div>
        </section>
    @endif

    @foreach($banners as $key => $value)
        @if($key == 0)
            <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">
                <div class="banner">
                    <a href="{{$value->link}}">
                        <img src="{{url($value->photo)}}" alt="" class="w-full rounded-lg shadow-2xl"/>
                    </a>
                </div>
            </section>
        @endif
    @endforeach

    <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">

        <p class="text-gray-400 text-center text-xs"> خریداران چه میگویند ؟ </p>
        <h2 class="text-center text-2xl font-bold text-gray-900"> نیازمندی خریداران در
            <b class="mx-2 text-blue-900 under-text-blue"> زاندس </b>
        </h2>
        <p class="text-center mt-3">
            <a href="{{route('buy-req')}}"
               class="text-white bg-green-500 text-xs rounded-md p-1 px-2 items-center justify-center shadow-sm"> مشاهده
                همه
                <i class="fal fa-angle-left text-white mr-[3px] text-[9px]"></i>
            </a>
        </p>
        <div class="buyers mt-16">
            <div class="mx-auto">
                <div class="swiper-products relative">
                    <div class="swiper-wrapper">

                        @foreach($buyers as $value)
                            <div class="swiper-slide">
                                <div class="box-buy border border-dashed relative  border-blue-900  rounded-lg p-5 sm:min-h-[235px]">

                                    <div class="head text-center">
                                        <div
                                                class="chat-icon bg-blue-800 ring-8 w-10 h-10 flex items-center justify-center absolute right-10 -top-6  rounded-full">
                                            <i class="fal fa-hand text-white"></i>
                                        </div>
                                        <i class="fal fa-user text-xs mt-3"></i>
                                        <span class="text-gray-800 font-semibold" style="font-size: 10px">
                                            {{$value->user ? $value->user->name : ''}}
                                            <span>{{verta($value->created_at)->formatDifference()}}</span>
                                        </span>
                                    </div>
                                    <div class="content mt-3 text-md">
                                        <h3 class="text-center">
                                            خریدار
                                            <strong class="font-semibold text-custom-900"> {{unit_calculate($value->inventory , $value->category->unit)}} </strong>
                                            {{$value->category ? $value->category->title : 'نامعلوم'}}
                                            <span class="text-gray-800"> از نوع </span>
                                            <strong class="text-dark text-sm">{{$value->type}} </strong>
                                        </h3>
                                    </div>
                                    <div class="foo mt-3">
                                        <a href="{{route('portal.request.list')}}"
                                           class="text-xs block w-full text-center border border-dashed border-blue-700 px-4 py-2 rounded-md  text-blue-900">
                                            ارتباط با خریدار </a>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full mx-auto mt-6 md:mt-10 p-5 md:p-10 features-home ">
        <h2 class="text-center text-2xl font-bold text-gray-900 text-white">
            زاندس چیست ؟
        </h2>
        <p class="text-center text-gray-100 mt-5 text-sm">
            زاندس ویترین فروش محصولات شماست
        </p>
        <div class="content-feature max-w-5xl p-5 bg-white mx-auto mt-5 bg-opacity-80 rounded-md shadow-xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-10">
                @foreach($features as $value)
                    <div class="feature flex gap-3 items-between">
                        <div class="icon bg-blue-500 text-white w-12 h-12 flex items-center justify-center rounded-md">
                            @if(!$value->icon)
                                <i class="fas fa-wind text-white"></i>
                            @else
                                <img class="w-[30px]" src="{{url($value->icon)}}"/>
                            @endif
                        </div>
                        <div class="w-3/4 body">
                            <h5 class="text-lg font-semibold">{{$value->title}} </h5>
                            <p class="text-sm leading-6 text-justify text-gray-800 mt-2">
                                {{$value->text}}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            @foreach($banners as $key => $value)
                @if($key == 1)
                    <div>
                        <a href="{{$value->link}}">
                            <img src="{{url($value->photo)}}" class="w-full rounded-lg shadow-2xl" alt="">
                        </a>
                    </div>
                @endif
            @endforeach
            @foreach($banners as $key => $value)
                @if($key == 2)
                    <div>
                        <a href="{{$value->link}}">
                            <img src="{{url($value->photo)}}" class="w-full rounded-lg shadow-2xl" alt="">
                        </a>
                    </div>
                @endif
            @endforeach

        </div>
    </section>



    @if(count($footer_products) > 0)
        <section class="w-full mx-auto pt-6 sm:pt-10 px-5">


            <div class="items-box p-5">
                <p class="text-gray-400 text-center text-xs">محصولات مشتریان زاندس </p>
                <h2 class="text-center text-2xl font-bold text-gray-900">
                    <b class="mx-2 text-gray-800 under-text-blue font-semibold"> آنچه مشتریان می پسندند </b>
                </h2>


                <div class="products-box mt-5">


                    <div class=" mx-auto relative overflow-hidden">
                        <div class="swiper-products-2">
                            <div class="swiper-wrapper py-3">
                                @foreach($footer_products as $value)
                                    <div class="swiper-slide">
                                        @include('components.product.card' , ['product' => $value])
                                    </div>
                                @endforeach
                            </div>

                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>


                </div>
            </div>
        </section>
    @endif


    <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">
        <p class="text-gray-400 text-center text-xs"> صنایع فعال در زاندس </p>
        <h2 class="text-center text-2xl font-bold text-gray-900"> سپاس از اعتماد شما به
            <b class="mx-2 text-custom-900 under-text"> زاندس </b>
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-5 mt-16 gap-10">
            <div class="item text-center">
                <div
                        class="icon flex items-center justify-center ring-8 w-16 h-16 p-3 bg-custom-700 ring-custom-200 text-white shadow-md mx-auto rounded-full">
                    <i class="fal fa-users text-4xl text-white"></i>
                </div>
                <div class="content mt-3">
                    <div class="number text-2xl" style="font-family: cursive">
                        +2000
                    </div>
                    <p class="mt-2 text-gray-500">
                        فروشندگان فعال
                    </p>
                </div>
            </div>
            <div class="item text-center">
                <div class="icon">
                    <div
                            class="icon flex items-center justify-center ring-8 w-16 h-16 p-3 bg-custom-700 ring-custom-200 text-white shadow-md mx-auto rounded-full">
                        <i class="fal fa-industry text-4xl text-white"></i>
                    </div>
                </div>
                <div class="content mt-3">
                    <div class="number text-2xl" style="font-family: cursive">
                        +500
                    </div>
                    <p class="mt-2 text-gray-500">
                        شرکت های بازرگانی
                    </p>
                </div>
            </div>
            <div class="item text-center">
                <div
                        class="icon flex items-center justify-center ring-8 w-16 h-16 p-3 bg-custom-700 ring-custom-200 text-white shadow-md mx-auto rounded-full">
                    <i class="fal fa-store text-4xl text-white"></i>
                </div>
                <div class="content mt-3">
                    <div class="number text-2xl" style="font-family: cursive">
                        +120
                    </div>
                    <p class="mt-2 text-gray-500">
                        صنایع مختلف
                    </p>
                </div>
            </div>
            <div class="item text-center">
                <div
                        class="icon flex items-center justify-center ring-8 w-16 h-16 p-3 bg-custom-700 ring-custom-200 text-white shadow-md mx-auto rounded-full">
                    <i class="fal fa-check-double text-4xl text-white"></i>
                </div>
                <div class="content mt-3">
                    <div class="number text-2xl" style="font-family: cursive">
                        +1M
                    </div>
                    <p class="mt-2 text-gray-500">
                        معامله موفق
                    </p>
                </div>
            </div>
            <div class="item text-center">
                <div
                        class="icon flex items-center justify-center ring-8 w-16 h-16 p-3 bg-custom-700 ring-custom-200 text-white shadow-md mx-auto rounded-full">
                    <i class="fal fa-calendar-alt text-4xl text-white"></i>
                </div>
                <div class="content mt-3">
                    <div class="number text-2xl " style="font-family: cursive">
                        +1Y
                    </div>
                    <p class="mt-2 text-gray-500">
                        در کنار شما هستیم
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5 hidden">
        <p class="text-gray-400 text-center text-xs"> محصول خود را در بازار یافت نکردید ؟ </p>
        <h2 class="text-center text-2xl font-bold text-gray-900"> خریداران عمده
            <b class="mx-2 text-custom-900 under-text"> زاندس </b>
        </h2>
        <div class="md:w-2/3 mx-auto rounded-lg shadow-lg p-5 mt-5">
            <p class="text-md text-gray-600"> خریداران محترم میتوانند با ثبت درخواست خود از محصول مورد نیاز خود
                پیشنهاد
                فروشندگان را دریافت کنند </p>
            <form method="post" action="" class="mt-3">
                {{--                <div class="form-control">--}}
                {{--                    <label class="text-sm text-gray-700"> انتخاب دسته محصول (مثلا : پسته) </label>--}}
                {{--                    <input type="text" name="category" disabled--}}
                {{--                           class="w-full mt-2 border rounded-md px-3 py-2" placeholder="انتخاب دسته بندی محصول">--}}
                {{--                </div>--}}

                {{--                <div class="mt-5">--}}
                {{--                    <label class="text-sm text-gray-700"> نوع محصول ( مثلا : درجه یک دامغان) </label>--}}
                {{--                    <input type="text" name="variant" disabled class="w-full mt-2 border rounded-md px-3 py-2"--}}
                {{--                           placeholder="نوع محصول">--}}
                {{--                </div>--}}

                {{--                <div class="mt-5 relative">--}}
                {{--                    <label class="text-sm text-gray-700"> مقدار نیازمندی (مثلا : 1000 کیلوگرم) </label>--}}
                {{--                    <input type="text" name="variant" disabled class="w-full mt-2 border rounded-md px-3 py-2"--}}
                {{--                           placeholder="مقدار نیازمندی">--}}
                {{--                    <span class="helper absolute left-2 top-14 text-gray-400  border-r-2 pr-3 text-sm"> کیلوگرم--}}
                {{--                        </span>--}}
                {{--                </div>--}}

                <div class="mt-5 relative">
                    <a href="{{route('portal.request.store')}}" type="submit"
                       class="btn text-white bg-blue-900 px-3 py-3 w-full text-sm rounded-md">
                        ثبت
                        درخواست
                    </a>
                </div>
            </form>
        </div>
    </section>

@endsection
@section('js')
    <script defer src="{{asset('assets/js/swiper.js')}}"></script>
    <script defer src="{{asset('assets/js/index.js?ver=1.9')}}"></script>
    <script>
        $(document).ready(function () {

            new TypeIt('#type-animation-home', {
                strings: ["خشکبار", "غلات", "ادویه", "حبوبات", "میوه", "صیفی", "بذر و نهال"],
                speed: 150,
                startDelay: 2000,
                loop: true,
                waitUntilVisible: true,
                breakLines: false,

            }).go();
        });
    </script>
@endsection
