@foreach($farmers as $f)

<tr id="farmer-{{$f->id}}" data-no="{{ $f->no }}" data-name="{{ $f->name }}" class="searchable">
    <td>{{ $f->no }}</td>
    <td>{{ $f->name }}</td>
    @if(env('requirephone',1)==1)
        <td>{{ $f->phone }}</td>
    @endif
    <td>{{ $f->address }}</td>
    <td>
        @if($f->amount > 0)
            {{ $f->amount}}   ( {{$f->amounttype==1?"Cr":"Dr"}} )
        @else
            --
        @endif
    </td>
    <td>
        <button  type="button" data-farmer="{{$f->toJson()}}" class="btn btn-primary btn-sm editfarmer" onclick="initEdit(this);"  >Edit</button>
        |
        <a href="{{ route('farmer.detail',$f->id) }}" class="btn btn-primary btn-sm" target="_blank">View</a> |
        <button class="btn btn-danger btn-sm" onclick="removeData({{$f->id}});">Delete</button>
    </td>
</tr>
@endforeach
