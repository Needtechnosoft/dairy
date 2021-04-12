@extends('admin.layouts.app')
@section('title','Purchase Invoice List')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Purchase Invoice List')
@section('toobar')
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 ">
        <label for="type">
            Report Duration
        </label>
        <select name="type" id="type" onchange="manageDisplay(this)" class="form-control show-tick ms">
            <option value="-1"></option>
            <option value="1">Daily</option>
            <option value="2">Weekly</option>
            <option value="3">Monthly</option>
            <option value="4">Yearly</option>
            <option value="5">Custom</option>
        </select>

    </div>
    <div class="col-md-3 ct ct-0 ct-2 ct-3 ct-4 d-none">
        <label for="date">Year</label>
        <select name="year" id="year" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-md-3 ct ct-0  ct-2 ct-3 d-none">
        <label for="date">Month</label>
        <select name="month" id="month" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-md-3 ct ct-2 d-none">
        <label for="week">Week</label>
        <select name="week" id="week" class="form-control show-tick ms select2">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="col-md-3 ct ct-0 d-none">
        <label for="date">Session</label>
        <select name="session" id="session" class="form-control show-tick ms select2">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
    </div>
    <div class="col-md-3 ct ct-1 ct-5 d-none">
        <label for="Date1">Date1</label>
        <input type="text" id="date1" class="form-control calender">
    </div>
    <div class="col-md-3 ct ct-5 d-none">
        <label for="Date1">Date2</label>
        <input type="text" id="date2" class="form-control calender">
    </div>


</div>
<div class="row mt-2">
    <div class="col-md-6">
        <span class="btn btn-primary" onclick="loadData()"> Load Report</span>
        <span class="btn btn-danger" onclick="$('#allData').html('');$('#type').val(-1);manageDisplay($('#type')[0])"> Reset</span>
    </div>

</div>
<div class="row">
    <div class="col-md-12 bg-light">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Date</th>
                    <Th>Gross Total</Th>
                    <th>Discount</th>
                    <th>Tax (%)</th>
                    <th>Net Total</th>
                    <Th>Paid</Th>
                    <th>Due</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="allData">
                @foreach ($invoices as $i)
                    <tr>
                        <td>{{$i->bill_no}}</td>
                        <td>{{ _nepalidate($i->date) }}</td>
                        <td>{{$i->gross_total}}</td>
                        <td>{{$i->discount}}</td>
                        <td>{{$i->tax}}</td>
                        <td>{{$i->net_total}}</td>
                        <td>{{$i->paid}}</td>
                        <td>{{ $i->due }}</td>
                        <td>
                            <a href="{{ route('purchase.invoice.item',$i->id)}}" class="btn btn-primary btn-sm">Invoice Items</a>
                            <a href="{{ route('purchase.expense',$i->id)}}" class="btn btn-primary btn-sm">Expenses</a>
                        </td>
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

            if($('#type').val()==-1){
                alert('Please Select Report Duration ');
                return;
            }

            var d={
                'year':$('#year').val(),
                'month':$('#month').val(),
                'week':$('#week').val(),
                'date1':$('#date1').val(),
                'date2': $('#date2').val(),
                'type':$('#type').val(),
            };
            axios.post("{{route('purchase.load')}}",d)
            .then(function(response){
                $('#allData').html(response.data);
            })
            .catch(function(error){
                alert('some error occured');
            });
        }

        window.onload = function() {

            var month = NepaliFunctions.GetCurrentBsDate().month;
            var year = NepaliFunctions.GetCurrentBsDate().year;
            var day =  NepaliFunctions.GetCurrentBsDate().day;

            $('#year').val(year).change();
            $('#month').val(month).change();

            $('.calender').each(function(){
                this.nepaliDatePicker();
                var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
                var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
                $(this).val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);
            });
        };



        function manageDisplay(element){
            type=$(element).val();
            $('.ct').addClass('d-none');
            $('.ct-'+type).removeClass('d-none');
        }
    </script>

@endsection
