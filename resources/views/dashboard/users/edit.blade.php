@extends('layouts.dashboard')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/persianDatepicker-default.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/plugins/select2/select2.min.css')}}">
    <style>
        .pdp-default *{
            line-height: 1.5em;
            font-size: 11px;
        }
    </style>
@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">
        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-pen"></i>
            <span> ویرایش </span>
            <span> {{$user->name}} </span>
        </p>
        <div class="mt-3">
            <form method="post" action="{{route('users.update' , $user->id)}}" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                <div class="grid grid-cols-2 gap-5">
                    <div class="input-group">
                        <label for="name" class="text-sm text-gray-600">نام و نام خانوادگی</label>
                        <input type="text" name="name" required class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('name') ? old('name') : $user->name}}" placeholder="نام و نام خانوادگی">
                    </div>
                    <div class="input-group">
                        <label for="mobile" class="text-sm text-gray-600">شماره موبایل</label>
                        <input type="number" name="mobile" required class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('mobile') ? old('mobile') : $user->mobile}}" placeholder="شماره موبایل">
                    </div>
                    <div class="input-group">
                        <label for="email" class="text-sm text-gray-600">ایمیل</label>
                        <input type="email" name="email" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('email') ? old('email') : $user->email}}" placeholder="ایمیل">
                    </div>
                    <div class="input-group">
                        <label for="sex" class="text-sm text-gray-600">جنسیت</label>
                        <select name="sex" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('sex') && old('sex') == 1 ? ' selected ' : ($user->sex == 1 ? ' selected ' : '')  }}  value="1">
                                مرد
                            </option>
                            <option {{old('sex') && old('sex') == 0 ? ' selected ' : ($user->sex == 0 ? ' selected ' : '')  }}  value="0">
                                زن
                            </option>
                        </select>
                    </div>


                    <div class="input-group">
                        <label for="account" class="text-sm text-gray-600">نوع حساب</label>
                        <select name="account" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('account') && old('account') == 'buyer' ? ' selected ' : ($user->account == 'buyer' ? ' selected ' : '')  }}  value="buyer">
                                خریدار
                            </option>
                            <option {{old('account') && old('account') == 'seller' ? ' selected ' : ($user->account == 'seller' ? ' selected ' : '')  }}  value="seller">
                                فروشنده
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="ban" class="text-sm text-gray-600">قفل حساب</label>
                        <select name="ban" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('ban') && old('ban') == 0 ? ' selected ' : ($user->ban == 0 ? ' selected ' : '')  }}  value="0">
                                باز
                            </option>
                            <option {{old('ban') && old('ban') == 1 ? ' selected ' : ($user->ban == 1 ? ' selected ' : '')  }}  value="1">
                                قفل
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="is_admin" class="text-sm text-gray-600">سطح دسترسی</label>
                        <select name="is_admin" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('is_admin') && old('is_admin') == 0 ? ' selected ' : ($user->is_admin == 0 ? ' selected ' : '')  }}  value="0">
                                کاربر عادی
                            </option>
                            <option {{old('is_admin') && old('is_admin') == 1 ? ' selected ' : ($user->is_admin == 1 ? ' selected ' : '')  }}  value="1">
                                ادمین
                            </option>
                        </select>
                    </div>

                    @php
                        if (!is_null($user->admin_permission)){
                            $per = json_decode($user->admin_permission);
                        }else{
                            $per = [];
                        }
                    @endphp
                    <div class="input-group">
                        <label for="admin_permission" class="text-sm text-gray-600">دسترسی</label>
                        <select name="admin_permission[]"
                                class="border rounded-sm px-2 py-1 bg-gray-100 select2-permission" multiple>
                            @foreach($permission as $value)
                                @if(in_array($value->id , $per))
                                    <option selected value="{{$value->id}}">{{$value->name}}</option>
                                @else
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>


                    <div class="input-group">
                        <label for="confirm_identity" class="text-sm text-gray-600">تایید اطلاعات هویتی</label>
                        <select name="confirm_identity" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('confirm_identity') && old('confirm_identity') == 0 ? ' selected ' : ($user->confirm_identity == 0 ? ' selected ' : '')  }}  value="0">
                                تایید نشده
                            </option>
                            <option {{old('confirm_identity') && old('confirm_identity') == 1 ? ' selected ' : ($user->confirm_identity == 1 ? ' selected ' : '')  }}  value="1">
                                تکمیل شده - تایید
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="vip_account" class="text-sm text-gray-600">اکانت ویژه</label>
                        <select name="vip_account" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('vip_account') && old('vip_account') == 0 ? ' selected ' : ($user->vip_account == 0 ? ' selected ' : '')  }}  value="0">
                                کاربر عادی
                            </option>
                            <option {{old('vip_account') && old('vip_account') == 1 ? ' selected ' : ($user->vip_account == 1 ? ' selected ' : '')  }}  value="1">
                                کاربر ویژه
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="expired" class="text-sm text-gray-600">اکسپایر شده</label>
                        <select name="expired" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('expired') && old('expired') == 1 ? ' selected ' : ($user->expired == 1 ? ' selected ' : '')  }}  value="1">
                                اکسپایر شده
                            </option>
                            <option {{old('expired') && old('expired') == 0 ? ' selected ' : ($user->expired == 0 ? ' selected ' : '')  }}  value="0">
                                اکسپایر نشده
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="email" class="text-sm text-gray-600">اکسپایر اکانت vip</label>
                        @if(!is_null($user->vip_expire_at))
                            <input type="text" name="vip_expire_at" class="border rounded-sm px-2 py-1 bg-gray-100"
                                   id="date-picker" readonly
                                   value="{{old('vip_expire_at') ? old('vip_expire_at') : Verta($user->vip_expire_at)->format('Y/m/d')}}"
                                   placeholder="اکسپایر اکانت vip">
                        @else
                            <input type="text" name="vip_expire_at" class="border rounded-sm px-2 py-1 bg-gray-100"
                                   id="date-picker" readonly
                                   value="{{old('vip_expire_at') ? old('vip_expire_at') : ''}}"
                                   placeholder="اکسپایر اکانت vip">
                        @endif
                    </div>

                    <div class="input-group">
                        <label class="text-sm text-gray-600">آخرین فعالیت</label>
                        <input type="text" disabled class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{Verta($user->last_activity)->formatDifference()}}" placeholder="آخرین فعالیت">
                    </div>

                    <div class="input-group">
                        <label for="password" class="text-sm text-gray-600">تغییر کلمه عبور</label>
                        <input name="password" type="text" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('password')}}" placeholder="تغییر کلمه عبور">
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
    <script src="{{asset('assets/dashboard/plugins/select2/select2.min.js')}}"></script>

    <script>
        $(function () {
            $("#date-picker").persianDatepicker({
                formatDate: "YYYY/MM/DD",
                showGregorianDate: !1,
                persianNumbers: !0,
            });
            $('.select2-permission').select2();
        });
    </script>
@endsection
