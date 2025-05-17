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
            <form method="post" action="{{route('features.update' , $item->id)}}" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                <div class="grid grid-cols-2 gap-5">
                    <div class="input-group">
                        <label for="title" class="text-sm text-gray-600">عنوان</label>
                        <input type="text" name="title" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{$item->title}}" placeholder="عنوان">
                    </div>

                    <div class="input-group">
                        <label for="sort" class="text-sm text-gray-600">ترتیب قرار گیری</label>
                        <input type="number" name="sort" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{$item->sort}}" placeholder="ترتیب قرار گیری">
                    </div>

                    <div class="input-group">
                        <label for="status" class="text-sm text-gray-600">وضعیت</label>
                        <select name="status" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{$item->status == 1 ? ' selected ' : null  }}  value="1">
                                فعال
                            </option>
                            <option {{$item->status == 0 ? ' selected ' : null  }}  value="0">
                                غیر فعال
                            </option>
                        </select>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="password" class="text-sm text-gray-600">توضیحات کوتاه</label>
                        <textarea name="text" rows="3" class="border rounded-sm px-2 py-1 bg-gray-100"
                                  placeholder="توضیحات کوتاه">{{$item->text}}</textarea>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="photo" class="text-sm text-gray-600">icon</label>
                        <input type="file" name="icon" class="border rounded-sm px-2 py-1 bg-gray-100" placeholder="icon">
                        <div class="mt-2" style="background-color: black">
                            @if(!is_null($item->icon))
                                <img src="{{url($item->icon)}}" style="max-width: 250px" alt="">
                            @endif
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

@endsection
