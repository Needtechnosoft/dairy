@foreach($farmers as $f)
<tr id="farmer-{{$f->id}}" data-name="{{ $f->name }}" class="searchable">
    <td>{{ $f->id }}</td>
    <td>{{ $f->name }}</td>
    <td>{{ $f->phone }}</td>
    <td>{{ $f->address }}</td>
    <td>
        <button  type="button" data-farmer="{{$f->toJson()}}" data-id="{{$f->id}}"  data-phone="{{ $f->address }}" class="btn btn-primary btn-sm editfarmer" onclick="initEdit(this);" >Edit</button>
        |
        <button class="btn btn-danger btn-sm" onclick="removeData({{$f->id}});">Delete</button>
    </td>
</tr>
@endforeach
