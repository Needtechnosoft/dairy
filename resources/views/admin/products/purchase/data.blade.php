@foreach ($data as $i)
<tr>
    <td>{{$i->bill_no}}</td>
    <td>{{ _nepalidate($i->date) }}</td>
    <td>{{$i->gross_total}}</td>
    <td>{{$i->discount}}</td>
    <td>{{$i->tax}}</td>
    <td>{{$i->net_total}}</td>
    <td>{{$i->paid}}</td>
    <td>{{ $i->due }}</td>
    <td>
        <a href="{{ route('purchase.invoice.item',$i->id)}}" class="btn btn-primary btn-sm">Invoice Items</a>
        <a href="{{ route('purchase.expense',$i->id)}}" class="btn btn-primary btn-sm">Expenses</a>
    </td>
</tr>
@endforeach
