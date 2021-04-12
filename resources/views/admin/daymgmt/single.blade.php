<tr id="day-{{$day->id}}" >
    <form action="">
        <td><input type="date" id="date-{{$day->id}}" value="{{ $day->date }}" required></td>
        <td>
            @if ($day->status == 0)
                @if ($day->isopen==0)
                    <a href="{{ route('daymgmt.default',$day->id) }}" title="Click for open" class="badge badge-primary">Closed</a>
                @else
                    --------
                @endif
            @else
                <span class="badge badge-success">Open</span>
            @endif
        </td>
        <td>
            <span  type="button" class="btn btn-primary btn-sm" onclick="editData({{ $day->id }});" >Edit</span>
            |
            <button class="btn btn-danger btn-sm" onclick="removeData({{$day->id}});">Delete</button>
        </td>
    </form>
</tr>
