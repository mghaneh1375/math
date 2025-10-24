@extends('layouts.template')

@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset/css/register.css') }}" />
@show

@section('content')

<div class="register-container">
    <h2>ثبت نام</h2>

    <form id="registerForm" method="post" accept="{{ route('registry') }}" autocomplete="off">
        @csrf
        
        <center id="errs">
            @if (isset($errors))
                @if (is_string($errors))
                    <p> {{ $errors }} </p>
                @elseif ($errors->any())
                    {!! implode('<br />', $errors->all(':message')) !!}
                @endif
            @endif
        </center>

        <div class="form-group">
            <label>شماره همراه *</label>
            <input value="{{ old('username') }}" type="text" name="username" pattern="^09\d{9}$" maxlength="11" placeholder="مثلاً 09123456789" required autocomplete="off">
        </div>

        <div class="form-group">
            <label>نام *</label>
            <input value="{{ old('firstname') }}" type="text" name="firstname" placeholder="مثلاً علی" required>
        </div>

        <div class="form-group">
            <label>نام خانوادگی *</label>
            <input value="{{ old('lastname') }}" type="text" name="lastname" placeholder="مثلاً رضایی" required>
        </div>

        <div class="form-group">
            <label>رمز عبور *</label>
            <input type="password" id="password" name="password" required autocomplete="new-password">
            <span class="toggle-password glyphicon glyphicon-eye-open" onclick="togglePassword('password')"></span>
        </div>

        <div class="form-group">
            <label>تکرار رمز عبور *</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            <span class="toggle-password glyphicon glyphicon-eye-open" onclick="togglePassword('password_confirmation')"></span>
        </div>

        <div class="form-group">
            <label>نام مدرسه (اختیاری)</label>
            <input value="{{ old('school_name') }}" type="text" name="school_name" placeholder="نام مدرسه">
        </div>

        <div class="form-group">
            <label>مقطع تحصیلی *</label>
            <select name="grade_id" required>
                <option value="">انتخاب کنید</option>
                @foreach($grades as $grade)
                    <option {{ old('grade_id') == $grade->id ? 'selected' : '' }} value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-primary">ثبت نام</button>
    </form>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = event.target;
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('glyphicon-eye-open');
            icon.classList.add('glyphicon-eye-close');
        } else {
            input.type = "password";
            icon.classList.remove('glyphicon-eye-close');
            icon.classList.add('glyphicon-eye-open');
        }
    }
</script>
@endsection
