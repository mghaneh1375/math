@extends('layouts.template')

@section('header')
    @parent
    <style>
        .box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 380px;
            margin: 100px auto;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .icon {
            font-size: 70px;
            margin-bottom: 20px;
        }

        .success {
            color: #4CAF50;
        }

        .failed {
            color: #E53935;
        }

        .ref-id {
            margin-top: 15px;
            background: #f0f0f0;
            padding: 10px;
            border-radius: 8px;
            direction: ltr;
        }

        a.btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 18px;
            background: #1976D2;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
@show

@section('content')
        
    <div class="box">

        @if($status === 'success')
            <div class="icon success">✔</div>
            <h2>پرداخت موفق</h2>
            <p>{{ $message }}</p>

            @if($ref_id)
                <div class="ref-id">
                    کد پیگیری: {{ $ref_id }}
                </div>
            @endif

        @else
            <div class="icon failed">✖</div>
            <h2>پرداخت ناموفق</h2>
            <p>{{ $message }}</p>
        @endif

        <a href="{{route('root')}}" class="btn">بازگشت به صفحه اصلی</a>

    </div>

@stop
