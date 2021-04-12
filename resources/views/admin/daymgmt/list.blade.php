@foreach ($days as $d)
    @include('admin.daymgmt.single',['day'=>$d])
@endforeach
