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
        table th {
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <div class="container p-3">
        @if(count($orders) > config('custome.count_item'))
            <h2>{{ $title }}</h2>
            <table class="table table-striped table-order">
                <thead>
                    <tr>
                        <th>{{ trans('custome.user') }}</th>
                        <th class="text-capitalize">{{ trans('custome.order_code') }}</th>
                        <th class="text-capitalize">{{ trans('validation.attributes.status') }}</th>
                        <th class="text-capitalize">{{ trans('validation.attributes.created_at') }}</th>
                        <th class="text-capitalize">{{ trans('custome.total_price') }}</th>
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
                        </td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <div class="mb-0 text-capitalize">
                                <b class="text-primary"> {{ convertVnd($order->total_price) }}</b>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', ['id' => $order->id]) }}"
                               class="btn btn-primary">
                                {{ trans('custome.view') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <h1>{{ trans('custome.no_order_pending_week') }}</h1>
        @endif
    </div>
</body>
</html>
