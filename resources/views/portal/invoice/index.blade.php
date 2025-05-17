@extends('layouts.portal')
@section('navbar')
    <li class="list-inline-item">صورت حساب ها</li>
@endsection
@section('body')
    <section class="statistic">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive m-b-40">
                            <table class="table table-borderless table-data3" style="text-align: center">
                                <thead>
                                <tr>
                                    <th style="font-size: 12px">شماره صورت حساب</th>
                                    <th style="font-size: 12px">مبلغ (تومان)</th>
                                    <th style="font-size: 12px">عنوان</th>
                                    <th style="font-size: 12px">تاریخ</th>
                                    <th style="font-size: 12px">تاریخ پرداخت</th>
                                    <th style="font-size: 12px">وضعیت</th>
                                    <th style="font-size: 12px;text-align: center">پرداخت</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($invoices) > 0)
                                    @foreach($invoices as $value)
                                        <tr>
                                            <td>
                                                {{$value->id}}
                                            </td>
                                            <td>
                                                @if($value->amount > 0)
                                                    <b>{{number_format($value->amount)}}</b>
                                                @else
                                                    <b>هدیه سایت سی :)</b>
                                                @endif

                                            </td>
                                            <td>
                                                {{$value->title}}
                                            </td>

                                            <td>{{verta($value->created_at)->format('Y/m/d')}}</td>
                                            <td>
                                                @if($value->status == 1)
                                                    {{verta($value->updated_at)->format('H:i Y/m/d')}}
                                                @else
                                                    -------------
                                                @endif
                                            </td>

                                            <td>
                                                @if($value->status == 0)
                                                    <span class="badge badge-warning p-1"
                                                          style="font-size: 10px"> در انتظار پرداخت </span>
                                                @elseif($value->status == 1)
                                                    <span class="badge badge-success p-1"
                                                          style="font-size: 10px">پرداخت شده</span>
                                                @elseif($value->status == -1)
                                                    <span class="badge badge-danger p-1"
                                                          style="font-size: 10px">منقضی شده</span>
                                                @endif

                                            </td>
                                            <td>
                                                @if($value->status == 0)
                                                    <a class="btn btn-success" style="font-size: 12px"
                                                       href="{{route('payment.invoice' , $value->id)}}">
                                                    پرداخت کنید
                                                    </a>
                                                @elseif($value->status == 1)
                                                    <button type="button" style="font-size: 12px" class="btn">پرداخت
                                                        شده
                                                    </button>
                                                @else
                                                    <button type="button" style="font-size: 12px" class="btn">امکان
                                                        پرداخت وجود ندارد
                                                    </button>

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <p class="text-center">صورتحسابی یافت نشد
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <div class="text-center my-3">
                                {!! $invoices->links() !!}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('.prices-charge li button').click(function () {
                $('input[name=amount]').val($(this).attr('data-price'));
                return $('.form-payment').submit()
            })
        })
    </script>

@endsection
