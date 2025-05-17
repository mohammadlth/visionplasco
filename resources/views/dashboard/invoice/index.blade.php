@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')
    <section class="card col-span-2 xl:col-span-1 p-3">

        <table class="table-auto w-full text-right">
            <thead>
            <tr class="border-t">
                <th class="px-4 py-2 border-r">پرداخت ها</th>
            </tr>
            <tr>
                <th class="px-4 py-2 border-r border-t">#</th>
                <th class="px-4 py-2 border-r border-t">کاربر</th>
                <th class="px-4 py-2 border-r border-t">مبلغ</th>
                <th class="px-4 py-2 border-r border-t">پلن</th>
                <th class="px-4 py-2 border-r border-t">کد پیگیری</th>
                <th class="px-4 py-2 border-r border-t">وضعیت</th>
                <th class="px-4 py-2 border-r border-l border-t text-center"> تاریخ</th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @if(count($items) > 0)
                @foreach($items as $value)
                    <tr>
                        <td class="border border-l-0 px-4 py-2 text-right text-black">{{$value->id}}</td>
                        <td class="border border-l-0 px-4 py-2">
                            {{$value->user ? $value->user->name . ' - ' . $value->user->mobile : 'نا معلوم'}}
                        </td>
                        <td class="border border-l-0 px-4 py-2">{{number_format($value->amount)}} ریال</td>
                        <td class="border border-l-0 px-4 py-2">
                            {{$value->description}}
                        </td>
                        <td class="border border-l-0 px-4 py-2">
                            {{$value->sale_reference_id}}
                        </td>
                        <td class="border px-4 py-2 border-l">
                            @if($value->status == 0)
                                <span class="text-yellow-500"> درانتظار </span>
                            @elseif($value->status == -1)
                                <span class="text-red-500"> پرداخت نشده </span>
                            @elseif($value->status == 1)
                                <span class="text-green-500"> پرداخت شده </span>
                            @endif
                        </td>
                        <td class="border border-l px-4 py-2 text-center text-gray-500">
                            {{Verta($value->created_at)->format('Y/m/d H:i:s')}}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="border border-l px-4 py-2 text-center text-gray-500">
                        چیزی در این جدول یافت نشد
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
