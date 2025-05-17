@foreach($requests as $value)
    <div class="item p-3 shadow-sm border-2 rounded-md">
        <div class="user-info">
            <p class="text-gray-400 gap-2 text-sm">
                <i class="fa fa-user-circle text-gray-400"></i>
                {{$value->user ? $value->user->name : 'نامعلوم' }}
                <span class="float-left text-xs text-gray-500 m-1">
                        <i class="fa fa-clock text-gray-500"></i>
                    {{verta($value->created_at)->formatDifference()}}
                </span>
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 items-center justify-between mt-3">
                <div class="detail">
                    <p class="text-[15px]">
                        <span class="text-gray-800"> خریدار </span>

                        <strong class="text-dark"> {{unit_calculate($value->inventory , $value->category->unit)}} </strong>

                        <strong class="text-dark"> {{$value->category ? $value->category->title : 'نامعلوم'}} </strong>
                        <span class="text-gray-800"> از نوع </span>
                        <strong class="text-dark">{{$value->type}} </strong>
                    </p>
                </div>
                @if(Auth::check() && Auth::user()->vip_account)

                    @if($value->user->info->show_phone_number)
                        <div class="contact-user flex gap-3">
                            <button onclick="showPhone({{$value->user->id}})"
                                    class="bg-green-600 text-white w-full text-xs text-center py-1 px-2 sm:py-2 rounded-md btn-call">
                                <i class="fa fa-phone text-white ml-1 default"></i>
                                <span class="text-white default"> تماس به خریدار </span>
                                <i class="fa fa-spinner fa-spin text-white load hidden"></i>
                            </button>
                            <button onclick="selectUser({{$value->user->id}} , '{{$value->user->name}}')"
                                    class="bg-yellow-500 text-white w-full text-xs text-center  py-1 px-2 sm:py-2 rounded-md btn-chat">
                                <i class="fa fa-comment text-white ml-1 default"></i>
                                <span class="text-white default"> چت با خریدار </span>
                                <i class="fa fa-spinner fa-spin text-white load hidden"></i>
                            </button>
                        </div>
                    @else
                        <div class="contact-user flex gap-3">
                            <button onclick="selectUser({{$value->user->id}} , '{{$value->user->name}}')"
                                    class="bg-yellow-500 text-white w-full text-xs text-center px-2 py-2 rounded-md btn-chat">
                                <i class="fa fa-comment text-white ml-1 default"></i>
                                <span class="text-white default"> چت با خریدار </span>
                                <i class="fa fa-spinner fa-spin text-white load hidden"></i>
                            </button>
                        </div>
                    @endif

                @elseif(Auth::check())
                    <div class="relative">
                        <div class="contact-user grid grid-cols-2 gap-3 mt-3">
                            <button onclick="vipShowToggle()" type="button"
                                    class="bg-green-600 text-white w-full text-xs text-center px-2 py-3 rounded-md">
                                <i class="fa fa-phone text-white ml-1"></i>
                                تماس به خریدار
                            </button>
                            <button type="button" onclick="vipShowToggle()"
                                    class="bg-yellow-500 text-white w-full text-xs text-center px-2 py-3 rounded-md">
                                <i class="fa fa-comment text-white ml-1"></i>
                                چت با خریدار
                            </button>
                        </div>
                    </div>
                @else
                    <div class="relative">
                        <div class="contact-user grid grid-cols-2 gap-3 mt-3">
                            <a href="{{route('login')}}" type="button"
                               class="bg-green-600 text-white w-full text-xs text-center px-2 py-3 rounded-md">
                                <i class="fa fa-phone text-white ml-1"></i>
                                تماس به خریدار
                            </a>
                            <a href="{{route('login')}}" type="button"
                               class="bg-yellow-500 text-white w-full text-xs text-center px-2 py-3 rounded-md">
                                <i class="fa fa-comment text-white ml-1"></i>
                                چت با خریدار
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endforeach
