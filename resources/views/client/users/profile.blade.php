@extends('client.layouts.master')

@section('title', trans('custome.update_infor'))

@section('content')
    <div class="container my-4">
        <div class="form-box">
            <form action="{{ route('client.user.update') }}" method="POST">
                @csrf
                <div class="form-title text-center">
                    <h4 class="mb-0">{{ trans('custome.update_infor') }}</h4>
                    @if (session('updateSuccess'))
                        <div class="d-flex justify-content-center">
                            <div class="alert alert-success mb-0 mt-2 w-75" role="alert">
                                {{ session('updateSuccess') }}
                            </div>
                        </div>
                    @endif
                </div>
                <div class="form-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="name" class="text-capitalize">{{ trans('validation.attributes.name') }}</label>
                                @if ($errors->has('name'))
                                    <p class="mb-0 text-danger">{{ $errors->first('name') }}</p>
                                @endif
                                <input type="text" name="name" class="form-control" id="name"
                                    value="
                                        @if (old('name'))
                                            {{ old('name') }}
                                        @else
                                            {{ $user->name }}
                                        @endif
                                    ">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="phone" class="text-capitalize">{{ trans('validation.attributes.phone') }}</label>
                                @if ($errors->has('phone'))
                                    <p class="mb-0 text-danger">{{ $errors->first('phone') }}</p>
                                @endif
                                <input type="text" name="phone" class="form-control" id="phone"
                                    value="
                                    @if (old('phone'))
                                        {{ old('phone') }}
                                    @else
                                        {{ $user->phone }}
                                    @endif
                                ">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="email" class="text-capitalize">{{ trans('validation.attributes.email') }}</label>
                                @if ($errors->has('email'))
                                    <p class="mb-0 text-danger">{{ $errors->first('email') }}</p>
                                @endif
                                <input type="email" name="email" class="form-control" id="email"
                                    value="
                                    @if (old('email'))
                                        {{ old('email') }}
                                    @else
                                        {{ $user->email }}
                                    @endif
                                ">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="address" class="text-capitalize">{{ trans('validation.attributes.address') }}</label>
                                @if ($errors->has('address'))
                                    <p class="mb-0 text-danger">{{ $errors->first('address') }}</p>
                                @endif
                                <input type="text" name="address" class="form-control" id="address"
                                    value="
                                    @if (old('address'))
                                    {{ old('address') }}
                                    @else
                                        {{ $user->address }}
                                    @endif
                                ">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group mb-0">
                                <label for="city" class="text-capitalize">{{ trans('validation.attributes.city') }}</label>
                                @if ($errors->has('city'))
                                    <p class="mb-0 text-danger">{{ $errors->first('city') }}</p>
                                @endif
                                <select class="custom-select" name="city">
                                    <option></option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            @if (old('city'))
                                                @if (old('city') == $city->id) selected @endif
                                            @else
                                                @if ($user->city->id == $city->id) selected @endif
                                            @endif
                                        >
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="birthdate" class="text-capitalize">{{ trans('validation.attributes.birthdate') }}</label>
                                @if ($errors->has('birthdate'))
                                    <p class="mb-0 text-danger">{{ $errors->first('birthdate') }}</p>
                                @endif
                                <input type="date" name="birthdate" class="form-control" id="birthdate"
                                    value="{{ $user->birthdate }}">
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
                                <input type="radio" class="mr-1" id="male" name="gender" value="{{ \App\Models\User::MALE }}"
                                    @if ($user->gender == \App\Models\User::MALE) checked @endif>
                                <label for="female" class="text-capitalize mr-1">{{ trans('validation.attributes.fe_male') }}</label>
                                <input type="radio" id="female" name="gender" value="{{ \App\Models\User::FE_MALE }}"
                                    @if ($user->gender == \App\Models\User::FE_MALE) checked @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-footer text-center">
                    <button type="submit" class="btn btn-primary">{{ trans('custome.update') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
