@extends('admin.layouts.app')
@section('title','Product Purchase')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Product Purchase')
@section('toobar')
@endsection
@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<div class="row">
    <div class="col-md-12 ">
        <form action="{{ route('purchase.store') }}" method="POST" id="milkData">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" name="date" id="nepali-datepicker" class="form-control next" data-next="center_id" placeholder="Date">
                    </div>
                </div>

                <input type="hidden" name="counter" id="counter" val=""/>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product">Suppliers</label>
                        <select id="supplier_id" name="supplier_id" class="form-control show-tick ms select2" data-placeholder="Select">
                            <option value="-1"></option>
                            @foreach(\App\Models\User::where('role',3)->get() as $s)
                              <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="reqireqty">Bill No.</label>
                        <input type="number"  step="0.01" min="1" name="billno" placeholder="Bill No." class="form-control next" data-next="qty" required>
                    </div>
                </div>

            </div>

            <div class="row mt-3" style="border: 1px #ccc solid; border-radius: 10px; padding:10px; margin:3px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="product">Purchase Items</label>
                            <select id="product" class="form-control show-tick ms select2" data-placeholder="Select">
                                <option value="-1"></option>
                                @foreach(\App\Models\Product::all() as $p)
                                <option  value='{{$p->toJson()}}'>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="from-group">
                            <label for="qty"> Quantity </label>
                            <input type="number" id="qty" onkeyup="singleItemTotal();" class="form-control next" data-next="rate" value="1" min="0" step="0.001">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="from-group">
                            <label for="rate"> Rate </label>
                            <input type="number" onkeyup="singleItemTotal();" class="form-control next" data-next="date" id="rate" value="0" min="0" step="0.001">
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="from-group">
                            <label for="rate"> Total </label>
                            <input type="number" class="form-control next" data-next="exp_date" id="total" value="0" min="0" step="0.001">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="expire">Expire Date</label>
                            <input type="date" class="form-control" id="exp_date">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <span class="btn btn-primary btn-block" style="margin-top:2rem;" onclick="addItems();">Add</span>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5">
                        <table id="newstable1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                    <th>Expire Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="itemBody">

                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="tot">Total</label>
                                <input type="number" name="gtotal" readonly id="itotal" value="0">
                            </div>

                            <div class="col-lg-3">
                                <label for="dis">Discount</label>
                                <input type="number" min="0" id="_discount" step="0.01" onkeyup="_calExtra();" name="discount" value="0" >
                            </div>

                            <div class="col-lg-3">
                                <label for="taxable">Taxable</label>
                                <input type="number" min="0" id="_taxable" step="0.01" name="taxable" value="0" readonly>
                            </div>

                            <div class="col-lg-3">
                                <label for="tax">Tax</label>
                                <input type="number" min="0" id="_tax" step="0.01" onkeyup="_calExtra();" name="tax" value="0">
                            </div>

                            <div class="col-lg-3 mt-2">
                                <label for="net">Net Total</label>
                                <input type="number" min="0" id="_nettotal" step="0.01" name="nettotal" value="0" readonly>
                            </div>

                            <div class="col-lg-3 mt-2">
                                <label for="pay">Payment</label>
                                <input type="number" min="0" onkeyup="_calExtra();" step="0.01" id="_payment" name="payment" value="0">
                            </div>

                            <div class="col-lg-3 mt-2">
                                <label for="due">Due</label>
                                <input type="number" min="0" class="" id="_due" name="due" step="0.01" value="0">
                            </div>

                            <div class="col-lg-3" style="margin-top:36px;">
                                <input type="checkbox" name="exp_status" onclick="
                                if(this.checked){
                                    $('#exp_field').addClass('d-block');
                                    $('#exp_field').removeClass('d-none');
                                }else{
                                    $('#exp_field').addClass('d-none');
                                    $('#exp_field').removeClass('d-block');
                                }
                                "> Show Expense Field
                            </div>

                            <div class="col-lg-12 d-none" id="exp_field" style="border: 1px #ccc solid; margin:10px; padding:10px; border-radius: 10px;">
                                <h5>Purchase Expenses</h5>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="title">Expense Title</label>
                                            <input type="text" id="exp_title"  class="form-control">
                                        </div>
                                    </div>
                                    <input type="hidden" id="exp_counter" name="exp_counter">
                                    <div class="col-lg-4">
                                        <label for="amt">Amount</label>
                                        <input type="number" min="0" value="0" step="0.01"  id="exp_amount" class="form-control">
                                    </div>
                                    <div class="col-lg-2">
                                        <span class="btn btn-primary" style="margin-top:33px;" onclick="addExp();">Add</span>
                                    </div>
                                </div>
                                <hr>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                       <tbody id="expbody">

                                       </tbody>
                                       <tr>
                                           <td class="text-right"><strong> Total </strong></td>
                                           <td colspan="2" id="exp_total">
                                             {{-- <input type="number" id="exp_total" value="0" readonly> --}}
                                           </td>
                                       </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-primary btn-block">Save Items</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
    <script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
    <script>
        var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
        var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
        $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);

    window.onload = function() {
        var mainInput = document.getElementById("nepali-datepicker");
        mainInput.nepaliDatePicker();
    };

    function singleItemTotal() {
        $('#total').val($('#rate').val() * $('#qty').val());
    }

    var i = 0;
    var itemKeys = [];

    function addItems() {
        if ($('#product').val() == -1 || $('#qty').val() == 0 || $('#rate').val() == 0 || $('#supplier_id').val() == -1 || $('#exp_date').val()=="") {
            alert('Please fill the above related field');
            $("#product").focus();
            return false;
        }
        product=JSON.parse($('#product').val());
        // console.log(product);
        html = "<tr id='row-" + i + "'>";
        html += "<td>" + product.name + "<input type='hidden' name='productid_" + i + "' value='" + product.id + "' /><input type='hidden' name='productname_" + i + "' value='" + product.name + "' /></td>";
        html += "<td>" + $('#qty').val() + "<input type='hidden' name='qty_" + i + "' value='" + $('#qty').val() + "'/></td>";
        html += "<td>" + $('#rate').val() + "<input type='hidden' name='rate_" + i + "' value='" + $('#rate').val() + "'/></td>";
        html += "<td>" + $('#total').val() + "<input type='hidden' name='total_" + i + "' id='total_" + i + "'  value='" + $('#total').val() + "'/></td>";
        html += "<td>"+$('#exp_date').val()+ "<input type='hidden' name='exp_date_"+ i +"' value='"+ $('#exp_date').val() +"'/> </td>";
        html += "<td> <span class='btn btn-danger btn-sm' onclick='RemoveItem(" + i + ");'>Remove</span></td>";
        html += "</tr>";
        $("#itemBody").append(html);
        $('#product').val(-1).change();
        $('#rate').val('0');
        $('#qty').val('0');
        $('#product').focus();
        $('#total').val(0);
        $('#exp_date').val("");
        itemKeys.push(i);
        i+= 1;
        suffle();
    }

    function suffle(){
        $("#counter").val(itemKeys.join(","));
        calculateTotal();
    }

    function RemoveItem(e){
        $('#row-'+e).remove();
        var index=$.inArray(e,itemKeys);
            if(index>-1){
                itemKeys.splice(index,1);
            }
            suffle();
    }

    function calculateTotal() {
        var itotal = 0;
        for (let index = 0; index < itemKeys.length; index++) {
            const element = itemKeys[index];
            itotal += parseInt($("#total_" + element).val());;
        }
        $('#itotal').val(itotal);
        $('#_taxable').val(itotal);
        $('#_due').val(itotal);
        $('#_nettotal').val(itotal);
    }

    function _calExtra(){
        var dis = parseFloat($('#_discount').val());
        var tot = parseFloat($('#itotal').val());
        $('#_due').val(tot-dis);
        $('#_taxable').val(tot-dis);
        $('#_nettotal').val(tot-dis);

        var taxable = parseFloat($('#_taxable').val());
        var tax = parseFloat($('#_tax').val());
        if(tax>0){
            var tax_amount = (taxable * tax)/100;
            var net_total = taxable + tax_amount;
            $('#_nettotal').val(net_total);
            $('#_due').val(net_total);
        }
        var pay = parseFloat($('#_payment').val());
        var _net = parseFloat($('#_nettotal').val());
        if(pay>0){
            $('#_due').val(_net-pay);
        }
    }


    // purchase invoice extra expenses
    var j = 0;
    var expKey = [];
    function addExp(){
        if($('#exp_title').val()=="" || $('#exp_amount').val() == 0){
            alert('Please empty fields !');
            $("#exp_title").focus();
            return false;
        }
        html = "<tr id='exprow-" + j + "'>";
        html += "<td>"+$('#exp_title').val()+"</td> <input type='hidden' name='exp_title_"+j+"' value='"+$('#exp_title').val()+"'>";
        html += "<td>"+$('#exp_amount').val()+"</td> <input type='hidden' id='exp_amount_"+j+"' name='exp_amount_"+j+"' value='"+$('#exp_amount').val()+"'> ";
        html += "<td><span class='btn btn-danger btn-sm' onclick='removeExp(" + j + ");'>Remove</span></td>";
        $('#expbody').append(html);
        $('#exp_title').val("");
        $('#exp_amount').val(0);
        expKey.push(j);
        j+= 1;
        counterTraker();
    }

    function removeExp(e){
        $('#exprow-'+e).remove();
        var index=$.inArray(e,expKey);
            if(index>-1){
                expKey.splice(index,1);
            }
            counterTraker();
    }

    function counterTraker(){
        $("#exp_counter").val(expKey.join(","));
        calExp();
    }

    function calExp(){
        var exptotal = 0;
        for (let index = 0; index < expKey.length; index++) {
            const element = expKey[index];
            exptotal += parseInt($("#exp_amount_" + element).val());
        }
        $('#exp_total').text(exptotal);
    }


    </script>
@endsection
