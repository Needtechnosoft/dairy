@foreach($data as $d)
<tr id="snf-{{$d->user->no}}" data-snf="{{ $d->snf??0 }}" data-fat="{{ $d->fat??0 }}">
    <td>{{ $d->user->no }}</td>
    <td id="_fat-{{$d->user->no}}" >{{ $d->fat??0 }}</td>
    <td id="_snf-{{$d->user->no}}" >{{ $d->snf??0 }}</td>
</tr>
@endforeach
