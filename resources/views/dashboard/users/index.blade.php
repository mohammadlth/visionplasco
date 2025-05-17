@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')
    <section class="card col-span-2 xl:col-span-1 p-3">

        <table class="table-auto w-full text-right">
            <thead>
            <tr class="border-t">
                <th class="px-4 py-2 border-r">لیست کاربران</th>
                <td class="px-4 py-2 border-l" colspan="6">

                    <a href="{{route('users.create')}}"
                       class="bg-green-500 text-white float-left px-3 py-1 rounded-sm text-sm mx-2">
                        <i class="fas fa-plus"></i>
                        افزودن</a>

                    <a href="{{route('excel.user')}}"
                       class="bg-blue-500 text-white float-left px-3 py-1 rounded-sm text-sm">
                        <i class="fas fa-file-export"></i>
                        خروجی اکسل</a>


                </td>
            </tr>
            <tr class="border-t">
                <th class="px-4 py-2 border-r border-l">جستجو کنید</th>
                <td class="px-4 py-2 border-l relative" colspan="6">
                    <div class="items-center gap-2">
                        <form method="get" action="{{route('users.index')}}">
                            <input class="border bg-gray-100 w-full px-3 py-1 rounded-md" name="s"
                                   placeholder="جستجو کنید ...">
                        </form>
                        @if(isset($params['s']) && !is_null($params['s']))
                            <div class="mt-2">
                                <a href="{{route('users.index')}}">
                                    <span class="border px-2 py-1 rounded-full">
                                        {{$params['s']}}
                                        <i class="fa fa-times"></i>
                                    </span>
                                </a>
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <th class="px-4 py-2 border-r border-t"></th>
                <th class="px-4 py-2 border-r border-t">نام و نام خانوادگی</th>
                <th class="px-4 py-2 border-t">موبایل</th>
                <th class="px-4 py-2 border-t">نوع حساب</th>
                <th class="px-4 py-2 border-t">دسترسی</th>
                <th class="px-4 py-2 border-l border-t">مدیریت</th>
                <th class="px-4 py-2 border-l border-t text-center">زباله دان</th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @if(count($users) > 0)
                @foreach($users as $value)
                    <tr>
                        @if($value->ban)
                            <td class="border border-l-0 px-4 py-2 text-center text-red-500">
                                <i class="fad fa-circle"></i>
                            </td>
                        @else
                            <td class="border border-l-0 px-4 py-2 text-center text-green-500">
                                <i class="fad fa-circle"></i>
                            </td>
                        @endif
                        <td class="border border-l-0 px-4 py-2">{{$value->name}}</td>
                        <td class="border border-l-0 px-4 py-2">{{$value->mobile}}</td>
                        <td class="border border-l-0 px-4 py-2">
                            @if($value->account == 'buyer')
                                خریدار
                            @elseif($value->account == 'seller')
                                فروشنده
                            @endif
                            -
                            @if($value->vip_account)
                                <span class="text-yellow-600 text-xs">اکانت ویژه</span>
                            @else
                                <span class="text-gray-600 text-xs  ">اکانت عادی</span>
                            @endif
                        </td>
                        <td class="border border-l-0 px-4 py-2">
                            @if($value->is_admin)
                                <span class="text-red-500 text-xs"> ادمین </span>
                            @else
                                <span class="text-green-500 text-xs"> کاربر عادی </span>
                            @endif
                        </td>
                        <td class="border border-l-0 px-4 py-2">
                            <a href="{{route('users.edit' , [$value->id , 'page' => $users->currentPage()])}}"
                               class="text-xs bg-blue-500 px-3 py-2 rounded-sm  text-white ml-1">
                                <i class="fa fa-pen text-xs text-white mx-1"></i>
                                ویرایش
                            </a>
                            <a href="{{route('users.info' , [$value->id , 'page' => $users->currentPage()])}}"
                               class="text-xs bg-green-500 px-3 py-2 rounded-sm  text-white ml-1">
                                <i class="fa fa-info text-xs text-white mx-1"></i>
                                اطلاعات
                            </a>
                            <a href="{{route('products.index' , ['s' => $value->mobile])}}"
                               class="text-xs bg-pink-500 px-3 py-2 rounded-sm  text-white ml-1">
                                <i class="fa fa-box text-xs text-white mx-1"></i>
                                محصولات
                            </a>
                            <a href="{{route('users.login' , [$value->id])}}"
                               class="text-xs bg-red-500 px-3 py-2 rounded-sm  text-white ml-1">
                                <i class="fa fa-user text-xs text-white mx-1"></i>
                                ورود سریع
                            </a>
                        </td>
                        <td class="border px-4 py-2 border-l">
                            <form class="delete-form text-center" method="post"
                                  action="{{route('users.destroy' , $value->id)}}">
                                @method('delete')
                                @csrf
                                <button type="submit"><i class="fa fa-trash text-red-500"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="border border-l px-4 py-2 text-center text-gray-500">
                        اطلاعاتی در این جدول یافت نشد
                    </td>
                </tr>
            @endif

            @if($users->lastPage() > 1)
                <tr class="text-center">
                    <td class="border px-4 py-2 text-center" colspan="7">
                        <div class="flex justify-center">
                            {{$users->withQueryString()->links()}}
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </section>
@endsection
@section('js')
@endsection
