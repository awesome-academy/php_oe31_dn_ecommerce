@extends('client.layouts.master')

@section('title', trans('custome.filter'))

@section('content')
    <div class="container-fluid my-4">
        <div class="hp-part-title">
            <h3 class="text-center mb-0">{{ trans('custome.products') }}</h3>
        </div>
        <div class="row">
            <div class="col-12 py-3">
                <div class="box-filter">
                    <select class="filter-form-category form-control w-auto mr-2">
                        <option value="">{{ trans('custome.filter') }}</option>
                        @foreach (trans('custome.filter_by') as $filter)
                            <option
                                @if ($filterBy == $filter['value']) selected @endif
                                value="{{ $filter['value'] }}">
                                {{ $filter['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-12 col-md-3 mb-4">
                    <a href="{{ route('client.products.detail', ['id' => $product->id]) }}" class="product-item">
                        <div class="product-img-fix">
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
        <div class="row">
            <div class="col-12 d-flex justify-content-center py-3">
                {!! $products->links() !!}
            </div>
        </div>
    </div>
@endsection
