@extends('admin.layouts.app')
@section('title','Farmer-Details')
@section('css')
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Farmer Details')
@section('toobar')
@endsection
@section('content')
<div class="row">
    <div class="col-md-3">
        <select name="year" id="year" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-md-3">
        <select name="month" id="month" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-md-3">
        <select name="session" id="session" class="form-control show-tick ms select2">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
    </div>
    <div class="col-md-3">
        <span class="btn btn-primary" onclick="loadData()"> Load </span>
    </div>
</div>
<div class="row mt-5">
    <div class="col-md-6">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Milk Data</strong>
            <hr>
        </div>
    </div>
    <div class="col-md-6">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Snf & Fats</strong>
            <hr>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Selling Items</strong>
            <hr>
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <tr>
                    <th>Item Name</th>
                    <th>Item Number</th>
                    <th>Rate</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                </tr>
                @php
                    $total = 0;
                    $paid = 0;
                    $due = 0;
                @endphp
                   <tbody id="sellItemData">

                   </tbody>
                    <tr>
                        <td colspan="6" class="text-right">Grand Total</td>
                        <td colspan="7">{{ $total }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Total Paid</td>
                        <td colspan="7">{{ $paid }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Total Due</td>
                        <td colspan="7">{{ $due }}</td>
                    </tr>
            </table>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    var month = Array.from(NepaliFunctions.GetBsMonths());
    var i =1;
    month.forEach(element => {
        $('#month').append('<option value="'+i+'">'+element+'</option>');
        i++;
    });

    var start_y = 2070;
    var now_yr = NepaliFunctions.GetCurrentBsYear();
    var now_yr1 = now_yr;
    for (let index = start_y; index < now_yr; index++) {
        $('#year').append('<option value="'+now_yr1+'">'+now_yr1+'</option>');
        now_yr1--;
    }



    function loadData(){
        var user = {{ $user->id }};
        var data={
            'user_id':user,
            'year':$('#year').val(),
            'month':$('#month').val(),
            'session':$('#session').val(),
        };
        axios({
                method: 'post',
                url: '{{ route("farmer.loaddetail") }}',
                data:data ,
        })
        .then(function(response) {
            // console.log(response.data);
            response.data.sellitem.forEach(ele => {
                var html = '<tr><td>'+ele.title+'</td>';
                    html+= '<td>'+ele.number+'</td>';
                    html+= '<td>'+ele.rate+'</td>';
                    html+= '<td>'+ele.qty+'</td>';
                    html+= '<td>'+ele.total+'</td>';
                    html+= '<td>'+ele.paid+'</td>';
                    html+= '<td>'+ele.due+'</td></tr>';
                    $('#sellItemData').append(html);
            });
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });
    }

    window.onload = function() {

        var month = NepaliFunctions.GetCurrentBsDate().month;
        var year = NepaliFunctions.GetCurrentBsDate().year;
        var day =  NepaliFunctions.GetCurrentBsDate().day;

        $('#year').val(year).change();
        $('#month').val(month).change();
        if(day>15){
            $('#session').val(2).change();
        }else{
            $('#session').val(1).change();
        }
        loadData();
    };

</script>
@endsection
