<tr id="farmer-{{$user->id}}" data-name="{{ $user->name }}" class="searchable">
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->phone }}</td>
    <td>{{ $user->address }}</td>
    <td>
        @if($user->amount > 0)
            {{ $user->amount}}   ( {{$user->amounttype==1?"Cr":"Dr"}} )
        @else
            --
        @endif
    </td>
    <td>
        <button  type="button" data-farmer="{{$user->toJson()}}" class="btn btn-primary btn-sm editfarmer" onclick="initEdit(this);" >Edit</button>
        |
        <button class="btn btn-danger btn-sm" onclick="removeData({{$user->id}});">Delete</button></td>
</tr>
