@extends('admin.layouts.app')
@section('title','Expense Categories')
@section('head-title','Expense Category')
@section('toobar')
    <form action="{{ route('admin.exp.category.add') }}"  method="POST" >
        @csrf
        <div class="row">
            <div class="col-lg-9">
                <label for="name">Expense Category Name</label>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control next" data-next="price" placeholder="Expense Category Name" required>
                </div>
            </div>
            <div class="col-md-3 mt-4">
                <button class="btn btn-primary">Save</button>
            </div>

        </div>
    </form>
@endsection
@section('content')

<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody >
            @foreach (\App\Models\Expcategory::latest()->get() as $item)
            <form action="{{ route('admin.exp.category.update') }}" method="POST">
                @csrf
                <tr>
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <td class="p-2"> <input type="text" name="name" class="form-control" value="{{ $item->name }}" ></td>
                    <td>
                        <button class="btn btn-primary btn-sm">Update</button>
                    </td>
                </tr>
            </form>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
@section('js')
<script>
    initTableSearch('sid', 'farmerData', ['name']);

    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("product.add")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                // console.log(response);
                showNotification('bg-success', 'Collection center added successfully!');
                $('#largeModal').modal('toggle');
                $('#form_validation').trigger("reset")
                $('#data').prepend(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    // edit data
    function update(e) {
        var bodyFormData = new FormData(document.getElementById('collectionForm-' + e));
        // console.log(bodyFormData);
        axios({
                method: 'post',
                url: '{{route('product.update')}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                // console.log(response);
                showNotification('bg-success', 'Updated successfully!');
            })
            .catch(function(response) {
                //handle error
                showNotification('bg-danger', 'You do not have authority to update !');
                console.log(response);
            });
    }


    function del(id) {
        var dataid = id;
        if (confirm('Are you sure?')) {
            axios({
                    method: 'post',
                    url: '{{route('product.del')}}',
                    data:{'id':id}
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#center-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {
                    //handle error
                    showNotification('bg-danger', 'You do not have authority to delete !');
                    console.log(response);
                });
        }
    }
</script>
@endsection
