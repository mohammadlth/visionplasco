@extends('layouts.dashboard')
@section('style')

@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">
        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-pen"></i>
            <span> افزودن </span>
            <span> صفحه جانبی </span>
        </p>
        <div class="mt-3">
            <form method="post" action="{{route('pages.store')}}" enctype="multipart/form-data">
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
                        <label for="for" class="text-sm text-gray-600">برای</label>
                        <select name="for" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('for') == 1 ? ' selected ' : null  }}  value="1">
                                فروشندگان
                            </option>
                            <option {{old('for') == 2 ? ' selected ' : null  }}  value="2">
                                خریداران
                            </option>
                        </select>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="password" class="text-sm text-gray-600">توضیحات</label>
                        <textarea name="text" rows="3" class="border rounded-sm px-2 py-1 bg-gray-100 text"
                                  placeholder="توضیحات"></textarea>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="photo" class="text-sm text-gray-600">تصویر</label>
                        <input type="file" name="photo" class="border rounded-sm px-2 py-1 bg-gray-100"
                               placeholder="photo">
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
    <script src="{{asset('assets/ckeditor/js/ckeditor.js')}}"></script>
    <script src="{{asset('assets/ckeditor/js/fa.js')}}"></script>
    <script>
        $(function () {
            CKEDITOR.replace('text');
        });
    </script>
@endsection
