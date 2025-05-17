<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{config('app.name_fa')}}| پنل مدیریت </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <meta name="csrf" content="{{csrf_token()}}">
    <meta name="base_url" content="{{url('/')}}/">
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/main.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="icon" type="image/png" href="{{url('assets/img/fav-icon.png')}}">
    @yield('style')
    <style>
        .cke_maximized {
            top: 0 !important;
        }
    </style>
</head>

<body dir="rtl" class="min-h-screen dark:bg-black bg-gray-100 rtl">

<div class="md:fixed md:w-full md:top-0 md:z-20 flex flex-row flex-wrap items-center bg-white p-3 border-b border-gray-300">

    <div class="flex-none w-56 flex flex-row items-center">
        <a href="{{url('/')}}" target="_blank">
            <img src="{{asset('assets/img/logo.png')}}" class="w-[130px] flex-none">
        </a>
        <button id="sliderBtn" class="flex-none text-right text-gray-900 hidden md:block">
            <i class="fad fa-list-ul"></i>
        </button>
    </div>

    <button id="navbarToggle" class="hidden md:block md:fixed right-0 mr-6">
        <i class="fad fa-chevron-double-down"></i>
    </button>

    <div id="navbar"
         class="animated md:hidden md:fixed md:top-0 md:w-full md:left-0 md:mt-16 md:border-t md:border-b md:border-gray-200 md:p-10 md:bg-white flex-1 pl-3 flex flex-row flex-wrap justify-between items-center md:flex-col md:items-center">
        <!-- left -->
        <div class="text-gray-600 md:w-full md:flex md:flex-row md:justify-evenly md:pb-10 md:mb-10 md:border-b md:border-gray-200">
        </div>
        <!-- end left -->
        <!-- right -->
        <div class="flex flex-row-reverse items-center">
            <!-- user -->
            <div class="dropdown relative md:static">
                <button class="menu-btn focus:outline-none flex flex-wrap items-center">
                    <div class="w-8 h-8 overflow-hidden rounded-full">
                        <img class="w-full h-full object-cover" src="{{asset('assets/dashboard/img/user.svg')}}">
                    </div>

                    <div class="mr-2 capitalize flex outline-none">
                        <h1 class="text-sm text-gray-800 font-semibold m-0 p-0 leading-none outline-none">{{Auth::user()->name}}</h1>
                        <i class="fad fa-chevron-down mr-2 text-xs leading-none"></i>
                    </div>
                </button>

                <button class="hidden fixed top-0 left-0 z-10 w-full h-full menu-overflow"></button>

                <div class="text-gray-500 menu hidden md:mt-10 md:w-full rounded bg-white shadow-md absolute z-20 right-0 w-40 mt-5 py-2 animated faster">
                    <a class="px-4 py-2 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 hover:text-gray-900 transition-all duration-300 ease-in-out"
                       href="#">
                        <i class="fad fa-user-edit text-xs ml-1"></i>
                        پروفایل من
                    </a>
                    <a class="px-4 py-2 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 hover:text-gray-900 transition-all duration-300 ease-in-out"
                       href="#">
                        <i class="fad fa-inbox-in text-xs ml-1"></i>
                        لیست کارها
                    </a>
                    <hr>
                    <a class="px-4 py-2 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 hover:text-gray-900 transition-all duration-300 ease-in-out"
                       href="{{route('logout')}}">
                        <i class="fad fa-user-times text-xs ml-1"></i>
                        خروج
                    </a>
                </div>
            </div>
            <!-- end user -->


        </div>
        <!-- end right -->
    </div>

</div>

<main class="h-screen flex flex-row flex-wrap">

    <!-- start sidebar -->
    <div id="sideBar"
         class="relative flex flex-col flex-wrap bg-white border-r border-gray-300 p-6 flex-none w-64 md:-mr-64 md:fixed md:top-0 md:z-30 md:h-screen md:shadow-xl animated faster">


        <!-- sidebar content -->
        <div class="flex flex-col">

            <!-- sidebar toggle -->
            <div class="text-right hidden md:block mb-4">
                <button id="sideBarHideBtn">
                    <i class="fad fa-times-circle"></i>
                </button>
            </div>
            <!-- end sidebar toggle -->

            <p class="uppercase text-xs text-gray-600 mb-2 tracking-wider">داشبورد</p>

            <a href="{{route('dashboard')}}"
               class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                <i class="fad fa-chart-pie text-xs ml-2"></i>
                مدیریت
            </a>
            <a href="{{route('home')}}" target="_blank"
               class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                <i class="fad fa-home text-xs ml-2"></i>
                صفحه اصلی سایت
            </a>

            <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">مدیریت</p>

            @if(in_array(1 , $permission))
                <a href="{{route('users.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-user text-xs ml-2"></i>
                    لیست کاربران
                </a>
            @endif
            @if(in_array(1 , $permission))
                <a href="{{route('users.vip')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-star text-xs ml-2"></i>
                    کاربران ویژه
                </a>
            @endif
            @if(in_array(2 , $permission))
                <a href="{{route('categories.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-folder-open text-xs ml-2"></i>
                    دسته بندی محصولات
                </a>
            @endif

            @if(in_array(3 , $permission))

                <a href="{{route('products.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-folder-open text-xs ml-2"></i>
                    محصولات
                </a>
            @endif

            @if(in_array(4 , $permission))

                <a href="{{route('requests.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-shopping-basket text-xs ml-2"></i>
                    درخواست خرید
                </a>
            @endif

            @if(in_array(5 , $permission))

                <a href="{{route('comments.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-comments text-xs ml-2"></i>
                    نظرات کاربران
                </a>
            @endif


            <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">کنترل</p>

            @if(in_array(6 , $permission))

                <a href="{{route('contacts.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-users text-xs ml-2"></i>
                    مخاطبین
                </a>
            @endif

            @if(in_array(7 , $permission))

                <a href="{{route('chats.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-users text-xs ml-2"></i>
                    نظارت بر چت کاربران
                </a>
            @endif

            @if(in_array(8 , $permission))

                <a href="{{route('identities.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-shield text-xs ml-2"></i>
                    احراز هویت
                </a>

            @endif

            @if(in_array(9 , $permission))

                <a href="{{route('mobiles.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-mobile text-xs ml-2"></i>
                    بازدید از شماره موبایل
                </a>
            @endif


            @if(in_array(10 , $permission))

                <a href="{{route('plans.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-box text-xs ml-2"></i>
                    پلن ها
                </a>
            @endif

            @if(in_array(15 , $permission))

                <a href="{{route('events.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-robot text-xs ml-2"></i>
                    رویداد های سیستمی
                </a>
            @endif

            @if(in_array(15 , $permission))

                <a href="{{route('invoice.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-wallet text-xs ml-2"></i>
                    پرداخت ها
                </a>
            @endif


            <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">سایت</p>

            @if(in_array(11 , $permission))

                <a href="{{route('banners.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-box text-xs ml-2"></i>
                    بنر ها
                </a>
            @endif

            @if(in_array(16 , $permission))
                <a href="{{route('features.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-tree text-xs ml-2"></i>
                    ویژگی ها
                </a>
            @endif


            @if(in_array(20 , $permission))
                <a href="{{route('upload.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-image text-xs ml-2"></i>
                    آپلود فایل
                </a>
            @endif

            @if(in_array(17 , $permission))
                <a href="{{route('pages.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-cog text-xs ml-2"></i>
                    صفحات جانبی
                </a>
            @endif

            @if(in_array(12 , $permission))
                <a href="{{route('settings.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-cog text-xs ml-2"></i>
                    تنظیمات
                </a>
            @endif


            <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">سئو</p>

            @if(in_array(18 , $permission))

                <a href="{{route('meta.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-box text-xs ml-2"></i>
                    متا صفحات
                </a>
            @endif
            @if(in_array(19 , $permission))

                <a href="{{route('article.index')}}"
                   class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-box text-xs ml-2"></i>
                    مقالات
                </a>
            @endif


        </div>
        <!-- end sidebar content -->

    </div>
    <!-- end sidbar -->

    <div class="bg-gray-100 flex-1 p-6 md:mt-16">
        @yield('body')
    </div>


</main>

</body>

@include('components.build')
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="{{asset('assets/js/jquery.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('assets/dashboard/js/scripts.js')}}"></script>

@include('message')
@yield('js')
<script>
    $('.delete-form').on('submit', function () {
        if (confirm('آیا از حذف اطلاعات اطمینان دارید ؟')) {
            return true;
        }
        return false;
    });
</script>

</html>
