@extends('layouts.front')

@section('body')

    <section class="mt-20">
        <div class="mx-auto max-w-[1240px] px-[10px] md:px-6 lg:px-8 xl:px-0">
            @if($article->photo)
                <img src="{{url($article->photo)}}" alt="{{$article->title}}"
                     class="w-auto mx-auto rounded-3xl object-cover md:h-auto"/>
            @endif

        </div>
    </section>
    <!-- blog content section -->
    <section class="mt-12">
        <!-- container | box width -->
        <div class="mx-auto max-w-[1240px] px-[10px] md:px-6 lg:px-8 xl:px-0">
            <div class="rounded-3xl border border-primary px-2 py-5 md:p-12 md:pb-10">
                <!-- title -->
                <h1 class="mb-4 text-lg font-bold text-secondary md:mb-10 md:text-3xl">
                    {{$article->title}}
                </h1>
                <div>
                    <div class="text-justify text-xs leading-8 text-blogGray md:text-lg">
                        {!! $article->text !!}
                    </div>

                </div>
                <div class="mt-5 border-t border-primary pt-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">

                        </div>
                        <span class="font-lg text-xs font-bold text-gray md:text-sm">

                  {{Verta($article->created_at)->format('%d %B  %Y')}}
                </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('js')


@endsection
