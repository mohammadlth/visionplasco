@extends('layouts.portal')
@section('navbar')
    <li class="list-inline-item">شارژ حساب</li>
@endsection
@section('body')
    <section class="statistic">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="charge-wallet card p-5">
                            <h3 class="text-center">
                                <p><i class="fas fa-coins icons-coin-charge"></i></p>
                                <p class="mt-3" style="font-size: 20px">افزایش شارژ حساب</p>
                            </h3>
                            <ul class="prices-charge mt-5">
                                <li>
                                    <button data-price="100000">100,000
                                        <small>(تومان)</small>
                                    </button>

                                </li>
                                <li>
                                    <button data-price="200000">200,000
                                        <small>(تومان)</small>
                                    </button>

                                </li>
                                <li>
                                    <button data-price="500000">500,000
                                        <small>(تومان)</small>
                                    </button>
                                </li>
                                <li>
                                    <button data-price="1000000">1,000,000
                                        <small>(تومان)</small>

                                    </button>
                                </li>
                            </ul>

                            <div class="form-group mt-5">
                                <form action="{{route('invoice.payment')}}" class="form-payment" method="post">
                                    @csrf
                                    <p class="text-center my-2 text-black">پرداخت مبلغ دلخواه (تومان)</p>
                                    <input class="form-control p-4 text-center" dir="ltr"
                                           style="font-size: 20px;font-weight: bold;color: black" name="amount"
                                           placeholder="50,000"
                                           min="50000"
                                           type="number">

                                    <button class="btn btn-success w-100 mt-3 p-3" type="submit">
                                        انتقال به درگاه پرداخت
                                        <i class="fas fa-angle-left" style="margin-top: 2px;margin-right: 5px"></i>
                                    </button>
                                </form>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-6">
                        <div class="card p-2">
                            <div class="table-responsive">
                                <table class="table table-borderless table-data3">
                                    <thead>
                                    <tr>
                                        <th style="font-size: 12px">مبلغ (تومان)</th>
                                        <th style="font-size: 12px">شماره ارجاع سایت</th>
                                        <th style="font-size: 12px">شماره ارجاع بانک</th>
                                        <th style="font-size: 12px">تاریخ ایجاد</th>
                                        <th style="font-size: 12px">آخرین وضعیت</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($invoice) > 0)
                                        @foreach($invoice as $value)
                                            <tr>
                                                <td><b>{{number_format($value->amount)}}</b>  </td>
                                                <td>
                                                    {{$value->number}}
                                                </td>
                                                <td>
                                                    {{!is_null($value->ref_id_bank) ? $value->ref_id_bank : '------' }}
                                                </td>
                                                <td>{{verta($value->created_at)->format('Y/m/d')}}</td>
                                                <td>
                                                    @if($value->status == 0)
                                                        <span class="badge badge-warning p-1"
                                                              style="font-size: 10px"> پرداخت نشده </span>
                                                    @elseif($value->status == 1)
                                                        <span class="badge badge-success p-1"
                                                              style="font-size: 10px">پرداخت شده</span>
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
                                    {!! $invoice->links() !!}
                                </div>
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
