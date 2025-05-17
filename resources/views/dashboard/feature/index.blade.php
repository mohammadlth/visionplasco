@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')
    <section class="card col-span-2 xl:col-span-1 p-3">

        <table class="table-auto w-full text-right">
            <thead>
            <tr class="border-t">
                <th class="px-4 py-2 border-r">لیست ویژگی ها</th>
                <td class="px-4 py-2 border-l" colspan="6">
                    <a href="{{route('features.create' , ['page' => $items->currentPage()])}}"
                       class="bg-green-500 text-white float-left px-3 py-1 rounded-sm">
                        <i class="fa fa-plus"></i>
                        افزودن </a>
                </td>
            </tr>
            <tr>
                <th class="px-4 py-2 border-r border-t">شناسه</th>
                <th class="px-4 py-2 border-r border-t">عنوان</th>
                <th class="px-4 py-2 border-t">وضعیت</th>
                <th class="px-4 py-2 border-t">ترتیب نمایش</th>
                <th class="px-4 py-2 border-l border-t">مدیریت</th>
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

                        <td class="border border-l-0 px-4 py-2">{{$value->title}}</td>
                        <td class="border border-l-0 px-4 py-2">
                            @if($value->status == 0)
                                <span class="text-red-500 text-xs"> غیر فعال </span>
                            @else
                                <span class="text-green-500 text-xs"> فعال </span>
                            @endif
                        </td>
                        <td class="border border-l-0 px-4 py-2">{{$value->sort}}</td>
                        <td class="border border-l-0 px-4 py-2">
                            <a href="{{route('features.edit' , [$value->id , 'page' => $items->currentPage()])}}"
                               class="text-xs bg-blue-500 px-3 py-2 rounded-sm  text-white ml-1">
                                <i class="fa fa-pen text-xs text-white mx-1"></i>
                                ویرایش
                            </a>
                        </td>
                        <td class="border px-4 py-2 border-l">
                            <form class="delete-form text-center" method="post"
                                  action="{{route('features.destroy' , $value->id)}}">
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
