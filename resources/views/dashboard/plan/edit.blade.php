@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">
        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-pen"></i>
            <span> ویرایش </span>
            <span> {{$item->title}} </span>
        </p>
        <div class="mt-3">
            <form method="post" action="{{route('plans.update' , $item->id)}}" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                <div class="grid grid-cols-2 gap-5">
                    <div class="input-group">
                        <label for="title" class="text-sm text-gray-600">عنوان</label>
                        <input type="text" name="title" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('title') ? old('title') : $item->title}}" placeholder="عنوان">
                    </div>

                    <div class="input-group">
                        <label for="label" class="text-sm text-gray-600">لیبل</label>
                        <input type="text" name="label" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('label') ? old('label') : $item->label}}" placeholder="لیبل">
                    </div>

                    <div class="input-group">
                        <label for="sort" class="text-sm text-gray-600">ترتیب قرار گیری</label>
                        <input type="number" name="sort" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('sort') ? old('sort') : $item->sort}}" placeholder="ترتیب قرار گیری">
                    </div>


                    <div class="input-group">
                        <label for="status" class="text-sm text-gray-600">وضعیت</label>
                        <select name="status" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('status') && old('status') == 0 ? ' selected ' : ($item->status == 0 ? ' selected ' : '')  }}  value="0">
                                غیر فعال
                            </option>
                            <option {{old('status') && old('status') == 1 ? ' selected ' : ($item->status == 1 ? ' selected ' : '')  }}  value="1">
                                فعال
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="price" class="text-sm text-gray-600">قیمت</label>
                        <input type="number" name="price" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('price') ? old('price') : $item->price}}" placeholder="قیمت">
                    </div>
                    <div class="input-group">
                        <label for="price_off" class="text-sm text-gray-600">قیمت با تخفیف </label>
                        <input type="number" name="price_off" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('price_off') ? old('price_off') : $item->price_off}}"
                               placeholder="قیمت با تخفیف">
                    </div>
                    <div class="input-group">
                        <label for="period_payment_day" class="text-sm text-gray-600"> مدت دوره </label>
                        <input type="number" name="period_payment_day" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('period_payment_day') ? old('period_payment_day') : $item->period_payment_day}}"
                               placeholder="مدت دوره">
                    </div>

                    <div class="input-group">
                        <label for="vip" class="text-sm text-gray-600">پرفروش ترین</label>
                        <select name="vip" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('vip') && old('vip') == 0 ? ' selected ' : ($item->vip == 0 ? ' selected ' : '')  }}  value="0">
                                عدم نمایش
                            </option>
                            <option {{old('vip') && old('vip') == 1 ? ' selected ' : ($item->vip == 1 ? ' selected ' : '')  }}  value="1">
                                نمایش
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="color" class="text-sm text-gray-600"> رنگ </label>
                        <input type="color" name="color" class="border rounded-sm px-2 py-1 bg-gray-100 w-full"
                               value="{{old('color') ? old('color') : $item->color}}"
                               placeholder="رنگ">
                    </div>


                    <div class="input-group col-span-2">
                        <label for="status" class="text-sm text-gray-600">ویژگی ها</label>
                        <div class="features grid grid-cols-1">
                            @if(!is_null($item->feature))
                                @foreach(json_decode($item->feature) as $value)
                                    <div class="item flex my-3">
                                        <div class="w-3/4">
                                            <input type="text" name="feature[]" required
                                                   class="border rounded-sm px-2 py-1 bg-gray-100 w-full"
                                                   value="{{$value}}"
                                                   placeholder="ویژگی">
                                        </div>
                                        <div class="w-1/4">
                                            <span class="bg-red-500 px-2 py-1 text-white mr-2 text-sm cursor-pointer delete-item">حذف کنید</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                        <button type="button" class="bg-green-500 rounded-sm px-2 py-1 text-white add-item-feature"> +
                            افزودن ردیف
                        </button>
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
    <script>
        $(document).ready(function () {


            $('.add-item-feature').click(function () {
                $('.features').append('<div class="item flex my-3">' +
                    '<div class="w-3/4">' +
                    '<input type="text" name="feature[]" class="border rounded-sm px-2 py-1 bg-gray-100 w-full" required value="" placeholder="ویژگی">' +
                    '</div>' +
                    '<div class="w-1/4">' +
                    '<span class="bg-red-500 px-2 py-1 text-white mr-2 text-sm cursor-pointer delete-item">حذف کنید</span>' +
                    '</div>' +
                    '</div>');
                removeFeature();
            });

            removeFeature();
        });

        function removeFeature() {
            $('.delete-item').click(function () {
                $(this).parent().parent().remove();
            })
        }

    </script>
@endsection
