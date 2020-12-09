<tr id="item-{{ $item->id }}" data-name="{{ $item->title }}">
    <td>{{$item->title}}</td>
    <td>{{$item->number}}</td>
    <td>{{$item->cost_price}}</td>
    <td>{{$item->sell_price}}</td>
    <td>{{$item->stock}}</td>
    <td>{{$item->unit}}</td> 
    <td>
        <button  class="btn btn-primary btn-sm" data-item="{{$item->toJson()}}" onclick="initEdit(this);" >Edit</button>
        <button class="btn btn-danger btn-sm" onclick="removeData({{$item->id}});">Delete</button>
    </td>
</tr>