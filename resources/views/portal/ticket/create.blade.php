@extends('layouts.portal')
@section('navbar')
    <li class="list-inline-item"><a href="{{route('tickets')}}">تیکت پشتیبانی</a></li>
    <li class="list-inline-item seprate">
        <span>/</span>
    </li>
    <li class="list-inline-item active">ثبت تیکت</li>
@endsection
@section('body')

    <section class="statistic">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>ثبت تیکت پشتیبانی</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{route('ticket.store')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title">عنوان تیکت</label>
                                                <input class="form-control" name="title" value="{{old('title')}}"
                                                       type="text"
                                                       placeholder="عنوان تیکت">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title">دیپارتمان</label>
                                                <select class="form-control" name="departman">
                                                    <option value="technical"> پشتیبانی فنی</option>
                                                    <option value="financial"> امور مالی</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="text">متن تیکت</label>
                                                <textarea class="form-control" name="text" rows="8"
                                                          style="border-radius: 5px"
                                                          placeholder="متن تیکت">{{old('text')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary w-100 p-3"> ثبت تیکت
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
