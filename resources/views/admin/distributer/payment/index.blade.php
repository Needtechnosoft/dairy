@extends('admin.layouts.app')
@section('title','Distributer Sell')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Distributer Sell')
@section('toobar')

@endsection
@section('content')
<div class="row">
    <div class="col-md-12 bg-light pt-2">
        <form action="" id="sellitemData">
            @csrf
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="unumber">Distributor</label>
                        <select name="user_id" id="u_id" class="form-control show-tick ms " data-placeholder="Select" required>
                            <option value="-1"></option>
                            @foreach(\App\Models\Distributer::get() as $d)
                                <option value="{{ $d->id }}" id="opt-{{ $d->id }}" data-rate="{{ $d->rate }}" data-qty="{{ $d->amount }}">{{ $d->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mt-4">
                    <input type="button" value="Load" class="btn btn-primary btn-block" onclick="loaddata();" id="save">
                    {{-- <span class="btn btn-primary btn-block" >Save</span> --}}
                </div>

            </div>
        </form>

        <div class="col-md-3">
            <div class="form-group">
                <label for="date">Date</label>
                <input readonly type="text" name="date" id="nepali-datepicker" class="form-control next" data-next="user_id" placeholder="Date">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5">

                    <table id="newstable1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Rate</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>

                            </tr>
                        </thead>
                        <tbody id="data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->

@include('admin.distributer.sell.editmodal')
@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    // $( "#x" ).prop( "disabled", true );
    initTableSearch('sId', 'sellDisDataBody', ['name']);




    // delete

    function removeData(id) {
        if (confirm('Are you sure?')) {
            axios({
                    method: 'get',
                    url: '/admin/distributer-sell-del/' + id,
                })
                .then(function(response) {
                    showNotification('bg-danger', 'Sellitem deleted successfully!');
                    $('#sell-' + id).remove();
                })
                .catch(function(response) {
                    console.log(response)
                })
        }
    }


    function calTotal() {
        $('#total').val($('#rate').val() * $('#qty').val());
        $('#due').val($('#rate').val() * $('#qty').val());
        $('#etotal').val($('#erate').val() * $('#eqty').val());
        $('#edue').val($('#erate').val() * $('#eqty').val());
    }

    function paidTotal() {
        var total = parseFloat($('#total').val());
        var paid = parseFloat($('#paid').val());
        $('#due').val(total - paid);
        var etotal = parseFloat($('#etotal').val());
        var epaid = parseFloat($('#epaid').val());
        $('#edue').val(etotal - epaid);
    }


    $('#u_id').change(function() {
        if($(this).val()!=-1){
            loaddata();
        }
   });

    function loaddata(){
        // list
        axios.post('{{ route("admin.dis.due")}}',{'id': $('#u_id').val()})
        .then(function(response) {
            // console.log(response.data);
            $('#data').html(response.data);
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });
    }
    var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
    var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
    $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);

    window.onload = function() {
        var mainInput = document.getElementById("nepali-datepicker");
        mainInput.nepaliDatePicker();
        var edit = document.getElementById("enepali-datepicker");
        edit.nepaliDatePicker();
        $('#u_id').focus();
        loaddata();
    };


    $('#paid').bind('keydown', 'return', function(e){
        saveData();
    });

</script>
@endsection
