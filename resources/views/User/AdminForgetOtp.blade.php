@extends('./user/masterview')
<style>
    .otp-input {
        width: 40px;
        height: 50px;
        text-align: center;
        font-size: 24px;
        margin: 0 5px;
    }

    .timer {
        font-size: 14px;
        color: red;
        margin-top: 10px;
        text-align: center;
    }
</style>

@section('content')
<div class="container">
    <div class="row mt-md-5" style="height: 45vh;">
        <div class="col-md-5 offset-md-3 offset-1 col-10 px-5 shadow-lg border rounded">
            <div class="container">
                <form class="p-3" action="{{ url('/') }}/AdminForgetOtp" method="post">
                    @csrf
                    <div class="modal-header d-md-block d-none">
                        <h1 class="modal-title fs-3 pb-4" id="staticBackdropLabel">
                            OTP Verification
                        </h1>
                    </div>
                    <div class="modal-header d-md-none d-block">
                        <p class="modal-title fw-bold pb-4" id="staticBackdropLabel">
                            OTP Verification
                        </p>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <input type="text" class="form-control otp-input" name="otp[]" maxlength="1" value="{{ old('otp.0') }}">
                        <input type="text" class="form-control otp-input" name="otp[]" maxlength="1" value="{{ old('otp.1') }}">
                        <input type="text" class="form-control otp-input" name="otp[]" maxlength="1" value="{{ old('otp.2') }}">
                        <input type="text" class="form-control otp-input" name="otp[]" maxlength="1" value="{{ old('otp.3') }}">
                    </div>
                    @if($errors->has('otp'))
                        <div class="text-danger text-center mb-3">
                            {{ $errors->first('otp') }}
                        </div>
                    @endif
                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button type="submit" name="login" class="btn-lg btn btn-primary">Verify</button>
                        <button class="btn-md btn btn-outline-primary mt-2" id="resendtime" disabled>
                            Resend Code in <span id="timer" class="timer"></span>
                        </button>
                        <a class="btn-md btn btn-outline-primary mt-2" id="resendbtn" style="display: none" href="">
                            Resend Code
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Timer
    let timeLeft = 60;
    const timerElement = document.getElementById('timer');
    const resendTimeButton = document.getElementById('resendtime');
    const resendBtn = document.getElementById('resendbtn');
    
    const timerInterval = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            resendTimeButton.style.display = "none";
            resendBtn.style.display = "block";
        } else {
            resendTimeButton.style.display = "block";
            resendBtn.style.display = "none";
            timerElement.textContent = `${timeLeft} seconds`;
        }
        timeLeft--;
    }, 1000);

    // Auto-focus to the next input
    const otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });
    });
</script>
@endsection
