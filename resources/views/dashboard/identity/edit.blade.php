@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">
        <p class="bg-blue-500 text-white px-3 py-2 rounded-sm mb-3">ادمین گرامی تمامی اطلاعات هویتی را ذخیره و در حافظه ای امن نگهداری کنید</p>

        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-pen"></i>
            <span> احراز هویت </span>
            <span> {{$item->title}} </span>
        </p>
        <div class="mt-3">
            <form method="post" action="{{route('identities.update' , $item->id)}}" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                <div class="grid grid-cols-2 gap-5">
                    <div class="input-group">
                        <label for="title" class="text-sm text-gray-600">نام و نام خانوادگی</label>
                        <input type="text" disabled class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{Auth::user()->name}}" placeholder="">
                    </div>
                    <div class="input-group">
                        <label for="title" class="text-sm text-gray-600">شماره موبایل</label>
                        <input type="text" disabled class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{Auth::user()->mobile}}" placeholder="">
                    </div>

                    <div class="input-group">
                        <label for="status" class="text-sm text-gray-600">وضعیت</label>
                        <select name="status" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{$item->status == 'waiting' ? ' selected ' : '' }}  value="waiting"> در انتظار
                            </option>
                            <option {{$item->status == 'confirm' ? ' selected ' : '' }}  value="confirm"> تایید شده
                            </option>
                            <option {{$item->status == 'reject' ? ' selected ' : '' }}  value="reject"> رد درخواست
                            </option>
                        </select>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="password" class="text-sm text-gray-600">توضیحات ادمین</label>
                        <textarea name="text" rows="3" class="border rounded-sm px-2 py-1 bg-gray-100 "
                                  placeholder="توضیحات">{!! $item->admin_text !!}</textarea>
                    </div>

                    <div class="input-group col-span-2">
                        @if($item->national_card)
                            <img src="{{url($item->national_card)}}" style="max-width: 400px">
                        @endif
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
