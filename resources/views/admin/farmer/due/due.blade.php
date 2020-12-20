<div class="row mt-4">
<div class="col-md-12">
    <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
        <strong>Farmer Due Details</strong>
        <hr>
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
            <tr>
                <th>Date</th>
                <th>Item</th>
                <th>Due (Rs.)</th>
            </tr>
            @php
                $total = 0;
            @endphp
              @if (count($due) == 0)
                  <tr>
                      <td colspan="3" class="text-center">No any due data</td>
                  </tr>
              @endif
            @foreach ($due as $d)
                <tr>
                    <td>{{ _nepalidate($d->date) }}</td>
                    <td>{{ $d->item->title }}</td>
                    <td>{{ $d->due }}</td>
                </tr>
                @php
                    $total += $d->due;
                @endphp
            @endforeach
        </table>
    </div>
</div>
</div>

<div class="mt-4" style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
<div class="row">
    <div class="col-md-4">
        <label for="date">Date</label>
        <input readonly type="text" name="date" id="nepali-datepicker" class="form-control" placeholder="Date">
    </div>
    <div class="col-md-4">
        <label for="total"> Total Due </label>
        <input type="text" class="form-control" value="{{ $total }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="pay">Pay Amount </label>
        <input type="text" class="form-control" id="p_amt" name="pay" min="0" step="0.001" value="0">
    </div>
    <div class="col-md-9 mt-1">
        <label for="detail">Payment Detail</label>
        <input type="text" class="form-control" id="detail" placeholder="Payment details">
    </div>
    <div class="col-md-3">
        <span class="btn btn-primary btn-block" style="margin-top:35px;" onclick="duePayment();"> Pay Now </span>
    </div>
  </div>
</div>
