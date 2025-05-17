<div class="head-chat p-2 bg-blue-600 rounded-t-lg flex justify-between items-center">
    <div class="user flex justify-between items-center gap-2">
        @if($chat->contact && $chat->contact->info->profile_pic)
            <img src="{{url($chat->contact->info->profile_pic)}}" class="w-10 h-10 rounded-full h-auto" alt="کاربر"/>
        @else
            <img src="{{asset('assets/portal/img/user-none.png')}}" class="w-10 h-10" alt="کاربر"/>
        @endif
        <p class="text-white text-xs user-chat-name">{{$chat->contact->name}}</p>
    </div>
    <div class="close-model-chat cursor-pointer">
        <i class="fal fa-times-circle text-white" style="transform: translateY(4px);"></i>
    </div>
</div>
<div class="model-items chat-box p-2">
    <div class="h-[350px] chat-box-content overflow-y-auto relative">
        <div class="chat-req-box relative">

            @if($product)
                <div class="product p-2 bg-white z-5 top-0 right-0 left-0 rounded-full text-xs shadow-md text-center"
                     style="position: sticky;z-index: 999">
                    {{$product->full_name}}
                </div>
                <input type="hidden" name="product_chat_id" value="zgp-{{$product->id}}">
            @endif

            @foreach($comments as $key => $items)
                <div class="part">
                    <p class="text-center">
                        <span class="bg-rounded-md bg-green-50 w-auto text-gray-800 rounded-full px-5 py-1 text-xs shadow-md">{{$key}}</span>
                    </p>
                    <ul class="messages-list overflow-x-hidden mt-3 px-3">

                        @foreach($items as $value)
                            <li class="{{$value->sender_id == Auth::id() ? ' message-box-self ' : ' message-box-user '}}  message-box">
                                <div class="text shadow-md">
                                    <p class="text-xs text-gray-800 leading-5">{{$value->message}}</p>
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
</div>

<div class="send-message p-3 bg-gray-100 flex gap-2 relative">
    <button class="btn bg-[#49b9c7] w-10 h-9 shadow-md flex items-center justify-center pl-[1px] rounded-full onclick-btn-box-send">
        <img src="{{asset('assets/portal/img/send.png')}}"/>
    </button>
    <input class="border w-full rounded-full px-2 py-2 text-xs message-input-box" placeholder="پیام خود را بنویسید"/>
</div>