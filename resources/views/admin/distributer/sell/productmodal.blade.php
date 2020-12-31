
<div class="modal fade" id="productmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg " role="document" >
    <div class="modal-content">
        <div class="modal-header pb-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                style="top:5px;font-size:3rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pt-1">
            <input type="text" id="productsearch" placeholder="Search" style="width: 134px;margin-bottom:5px;" >
            <table class="table">
                <tr>

                    <th>
                        no
                    </th>
                    <th>
                        name
                    </th>
                </tr>
                <tbody id="products">

                    @foreach (\App\Models\Product::all() as $product)
                        <tr onclick="setData('product_id',{{$product->id}});closeModal('');" id="product-{{$product->id}}" data-name="{{ $product->name }}" class="searchable" data-product="{{$product->toJson()}}" style="cursor: pointer">
                            <td>
                                {{$product->id}}
                            </td>
                            <td>
                                {{$product->name}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
