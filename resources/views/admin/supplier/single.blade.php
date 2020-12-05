<tr id="supplier-{{$user->id}}" data-name="{{ $user->name }}" class="searchable">
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->phone }}</td>
    <td>{{ $user->address }}</td>
    <td>
        <button  type="button" data-supplier="{{$user->toJson()}}" data-id="{{$user->id}}"  data-phone="{{ $user->address }}" class="badge badge-primary editfarmer" onclick="initEdit(this);" >Edit</button>
        |
        <button class="badge badge-danger" onclick="removeData({{$user->id}});">Delete</button></td>
</tr>