@extends('layouts.portal')
@section('css')
    <link href="{{asset('assets/portal/plugins/upload/upload.css')}}" rel="stylesheet">
@endsection
@section('body')

    <section class="content my-5">
        <div class="relative overflow-x-auto rounded-md">
            <div class="bg-white p-5">
                <h2 class="text-right my-2 text-sm text-gray-800"><strong style="font-size: 17px"
                                                                          class="text-gray-600">{{$product->category->title}}</strong>
                </h2>
                <hr/>
                @if($product->status == 'reject' && !is_null($product->description_reject))
                    <p class="bg-red-400 rounded-md text-white px-2 py-2 my-3">
                        <span style="color: white" class="text-sm"> دلیل رد محصول : </span>
                        <b style="color: white;" class="text-sm">{{$product->description_reject}}</b>
                    </p>
                @endif
                <form method="post" enctype="multipart/form-data"
                      action="{{route('portal.product.update' , $product->id)}}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div class="input-box grid mt-3">
                            <label for="type" class="my-2 text-sm"> از نوع </label>
                            <input class="border border-rounded p-2 rounded-md" type="text" name="type"
                                   value="{{$product->type}}">
                        </div>

                        <div class="input-box grid mt-3">
                            <label for="type" class="my-2 text-sm"> استان </label>
                            <select class="border border-rounded p-2 rounded-md" type="text" name="region_id">
                                @foreach($cities as $value)
                                    <option {{$product->region_id == $value->id ? ' selected ' : null}} value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box grid">
                            <label for="type" class="my-2 text-sm"> شهر </label>
                            <select class="border border-rounded p-2 rounded-md" type="text" name="city_id">
                                @foreach($cities as $city)
                                    @foreach($city->child as $value)

                                        <option class="{{ $value->parent_id != $product->region_id ? 'hidden'  : '' }} cat{{$value->parent_id}} cityList"
                                                {{$product->city_id == $value->id ? ' selected ' : null}} value="{{$value->id}}">{{$value->name}}</option>

                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box grid mt-3">
                            <label for="inventory" class="my-2 text-sm"> موجودی </label>
                            <input class="border border-rounded p-2 rounded-md" type="number" name="inventory"
                                   value="{{$product->inventory}}">
                        </div>


                        <div class="input-box grid mt-3">
                            <label for="min_inventory" class="my-2 text-sm"> حداقل فروش </label>
                            <input class="border border-rounded p-2 rounded-md" type="number" name="min_inventory"
                                   value="{{$product->min_inventory}}">
                        </div>


                        <div class="input-box grid mt-3">
                            <label for="min_price" class="my-2 text-sm"> قیمت </label>
                            <input class="border border-rounded p-2 rounded-md" type="number" name="min_price"
                                   value="{{$product->min_price}}">
                        </div>


                        <div class="input-box grid mt-3 sm:col-span-2">
                            <label for="description" class="my-2 text-sm"> توضیحات </label>
                            <textarea class="border border-rounded p-2 rounded-md"
                                      name="description">{{$product->description}}</textarea>
                            <small style="color: red;font-size: 12px"> ویرایش توضیحات نیازمند بازبینی مجدد محصول شما
                                میگردد </small>
                        </div>

                        <div class="images grid mt-3 sm:col-span-2">
                            <label for="photos" class="my-2 text-sm"> تصویر محصول </label>

                            <div class="items-content grid grid-cols-1 md:grid-cols-2 gap-7 align-items-start justify-center">
                                <div class="file upload">
                                    <div id="uploadFile" style="background-color: #eee"></div>

                                    <div class="items-photos">
                                    </div>

                                    <div class="photos-items grid grid-cols-1 sm:grid-cols-2 gap-5 mt-3">

                                        @foreach($product->photos as $value)
                                            <div class="item flex justify-between items-center border border-gray-200 rounded-md p-3">
                                                <img width="100px" src="{{url($value->path)}}">
                                                <a href="{{route('portal.product.photo.delete' , [$value->id , $product->id])}}"
                                                   class="text-xs flex items-center justify-center gap-2 bg-red-500 text-center px-2 py-1 rounded-xs text-white">
                                                    <i class="fa fa-times text-white"></i>
                                                    حذف </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="role">
                                    <ul class="text-xs list-dot">
                                        <li style="list-style-type: decimal">
                                            فقط تصاویر مرتبط با محصول را بارگذاری کنید.
                                        </li>
                                        <li style="list-style-type: decimal">
                                            از درج شماره تماس یا لوگو بر روی تصاویر خودداری کنید.

                                        </li>
                                        <li style="list-style-type: decimal">
                                            حداکثر مجاز به انتخاب 4 تصویر هستید.

                                        </li>
                                        <li style="list-style-type: decimal">
                                            حجم هر تصویر باید کمتر از 5 مگابایت باشد.
                                        </li>
                                        <li style="list-style-type: decimal">
                                            تصویر از نوع jpeg یا jpg باشد .

                                        </li>
                                        <li style="list-style-type: decimal">
                                            <small style="color: red;font-size: 12px"> ویرایش تصویر نیازمند بازبینی مجدد
                                                محصول شما
                                                میگردد </small>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="input-box grid mt-3 sm:col-span-2">
                            <button class="bg-blue-500 p-3 rounded-md text-white " type="submit"> ثبت اطلاعات</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script src="{{asset('assets/portal/js/productEdit.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/portal/plugins/upload/index.min.js')}}" type="text/javascript"></script>

@endsection
