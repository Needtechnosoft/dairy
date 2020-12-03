@foreach($data as $d)
<tr id="snf-{{$d->user_id}}" data-snf="{{ $d->snf??0 }}" data-fat="{{ $d->fat??0 }}">
    <td>{{ $d->user_id }}</td>
    <td id="_snf-{{$d->user_id}}" >{{ $d->snf??0 }}</td>
    <td id="_fat-{{$d->user_id}}" >{{ $d->fat??0 }}</td>
</tr>
@endforeach