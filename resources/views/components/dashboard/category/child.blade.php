@foreach($item->children as $value)
    <tr>
        <td class="border border-l-0 px-4 py-2 text-right text-black">
            <i class="fal fa-level-up" style="margin-right: {{$margin * 2}}px"></i>
            {{$value->id}}
        </td>

        <td class="border border-l-0 px-4 py-2">
            <i class="fal fa-level-up" style="margin-right: {{$margin * 2}}px"></i>
            {{$value->title}}
        </td>
        <td class="border border-l-0 px-4 py-2">
            @if($value->status == 0)
                <span class="text-red-500 text-xs"> غیر فعال </span>
            @else
                <span class="text-green-500 text-xs"> فعال </span>
            @endif
        </td>
        <td class="border border-l-0 px-4 py-2">{{$value->sort}}</td>
        <td class="border border-l-0 px-4 py-2">
            <a href="{{route('categories.edit' , [$value->id , 'page' => $items->currentPage()])}}"
               class="text-xs bg-blue-500 px-3 py-2 rounded-sm  text-white ml-1">
                <i class="fa fa-pen text-xs text-white mx-1"></i>
                ویرایش
            </a>
            <a href="{{route('products.index' , ['s' => 'zgc-' . $value->id])}}"
               class="text-xs bg-pink-500 px-3 py-2 rounded-sm  text-white ml-1">
                <i class="fa fa-box text-xs text-white mx-1"></i>
                محصولات
            </a>
        </td>
        <td class="border px-4 py-2 border-l">
            <form class="delete-form text-center" method="post"
                  action="{{route('categories.destroy' , $value->id)}}">
                @method('delete')
                @csrf
                <button type="submit"><i class="fa fa-trash text-red-500"></i></button>
            </form>
        </td>
    </tr>
    @if(count($value->children) > 0)
        @include('components.dashboard.category.child' , ['item' => $value ,  'margin' => $margin * 2])
    @endif
@endforeach

