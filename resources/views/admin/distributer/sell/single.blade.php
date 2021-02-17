@if ($sell->distributer->user!=null)

    <tr id="sell-{{$sell->id}}"   data-name="{{ $sell->distributer->user->name }}" class="searchable sell_{{$sell->distributer->id}}">
        <td>{{ $sell->distributer->user->name }}</td>
        <td>{{ $sell->product->name }}</td>
        <td>{{ $sell->rate }}</td>
        <td>{{ $sell->qty }}</td>
        <td>{{ $sell->total }}</td>
        <td>{{ $sell->paid }}</td>
        <td>{{ $sell->deu }}</td>
        <td>
            <button class="btn btn-danger btn-sm" onclick="removeData({{$sell->id}});">Delete</button></td>
    </tr>
@endif
