<tr id="item-{{ $item->id }}" data-name="{{ $item->title }}">
    <td>{{$item->title}}</td>
    <td>{{$item->cost_price}}</td>
    <td>{{$item->sell_price}}</td>
    <td>{{$item->stock}}</td>
    <td>{{$item->unit}}</td> 
    <td>
        <button  class="btn btn-primary" data-item="{{$item->toJson()}}" onclick="initEdit(this);" >Edit</button>
        <button class="btn btn-danger" onclick="removeData({{$item->id}});">Delete</button>
    </td>
</tr>