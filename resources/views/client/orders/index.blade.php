@extends('client.layouts.master')

@section('title', trans('custome.order'))

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="order-info-user">
                    @if (session()->has('cart'))
                        <div class="form-box">
                            <form action="{{ route('client.orders.create') }}" method="POST">
                                @csrf
                                <div class="form-title text-center">
                                    <h4 class="mb-0">{{ trans('custome.shipment_detail') }}</h4>
                                    @if (session('status'))
                                        <div class="alert alert-danger mb-0 mt-2" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="name" class="text-capitalize">
                                            {{ trans('validation.attributes.name') }}
                                        </label>
                                        @if ($errors->has('name'))
                                            <p class="mb-0 text-danger">{{ $errors->first('email') }}</p>
                                        @endif
                                        <input type="text" name="name" class="form-control" id="name" disabled
                                            value="{{ auth()->user()->name }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="phone"c lass="text-capitalize">
                                            {{ trans('validation.attributes.phone') }}
                                        </label>
                                        @if ($errors->has('phone'))
                                            <p class="mb-0 text-danger">{{ $errors->first('password') }}</p>
                                        @endif
                                        <input type="text" name="phone" class="form-control" id="phone" disabled
                                            value="{{ auth()->user()->phone }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="email" class="text-capitalize">
                                            {{ trans('validation.attributes.email') }}
                                        </label>
                                        @if ($errors->has('email'))
                                            <p class="mb-0 text-danger">{{ $errors->first('password') }}</p>
                                        @endif
                                        <input type="text" name="email" class="form-control" id="email" disabled
                                            value="{{ auth()->user()->email }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="address" class="text-capitalize">
                                            {{ trans('validation.attributes.address') }}
                                        </label>
                                        @if ($errors->has('address'))
                                            <p class="mb-0 text-danger">{{ $errors->first('address') }}</p>
                                        @endif
                                        <input type="text" name="address" class="form-control" id="address" disabled
                                            value="{{ auth()->user()->address }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="city" class="text-capitalize">
                                            {{ trans('validation.attributes.city') }}
                                        </label>
                                        @if ($errors->has('city'))
                                            <p class="mb-0 text-danger">{{ $errors->first('city') }}</p>
                                        @endif
                                        <input type="text" name="city" class="form-control" id="city" disabled
                                            value="{{ auth()->user()->city->name }}">
                                    </div>
                                    <div class="form-group mb-0 mt-1 text-right">
                                        <a href="">{{ trans('custome.note_update_infor') }}</a>
                                    </div>
                                </div>
                                <div class="form-footer text-center">
                                    <button type="submit" class="btn btn-primary">{{ trans('custome.order') }}</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if (isset($orderSuccess))
                        <div class="alert alert-success mb-0" role="alert">
                            <p class="mb-1">{{ $orderSuccess }}</p>
                            <p class="mb-0">{{ $orderCode }}</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="order-info">
                    @if(session()->has('cart'))
                        <table class="table table-striped table-order">
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
                                </tr>
                            @endforeach
                        </table>
                        <div class="d-flex justify-content-between">
                            <h5 class="text-capitalize">
                                {{ trans('custome.total_price') . ":" }}
                                <b class="text-primary"> {{ convertVnd($totalPrice) }}</b>
                            </h5>
                            <a href="{{ route('client.cart.index') }}" class="btn btn-template text-capitalize">
                                {{ trans('custome.edit_cart') }}
                            </a>
                        </div>
                    @endif

                    @if (isset($products) && !session()->has('cart'))
                        <table class="table table-striped table-order">
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
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
            @if (!session()->has('cart') && !isset($orderSuccess))
                <div class="col-12">
                    <div class="box-no-item-cart">
                        <div>
                            <h1 class="mb-3">{{ trans('custome.no_product_cart') }}</h1>
                            <div>
                                <a class="btn btn-template" href="{{ route('client.products.index') }}">
                                    {{ trans('custome.continue_buy') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
