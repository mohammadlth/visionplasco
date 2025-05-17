@extends('layouts.front')
@section('body')

    <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">

        <h2 class="text-center text-2xl mt-3 font-bold text-gray-900"> درباره
            <b class="mx-2 text-custom-500"> {{config('app.name_fa')}} </b>
        </h2>

        <div class="grid grid-cols-1 md:w-4/5 w-full mx-auto mt-3">
            <h2 class="text-justify mt-4 text-xl font-semibold">
                معرفی
                {{config('app.name_fa')}}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-1 gap-2">

                <div class="sm:col-span-2">
                    <div class="text-justify mt-4">
                        {!! $item->value !!}
                    </div>
                </div>


            </div>
    </section>

@endsection
@section('js')

@endsection
