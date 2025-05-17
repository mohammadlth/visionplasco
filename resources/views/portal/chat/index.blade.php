@extends('layouts.portal')

@section('body')

    <section class="content my-5">

        <div class="box-chat  rounded-md bg-white rounded-l-md">
            <div class="grid grid-cols-1 md:grid-cols-12">

                <div class="md:col-span-3 mx-2 mb-0 box-content-relative">
                    <div class="">
                        @if(count($contacts) > 0 )
                            @include('components.portal.chat.contact')
                        @else
                            <ul class="mt-3 min-h-[400px] overflow-auto p-2">
                                <li>
                                    <img class="mx-auto" src="{{asset('assets/portal/img/empty.svg')}}">
                                    <p class="text-center mt-2 text-gray-500 text-sm mt-3"> هیج پیامی ندارید </p>
                                    <p class="text-center mt-2 text-gray-500 text-xs mt-3">
                                        برای شروع گفتگو با خریداران و فروشندگان زاگرین، پیام ارسال کنید.
                                    </p>
                                    @if(Auth::user()->account == 'seller')
                                        <div class="mt-5 text-center">
                                            <a href="{{route('portal.request.list')}}"
                                               class="text-center bg-blue-500 rounded-sm p-3 mx-auto text-xs text-white rounded-md">
                                                مشاهده خریداران
                                            </a>
                                        </div>
                                    @else
                                        <div class="mt-5 text-center">
                                            <a href="{{url('/')}}"
                                               class="text-center bg-blue-500 rounded-sm p-3 mx-auto text-xs text-white rounded-md">
                                                مشاهده فروشندگان
                                            </a>
                                        </div>
                                    @endif
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-9 relative hidden sm:block chat-box-relative">
                    <div class="back-chat sm:hidden px-2 border-t-2 border-gray-50 flex items-center justify-start gap-2">
                        <i class="fal fa-angle-right text-2xl"></i>
                        <span class="text-xs"> بازگشت </span>
                    </div>

                    <div class="chat-req-box">
                        @include('components.portal.chat.empty')
                    </div>

                    @if(Auth::user()->confirm_identity == 0)
                        <div class="alert alert-warning shadow-lg absolute  text-xs bottom-24 z-[99] p-5 bg-blue-200  rounded-lg text-right right-10 left-10">
                            <p>
                                <i class="fa fa-info-circle text-blue-500 mx-1"></i>
                                کاربر گرامی برای جلب اعتماد در معاملات خود نسبت به تکمیل پروفایل و احراز هویت
                                اقدام کنید
                                <a href="{{route('verification.index')}}" class="text-blue-900 font-bold"> (احراز
                                    هویت) </a>
                                <button class="close absolute left-3 top-2"
                                        onclick="$(this).parent().parent().hide('1s')">
                                    <i class="fal fa-times text-red-500 text-lg"></i>
                                </button>

                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

@endsection
@section('js')
    <script src="{{asset('assets/portal/js/chat.js?ver=1.2')}}" type="text/javascript"></script>
@endsection
