@extends('admin.layouts.app')
@section('title','Farmer Advance')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Farmer Advance')
@section('toobar')
<button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">Add Farmer Advance</button>
@endsection
@section('content')
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search">
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Farmer Number</th>
                <th>Amount (Rs.)</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="advanceData">

        </tbody>
    </table>
</div>

<!-- modal -->

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" data-ff="u_id">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Add Farmer advance</h4>
                <div>
                   <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">X</button>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <div class="row">
                            <div class="col-lg-4">
                                <div class="pt-2 pb-2">
                                    <input type="text" id="searchid" placeholder="Search" style="width: 230px;">
                                </div>
                                <div class="table-responsive" style="height: 114px">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Farmer Name</th>
                                            </tr>
                                        </thead>
                                        <tbody id="farmerforData">
                                            @foreach(\App\Models\User::where('role',1)->get() as $u)
                                            <tr id="farmer-{{ $u->id }}" data-name="{{ $u->name }}" onclick="farmerId({{ $u->id }});">
                                                <td class="p-1"><span style="cursor: pointer;"> {{ $u->id }} </span></td>
                                                <td class="p-1" style="cursor: pointer;"><span>{{ $u->name }}</span> </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <div class="col-lg-8">
                            <form id="form_validation" method="POST" onsubmit="return saveData(event);">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="u_number">Farmer Number</label>
                                        <input type="hidden" name="date" id="nepali-datepicker">
                                        <div class="form-group">
                                            <input type="number" id="u_id" name="user_id" min="0" class="form-control next" data-next="amount" placeholder="Enter farmer number" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="amount">Advance Amount</label>
                                        <input type="number" id="amount" min="0" name="amount" class="form-control" placeholder="Enter advance amount" value="0" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <button class="btn btn-raised btn-primary waves-effect btn-block" type="submit">Submit Data</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-ff="eamount">
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
                                <label for="u_number">Farmer Number</label>
                                <input type="hidden" name="date" id="nepali-datepicker">
                                <div class="form-group">
                                    <input type="number" id="eu_id" name="user_id" min="0" class="form-control next" data-next="amount" placeholder="Enter farmer number" required readonly>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="amount">Advance Amount</label>
                                <input type="number" id="eamount" min="0" name="amount" class="form-control" placeholder="Enter advance amount" value="0" required>
                            </div>
                            <div class="col-lg-12">
                                <button class="btn btn-raised btn-primary waves-effect btn-block" type="submit">Submit Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    initTableSearch('searchid', 'farmerforData', ['name']);
    var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
    var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
    $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsDate().year+''+month+''+day);

    function initEdit(ele) {
        var adv = JSON.parse(ele.dataset.advance);
        console.log(adv);
        $('#eid').val(adv.id);
        $('#eu_id').val(adv.user_id);
        $('#eamount').val(adv.amount);
        $('#editModal').modal('show');

    }

    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("admin.farmer.advance.add")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Farmer advance added successfully!');
                $('#largeModal').modal('toggle');
                $('#form_validation').trigger("reset")
                $('#advanceData').prepend(response.data);
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
            url: '{{ route("admin.farmer.advance.list")}}',
        })
        .then(function(response) {
            // console.log(response.data);
            $('#advanceData').html(response.data);
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });

    // delete
    function removeData(id) {
        var dataid = id;
        console.log(dataid);
        if (confirm('Are you sure?')) {
            axios({
                    method: 'get',
                    url: '/admin/farmer-advance-delete/'+ dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#advance-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {
                    //handle error
                    console.log(response);
                });
        }
    }

    function farmerId(id){
        $('#u_id').val(id);
    }
</script>
@endsection
