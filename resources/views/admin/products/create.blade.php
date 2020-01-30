@extends('admin.layouts.master')

@section('title', trans('custome.create'))

@section('content')
    <div class="container-fluid pt-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="form-box">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
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
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="text-capitalize">
                                            {{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.name')]) }}
                                        </label>
                                        @if ($errors->has('name'))
                                            <p class="mb-0 text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="description" class="text-capitalize">
                                            {{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.description')]) }}
                                        </label>
                                        @if ($errors->has('description'))
                                            <p class="mb-0 text-danger">{{ $errors->first('description') }}</p>
                                        @endif
                                        <input type="text" name="description" class="form-control" id="description"
                                            value="{{  old('description') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="price" class="text-capitalize">
                                            {{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.price')]) }}
                                        </label>
                                        @if ($errors->has('price'))
                                            <p class="mb-0 text-danger">{{ $errors->first('price') }}</p>
                                        @endif
                                        <input type="text" name="price" class="form-control" id="price" value="{{ old('price') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="sale_price" class="text-capitalize">
                                            {{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.sale_price')]) }}
                                        </label>
                                        @if ($errors->has('sale_price'))
                                            <p class="mb-0 text-danger">{{ $errors->first('sale_price') }}</p>
                                        @endif
                                        <input type="text" name="sale_price" class="form-control" id="sale_price"
                                            value="{{ old('sale_price') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="sale_percent" class="text-capitalize">
                                            {{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.sale_percent')]) }}
                                        </label>
                                        @if ($errors->has('sale_percent'))
                                            <p class="mb-0 text-danger">{{ $errors->first('sale_percent') }}</p>
                                        @endif
                                        <input type="text" name="sale_percent" class="form-control" id="sale_percent"
                                            value="{{ old('sale_percent') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="quantity" class="text-capitalize">
                                            {{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.quantity')]) }}
                                        </label>
                                        @if ($errors->has('quantity'))
                                            <p class="mb-0 text-danger">{{ $errors->first('quantity') }}</p>
                                        @endif
                                        <input type="number" name="quantity" class="form-control" id="price" value="{{ old('quantity') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="category">{{ trans('custome.category') }}</label>
                                    @if ($errors->has('category'))
                                        <p class="mb-0 text-danger">{{ $errors->first('category') }}</p>
                                    @endif
                                    <select class="custom-select" name="category">
                                        <option></option>
                                        @foreach ($categories as $cate)
                                            <option value="{{ $cate->id }}"
                                                @if (old('category'))
                                                    @if (old('category') == $cate->id) selected @endif
                                                @endif
                                            >
                                                {{ $cate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="quantity" class="text-capitalize">
                                    {{ trans('validation.attributes.image') }}
                                </label>
                                @if ($errors->has('image'))
                                    <p class="mb-0 text-danger">{{ $errors->first('image') }}</p>
                                @endif
                                <input type="file" name="image" id="image" value="{{ old('image') }}">
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
