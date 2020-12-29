@extends('admin.layouts.app')
@section('title','Report')
@section('css')

@endsection
@section('head-title','Report')
@section('toobar')

@endsection
@section('content')
<div class="row">
    <div class="col-md-2 section href" data-target="{{route('report.farmer')}}">
        <span class="icon">
            <i class="zmdi zmdi-accounts"></i>
        </span>
        <span class="divider"></span>
        <span class="text">
            Farmer Report
        </span>
    </div>
    <div class="col-md-2 section href" data-target="{{route('report.milk')}}">
        <span class="icon">
            <i class="zmdi zmdi-view-agenda"></i>
        </span>
        <span class="divider"></span>
        <span class="text">
            Milk Report
        </span>
    </div>
    <div class="col-md-2 section href" data-target="{{route('report.sales')}}">
        <span class="icon">
            <i class="zmdi zmdi-money-box"></i>
        </span>
        <span class="divider"></span>
        <span class="text">
            Sales Report
        </span>
    </div>
    <div class="col-md-2 section href" data-target="{{route('report.dis')}}">
        <span class="icon">
            <i class="zmdi zmdi-truck"></i>
        </span>
        <span class="divider"></span>
        <span class="text">
            Distributor Report
        </span>
    </div>
</div>
@endsection
@section('js')

@endsection