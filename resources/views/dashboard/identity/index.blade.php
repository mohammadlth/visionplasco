@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')
    <section class="card col-span-2 xl:col-span-1 p-3">
        <table class="table-auto w-full text-right">
            <thead>
            <tr class="border-t">
                <th class="px-4 py-2 border-r">لیست احراز هویت</th>
                <td class="px-4 py-2 border-l" colspan="7"></td>
            </tr>
            <tr class="border-t">
                <th class="px-4 py-2 border-r border-l">جستجو کنید</th>
                <td class="px-4 py-2 border-l relative" colspan="7">
                    <div class="items-center gap-2">
                        <form method="get" action="{{route('identities.index')}}">
                            <input class="border bg-gray-100 w-full px-3 py-1 rounded-md" name="s"
                                   placeholder="جستجو کنید (موبایل - نام کاربر) ...">
                        </form>
                        @if(isset($params['s']) && !is_null($params['s']))
                            <div class="mt-2">
                                <a href="{{route('identities.index')}}">
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
                <th class="px-4 py-2 border-r border-t"> شناسه</th>
                <th class="px-4 py-2 border-r border-t"> کاربر</th>
                <th class="px-4 py-2 border-r border-t"> وضعیت</th>
                <th class="px-4 py-2 border-t"> تاریخ ثبت</th>
                <th class="px-4 py-2 border-t"> مشاهده</th>
                <th class="px-4 py-2 border-l border-t text-center"> زباله دان</th>
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
                                {{$value->user ? $value->user->name . ' - ' . $value->user->mobile : null}}
                            </a>
                        </td>
                        <td class="border border-l-0 px-4 py-2 text-right text-black">
                            @if($value->status == 'confirm')
                                <span class="text-green-500 text-sm"> تایید شده </span>
                            @elseif($value->status == 'reject')
                                <span class="text-red-500 text-sm"> رد شده </span>
                            @elseif($value->status == 'waiting')
                                <span class="text-yellow-500 text-sm"> درانتظار </span>
                            @endif
                        </td>
                        <td class="border border-l-0 px-4 py-2 text-xs">
                            {{Verta($value->created_at)->formatDifference()}}
                        </td>

                        <td class="border border-l-0 px-4 py-2">
                            <a href="{{route('identities.edit' , [$value->id , 'page' => $items->currentPage()])}}"
                               class="text-xs bg-blue-500 px-3 py-2 rounded-sm  text-white ml-1">
                                <i class="fa fa-eye text-xs text-white mx-1"></i>
                                مشاهده
                            </a>
                        </td>

                        <td class="border px-4 py-2 border-l">
                            <form class="delete-form text-center" method="post"
                                  action="{{route('identities.destroy' , $value->id)}}">
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
