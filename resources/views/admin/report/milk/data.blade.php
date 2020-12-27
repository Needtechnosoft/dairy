@extends('admin.layouts.app')
@section('title','Report')
@section('css')
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Report - Milk')
@section('toobar')

@endsection
@section('content')
    <style>
        td,th{
            border:1px solid black;
        }
        table{
            width:100%;
            border-collapse: collapse;
        }
        thead {display: table-header-group;}
        tfoot {display: table-header-group;}
    </style>
@endsection
