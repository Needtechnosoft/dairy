<tr id="distributer-{{$user->id}}" data-name="{{ $user->name }}" class="searchable">
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->phone }}</td>
    <td>{{ $user->address }}</td>
    <td>{{ $user->distributer()->rate }}</td>
    <td>{{ $user->distributer()->amount }}</td>
    <td>
        <button  type="button" data-distributer="{{$user->toJson()}}" data-rate="{{ $user->distributer()->rate }}" data-amount="{{ $user->distributer()->amount }}"  class="btn btn-primary btn-sm" onclick="initEdit(this);" >Edit</button>
        |
        <button class="btn btn-danger btn-sm" onclick="removeData({{$user->id}});">Delete</button></td>
</tr>