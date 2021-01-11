<tr>
    <td>
        {{$d->user->distributer()->id}}
    </td>
    <td>
        {{$d->user->name}}
    </td>
    <td>
        {{$d->amount}} {{$d->type==1?"CR":"DR"}}
    </td>

</tr>
