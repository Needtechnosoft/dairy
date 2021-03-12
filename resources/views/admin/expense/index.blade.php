@extends('admin.layouts.app')
@section('title','Expenses')
@section('head-title','Expenses')
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
                <label for="name">Date</label>
                <div class="form-group">
                    <input type="text" name="date" id="nepali-datepicker" class="form-control next" data-next="cat_id" placeholder="Date" required>
                </div>
            </div>

            <div class="col-lg-4">
                <label for="name">Expense Category</label>
                <div class="form-group">
                    <select name="cat_id" id="cat_id" class="form-control show-tick ms select2 next" data-next="title" data-placeholder="Select" required>
                        <option ></option>
                        @foreach (\App\Models\Expcategory::get() as $item)
                            <option value="{{ $item->id }}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-4">
                <label for="name">Title</label>
                <div class="form-group">
                    <input type="text" id="title" name="title" class="form-control next" data-next="amount" placeholder="Enter expense title" required>
                </div>
            </div>

            <div class="col-lg-4">
                <label for="name">Amount</label>
                <div class="form-group">
                    <input type="number" id="amount" name="amount" min="0" class="form-control next" data-next="paid_by" placeholder="Enter expense amount" required>
                </div>
            </div>

            <div class="col-lg-4">
                <label for="name">Paid By</label>
                <div class="form-group">
                    <input type="text" id="paid_by" name="payment_by" class="form-control next" data-next="payd" placeholder="Enter name of paiyer" required>
                </div>
            </div>

            <div class="col-lg-4">
                <label for="name">Payment Detail</label>
                <div class="form-group">
                    <input type="text" id="payd" name="payment_detail" class="form-control next" data-next="remark" placeholder="Enter payment detail" required>
                </div>
            </div>

            <div class="col-lg-6">
                <label for="remark">Remarks</label>
                <div class="form-group">
                    <input type="text" id="remark" name="remark" class="form-control" placeholder="Enter remark" required>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group" style="margin-top:30px;">
                    <button class="btn btn-primary btn-block">Submit Data</button>
                </div>
            </div>
        </div>
    </form>
</div>
@include('admin.expense.edit')
<div class="col lg-2">
    <div class="pt-2 pb-2">
        <input type="text" id="sid" placeholder="Search">
    </div>
</div>
@endsection
@section('content')

<div class="row mb-3">
    <div class="col lg-3">
        <select name="cat_id" id="cat" class="form-control show-tick ms select2">
            <option></option>
            @foreach (\App\Models\Expcategory::all() as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
        <small>Select category to display category wise expense</small>
    </div>

    <div class="col-lg-2">

    </div>

    <div class="col-lg-2">
        <select name="year" id="yr" class="form-control show-tick ms select2">

        </select>
    </div>
    <div class="col-lg-2">
        <select name="month" id="mth" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-lg-2">
        <span class="btn btn-primary" onclick="loadExp();">Load Expense</span>
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






@endsection
@section('js')
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>

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
        $('#editdate').val(exp.date);
        $('#eamount').val(exp.amount);
        $('#eid').val(exp.id);
        $('#epaid_by').val(exp.payment_by);
        $('#epayd').val(exp.payment_detail);
        $('#eremark').val(exp.remark);
        $('#ecat_id').val(exp.expcategory_id).change();
        // $('#editModal').modal('show');
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        ccswitch();
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
                if($('#for_multiple').val() == 0){
                    $('#largeModal').modal('toggle');
                }
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
                url: '{{route('admin.exp.edit')}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Updated successfully!');
                $('#editModal').modal('toggle');
                $('#expense-' + rowid).replaceWith(response.data);
                ccswitch();
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }



     function loadData(){
         axios({
                 method: 'get',
                 url: '{{ route("admin.exp.list")}}',
                 data : {'year':$}
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
                    url: '/admin/expense-delete/' + dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#expense-' + dataid).remove();
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
        $(".cc2").hide();

        var mainInput = document.getElementById("nepali-datepicker");
        mainInput.nepaliDatePicker();

        var month = NepaliFunctions.GetCurrentBsDate().month;
        var year = NepaliFunctions.GetCurrentBsDate().year;
        $('#yr').val(year).change();
        $('#mth').val(month).change();
        loadData();

        var editdate = document.getElementById("editdate");
        editdate.nepaliDatePicker();
    };


        var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
        var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
        $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);


    function loadExp(){
            var year = $('#yr').val();
            var month = $('#mth').val();
        axios({
                 method: 'post',
                 url: '{{ route("admin.exp.load")}}',
                 data:{ 'year':year,'month':month}
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


    $('#cat').change(function(){
           var cat_id = $('#cat').val();
        axios({
                 method: 'post',
                 url: '{{ route("admin.category.expenses")}}',
                 data:{ 'id':cat_id}
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
    });

    s_id=0;
    function ccswitch(){
        if(s_id==0){
            $(".cc1").hide();
            $(".cc2").show();
            s_id=1;
        }else{
            $(".cc2").hide();
            $(".cc1").show();
            s_id=0;

        }
    }

</script>
@endsection
