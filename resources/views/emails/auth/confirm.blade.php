{{ $user->name }} 님 환영합니다<br>
다음 주소를 열어 주세요<br>
<a href="{{ route('users.confirm',$user->confirm_code) }}">{{ route('users.confirm',$user->confirm_code) }}</a>