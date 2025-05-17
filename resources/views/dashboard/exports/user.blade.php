<table>
    <thead>
    <tr>
        <th>شناسه</th>
        <th>نام</th>
        <th>موبایل</th>
        <th>جنسیت</th>
        <th>نوع حساب</th>
        <th>اکانت ویژه</th>
        <th>تاریخ اکسپایر</th>
        <th>تاریخ عضویت</th>
        <th>وضعیت</th>
        <th>آخرین فعالیت</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $value)

        <tr>
            <td>{{$value->id}}</td>
            <td>{{$value->name}}</td>
            <td>{{$value->mobile}}</td>
            <td>
                @if($value->sex == 1)
                    مرد
                @else
                    زن
                @endif
            </td>
            <td>
                @if($value->account == 'buyer')
                    خریدار
                @elseif($value->account == 'seller')
                    فروشنده
                @endif
            </td>
            <td>
                @if($value->vip_account)
                    اکانت ویژه
                @else
                    اکانت عادی
                @endif
            </td>
            <td>
                {{Verta($value->vip_expire_at)->format('%d %B  %Y')}}
            </td>
            <td>
                {{Verta($value->created_at)->format('%d %B  %Y')}}
            </td>
            <td>
                @if($value->ban)
                    غیر فعال
                @else
                    فعال
                @endif
            </td>
            <td>
                {{Verta($value->last_activity)->format('%d %B  %Y')}}
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
