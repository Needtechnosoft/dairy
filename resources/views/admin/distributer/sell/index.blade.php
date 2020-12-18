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
    <div class="col-md-3">
        <div class="pt-2 pb-2">
            <input type="text" id="sid" placeholder="Search" style="width: 134px;">
        </div>
        @include('admin.distributer.sell.minlist')
    </div>

    <div class="col-md-9 bg-light pt-2">
        <form action="" id="sellitemData">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input readonly type="text" name="date" id="nepali-datepicker" class="form-control next" data-next="user_id" placeholder="Date">
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label for="unumber">User Number</label>
                        <input type="number" name="user_id" id="u_id" placeholder="User number" class="form-control checkfarmer next  " data-next="item_id" min="1">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <!-- <input type="hidden" name=""> -->
                        <label for="unumber">Item Number
                            <span id="itemsearch"  data-toggle="modal" data-target="#itemmodal">( search (alt+s) )</span>
                        </label>
                        <input type="text" id="item_id" name="number" placeholder="Item number" class="form-control checkitem next " data-rate="rate" data-next="rate" min="1">
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="rate">Rate</label>
                    <input type="number" name="rate" onkeyup="calTotal(); paidTotal();" id="rate" step="0.001" value="0" placeholder="Item rate" class="form-control  next" data-next="qty" min="0.001">
                </div>

                <div class="col-md-3">
                    <label for="qty">Quantity</label>
                    <input type="number" onfocus="$(this).select();" name="qty" id="qty" onkeyup="calTotal(); paidTotal();" step="0.001" value="1" placeholder="Item quantity" class="form-control  next" data-next="paid" min="0.001">
                </div>

                <div class="col-md-3">
                    <label for="total">Total</label>
                    <input type="number" name="total" id="total" step="0.001" placeholder="Total" value="0" class="form-control next connectmax" data-connected="paid" data-next="paid" min="0.001" readonly>
                </div>

                <div class="col-md-3">
                    <label for="paid">Paid</label>
                    <input type="number" name="paid" onkeyup="paidTotal();" id="paid" step="0.001" placeholder="Paid" value="0" class="form-control next " data-next="due" min="0.001">
                </div>

                <div class="col-md-3">
                    <label for="due">Due</label>
                    <input type="number" name="due" id="due" step="0.001" placeholder="due" value="0" class="form-control next" data-next="save" min="0" readonly>
                </div>

                <div class="col-md-12 d-flex justify-content-end mt-3">
                    <input type="button" value="Save" class="btn btn-primary btn-block" onclick="saveData();" id="save">
                    {{-- <span class="btn btn-primary btn-block" >Save</span> --}}
                </div>

            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5">
                    <div class="pt-2 pb-2">
                        <input type="text" id="sellItemId" placeholder="Search" style="width: 200px;">
                    </div>
                    <table id="newstable1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User No.</th>
                                <th>Item Name</th>
                                <th>Rate</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="sellDataBody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- edit modal -->

@include('admin.sellitem.editmodal')
@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    // $( "#x" ).prop( "disabled", true );
    initTableSearch('sid', 'farmerData', ['name']);
    initTableSearch('isid', 'itemData', ['number']);
    initTableSearch('sellItemId', 'sellDataBody', ['id', 'item_number']);

    function initEdit(e) {
        var itemsell = JSON.parse(e.dataset.itemsell);
        console.log(itemsell);
        $('#enepali-datepicker').val(itemsell.date);
        $('#eu_id').val(itemsell.user.no);
        $('#eitem_id').val(itemsell.item.number);
        $('#erate').val(itemsell.rate);
        $('#eqty').val(itemsell.qty);
        $('#epaid').val(itemsell.paid);
        $('#etotal').val(itemsell.total);
        $('#edue').val(itemsell.due);
        $('#eid').val(itemsell.id);
        $('#editModal').modal('show');
    }

    function saveData() {
        if ($('#nepali-datepicker').val() == '' || $('#u_id').val() == '' || $('#item_id').val() == '' || $('#total').val() == 0) {
            alert('Please enter data in empty field !');
            $('#nepali-datepicker').focus();
            return false;
        } else {
            var bodyFormData = new FormData(document.getElementById('sellitemData'));
            axios({
                    method: 'post',
                    url: '{{ route("admin.sell.item.add")}}',
                    data: bodyFormData,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    console.log(response.data);
                    showNotification('bg-success', 'Sellitem added successfully !');
                    $('#sellDataBody').prepend(response.data);
                    $('#u_id').val('');
                    $('#item_id').val('');
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

    function udateData() {
        if ($('#enepali-datepicker').val() == '' || $('#eu_id').val() == '' || $('#eitem_id').val() == '' || $('#etotal').val() == 0) {
            alert('Please enter data in empty field !');
            $('#enepali-datepicker').focus();
            return false;
        } else {
            var rowid = $('#eid').val();
            var bodyFormData = new FormData(document.getElementById('editform'));
            axios({
                    method: 'post',
                    url: '{{ route("admin.sell.item.update")}}',
                    data: bodyFormData,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    console.log(response.data);
                    showNotification('bg-success', 'Sellitem updated successfully !');
                    $('#itemsell-'+rowid).replaceWith(response.data);
                    $('#u_id').val('');
                    $('#item_id').val('');
                    $('#rate').val('');
                    $('#qty').val(1);
                    $('#total').val(0);
                    $('#paid').val(0);
                    $('#due').val(0);
                    $('#editModal').modal('hide');
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
                    url: '/admin/sell-item-delete/' + id,
                })
                .then(function(response) {
                    showNotification('bg-danger', 'Sellitem deleted successfully!');
                    $('#itemsell-' + id).remove();
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

    function farmerId(id) {
        $('#u_id').val(id);
        $('#u_id').focus();
    }

    function itemId(id) {
        _number = document.querySelector('#item-' + id).dataset.number;
        $('#item_id').val(_number);
        $('#item_id').focus();
    }

    function loaddata(){
        // list
        axios.post('{{ route("admin.sell.item.list")}}',{'date': $('#nepali-datepicker').val()})
        .then(function(response) {
            // console.log(response.data);
            $('#sellDataBody').html(response.data);
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
        $('body').addClass('ls-toggle-menu');
        $('body').addClass('right_icon_toggle');
        $('#u_id').focus();
        loaddata();
    };


    $(document).bind('keydown', 'alt+s', function(e){
       $('#itemmodal').modal('show');
    });
    $('#item_id').bind('keydown', 'alt+s', function(e){
       $('#itemmodal').modal('show');
    });


</script>
@endsection
