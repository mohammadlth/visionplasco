@extends('layouts.front')
@section('body')

    <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">

        <h2 class="text-center text-2xl mt-3 font-bold text-gray-900">
            {{$page->title}}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-1 gap-5 mt-5">
            @if($page->photo)
                <img src="{{url($page->photo)}}" alt="" class="w-full my-3">
            @endif


            {!! $page->text !!}


        </div>
    </section>

@endsection
@section('js')


@endsection
