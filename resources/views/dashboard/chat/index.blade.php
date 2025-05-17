@extends('layouts.dashboard')
@section('style')
@endsection
@section('body')
    <section class="card col-span-2 xl:col-span-1 p-3">

        <table class="table-auto w-full text-right">
            <thead>
            <tr class="border-t">
                <th class="px-4 py-2 border-r">لیست چت</th>
                <td class="px-4 py-2 border-l" colspan="6">
                </td>
            </tr>
            <tr class="border-t">
                <th class="px-4 py-2 border-r border-l">جستجو کنید</th>
                <td class="px-4 py-2 border-l relative" colspan="6">
                    <div class="items-center gap-2">
                        <form method="get" action="{{route('chats.index')}}">
                            <input class="border bg-gray-100 w-full px-3 py-1 rounded-md" name="s"
                                   placeholder="جستجو کنید (موبایل - نام کاربر) ...">
                        </form>
                        @if(isset($params['s']) && !is_null($params['s']))
                            <div class="mt-2">
                                <a href="{{route('contacts.index')}}">
                                    <span class="border px-2 py-1 rounded-full">
                                        {{$params['s']}}
                                        <i class="fa fa-times"></i>
                                    </span>
                                </a>
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <th class="px-4 py-2 border-r border-t">شناسه</th>
                <th class="px-4 py-2 border-r border-t">کاربر</th>
                <th class="px-4 py-2 border-r border-t">مخاطب</th>
                <th class="px-4 py-2 border-t">پیام</th>
                <th class="px-4 py-2 border-t"> زمان ارسال</th>
                <th class="px-4 py-2 border-t text-center"> تاریخچه</th>
                <th class="px-4 py-2 border-l border-t text-center">زباله دان</th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @if(count($items) > 0)
                @foreach($items as $value)
                    <tr>

                        <td class="border border-l-0 px-4 py-2 text-right text-black">
                            {{$value->id}}
                        </td>

                        <td class="border border-l-0 px-4 py-2 text-right text-black">
                            <a href="{{route('users.edit' , $value->user ? $value->user->id : -1)}}" class="text-xs">
                                @if($value->user && $value->user->info && !is_null($value->user->info->profile_pic))
                                    <img src="{{url($value->user->info->profile_pic)}}" alt=""
                                         style="width: 40px;height: 40px;border-radius: 50px">
                                @else
                                    <img src="{{asset('assets/portal/img/user-p.png')}}"
                                         style="width: 40px;height: 40px;border-radius: 50px" alt="">
                                @endif
                                {{$value->user ? $value->user->name . ' - ' . $value->user->mobile : null}}
                            </a>
                        </td>

                        <td class="border border-l-0 px-4 py-2 text-right text-black">
                            <a href="{{route('users.edit' , $value->contact ? $value->contact->id : -1)}}"
                               class="text-xs">
                                @if($value->contact && $value->contact->info && !is_null($value->contact->info->profile_pic))
                                    <img src="{{url($value->contact->info->profile_pic)}}" alt=""
                                         style="width: 40px;height: 40px;border-radius: 50px">
                                @else
                                    <img src="{{asset('assets/portal/img/user-p.png')}}"
                                         style="width: 40px;height: 40px;border-radius: 50px" alt="">
                                @endif
                                {{$value->contact ? $value->contact->name . ' - ' . $value->contact->mobile : null}}
                            </a>
                        </td>

                        <td class="border border-l-0 px-4 py-2 text-sm">
                            <span class="text-gray-800"> {{$value->message}} </span>
                        </td>

                        <td class="border border-l-0 px-4 py-2 text-xs">
                            <span class="text-gray-800">{{Verta($value->updated_at)->formatDifference()}}</span>
                        </td>

                        @php
                            $contact = \App\Models\Contact::where('user_id' , $value->user->id)->where('contact_id' , $value->contact->id)->first();
                        @endphp

                        <td class="border border-l-0 px-4 py-2 text-center">
                            <a href="{{route('contacts.chats' , [$contact ? $contact->id : -1])}}"
                               class="text-xs bg-blue-500 px-3 py-2 rounded-sm  text-white ml-1">
                                <i class="fa fa-comments text-xs text-white mx-1"></i>
                                مشاهده گفتگو
                            </a>
                        </td>

                        <td class="border px-4 py-2 border-l">
                            <form class="delete-form text-center" method="post"
                                  action="{{route('chats.delete' , $value->id)}}">
                                @method('delete')
                                @csrf
                                <button type="submit"><i class="fa fa-trash text-red-500"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="border border-l px-4 py-2 text-center text-gray-500">
                        اطلاعاتی در این جدول یافت نشد
                    </td>
                </tr>
            @endif

            @if($items->lastPage() > 1)
                <tr class="text-center">
                    <td class="border px-4 py-2 text-center" colspan="7">
                        <div class="flex justify-center">
                            {{$items->withQueryString()->links()}}
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </section>

@endsection
@section('js')
    <script>
        setInterval(function () {
            location.reload();
        }, 15000)
    </script>
@endsection
