@extends('layouts.portal')
@section('navbar')
    <li class="list-inline-item">صفحه نخست</li>
@endsection
@section('body')
    <section class="statistic">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4"></div>
                    @if($invoice->status == 1)
                        <div class="col-md-4">
                            <div class="charge-wallet card p-5">
                                <h3 class="text-center">
                                    <p><i class="fas fa-check icons-coin-charge"></i></p>
                                    <p class="my-4" style="font-size: 20px">شارژ پنل با موفقیت انجام شد</p>
                                </h3>
                                <a class="btn btn-success mt-3" style="border-radius: 10px" href="{{route('panel')}}">
                                    پیشخوان </a>
                            </div>
                        </div>
                    @else
                        <div class="col-md-4">
                            <div class="charge-wallet card p-5">
                                <h3 class="text-center">
                                    <p><i class="fas fa-times icons-coin-charge" style="background-color: red;width: 80px"></i></p>
                                    <p class="my-4" style="font-size: 20px">شارژ پنل انجام نشد</p>
                                </h3>
                                <a class="btn btn-danger mt-3" style="border-radius: 10px" href="{{route('panel')}}">
                                    پیشخوان </a>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-4"></div>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')

@endsection
