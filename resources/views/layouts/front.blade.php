<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    @if(!is_null($meta))
        <title>{{$meta->title}}</title>
        <meta name="description" content="{{$meta->description}}"/>
        <link rel="canonical" href="{{$full_url}}"/>
        <meta property="og:locale" content="fa_IR"/>
        <meta property="og:title"
              content="{{$meta->og_title}}"/>
        <meta property="og:description"
              content="{{$meta->og_description}}"/>
        <meta property="og:url" content="{{$full_url}}"/>
        <meta property="og:image" content="{{$meta->og_image}}"/>
        @if($meta->can_index == 0)
            <meta name="robots" content="noindex,nofollow">
        @else
            <meta name="robots" content="index,follow">
        @endif
        @if(!is_null($meta->structured_data) && $meta->structured_data != '')
            <script type="application/ld+json">
                @php
                    echo $meta->structured_data
                @endphp
            </script>
        @endif
    @else
        @hasSection('meta')
            @yield('meta')
        @else
            <title>زاندس</title>
            <meta name="description" content="زاندس"/>
            <link rel="canonical" href="{{$full_url}}"/>
            <meta property="og:locale" content="fa_IR"/>
            <meta property="og:type" content="store"/>
            <meta property="og:title"
                  content="زاندس"/>
            <meta property="og:description"
                  content="زاندس"/>
            <meta property="og:url" content="{{$full_url}}"/>
        @endif

    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <meta name="csrf" content="{{csrf_token()}}">
    <meta name="base_url" content="{{url('/')}}/">
    <link rel="icon" type="image/png" href="{{url('assets/img/fav-icon.png')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css?ver=1.9')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome/css/all.min.css')}}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{asset('assets/js/config.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "q31unmr1dp");
    </script>
    @yield('style')
</head>

<body dir="rtl" class="min-h-screen dark:bg-black">
<div class="space h-[50px] sm:h-[120px]"></div>

<header class="bg-white fixed top-0 dark:bg-black shadow-sm  dark:border-gray-800 right-0 left-0 top-0 z-30">

    <nav class="py-2 px-2 sm:px-5 mx-auto p-2 block sm:flex justify-between items-center">
        <div class="right gap-1 flex sm:gap-3 items-center justify-between">
            {{--            <div class="icon-bar hidden sm:block">--}}
            {{--                <i class="fal fa-bars text-2xl mt-1 block md:hidden"></i>--}}
            {{--            </div>--}}
            <div class="logo">
                <a href="{{url('/')}}">
                    <img src="{{asset('assets/img/logo.png?ver=1.2')}}" class="w-logo w-[120px] sm:w-[250px]"
                         alt="لوگو"/>
                </a>
            </div>

            <div class="search-header w-full">
                @include('components.search_header')
            </div>
        </div>
        <div class="left hidden sm:block">
            <ul class="block sm:flex items-center gap-2">

                <li class="text-sm text-gray-500  dark:text-white">
                    <a href="{{route('buy-req')}}"
                       class="font-medium px-2 py-3 text-md rounded-md text-black">
                        <i class="fa fa-users  text-black"></i>
                        خریدران
                    </a>
                </li>

                <li class="text-sm text-gray-500  dark:text-white">
                    <a href="{{route('product.all')}}"
                       class="font-medium px-2 py-3 text-md rounded-md text-black">
                        <i class="fa fa-box text-black"></i>
                        فروشندگان
                    </a>
                </li>

                @if(!Auth::check())

                    <li class="text-sm text-gray-500  dark:text-white">
                        <a href="{{route('login')}}"
                           class="font-medium bg-custom-900 px-4 py-3 text-md rounded-md text-white">
                            <i class="fal fa-user-plus ml-2 text-white"></i>
                            ورود / ثبت نام

                        </a>
                    </li>

                @else
                    <li class="text-sm text-gray-500  dark:text-white">
                        <a href="{{route('panel')}}"
                           class="font-medium bg-custom-900 px-4 py-3 text-md rounded-md text-white">
                            <i class="fa fa-dashboard ml-2 text-white"></i>
                            {{Auth::user()->name}}
                        </a>
                    </li>
                @endif


            </ul>
        </div>
    </nav>
    <nav class="py-0 sm:py-2 px-1 sm:px-5 mx-auto p-2 block sm:mr-[25px] nav-2">

        <div class="bottom menu-bar hidden sm:block">
            <ul class="block sm:flex items-center gap-5">
                <li class="text-md font-medium text-gray-800">
                    <i class="fal fa-home"></i>
                    <a href="{{url('/')}}">خانه</a>
                </li>
                <li class="text-md font-medium text-gray-800 ml-3 flex items-center">
                    <div class="cd-dropdown-wrapper">
                        <a class="cd-dropdown-trigger" href="#0">محصولات</a>
                        @include('components.menu' , ['categories' => $categories])
                    </div>
                </li>
                <li class="text-md font-medium text-gray-800">
                    <a href="{{route('contact')}}">ارتباط با ما</a>
                </li>
                <li class="text-md font-medium text-gray-800">
                    <a href="{{route('about')}}">درباره ما</a>
                </li>
                <li class="text-md font-medium text-gray-800">
                    <a href="{{route('privacy')}}">قوانین و مقررات</a>
                </li>
            </ul>

        </div>
    </nav>
</header>

@include('components.menu' , ['categories' => $categories])


<main class="min-h-screen" id="top">
    @yield('body')

</main>

<div class="block sm:hidden mobile-tool-bar bg-blue-900 p-3 fixed bottom-0 left-0 right-0 z-50">
    <ul class="grid grid-cols-5 gap-1 justify-between items-center">
        <li>
            <a href="{{route('home')}}">
                <div class="grid justify-center items-center">
                    <i class="fal fa-home text-xl text-white mx-auto"></i>
                    <span class="text-white text-xs">خانه</span>
                </div>
            </a>
        </li>
        <li class="">
            <button onclick="$('.cd-dropdown-trigger').click()">
                <div class="grid justify-center items-center">
                    <i class="fal fa-box text-xl text-white mx-auto"></i>
                    <span class="text-white text-xs">محصولات</span>
                </div>
            </button>
        </li>


        <li>
            <a href="{{route('portal.product.store')}}">
                <div class="grid justify-center items-center">
                    <i class="fa fa-plus text-xl mx-auto bg-white text-blue-900 w-[45px] h-[45px] border-2 border-blue-900 -mt-[30px] flex justify-center items-center rounded-full"></i>
                    <span class="text-white text-xs mt-[11px]">ثبت محصول</span>

                </div>
            </a>
        </li>
        <li>
            <a href="{{route('portal.request.list')}}">
                <div class="grid justify-center items-center">
                    <i class="fal fa-users text-xl text-white mx-auto"></i>
                    <span class="text-white text-xs">خریدارن</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{route('panel')}}">
                <div class="grid justify-center items-center">
                    @auth
                        <i class="fal fa-dashboard text-xl text-white mx-auto"></i>
                        <span class="text-white text-xs">ناحیه کاربری</span>
                    @else
                        <i class="fal fa-dashboard text-xl text-white mx-auto"></i>
                        <span class="text-white text-xs">ورود / ثبت نام</span>
                    @endauth
                </div>
            </a>
        </li>
    </ul>
</div>

<div class="category-select hidden">

    <div class="items">
        <div class="category-head border-b border-gray-100 flex justify-between">
            <p class="text-sm text-gray-500 flex items-center gap-3">
                <i
                        class="fal fa-check w-5 h-5 rounded-full text-white flex items-center justify-center p-3 bg-blue-900"></i>
                انتخاب دسته بندی
            </p>
            <button class="close-modal">
                <i class="fa fa-times text-red-500 text-xl"></i>
            </button>
        </div>
        <div class="category-content mt-3">
            <input class="search-category border rounded-md w-full px-3 py-2 text-sm"
                   placeholder="جستجو کنید (مثلا : برنج)...">
            <p class="mt-3 text-xs mr-1 text-gray-500">انتخاب از روی دسته بندی ها</p>
            <div class="prev-step-category mr-1 text-sm mt-2 flex gap-2 items-center hidden" data-step="child-0">
                <i class="fal fa-arrow-right text-blue-500"></i>
                <span class="text-blue-500 ">مرحله قبل</span>
            </div>
            <ul data-step="1" data-child="0" id="child-0" class="steps px-2 grid gap-2 mt-3 list-category">
                <li data-parent="0" data-id="1" have-child="true"
                    class="flex justify-between items-center cursor-pointer">
                    <span class=""> میوه </span>
                    <i class="fal fa-arrow-left text-gray-500"></i>
                </li>
                <li data-parent="0" data-id="2" have-child="true"
                    class="flex justify-between items-center cursor-pointer">
                    <span class=""> سبزیجات </span>
                    <i class="fal fa-arrow-left text-gray-500"></i>
                </li>
                <li data-parent="0" data-id="3" have-child="true"
                    class="flex justify-between items-center cursor-pointer">
                    <span class=""> خشکبار </span>
                    <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                </li>
                <li data-parent="0" data-id="4" have-child="true" class="flex justify-between items-center">
                    <span class=""> صیفی جات </span>
                    <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                </li>
                <li data-parent="0" data-id="5" have-child="true" class="flex justify-between items-center">
                    <span class=""> غلات </span>
                    <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                </li>
            </ul>

            <div class="items-child">
                <ul data-step="2" data-child="1" id="child-1"
                    class="steps hidden px-2 grid gap-2 mt-3 list-category">
                    <li data-parent="1" data-id="6" have-child="true"
                        class="flex justify-between items-center cursor-pointer">
                        <span class=""> خشکبار </span>
                        <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                    </li>
                    <li data-parent="1" data-id="7" have-child="true" class="flex justify-between items-center">
                        <span class=""> صیفی جات </span>
                        <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                    </li>
                    <li data-parent="1" data-id="8" have-child="true" class="flex justify-between items-center">
                        <span class=""> غلات </span>
                        <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                    </li>
                </ul>

                <ul data-step="2" data-child="6" id="child-6"
                    class="steps hidden px-2 grid gap-2 mt-3 list-category">
                    <li data-parent="6" data-id="9" have-child="true"
                        class="flex justify-between items-center cursor-pointer">
                        <span class=""> تست </span>
                        <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                    </li>
                    <li data-parent="6" data-id="10" have-child="true" class="flex justify-between items-center">
                        <span class=""> تست </span>
                        <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                    </li>
                    <li data-parent="6" data-id="11" have-child="true" class="flex justify-between items-center">
                        <span class=""> تست </span>
                        <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                    </li>
                </ul>

                <ul data-step="3" data-child="11" id="child-11"
                    class="steps hidden px-2 grid gap-2 mt-3 list-category">
                    <li data-parent="6" data-id="9" have-child="false"
                        class="flex justify-between items-center cursor-pointer">
                        <span class=""> الو </span>
                        <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                    </li>
                    <li data-parent="6" data-id="10" have-child="false" class="flex justify-between items-center">
                        <span class=""> الو </span>
                        <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                    </li>
                    <li data-parent="6" data-id="11" have-child="false" class="flex justify-between items-center">
                        <span class=""> الو </span>
                        <i class="fal fa-arrow-left text-gray-500 cursor-pointer"></i>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div class="modal-login hidden">
    <div class="form">

        <div class="flex justify-end">

            <button class="close-modal-login ml-2">
                <i class="fa fa-times text-red-500 text-xl"></i>
            </button>
        </div>
        <div class="modal-body">
            <img src="{{asset('assets/img/user-login.png')}}" class="w-16 mx-auto" alt=""/>
            <p class="text-center text-semibold"><b> ورود | ثبت نام</b></p>
            <p class="text-small text-center">
                <small class="text-gray-500">برای ورود یا ثبت نام در زاندس شماره موبایل خود را وارد کنید </small>
            </p>
            <div class="group mt-5">
                <div class="relative">
                    <input class="border pl-12 pr-4 py-2 border-gray-200 rounded-lg  w-full" dir="ltr"
                           placeholder="9********"/>
                    <span style="margin-top: 1px;left:1px"
                          class="absolute p-2 rounded-l-lg bg-gray-100 text-gray-600  top-0"
                          dir="ltr">+98</span>
                    <i class="fal fa-mobile absolute top-4 right-3"></i>
                </div>
                <div class="button mt-5">
                    <button class="bg-custom-900 w-full text-white p-2 rounded-md">ورود | ثبت نام</button>
                </div>
            </div>

        </div>
        <div class="modal-body hidden">
            <img src="./img/sms-code.svg" class="w-16 mx-auto" alt=""/>
            <p class="text-center text-semibold"><b> وارد کردن کد ورود </b></p>
            <p class="text-small text-center">
                <small class="text-gray-500">
                    کد ارسالی به شماره موبایل :
                    <strong class="'font-semibild"></strong>
                    وارد کنید
                </small>
            </p>
            <p class="text-small text-center">
                <button class="text-gray-500 text-xs">
                    <i class="fal fa-arrow-right ml-2"></i>
                    <span> شماره موبایل را اشتباه وارد کردید </span>
                </button>
            </p>
            <div class="group flex justify-center gap-5 mt-3" dir="ltr">
                <input autofocus class="w-10 text-center h-10 border border-gray-300 rounded-md code-input"
                       maxlength="1" name="code[1]">
                <input class="w-10 text-center h-10 border border-gray-300 rounded-md code-input" maxlength="1"
                       name="code[2]">
                <input class="w-10 text-center h-10 border border-gray-300 rounded-md code-input" maxlength="1"
                       name="code[3]">
                <input class="w-10 text-center h-10 border border-gray-300 rounded-md code-input" maxlength="1"
                       name="code[4]">
            </div>
            <div class="role text-center">
                <p class="text-xs text-gray-800 mt-3 text-center">
                    هرگونه ثبت نام یا ورود به معنای پذیرش
                    <a href="" target="_blank" class="text-xs text-custom-900"> قوانین و مقررات </a>
                    زاندس میباشد
                    .
                </p>
            </div>
        </div>

    </div>
</div>

<footer class=" p-5 bg-gray-50 mt-10">
    <div class="max-w-6xl mx-auto">
        <div class="feature border-b">
            <div class="grid grid-cols-2 md:grid-cols-4">
                <div class="text-center mb-3">
                    <i class="fal fa-headphones text-gray-700 text-4xl"></i>
                    <p class="text-gray-800 mt-3  w-fit mx-auto rounded-md px-2 py-1 font-semibold text-xs">
                        پشتیبانی بر خط </p>
                </div>
                <div class="text-center mb-3">
                    <i class="fal fa-flag text-gray-700 text-4xl"></i>
                    <p class="text-gray-800 mt-3  w-fit mx-auto rounded-md px-2 py-1 font-semibold text-xs">
                        بازار فروش محصولات </p>
                </div>
                <div class="text-center mb-3">
                    <i class="fal fa-comments text-gray-700 text-4xl"></i>
                    <p class="text-gray-800 mt-3  w-fit mx-auto rounded-md px-2 py-1 font-semibold text-xs">
                        ارتباط مستقیم با خریداران </p>
                </div>
                <div class="text-center mb-3">
                    <i class="fal fa-users text-gray-700 text-4xl"></i>
                    <p class="text-gray-800 mt-3  w-fit mx-auto rounded-md px-2 py-1 font-semibold text-xs">
                        خانواده چندین هزار نفری </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 mt-4">
            <div class="item-1">
                <p class="text-lg">
                    زاندس
                </p>
                <ul class="grid items-center gap-2 justify-start mr-3  text-gray-900 text-sm my-5">
                    <li>
                        <a href="{{route('about')}}">
                            <i class="fal fa-angle-left"></i>
                            درباره زاندس
                        </a>
                    </li>

                    <li>
                        <a href="{{route('contact')}}">
                            <i class="fal fa-angle-left"></i>
                            تماس با ما
                        </a>
                    </li>
                    <li>
                        <a href="{{route('privacy')}}">
                            <i class="fal fa-angle-left"></i>
                            قوانین و مقررات
                        </a>
                    </li>
                    <li>
                        <a href="{{route('buy-req')}}">
                            <i class="fal fa-angle-left"></i>
                            خریداران
                        </a>
                    </li>
                    <li>
                        <a href="https://blog.zandes.ir">
                            <i class="fal fa-angle-left"></i>
                            مقالات
                        </a>
                    </li>
                    <li>
                        <a href="{{route('app')}}">
                            <i class="fal fa-angle-left"></i>
                            اپلیکیشن
                        </a>
                    </li>
                </ul>
            </div>
            <div class="item-2">


                <p class="text-lg">
                    فروشندگان
                </p>

                <ul class="grid items-center gap-2 justify-start mr-3  text-gray-900 text-sm my-5">
                    @foreach($page_r as $value)
                        <li>
                            <a href="{{route('page' , $value->id)}}">
                                <i class="fal fa-angle-left"></i>
                                {{$value->title}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="item-3 ">
                <p class="text-lg">
                    خریداران
                </p>
                <ul class="grid items-center gap-2 justify-start mr-3  text-gray-900 text-sm my-5">
                    @foreach($page_b as $value)
                        <li>
                            <a href="{{route('page' , $value->id)}}">
                                <i class="fal fa-angle-left"></i>
                                {{$value->title}}
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
            <div class="item-4 col-span-2 md:col-span-1">
                <p class="text-md text-right sm:text-center">ما را در شبکه های اجتماعی دنبال کنید!
                </p>
                <ul class="flex gap-5 items-center gap-3 md:gap-5 justify-center text-gray-400 mt-5 text-2xl">
                    <li>
                        <a href="{{$telegram->value}}" target="_blank">
                            <i class="fab fa-telegram text-gray-600"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{$twitter->value}}" target="_blank">
                            <i class="fab fa-twitter text-gray-600"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{$instagram->value}}" target="_blank">
                            <i class="fab fa-instagram text-gray-600"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{$whatsapp->value}}" target="_blank">
                            <i class="fab fa-whatsapp text-gray-600"></i>
                        </a>
                    </li>
                </ul>
                <div class="text-center justify-center flex">

                    <a referrerpolicy='origin' target='_blank'
                       href='https://trustseal.enamad.ir/?id=469422&Code=HxguGDyHnOuPXcj2OmmVBEcDnITxR4tr'><img
                                referrerpolicy='origin'
                                src='https://trustseal.enamad.ir/logo.aspx?id=469422&Code=HxguGDyHnOuPXcj2OmmVBEcDnITxR4tr'
                                alt='' style='cursor:pointer;zoom: 0.8' Code='HxguGDyHnOuPXcj2OmmVBEcDnITxR4tr'></a>

                </div>
            </div>
            <div class="col-span-2 sm:col-span-4 mt-3 ">
                <div class=" border-t">
                    <p class="text-sm mt-3 text-gray-500 font-semibold">
                        <i class="fa fa-info-circle text-custom-500"></i>

                        <span class="mx-1"> زاندس را بیشتر بشناسید </span>

                    </p>
                    <p class="text-xs text-gray-500 mt-3 leading-8" style="text-align: justify">
                        {{$footer_text->value}}
                    </p>
                </div>
            </div>
        </div>


        <div class="copy-right mt-3 sm:bg-custom-900 rounded-full items-center justify-center block md:flex sm:p-3 w-full">

            <p class="text-xs text-center text-gray-900 sm:text-white">
                <i class="fas fa-copyright text-gray-500 sm:text-white text-center sm:text-right"></i>
                تمامی حقوق وب سایت متعلق به
                <a class="text-gray-500 sm:text-white" href="">
                    (زاندس)
                    zandes
                </a>
                می باشد.
            </p>

            {{--            <p class="text-xs text-center text-gray-900 text-white mt-2 sm:mt-0">--}}
            {{--                <span class="text-xs text-gray-500 sm:text-white"> طراحی و توسعه توسط : </span>--}}

            {{--                <a href="https://armis-web.com"--}}
            {{--                   class="text-white bg-custom-900 rounded-full px-3 py-1 font-semibold" target="_blank">--}}
            {{--                    آرمیس وب--}}
            {{--                </a>--}}
            {{--            </p>--}}

        </div>
    </div>
    <div class="space-bottom h-[60px] block sm:hidden"></div>
</footer>
</body>

@include('components.build')
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="{{asset('assets/js/jquery.min.js')}}" type="text/javascript"></script>
<script src="https://unpkg.com/typeit@8.7.1/dist/index.umd.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('assets/js/jquery.menu-aim.js?ver=1.2')}}"></script>
<script src="{{asset('assets/js/mega-menu.js?ver=1.2')}}"></script>
<script defer src="{{asset('assets/js/main.js?ver=1.9')}}"></script>

@include('message')
@yield('js')
@yield('jss')
<script>
    $(document).ready(function () {
        $('.cd-dropdown-content').mouseleave(function () {
            var navIsVisible = false;
            $('.cd-dropdown').toggleClass('dropdown-is-active', navIsVisible);
            $('.cd-dropdown-trigger').toggleClass('dropdown-is-active', navIsVisible);
            if (!navIsVisible) {
                $('.cd-dropdown').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                    $('.has-children ul').addClass('is-hidden');
                    $('.move-out').removeClass('move-out');
                    $('.is-active').removeClass('is-active');
                });
            }
        });

    });
</script>
<script type="text/javascript">
    !function(){var i="sJr9Aa",a=window,d=document;function g(){var g=d.createElement("script"),s="https://www.goftino.com/widget/"+i,l=localStorage.getItem("goftino_"+i);g.async=!0,g.src=l?s+"?o="+l:s;d.getElementsByTagName("head")[0].appendChild(g);}"complete"===d.readyState?g():a.attachEvent?a.attachEvent("onload",g):a.addEventListener("load",g,!1);}();
</script>
</html>
