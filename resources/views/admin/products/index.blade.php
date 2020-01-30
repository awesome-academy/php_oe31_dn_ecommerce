@extends('admin.layouts.master')
@section('title', trans('custome.products'))

@section('meta-header')
    <meta name="confirmDeleteProduct" content="{{ trans('custome.confirm_del_product') }}">
@endsection

@section('content')
    <div class="p-3">
        <table class="table table-striped table-product">
            <thead>
                <tr>
                    <th class="text-capitalize">{{ trans('validation.attributes.image') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.name') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.price') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.sale_price') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.sale_percent') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.quantity') }}</th>
                    <th></th>
                </tr>
            </thead>
            @foreach ($products as $product)
                <tr>
                    <td>
                        <a href="{{ route('products.show', ['id' => $product->id]) }}">
                            <img src="{{ asset(config('custome.link_img_product') . $product->first_image->name) }}"
                                alt="{{ $product->name }}">
                        </a>
                    </td>
                    <td>
                        {{ $product->description }}
                    </td>
                    <td>
                        @if ($product->sale_price != null)
                            <strike>{{ convertVnd($product->price) }}</strike>
                        @else
                            {{ convertVnd($product->price) }}
                        @endif
                    </td>
                    @if ($product->sale_price != null)
                        <td>
                            <span class="text-primary font-weight-bold">{{ convertVnd($product->sale_price) }}</span>
                        </td>
                    @else
                        <td></td>
                    @endif
                    @if ($product->sale_percent != null)
                        <td>
                            <span class="sale-percent">{{ "-" . $product->sale_percent . "%" }}</span>
                        </td>
                    @else
                        <td></td>
                    @endif
                    <td>
                        <span class="text-primary">{{ $product->quantity }}</span>
                    </td>
                    <td>
                        <a href="{{ route('products.show', ['id' => $product->id]) }}"
                            class="btn btn-success">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.product.delete', ['id' => $product->id]) }}"
                            class="btn btn-danger delete-product">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="d-flex justify-content-center pb-3">
        {!! $products->links() !!}
    </div>
@endsection
