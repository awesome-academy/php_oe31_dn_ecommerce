@extends('admin.layouts.master')

@section('title', 'Admin')

@section('style')
    <link href="{{ asset('plugins/chart.js/dist/Chart.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div>
        <div class="box-canvasUserSta">
            <canvas id="canvasUserSta"></canvas>
        </div>
    </div>
@endsection
