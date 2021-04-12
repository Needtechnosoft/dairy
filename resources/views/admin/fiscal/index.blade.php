@extends('admin.layouts.app')
@section('title','Fiscal Year')
@section('head-title','Fiscal Year')
@section('css')
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
@endsection
@section('toobar')
<div class="p-4 mb-2 cc1" style="background-color: white; border-radius: 10px">
    <form id="form_validation" method="POST" onsubmit="return saveData(event);">
        @csrf
        <div class="row">

            <div class="col-lg-4">
                <label for="name">Title</label>
                <div class="form-group">
                    <input type="text" id="title" name="title" class="form-control next" data-next="sdate" placeholder="Enter expense title" required>
                </div>
            </div>

            <div class="col-lg-3">
                <label for="name">Start Date</label>
                <div class="form-group">
                    <input type="date" name="sdate" id="sdate" class="form-control next" data-next="edate" placeholder="Date" required>
                </div>
            </div>

            <div class="col-lg-3">
                <label for="name">Start Date</label>
                <div class="form-group">
                    <input type="date" name="edate" id="edate" class="form-control next" data-next="" placeholder="Date" required>
                </div>
            </div>


            <div class="col-lg-2">
                <div class="form-group" style="margin-top:30px;">
                    <button class="btn btn-primary btn-block">Submit Data</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
@section('content')

<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="expenseData">

        </tbody>
    </table>
</div>






@endsection
@section('js')
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>

<script>


    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("fiscal.index")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Fiscal Year added successfully!');
                $('#form_validation').trigger("reset");
                $('#expenseData').prepend(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }


    // edit data
    function editData(e) {
        axios({
                method: 'post',
                url: '{{route("fiscal.update")}}',
                data: {
                    title:$('#title-'+e).val(),
                    sdate:$('#sdate-'+e).val(),
                    edate:$('#edate-'+e).val(),
                    id:e
                }

            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Updated successfully!');
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }



     function loadData(){
         axios({
                 method: 'get',
                 url: '{{ route("fiscal.list")}}'
             })
             .then(function(response) {
                 // console.log(response.data);
                 $('#expenseData').html(response.data);
                 initTableSearch('sid', 'expenseData', ['name']);
             })
             .catch(function(response) {
                 //handle error
                 console.log(response);
             });
    }

    // delete
    function removeData(id) {
        var dataid = id;
        if (confirm('Are you sure?')) {
            axios({
                    method: 'get',
                    url: '/admin/fiscal-year/delete/' + dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#fiscal-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {

                     showNotification('bg-danger','You do not have authority to delete!');
                    //handle error
                    console.log(response);
                });
        }
    }

    window.onload = function(){
        loadData();
    }


</script>
@endsection
