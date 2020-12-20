@extends('admin.layouts.app')
@section('title','Farmer-add')
@section('head-title','Create Farmer')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
@endsection
@section('toobar')
<button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">Create Farmer (alt+n)</button>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3">
        <input type="text" id="sid" placeholder="Search">
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3 text-right"><div class="mt-2"><strong> Collection Center : </strong></div></div>
    <div class="col-md-3">
        <div class="form-group text-right">
            <select name="center_id" id="loadFarmerByCenter" class="form-control show-tick ms next" data-next="session">
                <option></option>
                @foreach(\App\Models\Center::all() as $c)
                <option value="{{$c->id}}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>#Id</th>
                <th>Farmer Name</th>
                <th>Farmer phone</th>
                <th>Farmer Address</th>
                <th>Balance (Rs.)</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="farmerData">

        </tbody>
    </table>
</div>

<!-- modal -->

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" data-ff="center_id">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Create Farmer</h4>
            </div>
            <hr>
            <div class="card mb-0">
                <div class="body">
                    <form id="form_validation" method="POST" onsubmit="return saveData(event);">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Collection Center</label>
                                    <select name="center_id" id="center_id" class="form-control show-tick ms next" data-next="name" required>
                                        <option></option>
                                        @foreach(\App\Models\Center::all() as $c)
                                        <option value="{{$c->id}}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                               <input type="hidden" name="date" id="nepali-datepicker">
                                <label for="name">Farmer Name</label>
                                <div class="form-group">
                                    <input type="text" id="name" name="name" class="form-control next" data-next="phone" placeholder="Enter farmer name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Farmer Phone</label>
                                <div class="form-group">
                                    <input type="number" id="phone" name="phone" class="form-control next" data-next="address" placeholder="Enter farmer phone" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Farmer Address</label>
                                <div class="form-group">
                                    <input type="text" id="address" name="address" class="form-control next" data-next="advance" placeholder="Enter farmer address" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Advance Amount </label>
                                <div class="form-group">
                                    <input type="number" id="advance" name="advance" step="0.001" value="0" class="form-control" placeholder="Enter advance">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">

                <button class="btn btn-raised btn-primary waves-effect" type="submit" >Submit Data</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
            </form>
            <div class="text-right pr-3">
                <span>
                    <input type="checkbox" id="another"> Add Another
                </span>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-ff="ename">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Edit Farmer</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="editform" onsubmit="return editData(event);">
                        @csrf
                        <input type="hidden" name="id" id="eid">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Farmer Name</label>
                                <div class="form-group">
                                    <input type="text" id="ename" name="name" class="form-control next" data-next="ephone" placeholder="Enter farmer name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Farmer Phone</label>
                                <div class="form-group">
                                    <input type="number" id="ephone" name="phone" class="form-control next" data-next="eaddress" placeholder="Enter farmer phone" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Farmer Address</label>
                                <div class="form-group">
                                    <input type="text" id="eaddress" name="address" value="" class="form-control" placeholder="Enter farmer address" required>
                                </div>
                            </div>

                            <!-- <div class="col-lg-6">
                                <label for="name">Advance Amount </label>
                                <div class="form-group">
                                    <input type="number" id="eadvance" name="advance" step="0.001" value="0" class="form-control" placeholder="Enter advance">
                                </div>
                            </div> -->
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
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
    var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
    $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsDate().year+''+month+''+day);
    function initEdit(ele) {
        var farmer = JSON.parse(ele.dataset.farmer);
        console.log(farmer);
        $('#ecenter_id').val(farmer.center_id).change();
        $('#ename').val(farmer.name);
        $('#ephone').val(farmer.phone);
        $('#eaddress').val(farmer.address);
        // $('#eadvance').val(ele.dataset.advance);
        $('#eid').val(farmer.id);
        $('#editModal').modal('show');

    }

    function saveData(e) {
        e.preventDefault();
        var center = $('#center_id').val();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("admin.farmer")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Farmer added successfully!');
                if(!(document.getElementById('another').checked)){
                    $('#largeModal').modal('toggle');
                }
                $('#form_validation').trigger("reset");
                $('#name').focus();
                $('#farmerData').prepend(response.data);
                $('#center_id').val(center).change();
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    // edit data
    function editData(e) {
        e.preventDefault();
        var rowid = $('#eid').val();
        var bodyFormData = new FormData(document.getElementById('editform'));
        axios({
                method: 'post',
                url: '/admin/farmer/update',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Updated successfully!');
                $('#editModal').modal('toggle');
                $('#farmer-' + rowid).replaceWith(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    axios({
            method: 'get',
            url: '{{ route("list.farmer")}}',
        })
        .then(function(response) {
            // console.log(response.data);
            $('#farmerData').html(response.data);
            initTableSearch('sid', 'farmerData', ['name']);
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });

    // delete
    function removeData(id) {
        var dataid = id;
        if (confirm('Are you sure?')) {
            axios({
                    method: 'get',
                    url: '/admin/farmer/delete/' + dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#farmer-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {
                    //handle error
                    console.log(response);
                });
        }
    }

    $("#loadFarmerByCenter").change(function () {
        var center_id = $('#loadFarmerByCenter').val();
        axios({
            method: 'post',
            url: '{{ route("list.farmer.bycenter")}}',
            data:{'center':center_id}
        })
        .then(function(response) {
            // console.log(response.data);
            $('#farmerData').empty();
            $('#farmerData').html(response.data);
            initTableSearch('sid', 'farmerData', ['name']);
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });
    });


    $(document).bind('keydown', 'alt+n', function(e){
       $('#largeModal').modal('show');
    });

</script>
@endsection
