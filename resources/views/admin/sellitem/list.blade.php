@foreach($sell as $itemsell)
<tr id="itemsell-{{ $itemsell->id }}" data-user_id="{{ $itemsell->user_id }}" data-item_number="{{ $itemsell->item->number }}">
    <td>{{$itemsell->user_id}}</td>
    <td>{{$itemsell->item->title}}</td>
    <td>{{$itemsell->rate}}</td>
    <td>{{$itemsell->qty}}</td>
    <td>{{$itemsell->total}}</td> 
    <td>{{$itemsell->paid}}</td> 
    <td>{{$itemsell->due}}</td> 
    <td>
        <button  class="badge badge-primary" data-itemsell="{{$itemsell->toJson()}}" onclick="initEdit(this);" >Edit</button>
        <button class="badge badge-danger" onclick="removeData({{$itemsell->id}});">Delete</button>
    </td>
</tr>
@endforeach