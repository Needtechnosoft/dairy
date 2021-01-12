<tr id="ledger-{{$d->id}}">
    <td>
        {{$d->user->distributer()->id}}
    </td>
    <td>
        {{$d->user->name}}
    </td>
    <td>
        {{(float)$d->amount}} {{$d->type==1?"CR":"DR"}}
    </td>
    <td>
        @if ($d->user->ledgers->count()<=1)
            <button class="btn btn-danger" onclick="removeData({{$d->id}});">Delete</td>
        @else

        @endif
    </td>

</tr>
