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
            <form method="post" action="{{route('meta.update' , $item->id)}}" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                <div class="grid grid-cols-2 gap-5">

                    <div class="input-group col-span-2">
                        <label for="path" class="text-sm text-gray-600">آدرس</label>
                        <input type="text" name="path" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{$item->path}}" placeholder="آدرس">
                    </div>

                    <div class="input-group col-span-2">
                        <label for="title" class="text-sm text-gray-600">عنوان</label>
                        <input type="text" name="title" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{$item->title}}" placeholder="عنوان">
                    </div>

                    <div class="input-group col-span-2">
                        <label for="description" class="text-sm text-gray-600">توضیحات</label>
                        <textarea rows="2" class="border rounded-sm px-2 py-1 bg-gray-100" name="description"
                                  id="description"
                                  placeholder="توضیحات">{{$item->description}}</textarea>
                    </div>


                    <div class="input-group">
                        <label for="og_title" class="text-sm text-gray-600">og title</label>
                        <input type="text" class="border rounded-sm px-2 py-1 bg-gray-100" value="{{$item->og_title}}" name="og_title"
                               id="og_title"
                               placeholder="og title">
                    </div>

                    <div class="input-group">
                        <label for="og_title" class="text-sm text-gray-600">og type</label>
                        <input type="text" class="border rounded-sm px-2 py-1 bg-gray-100" value="{{$item->og_type}}" name="og_type"
                               id="og_type"
                               placeholder="og_type">
                    </div>


                    <div class="input-group col-span-2">
                        <label for="og_description" class="text-sm text-gray-600">og description</label>
                        <textarea rows="2" class="border rounded-sm px-2 py-1 bg-gray-100" name="og_description"
                                  id="og_description"
                                  placeholder="og description">{{$item->og_description}}</textarea>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="og_image" class="text-sm text-gray-600">og image</label>
                        <input type="text" class="border rounded-sm px-2 py-1 bg-gray-100" value="{{$item->og_image}}" name="og_image"
                               id="og_image"
                               placeholder="og_image">
                    </div>

                    <div class="input-group col-span-2">
                        <label for="structured_data" class="text-sm text-gray-600">structured data js</label>
                        <textarea rows="6" class="border rounded-sm px-2 py-1 bg-gray-100" name="structured_data"
                                  id="structured_data"
                                  placeholder="structured_data">{{$item->structured_data}}</textarea>
                    </div>

                    <div class="input-group">
                        <label for="priority" class="text-sm text-gray-600">priority</label>
                        <input type="text" class="border rounded-sm px-2 py-1 bg-gray-100" value="{{$item->priority}}" name="priority"
                               id="priority"
                               placeholder="priority">
                    </div>


                    <div class="input-group">
                        <label for="changefreq" class="text-sm text-gray-600">changefreq</label>
                        <input type="text" class="border rounded-sm px-2 py-1 bg-gray-100" value="{{$item->changefreq}}" name="changefreq"
                               id="changefreq"
                               placeholder="changefreq">
                    </div>

                    <div class="input-group col-span-2">
                        <label for="can_index" class="text-sm text-gray-600">مخفی کردن از موتور جستجو</label>
                        <select class="border rounded-sm px-2 py-1 bg-gray-100" id="can_index" name="can_index">
                            <option {{$item->can_index == 1 ? ' selected ' : null  }}  value="1">ایندکس شود</option>
                            <option {{$item->can_index == 0 ? ' selected ' : null  }} value="0">ایندکس نشود</option>
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
            </form>
        </div>
    </section>

@endsection
@section('js')

@endsection
