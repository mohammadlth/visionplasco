@extends('layouts.front')

@section('body')

    <section class="max-w-6xl mx-auto pt-6 md:pt-5 px-5">
        <div class="md:col-span-8">
            <div class="header-products relative shadow-lg">
                <img src="{{asset('assets/img/zagrin7.jpg')}}" class="w-full hidden sm:block rounded-md"
                     alt="مقالات">
                <div class="block sm:hidden bg-cover min-h-[200px]"
                     style="background-image: url('{{asset('assets/img/zagrin7.jpg')}}')"></div>

                <div class="absolute top-0 right-0 left-0 bottom-0 p-5 bg-black bg-opacity-25 rounded-lg min-h-[200px]">

                    <div class="">

                        <h3 class="text-xl font-semibold text-white"> مقالات </h3>

                        <nav class="absolute bottom-5">
                            <ul class="text-xs text-gray-300 flex gap-3 breadcrumb">
                                <li class="hidden sm:block">
                                    <a href="{{url('/')}}">
                                        <i class="fal fa-home text-white"></i>
                                        <span class="text-white">خانه</span>
                                        <i class="fal fa-angle-left text-white"></i>
                                    </a>
                                </li>
                                <li class="hidden sm:block">
                                    <a href="#" class="text-white">
                                        مقالات
                                    </a>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto pt-6 md:pt-5 px-5">
        <div class="items">

            <div class="content-articles">
                @if(count($articles) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-4">
                        @foreach($articles as $value)
                            <div class="">
                                @include('components.blog.card' , ['width' => 400 , 'height' => 300 , 'item' => $value])
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="nothing text-center">
                            <img src="{{asset('assets/img/empty-96.png')}}" class="mx-auto"/>
                            <h5> چیزی پیدا نشد </h5>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

@endsection


@section('js')


@endsection
