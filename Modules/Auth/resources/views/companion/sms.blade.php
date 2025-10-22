@extends('auth::layout.master')

@section('content')
    <div class="page login-bg">
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div class="col mx-auto">
                        <div class="row justify-content-center">
                            <div class="col-md-7 col-lg-5">
                                <div class="card">
                                    <div class="p-4 pt-6 text-center">
                                        <div class="text-left">
                                            <a href="{{ route('companion.login.form',$mobile) }}" class="btn btn-info btn-sm">
                                                <i class="text-white fa fa-arrow-left"></i>
                                            </a>
                                        </div>
                                        <h1 class="mb-2">ورود</h1>
                                        <p class="text-muted">کد ورود به شماره شما پیامک شده.</p>
                                    </div>
                                    <form class="card-body pt-3" id="login" name="login" method="POST" action="{{ route('companion.login') }}">
                                        @include('components.errors')
                                        @csrf
                                        <input type="hidden" name="mobile" value="{{$mobile}}">
                                        <div class="form-group">
                                            <label class="form-label" for="sms_token">کد ورود:</label>
                                            <input class="form-control @error('sms_token') is-invalid @enderror" id="sms_token" type="tel" maxlength="5" name="sms_token" value="{{ old('sms_token') }}" autofocus required>
                                            @error('sms_token')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror
                                        </div>
                                        <div class="submit">
                                            <button class="btn btn-primary btn-block" type="submit">ورود</button>
                                        </div>
                                    </form>
{{--                                    <div class="card-body border-top-0 pb-6 pt-2">--}}
{{--                                        <div class="text-center">--}}
{{--                                            <span class="avatar brround mr-3 bg-primary-transparent text-primary"><i class="ri-facebook-line"></i></span>--}}
{{--                                            <span class="avatar brround mr-3 bg-primary-transparent text-primary"><i class="ri-instagram-line"></i></span>--}}
{{--                                            <span class="avatar brround mr-3 bg-primary-transparent text-primary"><i class="ri-twitter-line"></i></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
