@extends('admin.layouts.app')
@section('title','Farmer-Dues')
@section('css')
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Farmer Dues')
@section('toobar')
@endsection
@section('content')
<div class="row">
    <div class="col-md-3">
     @include('admin.farmer.minlist')
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <input type="text" id="u_no" class="form-control" placeholder="Enter farmer no.">
            </div>
            <div class="col-md-3">
                <span class="btn btn-primary" onclick="loadData()"> Load </span>
            </div>
            <div class="col-md-12">
                <div id="allData">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    function farmerId(id){
        $('#u_no').val(id);
    }

    function loadData(){
        var user_no = $('#u_no').val();
        axios({
                method: 'post',
                url: '{{ route("admin.farmer.due.load") }}',
                data: {'no':user_no}
        })
        .then(function(response) {
            $('#allData').html(response.data);
            var mainInput = document.getElementById("nepali-datepicker");
                mainInput.nepaliDatePicker();
                var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
                var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
                $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);
        })
        .catch(function(response) {
            //handle error
            // showNotification('bg-danger', 'Please enter farmer number!');
            console.log(response);
        });
    }

    window.onload = function(){
      loadData();
    }

// due payment
    function duePayment(){
        var date = $('#nepali-datepicker').val();
        var amt = $('#p_amt').val();
        var detail = $('#p_detail').val();
        var data = {
            'date':date,
            'pay':amt,
            'detail':detail
        }

        axios({
                method: 'post',
                url: '{{ route("admin.farmer.pay.save") }}',
                data: data
        })
        .then(function(response) {

        })
        .catch(function(response) {
            //handle error
            // showNotification('bg-danger', 'Please enter farmer number!');
            console.log(response);
        });

    }


</script>
@endsection
