@extends('admin.layouts.app')
@section('title','Products')
@section('head-title')
<a href="{{ url('/admin/product') }}">Products</a> / Edit Product
@endsection
@section('content')

<div class="modal-header">
    <h4 class="title" id="largeModalLabel">Edit Product >> {{ $product->name }}</h4>
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
                             <option value="{{$c->id}}" {{ $product->product_cat_id == $c->id?'selected':'' }}>{{ $c->name }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <label for="name">Product Name</label>
                    <div class="form-group">
                        <input type="text" id="name" name="name" value="{{ $product->name }}" class="form-control next" data-next="price" placeholder="Product Name" required>
                    </div>
                </div>


                <div class="col-lg-4">
                    <label for="name">Cost Price</label>
                    <div class="form-group">
                        <input type="number" id="price" name="costprice" value="{{ $product->cost_price }}" class="form-control next" data-next="unit" step="0.001" placeholder="Enter cost price" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <label for="sellprice">Selling Price</label>
                    <div class="form-gorup">
                        <input type="number" id="sell" name="sellprice" value="{{ $product->selling_price }}" class="form-control next" data-next="" step="0.001" placeholder="Enter sell price" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-gorup">
                        <label for="offer">Offer Price</label>
                        <input type="number" id="offer" name="saleprice" value="{{ $product->sale_price }}" class="form-control next" data-next="" value="0" step="0.001" placeholder="Enter sell price" >
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-gorup">
                        <label for="whole">Wholesale Price</label>
                        <input type="number" id="wholesale" name="wholesaleprice" value="{{ $product->wholesale_rate }}" class="form-control next" data-next="" step="0.001" placeholder="Enter sell price" value="0">
                    </div>
                </div>

                <div class="col-lg-4">
                    <label for="barcode">Barcode</label>
                    <div class="form-group">
                        <input type="text" id="barcode" name="barcode" class="form-control next" value="{{ $product->barcode }}" data-next="" placeholder="Product Barcode" required>
                    </div>
                </div>


                <div class="col-lg-4">
                    <label for="unit">Unit (EG. KG)</label>
                    <div class="form-group">
                        <input type="text" id="unit" name="unit" class="form-control next" value="{{ $product->unit }}" data-next="stock" placeholder="Product Name" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <label for="sku">SKU</label>
                    <div class="form-group">
                        <input type="text" id="sku" name="sku" class="form-control next" value="{{ $product->sku }}" data-next="stock" placeholder="Product SKU" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-gorup">
                        <label for="alert">Alert Quantity</label>
                        <input type="number" id="altqty" name="alertqty" value="{{ $product->alertqty }}" class="form-control next" min="1" data-next="unit"  placeholder="Enter Alert Qty" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-gorup">
                        <label for="exp">Expire Alert (Days)</label>
                        <input type="number" id="exp" name="expiredays" value="{{ $product->expire_alert }}"  class="form-control next" min="1" data-next="unit"  placeholder="Enter Expire days" required>
                    </div>
                </div>

                <div class="col-lg-2">
                    <label for="tax">Tax (%)</label>
                    <div class="form-group">
                        <input type="number" class="form-control" value="{{ $product->tax }}"  id="tax" name="tax" step="0.001" value="0" placeholder="Enter tax percentage">
                    </div>
                </div>


                <div class="col-lg-3">
                    <label for="current">Current Stock</label>
                    <div class="form-group">
                        <input type="number" id="stock" name="stock" value="{{ $product->stock }}" class="form-control next" data-next="address" placeholder="Enter Stock" required>
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
                        " {{ $product->onsale ==1?'checked':''}}> Onsale
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
                        " {{ $product->hasdiscount == 1?'checked':''}}> Enable Discount
                    </div>
                </div>

                <div class="col-lg-2">
                    <div style="margin-top: 38px;">
                        <input type="checkbox" id="single_batch" name="single_batch" value="{{ $product->batch_type }}" onchange="
                        if(this.checked){
                            $('#stock').prop( 'disabled', false );
                        }else{
                            $('#stock').prop( 'disabled', true );
                        }
                        " {{ $product->batch_type == 0?'checked':''}}> Single Batch
                    </div>
                </div>
            </div>

            <div class="{{ $product->hasdiscount == 1?'d-block':'d-none'}} mb-2" id="dis_block">
                <div class="row" style="border: 1px #ccc solid; padding:1rem; border-radius: 10px; margin: 5px;">
                    <div class="col-lg-3">
                        <label for="disc">Discount Type</label>
                        <select name="discount_type" id="dis_type" class="form-control show-tick ms select2" required>
                            <option></option>
                           <option value="1" {{ $product->discount_type == 1?'selected':''}}>Amount Type</option>
                           <option value="2" {{ $product->discount_type == 2?'selected':''}}>Percentage Type</option>
                         </select>
                    </div>
                    @if ($product->discount_type == 1)
                        <div class="col-lg-3">
                            <label for="amt">Amount/Percentage</label>
                            <input type="number" name="dis_value" min="1" value="{{ $product->discount}}" class="form-control" placeholder="Enter discount value" required>
                        </div>
                    @else
                        <div class="col-lg-3">
                            <label for="amt">Amount/Percentage</label>
                            <input type="number" name="dis_value" min="1" value="{{ $product->discount_percentage }}" class="form-control" placeholder="Enter discount value" required>
                        </div>
                    @endif
                    <div class="col-lg-3">
                        <label for="amt">Min Qty</label>
                        <input type="number" name="minqty" min="1" value="{{ $product->minqty }}" class="form-control" placeholder="Enter min. qty. for discount" required>
                    </div>

                    <div class="col-lg-3">
                        <label for="amt">Max Qty</label>
                        <input type="number" name="maxqty" min="1" value="{{ $product->maxqty }}" class="form-control" placeholder="Enter max. qty. for discount" required>
                    </div>

                </div>
            </div>
            <button class="btn btn-raised btn-primary waves-effect btn-block" type="submit">Submit Data</button>
    </div>
</div>
</form>


<!-- add modal -->

@endsection
@section('js')
<script>
    initTableSearch('sid', 'farmerData', ['name']);

    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("product.update",$product->id)}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                // console.log(response);
                showNotification('bg-success', 'Product updated successfully!');
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }


    window.onload = function(){
       if($('#single_batch').val() == 1){
         $('#stock').prop( 'disabled', true );
       }else{
         $('#stock').prop( 'disabled', false );
       }
    }


</script>
@endsection
