@extends('client.layouts.master')

@section('title', trans('custome.order_history'))

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                @if (session('notAddProduct'))
                    <div class="alert alert-danger mb-2" role="alert">
                        {{ session('notAddProduct') }}
                    </div>
                @endif
                @if (session('notEditOrder'))
                    <div class="alert alert-danger mb-0 mb-2" role="alert">
                        {{ session('notEditOrder') }}
                    </div>
                @endif
                <div class="my-2">
                    <h5 class="">
                        {{ trans('custome.order_code') . ": " . $order->order_code }}
                    </h5>
                    <div>
                        <p class="mb-0">
                            <span class="text-capitalize">{{ trans('validation.attributes.status') }}:</span>
                            @if ($order->status == \App\Models\Order::PENDING)
                                <span class="text-primary">{{ trans('custome.status_pending') }}</span>
                            @else
                                <span class="text-success">{{ trans('custome.status_success') }}</span>
                            @endif
                        </p>
                        <p class="mb-0 text-capitalize">
                            <span>{{ trans('validation.attributes.time') }}: </span>
                            {{ $order->created_at }}
                        </p>
                    </div>
                    <div>
                        <p class="mb-0"><b>{{ trans('custome.products') }}: </b></p>
                    </div>
                </div>
                <table class="table table-striped table-order">
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
                    <tbody>
                        @foreach ($order->order_details as $detail)
                            <tr>
                                <td>
                                    <a href="{{ route('client.products.detail', ['id' => $detail->product->id]) }}">
                                        <img src="{{ asset(config('custome.link_img_product') . $detail->product->first_image->name) }}"
                                            alt="{{ $detail->product->name }}">
                                    </a>
                                </td>
                                <td>
                                    {{ $detail->product->name }}
                                </td>
                                <td>
                                    @if ($detail->product->sale_price != null)
                                        <strike>{{ convertVnd($detail->product->price) }}</strike>
                                    @else
                                        {{ convertVnd($detail->product->price) }}
                                    @endif
                                </td>
                                @if ($detail->product->sale_price != null)
                                    <td>
                                        {{ convertVnd($detail->product->sale_price) }}
                                    </td>
                                @else
                                    <td></td>
                                @endif
                                @if ($detail->product->sale_percent != null)
                                    <td>
                                        <span class="sale-percent">{{ "-" . $detail->product->sale_percent . "%" }}</span>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                                <td>
                                    {{ $detail->quantity }}
                                </td>
                                <td>
                                    <a href="{{ route('client.orders.increase', ['id' => $detail->id]) }}"
                                        class="btn btn-dark">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a href="{{ route('client.orders.reduce', ['id' => $detail->id]) }}"
                                        class="btn btn-dark">
                                        <i class="fas fa-minus"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('client.orders.remove_item', ['id' => $detail->id]) }}"
                                        class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-capitalize">
                    {{ trans('custome.total_price') . ":" }}
                    <b class="text-primary"> {{ convertVnd($order->total_price) }}</b>
                </div>
            </div>
        </div>
    </div>
@endsection
