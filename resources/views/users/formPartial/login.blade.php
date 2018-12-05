@extends('users.frame')
@section('form')
    <div class="card-header text-center">{{ __('로그인') }}</div>

    <div class="card-body" id="oauth">
        <p class="text-muted text-center">다른 사이트와 연동하고 싶으신가요?</p>
        <div class="col-md-12 d-flex">
            <i class="btn btn-default ml-auto mr-auto fab fa-github fa-2x"
               onclick="location.href='{{ route('social.login', ['github']) }}'"></i>
        </div>
    </div>

    <div class="d-flex">
        <div class="line ml-4" style="height: 1px"> </div>
        <div class="line-text mr-2 ml-2 text-secondary">또는</div>
        <div class="line mr-4" style="height: 1px"> </div>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('sessions.store') }}">
            @csrf

            <div class="form-group row">
                <label for="email"
                       class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email"
                           class="form-control"
                           name="email" value="{{ old('email') }}" required autofocus>

                    {!! $errors->first('email','<span class="form-error">:message</span>') !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="password"
                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password"
                           class="form-control"
                           name="password" required>

                    {!!  $errors->first('password','<span class="form-error">:message</span>') !!}

                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4"></div>
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('비밀번호 자동 저장') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12 pl-0 d-flex flex-column">
                    <div class="ml-auto mr-auto">
                        <button type="submit" class="btn btn-primary">
                            {{ __('로그인') }}
                        </button>
                    </div>
                    <div class="ml-auto mr-auto">
                        <a class="btn btn-link" href="{{ route('remind.create') }}">
                            {{ __('비밀번호를 잊어버리셨나요?') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection