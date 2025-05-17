@extends('layouts.dashboard')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/dashboard/plugins/select2/select2.min.css')}}">
@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">
        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-pen"></i>
            <span> ویرایش </span>
            <span> {{$item->title}} </span>
        </p>
        <div class="mt-3">
            <form method="post" action="{{route('settings.update' , $item->id)}}" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                @if($item->key == 'plan_offer')
                    <div class="grid grid-cols-2 gap-5">
                        <div class="input-group col-span-2">
                            <p class="text-center text-black">
                                ویرایش اطلاعات این بخش در قسمت پلن ها
                            </p>
                        </div>
                    </div>
                @elseif($item->key == 'site_view')
                    <div class="grid grid-cols-2 gap-5">

                        <div class="input-group">
                            <p> با غیر فعال کردن - سایت به طور کامل از دسترس خارج خواهد شد و فقط پنل ادمین قابلیت دسترسی
                                دارد</p>
                            <label for="type" class="text-sm text-gray-600">نمایش سایت</label>
                            <select name="view" class="border rounded-sm px-2 py-1 bg-gray-100">
                                <option {{$item->value == 0 ?  ' selected ' : ''}} value="0"> عدم نمایش</option>
                                <option {{$item->value == 1 ?  ' selected ' : ''}} value="1"> نمایش</option>
                            </select>
                        </div>


                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($item->key == 'expire_day')
                    <div class="grid grid-cols-2 gap-5">

                        <div class="input-group">
                            <p>تعداد روز مهلت استفاده از پنل کاربری به صورت رایگان را وارد کنید</p>
                            <input class="border rounded-sm px-2 py-1 bg-gray-100" type="number" name="day"
                                   value="{{$item->value}}">

                        </div>


                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>

                @elseif($item->key == 'about_us')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>متن درباره ما</p>
                            <textarea class="border rounded-sm px-2 py-1 bg-gray-100 about_us" id="about_us"
                                      name="about_us">{{$item->value}}</textarea>
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>

                @elseif($item->key == 'terms')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>متن قوانین و مقررات</p>
                            <textarea class="border rounded-sm px-2 py-1 bg-gray-100 about_us" id="terms"
                                      name="terms">{{$item->value}}</textarea>
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>

                @elseif($item->key == 'phones')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>شماره تماس ها به ترتیب (پشتیبانی - همراه پشتیبانی) با کاما (,) جدا شود</p>
                            <input class="border rounded-sm px-2 py-1 bg-gray-100"
                                   name="phones" type="text" value="{{$item->value}}">
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($item->key == 'email')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>آدرس ایمیل</p>
                            <input class="border rounded-sm px-2 py-1 bg-gray-100"
                                   name="email" type="text" value="{{$item->value}}">
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($item->key == 'address')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>آدرس</p>
                            <input class="border rounded-sm px-2 py-1 bg-gray-100"
                                   name="address" type="text" value="{{$item->value}}">
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($item->key == 'map')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>نقشه کد embed</p>
                            <input class="border rounded-sm px-2 py-1 bg-gray-100"
                                   name="map" type="text" value="{{$item->value}}">
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($item->key == 'footer_text')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>متن فوتر</p>
                            <input class="border rounded-sm px-2 py-1 bg-gray-100"
                                   name="footer_text" type="text" value="{{$item->value}}">
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($item->key == 'whatsapp')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>واتساپ</p>
                            <input class="border rounded-sm px-2 py-1 bg-gray-100"
                                   name="whatsapp" type="text" value="{{$item->value}}">
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($item->key == 'telegram')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>تلگرام</p>
                            <input class="border rounded-sm px-2 py-1 bg-gray-100"
                                   name="telegram" type="text" value="{{$item->value}}">
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($item->key == 'instagram')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>اینستاگرام</p>
                            <input class="border rounded-sm px-2 py-1 bg-gray-100"
                                   name="instagram" type="text" value="{{$item->value}}">
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($item->key == 'twitter')
                    <div class="grid grid-cols-1 gap-5">

                        <div class="input-group">
                            <p>توییتر</p>
                            <input class="border rounded-sm px-2 py-1 bg-gray-100"
                                   name="twitter" type="text" value="{{$item->value}}">
                        </div>

                        <div class="btn-form col-span-2">
                            <div class="flex justify-end">
                                <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                    <i class="fa fa-check"></i>
                                    ثبت اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </section>

@endsection
@section('js')
    <script src="{{asset('assets/dashboard/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/ckeditor/js/ckeditor.js')}}"></script>
    <script src="{{asset('assets/ckeditor/js/fa.js')}}"></script>
    @if($item->key == 'about_us')
        <script>
            $(function () {
                CKEDITOR.replace('about_us');
            });
        </script>
    @endif
    @if($item->key == 'terms')
        <script>
            $(function () {
                CKEDITOR.replace('terms');
            });
        </script>
    @endif
    <script>
        $(function () {
            $('.select2-category').select2();
        });
    </script>
@endsection
