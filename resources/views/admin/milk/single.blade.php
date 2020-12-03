<tr id="milk-{{$d->user_id}}" data-m_amount="{{ $d->m_amount??0 }}" data-e_amount="{{ $d->e_amount??0 }}">
    <!-- @if($d->m_amount>0)
        <td>{{ $d->user_id }}</td>
        <td>{{ $d->m_amount }}</td>
        <td>--</td>
    @endif
    @if($d->e_amount>0)
        <td>{{ $d->user_id }}</td>
        <td>--</td>
        <td>{{ $d->e_amount }}</td>
    @endif -->
    <td>{{ $d->user_id }}</td>
    <td id="m_milk-{{$d->user_id}}"  >{{ $d->m_amount??0 }}</td>
    <td id="e_milk-{{$d->user_id}}" >{{ $d->e_amount??0 }}</td>
</tr>