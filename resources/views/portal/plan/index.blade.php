@extends('layouts.portal')
@section('css')
    <link href="{{asset('assets/portal/plugins/count_down/index.css')}}" rel="stylesheet">
@endsection
@section('body')

    <section class="content my-5">
        <div class="relative overflow-x-auto rounded-md">

            @if(Session::get('payment_success'))
                <p class="w-full bg-green-500 text-white rounded-md px-3 py-2 mb-3"> {{Session::get('payment_success') }} </p>
            @endif

            @if(Session::get('payment_error'))
                <p class="w-full bg-red-500 text-white rounded-md px-3 py-2 mb-3"> {{Session::get('payment_error') }} </p>
            @endif

            <p class="text-center">
                <i class="fal fa-star text-3xl"></i>
            </p>
            <h1 class="text-xl text-center font-bold text-gray-700"> شروع حرفه ای = فروش سریع </h1>
            <p class="text-center text-md mt-5 text-gray-500"> با انتخاب هر یک از بسته های حرفه‌ای زیر محصولات خود را
                سریع تر از رقبا بفروشید.</p>
            <div class="max-w-[1200px] mx-auto mt-5">
                @if($expire == 1)
                    @if(Auth::user()->vip_account == 0)
                        <p class="w-full p-3 rounded-md bg-red-500 text-white text-center">
                            کاربر گرامی مدت زمان استفاده رایگان از خدمات

                            {{config('app.name_fa')}}
                            برای شما به اتمام رسیده است برای ادامه
                            یکی از پلن های زیر را انتخاب کنید
                        </p>
                    @else
                        <p class="w-full p-3 rounded-md bg-red-500 text-white text-center">
                            کاربر گرامی اشتراک شما به پایان رسیده است
                        </p>
                    @endif
                @endif

                @if(!is_null($setting->value))

                    @php
                        $data = json_decode($setting->value);
                    @endphp

                    <div class="p-5 bg-gray-200 rounded-sm bg-cover"
                         style="background-image: url('{{url('assets/img/bg-off.jpg')}}');    background-position: bottom;">
                        <div class="grid md:flex gap-2 justify-between items-center">
                            <div class="description text-xl font-bold  text-gray-900 bg-white bg-opacity-50 p-3 rounded-sm">
                                {!! $data->description !!}
                            </div>
                            <div class="timer min-w-[250px] bg-white p-3 rounded-md shadow-md text-shadow-md">
                                <div id="Countdown"></div>
                            </div>

                        </div>
                    </div>

                @endif

                <div class="grid grid-cols-1 md:grid-cols-4 mt-5 gap-5">
                    @foreach($plans as $value)
                        @if($value->vip)
                            <div class="item bg-white  rounded-md shadow-md border-4 border-green-500 zoom-2"
                                 style="zoom: 1.1">
                                <div class="bg-green-500 text-center text-white p-2">
                                    پرفروش ترین
                                </div>
                                <div class="header p-1">
                                    <h2 class="text-center text-md font-bold text-gray-800 font-bold">
                                        <span>{{$value->title}}</span>
                                    </h2>
                                    @if($value->price_off <= 0)
                                        <p class="text-3xl text-center my-8">
                                            {{number_format($value->price)}}
                                            <small class="text-sm text-gray-500"> تومان </small>
                                        </p>
                                    @else
                                        <p class="text-3xl text-center my-3 text-green-500">
                                            {{number_format($value->price_off)}}
                                            <small class="text-sm text-green-500"> تومان </small>
                                        </p>
                                        <p class="text-xl text-center my-4 text-red-500" style="">
                                            <span class="text-red-500"
                                                  style="text-decoration: line-through;">{{number_format($value->price)}}</span>
                                            <small class="text-sm text-red-500"> تومان </small>
                                        </p>
                                    @endif
                                    <div class="my-3 text-center">
                                        <a class="border-2 text-sm hover:bg-green-500 hover:text-white font-semibold rounded-md border-green-500 text-green-500 py-2 px-3"
                                           href="{{route('portal.payment' , $value->id)}}"> انتخاب و پرداخت </a>
                                    </div>

                                    @if($value->feature != "null" && !is_null($value->feature))
                                        <div class="text mt-6">
                                            <ul class="p-2 grid grid-cols-1 gap-3 border-t">
                                                @foreach(json_decode($value->feature) as $value)
                                                    <li class="flex  items-center gap-2">
                                                        <svg data-v-0e02171e="" width="24" height="24"
                                                             viewBox="0 0 24 24"
                                                             fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path data-v-0e02171e=""
                                                                  d="M8.5 16.5858L4.70711 12.7929C4.31658 12.4024 3.68342 12.4024 3.29289 12.7929C2.90237 13.1834 2.90237 13.8166 3.29289 14.2071L7.79289 18.7071C8.18342 19.0976 8.81658 19.0976 9.20711 18.7071L20.2071 7.70711C20.5976 7.31658 20.5976 6.68342 20.2071 6.29289C19.8166 5.90237 19.1834 5.90237 18.7929 6.29289L8.5 16.5858Z"
                                                                  fill="#6FCF97"></path>
                                                        </svg>
                                                        <span class="text-xs">{!! $value !!}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @else
                            <div class="item bg-white p-2 rounded-md shadow-md">
                                <div class="header p-2">
                                    <h2 class="text-center text-md  text-gray-800">{{$value->title}}</h2>
                                    @if($value->price_off <= 0)
                                        <p class="text-3xl text-center my-8">
                                            {{number_format($value->price)}}
                                            <small class="text-sm text-gray-500"> تومان </small>
                                        </p>
                                    @else
                                        <p class="text-3xl text-center my-3 text-green-500">
                                            {{number_format($value->price_off)}}
                                            <small class="text-sm text-green-500"> تومان </small>
                                        </p>
                                        <p class="text-xl text-center my-4 text-red-500" style="">
                                            <span class="text-red-500"
                                                  style="text-decoration: line-through;">{{number_format($value->price)}}</span>
                                            <small class="text-sm text-red-500"> تومان </small>
                                        </p>
                                    @endif
                                    <div class="my-3 text-center">
                                        <a class="border-2 text-sm hover:bg-green-500 hover:text-white font-semibold rounded-md border-green-500 text-green-500 py-2 px-3"
                                           href="{{route('portal.payment' , $value->id)}}"> انتخاب و پرداخت </a>
                                    </div>

                                    @if(!is_null($value->feature))
                                        <div class="text mt-6">
                                            <ul class="p-2 grid grid-cols-1 gap-3 border-t">
                                                @foreach(json_decode($value->feature) as $value)
                                                    <li class="flex  items-center gap-2">
                                                        <svg data-v-0e02171e="" width="24" height="24"
                                                             viewBox="0 0 24 24"
                                                             fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path data-v-0e02171e=""
                                                                  d="M8.5 16.5858L4.70711 12.7929C4.31658 12.4024 3.68342 12.4024 3.29289 12.7929C2.90237 13.1834 2.90237 13.8166 3.29289 14.2071L7.79289 18.7071C8.18342 19.0976 8.81658 19.0976 9.20711 18.7071L20.2071 7.70711C20.5976 7.31658 20.5976 6.68342 20.2071 6.29289C19.8166 5.90237 19.1834 5.90237 18.7929 6.29289L8.5 16.5858Z"
                                                                  fill="#6FCF97"></path>
                                                        </svg>
                                                        <span class="text-xs">{!! $value !!}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </div>
                            </div>

                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </section>

@endsection
@section('js')
    <script src="{{asset('assets/portal/plugins/count_down/jquery.plugin.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/portal/plugins/count_down/index.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/portal/plugins/count_down/jquery.countdown-fa.js')}}" type="text/javascript"></script>
    <script>
        $(function () {

            var austDay = new Date();
            austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
            $('#Countdown').countdown({until: +{{$leftTimer}}});
        });
    </script>
@endsection
