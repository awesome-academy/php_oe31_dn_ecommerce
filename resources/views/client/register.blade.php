@extends('client.layouts.master')
@section('title', trans('custome.sign_up'))

@section('content')
    <div class="login-client">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 my-4">
                    <div class="form-box">
                        <form action="{{ route('client.register.post') }}" method="POST">
                            @csrf
                            <div class="form-title text-center">
                                <h4 class="mb-0">{{ trans('custome.sign_up') }}</h4>
                                @if (session('status'))
                                    <div class="alert alert-danger mb-0 mt-2" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="name">{{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.name')]) }}</label>
                                                @if ($errors->has('name'))
                                                    <p class="mb-0 text-danger">{{ $errors->first('name') }}</p>
                                                @endif
                                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="phone">{{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.phone')]) }}</label>
                                                @if ($errors->has('phone'))
                                                    <p class="mb-0 text-danger">{{ $errors->first('phone') }}</p>
                                                @endif
                                            <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="email">{{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.email')]) }}</label>
                                                @if ($errors->has('email'))
                                                    <p class="mb-0 text-danger">{{ $errors->first('email') }}</p>
                                                @endif
                                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group mb-0">
                                            <label for="pwd">{{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.password')]) }}</label>
                                                @if ($errors->has('password'))
                                                    <p class="mb-0 text-danger">{{ $errors->first('password') }}</p>
                                                @endif
                                            <input type="password" name="password" class="form-control" id="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="address">{{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.address')]) }}</label>
                                                @if ($errors->has('address'))
                                                    <p class="mb-0 text-danger">{{ $errors->first('address') }}</p>
                                                @endif
                                            <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group mb-0">
                                            <label for="city" class="text-capitalize">{{ trans('validation.attributes.city') }}</label>
                                                @if ($errors->has('city'))
                                                    <p class="mb-0 text-danger">{{ $errors->first('city') }}</p>
                                                @endif
                                            <select class="custom-select" name="city">
                                                <option></option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" @if (old('city') == $city->id) { selected } @endif>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <div>
                                                <label for="gender" class="text-capitalize">{{ trans('validation.attributes.gender') }}</label>
                                            </div>
                                                @if ($errors->has('gender'))
                                                    <p class="mb-0 text-danger">{{ $errors->first('gender') }}</p>
                                                @endif
                                            <label for="male" class="text-capitalize mr-1">{{ trans('validation.attributes.male') }}</label>
                                            <input type="radio" class="mr-1" id="male" name="gender" value="{{ \App\Models\User::MALE }}">
                                            <label for="female" class="text-capitalize mr-1">{{ trans('validation.attributes.fe_male') }}</label>
                                            <input type="radio" id="female" name="gender" value="{{ \App\Models\User::FE_MALE }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="birthdate">{{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.birthdate')]) }}</label>
                                                @if ($errors->has('birthdate'))
                                                    <p class="mb-0 text-danger">{{ $errors->first('birthdate') }}</p>
                                                @endif
                                            <input type="date" name="birthdate" class="form-control" id="birthdate" value="{{ old('birthdate') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('custome.sign_up') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
