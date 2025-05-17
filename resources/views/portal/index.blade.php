@extends('layouts.portal')
@section('navbar')
    <li class="list-inline-item">صفحه نخست</li>
@endsection
@section('body')
    <section class="content my-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white flex gap-3 rounded-md shadow-sm">
                <div class="w-1/4 p-5 rounded-r-md {{Auth::user()->confirm_identity ? ' bg-green-500 ' : ' bg-custom-900 '}} text-center flex justify-center items-center">
                    <i class="fal fa-user text-5xl text-white"></i>
                </div>
                <div class="w-3/4 p-5">
                    <p class="text-sm text-gray-900">{{Auth::user()->name}} </p>
                    @if(Auth::user()->confirm_identity)
                        <p class="flex items-center gap-1 mt-2">
                                <span class="text-[9px] bg-green-500 py-[2px] text-white rounded-full px-2">
                                    <i class="fal fa-check text-white mt-[2px] ml-1"></i>
                                    احراز شده </span>
                        </p>
                    @else
                        <p class="flex items-center gap-1 mt-2">
                                <span class="text-[9px] bg-red-400 py-[2px] text-white rounded-full px-2">
                                    <i class="fal fa-ban text-white mt-[2px] ml-1"></i>
                                    احراز نشده </span>
                        </p>
                    @endif
                    <a href="{{route('portal.profile')}}"
                       class="flex items-center gap-2 text-xs font-bold {{Auth::user()->confirm_identity ? ' text-green-500 ' : ' text-custom-900 '}} mt-2">
                        مشاهده پروفایل کاربری
                        <i class="fal fa-angle-left {{Auth::user()->confirm_identity ? ' text-green-500 ' : ' text-custom-900 '}} text-[15px]"></i>
                    </a>
                </div>
            </div>

            @if(Auth::user()->account ==  'seller')

                <div class="bg-white flex gap-3 rounded-md shadow-sm">
                    <div class="w-1/4 p-5 rounded-r-md bg-green-800 text-center flex justify-center items-center">
                        <i class="fal fa-box text-5xl text-white"></i>
                    </div>
                    <div class="w-3/4 p-5">
                        <p class="text-sm text-gray-900">محصولات شما </p>
                        <p class="flex items-center gap-1 mt-1">
                        <p class="flex items-center gap-1 mt-1">
                                <span class="text-[11px]">
                                    @if($products == 0)
                                        شما محصولی ثبت نکرده اید
                                    @else
                                        {{$products}}
                                        محصول ثبت شده است
                                    @endif
                                </span>
                        </p>
                        </p>
                        <a href="{{route('portal.product.store')}}"
                           class="flex items-center gap-2 text-xs text-green-800 mt-2  font-bold">
                            بارگذاری محصول جدید
                            <i class="fal fa-angle-left text-green-800 text-[15px]"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white flex gap-3 rounded-md shadow-sm">
                    <div class="w-1/4 p-5 rounded-r-md bg-blue-900 text-center flex justify-center items-center">
                        <i class="fal fa-users text-5xl text-white"></i>
                    </div>
                    <div class="w-3/4 p-5">
                        <p class="text-sm text-gray-900">درخواست خریداران </p>
                        <p class="flex items-center gap-1 mt-1">
                        <p class="flex items-center gap-1 mt-1">
                            <span class="text-[11px]">
                                @if($requests == 0)
                                    درخواست خریدی تا کنون ثبت نشده است
                                @else
                                    {{$requests}}+
                                    درخواست خرید
                                @endif

                            </span>
                        </p>
                        </p>
                        <a href="{{route('portal.request.list')}}"
                           class="flex items-center gap-2 text-xs text-blue-900 mt-2  font-bold">
                            مشاهده خریدارن
                            <i class="fal fa-angle-left text-blue-900 text-[15px]"></i>
                        </a>
                    </div>
                </div>


            @else


                <div class="bg-white flex gap-3 rounded-md shadow-sm">
                    <div class="w-1/4 p-5 rounded-r-md bg-blue-900 text-center flex justify-center items-center">
                        <i class="fal fa-users text-5xl text-white"></i>
                    </div>
                    <div class="w-3/4 p-5">
                        <p class="text-sm text-gray-900">  زاندس بزرگترین بازار معاملاتی</p>
                        <p class="flex items-center gap-1 mt-1">
                        <p class="flex items-center gap-1 mt-1">
                            <span class="text-[11px]">
                                    1000 +
                                    درخواست فروش
                            </span>
                        </p>
                        </p>
                        <a href="{{route('home')}}"
                           class="flex items-center gap-2 text-xs text-blue-900 mt-2  font-bold">
                            مشاهده فروشندگان
                            <i class="fal fa-angle-left text-blue-900 text-[15px]"></i>
                        </a>
                    </div>
                </div>


                <div class="bg-white flex gap-3 rounded-md shadow-sm">
                    <div class="w-1/4 p-5 rounded-r-md bg-yellow-500 text-center flex justify-center items-center">
                        <i class="fal fa-users text-5xl text-white"></i>
                    </div>
                    <div class="w-3/4 p-5">
                        <p class="text-sm text-gray-900">درخواست های خرید شما </p>
                        <p class="flex items-center gap-1 mt-1">
                        <p class="flex items-center gap-1 mt-1">
                            <span class="text-[11px]">
                                @if(count($requests_user) == 0)
                                    درخواست خریدی تا کنون ثبت نشده است
                                @else
                                    {{count($requests_user)}}
                                    درخواست خرید
                                @endif
                            </span>
                        </p>
                        </p>
                        <a href="{{route('portal.request.store')}}"
                           class="flex items-center gap-2 text-xs text-yellow-500 mt-2  font-bold">
                            مدیریت درخواست ها
                            <i class="fal fa-angle-left text-yellow-500 text-[15px]"></i>
                        </a>
                    </div>
                </div>



            @endif


        </div>
    </section>


    <section class="content my-5">
        <div class="grid grid-cols-1 md:grid-cols-4 sm:gap-5">
            <div class="md:col-span-2">
                <div class="bg-white p-5 rounded-md shadow-sm">
                    <p class="text-sm"> لیست آخرین پیام ها </p>
                    @if(count($chats) > 0)
                        <div class="messages mt-3">
                            @foreach($chats as $value)
                                <div class="message-box mt-2 bg-white border border-gray-200 p-3 rounded-md">
                                    <a href="{{route('portal.chat')}}" class="flex">
                                        <div class="w-2/12">
                                            @if($value->user && $value->user->info && !is_null($value->user->info->profile_pic))
                                                <img src="{{url($value->user->info->profile_pic)}}"
                                                     class="w-12 h-12 rounded-full mx-auto">
                                            @else
                                                <img src="{{asset('assets/portal/img/user-none.png')}}"
                                                     class="w-12 h-12 rounded-full mx-auto">
                                            @endif
                                        </div>
                                        <div class="box w-10/12">
                                            <div class="flex justify-between items-center">
                                                <div class="user text-sm text-bold text-gray-800">
                                                    {{$value->user ? $value->user->name : null}}
                                                </div>
                                                <div class="date">
                                                    <p class="text-gray-700 text-[11px]">
                                                        {{verta($value->created_at)->format('Y/m/d H:i')}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text mt-2">
                                                <p class="text-xs text-justify text-gray-600 leading-6 font-small">
                                                    {{$value->message}}
                                                </p>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="messages mt-3">
                            <img class="w-[100px] mx-auto mt-2" src="{{asset('assets/portal/img/empty.svg')}}" alt="">
                            <p class="text-center mt-2 text-gray-500">صندق ورودی شما خالی میباشد </p>
                        </div>
                    @endif
                </div>
            </div>
            @if(Auth::user()->account ==  'seller')
                <div class="col-span-2">
                    <div class="bg-white p-5 rounded-md shadow-sm sm:mt-0 mt-2">
                        <div class="text-sm"> مشاهده آخرین درخواست های خریداران

                            <a href="{{route('portal.request.list')}}"
                               class="float-left text-xs text-blue-900 flex items-center">
                                مشاهده همه
                                <i class="fal fa-angle-left mr-2"></i>
                            </a>
                        </div>

                        <div class="list-buy mt-3">
                            @foreach($requests_items as $value)
                                <div class="item mt-3">
                                    <a href="{{route('portal.request.list')}}">
                                        <div class="item border-r-4 border-blue-900 px-2 shadow-md p-4">
                                            <p class="text-xs text-gray-800">
                                                <i class="fa fa-user-circle text-gray-400"></i>
                                                {{$value->user->name}}
                                                <small class="text-[9px] my-0 float-left"> {{verta($value->created_at)->formatDifference()}} </small>
                                            </p>
                                            <p class=" text-sm mt-2">
                                                <span class="text-gray-800"> خریدار </span>

                                                <strong class="text-dark"> {{unit_calculate($value->inventory , $value->category->unit)}} </strong>

                                                <strong class="text-dark"> {{$value->category ? $value->category->title : 'نامعلوم'}} </strong>
                                                <span class="text-gray-800"> از نوع </span>
                                                <strong class="text-dark">{{$value->type}} </strong>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            @else
                <div class="col-span-2">
                    <div class="bg-white p-5 rounded-md shadow-sm mt-3">
                        <div class="text-sm"> مدیریت درخواست های شما

                            <a href="{{route('portal.request.store')}}"
                               class="float-left text-xs text-blue-900 flex items-center">
                                مشاهده همه
                                <i class="fal fa-angle-left mr-2"></i>
                            </a>
                        </div>

                        @if(count($requests_user) > 0)
                            <div class="list-buy mt-3 grid grid-cols-1 gap-3">
                                @foreach($requests_user as $value)

                                    <div class="item border border-gray-200 shadow-sm p-5 rounded-md">
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
                                        </p>
                                    </div>

                                @endforeach
                            </div>
                        @else
                            <div class="messages mt-3">
                                <img class="w-[100px] mx-auto mt-2" src="{{asset('assets/portal/img/in_process_buyad.svg')}}" alt="">
                                <p class="text-center mt-2 text-gray-500">هنوز درخواستی ثبت نکرده اید </p>
                            </div>
                        @endif
                    </div>

                </div>

            @endif
        </div>
    </section>

@endsection
@section('js')

@endsection
