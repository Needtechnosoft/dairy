
<div class="row mt-5">
    <div class="col-md-6">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Milk Data</strong>
            <hr>
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <tr>
                    <th>Date</th>
                    <th>Morning (Liter)</th>
                    <th>Evening (liter)</th>
                </tr>
                @php
                    $m = 0;
                    $e = 0;
                @endphp
                    @foreach ($milkData as $milk)
                      <tr>
                          <td>{{ _nepalidate($milk->date) }}</td>
                          <td>{{ $milk->m_amount }}</td>
                          <td>{{ $milk->e_amount }}</td>
                      </tr>
                      @php
                          $m += $milk->m_amount;
                          $e += $milk->e_amount;
                      @endphp
                    @endforeach
                    <tr>
                        <td><strong>Total</strong></td>
                        <td>{{ $m }}</td>
                        <td>{{ $e }}</td>
                    </tr>
            </table>
                <strong>Grand Total : {{ $m + $e }}</strong> (Liter) <br>
        </div>
    </div>
    <div class="col-md-6">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Snf & Fats </strong>
            <hr>
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <tr>
                    <th>Date</th>
                    <th>Snf (%)</th>
                    <th>Fats (%)</th>
                </tr>
                    @foreach ($snfFats as $sf)
                        <tr>
                           <td>{{ _nepalidate($sf->date) }}</td>
                            <td>{{ $sf->snf }}</td>
                            <td>{{ $sf->fat }}</td>
                        </tr>

                    @endforeach
            </table>
            <div class="row">
                <div class="col-md-7">
                    <strong>Snf Average : {{ round($snfAvg,2) }}</strong> <br> <br>
                    <strong>Per Liter Rate : {{ round($perLiterAmount,2) }} (Rs.)</strong> <br>
                    <strong>Total Amount : {{ round(($m + $e) * $perLiterAmount,2) }} (Rs.)</strong>
                </div>
                <div class="col-md-5">
                    <strong>Fat Average : {{ round($fatAvg,2) }}</strong>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Sold Items</strong>
            <hr>
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <tr>
                    <th>Date</th>
                    <th>Item Name</th>
                    <th>Item Number</th>
                    <th>Rate</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                </tr>
                   @php
                       $total = 0;
                       $paid = 0;
                       $due = 0;
                   @endphp
                   @foreach ($sellitem as $item)
                   <tr>
                       <td>{{ _nepalidate($item->date)}}</td>
                       <td>{{ $item->item->title }}</td>
                       <td>{{ $item->item->title }}</td>
                       <td>{{ $item->rate }}</td>
                       <td>{{ $item->qty }}</td>
                       <td>{{ $item->total }}</td>
                       <td>{{ $item->paid }}</td>
                       <td>{{ $item->due }}</td>
                   </tr>
                       @php
                           $total += $item->total;
                           $paid += $item->paid;
                           $due += $item->due;
                       @endphp
                   @endforeach
                    <tr>
                        <td colspan="7" class="text-right">Grand Total</td>
                        <td>{{ $total }}</td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-right">Total Paid</td>
                        <td> {{ $paid }}</td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-right">Total Due</td>
                        <td>{{ $due }}</td>
                    </tr>
            </table>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Ledger</strong>
            <hr>
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <tr>
                    <th>Date</th>
                    <th>Particular</th>
                    <th>Cr. (Rs.)</th>
                    <th>Dr. (Rs.)</th>
                    <th>Balance (Rs.)</th>
                </tr>

                @foreach ($ledger as $l)
                    <tr>
                        <td>{{ _nepalidate($l->date) }}</td>
                        <td>{{ $l->title }}</td>

                        <td>
                            @if ($l->type==1)
                                {{ $l->amount }}
                            @endif
                        </td>
                        <td>
                            @if($l->type==2)
                              {{ $l->amount }}
                            @endif
                        </td>
                        <td>
                            {{ $l->dr == null?"":"Dr. ".$l->dr }}

                            {{ $l->cr == null?"--":"Cr. ".$l->cr }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
