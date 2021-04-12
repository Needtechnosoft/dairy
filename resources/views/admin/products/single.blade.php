
<tr id="center-{{ $product->id }}" data-name="{{ $product->name }}">
    <td>{{ $product->id }}</td>
    <td>{{ $product->name }}</td>
    <td>{{ $product->stock }}</td>
    <td>
        <a href="{{ route('product.edit',$product->id)}}" class="btn btn-primary btn-sm">Edit</a>
        <span class="btn btn-danger btn-sm" onclick="del({{$product->id}});">Delete</span>
        @if ($product->batch_type == 1)
            <a href="{{ route('product.manage.batch',$product->id) }}" class="btn btn-primary btn-sm">Manage Batch</a>
        @endif
    </td>
</tr>
