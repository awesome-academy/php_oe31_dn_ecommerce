<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .container {
            padding: 15px;
        }
        .badge-primary, .badge-secondary, .badge-success {
            color: #fff;
            display: inline-block;
            padding: 12px;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }
        .badge-primary {
            background-color: #007bff;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-secondary {
            background-color: #6c757d;
        }
        table th, .text-capitalize {
            text-transform: capitalize;
        }
        img {
            width: 150px;
            height: 150px;
        }
        .text-center {
            text-align: center;
        }
        tr td {
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
</head>
<body>
<div class="container p-3">
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <div class="my-2">
                    <h1 class="text-center"><b>{{ $title }}</b></h1>
                    <hr>
                    <p>
                        {{ trans('custome.order_code') . ": " }}
                        <b>{{ $order->order_code }}</b>
                    </p>
                    <div class="info-shipment">
                        <p class="mb-0">
                            <span class="text-capitalize">{{ trans('validation.attributes.status') }}:</span>
                            @switch($order->status)
                                @case(\App\Models\Order::SUCCESS)
                                    <span class="badge badge-success p-2">
                                        {{ trans('custome.status_success') }}
                                    </span>
                                @break

                                @case(\App\Models\Order::CANCEL)
                                    <span class="badge badge-secondary p-2">
                                        {{ trans('custome.status_cancel') }}
                                    </span>
                                @break

                                @case(\App\Models\Order::PENDING)
                                    <span class="badge badge-primary p-2">
                                        {{ trans('custome.status_pending') }}
                                    </span>
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
                <table class="table table-striped table-order">
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
                                    <b>{{ convertVnd($detail->product->price) }}</b>
                                @endif
                            </td>
                            @if ($detail->product->sale_price != null)
                                <td>
                                    <b>{{ convertVnd($detail->product->sale_price) }}</b>
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
                    <span class="text-capitalize">{{ trans('custome.total_price') . ":" }}</span>
                    <b class="text-primary text-capitalize"> {{ convertVnd($order->total_price) }}</b>
                </div>
                <hr>
                <div class="my-2 info-shipment">
                    <h2>{{ trans('custome.shipment_detail') }}</h2>
                    <p>
                        <b class="text-capitalize">{{ trans('validation.attributes.name') }}</b>:
                        {{ $order->order_infors->name }}
                    </p>
                    <p>
                        <b class="text-capitalize">{{ trans('validation.attributes.address') }}</b>:
                        {{ $order->order_infors->address }}
                    </p>
                    <p>
                        <b class="text-capitalize">{{ trans('validation.attributes.city') }}</b>:
                        {{ $order->order_infors->city->name }}
                    </p>
                    <p>
                        <b class="text-capitalize">{{ trans('validation.attributes.phone') }}</b>:
                        {{ $order->order_infors->phone }}
                    </p>
                    <p>
                        <b class="text-capitalize">{{ trans('validation.attributes.email') }}</b>:
                        {{ $order->order_infors->email }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
