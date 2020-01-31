@extends('admin.layouts.master')

@section('title', trans('custome.order'))

@section('meta-header')
    <meta name="confirmDeleteOrder" content="{{ trans('custome.confirm_del_order') }}">
@endsection

@section('content')
    <div class="p-3">
        <table class="table table-striped table-order">
            <thead>
                <tr>
                    <th class="text-capitalize">{{ trans('custome.user') }}</th>
                    <th class="text-capitalize">{{ trans('custome.order_code') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.status') }}</th>
                    <th class="text-capitalize">{{ trans('validation.attributes.created_at') }}</th>
                    <th class="text-capitalize">{{ trans('custome.total_price') }}</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            @foreach ($orders as $order)
                <tr>
                    <td>
                        {{ $order->user->name }}
                    </td>
                    <td>
                        <b>{{ $order->order_code }}</b>
                    </td>
                    <td>
                        @if ($order->status == \App\Models\Order::PENDING)
                            <span class="badge badge-primary p-2">{{ trans('custome.status_pending') }}</span>
                        @else
                            <span class="badge badge-success p-2">{{ trans('custome.status_success') }}</span>
                        @endif
                    </td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <p class="mb-0 text-capitalize">
                            <b class="text-primary"> {{ convertVnd($order->total_price) }}</b>
                        </p>
                    </td>
                    <td>
                        <a href="{{ route('orders.show', ['id' => $order->id]) }}"
                            class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.order.delete', ['id' => $order->id]) }}"
                            class="btn btn-danger delete-order">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="pb-3">
        {!! $orders->links() !!}
    </div>
@endsection
