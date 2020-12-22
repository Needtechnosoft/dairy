@extends('admin.layouts.app')
@section('title','Expenses')
@section('head-title','Expenses')
@section('css')
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />

@endsection
@section('toobar')
<button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">Add Expense</button>
@endsection
@section('content')
<div class="row mb-3">
    <div class="col lg-2">
        <div class="pt-2 pb-2">
            <input type="text" id="sid" placeholder="Search">
        </div>
    </div>
    <div class="col-lg-3">
        <select name="year" id="yr" class="form-control show-tick ms select2">

        </select>
    </div>
    <div class="col-lg-3">
        <select name="month" id="mth" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-lg-3">
        <span class="btn btn-primary">Load Expense</span>
    </div>
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Paid By</th>
                <th>Amount (Rs.)</th>
                <th>Payment Detail</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="expenseData">

        </tbody>
    </table>
</div>

<!-- modal -->

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" data-ff="title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Add New Expense</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="form_validation" method="POST" onsubmit="return saveData(event);">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Date</label>
                                <div class="form-group">
                                    <input type="text" name="date" id="nepali-datepicker" class="form-control next" data-next="title" placeholder="Date" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Title</label>
                                <div class="form-group">
                                    <input type="text" id="title" name="title" class="form-control next" data-next="amount" placeholder="Enter expense title" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Amount</label>
                                <div class="form-group">
                                    <input type="number" id="amount" name="amount" min="0" class="form-control next" data-next="paid_by" placeholder="Enter expense amount" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Paid By</label>
                                <div class="form-group">
                                    <input type="text" id="paid_by" name="payment_by" class="form-control next" data-next="payd" placeholder="Enter name of paiyer" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Payment Detail</label>
                                <div class="form-group">
                                    <input type="text" id="payd" name="payment_detail" class="form-control next" data-next="remark" placeholder="Enter payment detail" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="remark">Remarks</label>
                                <div class="form-group">
                                    <input type="text" id="remark" name="remark" class="form-control" placeholder="Enter remark" required>
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

<!-- edit modal -->


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-ff="ename">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Edit Employee</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="editform" onsubmit="return editData(event);">
                        @csrf
                        <input type="hidden" name="id" id="eid">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Date</label>
                                <div class="form-group">
                                    <input type="text" name="date" id="enepali-datepicker" class="form-control next" data-next="title" placeholder="Date" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Title</label>
                                <div class="form-group">
                                    <input type="text" id="etitle" name="title" class="form-control next" data-next="amount" placeholder="Enter expense title" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Amount</label>
                                <div class="form-group">
                                    <input type="number" id="eamount" name="amount" min="0" class="form-control next" data-next="paid_by" placeholder="Enter expense amount" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Paid By</label>
                                <div class="form-group">
                                    <input type="text" id="epaid_by" name="payment_by" class="form-control next" data-next="payment_detail" placeholder="Enter name of paiyer" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Payment Detail</label>
                                <div class="form-group">
                                    <input type="text" id="epayd" name="payment_detail" class="form-control next" data-next="remark" placeholder="Enter payment detail" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="remark">Remarks</label>
                                <div class="form-group">
                                    <input type="text" id="eremark" name="remark" class="form-control" placeholder="Enter remark" required>
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
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>

<script>
    var month = Array.from(NepaliFunctions.GetBsMonths());
    var i =1;
    month.forEach(element => {
        $('#mth').append('<option value="'+i+'">'+element+'</option>');
        i++;
    });

    var start_y = 2050;
    var now_yr = NepaliFunctions.GetCurrentBsYear();
    var now_yr1 = now_yr;
    for (let index = start_y; index < now_yr; index++) {
        $('#yr').append('<option value="'+now_yr1+'">'+now_yr1+'</option>');
        now_yr1--;
    }

    // TODO expenses
    function initEdit(ele) {
        var exp = JSON.parse(ele.dataset.expense);
        $('#etitle').val(exp.title);
        $('#enepali-datepicker').val(exp.date);
        $('#eamount').val(exp.amount);
        $('#eid').val(exp.id);
        $('#epaid_by').val(exp.payment_by);
        $('#epayd').val(exp.payment_detail);
        $('#eremark').val(exp.remark);
        $('#editModal').modal('show');
    }

    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("admin.exp.add")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Expense added successfully!');
                $('#largeModal').modal('toggle');
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
        e.preventDefault();
        var rowid = $('#eid').val();
        var bodyFormData = new FormData(document.getElementById('editform'));
        axios({
                method: 'post',
                url: '/admin/employee/update',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Updated successfully!');
                $('#editModal').modal('toggle');
                $('#employee-' + rowid).replaceWith(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    axios({
            method: 'get',
            url: '{{ route("admin.exp.list")}}',
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

    // delete
    function removeData(id) {
        var dataid = id;
        if (confirm('Are you sure?')) {
            axios({
                    method: 'get',
                    url: '/admin/expense-delete/' + dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#expenseData-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {
                    showNotification('bg-danger','You do not have authority to delete!');
                    //handle error
                    console.log(response);
                });
        }
    }

    window.onload = function() {
        var mainInput = document.getElementById("nepali-datepicker");
        mainInput.nepaliDatePicker();
    };
    var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
    var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
    $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);


</script>
@endsection
