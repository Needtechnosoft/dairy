@extends('admin.layouts.app')
@section('title','Farmer Advance')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Farmer Advance')
@section('toobar')
@endsection
@section('content')
<div class="row">
<div class="col-lg-12">

    <form id="form_validation" method="POST" onsubmit="return saveData(event);">
        @csrf
        <div class="row">

            <div class="col-lg-3">
                <label for="date">Date</label>
                <input type="text" name="date" id="nepali-datepicker" class="form-control next" data-next="u_id">
            </div>

            <div class="col-lg-4">
                <label for="u_number">Employee</label>

                <div class="form-group">
                   <select name="employee_id" id="employee_id" class="form-control show-tick ms select2">
                        <option ></option>
                        @foreach (\App\Models\Employee::all() as $employee)
                                <option value="{{$employee->id}}">
                                    {{$employee->user->name}}
                                </option>
                        @endforeach
                   </select>
                </div>
            </div>

            <div class="col-lg-3">
                <label for="amount">Advance Amount</label>
                <input type="number" id="amount" min="0" name="amount" class="form-control next" data-next="save" placeholder="Enter advance amount" value="0" required>
            </div>
            <div class="col-lg-2">
                <input type="submit" id="save" class="btn btn-raised btn-primary waves-effect btn-block" value="Add" style="margin-top:30px;">
            </div>

        </div>
    </form>
</div>
</div>
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search">
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Amount (Rs.)</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="advanceData">

        </tbody>
    </table>
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
                                <input type="text" name="date" id="enepali-datepicker">
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
    // initTableSearch('searchid', 'farmerforData', ['name']);
    // load by date
    $("input#nepali-datepicker").bind('click', function (e) {
        loadAdvance();
    });

    function loadAdvance(){
        var date = $('#nepali-datepicker').val();

        axios({
                method: 'post',
                url: '{{ route("admin.emp.advance.list")}}',
                data : {'date' : date}
            })
            .then(function(response) {
                // console.log(response.data);
                $('#advanceData').empty();
                $('#advanceData').html(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    function update(id){
        var date = $('#nepali-datepicker').val();

        axios({
                method: 'post',
                url: '{{ route("admin.emp.advance.update")}}',
                data : {
                    'date' : date,
                    'id':id,
                    'amount':$('#amount-'+id).val()
                }
            })
            .then(function(response) {

            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    function del(id){
        var date = $('#nepali-datepicker').val();

        axios({
                method: 'post',
                url: '{{ route("admin.emp.advance.del")}}',
                data : {
                    'date' : date,
                    'id':id
                }
            })
            .then(function(response) {

            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }



    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("admin.emp.advance.add")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Farmer advance added successfully!');
                $('#largeModal').modal('toggle');
                $('#advanceData').prepend(response.data);
                $('#u_id').val('');
                $('#amount').val(0);
                $('#u_id').focus();
            })
            .catch(function(response) {
                //handle error
                console.log(response);
                showNotification('bg-danger','operation Faild!');
            });
    }


    window.onload = function() {
        var mainInput = document.getElementById("nepali-datepicker");
        mainInput.nepaliDatePicker();
        var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
        var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
        $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);
        loadAdvance();
        $('#u_id').focus();
    };




</script>
@endsection