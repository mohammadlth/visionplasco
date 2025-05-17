<div class="search-drop-down top-[44px] ml-[43px] rounded-b-lg left-0 right-0 p-3 bg-white absolute shadow-md max-h-[350px] overflow-x-auto z-20">
    @if(count($lists) > 0)
        <ul class="grid grid-cols-1 gap-1">
            @foreach($lists as $value)
                <li class="mt-2 text-right">
                    <a href="{{$value['url']}}" class="flex gap-2 justify-between items-center">
                        <span class="text-xs sm:text-md">  {{$value['title']}} </span>
                        <i class="fa fa-angle-left text-gray-700 text-sm"></i>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-sm my-3 text-gray-500"> متاسفانه چیزی پیدا نشد :(</p>
    @endif
</div>
