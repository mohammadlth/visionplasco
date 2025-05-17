<div class="head-chat p-2 bg-blue-600 rounded-t-lg flex justify-between items-center">
    <div class="user flex justify-between items-center gap-2">
        @if($user->info && $user->info->profile_pic)
            <img src="{{url($user->info->profile_pic)}}" class="w-[30px] rounded-full h-[30px]" alt="">
        @else
            <img src="{{asset('assets/portal/img/user-p.png')}}" class="w-[30px]" alt="">
        @endif
        <p class="text-white text-xs user-chat-name">{{$user->name}}</p>
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

            <div class="box box-chat-empty z-20 border border-2 border-gray-400 max-w-[250px] mx-auto mt-5 rounded-xl text-center p-5 ">
                <p> سلام </p>
                <img class="w-[100px] mx-auto mt-2" src="{{asset('assets/portal/img/hello.gif')}}" alt="">
                <p class="text-xs leading-8"> برای ارتباط با خریدار پیام خود را ارسال کنید </p>
            </div>

            <div class="part">
                <ul class="messages-list overflow-x-hidden mt-3 px-3">
                </ul>
            </div>

        </div>

    </div>
</div>
<div class="send-message p-3 bg-gray-100 flex gap-2 relative">
    <button class="btn bg-[#49b9c7] w-10 h-9 shadow-md flex items-center justify-center pl-[1px] rounded-full onclick-btn-box-send">
        <img src="{{asset('assets/portal/img/send.png')}}"/>
    </button>
    <input class="border w-full rounded-full px-2 py-2 text-xs message-input-box" placeholder="پیام خود را بنویسید"/>
</div>
@section('jss')
    <script src="{{asset('assets/portal/js/chatBox.js')}}" type="text/javascript"></script>
@endsection
