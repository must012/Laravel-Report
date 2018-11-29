@extends('layouts.master')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @yield('form')
                </div>
            </div>
        </div>
    </div>
@endsection
