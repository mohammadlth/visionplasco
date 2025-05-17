@extends('layouts.portal')
@section('css')
    <link href="{{asset('assets/portal/plugins/upload/upload.css')}}" rel="stylesheet">
@endsection
@section('body')

    <section class="content my-5">
        <div class="relative overflow-x-auto rounded-md">
            <div class="bg-white p-5">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="photos border border-gray-300 rounded-md p-5">
                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <h3 class="text-md text-green-500 font-bold "> تصویر قابل قبول </h3>
                                <div class="grid grid-cols-1 mt-3">
                                    <img src="{{asset('assets/portal/img/sample-3-compact.jpg')}}"
                                         class="w-full sm:w-[250px] border-4 border-green-500  rounded-3xl">
                                </div>
                            </div>
                            <div>
                                <h3 class="text-md text-red-500 font-bold"> تصاویر غیر قابل قبول </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 mt-3 gap-3">

                                    <div class="">
                                        <img class="w-full  border-4 border-red-500  rounded-3xl"
                                             src="{{asset('assets/portal/img/sample-2-compact.jpeg')}}" alt="">
                                    </div>
                                    <div class="">
                                        <img class="w-full  border-4 border-red-500  rounded-3xl"
                                             src="{{asset('assets/portal/img/sample-4-compact.jpg')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content border border-gray-200 rounded-md p-5 bg-gray-100">
                        @if(!is_null($identity))
                            <div class="mb-5">

                                @if($identity->status == 'waiting')
                                    <div class="bg-yellow-300 p-3 rounded-md mb-3 text-xs">
                                        اطلاعات شما در حال بررسی میباشد
                                    </div>
                                @elseif($identity->status == 'confirm')
                                    <div class="bg-green-500 p-3 rounded-md mb-3 text-xs text-white">
                                        اکانت شما احراز گردیده است
                                    </div>

                                @elseif($identity->status == 'reject')
                                    <div class="bg-red-300 p-3 rounded-md mb-3 text-white text-xs">
                                        خطا در احراز هویت لطفا در صورت لزوم مجددا احراز هویت را انجام دهید
                                    </div>
                                    @if(!is_null($identity->admin_text))
                                        <div class="mt-2 bg-blue-300 p-3 rounded-md mb-3 text-white text-xs">
                                            <strong class="text-white">پیام مدیریت :</strong>
                                            <br/>
                                            <p class="text-white">
                                                {!! $identity->admin_text !!}
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            </div>

                        @endif

                        <h2 class="text-black text-sm"> تصویر کارت ملی خود را بارگذاری کنید </h2>
                        <div class="mt-3">
                            <div class="items-center bg-white text-center h-[150px] border-2 border-dashed border-gray-300"
                                 id="verification_pic"></div>
                        </div>
                        @if(!is_null($identity))
                            @if($identity->status == 'confirm')
                                <div class="bg-blue-500 p-3 rounded-md mb-3 text-xs text-white mt-3">
                                    توجه : تغییر اطلاعات نیازمند بازبینی مجدد

                                    <strong class="text-white"> اطلاعات هویتی </strong>
                                    شما میباشد
                                </div>
                                <div class="mt-3 border border-gray-300 p-3">
                                    <img class="w-[150px] rounded-md shadow-sm"
                                         src="{{asset($identity->national_card)}}" alt="">
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>


        </div>

    </section>

@endsection
@section('js')
    <script src="{{asset('assets/portal/plugins/upload/index.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/portal/js/verification.js')}}" type="text/javascript"></script>
@endsection
