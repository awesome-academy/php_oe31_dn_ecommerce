@extends('admin.layouts.master')

@section('title', trans('custome.create'))

@section('content')
    <div class="container pt-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="form-box">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="form-title text-center">
                            <h4 class="mb-0">{{ trans('custome.create') }}</h4>
                            @if (session('createSuccess'))
                                <div class="alert alert-success mb-0 mt-2" role="alert">
                                    {{ session('createSuccess') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-body">
                            <div class="form-group">
                                <label for="description">{{ trans('custome.parent') }}</label>
                                <select class="custom-select" name="parent">
                                    <option></option>
                                    @foreach ($categories as $cate)
                                        <option value="{{ $cate->id }}"
                                            @if (old('parent'))
                                                @if (old('parent') == $cate->id) selected @endif
                                            @endif
                                        >
                                            {{ $cate->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name" class="text-capitalize">
                                    {{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.name')]) }}
                                </label>
                                @if ($errors->has('name'))
                                    <p class="mb-0 text-danger">{{ $errors->first('name') }}</p>
                                @endif
                                <input type="name" name="name" class="form-control" id="name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="description" class="text-capitalize">
                                    {{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.description')]) }}
                                </label>
                                @if ($errors->has('email'))
                                    <p class="mb-0 text-danger">{{ $errors->first('description') }}</p>
                                @endif
                                <input type="description" name="description" class="form-control" id="description"
                                    value="{{  old('description') }}">
                            </div>
                        </div>
                        <div class="form-footer text-center">
                            <button type="submit" class="btn btn-primary">{{ trans('custome.create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
