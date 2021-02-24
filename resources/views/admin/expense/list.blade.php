@php
    $total = 0;
@endphp
@foreach($exps as $exp)
<tr id="expense-{{$exp->id}}" data-name="{{ $exp->title }}" class="searchable">
    <td>{{ $exp->title }}</td>
    <td>{{ _nepalidate($exp->date) }}</td>
    <td>{{ $exp->payment_by }}</td>
    <td>{{ $exp->amount }}</td>
    <td>{{ $exp->payment_detail }}</td>
    <td>{{ $exp->remark }}</td>
    <td>
        <button  type="button" data-expense="{{$exp->toJson()}}" class="btn btn-primary btn-sm" onclick="initEdit(this);" >Edit</button>
        |
        <button class="btn btn-danger btn-sm" onclick="removeData({{$exp->id}});">Delete</button></td>
</tr>
@php
    $total += $exp->amount;
@endphp
@endforeach
<tr>
    <td class="text-right" colspan="3"><strong>Total</strong></td>
    <td colspan="4"><strong>Rs.{{ $total }}</strong></td>
</tr>
