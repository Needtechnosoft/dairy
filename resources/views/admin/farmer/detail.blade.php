@extends('admin.layouts.app')
@section('title','Farmer-Details')
@section('css')
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title')
    <a href="{{route('list.farmer')}}">Famers</a>/ Farmer Details - . {{$user->name}}
@endsection
@section('toobar')
@endsection
@section('content')
@php

@endphp
@include('admin.farmer.snippet.updatesnf')
@include('admin.farmer.snippet.updatemilkdata')
@include('admin.farmer.snippet.updatesell')
@include('admin.farmer.snippet.updateledger')

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
        <span class="btn btn-primary" onclick="printDiv('print')"> Print </span>
    </div>
</div>
<div id="allData">

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
        console.log(user);
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
            $('#allData').html(response.data);

            var edit = document.getElementById("closedate");
            if(edit!=undefined){
                edit.nepaliDatePicker();
            }
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

    function snfUpdated(data){
        loadData();
    }

    function snfDeleted(data){
        loadData();
    }
     function milkUpdated(data){
        loadData();
    }

    function milkDeleted(data){
        loadData();
    }
</script>
@endsection
