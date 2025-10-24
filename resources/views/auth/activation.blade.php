@extends('layouts.template')

@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset/css/register.css') }}" />
@show

@section('content')

    <form id="otpForm" method="post" accept="{{ route('do_activate_account', ['activation' => $id]) }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}" />
        <input id="code" type="hidden" name="code" />
        
        <div id="otpModal" class="modal">
            <div class="modal-content" id="otpContent">
                <h3>کد تأیید را وارد کنید</h3>
                
                <center id="errs">
                    @if (isset($errors))
                        @if (is_string($errors))
                            <p> {{ $errors }} </p>
                        @elseif ($errors->any())
                            {!! implode('<br />', $errors->all(':message')) !!}
                        @endif
                    @endif
                </center>

                <div class="otp-inputs">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                </div>
                <div class="countdown" id="countdown"></div>
                <button class="btn-primary" id="resendBtn" style="margin-top:10px;" disabled>ارسال مجدد کد</button>
            </div>
        </div>
    </form>

    <script>
        
        function moveNext(input) {
            if (input.value.length === 1) {
                const next = input.nextElementSibling;
                if (next) next.focus();
            }
        }

        $(document).ready(function() {
            startCountdown();
        });

        function startCountdown() {
            const countdownEl = document.getElementById('countdown');
            const resendBtn = document.getElementById('resendBtn');
            let time = parseInt('{{$reminder}}');
            
            const timer = setInterval(() => {
                const minutes = String(Math.floor(time / 60)).padStart(2, '0');
                const seconds = String(time % 60).padStart(2, '0');
                countdownEl.textContent = `ارسال مجدد تا ${minutes}:${seconds}`;
                time--;

                if (time < 0) {
                    clearInterval(timer);
                    countdownEl.textContent = 'می‌توانید دوباره کد را ارسال کنید.';
                    resendBtn.disabled = false;
                }
            }, 1000);
        }

        document.addEventListener("DOMContentLoaded", function () {
            const inputs = document.querySelectorAll('.otp-inputs input');
            const form = document.getElementById('otpForm');

            inputs.forEach((input, index, inputs) => {
                input.addEventListener('input', (e) => {
                    // فقط عدد قبول کن
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');

                    // اگر عددی وارد شد برو input بعدی
                    if (e.target.value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                    // اگر آخرین input پر شد، همه پرن؟ بعداً میشه auto-submit
                    if (index === inputs.length - 1 && e.target.value) {
                        let code = '';
                        inputs.forEach(i => code += i.value);
                    }

                    // اگر آخرین input پر شد، بررسی کن همه پر شدن
                    if (index === inputs.length - 1 && e.target.value) {
                        const code = Array.from(inputs).map(i => i.value).join('');

                        if (code.length === inputs.length) {
                            // مقدار OTP رو داخل input hidden بریز
                            const hiddenOtpInput = document.getElementById('code');
                            if (hiddenOtpInput) hiddenOtpInput.value = code;

                            // فرم رو ارسال کن
                            form.submit();
                        }
                    }
                });

                input.addEventListener('keydown', (e) => {
                    // اگر backspace زد و خالی بود برگرد به قبلی
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });
        });

    </script>

@endsection