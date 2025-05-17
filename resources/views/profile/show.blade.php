@extends('layouts.front')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
@endsection
@section('body')

    <section class="max-w-6xl mx-auto pt-6 md:pt-5 px-5">
        <div class="rounded-xl">
            <div class="user-name-profile text-center p-3 sm:p-5 rounded-lg relative">
                @if($user->info->profile_pic)
                    <img src="{{url($user->info->profile_pic)}}"
                         class="w-24 h-24 rounded-full shadow-lg mx-auto ring-8 ring-white">
                @else
                    <img src="{{url('assets/img/user-defult.png')}}"
                         class="w-24 h-24 rounded-full shadow-lg mx-auto ring-8 ring-white">
                @endif
                <p class="mt-4 bg-white rounded-full px-3 py-1 text-sm w-auto mx-auto" style="max-width: max-content">
                    <span> 👋 سلام </span>
                    <strong> {{$user->name}} </strong>
                    <span> هستم </span>
                </p>
                @if($user->vip_account)
                    <button class="absolute bg-yellow-500 rounded-full text-xs px-2 py-1 text-white top-5 left-5 flex items-center gap-2">
                        <i class="fa fa-medal text-white"></i>
                        @if($user->account == 'buyer')
                            خریدار
                        @else
                            فروشنده
                        @endif
                        برتر
                    </button>
                @endif
                @if(Auth::check())
                    <button onclick="selectUser({{$user->id}} , '{{$user->full_name}}')"
                            class="absolute bg-blue-500 rounded-full text-xs px-3 py-2 text-white bottom-5 left-5 flex items-center gap-2">
                        <i class="fa fa-comment text-white"></i>
                        ارسال پیام
                    </button>
                @else
                    <a href="{{route('login')}}"
                       class="absolute bg-blue-500 rounded-full text-xs px-3 py-2 text-white bottom-5 left-5 flex items-center gap-2">
                        <i class="fa fa-comment text-white"></i>
                        ارسال پیام
                    </a>
                @endif

            </div>
            <div class="user-detail-profile border rounded-lg p-3 mt-5 sm:p-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="some-detail sm:border-l border-gray-300">
                        <ul class="grid gap-2">
                            <li class="text-sm">
                                <i class="fa fa-globe mx-1 text-gray-500"></i>
                                <span class="text-gray-500"> آدرس :  </span>
                                <span class="text-black">{{$user->info->address}}</span>
                            </li>
                            <li class="text-sm">
                                <i class="fa fa-user-circle mx-1 text-gray-500"></i>
                                <span class="text-gray-500"> نوع حساب :  </span>
                                @if($user->info->account_type == 'personal')
                                    <span class="text-black">حقیقی</span>
                                @else
                                    <span class="text-black">حقوقی</span>
                                @endif
                            </li>
                            @if($user->info->account_type == 'company')
                                <li class="text-sm">
                                    <i class="fa fa-barcode mx-1 text-gray-500"></i>
                                    <span class="text-gray-500"> شماره ثبت :  </span>
                                    <span class="text-black">{{$user->info->company_number}}</span>
                                </li>
                            @endif
                            <li class="text-sm">
                                <i class="fa fa-clock mx-1 text-gray-500"></i>
                                <span class="text-gray-500"> زمان فعالیت در
                                    {{config('app.name_fa')}}
                                    از
                                    :
                                    </span>
                                <span class="text-black">{{verta($user->created_at)->formatDifference()}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="some-detail">
                        <ul class="grid gap-2">
                            <li class="text-sm flex items-center gap-3">
                                <span class="text-gray-500">
                                    <i class="fa fa-star mx-1 text-gray-500"></i>
                                    امتیاز  : </span>
                                @if($user->info->score > 0)
                                    <div class="starts-rate flex gap-1">
                                        @for($i = 0;$i < $user->info->score;$i++)
                                            <i class="fa fa-star text-yellow-500 text-sm"></i>
                                        @endfor
                                        @for($i = 0;$i < 5 - $user->info->score;$i++)

                                            <i class="fal fa-star text-yellow-500 text-sm"></i>
                                        @endfor
                                        @if($user->info->comments > 0)
                                            <span class="text-gray-800">
                                            {{$user->info->comments}}
                                            نظر
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span> امتیازی برای کاربر ثبت نشده است </span>
                                @endif
                            </li>
                            <li class="text-sm">
                                <i class="fa mx-1 fa-user text-gray-500"></i>
                                <span class="text-gray-500"> نوع اکانت :  </span>
                                @if($user->account == 'buyer')
                                    <span class="text-black">خریدار در
                                    {{config('app.name_fa')}}
                                    </span>
                                @else
                                    <span class="text-black">فروشنده در
                                        {{config('app.name_fa')}}
                                    </span>
                                @endif
                            </li>
                            @if($user->confirm_identity)
                                <li class="text-sm">
                                    <i class="fa mx-1 fa-shield text-gray-500"></i>
                                    <span class="text-gray-500"> احراز هویت : </span>
                                    <i class="fa fa-shield text-green-900"></i>
                                    <span class="text-green-900">احراز شده</span>
                                </li>
                            @else
                                <li class="text-sm">
                                    <i class="fa mx-1 fa-shield text-gray-500"></i>
                                    <span class="text-gray-500"> احراز هویت : </span>
                                    <i class="fa fa-shield text-red-500"></i>
                                    <span class="text-red-500">احراز نشده</span>
                                </li>
                            @endif


                        </ul>
                    </div>

                </div>
            </div>
            <div class="user-detail-profile border rounded-lg p-3 mt-5 sm:p-5">
                <p class="text-md text-sm font-semibold"> درباره فعالیت و کسب کار </p>
                <p class="mt-3 text-justify text-sm leading-8">
                    {{$user->info->description}}
                </p>
            </div>
            @if(count($products) > 0)
                <div class="user-detail-profile border rounded-lg p-3 mt-5 sm:p-5">
                    <p class="text-md text-sm font-semibold"> محصولات </p>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-5 mt-3">
                        @foreach($products as $value)
                            @include('components.product.card' , ['product' => $value])
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="comments">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="sm:col-span-2 user-detail-profile border rounded-lg p-3 mt-5 sm:p-5">
                        <p class="text-md text-sm font-semibold"> نظرات </p>

                        <div class="mt-3 grid gap-3 max-h-[350px] overflow-y-auto comments-list">
                            @if(count($comments) > 0)
                                @foreach($comments as $value)
                                    @include('components.profile.comment' , ['comment' => $value])
                                @endforeach
                            @else
                                <div class="empty">
                                    <img class="mx-auto" src="{{asset('assets/portal/img/empty.svg')}}">
                                    <p class="text-gray-400 text-center mt-3 text-xs"> نظری هنوز ثبت نشده است</p>
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="comments-store">
                        <div class="user-detail-profile border rounded-lg p-3 mt-5 sm:p-5">
                            <p class="text-md text-sm font-semibold"> ثبت نظر </p>
                            @include('components.profile.comment_store')
                        </div>
                    </div>
                </div>
            </div>
            @if(count($user->certificate) > 0)
                <div class="user-detail-profile border rounded-lg p-3 mt-5 sm:p-5">
                    <p class="text-md text-sm font-semibold"> گواهینامه ها </p>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-5 mt-3">
                        @foreach($user->certificate as $val)
                            <div class="item">
                                <a href="{{url($val->path)}}" data-fancybox="certificate" data-caption="گواهینامه ها">
                                    <div style="background-image: url('{{url($val->path)}}');background-position: center;background-size: cover"
                                         class="h-[200px] w-full rounded-md"></div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if(count($user->photos) > 0)
                <div class="user-detail-profile border rounded-lg p-3 mt-5 sm:p-5">
                    <p class="text-md text-sm font-semibold"> تصاویر مرتبط </p>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-5 mt-3">
                        @foreach($user->photos as $val)
                            <div class="item">
                                <a href="{{url($val->path)}}" data-fancybox="gallery" data-caption="تصاویر مرتبط">
                                    <div style="background-image: url('{{url($val->path)}}');background-position: center;background-size: cover"
                                         class="h-[200px] w-full rounded-md"></div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    </section>

    @if(Auth::check())
        @include('components.chat.box')
    @endif
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>Fancybox.bind()</script>
    <script>
        $(document).ready(function () {
            $('.start-set').hover(function () {
                var val_star = $(this).data('value');
                $('.start-set').removeClass('text-yellow-500').addClass('text-gray-300');
                for (var i = val_star; i >= 1; i--) {
                    $('.val-' + i).removeClass('text-gray-300').addClass('text-yellow-500');
                }
                $('input[name=rate]').val(val_star);
            });

            $('.start-set').click(function () {
                $('.dropdown-store-comment').slideDown();
            });
        });
    </script>
@endsection
