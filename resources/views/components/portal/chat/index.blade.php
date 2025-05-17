<div class="user-chat-info p-2 sm:border-r-2 flex gap-2 items-center justify-between relative">
    <div class="flex gap-2 items-center">
        @if($chat->contact && $chat->contact->info->profile_pic)
            <img src="{{url($chat->contact->info->profile_pic)}}" class="w-10 h-10 rounded-full h-auto" alt="کاربر"/>
        @else
            <img src="{{asset('assets/portal/img/user-none.png')}}" class="w-10 h-auto" alt="کاربر"/>
        @endif
        <p class="text-sm">{{$chat->contact->name}}</p>
        @if($chat->contact->confirm_identity)
            <strong class="text-[9px] bg-green-500 px-2 text-white rounded-full">
                <i class="fa fa-shield text-white"></i>
                احراز شده
            </strong>
        @else

            <strong class="text-[9px] bg-red-300 px-2 text-white rounded-full">
                <i class="fa fa-shield text-white"></i>
                احراز نشده
            </strong>
        @endif
        @if($chat->contact->info->score > 0)
            <div class="starts-rate flex gap-1">
                @for($i = 0;$i < $chat->contact->info->score;$i++)
                    <i class="fa fa-star text-yellow-500 text-sm"></i>
                @endfor
                @for($i = 0;$i < 5 - $chat->contact->info->score;$i++)

                    <i class="fal fa-star text-yellow-500 text-sm"></i>
                @endfor

            </div>
        @endif
    </div>
    <div class="">
        <div class="leading-[13px] show-option-user">
            <i class="fal fa-ellipsis-v text-[25px] w-2 text-center cursor-pointer"></i>
            <ul
                    class="z-50 list-option hidden absolute w-24 bg-white shadow-2xl p-2 rounded-md left-5 grid gap-3">
                <li class="text-[11px]">
                    <a href="" class="text-gray-600">
                        <i class="fas fa-user text-xs"></i>
                        پروفایل کاربر
                    </a>
                </li>
                <li class="text-[11px]">
                    <a href="" class="text-gray-600">
                        <i class="fas fa-ban text-xs"></i>
                        گزارش تخلف
                    </a>
                </li>
                <li class="text-[11px]">
                    <a href="" class="text-gray-600">
                        <i class="far fa-comments text-xs"></i>
                        ثبت نظر
                    </a>
                </li>
                <li class="text-[11px]">
                    <a href="" class="text-gray-600">
                        <i class="far fa-hand text-xs"></i>
                        بلاک کردن
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="chat-box">
    <div class="h-[350px] sm:h-[400px] chat-box-content overflow-y-auto relative">
        @foreach($comments as $key => $items)
            <div class="part">
                <p class="text-center">
                    <span class="bg-rounded-md bg-green-50 w-auto text-gray-800 rounded-full px-5 py-1 text-xs shadow-md">{{$key}}</span>
                </p>
                <ul class="messages-list overflow-x-hidden mt-3 px-3">

                    @foreach($items as $value)
                        @php
                            $item = null;
                        @endphp
                        @if(!is_null($value->refrense))
                            @php
                                $explode = explode('-' , $value->refrense);
                                if($explode[0] == 'zgp'){
                                    $item = \App\Models\Product::find($explode[1]);
                                }
                            @endphp
                        @endif

                        <li class="{{$value->sender_id == Auth::id() ? ' message-box-self ' : ' message-box-user '}}  message-box">
                            <div class="text shadow-md">
                                @if($item)
                                    @if($explode[0] == 'zgp')
                                        <p class="text-xs text-gray-800 leading-5 mb-1">
                                            محصول :
                                            <code><a target="_blank"
                                                     href="{{route('product.show' , [$item->id , $item->slug])}}">{{$item->full_name}}</a></code>
                                        </p>
                                    @endif
                                @endif
                                <p class="text-xs text-gray-800 leading-5">
                                    {{$value->message}}</p>
                                <p class="text-left mb-0">
                                    <span class="text-gray-500 text-[9px] text-left">{{verta($value->created_at)->format('Y/m/d H:i')}}</span>
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>
<div class="send-message p-3 bg-gray-100 flex gap-2 relative">
    <button class="btn bg-[#49b9c7] w-10 h-9 shadow-md flex items-center justify-center pl-[1px] rounded-full onclick-btn">
        <img src="{{asset('assets/portal/img/send.png')}}"/>
    </button>
    <input class="border w-full rounded-full px-2 py-2 text-xs message-input" placeholder="پیام خود را بنویسید"/>
</div>
