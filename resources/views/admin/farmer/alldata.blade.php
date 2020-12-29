
<hr>
<div id="print" class="p-2">
    <div class="p-3">
        <div style="font-weight: 800" class="d-flex justify-content-start">
            <span class="mr-4">
                Farmer No : {{$farmer1->no}}
            </span>
            <span class="mr-4">

                 Name : {{$farmer1->name}}
            </span>
            <span class="mr-4">
                Phone no : {{$farmer1->phone}}
            </span>
        </div style="font-weight: 800">
        <div style="font-weight: 800" class="d-flex justify-content-start">
            <span class="mr-4">

                Year : {{$data['year']}}
            </span>
            <span class="mr-4">

                Month : {{$data['month']}}
            </span>
            <span class="mr-4">

                Session : {{$data['session']}}
            </span>
        </div style="font-weight: 800">
    </div>
    <div class="row ">
        <div class="col-md-6">
            <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
                {{-- <button class="btn btn-success" onclick="printDiv('milk-data');">Print</button> --}}
                <div id="milk-data">
                    <style>
                        td,th{
                            border:1px solid black;
                        }
                        table{
                            width:100%;
                            border-collapse: collapse;
                        }
                        thead {display: table-header-group;}
                        tfoot {display: table-header-group;}
                    </style>
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

        </div>
        <div class="col-md-6">
            <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">

                <div id="snffat-data">
                    <style>
                        td,th{
                            border:1px solid black;
                        }
                        table{
                            width:100%;
                            border-collapse: collapse;
                        }
                        thead {display: table-header-group;}
                        tfoot {display: table-header-group;}
                    </style>
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
                    <div style="display: flex">
                        <div style="flex:7;padding:10px;">
                            <strong>Snf Average : {{ round($snfAvg,2) }}</strong> <br> <br>
                            <strong>Per Liter Rate : {{ round($perLiterAmount,2) }} (Rs.)</strong> <br>
                            <strong>Total Amount : {{ round(($m + $e) * $perLiterAmount) }} (Rs.)</strong>
                        </div>
                        <div style="flex:5;padding:10px;">
                            <strong>Fat Average : {{ round($fatAvg,2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-12 mt-3">
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
        </div> --}}

        <div class="col-md-12 mt-3">
            <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">

                <div id="ledger-data">
                    <style>
                        td,th{
                            border:1px solid black;
                        }
                        table{
                            width:100%;
                            border-collapse: collapse;
                        }
                        thead {display: table-header-group;}
                        tfoot {display: table-header-group;}
                    </style>
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
    </div>
</div>


    <hr>
    <h5 class="font-weight-bold">
        Session Summary
    </h5>
    <hr>

    <div class="report p-2">
        <table class="table">
            <tr>
                <th>
                    Snf
                </th>
                <th>
                    Fat
                </th>
                <th>
                    Rate
                </th>
                <th>
                    Milk Amount
                </th>
                <th>
                    Total
                </th>
                <th>Due</th>
                <th>Avance</th>
                <th>
                    Prev Due
                </th>
                <th>Net Total</th>
                <th>Due Balance</th>
                <th>

                </th>
            </tr>
            <tr>
                <td>
                    {{ round($snfAvg,2) }}
                </td>
                <td>
                    {{ round($fatAvg,2) }}
                </td>
                <td>
                    {{ round($perLiterAmount,2) }}
                </td>
                <td>
                    {{ $m + $e }}
                </td>
                <td>
                    {{ round(($m + $e) * $perLiterAmount) }}
                </td>
                <td>
                    {{$farmer1->due}}
                </td>
                <td>
                    {{$farmer1->advance}}
                </td>
                <td>
                    {{$farmer1->prevdue}}
                </td>
                @php
                    $tt=round(($m + $e) * $perLiterAmount)-$farmer1->advance-$farmer1->due-$farmer1->prevdue;
                    $balance=$tt<0?(-1*$tt):0;
                    $nettotal=$tt>0?$tt:0;
                @endphp
                <td>
                    {{$nettotal}}
                </td>
                <td>
                    {{$balance}}
                </td>
                <td>
                    @if ($farmer1->old==false)
                    <form action="{{route('report.farmer.single.session')}}" method="POST">
                        @csrf
                        <input type="hidden" name="year" value="{{$data['year']}}">
                        <input type="hidden" name="month" value="{{$data['month']}}">
                        <input type="hidden" name="session" value="{{$data['session']}}">
                        <input type="hidden" name="id" value="{{$farmer1->id}}">
                        <input type="hidden" name="snf" value="{{ round($snfAvg,2) }}">
                        <input type="hidden" name="fat" value="{{ round($fatAvg,2) }}">
                        <input type="hidden" name="rate" value=" {{ round($perLiterAmount,2) }}">
                        <input type="hidden" name="milk" value="{{ $m + $e }}">
                        <input type="hidden" name="total" value=" {{ round(($m + $e) * $perLiterAmount) }}">
                        <input type="hidden" name="due" value=" {{ $farmer1->due}}">
                        <input type="hidden" name="advance" value=" {{ $farmer1->advance }}">
                        <input type="hidden" name="prevdue" value=" {{ $farmer1->prevdue}}">
                        <input type="hidden" name="nettotal" value=" {{ $nettotal }}">
                        <input type="hidden" name="balance" value=" {{ $balance}}">
                        <button class="btn btn-sm btn-success">Close Session</button>
                    </form>
                    @else
                        Session Closed
                    @endif
                </td>
            </tr>
        </table>
    </div>
