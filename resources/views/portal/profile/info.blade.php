@extends('layouts.portal')
@section('css')
    <link href="{{asset('assets/portal/plugins/upload/upload.css')}}" rel="stylesheet">
@endsection
@section('body')

    <section class="content my-5">
        <div class="relative overflow-x-auto rounded-md">
            <div class="bg-white p-5">
                <h2 class="text-right my-2 text-sm text-gray-800">
                    <strong style="font-size: 15px" class="text-gray-600">ویرایش اطلاعات کاربری</strong>
                </h2>
                <hr/>
                @if(!$user->confirm_identity)
                    <div class="bg-gray-100 text-gray-200 text-sm p-2 mt-2 flex justify-between items-center rounded-md px-3">
                        <span class="text-red-500 text-sm">
                            <i class="fa fa-warning text-red-500"></i>
                            کاربر گرامی برای جلب اعتماد در معالات خود احراز هویت کنید </span>
                        <a class="bg-blue-500 rounded-md px-4 py-1 text-black text-white text-xs" href="">
                            <i class="fa fa-shield text-white"></i>
                            احراز هویت
                        </a>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-10 mt-2 gap-5">
                    <div class="sm:col-span-4 items border-2 border-gray-100 rounded-md p-3">
                        @if(is_null($user->info->profile_pic))
                            <div class="text-center">
                                <img class="w-[80px] image-profile mx-auto cursor-pointer"
                                     src="{{asset('assets/img/male.png')}}">
                                <div id="profile_pic"></div>
                            </div>
                        @else
                            <div class="text-center">
                                <img class="w-[80px] image-profile mx-auto cursor-pointer"
                                     src="{{url($user->info->profile_pic)}}">
                                <div id="profile_pic"></div>
                            </div>
                        @endif
                    </div>

                    <div class="sm:col-span-6 items border-2 border-gray-100 rounded-md p-3">
                        <form method="post" action="{{route('portal.profile.update.mobile.check')}}">
                            @csrf
                            <h3 class="text-gray-900">
                                اطلاعات شما
                                <hr class="w-[90px] h-[3px] bg-blue-500"/>
                            </h3>
                            <div class="form mt-3 w-full">
                                <label> <small>شماره موبایل :</small>
                                    <span>  {{$user->mobile}} </span>
                                </label>
                                <div class="mobile flex items-center justify-center gap-3 mt-1">

                                    <input class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm"
                                           type="number" name="mobile"
                                           placeholder="درصورت نیاز شماره موبایل جدید خود را وارد کنید">
                                    <div class="confirm">
                                        <button type="button"
                                                class="btn w-[120px] bg-green-500 rounded-sm px-2 py-[10px] text-white text-sm change-mobile">
                                            ارسال کد تایید
                                        </button>
                                    </div>
                                </div>

                                <div class="mobile-box mt-3 bg-gray-50 p-3 rounded-md hidden">
                                    <div class="flex gap-3">
                                        <input class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm"
                                               type="number" name="code"
                                               placeholder="کد پیامک شده را وارد کنید">
                                        <button type="submit"
                                                class="btn w-[220px] bg-pink-500 rounded-sm px-2 py-[5px] text-white text-xs">
                                            بررسی و تغییر شماره موبایل
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="flex justify-between items-center mt-5">
                                <p class="text-gray-500 text-md text-xs"> نمایش شماره موبایل :
                                    @if($user->info->show_phone_number)
                                        <span class="text-green-500 text-xs"> فعال است </span>
                                    @else
                                        <span class="text-red-500 text-xs"> غیر فعال است </span>
                                    @endif
                                </p>

                                @if($user->info->show_phone_number)
                                    <a href="{{route('portal.profile.update.mobile.visibility' , 0)}}"
                                       class="bg-red-500 btn text-center w-[120px] rounded-sm px-2 py-[10px] text-white text-xs">
                                        غیر فعال کنید </a>
                                @else
                                    <a href="{{route('portal.profile.update.mobile.visibility' , 1)}}"
                                       class="bg-blue-500 btn text-center w-[120px] rounded-sm px-2 py-[10px] text-white text-xs">
                                        فعال کنید </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="sm:col-span-5 items border-2 border-gray-100 rounded-md p-3">
                        <form method="post" action="{{route('portal.profile.update')}}">
                            @csrf
                            <h3 class="text-gray-900">
                                اطلاعات حقوقی
                                <hr class="w-[90px] h-[3px] bg-blue-500"/>
                            </h3>
                            <div class="form mt-3 w-full">


                                <div class=" items-center justify-center gap-3 mt-3">
                                    <label class="text-xs"> نام و نام خانوادگی </label>
                                    <input class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm mt-1"
                                           value="{{$user->name}}"
                                           type="text" name="name" placeholder="نام و نام خانوادگی">
                                </div>


                                <div class=" items-center justify-center gap-3 mt-3">
                                    <label class="text-xs"> جنسیت </label>
                                    <select class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm"
                                            name="sex">
                                        <option {{$user->sex == 1 ? ' selected ' : null}}  value="1">
                                            مرد
                                        </option>
                                        <option {{$user->sex == 0 ? ' selected ' : null}} value="0">
                                            زن
                                        </option>
                                    </select>
                                </div>


                                <div class=" items-center justify-center gap-3 mt-3">
                                    <label class="text-xs"> نوع حساب </label>
                                    <select class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm"
                                            name="account_type">
                                        <option {{$user->info->account_type == 'personal' ? ' selected ' : null}}  value="personal">
                                            حقیقی
                                        </option>
                                        <option {{$user->info->account_type == 'company' ? ' selected ' : null}} value="company">
                                            حقوقی
                                        </option>
                                    </select>
                                </div>

                                <div class="company mt-3 bg-gray-50 p-3 rounded-md {{ $user->info->account_type == 'personal' ? ' hidden ' : null }}">
                                    <div class="gap-3">
                                        <label class="text-sm"> نام شرکت / ارگان </label>
                                        <input class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm mt-1"
                                               value="{{$user->info->company_name}}"
                                               type="text" name="company_name" placeholder="نام شرکت / ارگان">
                                    </div>
                                    <div class="gap-3 mt-3">
                                        <label class="text-sm"> شناسه ملی </label>
                                        <input class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm mt-1"
                                               value="{{$user->info->company_number}}"
                                               type="text" name="company_number" placeholder="شناسه ملی">
                                    </div>
                                    <div class="gap-3 mt-3">
                                        <label class="text-sm"> شماره ثابت </label>
                                        <input class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm mt-1"
                                               value="{{$user->info->company_phone}}"
                                               type="text" name="company_phone" placeholder="شماره ثابت">
                                    </div>
                                    <div class="gap-3 mt-3">
                                        <label class="text-sm"> آدرس </label>
                                        <textarea
                                                class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm mt-1"
                                                type="text" name="company_address"
                                                placeholder="آدرس">{{$user->info->company_address}}</textarea>
                                    </div>
                                </div>

                                <div class=" items-center justify-center gap-3 mt-3">
                                    <button type="submit"
                                            class="bg-blue-500 w-full rounded-sm px-2 py-[10px] text-white text-sm"> ثبت
                                        اطلاعات
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="sm:col-span-5 items border-2 border-gray-100 rounded-md p-3">
                        <form method="post" action="{{route('portal.profile.update.info')}}">
                            @csrf
                            <h3 class="text-gray-900">
                                اطلاعات تکمیلی
                                <hr class="w-[90px] h-[3px] bg-blue-500"/>
                            </h3>
                            <div class="form mt-3 w-full">


                                <div class=" items-center justify-center gap-3 mt-3">
                                    <label class="text-xs"> آدرس </label>
                                    <textarea
                                            class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm mt-1"
                                            rows="2" placeholder="آدرس"
                                            type="text" name="address">{{$user->info->address}}</textarea>
                                </div>


                                <div class=" items-center justify-center gap-3 mt-3">
                                    <label class="text-xs"> مختصری از فعالیت شما </label>
                                    <textarea
                                            class="border w-full border-gray-200 rounded-sm px-3 py-[10px] text-sm mt-1"
                                            rows="3"
                                            placeholder="مثلا : علی مقدم هستم 5 سال در حوضه خرید و فروش محصولات کشاورزی فعالیت میکنم و ...."
                                            type="text" name="description">{{$user->info->description}}</textarea>
                                </div>


                                <div class=" items-center justify-center gap-3 mt-3">
                                    <button type="submit"
                                            class="bg-blue-500 w-full rounded-sm px-2 py-[10px] text-white text-sm"> ثبت
                                        اطلاعات
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="sm:col-span-10 items border-2 border-gray-100 rounded-md p-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="upload">
                                <h3 class="text-gray-900 text-md">
                                    افزون تصاویر مرتبط (محصولات - شرکت - کارکنان)
                                    <hr class="w-[90px] h-[3px] bg-blue-500"/>
                                </h3>
                                <div class="form mt-3 w-full">
                                    <div id="accounts_pic" class="items-center bg-gray-100"></div>
                                </div>
                            </div>

                            <div class="items">
                                <h3 class="text-gray-900 text-md">
                                    تصاویر بارگذاری شده
                                    <hr class="w-[90px] h-[3px] bg-blue-500"/>
                                </h3>
                                <div class="form mt-3 w-full">
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-4 append-photo-file">
                                        @if(count($user->photos) > 0)

                                            @foreach($user->photos as $value)
                                                <div class="photo">
                                                    <img src="{{url($value->path)}}" class="w-full" alt="">
                                                    <a href="{{route('portal.profile.photo.delete' , $value->id)}}"
                                                       class="bg-red-500 block w-full text-white  py-2 text-center text-xs">حذف
                                                        تصویر</a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="sm:col-span-4 empty-items-photos">
                                                <p class="p-3 text-gray-500 bg-gray-100 rounded-md text-center text-sm">
                                                    هنوز تصویری بارگذاری نشده است </p>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="sm:col-span-10 items border-2 border-gray-100 rounded-md p-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="upload">
                                <h3 class="text-gray-900 text-md">
                                    افزون گواهینامه ها
                                    <hr class="w-[90px] h-[3px] bg-blue-500"/>
                                </h3>
                                <div class="form mt-3 w-full">
                                    <div id="certificate_pic" class="items-center bg-gray-100"></div>
                                </div>
                            </div>

                            <div class="items">
                                <h3 class="text-gray-900 text-md">
                                    تصاویر بارگذاری شده
                                    <hr class="w-[90px] h-[3px] bg-blue-500"/>
                                </h3>
                                <div class="form mt-3 w-full">
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-4 append-certificate-file">
                                        @if(count($user->certificate) > 0)
                                            @foreach($user->certificate as $value)
                                                <div class="photo">
                                                    <img src="{{url($value->path)}}" class="w-full" alt="">
                                                    <a href="{{route('portal.profile.certificate.delete' , $value->id)}}"
                                                       class="bg-red-500 block w-full text-white  py-2 text-center text-xs">حذف
                                                        تصویر</a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="sm:col-span-4 empty-items-certificate">
                                                <p class="p-3 text-gray-500 bg-gray-100 rounded-md text-center text-sm">
                                                    هنوز تصویری بارگذاری نشده است </p>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>


                </div>

            </div>


        </div>

    </section>

@endsection
@section('js')
    <script src="{{asset('assets/portal/plugins/upload/index.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/portal/js/profile.js')}}" type="text/javascript"></script>
@endsection
