@extends('client.layouts.master')

@section('content')
    <div class="login-client">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 my-4">
                    <div class="form-box">
                        <form action="{{ route('client.login.post') }}" method="POST">
                            @csrf
                            <div class="form-title text-center">
                                <h4 class="mb-0">{{ trans('custome.sign_in') }}</h4>
                                @if (session('status'))
                                    <div class="alert alert-danger mb-0 mt-2" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="email">{{ trans('custome.enter_input', ['attribute' => trans('attribute.email')]) }}</label>
                                        @if ($errors->has('email'))
                                            <p class="mb-0 text-danger">{{ $errors->first('email') }}</p>
                                        @endif
                                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
                                </div>
                                <div class="form-group mb-0">
                                    <label for="password">{{ trans('custome.enter_input', ['attribute' => trans('attribute.password')]) }}</label>
                                        @if ($errors->has('password'))
                                            <p class="mb-0 text-danger">{{ $errors->first('password') }}</p>
                                        @endif
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                            </div>
                            <div class="form-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('custome.sign_in') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
