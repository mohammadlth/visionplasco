@extends('layouts.front')
@section('body')

    <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">

        <h2 class="text-center text-2xl mt-3 font-bold text-gray-900"> اپلیکیشن
            <b class="mx-2 text-custom-500"> {{config('app.name_fa')}} </b>
        </h2>

        <div class="grid grid-cols-1 md:w-4/5 w-full mx-auto mt-3">
            <h2 class="text-center mt-4 text-md font-semibold">
                برای رفاه حال شما مشتریان عزیز و کاربری آسان تر اپلیکیشن زاندس منتشر شد.
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-3">
                <div class="text-justify mt-4 text-center">
                    <img src="{{asset('assets/img/android.png')}}" class="w-[150px] mx-auto" alt="اندروید">
                    <p class="text-center mt-3">
                        <a href="{{asset('assets/app/zandes-1.0.0.apk')}}" class="mx-auto" rel="downlad"> <b>دانلود مستقیم نسخه اندروید</b> </a>
                    </p>
                </div>
                <div class="text-justify mt-4">
                    <img src="{{asset('assets/img/ios.png')}}" class="w-[150px] mx-auto" alt="ios">
                    <p class="text-center mt-3">
                        <a href="https://pwa.zandes.ir" target="_blank" class="mx-auto"> <b>نسخه آیفون</b> </a>
                    </p>
                </div>
            </div>
    </section>

@endsection
@section('js')

@endsection
