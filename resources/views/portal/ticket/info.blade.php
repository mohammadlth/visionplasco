@extends('layouts.portal')
@section('navbar')
    <li class="list-inline-item"><a href="{{route('tickets')}}">تیکت پشتیبانی</a></li>
    <li class="list-inline-item seprate">
        <span>/</span>
    </li>
    <li class="list-inline-item active">{{$ticket->title}}</li>
@endsection
@section('body')
    <style>
        .comment {
            padding: 28px;
            border-radius: 10px;
            box-shadow: 0px 0px 18px 0px #cdcdcd;
        }
    </style>

    <section class="statistic">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{$ticket->title}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="text">
                                    {!! $ticket->text !!}
                                    <hr/>
                                </div>

                                <div class="comments">
                                    <div class="row" style="row-gap: 20px">

                                        @foreach($comments as $value)
                                            @if($value->is_admin)
                                                <div class="col-md-4">

                                                </div>
                                                <div class="col-md-8">
                                                    <div class="comment" style="border: 2px dashed #5199e46b">
                                                        <div class="">
                                                            {!! $value->text !!}
                                                        </div>
                                                        <div class="footer mt-2"
                                                             style="font-size: 12px;border: 1px solid #eee;border-radius: 20px;padding: 10px">
                                                            <div style="display: flex;justify-content: space-between;align-items: center">
                                                                <p>
                                                                    پشتیبان :
                                                                    {{$value->user->name}} </p>
                                                                <p>
                                                                    {{verta($value->created_at)->format('H:i Y/m/d')}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @else

                                                <div class="col-md-8">
                                                    <div class="comment">
                                                        <div class="">
                                                            {!! $value->text !!}
                                                        </div>
                                                        <div class="footer mt-2"
                                                             style="font-size: 12px;border: 1px solid #eee;border-radius: 20px;padding: 10px">
                                                            <div style="display: flex;justify-content: space-between;align-items: center">
                                                                <p>
                                                                    {{$value->user->name}} </p>
                                                                <p>
                                                                    {{verta($value->created_at)->format('H:i Y/m/d')}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">

                                                </div>

                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>پاسخ به تیکت</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{route('ticket.comment.store' , $ticket->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <textarea class="form-control" name="text" rows="8"
                                                      style="border-radius: 5px"
                                                      placeholder="متن پیام">{{old('text')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary w-100 p-3"> ثبت پیام
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
