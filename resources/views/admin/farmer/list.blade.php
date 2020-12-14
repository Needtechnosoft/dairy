@foreach($farmers as $f)
<tr id="farmer-{{$f->id}}" data-name="{{ $f->name }}" class="searchable">
    <td>{{ $f->id }}</td>
    <td>{{ $f->name }}</td>
    <td>{{ $f->phone }}</td>
    <td>{{ $f->address }}</td>
    <td>
        @if($f->amount > 0)
            {{ $f->amount}}   ( {{$f->amounttype==1?"Cr":"Dr"}} )
        @else
            --
        @endif
    </td>
    <td>
        <button  type="button" data-farmer="{{$f->toJson()}}" class="btn btn-primary btn-sm editfarmer" onclick="initEdit(this);" >Edit</button>
        |
        <button class="btn btn-danger btn-sm" onclick="removeData({{$f->id}});">Delete</button>
    </td>
</tr>
@endforeach
