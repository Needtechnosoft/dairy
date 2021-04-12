@foreach ($cat as $c)
    @include('admin.products.category.single',['cat'=>$c])
@endforeach
