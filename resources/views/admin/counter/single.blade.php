<tr id="counter-{{$counter->id}}" >
    <form action="">
        <td><input type="text" id="name-{{$counter->id}}" value="{{ $counter->name }}" required></td>
        <td>
            @if ($counter->status == 0)
                <a href="{{ route('counter.active',$counter->id)}}" title="Click for active" class="badge badge-danger">Inactive</a>
            @else
               <a href="{{ route('counter.inactive',$counter->id) }}" title="Click for inactive" class="badge badge-primary">Active</a>
            @endif
        </td>
        <td>
            <span  type="button" class="btn btn-primary btn-sm" onclick="editData({{ $counter->id }});" >Edit</span>
            |
            <button class="btn btn-danger btn-sm" onclick="removeData({{$counter->id}});">Delete</button>
        </td>
    </form>
</tr>
