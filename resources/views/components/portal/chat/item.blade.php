<li class="{{$item->sender_id == Auth::id() ? ' message-box-self ' : ' message-box-user '}}  message-box">
    <div class="text shadow-md">
        <p class="text-xs text-gray-800 leading-5">{{$item->message}}</p>
        <p class="text-left mb-0">
            <span class="text-gray-500 text-[9px] text-left">{{verta($item->created_at)->format('Y/m/d H:i')}}</span>
        </p>
    </div>
</li>