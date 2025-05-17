<div class="search relative mt-2">
    <input class="bg-gray-50 text-sm p-2 rounded-md w-full" placeholder="جستجو کاربر"
           alt="">
    <i class="fal fa-search text-gray-500 absolute left-3 top-[10px]"></i>
</div>
<ul class="mt-3 min-h-[400px] overflow-auto p-2">
    @foreach($contacts as $value)
        <li class="border-b py-2 cursor-pointer" onclick="selectUser({{$value->contact_id}})">
            <div class="user flex gap-3">
                <div class="image">
                    @if($value->contact->info && $value->contact->info->profile_pic)
                        <img src="{{url($value->contact->info->profile_pic)}}"
                             class="w-12 h-12 rounded-full h-auto"
                             alt=""/>
                    @else
                        <img src="{{url('assets/portal/img/user-none.png')}}"
                             class="w-12 h-12 rounded-full h-auto"
                             alt=""/>
                    @endif
                </div>
                <div class="info w-full relative">
                    <b class="text-xs flex justify-between items-center"> {{$value->contact->name}}
                        <span class="font-thin text-gray-400 text-[10px]">{{verta($value->contact->last_activity)->formatDifference()}}</span>
                    </b>

                    @if(!is_null($value->last_message))
                        <p class="text-[10px] text-gray-600 mt-2">
                            {{$value->last_message}}
                        </p>
                    @endif

                    @if($value->message_not_read > 0)
                        <span class="bg-red-500 text-[10px] text-white rounded-sm px-[2px] py-0 absolute left-3 bottom-[2px] leading-[15px]">{{$value->message_not_read}}</span>
                    @endif
                    <div class="absolute left-0 bottom-0 leading-[13px] show-option-user">
                        <i class="fal fa-ellipsis-v text-[18px] w-2 text-center cursor-pointer"></i>
                        <ul class="z-50 list-option hidden absolute w-24 bg-white shadow-md p-2 rounded-md left-0 grid gap-3">
                            <li class="text-[11px]">
                                <a href="" class="text-gray-600">
                                    <i class="fas fa-ban"></i>
                                    گزارش تخلف
                                </a>
                            </li>
                            <li class="text-[11px]">
                                <a href="" class="text-gray-600">
                                    <i class="far fa-comments"></i>
                                    ثبت نظر
                                </a>
                            </li>
                            <li class="text-[11px]">
                                <a href="" class="text-gray-600">
                                    <i class="far fa-hand"></i>
                                    بلاک کردن
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </li>
    @endforeach
</ul>