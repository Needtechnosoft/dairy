@extends('admin.layouts.app')
@section('title','Products')
@section('head-title','Products')
@section('toobar')
    <div class="modal-header">
        <h4 class="title" id="largeModalLabel">Create New Product</h4>
    </div>
    <div class="card">
        <div class="body">
            <form id="form_validation" method="POST" onsubmit="return saveData(event);">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label for="name">Category Name</label>
                        <div class="form-group">
                            <select name="category_id" id="category_id" class="form-control show-tick ms select2" required>
                               <option></option>
                               @foreach (\App\Models\ProductCat::all() as $c)
                                 <option value="{{$c->id}}">{{ $c->name }}</option>
                               @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <label for="name">Product Name</label>
                        <div class="form-group">
                            <input type="text" id="name" name="name" class="form-control next" data-next="price" placeholder="Product Name" required>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <label for="name">Cost Price</label>
                        <div class="form-group">
                            <input type="number" id="price" name="costprice" class="form-control next" data-next="sell" step="0.001" placeholder="Enter cost price" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label for="sellprice">Selling Price</label>
                        <div class="form-gorup">
                            <input type="number" id="sell" name="sellprice" class="form-control next" data-next="offer" step="0.001" placeholder="Enter sell price" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-gorup">
                            <label for="offer">Offer Price</label>
                            <input type="number" id="offer" name="saleprice" class="form-control next" data-next="wholesale" value="0" step="0.001" placeholder="Enter sell price" >
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-gorup">
                            <label for="whole">Wholesale Price</label>
                            <input type="number" id="wholesale" name="wholesaleprice" class="form-control next" data-next="barcode" step="0.001" placeholder="Enter sell price" value="0">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label for="barcode">Barcode</label>
                        <div class="form-group">
                            <input type="text" id="barcode" name="barcode" class="form-control next" data-next="unit" placeholder="Product Barcode" required>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <label for="unit">Unit (EG. KG)</label>
                        <div class="form-group">
                            <input type="text" id="unit" name="unit" class="form-control next" data-next="sku" placeholder="Product Name" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label for="sku">SKU</label>
                        <div class="form-group">
                            <input type="text" id="sku" name="sku" class="form-control next" data-next="stock" placeholder="Product SKU" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-gorup">
                            <label for="alert">Alert Quantity</label>
                            <input type="number" id="altqty" name="alertqty" class="form-control next" min="1" data-next="exp"  placeholder="Enter Alert Qty" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-gorup">
                            <label for="exp">Expire Alert (Days)</label>
                            <input type="number" id="exp" name="expiredays" class="form-control next" min="1" data-next="tax"  placeholder="Enter Expire days" required>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <label for="tax">Tax (%)</label>
                        <div class="form-group">
                            <input type="number" class="form-control next" data-next="stock"  id="tax" name="tax" step="0.001" value="0" placeholder="Enter tax percentage">
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <label for="current">Current Stock</label>
                        <div class="form-group">
                            <input type="number" id="stock" name="stock" class="form-control next" data-next="address" placeholder="Enter Stock" required>
                        </div>
                    </div>


                    <div class="col-lg-2">
                        <div style="margin-top: 38px;">
                            <input type="checkbox" name="onsale" value="1" onclick="
                            if(this.checked){
                                $('#dis_enable').removeClass('d-block');
                                $('#dis_enable').addClass('d-none');
                            }else{
                                $('#dis_enable').addClass('d-block');
                                $('#dis_enable').removeClass('d-none');
                            }
                            "> Onsale
                        </div>
                    </div>

                    <div class="col-lg-3" style="margin-top: 38px;">
                        <div class="d-block" id="dis_enable">
                            <input type="checkbox" name="hasdiscount" value="1" onchange="
                            if(this.checked){
                                $('#dis_block').removeClass('d-none');
                                $('#dis_block').addClass('d-block');
                            }else{
                                $('#dis_block').removeClass('d-block');
                                $('#dis_block').addClass('d-none');
                            }
                            "> Enable Discount
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div style="margin-top: 38px;">
                            <input type="checkbox" id="single_batch" name="single_batch" value="1" onchange="
                            if(this.checked){
                                $('#stock').prop( 'disabled', false );
                            }else{
                                $('#stock').prop( 'disabled', true );
                            }
                            "> Single Batch
                        </div>
                    </div>
                </div>

                <div class="d-none mb-2" id="dis_block">
                    <div class="row" style="border: 1px #ccc solid; padding:1rem; border-radius: 10px; margin: 5px;">
                        <div class="col-lg-3">
                            <label for="disc">Discount Type</label>
                            <select name="discount_type" id="dis_type" class="form-control show-tick ms select2" required>
                                <option></option>
                               <option value="1">Amount Type</option>
                               <option value="2">Percentage Type</option>
                             </select>
                        </div>

                        <div class="col-lg-3">
                            <label for="amt">Amount/Percentage</label>
                            <input type="number" name="dis_value" min="1" class="form-control next" data-next="minqty" placeholder="Enter discount value" required>
                        </div>
                        <div class="col-lg-3">
                            <label for="amt">Min Qty</label>
                            <input type="number" id="minqty" name="minqty" min="1" class="form-control next" data-next="maxqty" placeholder="Enter min. qty. for discount" required>
                        </div>

                        <div class="col-lg-3">
                            <label for="amt">Max Qty</label>
                            <input type="number" id="maxqty" name="maxqty" min="1" class="form-control" placeholder="Enter max. qty. for discount" required>
                        </div>

                    </div>
                </div>
                <button class="btn btn-raised btn-primary waves-effect btn-block" type="submit">Submit Data</button>
        </div>
    </div>
    </form>
@endsection
@section('content')
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search">
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>#Id</th>
                <th>Name</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="data">
            @foreach($products as $product)
                @include('admin.products.single',['product'=>$product])
            @endforeach
        </tbody>
    </table>
</div>




@endsection
@section('js')
<script>
    initTableSearch('sid', 'data', ['name']);

    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("product.add")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                // console.log(response);
                showNotification('bg-success', 'Product added successfully!');
                $('#largeModal').modal('toggle');
                $('#form_validation').trigger("reset")
                $('#data').prepend(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }



    function del(id) {
        var dataid = id;
        if (confirm('Are you sure?')) {
            axios({
                    method: 'post',
                    url: '{{route('product.del')}}',
                    data:{'id':id}
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#center-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {
                    //handle error
                    showNotification('bg-danger', 'You do not have authority to delete !');
                    console.log(response);
                });
        }
    }

    window.onload = function(){
        $('#single_batch').prop('checked', true);
    }



</script>
@endsection
