@extends('admin.layouts.app')
@section('title','Purchase Expenses')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Purchase Expenses')
@section('toobar')
@endsection
@section('content')

<div class="row">
    <div class="col-md-12 bg-light">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Amount (Rs)</th>
                </tr>
            </thead>
            <tbody id="allData">
                @foreach ($expense as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
    <script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
@endsection
