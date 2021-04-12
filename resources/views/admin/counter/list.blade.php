@foreach ($counter as $item)
    @include('admin.counter.single',['counter' => $item])
@endforeach
