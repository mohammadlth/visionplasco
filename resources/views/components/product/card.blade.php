<div class="card-product w-auto bg-white shadow-md p-2 rounded-xl sm:max-w-[250px]">
    <a class="detail-product" href="{{route('product.show' , [$product->id , $product->slug])}}">
        @if($product->photo)
            <div class="w-full rounded-md product-img"
                 style="background-image: url('{{url($product->photo->path) }}');">
            </div>
        @else
            <div class="w-full rounded-md product-img"
                 style="background-image: url('{{url('assets/img/no-image.png')}}');background-size: auto;background-color: #f1f1f1">
            </div>
        @endif
        <div class="product-detail mt-3">
            <p class="text-black text-sm text-center min-h-[40px] flex justify-center items-center"> {{$product->full_name}} </p>
            <ul class="border border-gray-200 text-gray-500 grid grid-cols-2 rounded-md text-xs card-ul p-2 mt-3">
                <li class="text-center">
                    <i class="fa fa-inbox"></i>
                    @if($value->category)
                        {{unit_calculate($value->inventory , $value->category->unit)}}
                    @endif
                </li>
                <li class="text-center">
                    <i class="fa fa-map-pin"></i>
                    {{$value->city->name}}
                </li>
                <li class="text-center col-span-2 mt-2 border-t">
                    <p class="pt-2">
                        <strong class="font-semibold text-sm">{{number_format($value->min_price)}}</strong>
                        <small> تومان </small>
                    </p>
                </li>
            </ul>
        </div>
    </a>
</div>

