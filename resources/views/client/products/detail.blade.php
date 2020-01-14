@extends('client.layouts.master')

@section('title', $product->name)

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-12 col-lg-7 order-sm-2 order-lg-1">
                <div class="product-img">
                    <div id="carouselProductImg" class="carousel slide carousel-fade" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="w-100 h-auto img-thumbnail"
                                    src="{{ asset(config('custome.link_img_product') . $product->first_image->name) }}"
                                    alt="{{ $product->first_image->name }}">
                            </div>
                            @foreach ($product->images as $img)
                                <div class="carousel-item">
                                    <img class="w-100 h-auto img-thumbnail"
                                        src="{{ asset(config('custome.link_img_product') . $img->name) }}"
                                        alt="{{ $img->name }}">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselProductImg" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">{{ trans('custome.previous') }}</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselProductImg" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">{{ trans('custome.next') }}</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 order-sm-1 order-lg-2 py-3">
                <div class="product-content">
                    <div class="name pb-3">
                        <p class="mb-0">{{ $product->name }}</p>
                    </div>
                    <div class="price-box py-3">
                        <p class="mb-0">
                            @if ($product->sale_price != null)
                                <span class="price-strike pr-2"><strike>{{ convertVnd($product->price) }}</strike></span>
                                <span class="price-sale pr-2">{{ convertVnd($product->sale_price) }}</span>
                            @else
                                <span class="price pr-2">{{ convertVnd($product->price) }}</span>
                            @endif
                            @if ($product->sale_percent != null)
                                <span class="sale-percent">{{ "-" . $product->sale_percent . "%" }}</span>
                            @endif
                        </p>
                    </div>
                    @if ($product->description != null)
                        <div class="description py-3">
                            <p class="mb-0 text-capitalize">
                                <b>{{ trans('validation.attributes.description') }}:</b>
                            </p>
                            <p class="mb-0">{{ $product->description }}</p>
                        </div>
                    @endif
                    <div class="action pt-3 text-center">
                        <a class="btn btn-template my-2 my-sm-0 w-50" href="">
                            {{ trans('custome.add_to_cart') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 pt-3">
                <div class="form-box">
                    <form action="{{ route('client.products.comment') }}" method="POST">
                        @csrf
                            <h4 class="mb-0 pb-2 text-capitalize">{{ trans('custome.comment') }}</h4>
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
                        </div>
                        <div class="form-footer text-center">
                            <button type="submit" class="btn btn-template text-capitalize">{{ trans('custome.comment') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
