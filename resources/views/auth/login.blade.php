@extends('layouts.front')

@section('body')
    <section class="w-full mx-auto">
        <div class="w-96 max-w-full mx-auto mt-10 border border-gray-100 rounded-md p-3">
            <div class="header text-center">
                <img src="{{asset('assets/img/logo.png')}}" class="w-64 mx-auto" alt="{{config('app.name')}}">
                <p class="text-center text-semibold"><b> ورود | ثبت نام</b></p>

            </div>
            <div class="content-auth mt-3">
                @include('components.auth.exist')
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{asset('assets/js/auth.js?ver=2.3')}}"></script>
@endsection
