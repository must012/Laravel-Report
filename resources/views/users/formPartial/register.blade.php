@extends('users.frame')
@section('form')
    <div class="card-header text-center">{{ __('회원가입') }}</div>

    <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                    <input id="name" type="text"
                           class="form-control"
                           name="name" value="{{ old('name') }}" required autofocus>

                    {!! $errors->first('name','<span class="form-error">:message</span>') !!}

                </div>
            </div>

            <div class="form-group row">
                <label for="email"
                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email"
                           class="form-control"
                           name="email" value="{{ old('email') }}" required>

                    {!! $errors->first('email','<span class="form-error">:message</span>') !!}

                </div>
            </div>

            <div class="form-group row">
                <label for="password"
                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="password" type="password"
                           class="form-control"
                           name="password" required>

                    {!! $errors->first('password','<span class="form-error">:message</span>') !!}

                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm"
                       class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control"
                           name="password_confirmation" required>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-4"></div>
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('가입') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection