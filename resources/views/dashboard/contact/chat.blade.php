@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')
    <section class="card col-span-2 xl:col-span-1 p-3">
        <h1 class="text-sm"> پیام های مخاطبین :
            (
            <span>  کاربر :
            {{$item->user ? $item->user->name : '' }}
            </span>
            ----
            <span>   مخاطب :
            {{$item->contact ? $item->contact->name : '' }}
            </span>)
        </h1>
        <hr class="my-3"/>
        <div class="control-sms my-3">
            <p> ارسال پیامک به کاربر : </p>
            <ul class="flex gap-3 mt-3">
                <li>
                    <a href="{{route('contacts.warning' , [$item->user->id , 0])}}"
                       class="bg-yellow-500 px-3 py-2 text-white rounded-sm text-sm"> اخطار شئونات اخلاقی به
                        {{$item->user->name}}
                    </a>
                </li>
                <li>
                    <a href="{{route('contacts.warning' , [$item->contact->id , 0])}}"
                       class="bg-yellow-500 px-3 py-2 text-white rounded-sm text-sm"> اخطار شئونات اخلاقی به
                        {{$item->contact->name}}
                    </a>
                </li>
                <li>
                    <a href="{{route('contacts.warning' , [$item->user->id , 1])}}"
                       class="bg-red-500 px-3 py-2 text-white rounded-sm text-sm"> اخطار کلاهبرداری به
                        {{$item->user->name}}
                    </a>
                </li>
                <li>
                    <a href="{{route('contacts.warning' , [$item->contact->id , 1])}}"
                       class="bg-red-500 px-3 py-2 text-white rounded-sm text-sm"> اخطار کلاهبرداری به
                        {{$item->contact->name}}
                    </a>
                </li>
                <li>
                    <a href="{{route('contacts.warning' , [$item->user->id , 2])}}"
                       class="bg-purple-500 px-3 py-2 text-white rounded-sm text-sm"> اخطار مسدودیت حساب به
                        {{$item->user->name}}
                    </a>
                </li>
                <li>
                    <a href="{{route('contacts.warning' , [$item->contact->id , 2])}}"
                       class="bg-purple-500 px-3 py-2 text-white rounded-sm text-sm"> اخطار مسدودیت حساب به
                        {{$item->contact->name}}
                    </a>
                </li>
            </ul>
        </div>

        <div class="content p-2 border rounded-md">
            <div class="grid grid-cols-1 gap-2">
                @foreach($chats as $value)

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

                    <div class="item p-3 bg-gray-100">
                        <ul class="grid grid-cols-1 gap-2">
                            <li class="text-xs">
                                <span>
                                    <i class="fa fa-user mx-1"></i>
                                    فرستنده :
                                </span>
                                <span> {{$value->user ? $value->user->name . ' - ' . $value->user->mobile : '*' }} </span>
                            </li>
                            <li class="text-xs">
                                <span>
                                    <i class="fa fa-user mx-1"></i>
                                    گیرنده :
                                </span>
                                <span> {{$value->contact ? $value->contact->name . ' - ' . $value->contact->mobile : '*' }} </span>
                            </li>
                            <li class="text-xs">
                                <span>
                                    <i class="fa fa-clock mx-1"></i>
                                    تاریخ / زمان :
                                </span>
                                <span> {{Verta($value->created_at)->format('Y/m/d H:i:s') }} </span>
                            </li>

                            <li class="text-xs">
                                <span>
                                    <i class="fa fa-box mx-1"></i>
                                    ریپلای محصول یا ... :
                                </span>
                                @if($item)
                                    @if($explode[0] == 'zgp')
                                        <code><a target="_blank"
                                                 href="{{route('product.show' , [$item->id , $item->slug])}}">{{$item->full_name}}</a></code>
                                    @endif
                                @else
                                    ندارد
                                @endif
                            </li>

                            <li class="text-md">
                                <span class="text-black">
                                    <i class="fa fa-comment mx-1"></i>
                                    پیام :
                                </span>
                                <span class="text-black"> {{$value->message}} </span>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
@section('js')
@endsection
