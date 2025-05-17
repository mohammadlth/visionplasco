@if(count($products) > 0 || count($similar) > 0)
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mt-3 infinite-scroll">
        @foreach($products as $key =>  $value)
            @include('components.product.card' , ['product' => $value])
            @if(isset($banners))
                @if($key == 7 || count($products) < 8)
                    @foreach($banners as $i => $val)
                        <div class="col-span-4">
                            <a href="{{$val->link}}">
                                <img src="{{url($val->photo)}}" alt="{{$val->title}}" class="w-100">
                            </a>
                        </div>
                    @endforeach
                @endif
            @endif
        @endforeach

        @if(isset($similar))
            @foreach($similar as $key =>  $value)
                @include('components.product.card' , ['product' => $value])
            @endforeach
        @endif
    </div>
@else
    @if(count($similar) == 0)
        <div class="grid grid-cols-1 mt-3">
            <div class="w-full p-3 text-center roubded-md">
                <img src="{{asset('assets/img/empty-96.png')}}" class="mx-auto">
                <p class="text-center text-gray-400 mt-3"> چیزی برای نمایش در این دسته وجود ندارد </p>
            </div>
        </div>
    @endif
@endif
