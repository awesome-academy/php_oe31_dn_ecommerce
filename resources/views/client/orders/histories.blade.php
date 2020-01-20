@extends('client.layouts.master')

@section('title', trans('custome.order_history'))

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-order">
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                {{ trans('custome.order_code') . ": " . $order->order_code }}
                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                <span class="text-capitalize">{{ trans('validation.attributes.status') }}:</span>
                                @if ($order->status == \App\Models\Order::PENDING)
                                    <span class="text-primary">{{ trans('custome.status_pending') }}</span>
                                @else
                                    <span class="text-success">{{ trans('custome.status_success') }}</span>
                                @endif
                            </td>
                            <td>
                                <p class="mb-0 text-capitalize">
                                    {{ trans('custome.total_price') . ":" }}
                                    <b class="text-primary"> {{ convertVnd($order->total_price) }}</b>
                                </p>
                            </td>
                            <td>
                                <a href="{{ route('client.orders.detail', ['id' => $order->id]) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('client.orders.delete', ['id' => $order->id]) }}"
                                    class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-12 d-flex justify-content-center py-3">
                {!! $orders->links() !!}
            </div>
            @if ($orders->count() <= config('custome.count_item'))
               <div class="col-12">
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
               </div>
            @endif
        </div>
    </div>
@endsection
