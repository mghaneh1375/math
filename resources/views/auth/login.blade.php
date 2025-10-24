@extends('layouts.template')

@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset/css/login.css') }}" />
@show

@section('content')

    <div class="login-container">
        <h2>ورود به حساب کاربری</h2>
        <form method="post" action="{{ route('doLogin') }}">
            @csrf

            <div class="input-group">
                <label for="username">نام کاربری</label>
                <input type="text" id="username" name="username" placeholder="نام کاربری خود را وارد کنید" required />
            </div>
            <div class="input-group">
                <label for="password">رمز عبور</label>
                <input type="password" id="password" name="password" placeholder="رمز عبور خود را وارد کنید" required />
            </div>
            @if(isset($loginErr))
                <p>{{ $loginErr }}</p>
            @endif
            
            <center id="errs">

                @if (isset($errors))
                    @if (is_string($errors))
                        <p> {{ $errors }} </p>
                    @elseif ($errors->any())
                        {!! implode('<br />', $errors->all(':message')) !!}
                    @endif
                @endif

            </center>
            <div class="buttons">
                <button type="submit">ورود</button>
                <a href="{{ route('register') }}">ثبت نام</a>
            </div>
        </form>
        <div class="forgot-password">
        <a href="#">فراموشی رمز عبور؟</a>
        </div>
    </div>
  
@stop