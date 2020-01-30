@extends('admin.layouts.master')

@section('title', $category->name)

@section('content')
    <div class="container pt-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="form-box">
                    <form action="{{ route('categories.update', ['id' => $category->id]) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-title text-center">
                            <h4 class="mb-0">{{ trans('custome.update') }}</h4>
                            @if (session('status'))
                                <div class="alert alert-danger mb-0 mt-2" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if (session('updateSuccess'))
                                <div class="alert alert-success mb-0 mt-2" role="alert">
                                    {{ session('updateSuccess') }}
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
                                            @if ($category->parent != null)
                                                @if ($category->parent->id == $cate->id) selected @endif
                                            @endif
                                        >
                                            {{ $cate->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name" class="text-capitalize">{{ trans('validation.attributes.name') }}</label>
                                @if ($errors->has('name'))
                                    <p class="mb-0 text-danger">{{ $errors->first('name') }}</p>
                                @endif
                                <input type="name" name="name" class="form-control" id="name"
                                    value="
                                        @if(old('name'))
                                            {{ old('name') }}
                                        @else
                                            {{ $category->name }}
                                        @endif"
                                    >
                            </div>
                            <div class="form-group">
                                <label for="description" class="text-capitalize">{{ trans('validation.attributes.description') }}</label>
                                @if ($errors->has('email'))
                                    <p class="mb-0 text-danger">{{ $errors->first('description') }}</p>
                                @endif
                                <input type="description" name="description" class="form-control" id="description"
                                    value="
                                        @if(old('description'))
                                            {{ old('description') }}
                                        @else
                                            {{ $category->description }}
                                        @endif"
                                    >
                            </div>
                        </div>
                        <div class="form-footer text-center">
                            <button type="submit" class="btn btn-primary">{{ trans('custome.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
