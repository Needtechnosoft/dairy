<tr id="itemsell-{{ $sell_item->id }}" data-user_id="{{ $sell_item->user_id }}" data-item_number="{{ $sell_item->item->number }}">
    <td>{{$sell_item->user_id}}</td>
    <td>{{$sell_item->item->title}}</td>
    <td>{{$sell_item->rate}}</td>
    <td>{{$sell_item->qty}}</td>
    <td>{{$sell_item->total}}</td> 
    <td>{{$sell_item->paid}}</td> 
    <td>{{$sell_item->due}}</td> 
    <td>
        <button  class="badge badge-primary" data-itemsell="{{$sell_item->toJson()}}" onclick="initEdit(this);" >Edit</button>
        <button class="badge badge-danger" onclick="removeData({{$sell_item->id}});">Delete</button>
    </td>
</tr>