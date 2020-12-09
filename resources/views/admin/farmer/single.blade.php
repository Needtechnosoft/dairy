<tr id="farmer-{{$user->id}}" data-name="{{ $user->name }}" class="searchable">
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->phone }}</td>
    <td>{{ $user->address }}</td>
    <td>
        <button  type="button" data-farmer="{{$user->toJson()}}" data-id="{{$user->id}}"  data-phone="{{ $user->address }}" class="btn btn-primary btn-sm editfarmer" onclick="initEdit(this);" >Edit</button>
        |
        <button class="btn btn-danger btn-sm" onclick="removeData({{$user->id}});">Delete</button></td>
</tr>