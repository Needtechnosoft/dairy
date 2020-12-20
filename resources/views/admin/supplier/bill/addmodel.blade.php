<!-- modal -->

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg " style="margin:0px; max-width:1920px !important;" role="document">
        <div class="modal-content" style="height: 100vh;">
            <div class="modal-header mb-2">
                <h4 class="title" id="largeModalLabel">Create Supplier Bill</h4>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">X</button>
            </div>
            <div class="card">
                <div class="body">
                    <form id="form_validation" method="POST" onsubmit="return saveData(event);">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-lg-12 mb-4">
                                        <label for="name">Choose Supplier</label>
                                        <select name="user_id" id="supplier" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                            <option></option>
                                            @foreach(\App\Models\User::where('role',3)->get() as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="name">Bill No.</label>
                                        <div class="form-group">
                                            <input type="text" id="billno" name="billno" class="form-control" placeholder="Enter supplier bill no." required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="text" name="date" id="nepali-datepicker" class="form-control" placeholder="Date" required>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="ptr"> Particular Items </label>
                                            <select name="" id="ptr" class="form-control show-tick ms select2" data-placeholder="Select">
                                                <option></option>
                                                @foreach(\App\Models\Item::all() as $i)
                                                    <option value="{{ $i->id}}"> {{ $i->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="margin-top: 26px;">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#createItems">Create New Item</button>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="from-group">
                                            <label for="rate"> Rate </label>
                                            <input type="number" onkeyup="singleItemTotal();" class="form-control" id="rate" value="0" min="0.001" step="0.001">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="from-group">
                                            <label for="qty"> Quantity </label>
                                            <input type="number" onkeyup="singleItemTotal();" class="form-control" id="qty" value="1" min="0.001" step="0.001">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="from-group">
                                            <label for="rate"> Total </label>
                                            <input type="number" class="form-control" id="total" value="0" min="0.001" step="0.001">
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="margin-top: 26px;">
                                        <div class="from-group">
                                            <span class="btn btn-primary btn-block" onclick="addItems();">Add Item</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <input type="hidden" name="counter" id="counter" val=""/>
                                    <div class="col-md-12 mt-4 mb-3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Particular</th>
                                                    <th>Rate</th>
                                                    <th>Qty</th>
                                                    <Th>Total</Th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="item_table">

                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-end">
                                            <div style="margin-top: 4px; margin-right: 5px;"><strong> Item Total :</strong></div>
                                            <input type="text" value="0" id="itotal">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="trp">Transportation Charge</label>
                                            <input type="number" name="t_charge" class="form-control" step="0.001" min="0" placeholder="Enter transportation charge" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total">Total Amount</label>
                                            <input type="number" name="total" class="form-control" step="0.001" min="0" placeholder="Enter total bill amount" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total">Paid Amount</label>
                                            <input type="number" name="paid" class="form-control" step="0.001" min="0" placeholder="Enter paid amount" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-raised btn-primary waves-effect btn-block" type="submit">Submit Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
