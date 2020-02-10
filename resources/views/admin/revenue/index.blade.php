@extends('admin.layouts.master')

@section('title', trans('custome.revenue'))

@section('meta-header')
    <meta name="requiredSelectYear" content="{{ trans('custome.required_select_year') }}">
    <meta name="noRevenue" content="{{ trans('custome.no_revenue') }}">
@endsection

@section('style')
    <link href="{{ asset('plugins/chart.js/dist/Chart.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="py-3">
        <div class="px-3">
            <div class="d-flex">
                <div class="form-group d-flex mb-0 mr-2 align-items-center">
                    <label for="revenue-year" class="mb-0 text-capitalize align-middle mr-2">
                        {{ trans('validation.attributes.year') }}
                    </label>
                    <select id="revenue-year" class="form-control w-auto">
                        <option></option>
                        @foreach($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group d-flex mb-0 mr-2 align-items-center">
                    <label for="revenue-month" class="mb-0 text-capitalize align-middle mr-2">
                        {{ trans('validation.attributes.month') }}
                    </label>
                    <select id="revenue-month" class="form-control w-auto">
                        <option></option>
                        @foreach(config('custome.months') as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <button id="filter-revenue" class="btn btn-primary">{{ trans('custome.filter') }}</button>
            </div>
        </div>
        <div class="box-canvasRevenueCurrentMonth">
            <canvas id="canvasRevenueCurrentMonth"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/admin/admin_revenue.js') }}"></script>
@endsection
