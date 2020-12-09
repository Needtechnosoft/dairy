<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

@extends('layouts.back.index')
@section('title',"Supplier Bill")
@section('brand',"Supplier Bill Add")
@section('content')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card stacked-form">
                                <div class="card-header text-center ">
                                    <h4 class="card-title">Supplier Bill Add</h4>
                                </div>
                                <div class="card-body ">
                                    <form method="post" action="">
                                        @csrf

                                         <div class="form-group">
                                                    <label for="name">Supplier Name</label>

                                                    <select id="" name="supplier_id" class="selectpicker form-control" data-live-search="true"  data-hide-disabled="true"
                                                    onchange="
                                                        loadCustomerData($(this).val());
                                                    ">
                                                      <option value="0">--- Choose Supplier ---</option>
                                                        @foreach($suppliers as $supp)
                                                          <option  data-tokens="{{$supp->name}}"  value="{{$supp->id}}">{{$supp->name}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>


                                         <div class="form-group">
                                            <label>Date</label>
                                            <input id="nepali-calendar" name="date" type="text" placeholder="Enter date" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Particular</label>
                                            <input name="particular" id="ptr" type="text" placeholder="Enter Ptr content" class="form-control" >
                                        </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Rate</label>
                                                            <input onkeyup="CalTotal();" id="rate" name="rate" type="number"   class="form-control" value="0"  required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                            <label>Quantity </label>
                                                            <input onkeyup="CalTotal();" id="qty" type="number" name="qty"  class="form-control" value="1"  required>
                                                    </div>

                                                    <div class="col-md-3">
                                                            <label>Total </label>
                                                            <input id="total" type="number" name="total"  class="form-control" value="0"  required>
                                                    </div>
                                                    <div class="col-md-3" style="margin-top:1.5rem;">
                                                         <span class="btn btn-primary" onclick="addBill();return false;">Add Item</span>
                                                    </div>
                                                </div>
                                                <hr>
                                                  {{-- ItemsCounter --}}
                                                      <input type="hidden" name="counter" id="counter" val=""/>
                                                    {{-- /ItemsCounter --}}
                                                <table class="table table-bordered" id="item_table">
                                                <tr>
                                                    <th>Particular</th>
                                                    <th>Rate</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                    <th>Action </th>
                                                </tr>

                                                <table>
                                                <div style="margin-left:40.4rem;">
                                                   Item Grand Total
                                                   <input style="width:350px;" type="text" id="gtotal" class="form-control" value="0" disabled/>
                                                </div>
                                        <hr>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Grand Total*</label>
                                                            <input name="total_amount" onkeyup="calculateTotal()" id="grandtotal" type="number" value="0"   class="form-control"  required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Discount</label>
                                                            <input name="discount" onkeyup="calculateTotal()" id="discount" type="number" value="0"   class="form-control"  required>
                                                        </div>
                                                    </div>

                                                     <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Taxable Amount*</label>
                                                            <input name="" id="taxable" type="number" value="0"   class="form-control"  required>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="row">
                                                    <div class="col-md-4">
                                                            <label class="text-danger">Vat* Amount </label>
                                                            <input type="number" onkeyup="calculateTotal()" id="vat" value="0" name="vat"  class="form-control"  required>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <label>Paid Amount </label>
                                                            <input type="number" onkeyup="calculateTotal()" id="paid" name="paid"  class="form-control" value="0" required>
                                                    </div>
                                                    <div class="col-md-4" >
                                                        <label>Due Amount </label>
                                                        <input type="number" id="due" name="due" value="0"  class="form-control"  required>
                                                    </div>
                                                </div>



                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-md btn-block">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                     </div>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script>
        var i=0;
        var uniqueItemKeys=[];
          $(function() {
            $('.selectpicker').selectpicker();
        });

        function CalTotal(){
            $('#total').val($('#rate').val() * $('#qty').val());
        }
        function addBill(){
            if($('#ptr').val()=="" || $('#total').val()==0){
                alert('Please fill the above related field');
                  $("#ptr").focus();
                return false;
            }
            html="<tr id='row-"+i+"'>";
            html+="<td>"+$('#ptr').val()+"<input type='hidden' name='ptr_"+i+"' value='"+$('#ptr').val()+"' /></td>";
            html+="<td>"+$('#rate').val()+"<input type='hidden' name='rate_"+i+"' value='"+$('#rate').val()+"'/></td>";
            html+="<td>"+$('#qty').val()+"<input type='hidden' name='qty_"+i+"' value='"+$('#qty').val()+"'/></td>";
            html+="<td>"+$('#total').val()+"<input type='hidden' name='total_"+i+"' id='total_"+i+"' value='"+$('#total').val()+"'/></td>";
            html+="<td> <span class='btn btn-danger btn-sm' onclick='RemoveItem("+i+")'>Remove</span></td>";
            html+="</tr>";
            $("#item_table").append(html);
            $('#ptr').val('');
            $('#rate').val('0');
            $('#qty').val('1');
            $('#total').val('0');
             uniqueItemKeys.push(i);
            i+=1;
            suffle();
        }

         function suffle(){
            console.log(uniqueItemKeys);
            $("#counter").val(uniqueItemKeys.join(","));
            calculateTotal();
        }

        function calculateTotal(){
           var gtotal = 0;
            for (let index = 0; index < uniqueItemKeys.length; index++) {
                const element = uniqueItemKeys[index];
               gtotal+= parseInt($("#total_"+element).val());
            }
            $('#gtotal').val(gtotal);
            var total = parseInt($('#grandtotal').val());
            var vat = parseInt($('#vat').val());
            var discount = parseInt($("#discount").val());
            var paid = parseInt($("#paid").val());
            if(discount>0){
                var withdiscount = total - discount;
                $('#taxable').val(withdiscount);
                if(vat>0){
                    var withvat = withdiscount + vat;
                    if(paid>0){
                        var withpaid = withvat - paid;
                        $('#due').val(withpaid);
                    }else{
                    $('#due').val(withvat);
                    }
                }else{
                     if(paid>0){
                         var withpaid = withdiscount - paid;
                         $('#due').val(withpaid);
                     }else{
                     $('#due').val(withdiscount);
                     }
                }
            }else{
                 $('#taxable').val(total);
                 if(vat>0){
                     var withvat = total + vat;
                     if(paid>0){
                         var withpaid = withvat - paid;
                         $('#due').val(withpaid);
                     }else{
                     $('#due').val(withvat);
                     }
                 }else{
                     if(paid>0){
                         var withpaid = total - paid;
                       $('#due').val(withpaid);
                     }else{
                       $('#due').val(total);
                     }
                 }
            }
        }


        function RemoveItem(i){
            $('#row-'+i).remove();
             var index=$.inArray(i,uniqueItemKeys);
            if(index>-1){
                uniqueItemKeys.splice(index,1);
            }
            suffle();
        }

        $(document).ready(function () {
            $('#nepali-calendar').nepaliDatePicker();
        });

    </script>
@endsection