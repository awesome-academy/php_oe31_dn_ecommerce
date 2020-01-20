@extends('client.layouts.master')

@section('title', trans('custome.suggest'))

@section('content')
    <div class="login-client">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 my-4">
                    <div class="form-box">
                        @if (session('suggestSuccess'))
                            <div class="alert alert-success mb-0 mb-2" role="alert">
                                {{ session('suggestSuccess') }}
                            </div>
                        @endif
                        <form action="{{ route('client.suggest.post') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h4 class="mb-0 pb-2 text-capitalize">{{ trans('custome.suggest') }}</h4>
                            @if (session('status'))
                                <div class="alert alert-danger mb-0 mt-2" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="content">
                                        {{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.content')]) }}
                                    </label>
                                    @if ($errors->has('content'))
                                        <p class="mb-0 text-danger">{{ $errors->first('content') }}</p>
                                    @endif
                                    <textarea type="text" name="content" class="form-control"></textarea>
                                </div>
                                @if ($errors->has('image'))
                                    <p class="mb-0 text-danger">{{ $errors->first('image') }}</p>
                                @endif
                                <div class="custom-file">
                                    <input type="file" name="image">
                                </div>
                            </div>
                            <div class="form-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('custome.suggest') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
