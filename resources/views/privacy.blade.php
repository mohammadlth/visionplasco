@extends('layouts.front')
@section('body')

    <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">

        <h2 class="text-right text-xl mt-3 font-bold text-gray-900"> قوانین و حریم شخصی
            <b class="mx-2 text-custom-500"> {{config('app.name_fa')}} </b>
        </h2>

        <div class="grid grid-cols-1 w-full mx-auto mt-3">
            {!! $item->value !!}
        </div>
    </section>

@endsection
@section('js')

@endsection
