@foreach($emp as $user)
<tr id="employee-{{$user->id}}" data-name="{{ $user->name }}" class="searchable">
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->phone }}</td>
    <td>{{ $user->address }}</td>
    <td>{{ $user->employee()->salary }}</td>
    <td>
        <button  type="button" data-employee="{{$user->toJson()}}" data-salary="{{ $user->employee()->salary }}" class="badge badge-primary editfarmer" onclick="initEdit(this);" >Edit</button>
        |
        <button class="badge badge-danger" onclick="removeData({{$user->id}});">Delete</button></td>
</tr>
@endforeach