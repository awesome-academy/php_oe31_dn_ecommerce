@extends('admin.layouts.master')

@section('title', trans('custome.order_history'))

@section('meta-header')
    <meta name="confirmOrderPending" content="{{ trans('custome.confirm_order_pending') }}">
    <meta name="confirmOrderSuccess" content="{{ trans('custome.confirm_order_success') }}">
    <meta name="confirmOrderCancel" content="{{ trans('custome.confirm_order_cancel') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="my-2">
                    <h5 class="">
                        {{ trans('custome.order_code') . ": " }}
                        <b>{{ $order->order_code }}</b>
                    </h5>
                    <div>
                        <p class="mb-0">
                            <span class="text-capitalize">{{ trans('validation.attributes.status') }}:</span>
                            @switch($order->status)
                                @case(\App\Models\Order::PENDING)
                                    <span class="badge badge-primary p-2">{{ trans('custome.status_pending') }}</span>
                                @break

                                @case(\App\Models\Order::SUCCESS)
                                    <span class="badge badge-success p-2">{{ trans('custome.status_success') }}</span>
                                @break

                                @case(\App\Models\Order::CANCEL)
                                    <span class="badge badge-secondary p-2">{{ trans('custome.status_cancel') }}</span>
                                @break
                            @endswitch
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
                <table class="table table-striped table-product">
                    <thead>
                        <tr>
                            <th class="text-capitalize">{{ trans('validation.attributes.image') }}</th>
                            <th class="text-capitalize">{{ trans('validation.attributes.name') }}</th>
                            <th class="text-capitalize">{{ trans('validation.attributes.price') }}</th>
                            <th class="text-capitalize">{{ trans('validation.attributes.sale_price') }}</th>
                            <th class="text-capitalize">{{ trans('validation.attributes.sale_percent') }}</th>
                            <th class="text-capitalize">{{ trans('validation.attributes.quantity') }}</th>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    <p class="mb-0">
                        <b class="text-capitalize">{{ trans('validation.attributes.name') }}:</b> {{ $order->user->name }}
                    </p>
                    <p class="mb-0">
                        <b class="text-capitalize">{{ trans('validation.attributes.address') }}:</b>
                        {{ $order->user->address }}
                    </p>
                    <p class="mb-0">
                        <b class="text-capitalize">{{ trans('validation.attributes.city') }}:</b>
                        {{ $order->user->city->name }}
                    </p>
                    <p class="mb-0">
                        <b class="text-capitalize">{{ trans('validation.attributes.email') }}:</b>
                        {{ $order->user->email }}
                    </p>
                    <p class="mb-0">
                        <b class="text-capitalize">{{ trans('validation.attributes.phone') }}:</b>
                        {{ $order->user->phone }}
                    </p>
                </div>
                <hr>
                <div class="text-capitalize font-weight-bold">
                    {{ trans('custome.total_price') . ":" }}
                    <b class="text-primary"> {{ convertVnd($order->total_price) }}</b>
                </div>
                <hr>
                <div>
                    <h5>{{ trans('custome.change') }} {{ trans('validation.attributes.status') }}</h5>
                    @switch($order->status)
                        @case(\App\Models\Order::PENDING)
                            <a href="{{ route('admin.order.change-success', ['id' => $order->id]) }}"
                                class="btn btn-primary order-change-success">
                                <i class="fas fa-check"></i>
                                {{ trans('custome.status_success') }}
                            </a>
                            <a href="{{ route('admin.order.change-cancel', ['id' => $order->id]) }}"
                                class="btn btn-secondary order-change-cancel">
                                <i class="fas fa-window-close"></i>
                                {{ trans('custome.cancel') }}
                            </a>
                        @break

                        @case(\App\Models\Order::SUCCESS)
                            <a href="{{ route('admin.order.change-pending', ['id' => $order->id]) }}"
                                class="btn btn-primary order-change-pending">
                                <i class="fas fa-spinner"></i>
                                {{ trans('custome.status_pending') }}
                            </a>
                            <a href="{{ route('admin.order.change-cancel', ['id' => $order->id]) }}"
                                class="btn btn-secondary order-change-cancel">
                                <i class="fas fa-window-close"></i>
                                {{ trans('custome.cancel') }}
                            </a>
                        @break

                        @case(\App\Models\Order::CANCEL)
                            <a href="{{ route('admin.order.change-success', ['id' => $order->id]) }}"
                                class="btn btn-success order-change-success">
                                <i class="fas fa-check"></i>
                                {{ trans('custome.status_success') }}
                            </a>
                            <a href="{{ route('admin.order.change-pending', ['id' => $order->id]) }}"
                                class="btn btn-primary order-change-pending">
                                <i class="fas fa-spinner"></i>
                                {{ trans('custome.status_pending') }}
                            </a>
                        @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
@endsection
