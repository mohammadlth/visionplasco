@extends('layouts.dashboard')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/persianDatepicker-default.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/plugins/select2/select2.min.css')}}">
@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">
        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-pen"></i>
            <span> افزودن </span>
            <span> دسته </span>
        </p>
        <div class="mt-3">
            <form method="post" action="{{route('categories.store')}}" enctype="multipart/form-data">
                @method('post')
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                <div class="grid grid-cols-2 gap-5">
                    <div class="input-group">
                        <label for="title" class="text-sm text-gray-600">عنوان</label>
                        <input type="text" name="title" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('title')}}" placeholder="عنوان">
                    </div>
                    <div class="input-group">
                        <label for="slug" class="text-sm text-gray-600">نامک</label>
                        <input type="text" name="slug" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('slug')}}" placeholder="نامک">
                    </div>

                    <div class="input-group">
                        <label for="parent_id" class="text-sm text-gray-600">دسته بندی شاخه</label>
                        <select name="parent_id" class="border rounded-sm px-2 py-1 bg-gray-100 select2-category">
                            <option value=""> سر دسته اصلی</option>
                            @foreach($categories as $value)
                                @include('components.dashboard.category.select' , ['item' => $value  ,  'selected' => null])
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="sort" class="text-sm text-gray-600">ترتیب قرار گیری</label>
                        <input type="number" name="sort" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('sort')}}" placeholder="ترتیب قرار گیری">
                    </div>

                    <div class="input-group">
                        <label for="status" class="text-sm text-gray-600">وضعیت</label>
                        <select name="status" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('status') == 1 ? ' selected ' : null  }}  value="1">
                                فعال
                            </option>
                            <option {{old('status') == 0 ? ' selected ' : null  }}  value="0">
                                غیر فعال
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="placeholder" class="text-sm text-gray-600">مثال نمونه برای راهنمایی کاربر</label>
                        <input type="text" name="placeholder" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('placeholder')}}"
                               placeholder="مثال  نمونه برای راهنمایی کاربر">
                    </div>

                    <div class="input-group">
                        <label for="unit" class="text-sm text-gray-600">واحد اندازه گیری</label>
                        <select name="unit" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('unit') == 'کیلوگرم' ? ' selected ' : null  }}  value="کیلوگرم">
                                کیلوگرم
                            </option>
                            <option {{old('unit') == 'گرم' ? ' selected ' : null  }}  value="گرم">
                                گرم
                            </option>
                            <option {{old('unit') == 'عدد' ? ' selected ' : null  }}  value="عدد">
                                عدد
                            </option>
                            <option {{old('unit') == 'کارتن' ? ' selected ' : null  }}  value="کارتن">
                                کارتن
                            </option>
                            <option {{old('unit') == 'جین' ? ' selected ' : null  }}  value="جین">
                                جین
                            </option>
                            <option {{old('unit') == 'شاخه' ? ' selected ' : null  }}  value="شاخه">
                                شاخه
                            </option>
                            <option {{old('unit') == 'مثقال' ? ' selected ' : null  }}  value="مثقال">
                                مثقال
                            </option>
                            <option {{old('unit') == 'راس' ? ' selected ' : null  }}  value="راس">
                                راس
                            </option>
                            <option {{old('unit') == 'نفر' ? ' selected ' : null  }}  value="نفر">
                                نفر
                            </option>
                            <option {{old('unit') == 'لیتر' ? ' selected ' : null  }}  value="لیتر">
                                لیتر
                            </option>
                            <option {{old('unit') == 'گالن' ? ' selected ' : null  }}  value="گالن">
                                گالن
                            </option>
                            <option {{old('unit') == 'بطری' ? ' selected ' : null  }}  value="بطری">
                                بطری
                            </option>
                            <option {{old('unit') == 'شل' ? ' selected ' : null  }}  value="شل">
                                شل
                            </option>
                            <option {{old('unit') == 'مخزن' ? ' selected ' : null  }}  value="مخزن">
                                مخزن
                            </option>
                            <option {{old('unit') == 'پاکت' ? ' selected ' : null  }}  value="پاکت">
                                پاکت
                            </option>
                            <option {{old('unit') == 'بسته' ? ' selected ' : null  }}  value="بسته">
                                بسته
                            </option>
                            <option {{old('unit') == 'متر' ? ' selected ' : null  }}  value="متر">
                                متر
                            </option>
                            <option {{old('unit') == 'بشکه' ? ' selected ' : null  }}  value="بشکه">
                                بشکه
                            </option>
                            <option {{old('unit') == 'تانکر' ? ' selected ' : null  }}  value="تانکر">
                                تانکر
                            </option>
                            <option {{old('unit') == 'کیسه' ? ' selected ' : null  }}  value="کیسه">
                                کیسه
                            </option>
                            <option {{old('unit') == 'گونی' ? ' selected ' : null  }}  value="گونی">
                                گونی
                            </option>
                        </select>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="password" class="text-sm text-gray-600">توضیحات کوتاه</label>
                        <textarea name="short_text" rows="3" class="border rounded-sm px-2 py-1 bg-gray-100"
                                  placeholder="توضیحات کوتاه"></textarea>
                    </div>

                    <div class="input-group col-span-2 relative">
                        <label for="password" class="text-sm text-gray-600">توضیحات</label>
                        <textarea name="text" rows="3" class="border rounded-sm px-2 py-1 bg-gray-100 text" id="text"
                                  placeholder="توضیحات"></textarea>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="photo" class="text-sm text-gray-600">تصویر</label>
                        <input type="file" name="photo" class="border rounded-sm px-2 py-1 bg-gray-100"
                               placeholder="تصویر">
                    </div>


                    <div class="input-group col-span-2">
                        <label for="photo" class="text-sm text-gray-600">تصویر ساب</label>
                        <input type="file" name="sub" class="border rounded-sm px-2 py-1 bg-gray-100"
                               placeholder="تصویر ساب">
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
            </form>
        </div>
    </section>

@endsection
@section('js')
    <script src="{{asset('assets/dashboard/js/persianDatepicker.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/ckeditor/js/ckeditor.js')}}"></script>
    <script src="{{asset('assets/ckeditor/js/fa.js')}}"></script>
    <script>
        $(function () {
            $("#date-picker").persianDatepicker({
                formatDate: "YYYY/MM/DD",
                showGregorianDate: !1,
                persianNumbers: !0,
            });
            $('.select2-category').select2();
            CKEDITOR.replace('text');
            $(".cke_combopanel").css("width", 'auto');
        });
    </script>
@endsection
