@extends('admin.layouts.app')
@section('title','Product Batch Manage')
@section('head-title','Product Batch Manage')

@section('content')
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search">
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Name</th>
                <th>Purchase Date</th>
                <th>Expire Date</th>
                <th>Batch Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($batchItem as $k => $item)

            @if ($item->expireAlert() == true)
            <tr style="background: red;color:white;">
                <td>{{ $k+1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ _nepalidate($item->date) }}</td>
                <td>{{ $item->expire_date }}</td>
                <td>{{ $item->qty }}</td>
            </tr>
            @else
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ _nepalidate($item->date) }}</td>
                    <td>{{ $item->expire_date }}</td>
                    <td>{{ $item->qty }}</td>
                </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>




@endsection
@section('js')

@endsection
