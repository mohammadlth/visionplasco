<ul id="list-cat-{{$item->id}}" class="steps  grid gap-2 mt-3 list-category hidden">
    @foreach($item->children as $value)
        <li id="cat-{{$value->id}}"
            class="cursor-pointer">
            <div class="flex justify-between items-center"
                 onclick="setCatValue({{$item->id}} , {{$value->id}} , '{{$value->title}}' , '{{$prev}}' , {{count($value->children) > 0 ?"'#list-cat-$value->id'" : 0}})">
                <span class=""> {{$value->title}} </span>
                <i class="fal fa-arrow-left text-gray-500"></i>
            </div>
        </li>
    @endforeach
</ul>

@foreach($item->children as $value)
    @if(count($value->children) > 0)
        @include('components.product.category' , ['item' => $value ,  'prev' => '#list-cat-' . $item->id])
    @endif
@endforeach