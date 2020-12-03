@extends('admin.layouts.app')
@section('title','Collection Centers')
@section('head-title','Create Farmer')
@section('toobar')
<button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">Create New Center</button>
@endsection
@section('content')
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search"> 
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>#Id</th>
                <th>Center Name</th>
                <th>Center Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="farmerData">
            @foreach($centers as $c)
            <tr id="center-{{ $c->id }}" data-name="{{ $c->name }}">
                <form action="#" id="collectionForm-{{ $c->id }}">
                    <td>@csrf{{ $c->id }}</td>
                    <input type="hidden" name="id" value="{{$c->id}}">
                    <td><input type="text" value="{{ $c->name }}" class="form-control" name="name" form="collectionForm-{{ $c->id }}"></td>
                    <td><input type="text" value="{{ $c->addresss }}" class="form-control" name="address" form="collectionForm-{{ $c->id }}"></td>
                    <td><span onclick="editCollection({{$c->id}});" form="collectionForm-{{ $c->id }}" class="btn btn-primary"> Update </span> | <span class="btn btn-danger" onclick="removeCenter({{$c->id}});">Delete</span></td>
                </form>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>


<!-- modal -->

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Create New Collection Centers</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="form_validation" method="POST" onsubmit="return saveData(event);">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Collection Center Name</label>
                                <div class="form-group">
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Collection Center Name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Collection Center Address</label>
                                <div class="form-group">
                                    <input type="text" id="address" name="address" class="form-control" placeholder="Collection Center Address" required>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-raised btn-primary waves-effect" type="submit">Submit Data</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
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
                url: '{{ route("add.center")}}',
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
                $('#farmerData').prepend(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    // edit data
    function editCollection(e) {
        var bodyFormData = new FormData(document.getElementById('collectionForm-' + e));
        // console.log(bodyFormData);
        axios({
                method: 'post',
                url: '/admin/collection-center-update',
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
                console.log(response);
            });
    }

    // list 
    // axios({
    //         method: 'get',
    //         url: '{{ route("list.center")}}',
    //     })
    //     .then(function(response) {
    //         console.log(response.data);

    //         var data = response.data;
    //         data.forEach(ele => {
    //             var html = '<tr id="row-'+ele.id+'"><form id="collection-'+ele.id+'">';
    //                 html+='<td>'+ele.id+'</td>';
    //                 html+='<td><input type="text" value="'+ele.name+'" class="form-control" name="name"></td>';
    //                 html+='<td><input type="text" value="'+ele.addresss+'" class="form-control" name="name"></td>';
    //                 html+='<td><button class="badge badge-primary">Update</button> | <span class="badge badge-danger" onclick="removeCenter('+ele.id+');">Delete</span></td>';
    //                 html+='</form></tr>';
    //                 $('#farmerData').append(html);
    //         });
    //     })
    //     .catch(function(response) {
    //         //handle error
    //         console.log(response);
    //     });

    // delete 
    function removeCenter(id) {
        var dataid = id;
        if (confirm('Are you sure?')) {
            axios({
                    method: 'get',
                    url: '/admin/collection-center-delete-' + dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#center-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {
                    //handle error
                    console.log(response);
                });
        }
    }
</script>
@endsection