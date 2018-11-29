@extends('layouts.master')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{ __('비밀번호 찾기') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('remind.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" type="email"
                                           class="form-control"
                                           name="email" value="{{ old('email') }}"
                                           required autofocus>

                                    {!! $errors->first('email','<span class="form-error">:message</span>') !!}
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-8 ml-auto">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('보내기') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection