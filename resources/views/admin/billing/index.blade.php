@extends('admin.billing.layout.app')
@section('content')
    <style>
        .prodtable,.prodtable td,.prodtable th {
            border: 1px solid black;
        }
        .btn-max{
            border:1px white solid;
            background: #0000C0;
            color:white;
            text-align: center;
            outline: transparent;
            width:100%;
            padding-top:10px;
            height:100%;
        }

        .prodtable {
        width: 100%;
        border-collapse: collapse;
        }
        .prodviwer{
            position:fixed;top:0;bottom:0;right:0px;
            width:40vw;
            display:none;
            background:white;
            padding:15px;
            box-shadow:0px 0px 5px 1px black;
        }
        .prodviwer.active{
            display:block !important;
        }
        .form-control1{
            background:transparent;
            outline:none !important;
            color:white;
            border:1px solid white !important;
            padding:0 5px;
            width:100%;
        }
        .form-control2{
            background:transparent;
            outline:none !important;
            color:white;
            border:none!important;
            padding:0 5px;
            width:100%;
        }
        .toast-error{
            background:rgb(173, 14, 14);
            opacity: 1 !important;
        }
        /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
    </style>
    @include('admin.billing.products')
    <div style="display:flex;flex-direction: column;height:100vh;">
        <div style="background: #355F79;">
            <div class="container py-2">
                <div style="display:flex;justify-content: space-between;">
                    <span>
                        <h3 style="color:White;">
                            {{env('APP_NAME')}}
                        </h3>
                    </span>
                    <span>
                        <h3 >
                            <a style="color:White;" href="{{route('admin.dashboard')}}">Home</a>
                        </h3>
                    </span>
                </div>
            </div>
        </div>
        <div  style="flex-grow: 1;border:1px #505050 solid;overflow:scroll;">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            #ID
                        </th>
                        <th>
                            Item
                        </th>
                        <th>
                            Rate
                        </th>
                        <th>
                            Qty
                        </th>
                        <th>
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody id="billitemholder">

                </tbody>

            </table>
        </div>

        <div style="padding:15px;">
            <div class="row">
                <div class="col-md-2">
                    <label for="item">Item (F1)</label>
                    <input type="text" id="item" class="form-control next" data-next="rate">
                </div>
                <div class="col-md-2">
                    <label for="item">Rate</label>
                    <input type="number" min="0" step="0.01" id="rate" class="form-control next" data-next="qty" >
                </div>
                <div class="col-md-2">
                    <label for="item">Qty</label>
                    <input type="number" oninput="calculateTotal(this);" min="0" step="0.01" id="qty" class="form-control next" data-next="total" >
                </div>
                <div class="col-md-2">
                    <label for="item">Total</label>
                    <input type="number" min="0" step="0.01" id="total" class="form-control"  >
                </div>
            </div>
        </div>
        <div style="background:#365F78;display:flex;padding:0px 25px;font-size: 1.2rem;font-weight:600;">
            <div style="flex:4;border-right:1px white solid;display:flex;">
                <div style="flex:3; padding:15px 0px;">
                    <table class="w-100" >
                        <tr>
                            <td>
                                <div class="text-white text-right" >
                                    Gross Total:
                                </div>
                            </td>
                            <td>
                                <input type="number" value="0" step="0.01" min="0" id="grosstotal" class="form-control1" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="text-white text-right" >
                                    Discount(F2):
                                </div>
                            </td>
                            <td>
                                <input type="number" oninput="calculateAll()" value="0"  step="0.01" min="0" id="discount" class="form-control1">
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="flex:4;display:flex;height:100%;text-align:center;">
                    <div style="background:#2A9CDA;height:100%;padding-top:20px;color:white;flex:1">
                        <div>Net Total</div>
                        <input type="number" value="0"  step="0.01" min="0" id="nettotal" class="form-control2 text-center" readonly>
                    </div>
                    <div style="background:transparent;height:100%;padding:15px 0;color:white;flex:2">
                        <table class="w-100" >
                            <tr>
                                <td>
                                    <div class="text-white text-right" >
                                       Paid(F3):
                                    </div>
                                </td>
                                <td>
                                    <input type="number" value="0" step="0.01" min="0" id="paid" class="form-control1"  oninput="calculateAll()">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="text-white text-right" >
                                        Return:
                                    </div>
                                </td>
                                <td>
                                    <input type="number" value="0"  step="0.01" min="0" id="return" class="form-control1" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="text-white text-right" >
                                       Due:
                                    </div>
                                </td>
                                <td>
                                    <input type="number" value="0"  step="0.01" min="0" id="due" class="form-control1" readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div style="flex:1;display:flex;flex-direction: column;">
                <div style="flex:1;display:flex;">
                        <div style="flex:1;">
                            <button class="btn-max" onclick="saveBill()">a</button>
                        </div>
                        <div style="flex:1;">
                            <button class="btn-max">a</button>
                        </div>

                </div>
                <div style="flex:1;display:flex">
                    <div style="flex:1;">
                        <button class="btn-max">a</button>
                    </div>
                    <div style="flex:1;">
                        <button class="btn-max">a</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/template">

    </style>
@endsection
@section('scripts')
    <script>
        toastr.options.progressBar = true;
        var i=0;
        $('#item').focusin(function(){
            $('.prodviwer').addClass('active');
        });
        $('#item').focusout(function(){
            $('.prodviwer').removeClass('active');
            var id=this.value;
            if(id!=''){
                if(!exists('#prod_'+id)){
                    toastr.error('Cannot Find Item No - '+id,'{{env('APP_NAME')}}', {timeOut: 1000});
                    $('#item').focus();
                    $('#item').val('');
                }else{
                    console.log($('#prod_'+id).data('product'));
                    var data= $('#prod_'+id).data('product');
                    $('#rate').val(data.price);

                }
            }
        });


        function calculateTotal(ele){
            if(ele.value!=''){
                var qty=ele.value;
                var rate=$('#rate').val();
                $('#total').val(qty*rate);
            }
        }

        function calculateAll(){
            var gross=0;
            $('.billitems').each(function(){
                bdata=JSON.parse(this.value);
                console.log(JSON.parse(this.value));
                gross+=parseFloat( bdata.total);
            });
            $('#grosstotal').val(gross);
            var dis=parseFloat($('#discount').val());
            if(dis>gross){
                dis=gross;
                $('#discount').val(gross)
            }
            var net=gross-dis;
            $('#nettotal').val(net);
            var paid=parseFloat($('#paid').val());
            final=paid-net;
            if(final<0){
                $('#return').val(0);
                $('#due').val((-1*final));
            }else{
                $('#return').val(final);
                $('#due').val(0);
            }

        }

        function addToBill(){
            i+=1;
            var id=$('#item').val();
            if(!exists('#prod_'+id)){
                    toastr.error('Cannot Find Item No - '+id,'{{env('APP_NAME')}}', {timeOut: 1000});
                    $('#item').focus();
                    $('#item').val('');
                    return;
            }

            var data= $('#prod_'+id).data('product');
            var billitem={
                id:id,
                name:data.name,
                rate:$("#rate").val(),
                qty:$("#qty").val(),
                total:$("#total").val(),
            };

            if(billitem.qty=='' || billitem.qty<=0){
                toastr.error('Please Enter Quantity','{{env('APP_NAME')}}', {timeOut: 1000});
                return;

            }

            if(billitem.rate=='' || billitem.rate<=0){
                toastr.error('Please Enter Rate','{{env('APP_NAME')}}', {timeOut: 1000});
                return;

            }
            if(billitem.total=='' || billitem.total<=0){
                toastr.error('Please Enter Total','{{env('APP_NAME')}}', {timeOut: 1000});
                return;

            }

            datastr=JSON.stringify(billitem)
            str="<tr id='row-"+i+"'> <td><input class='billitems' type='hidden' name='billitems[]' value='"+datastr+"'/> "+billitem.id+"</td><td>"+billitem.name+"</td><td>"+billitem.rate+"</td><td>"+billitem.qty+"</td><td>"+billitem.total+"</td></tr>"
            console.log(billitem);
            $('#billitemholder').append(str);
            $('#item').val('');
            $('#rate').val('');
            $('#qty').val('');
            $('#total').val('');
            $('#item').focus();
            calculateAll();
        }


        $('#total').bind('keydown', 'return', function(e){
            if(this.value!=''&& this.value!=0 ){
                addToBill();
            }
        });

        $('body,.form-control1, .form-control').bind('keydown', 'f1', function(e){
            e.preventDefault();
            $('#item').focus();
            $('#item').select();
        });
        $('body,.form-control1, .form-control').bind('keydown', 'f2', function(e){
            e.preventDefault();
            $('#discount').focus();
            $('#discount').select();
        });
        $('body,.form-control1, .form-control').bind('keydown', 'f3', function(e){
            e.preventDefault();
            $('#paid').focus();
            $('#paid').select();
        });

        var savelock=false;
        function saveBill(){
            var arr=[];
            $('.billitems').each(function(){
                bdata=JSON.parse(this.value);
                arr.push(bdata);
            });
            if(arr.length==0){
                toastr.error('Please add Products in bill','{{env('APP_NAME')}}', {timeOut: 1000});
            }
            var fd={
                billitems:arr,
                gross:$('#grosstotal').val(),
                dis:$('#discount').val(),
                net:$('#nettotal').val(),
                paid:$('#paid').val(),
                return:$('#return').val(),
                due:$('#due').val(),

            };

            console.log(fd);
        }
    </script>
@endsection

