@extends('layouts.portal')
@section('body')

    <div class="bg-white shopping-main rounded-md">
        <div class="row">
            <div class="col-md-12">


                @if(Session::get('payment_error'))

                    <h5 class="alert alert-danger"> {{Session::get('payment_error')}}  </h5>

                @endif


                @if(Session::get('payment_success'))

                    <h5 class="alert alert-success"> {{Session::get('payment_success')}}  </h5>

                @endif


                @if(isset($bank))

                    @if($bank['Success'])
                        <div class="text-center my-3 rounded-md p-5">
                            <h5 class="text-center my-3">انتقال به درگاه بانک</h5>


                            <form action="https://bpm.shaparak.ir/pgwchannel/startpay.mellat" method="POST">
                                <input type="hidden" id="RefId" name="RefId" value="{{$bank['RefId']}}">
                            </form>
                            @if($fast_redirect)

                                <script type="text/javascript">
                                    window.onload = formSubmit;

                                    function formSubmit() {
                                        document.forms[0].submit();
                                    }
                                </script>

                            @else

                                <button onclick="document.forms[0].submit()" class="bg-green-500 px-4 py-1 rounded-md  shadow-sm text-white">
                                    پرداخت مجدد
                                </button>

                            @endif
                        </div>
                    @else
                        <p class="text-center text-red-500 my-3">
                            خطا در اتصال به درگاه بانک لطفا با پشتیبانی تماس حاصل فرمایید
                        </p>
                    @endif
                @endif


            </div>
        </div>
    </div>

@endsection
@section('js')

@endsection
