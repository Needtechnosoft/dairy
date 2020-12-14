@extends('admin.layouts.app')
@section('title','Dashboard')
@section('head-title','Dashboard')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/css/local.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-2 section href" data-target="{{route('admin.farmer')}}">
            <span class="icon">
                <i class="zmdi zmdi-accounts"></i>
            </span>
            <span class="divider"></span>
            <span class="text">
                Farmers
            </span>
        </div>
    </div>
@endsection
