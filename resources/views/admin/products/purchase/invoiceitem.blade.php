@extends('admin.layouts.app')
@section('title','Purchase Invoice Item List')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Purchase Invoice Item List')
@section('toobar')
@endsection
@section('content')

<div class="row">
    <div class="col-md-12 bg-light">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Rate</th>
                    <Th>Qty</Th>
                    <th>Expire date</th>
                    <th>Old Stock</th>

                </tr>
            </thead>
            <tbody id="allData">
                @foreach ($items as $item)
                    <tr>
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->rate}}</td>
                        <td>{{$item->qty}}</td>
                        <td>{{$item->expire_date}}</td>
                        <td>{{$item->old_stock}}</td>
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
