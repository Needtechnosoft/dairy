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
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input readonly type="text" name="date" id="nepali-datepicker" class="form-control next" data-next="user_id" placeholder="Date">
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="unumber">Distributer</label>
                        <select name="user_id" id="u_id" class="form-control show-tick ms select2" data-placeholder="Select" required>
                            <option></option>
                            @foreach(\App\Models\Distributer::get() as $d)
                             <option value="{{ $d->id }}" id="opt-{{ $d->id }}" data-rate="{{ $d->rate }}" data-qty="{{ $d->amount }}">{{ $d->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="rate">Rate</label>
                    <input type="number" name="rate" onkeyup="calTotal(); paidTotal();" id="rate" step="0.001" value="0" placeholder="Item rate" class="form-control  next" data-next="qty" min="0.001">
                </div>

                <div class="col-md-2">
                    <label for="qty">Quantity</label>
                    <input type="number" onfocus="$(this).select();" name="qty" id="qty" onkeyup="calTotal(); paidTotal();" step="0.001" value="1" placeholder="Item quantity" class="form-control  next" data-next="paid" min="0.001">
                </div>

                <div class="col-md-3">
                    <label for="total">Total</label>
                    <input type="number" name="total" id="total" step="0.001" placeholder="Total" value="0" class="form-control next connectmax" data-connected="paid" data-next="paid" min="0.001" readonly>
                </div>

                <div class="col-md-3">
                    <label for="paid">Paid</label>
                    <input type="number" name="paid" onkeyup="paidTotal();" id="paid" step="0.001" placeholder="Paid" value="0" class="form-control next " data-next="save" min="0.001">
                </div>

                <div class="col-md-3">
                    <label for="due">Due</label>
                    <input type="number" name="due" id="due" step="0.001" placeholder="due" value="0" class="form-control" min="0" readonly>
                </div>

                <div class="col-md-3 mt-4">
                    <input type="button" value="Save" class="btn btn-primary btn-block" onclick="saveData();" id="save">
                    {{-- <span class="btn btn-primary btn-block" >Save</span> --}}
                </div>

            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5">
                    <div class="pt-2 pb-2">
                        <input type="text" id="sId" placeholder="Search" style="width: 200px;">
                    </div>
                    <table id="newstable1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Distributer</th>
                                <th>Rate</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="sellDisDataBody">

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


    function saveData() {
        if ($('#nepali-datepicker').val() == '' || $('#u_id').val() == '' || $('#total').val() == 0) {
            alert('Please enter data in empty field !');
            $('#u_id').focus();
            return false;
        } else {
            var bodyFormData = new FormData(document.getElementById('sellitemData'));
            axios({
                    method: 'post',
                    url: '{{ route("admin.dis.sell.add")}}',
                    data: bodyFormData,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    console.log(response.data);
                    showNotification('bg-success', 'Sellitem added successfully !');
                    $('#sellDisDataBody').prepend(response.data);
                    $('#u_id').val('');
                    $('#rate').val('');
                    $('#qty').val(1);
                    $('#total').val(0);
                    $('#paid').val(0);
                    $('#due').val(0);
                })
                .catch(function(response) {
                    showNotification('bg-danger', 'You have entered invalid data !');
                    //handle error
                    console.log(response);
                });
        }
    }

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
     var id = $(this).val();
     _rate = document.querySelector('#opt-'+id).dataset.rate;
     $('#rate').val(_rate);
     _qty = document.querySelector('#opt-'+id).dataset.qty;
     $('#qty').val(_qty);
     calTotal();
     $('#rate').focus();
     $('#rate').select();
   });

    function loaddata(){
        // list
        axios.post('{{ route("admin.dis.sell.list")}}',{'date': $('#nepali-datepicker').val()})
        .then(function(response) {
            // console.log(response.data);
            $('#sellDisDataBody').html(response.data);
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



</script>
@endsection
