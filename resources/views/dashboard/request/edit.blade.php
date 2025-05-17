@extends('layouts.dashboard')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/dashboard/plugins/select2/select2.min.css')}}">
@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">
        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-pen"></i>
            <span> ویرایش </span>
            <span> {{$item->type}} </span>
        </p>
        <div class="mt-3">
            <form method="post" action="{{route('requests.update' , $item->id)}}" enctype="multipart/form-data">
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
                        <label for="status" class="text-sm text-gray-600">وضعیت</label>
                        <select name="status" class="border rounded-sm px-2 py-1 bg-gray-100">
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
                        <label for="user_name" class="text-sm text-gray-600">ثبت کننده</label>
                        <input type="text" disabled class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{$item->user ?  $item->user->name : ''}}" placeholder="ثبت کننده">
                    </div>

                    <div class="input-group">
                        <label for="inventory" class="text-sm text-gray-600">مقدار مورد نیاز</label>
                        <input type="number" name="inventory" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('inventory') ? old('inventory') : $item->inventory}}"
                               placeholder="مقدار موجودی">
                    </div>


                    <div class="input-group">
                        <label for="created_at" class="text-sm text-gray-600">تاریخ ثبت</label>
                        <input type="text" disabled class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{Verta($item->created_at)->format('Y/m/d H:i')}}"
                               placeholder="تاریخ ثبت">
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
    </script>
@endsection
