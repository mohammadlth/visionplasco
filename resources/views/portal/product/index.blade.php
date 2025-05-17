@extends('layouts.portal')
@section('navbar')
    <li class="list-inline-item">وب سایت ها</li>
@endsection
@section('body')

    <section class="content my-5">
        <div class="relative overflow-x-auto rounded-md">
            @if(!Auth::user()->vip_account)
                <div class="alert bg-green-500 rounded-md text-xs w-full p-3 mb-3 text-white">
                    برای فروش سریع محصولات خود اکانت خود را
                    <a href="{{route('portal.plan')}}"
                       class="bg-white px-3 py-1 rounded-sm text-green-500 mx-2 text-xs">
                        <i class="fa fa-star text-green-500"></i>
                        ارتقاع دهید
                    </a>
                </div>
            @endif
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">
                        محصول
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        نوع
                    </th>
                    <th scope="col" class="px-6 py-3 text-center min-w-[180px]">
                        وضعیت
                    </th>
                    <th scope="col" class="px-6 py-3 text-center min-w-[180px]">
                        تغییر وضعیت
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        دسترسی
                    </th>
                </tr>
                </thead>
                <tbody>

                @if(count($products) > 0)
                    @foreach($products as $value)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 text-center">
                                @if($value->category)
                                    {{$value->category->title}}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{$value->type}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($value->status == 'waiting')
                                    <span class="bg-yellow-400 px-2 py-1 rounded-sm text-white"
                                          style="font-size: 10px"> در انتظار بررسی </span>
                                @elseif($value->status == 'confirm')
                                    <span class="bg-green-500 px-2 py-1 rounded-sm text-white" style="font-size: 10px">فعال</span>
                                @elseif($value->status == 'reject')
                                    <span class="bg-red-500 px-2 py-1 rounded-sm text-white" style="font-size: 10px">رد شده</span>
                                    <p style="font-size: 12px;margin-top: 5px">
                                        {{$value->description_reject}}
                                    </p>
                                @endif
                            </td>
                            <td>
                                @if($value->show == 1)
                                    <div class="flex gap-2 justify-center">
                                        <a href=""
                                           class="bg-green-500 rounded-sm px-2 py-1 text-white text-xs opacity-25"> فعال
                                            کنید </a>
                                        <a href="{{route('portal.product.show' , [$value->id , 0])}}"
                                           class="bg-red-500 rounded-sm px-2 py-1 text-white text-xs"> غیر فعال
                                            کنید </a>
                                    </div>
                                @else
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{route('portal.product.show' , [$value->id , 1])}}"
                                           class="bg-green-500 rounded-sm px-2 py-1 text-white text-xs"> فعال کنید</a>
                                        <a href=""
                                           class="bg-red-500 rounded-sm px-2 py-1 text-white text-xs opacity-25"> غیر
                                            فعال کنید </a>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center">
                                    <a href="{{route('portal.product.info' , $value->id)}}"
                                       class="bg-blue-500 rounded-sm flex justify-center items-center ml-2 py-1 px-2 w-fit">
                                        <i class="fa fa-eye text-white text-xs"></i>
                                        <span class="mx-1 text-white text-xs"> مشاهده </span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="bg-gray-100">
                        <td class="px-6 py-4 text-center" colspan="5">
                            <p class="text-center text-gray-400"> محصولی ثبت نکرده اید
                                <a href="{{route('portal.product.store')}}" class="text-blue-700"> ثبت محصول </a>
                            </p>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="text-center my-3">
                {!! $products->links() !!}
            </div>
        </div>


    </section>

@endsection
@section('js')

@endsection
