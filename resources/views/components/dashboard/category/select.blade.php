<option {{!is_null($selected) ? ($selected == $item->id ? ' selected ' : null) : null}} value="{{$item->id}}">
    @if(isset($item->parent->parent->parent->parent->parent))
        {{$item->parent->parent->parent->parent->parent->title}} >
    @endif
    @if(isset($item->parent->parent->parent->parent))
        {{$item->parent->parent->parent->parent->title}} >
    @endif
    @if(isset($item->parent->parent->parent))
        {{$item->parent->parent->parent->title}} >
    @endif
    @if(isset($item->parent->parent))
        {{$item->parent->parent->title}} >
    @endif
    @if(isset($item->parent))
        {{$item->parent->title}} >
    @endif
    {{$item->title}}
</option>