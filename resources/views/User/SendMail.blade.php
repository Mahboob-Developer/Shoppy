Hello Mr/Ms. {{ $data1['name'] }}
<br>
Your account is created successfully. Please verify your email to activate your account.
<br>
<a href="http://127.0.0.1:8000/verifyAccount/{{ $data['id'] }}/{{ $data['user_id'] }}/{{$data['otp']}}">Click here to verify your
    email</a>
<br>