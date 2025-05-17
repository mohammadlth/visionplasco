@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')
    <section class="card col-span-2 xl:col-span-1 p-3">

        <table class="table-auto w-full text-right">
            <thead>
            <tr class="border-t">
                <th class="px-4 py-2 border-r">لیست رویدادهای سیستمی</th>
                <td class="px-4 py-2 border-l" colspan="6">
                </td>
            </tr>
            <tr>
                <th class="px-4 py-2 border-r border-t"></th>
                <th class="px-4 py-2 border-r border-t">فعالیت</th>
                <th class="px-4 py-2 border-t">اکشن</th>
                <th class="px-4 py-2 border-t">وضعیت</th>
                <th class="px-4 py-2 border-l border-t">مدیریت</th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @if(count($items) > 0)
                @foreach($items as $value)
                    <tr>
                        <td class="border border-l-0 px-4 py-2 text-center text-green-500">
                            <i class="fad fa-circle"></i>
                        </td>
                        <td class="border border-l-0 px-4 py-2">{{$value->title}}</td>
                        <td class="border border-l-0 px-4 py-2">{{$value->action}}</td>
                        <td class="border border-l-0 px-4 py-2">
                            <span class="text-green-500"> انجام شده </span>
                        </td>
                        <td class="border border-l px-4 py-2">
                            <a href="{{route('events.show' , [$value->id])}}"
                               class="text-xs bg-green-500 px-3 py-2 rounded-sm  text-white ml-1">
                                <i class="fa fa-info text-xs text-white mx-1"></i>
                                مشاهده
                            </a>
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

            @if($items->lastPage() > 1)
                <tr class="text-center">
                    <td class="border px-4 py-2 text-center" colspan="7">
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
