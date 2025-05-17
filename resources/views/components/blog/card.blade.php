<div class="relative flex rounded-2xl bg-white pb-11 border border-gray-200 md:block">
    @if($item->photo)
        <img src="{{url($item->photo)}}" alt="{{$item->title}}"
             class="w-32 rounded-t-2xl  md:w-full shadow-sm"/>
    @endif

    <div class="px-4">
        <p class="mt-3 text-sm font-bold text-secondary">
            <strong>{{$item->title}}</strong>
        </p>
        <p class="mt-3 line-clamp-3 whitespace-normal text-right text-sm font-medium text-gray">
            {{mb_strimwidth($item->short_text , 0 , 150 , '....')}}
        </p>
    </div>
    <div class="absolute -bottom-5 flex w-full justify-center">
        <a href="{{route('articles.show' , $item->slug)}}"
           class="inline-block rounded-md bg-dark px-7 py-2 text-sm font-bold text-white transition hover:bg-dark">ادامه مطلب</a>
    </div>
</div>
