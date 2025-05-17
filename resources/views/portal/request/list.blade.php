@extends('layouts.portal')
@section('navbar')

@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/swiper.css')}}">
@endsection
@section('body')
    <section class="content my-5">
        <div class="sm:col-span-1 step-level bg-white p-5 rounded-lg shadow-sm">
            <p class="text-md sm:text-xl text-center">
                درخواست های خرید
            </p>
            <p class="text-center text-gray-500 text-xs sm:text-sm mt-2">
                هر آنچه نیاز بازار است را در لیست زیر مشاهده کنید
                ( {{config('app.name_fa')}}
                )
            </p>
            <div class="search relative">
                <input name="search"
                       class="border border-1 rounded-sm w-full mt-3 px-2 py-4 rounded-lg text-right pr-10 text-xs sm:text-sm bg-gray-100 search-buyers"
                       placeholder="محصولی را که به دنبال آن هستید جستجو کنید....">
                <i class="fa fa-search absolute right-5 top-[28px] text-gray-400"></i>
                <button class="bg-yellow-500 absolute text-white left-[10px] top-[25px] p-2 rounded-md text-xs flex justify-center gap-1" type="button">
                    <i class="fa fa-spinner fa-spin text-white text-xs loading-data-spin hidden"></i>
                    جستجو کنید
                </button>
            </div>
            <div class="requests-list">
                @include('components.portal.request.list'  , ['items' => $requests])
            </div>
        </div>
    </section>
    @include('components.chat.box')

    @include('components.modal.phone')



    <div class="vip-account hidden close-model-vip">
        <div class="fixed top-0 right-0 bottom-0 left-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="w-[350px] sm:w-[400px] rounded-md shadow-md bg-white p-0 min-h-[350px] class-content-modal-vip">

                <div class="mx-auto relative rounded-md overflow-hidden">
                    <button class="absolute top-2 left-3 z-20 text-red-500"
                            onclick="$('.close-model-vip').fadeOut('fast')">
                        <i class="fa fa-times text-red-500"></i>
                    </button>
                    <div class="swiper-vip">
                        <div class="swiper-wrapper">
                            @foreach($slider as $value)
                                <div class="swiper-slide">
                                    <div class="image bg-[#ffcc94]">
                                        <img src="{{url($value->photo)}}" class="w-full">
                                    </div>
                                    <div class="content p-3 mt-10 mb-[100px]">
                                        <h2 class="text-center">{{$value->title}}</h2>
                                        <p class="text-gray-500 text-sm text-center mt-3">{{$value->short_text}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-pagination"></div>

                    </div>

                    <div class="absolute bottom-5 right-0 left-0 w-full z-20 text-center">
                        <a href="{{route('portal.plan')}}"
                           class="bg-yellow-600 w-[250px] rounded-md py-2 px-2 flex justify-center mx-auto items-center gap-4 shadow-md">
                            <span class="text-white"> ارتقا عضویت</span>
                            <i class="fas fa-angle-left text-white"></i>
                        </a>
                    </div>

                </div>


            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('assets/portal/js/request_list.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/portal/js/phone.js')}}" type="text/javascript"></script>
    <script defer src="{{asset('assets/js/swiper.js')}}"></script>
    <script>
        $(document).ready(function () {
            new Swiper('.swiper-vip', {
                spaceBetween: 0,
                slidesPerView: 1,
                loop: false,
                dir: 'rtl',
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });

            $('.close-model-vip').click(function () {
                $('.close-model-vip').fadeOut('fast');
            });
            $('.class-content-modal-vip').click(function (event) {
                event.stopPropagation();
            });
        });

        function vipShowToggle() {
            $('.vip-account').fadeIn(500)
        }


    </script>
@endsection
