@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')
    <section class="card col-span-2 xl:col-span-1 p-3">

        <table class="table-auto w-full text-right">
            <thead>
            <tr class="border-t">
                <th class="px-4 py-2 border-r">لیست مخاطبین</th>
                <td class="px-4 py-2 border-l" colspan="7">
                </td>
            </tr>
            <tr class="border-t">
                <th class="px-4 py-2 border-r border-l">جستجو کنید</th>
                <td class="px-4 py-2 border-l relative" colspan="7">
                    <div class="items-center gap-2">
                        <form method="get" action="{{route('contacts.index')}}">
                            <input class="border bg-gray-100 w-full px-3 py-1 rounded-md" name="s"
                                   placeholder="جستجو کنید (موبایل - نام کاربر) ...">
                        </form>
                        @if(isset($params['s']) && !is_null($params['s']))
                            <div class="mt-2">
                                <a href="{{route('contacts.index')}}">
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
                <th class="px-4 py-2 border-r border-t">شناسه</th>
                <th class="px-4 py-2 border-r border-t">کاربر</th>
                <th class="px-4 py-2 border-r border-t">مخاطب</th>
                <th class="px-4 py-2 border-t">آخرین پیام</th>
                <th class="px-4 py-2 border-t">بلاک شده ؟</th>
                <th class="px-4 py-2 border-t"> آخرین بروز رسانی</th>
                <th class="px-4 py-2 border-t"> تاریخچه</th>
                <th class="px-4 py-2 border-l border-t text-center">زباله دان</th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @if(count($items) > 0)
                @foreach($items as $value)
                    <tr>
                        <td class="border border-l-0 px-4 py-2 text-right text-black">
                            {{$value->id}}
                        </td>
                        <td class="border border-l-0 px-4 py-2 text-right text-black">
                            <a href="{{route('users.edit' , $value->user ? $value->user->id : -1)}}" class="text-xs">
                                @if($value->user && $value->user->info && !is_null($value->user->info->profile_pic))
                                    <img src="{{url($value->user->info->profile_pic)}}" alt=""
                                         style="width: 40px;height: 40px;border-radius: 50px">
                                @else
                                    <img src="{{asset('assets/portal/img/user-p.png')}}"
                                         style="width: 40px;height: 40px;border-radius: 50px" alt="">
                                @endif
                                {{$value->user ? $value->user->name . ' - ' . $value->user->mobile : null}}
                            </a>
                        </td>
                        <td class="border border-l-0 px-4 py-2 text-right text-black">
                            <a href="{{route('users.edit' , $value->contact ? $value->contact->id : -1)}}"
                               class="text-xs">
                                @if($value->contact && $value->contact->info && !is_null($value->contact->info->profile_pic))
                                    <img src="{{url($value->contact->info->profile_pic)}}" alt=""
                                         style="width: 40px;height: 40px;border-radius: 50px">
                                @else
                                    <img src="{{asset('assets/portal/img/user-p.png')}}"
                                         style="width: 40px;height: 40px;border-radius: 50px" alt="">
                                @endif
                                {{$value->contact ? $value->contact->name . ' - ' . $value->contact->mobile : null}}
                            </a>
                        </td>
                        <td class="border border-l-0 px-4 py-2 text-xs">
                            {{$value->last_message}}
                        </td>
                        <td class="border border-l-0 px-4 py-2 text-sm">
                            @if($value->block)
                                <span class="text-red-500">بله</span>
                            @else
                                <span class="text-green-500">خیر</span>
                            @endif
                        </td>
                        <td class="border border-l-0 px-4 py-2 text-xs">
                            {{Verta($value->updated_at)->formatDifference()}}
                        </td>
                        <td class="border border-l-0 px-4 py-2">
                            <a href="{{route('contacts.chats' , [$value->id , 'page' => $items->currentPage()])}}"
                               class="text-xs bg-blue-500 px-3 py-2 rounded-sm  text-white ml-1">
                                <i class="fa fa-eye text-xs text-white mx-1"></i>
                                مشاهده تاریخچه
                            </a>
                        </td>
                        <td class="border px-4 py-2 border-l">
                            <form class="delete-form text-center" method="post"
                                  action="{{route('contacts.delete' , $value->id)}}">
                                @method('delete')
                                @csrf
                                <button type="submit"><i class="fa fa-trash text-red-500"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="border border-l px-4 py-2 text-center text-gray-500">
                        اطلاعاتی در این جدول یافت نشد
                    </td>
                </tr>
            @endif

            @if($items->lastPage() > 1)
                <tr class="text-center">
                    <td class="border px-4 py-2 text-center" colspan="8">
                        <div class="flex justify-center">
                            {{$items->withQueryString()->links()}}
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
