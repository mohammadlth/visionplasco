<nav class="cd-dropdown">
    <a href="#0" class="cd-close">بستن</a>
    <ul class="cd-dropdown-content">
        @foreach($categories as $category)
            @if(count($category->children) > 0)
                <li class="has-children">
                    <a href="{{route('product.category' , [$category->id , $category->slug])}}">{{$category->title}}</a>
                    <ul class="cd-secondary-dropdown is-hidden">
                        <li class="go-back"><a href="#0">بازگشت</a></li>
                        @foreach($category->children as $cat)
                            @if(count($cat->children) > 0 && $cat->status == 1)
                                <li class="has-children">
                                    <a href="{{route('product.category' , [$cat->id , $cat->slug])}}">{{$cat->title}}
                                    </a>
                                    <button class="remove-in-mobile  items-center gap-1 hidden sm:flex" style="font-size: 12px;float: left;margin-top: -32px;color: red;" onclick="location.replace('{{route('product.category' , [$cat->id , $cat->slug])}}')">
                                        مشاهده همه
                                    <i class="fal fa-angle-left" style="margin-top: 2px;color: red"></i>
                                    </button>
                                    <ul class="is-hidden mr-2 md:grid md:grid-cols-5 gap-1">
                                        <li class="go-back"><a href="#0">بازگشت</a>
                                        @foreach($cat->children as $c)
                                            @if($c->status == 1)
                                                <li>
                                                    <a href="{{route('product.category' , [$c->id , $c->slug])}}">{{$c->title}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li>
                                    <a href="{{route('product.category' , [$cat->id , $cat->slug])}}">{{$cat->title}}</a>
                                    <button class="remove-in-mobile items-center gap-1 hidden sm:flex" style="font-size: 12px;float: left;margin-top: -32px;color: red;" onclick="location.replace('{{route('product.category' , [$cat->id , $cat->slug])}}')">
                                        مشاهده همه
                                        <i class="fal fa-angle-left" style="margin-top: 2px;color: red"></i>
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @else
                <li>
                    <a href="{{route('product.category' , [$category->id , $category->slug])}}">{{$category->title}}</a>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
