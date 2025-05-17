<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> پنل کاربری |  زاندس</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('assets/portal/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/toast.min.css')}}"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{asset('assets/js/config.js')}}"></script>
    <link rel="icon" type="image/png" href="{{url('assets/img/fav-icon.png')}}">
    <meta name="csrf" content="{{csrf_token()}}">
    <meta name="base_url" content="{{url('/')}}/">
    @yield('css')
</head>

<body dir="rtl" class="min-h-screen dark:bg-black">

<div class="lg:flex m-2 sm:m-5">

    <nav class="nav-menu fixed sm:relative lg:block -right-[300px] left-[500px] sm:right-[0] sm:left-[0] top-0 bottom-0 w-auto lg:w-2/12 p-5 bg-blue-900  h-full sm:rounded-md shadow-2xl h-full min-h-screen"
         style="z-index: 999">
        <div class="head-nav">
            <img src="{{asset('assets/portal/img/logo.png')}}" alt="" class="w-[200px] sm:w-full mx-auto px-3">
        </div>

        <div class="close-nav block sm:hidden absolute top-2 left-5">
            <i class="fa fa-times text-red-500 text-white text-xl"></i>
        </div>

        <div class="user-info sm:mt-3 flex gap-3 items-center">
            @if(!is_null(Auth::user()->info->profile_pic))
                <img src="{{url(Auth::user()->info->profile_pic)}}" class="w-10 h-10 sm:w-16 sm:h-16 rounded-full"
                     alt="">
            @else
                <img src="{{asset('assets/portal/img/user-p.png')}}" class="w-10 sm:w-16" alt="">
            @endif
            <div class="info">
                <p class="text-white text-xs"> {{Auth::user()->name}} </p>
                @if(Auth::user()->vip_account)
                    <p class="text-xs mt-2 text-white text-yellow-500">
                        <i class="fal fa-star text-yellow-500"></i>
                        کاربر ویژه
                    </p>
                @else
                    <p class="text-xs mt-2 text-white">
                        <i class="fal fa-star text-white"></i>
                        کاربر عادی
                    </p>
                @endif
            </div>
        </div>

        <div class="type flex gap-3 mt-3">


            @if(Auth::user()->account ==  'seller')

                <button
                        class="seller flex gap-2 w-full text-white bg-green-500 text-xs border-2 border-green-500 justify-center px-2 py-2 rounded-md">
                    <img src="{{asset('assets/portal/img/farmer.svg')}}" class="w-4 text-white"/>
                    فروشنده
                </button>

            @else

                <a href="{{route('change.level' , 'seller')}}"
                   class="seller flex gap-2 w-full text-white text-xs border-2 border justify-center px-2 py-2 rounded-md">
                    <img src="{{asset('assets/portal/img/farmer.svg')}}" class="w-4 text-white"/>
                    فروشنده
                </a>

            @endif


            @if(Auth::user()->account ==  'buyer')

                <button
                        class="seller flex gap-2 w-full text-white bg-green-500 text-xs border-2 border-green-500 justify-center px-2 py-2 rounded-md">
                    <img src="{{asset('assets/portal/img/user-buy.svg')}}" class="w-4 text-white"/>
                    خریدار
                </button>

            @else

                <a href="{{route('change.level' , 'buyer')}}"
                   class="seller flex gap-2 w-full text-white text-xs border-2 border justify-center px-2 py-2 rounded-md">
                    <img src="{{asset('assets/portal/img/user-buy.svg')}}" class="w-4 text-white"/>
                    خریدار
                </a>

            @endif


        </div>

        <div class="balance bg-blue-100 p-2 rounded-md mt-3 ring-[5px] mt-5 hidden">
            <p class="text-xs text-center">
                <i class="fal fa-wallet"></i>
                دارایی کیف پول شما
            </p>
            <p class=" text-center mt-2 flex justify-between items-center">
                    <span class="font-semibold text-custom-900">
                        50,000
                        <small class="text-custom-900"> تومان </small>
                    </span>
                <a href="#"> <i
                            class="fal fa-plus w-6 h-6 text-white rounded-sm shadow-md flex justify-center items-center bg-green-500"></i>
                </a>
            </p>
        </div>
        <div class="menu-list">
            <ul class="mt-5 grid gap-3">

                <li class="text-xs bg-blue-800 px-2 py-3 rounded-lg text-white">
                    <a href="{{url('/')}}" class="flex gap-2 justify-start items-center">
                        <i class="fal fa-home text-white"></i>
                        خانه
                    </a>
                </li>

                <li class="text-xs bg-blue-800 px-2 py-3 rounded-lg text-white">
                    <a href="{{route('panel')}}" class="flex gap-2 justify-start items-center">
                        <i class="fal fa-dashboard text-white"></i>
                        داشبورد
                    </a>
                </li>

                <li class="text-xs bg-blue-800 px-2 py-3 rounded-lg text-white">
                    <a href="{{route('portal.chat')}}" class="flex gap-2 justify-start items-center">
                        <i class="fal fa-comments text-white"></i>
                        پیام ها
                    </a>
                </li>

                @if(Auth::user()->account == 'seller')

                    <li class="text-xs bg-blue-800 px-2 py-3 rounded-lg text-white">
                        <a href="{{route('portal.request.list')}}" class="flex gap-2 justify-start items-center">
                            <i class="fal fa-users text-white"></i>
                            درخواست های خریداران
                        </a>
                    </li>

                    <li class="text-xs bg-blue-800 px-2 py-3 rounded-lg text-white">
                        <a href="{{route('portal.products')}}" class="flex gap-2 justify-start items-center">
                            <i class="fal fa-box text-white"></i>
                            لیست محصولات
                        </a>
                    </li>
                    <li class="text-xs bg-blue-800 px-2 py-3 rounded-lg text-white">
                        <a href="{{route('portal.product.store')}}" class="flex gap-2 justify-start items-center">
                            <i class="fal fa-box text-white"></i>
                            ثبت محصول
                        </a>
                    </li>
                    <li class="text-xs bg-blue-800 px-2 py-3 rounded-lg text-white">
                        <a href="{{route('portal.plan')}}" class="flex gap-2 justify-start items-center">
                            <i class="fal fa-level-up text-white"></i>
                            ارتقا عضویت
                        </a>
                    </li>
                @else
                    <li class="text-xs bg-blue-800 px-2 py-3 rounded-lg text-white">
                        <a href="{{route('portal.request.store')}}" class="flex gap-2 justify-start items-center">
                            <i class="fal fa-box text-white"></i>
                            ثبت درخواست خرید
                        </a>
                    </li>
                @endif


                <li class="text-xs bg-blue-800 px-2 py-3 rounded-lg text-white">
                    <a href="{{route('verification.index')}}" class="flex gap-2 justify-start items-center">
                        <i class="fal fa-shield text-white"></i>
                        احراز هویت
                    </a>
                </li>
            </ul>
        </div>

    </nav>

    <main class="body  w-full lg:w-10/12  min-h-screen sm:mr-5">

        <header class="bg-blue-900 p-3 rounded-md items-center justify-between flex sm:block justify-between">

            <div class="right">
                <div class="block sm:hidden flex items-center open-menu">
                    <i class="fal fa-bars text-white text-[20px]"></i>
                </div>
            </div>

            <div class="left flex gap-5 items-center justify-between">
                <div class="charge flex gap-3">
                    @if(Auth::user()->account ==  'seller')
                        <a href="{{route('portal.plan')}}"
                           class="btn bg-tarnsparent bg-yellow-500 px-3  text-white  flex items-center gap-1 rounded-full text-[12px]">
                            <i class="fa fa-star text-white"></i>
                            ارتقاع عضویت
                        </a>
                    @endif
                    <button
                            class="btn bg-tarnsparent bg-green-500 px-3  text-white  flex items-center gap-1 rounded-full text-[12px]">
                        <i class="fa fa-wallet text-white"></i>
                        موجودی :
                        <strong class="text-white"> 0 </strong>
                        {{--                        <small class="text-white">تومان </small>--}}
                    </button>
                </div>
                <div class="profile-header relative">
                    <button onclick="$('.dropdown-profile').toggleClass('hidden')" class="flex gap-2 items-center">
                        <i
                                class="fal fa-user text-white cursor-pointer bg-blue-900 w-8 h-8 flex ring-4 ring-blue-800 rounded-full items-center justify-center"></i>
                        <i class="fal fa-angle-down text-white"></i>
                    </button>
                    <div class="dropdown-profile z-20 top-[50px] left-0 absolute hidden">
                        <div class="bg-blue-900 px-2 py-5 min-w-[120px] rounded-md">
                            <ul class="grid gap-2">
                                <li>
                                    <a href="{{route('portal.profile')}}" class="justify-start flex items-center">
                                        <i class="fal fa-user text-white text-sm"></i>
                                        <span class="text-xs mx-1 text-white"> پروفایل کاربری </span>
                                    </a>
                                </li>
                                <li class="mt-1">
                                    <a href="{{route('verification.index')}}" class="justify-start flex items-center">
                                        <i class="fal fa-shield text-white text-sm"></i>
                                        <span class="text-xs mx-1 text-white"> احراز هویت </span>
                                    </a>
                                </li>
                                <li class="mt-1">
                                    <a href="{{route('logout')}}" class="justify-start flex items-center">
                                        <i class="fal fa-sign-out text-white text-sm"></i>
                                        <span class="text-xs mx-1 text-white"> خروج </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        @yield('body')

        <footer class="px-3  md:flex gap-5 justify-between items-center rounded-md">
            <p class="text-gray-500 text-[11px] text-center sm:text-right">
                <i class="fal fa-copyright text-gray-500"></i>
                تمامی حقوق برای  زاندس محفوظ است
            </p>
            <p class=" text-center sm:text-right">
                <i class="fal fa-phone text-gray-500 text-[11px]"></i>
                <span class="text-gray-500 text-[11px]"><a href="tel:90007026">90007026</a></span>
            </p>
        </footer>
    </main>
</div>

<div class="fixed left-0 right-0 top-0 bottom-0 bg-black bg-opacity-50 pattern-close hidden"></div>
<script src="{{asset('assets/portal/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/toast.min.js')}}"></script>
<script src="{{asset('assets/js/portal.js')}}"></script>
@include('message')
@yield('js')
@yield('jss')
<script>
    $('.close-nav,.pattern-close').click(function () {
        $('.nav-menu').animate({'left': "500px", 'right': "-300px"}, 300);
        $('.pattern-close').addClass('hidden');
    });
    $('.open-menu').click(function () {
        $('.nav-menu').animate({'left': "100px", 'right': "0px"}, 300);
        $('.pattern-close').removeClass('hidden');
    });
</script>
</body>
</html>
