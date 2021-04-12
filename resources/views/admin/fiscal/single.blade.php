<tr id="fiscal-{{$fiscal->id}}" >
    <form action="">
        <td><input type="text" id="title-{{$fiscal->id}}" name="title" placeholder="Title" value="{{ $fiscal->title }}" required> </td>
        <td><input type="date" id="sdate-{{$fiscal->id}}" name="sdate" value="{{$fiscal->s_date}}" required></td>
        <td><input type="date" id="edate-{{$fiscal->id}}" name="edate" value="{{$fiscal->e_date}}" required></td>
        <td>
            @if ($fiscal->status == 0)
                <a href="{{ route('fiscal.default',$fiscal->id)}}" class="badge badge-primary">Make Default</a>
            @else
               <span class="badge badge-success">Default</span>
            @endif
        </td>
        <td>
            <span  type="button" class="btn btn-primary btn-sm" onclick="editData({{ $fiscal->id }});" >Edit</span>
            |
            <button class="btn btn-danger btn-sm" onclick="removeData({{$fiscal->id}});">Delete</button>
        </td>
    </form>
</tr>
