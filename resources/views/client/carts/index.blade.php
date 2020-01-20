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
                        <thead>
                            <tr>
                                <th class="text-capitalize">{{ trans('validation.attributes.image') }}</th>
                                <th class="text-capitalize">{{ trans('validation.attributes.name') }}</th>
                                <th class="text-capitalize">{{ trans('validation.attributes.price') }}</th>
                                <th class="text-capitalize">{{ trans('validation.attributes.sale_price') }}</th>
                                <th class="text-capitalize">{{ trans('validation.attributes.sale_percent') }}</th>
                                <th class="text-capitalize">{{ trans('validation.attributes.quantity') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
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
                                @else
                                    <td></td>
                                @endif
                                @if ($product['item']->sale_percent != null)
                                    <td>
                                        <span class="sale-percent">{{ "-" . $product['item']->sale_percent . "%" }}</span>
                                    </td>
                                @else
                                    <td></td>
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
                    <div class="d-flex justify-content-between">
                        <h5 class="text-capitalize">
                            {{ trans('custome.total_price') . ":" }}
                            <b class="text-primary"> {{ convertVnd($totalPrice) }}</b>
                        </h5>
                        <a href="{{ route('client.orders.index') }}" class="btn btn-template text-capitalize">
                            {{ trans('custome.order') }}
                        </a>
                    </div>
                @else
                    <div class="box-no-item-cart">
                        <div>
                            <h1 class="mb-3">{{ trans('custome.no_history_order') }}</h1>
                            <div>
                                <a class="btn btn-template" href="{{ route('client.products.index') }}">
                                    {{ trans('custome.continue_buy') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
