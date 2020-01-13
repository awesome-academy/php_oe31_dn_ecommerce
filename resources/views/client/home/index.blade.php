@extends('client.layouts.master')

@section('content')
    <div class="banner">
        <img class="w-100" src="{{ asset(config('custome.link_banner')) . '/banner-bg.jpg'}}" alt="{{ trans('custome.banner') }}">
    </div>
    <div class="container-fluid my-4">
        <div class="hp-part-title mb-4">
            <h3 class="text-center mb-0">{{ trans('custome.new_product') }}</h3>
        </div>
        <div class="row">
            @foreach ($productRelateds as $product)
                <div class="col-12 col-md-3 mb-4">
                    <a href="{{ route('client.products.detail', ['id' => $product->id]) }}" class="product-item">
                        <div class="product-img">
                            <img class="w-100 h-auto"
                                 src="{{ asset(config('custome.link_img_product') . $product->first_image->name) }}"
                                 alt="{{ $product->name }}">
                        </div>
                        <div class="product-name text-center py-2">
                            <p class="mb-0">{{ $product->name }}</p>
                        </div>
                        <div class="product-price text-center">
                            <p class="mb-0">
                                @if ($product->sale_price != null)
                                    <strike>{{ convertVnd($product->price) }}</strike>
                                @else
                                    {{ convertVnd($product->price) }}
                                @endif

                                @if ($product->sale_price != null)
                                    <span> {{ convertVnd($product->sale_price) }}</span>
                                @endif
                            </p>
                            <p class="mb-0 sale-percent">
                                @if ($product->sale_price != null)
                                    {{ "-" . $product->sale_percent . "%" }}
                                @endif
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="hp-part-title mb-4">
            <h3 class="text-center mb-0">{{ $trend->title }}</h3>
        </div>
        <div class="row">
            @foreach ($trend->products as $product)
                <div class="col-12 col-md-3 mb-4">
                    <a href="{{ route('client.products.detail', ['id' => $product->id]) }}" class="product-item">
                        <div class="product-img">
                            <img class="w-100 h-auto"
                                 src="{{ asset(config('custome.link_img_product') . $product->first_image->name) }}"
                                 alt="{{ $product->name }}">
                        </div>
                        <div class="product-name text-center py-2">
                            <p class="mb-0">{{ $product->name }}</p>
                        </div>
                        <div class="product-price text-center">
                            <p class="mb-0">
                                @if ($product->sale_price != null)
                                    <strike>{{ convertVnd($product->price) }}</strike>
                                @else
                                    {{ convertVnd($product->price) }}
                                @endif

                                @if ($product->sale_price != null)
                                    <span> {{ convertVnd($product->sale_price) }}</span>
                                @endif
                            </p>
                            <p class="mb-0 sale-percent">
                                @if ($product->sale_price != null)
                                    {{ "-" . $product->sale_percent . "%" }}
                                @endif
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
