<div class="cc2">
    <div class="" role="document">
        <div class="" style="background-color: white; border-radius: 10px;">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Edit Expense</h4>
            </div>
            <div class="card">
                <div class="body">
                    <form id="editform" onsubmit="return editData(event);">
                        @csrf
                        <input type="hidden" name="id" id="eid">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Date</label>
                                <div class="form-group">
                                    <input type="text" name="date" id="editdate" class="form-control next" data-next="ecat_id" placeholder="Date" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Expense Category</label>
                                <div class="form-group">
                                    <select name="cat_id" id="ecat_id" class="form-control show-tick ms select2 next" data-next="etitle" data-placeholder="Select">
                                        <option ></option>
                                        @foreach (\App\Models\Expcategory::get() as $item)
                                            <option value="{{ $item->id }}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
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
                <button type="button" class="btn btn-danger waves-effect" onclick="ccswitch();">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
