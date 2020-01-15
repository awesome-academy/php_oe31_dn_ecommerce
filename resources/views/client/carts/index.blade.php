@extends('client.layouts.master')

@section('title', trans('custome.cart'))

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            @if (session('notAddProduct'))
                <div class="alert alert-danger mb-2" role="alert">
                    {{ session('notAddProduct') }}
                </div>
            @endif
            <div class="col-12">
                @if (session()->has('cart'))
                    <table class="table table-striped table-cart">
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('client.products.detail', ['id' => $product['item']->id]) }}">
                                        <img src="{{ asset(config('custome.link_img_product') . $product['item']->first_image->name) }}"
                                            alt="{{ $product['item']->name }}">
                                    </a>
                                </td>
                                <td>
                                    {{ $product['item']->name }}
                                </td>
                                <td>
                                    @if ($product['item']->sale_price != null)
                                        <strike>{{ convertVnd($product['item']->price) }}</strike>
                                    @else
                                        {{ convertVnd($product['item']->price) }}
                                    @endif
                                </td>
                                @if ($product['item']->sale_price != null)
                                    <td>
                                        {{ convertVnd($product['item']->sale_price) }}
                                    </td>
                                @endif
                                @if ($product['item']->sale_percent != null)
                                    <td>
                                        <span class="sale-percent">{{ "-" . $product['item']->sale_percent . "%" }}</span>
                                    </td>
                                @endif
                                <td>
                                    <span class="text-primary">{{ $product['qty'] }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('client.cart.increase', ['id' => $product['item']->id]) }}"
                                       class="btn btn-dark">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a href="{{ route('client.cart.reduce', ['id' => $product['item']->id]) }}"
                                       class="btn btn-dark">
                                        <i class="fas fa-minus"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('client.cart.remove', ['id' => $product['item']->id]) }}"
                                       class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div>
                        <h5 class="text-capitalize">
                            {{ trans('custome.total_price') . ":" }}
                            <b class="text-primary"> {{ convertVnd($totalPrice) }}</b>
                        </h5>
                    </div>
                @else
                    <h1>{{ trans('custome.no_product_cart') }}</h1>
                @endif
            </div>
        </div>
    </div>
@endsection
