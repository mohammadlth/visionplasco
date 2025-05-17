@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">
        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-eyes"></i>
            <span> مشاهده رویداد :  </span>
            <span> {{$item->id}} </span>
        </p>
        <div class="mt-3">
            <p> {{$item->title}} </p>
            <p> {{$item->action}} </p>
            @php
                $item = json_decode($item->params);
            @endphp

            @foreach($item as $key => $value)
                <p>
                    <span>{{$key}} : </span>
                    <span>{{$value}}</span>
                </p>
            @endforeach
        </div>
    </section>


@endsection
@section('js')

@endsection
