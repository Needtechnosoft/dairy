@foreach ($fiscals as $fiscal)
    @include('admin.fiscal.single',['fiscal'=>$fiscal])
@endforeach
