@extends('layouts.portal')
@section('navbar')
    <li class="list-inline-item">تیکت پشتیبانی</li>
@endsection
@section('body')

    <section class="statistic">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right my-2">
                            <a href="{{route('ticket.create')}}" class="btn btn-danger">
                                <i class="fa fa-plus"></i>
                                ثبت تیکت
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive m-b-40">
                            <table class="table table-borderless table-data3 text-center">
                                <thead>
                                <tr>
                                    <th>عنوان</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ ایجاد</th>
                                    <th class="text-center">دسترسی ها</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($tickets) > 0)
                                    @foreach($tickets as $value)
                                        <tr class="text-center">
                                            <td><b>{{$value->title}}</b></td>

                                            <td>
                                                @if($value->status == 0)
                                                    <span class="badge  badge-warning"
                                                          style="font-size: 10px;padding: 5px"> در انتظار پاسخ </span>
                                                @elseif($value->status == 1)
                                                    <span class="badge  badge-success"
                                                          style="font-size: 10px;padding: 5px">پاسخ داده شده</span>
                                                @elseif($value->status == 2)
                                                    <span class="badge  badge-dark"
                                                          style="font-size: 10px;padding: 5px">بسته شده</span>
                                                @elseif($value->status == -1)
                                                    <span class="badge  badge-danger"
                                                          style="font-size: 10px;padding: 5px">لغو شده</span>
                                                @endif
                                            </td>

                                            <td>{{verta($value->created_at)->format('Y/m/d')}}</td>

                                            <td>
                                                <div class="table-data-feature" style="justify-content: center">
                                                    <a href="{{route('ticket.show' , $value->id)}}" class="item ml-2"
                                                       title="مشاهده تیکت">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <p class="text-center">هنوز وب سایتی ثبت نکرده اید
                                                <a href="{{url('/')}}"> رایگان شروع کنید </a>
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <div class="text-center my-3">
                                {!! $tickets->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
@section('js')

@endsection
