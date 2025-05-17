@extends('layouts.front')
@section('body')

    <section class="max-w-6xl mx-auto pt-6 md:pt-10 px-5">

        <h2 class="text-center text-2xl mt-3 font-bold text-gray-900"> تماس با
            <b class="mx-2 text-custom-500"> {{config('app.name_fa')}} </b>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-1 gap-5">
            <div class="col-span-2">
                {!! $map->value !!}
            </div>

            <div class="info mt-5 rounded-md border-gray-200 p-3">
                <p> ارتباط با ما </p>
                <ul class="mt-5 grid gap-3">
                    <li>
                        <span class="text-gray-700 text-sm">
                            <i class="fal fa-phone"></i>
                             پشتیبانی :
                        </span>
                        <span class="font-semibold">
                            <a href="tel:{{$phones[0]}}">{{$phones[0]}}</a>
                        </span>

                    </li>
                    <li>
                        <span class="text-gray-700 text-sm">
                            <i class="fal fa-phone"></i>
                            همراه پشتیبانی :
                        </span>
                        <span class="font-semibold">
                            <a href="tel:{{$phones[1]}}">{{$phones[1]}}</a>
                        </span>

                    </li>

                    <li>

                        <span class="text-gray-700 text-sm">
                            <i class="fal fa-envelope"></i>
                            ایمیل :
                        </span>
                        <span class="font-semibold">
                            <a href="mailto:{{$email->value}}">
                                {{$email->value}}
                            </a>
                        </span>

                    </li>
                    <li>

                        <span class="text-gray-700 text-sm">
                            <i class="fal fa-globe"></i>
                            آدرس :
                        </span>
                        <span class="font-semibold">
                            {{$address->value}}
                        </span>

                    </li>

                </ul>
            </div>




        </div>
    </section>

@endsection
@section('js')


@endsection
