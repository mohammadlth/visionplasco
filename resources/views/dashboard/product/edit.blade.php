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
            <span> ویرایش </span>
            <span> {{$item->title}} </span>
        </p>

        <div class="mt-3">
            <form method="post" action="{{route('products.update' , $item->id)}}" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                <div class="grid grid-cols-2 gap-5">

                    <div class="input-group">
                        <label for="category_id" class="text-sm text-gray-600">دسته بندی</label>
                        <select name="category_id" class="border rounded-sm px-2 py-1 bg-gray-100 select2-category">
                            @foreach($categories as $value)
                                @include('components.dashboard.category.select' , ['item' => $value  ,  'selected' => $item->category_id])
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="type" class="text-sm text-gray-600">نوع</label>
                        <input type="text" name="type" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('type') ? old('type') : $item->type}}" placeholder="نوع">
                    </div>

                    <div class="input-group">
                        <label for="full_name" class="text-sm text-gray-600">عنوان کامل</label>
                        <input type="text" name="full_name" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('full_name') ? old('full_name') : $item->full_name}}"
                               placeholder="عنوان کامل">
                    </div>

                    <div class="input-group">
                        <label for="slug" class="text-sm text-gray-600">نامک</label>
                        <input type="text" name="slug" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('slug') ? old('slug') : $item->slug}}" placeholder="عنوان کامل">
                    </div>

                    <div class="input-group">
                        <label for="show_footer" class="text-sm text-gray-600">آنچه مشتریان می پسندند</label>
                        <select name="show_footer" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('show_footer') && old('show_footer') == 1 ? ' selected ' : ($item->show_footer == 1 ? ' selected ' : '')  }}  value="1">
                                نمایش
                            </option>
                            <option {{old('show_footer') && old('show_footer') == 0 ? ' selected ' : ($item->show_footer == 0 ? ' selected ' : '')  }}  value="0">
                                عدم نمایش
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="status" class="text-sm text-gray-600">وضعیت</label>
                        <select name="status" class="border rounded-sm px-2 py-1 bg-gray-100"
                                onchange="checkValue($(this).val())">
                            <option {{old('status') && old('status') == 'confirm' ? ' selected ' : ($item->status == 'confirm' ? ' selected ' : '')  }}  value="confirm">
                                تایید شده
                            </option>
                            <option {{old('status') && old('status') == 'waiting' ? ' selected ' : ($item->status == 'waiting' ? ' selected ' : '')  }}  value="waiting">
                                در انتظار تایید
                            </option>
                            <option {{old('status') && old('status') == 'reject' ? ' selected ' : ($item->status == 'reject' ? ' selected ' : '')  }}  value="reject">
                                رد شده
                            </option>
                        </select>
                    </div>

                    @if($item->status == 'reject')
                        <div class="input-group col-span-2 description_reject" id="description_reject" style="display: grid">
                               <textarea name="description_reject" rows="3"
                                         class="border rounded-sm px-2 py-1 bg-red-100 text"
                                         id="description_reject" required
                                         placeholder="توضیحات عدم تایید جهت راهنمایی کاربر (اجباری *)">{!! $item->description_reject !!}</textarea>
                        </div>
                    @else
                        <div class="input-group col-span-2 description_reject" id="description_reject" style="display: none">
                               <textarea name="description_reject" rows="3"
                                         class="border rounded-sm px-2 py-1 bg-red-100 text"
                                         id="description_reject"
                                         placeholder="توضیحات عدم تایید جهت راهنمایی کاربر (اجباری *)">{!! $item->description_reject !!}</textarea>
                        </div>
                    @endif


                    <div class="input-group">
                        <label for="show" class="text-sm text-gray-600">وضعیت نمایش</label>
                        <select name="show" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('show') && old('show') == 1 ? ' selected ' : ($item->show == 1 ? ' selected ' : '')  }}  value="1">
                                نمایش
                            </option>
                            <option {{old('show') && old('show') == 0 ? ' selected ' : ($item->show == 0 ? ' selected ' : '')  }}  value="0">
                                عدم نمایش
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="sort" class="text-sm text-gray-600">ترتیب قرار گیری</label>
                        <input type="number" name="sort" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('sort') ? old('sort') : $item->sort}}" placeholder="ترتیب قرار گیری">
                    </div>


                    <div class="input-group">
                        <label for="user_name" class="text-sm text-gray-600">ثبت کننده</label>
                        <input type="text" disabled class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{$item->user ?  $item->user->name : ''}}" placeholder="ثبت کننده">
                    </div>


                    <div class="input-group">
                        <label for="city_id" class="text-sm text-gray-600">شهر / استان</label>
                        <select name="city_id" class="border rounded-sm px-2 py-1 bg-gray-100 select2-city">
                            @foreach($city as $value)
                                <option {{$item->city_id == $value->id ? ' selected ' : null }}  value="{{$value->id}}">
                                    {{$value->parent ? $value->parent->name : '*' }} - {{$value->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="inventory" class="text-sm text-gray-600">مقدار موجودی</label>
                        <input type="number" name="inventory" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('inventory') ? old('inventory') : $item->inventory}}"
                               placeholder="مقدار موجودی">
                    </div>

                    <div class="input-group">
                        <label for="min_inventory" class="text-sm text-gray-600">کمترین مقدار فروش</label>
                        <input type="number" name="min_inventory" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('min_inventory') ? old('min_inventory') : $item->min_inventory}}"
                               placeholder="کمترین مقدار فروش">
                    </div>


                    <div class="input-group">
                        <label for="min_price" class="text-sm text-gray-600">قیمت پایه (تومان)</label>
                        <input type="number" name="min_price" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('min_price') ? old('min_price') : $item->min_price}}"
                               placeholder="قیمت پایه">
                    </div>

                    <div class="input-group">
                        <label for="created_at" class="text-sm text-gray-600">تاریخ ثبت</label>
                        <input type="text" disabled class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{Verta($item->created_at)->format('Y/m/d H:i')}}"
                               placeholder="تاریخ ثبت">
                    </div>

                    <div class="input-group col-span-2">
                        <label for="description" class="text-sm text-gray-600">توضیحات</label>
                        <textarea name="description" rows="3" class="border rounded-sm px-2 py-1 bg-gray-100 text"
                                  id="description"
                                  placeholder="توضیحات">{!! $item->description !!}</textarea>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="photos" class="text-sm text-gray-600">تصویر (افزودن)</label>
                        <input type="file" name="photos[]" multiple class="border rounded-sm px-2 py-1 bg-gray-100"
                               placeholder="تصویر">
                        <div class="mt-2">
                            @foreach($item->photos as $value)
                                <img src="{{url($value->path)}}" style="max-width: 250px" alt="">
                                <a href="{{route('remove.file' , $value->id)}}"><i
                                            class="fa fa-times text-red-500"></i> </a>
                            @endforeach
                        </div>
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
            $('.select2-city').select2();
            $('.select2-category').select2();
        });

        function checkValue(value) {
            if (value === 'reject') {
                $('#description_reject').attr('required', true)
                $('#description_reject').css('display', 'grid');
            } else {
                $('#description_reject').attr('required', false)
                $('#description_reject').css('display', 'none');
            }
        }
    </script>
@endsection
