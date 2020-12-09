@foreach($bills as $bill)
<tr id="supplier-bill-{{$bill->id}}" data-name="{{ $bill->user->name }}" data-billno="{{ $bill->billno }}" class="searchable">
    <td>{{ $bill->id }}</td>
    <td>{{ $bill->user->name }}</td>
    <td>{{ $bill->billno }}</td>
    <td>{{ $bill->total }}</td>
    <td>{{ $bill->paid }}</td>
    <td>{{ $bill->total - $bill->paid }}</td>
    <td>
        <button  type="button" data-bill="{{$bill->toJson()}}" class="badge badge-primary editfarmer" onclick="initEdit(this);" >Edit</button>
        |
        <button class="badge badge-danger" onclick="removeData({{$bill->id}});">Delete</button>
        <br><a href="#">Mangage Bill Items</a>
    </td>
</tr>
@endforeach