@extends('admin.layouts.master')

@section('title', $product->name)

@section('content')
    <div class="container-fluid pt-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="form-box">
                    <form action="{{ route('products.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-title text-center">
                            <h4 class="mb-0">{{ trans('custome.update') }}</h4>
                            @if (session('updateSuccess'))
                                <div class="alert alert-success mb-0 mt-2" role="alert">
                                    {{ session('updateSuccess') }}
                                </div>
                            @endif
                        </div>
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="text-capitalize">
                                            {{ trans('validation.attributes.name') }}
                                        </label>
                                        @if ($errors->has('name'))
                                            <p class="mb-0 text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="
                                                @if(old('name'))
                                                    {{ old('name') }}
                                                @else
                                                    {{ $product->name }}
                                                @endif"
                                            >
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="description" class="text-capitalize">
                                            {{ trans('validation.attributes.description') }}
                                        </label>
                                        @if ($errors->has('description'))
                                            <p class="mb-0 text-danger">{{ $errors->first('description') }}</p>
                                        @endif
                                        <input type="text" name="description" class="form-control" id="description"
                                            value="
                                                @if(old('description'))
                                                    {{ old('description') }}
                                                @else
                                                    {{ $product->description }}
                                                @endif"
                                            >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="price" class="text-capitalize">
                                            {{ trans('validation.attributes.price') }}
                                        </label>
                                        @if ($errors->has('price'))
                                            <p class="mb-0 text-danger">{{ $errors->first('price') }}</p>
                                        @endif
                                        <input type="text" name="price" class="form-control" id="price"
                                            value="
                                                @if(old('price'))
                                                    {{ old('price') }}
                                                @else
                                                    {{ $product->price }}
                                                @endif"
                                            >
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="sale_price" class="text-capitalize">
                                            {{ trans('validation.attributes.sale_price') }}
                                        </label>
                                        @if ($errors->has('sale_price'))
                                            <p class="mb-0 text-danger">{{ $errors->first('sale_price') }}</p>
                                        @endif
                                        <input type="text" name="sale_price" class="form-control" id="sale_price"
                                            value="
                                                @if(old('sale_price'))
                                                    {{ old('sale_price') }}
                                                @else
                                                    {{ $product->sale_price }}
                                                @endif"
                                            >
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="sale_percent" class="text-capitalize">
                                            {{ trans('validation.attributes.sale_percent') }}
                                        </label>
                                        @if ($errors->has('sale_percent'))
                                            <p class="mb-0 text-danger">{{ $errors->first('sale_percent') }}</p>
                                        @endif
                                        <input type="text" name="sale_percent" class="form-control" id="sale_percent"
                                            value="
                                                @if(old('sale_percent'))
                                                    {{ old('sale_percent') }}
                                                @else
                                                    {{ $product->sale_percent }}
                                                @endif"
                                            >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="quantity" class="text-capitalize">
                                            {{ trans('validation.attributes.quantity') }}
                                        </label>
                                        @if ($errors->has('quantity'))
                                            <p class="mb-0 text-danger">{{ $errors->first('quantity') }}</p>
                                        @endif
                                        <input type="number" name="quantity" class="form-control" id="quantity"
                                            value="{{ $product->quantity }}">
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
                                                @if (old('parent'))
                                                    @if (old('parent') == $cate->id) selected @endif
                                                @else
                                                    @if ($product->category_id == $cate->id) selected @endif
                                                @endif
                                            >
                                                {{ $cate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="text-capitalize">
                                    {{ trans('validation.attributes.image') }}
                                </label>
                                @if ($errors->has('image'))
                                    <p class="mb-0 text-danger">{{ $errors->first('image') }}</p>
                                @endif
                                <input type="file" name="image" id="image" value="{{ $product->first_image->name }}">
                                <input type="hidden" name="image_replace" id="image"
                                    value="
                                        @if(old('image_replace'))
                                            {{ old('image_replace') }}
                                        @else
                                            {{ $product->first_image->name }}
                                        @endif"
                                    >
                            </div>
                            <div class="img text-center">
                                <img class="w-50 h-auto img-thumbnail" src="{{ asset(config('custome.link_img_product') . $product->first_image->name) }}"
                                    alt="{{ $product->name }}">
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

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/admin/admin_product_detail.js') }}"></script>
@endsection
