<div class="chat-box">
    <div class="h-[400px] chat-box-content overflow-y-auto relative z-20">
        <div class="box z-20 border border-2 border-gray-400 max-w-[250px] mx-auto mt-5 rounded-xl text-center p-5 ">
            <p> سلام </p>
            <img class="w-[100px] mx-auto mt-2" src="{{asset('assets/portal/img/hello.gif')}}" alt="">
            @if(Auth::user()->vip_account == 0)
                <p class="text-xs leading-8"> به زاگرین خوش آمدید برای ارتباط با خریداران یا فروشندگان اکانت خود را
                    <br/>
                    <a href="{{route('portal.plan')}}"> <strong class="text-blue-500">ارتقا دهید</strong> </a>
                </p>
            @else
                <p class="text-xs leading-8"> برای شروع مخاطب خود را انتخاب کنید </p>
            @endif
        </div>
    </div>
</div>
