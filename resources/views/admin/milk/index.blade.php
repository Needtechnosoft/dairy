@extends('admin.layouts.app')
@section('title','Milk Data')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Milk Data')
@section('toobar')

@endsection
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="pt-2 pb-2">
            <input type="text" id="sid" placeholder="Search" style="width: 210px;">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Farmer Name</th>
                    </tr>
                </thead>
                <tbody id="farmerData">
                    @foreach(\App\Models\User::all() as $u)
                    <tr data-name="{{ $u->name }}">
                        <td class="p-1">{{ $u->id }}</td>
                        <td class="p-1">{{ $u->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-9 bg-light">
        <form action="" id="milkData">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" name="date" id="nepali-datepicker" class="form-control" placeholder="Date">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date">Collection Center</label>
                        <select name="center_id" id="center_id" class="form-control show-tick ms">
                            <option></option>
                            @foreach(\App\Models\Center::all() as $c)
                            <option value="{{$c->id}}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="date">Session</label>
                        <select name="session" id="session" class="form-control show-tick ms">
                            <option></option>
                            <option value="0">Morning</option>
                            <option value="1">Evening</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 mt-4">
                    <span class="btn btn-primary btn-block" onclick="loadData();">Load</span>
                </div>

                <div class="col-md-4 add-section">
                    <input type="number" name="user_id" id="u_id" placeholder="number" class="form-control" min="1">
                </div>
                <div class="col-md-4 add-section">
                    <input type="number" name="milk_amount" id="m_amt" step="0.001" min="0.001" placeholder="Milk in liter" class="form-control">
                </div>

                <div class="col-md-4 add-section">
                    <span class="btn btn-primary btn-block" onclick="saveDate();">Save</span>
                </div>

            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5">
                    <table id="newstable1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#No</th>
                                <th>Morning Milk (In Liter)</th>
                                <th>Evening Milk (In Liter)</th>
                            </tr>
                        </thead>
                        <tbody id="milkDataBody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="defaultModalLabel">
                    The Milk Data for Farmer Has Been Already Added, Please Choose From Following Actions.
                </h4>
            </div>
             <div class="modal-footer">
                <button class="btn btn-primary" onclick="savedefault(0)">Update Current Data</button>
                <button class="btn btn-primary" onclick="savedefault(1)">Add To Current Data</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div> 
        </div>
    </div>
</div>
<!-- end modal -->

@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    // $('#defaultModal').modal('show');
    $('.add-section').hide();
    // $( "#x" ).prop( "disabled", true );
    initTableSearch('sid', 'farmerData', ['name']);
    function savedefault(type){
        var url='{{ route("store.milk",["type"=>0])}}';
        if(type==1){
            url='{{ route("store.milk",["type"=>1])}}';
        }
        var id=$('#u_id').val();
        var amount=$('#m_amt').val();
        var session =$('#session').val();
        var fdata = new FormData(document.getElementById('milkData'));
        // store.milk
        axios({
                method: 'post',
                url:url,
                data: fdata,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response.data);
                showNotification('bg-success', 'Milk data added Successfully !');
                $('#u_id').val('');
                $('#m_amt').val('');
                
                if(session==0){
                        document.querySelector('#milk-'+id).dataset.m_amount=response.data.m_amount;
                        $('#m_milk-'+id).text(response.data.m_amount);
                }else{
                        document.querySelector('#milk-'+id).dataset.e_amount=response.data.e_amount;
                        $('#e_milk-'+id).text(response.data.e_amount);
                }
                $('#defaultModal').modal('hide');
               
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }
        
    
    function saveDate() {
        if($('#u_id').val()==""){
            alert('Please enter farmer number');
            $('#u_id').focus();
        }else if($('#m_amt').val()==""){
            alert('Please enter milk amout');
            $('#m_amt').focus();
        }else{
            var id=$('#u_id').val();
            var amount=$('#m_amt').val();
            var session =$('#session').val();
            // alert(document.querySelectorAll('#milk-'+id).length);
            // return;
            if(document.querySelectorAll('#milk-'+id).length>0){
                m_milk=document.querySelector('#milk-'+id).dataset.m_amount;
                e_milk=document.querySelector('#milk-'+id).dataset.e_amount;
                if(session==0){
                    if(m_milk>0){
                        $('#defaultModal').modal('show');
                        return;
                    }
                }else{
                    if(e_milk>0){
                        $('#defaultModal').modal('show');
                        return;
                    }
                }
            }
        var fdata = new FormData(document.getElementById('milkData'));
        // store.milk
        axios({
                method: 'post',
                url: '{{ route("store.milk",["type"=>0])}}',
                data: fdata,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response.data);
                showNotification('bg-success', 'Milk data added Successfully !');
                $('#u_id').val('');
                $('#m_amt').val('');
                if(document.querySelectorAll('#milk-'+id).length>0){
                    if(session==0){
                        document.querySelector('#milk-'+id).dataset.m_amount=response.data.m_amount;
                        $('#m_milk-'+id).text(response.data.m_amount);
                    }else{
                        document.querySelector('#milk-'+id).dataset.e_amount=response.data.e_amount;
                        $('#e_milk-'+id).text(response.data.e_amount);
                    }
                }else{
                    $('#milkDataBody').prepend(response.data);
                }
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
        }
    }

    function loadData() {
        if ($('#nepali-datepicker').val() == '' || $('#center_id').val() == '' || $('#session').val() == '') {
            alert('Please fill empty field !');
            if ($('#nepali-datepicker').val() == '') {
                $('#nepali-datepicker').focus();
                return false;
            } else if ($('#center_id').val() == '') {
                $('#center_id').focus();
                return false;
            } else {
                $('#session').focus();
                return false;
            }
        } else {
           
            var fdata = new FormData(document.getElementById('milkData'));
            // store.milk
            $('.add-section').show();
            axios({
                    method: 'post',
                    url: '{{ route("load.milk.data")}}',
                    data: fdata,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#milkDataBody').empty();
                    $('#milkDataBody').append(response.data);
                })
                .catch(function(response) {
                    //handle error
                    console.log(response);
                });
        }
    }

    window.onload = function() {
        var mainInput = document.getElementById("nepali-datepicker");
        mainInput.nepaliDatePicker();
    };
</script>
@endsection