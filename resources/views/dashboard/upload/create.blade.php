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
            <form method="post" action="{{route('upload.store')}}" enctype="multipart/form-data">
                @method('post')
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                <div class="grid grid-cols-2 gap-5">
                    <div class="input-group">
                        <label for="title" class="text-sm text-gray-600">عنوان</label>
                        <input type="text" name="title" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('title')}}" placeholder="عنوان">
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
@endsection
