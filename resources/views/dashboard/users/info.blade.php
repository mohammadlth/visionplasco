@extends('layouts.dashboard')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/persianDatepicker-default.css')}}">
@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">
        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-pen"></i>
            <span> مشاهده اطلاعات </span>
            <span> {{$user->name}} </span>
        </p>
        <div class="mt-3">
            <form method="post" action="{{route('users.info.update' , $info->id)}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                <div class="grid grid-cols-2 gap-5">

                    <div class="input-group">
                        <label for="account_type" class="text-sm text-gray-600">نوع شخص</label>
                        <select name="account_type" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('account_type') && old('account_type') == 'personal' ? ' selected ' : ($info->account_type == 'personal' ? ' selected ' : '')  }}  value="personal">
                                حقیقی
                            </option>
                            <option {{old('account_type') && old('account_type') == 'company' ? ' selected ' : ($info->account_type == 'company' ? ' selected ' : '')  }}  value="company">
                                حقوقی
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="company_name" class="text-sm text-gray-600">نام شرکت</label>
                        <input type="text" name="company_name" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('company_name') ? old('company_name') : $info->company_name}}"
                               placeholder="شماره ثبت">
                    </div>

                    <div class="input-group">
                        <label for="company_number" class="text-sm text-gray-600">شماره ثبت</label>
                        <input type="text" name="company_number" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('company_number') ? old('company_number') : $info->company_number}}"
                               placeholder="شماره ثبت">
                    </div>

                    <div class="input-group">
                        <label for="company_phone" class="text-sm text-gray-600">شماره ثابت</label>
                        <input type="text" name="company_phone" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('company_phone') ? old('company_phone') : $info->company_phone}}"
                               placeholder="شماره ثابت">
                    </div>

                    <div class="input-group col-span-2">
                        <label for="company_address" class="text-sm text-gray-600">آدرس شرکت</label>
                        <textarea name="company_address" class="border rounded-sm px-2 py-1 bg-gray-100"
                                  placeholder="آدرس شرکت">{{$info->company_address}}</textarea>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="show_phone_number" class="text-sm text-gray-600">نمایش شماره موبایل</label>
                        <select name="show_phone_number" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('show_phone_number') && old('show_phone_number') == 1 ? ' selected ' : ($info->show_phone_number == 1 ? ' selected ' : '')  }}  value="1">
                                نمایش داده شود
                            </option>
                            <option {{old('show_phone_number') && old('show_phone_number') == 0 ? ' selected ' : ($info->show_phone_number == 0 ? ' selected ' : '')  }}  value="0">
                                نمایش داده نشود
                            </option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="address" class="text-sm text-gray-600">آدرس</label>
                        <textarea name="address" class="border rounded-sm px-2 py-1 bg-gray-100"
                                  placeholder="آدرس">{{$info->address}}</textarea>
                    </div>
                    <div class="input-group">
                        <label for="description" class="text-sm text-gray-600">توضیحات کاربر</label>
                        <textarea name="description" class="border rounded-sm px-2 py-1 bg-gray-100"
                                  placeholder="توضیحات کاربر">{{$info->description}}</textarea>
                    </div>


                    <div class="input-group">
                        <label for="score" class="text-sm text-gray-600">امتیاز</label>
                        <input type="number" name="score" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('score') ? old('score') : $info->score}}"
                               placeholder="امتیاز">
                    </div>


                    <div class="input-group">
                        <label for="comments" class="text-sm text-gray-600">تعداد نظرات</label>
                        <input type="number" name="comments" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('comments') ? old('comments') : $info->comments}}"
                               placeholder="تعداد نظرات">
                    </div>

                    <div class="input-group">
                        <label for="profile_pic" class="text-sm text-gray-600">تصویر پروفایل</label>
                        <input type="file" name="profile_pic" class="border rounded-sm px-2 py-1 bg-gray-100"
                               placeholder="تصویر پروفایل">
                        <div class="mt-2">
                            @if(!is_null($info->profile_pic))
                                <img src="{{url($info->profile_pic)}}" alt="" style="width: 200px">
                                <a href="{{route('user.info.pic.remove' , $info->id)}}"><i
                                            class="fa fa-times text-red-500"></i> </a>
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
    <script src="{{asset('assets/dashboard/js/persianDatepicker.js')}}"></script>
    <script>
        $(function () {
            $("#date-picker").persianDatepicker({
                formatDate: "YYYY/MM/DD",
                showGregorianDate: !1,
                persianNumbers: !0,
            });
        });
    </script>
@endsection
