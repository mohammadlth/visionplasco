<div class="chat-box-content-parent fixed bottom-[-500px] left-3 min-w-[350px] z-20 shadow-md bg-white rounded-t-lg" style="z-index: 9999999">
    <div class="head-chat p-2 bg-blue-600 rounded-t-lg flex justify-between items-center">
        <div class="user flex justify-between items-center gap-2">
            <img src="{{asset('assets/portal/img/user-p.png')}}" class="w-10 h-10" alt="">
            <p class="text-white text-xs user-chat-name"></p>
        </div>
        <div class="close-model-chat cursor-pointer">
            <i class="fal fa-times-circle text-white" style="transform: translateY(4px);"></i>
        </div>
    </div>
    <div class="model-items chat-box p-2">
        <div class="h-[350px] chat-box-content overflow-y-auto relative">
            <div class="chat-req-box">
            </div>
        </div>
    </div>
</div>
@section('jss')
    <script src="{{asset('assets/portal/js/chatBox.js')}}" type="text/javascript"></script>
@endsection
