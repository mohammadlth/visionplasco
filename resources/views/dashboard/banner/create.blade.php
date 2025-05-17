@extends('layouts.dashboard')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/dashboard/plugins/select2/select2.min.css')}}">
    <style>
        .description_reject {
            background-color: #fff3f3;
        }
    </style>
@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">

        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-pen"></i>
            <span> افزودن </span>
            <span> نمایش در </span>
        </p>

        <div class="mt-3">
            <form method="post" action="{{route('banners.store')}}" enctype="multipart/form-data">
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
                        <label for="view_in" class="text-sm text-gray-600">نمایش در</label>
                        <select name="view_in"
                                class="border rounded-sm px-2 py-1 bg-gray-100 select2-category select_view_in">
                            <option {{old('view_in') == 'home' ? ' selected ' : null  }}  value="home">
                                خانه
                            </option>
                            <option {{old('view_in') == 'product' ? ' selected ' : null  }}  value="product">
                                صفحه تک محصول
                            </option>
                            <option {{old('view_in') == 'slider' ? ' selected ' : null  }}  value="slider">
                                تصویر ساب صفحه اصلی
                            </option>
                            <option {{old('view_in') == 'buyer' ? ' selected ' : null  }}  value="buyer">
                                صفحه لیست خریداران (پاپاپ)
                            </option>
                            <option {{old('view_in') == 'category' ? ' selected ' : null  }}  value="category">
                                دسته بندی محصولات
                            </option>
                        </select>
                    </div>


                    <div class="input-group select-category" style="display: none">
                        <label for="sort" class="text-sm text-gray-600">دسته</label>
                        <select name="page_category_id"class="border rounded-sm px-2 py-1 bg-gray-100 select2-category">
                            <option value="">انتخاب کنید</option>
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
                        <label for="link" class="text-sm text-gray-600">لینک به</label>
                        <input type="text" name="link" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('link')}}" placeholder="لینک به">
                    </div>

                    <div class="input-group">
                        <label for="short_text" class="text-sm text-gray-600">توضیح کوتاه</label>
                        <textarea rows="1" name="short_text" class="border rounded-sm px-2 py-1 bg-gray-100"
                                  placeholder="توضیح کوتاه"></textarea>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="photo" class="text-sm text-gray-600">تصویر</label>
                        <input type="file" name="photo" class="border rounded-sm px-2 py-1 bg-gray-100"
                               placeholder="تصویر">
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
    <script src="{{asset('assets/dashboard/plugins/select2/select2.min.js')}}"></script>
    <script>
        $(function () {
            $('.select2-category').select2();
        });
        $(document).ready(function () {
            $('.select_view_in').change(function () {

                var val = $(this).val();

                console.log(val);

                if (val === 'category') {
                    $('.select-category').css('display', 'grid');
                } else {
                    $('.select-category').css('display', 'none');
                }
            });
        });
    </script>
@endsection
