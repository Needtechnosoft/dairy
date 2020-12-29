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
<h2 style="text-align: center;margin-bottom:0px;font-weight:800;font-size:2rem;">
    NawaDurga Dairy Udyog
</h2>

<div style="display: flex;justify-content: space-between;font-weight:800;">
    <span>
        Year : {{$year}}

    </span>
    <span>
        Month : {{$month}}
    </span>
    <span>
        Session : {{$session}}
    </span>
    <span>
        Center : {{$center->name}}
    </span>
</div>
<form action="{{route('report.farmer.session')}}" method="POST">
    <input type="hidden" name="year" value="{{$year}}" >
    <input type="hidden" name="month" value="{{$month}}" >
    <input type="hidden" name="session" value="{{$session}}" >
    <input type="hidden" name="center_id" value="{{$center->id}}" >
    @php


    @endphp
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Milk (l)</th>
                <th>Snf%</th>
                <th>Fat%</th>
                <th>Price/l</th>
                <th>Total</th>
                @if (env('hasextra',0)==1)
                    <th>
                        Bonus ( {{ round($center->bonus,2) }} % )
                    </th>

                @endif
                <th>Due</th>
                <th>Avance</th>
                <th>
                    Prev Due
                </th>
                <th>Net Total</th>
                <th>Due Balance</th>
                @if (env('hasextra',0)==0)
                    <th>Signature</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @csrf
            @foreach ($data as $farmer)
                <tr>
                    <td>
                        {{$farmer->no}}
                        @php
                        $tt=$farmer->total-$farmer->advance-$farmer->due-$farmer->prevdue+$farmer->bonus;
                        $farmer->balance=$tt<0?(-1*$tt):0;
                        $farmer->nettotal=$tt>0?$tt:0;
                        @endphp
                        @if ($farmer->old==false)
                            <input type="hidden" name="farmers[]" value="{{$farmer->toJson()}}" >
                        @endif
                    </td>
                    @php
                        $t='farmer-'.$farmer->id;
                    @endphp

                    <td>
                        {{$farmer->name}}
                    </td>
                    <td>
                        {{($farmer->milk)}}
                        {{-- <input type="hidden" name="milk[{{$t}}]" value="{{($farmer->m_milk+$farmer->e_milk)}}" > --}}

                    </td>
                    <td>
                        {{$farmer->snf}}
                        {{-- <input type="hidden" name="snf[{{$t}}]" value="{{($farmer->snf)}}" > --}}

                    </td>
                    <td>
                        {{$farmer->fat}}
                        {{-- <input type="hidden" name="fat[{{$t}}]" value="{{($farmer->fat)}}" > --}}

                    </td>
                    <td>
                        {{$farmer->rate}}
                        {{-- <input type="hidden" name="rate[{{$t}}]" value="{{($farmer->rate)}}" > --}}

                    </td>
                    <td>
                        {{$farmer->total}}
                        {{-- <input type="hidden" name="total[{{$t}}]" value="{{($farmer->total)}}" > --}}

                    </td>
                    @if(env('hasextra',0)==1)
                        <td>
                             {{ $farmer->bonus??0}}
                        </td>

                    @endif
                    <td>
                        {{$farmer->due}}
                        {{-- <input type="hidden" name="due[{{$t}}]" value="{{($farmer->due)}}" > --}}

                    </td>
                    <td>
                        {{$farmer->advance}}
                        {{-- <input type="hidden" name="advance[{{$t}}]" value="{{($farmer->advance)}}" > --}}
                    </td>
                    <td>
                        {{$farmer->prevdue}}
                        {{-- <input type="hidden" name="prevdue[{{$t}}]" value="{{($farmer->prevdue)}}" > --}}
                    </td>

                    <td>
                        {{$farmer->nettotal}}
                        {{-- <input type="hidden" name="nettotal[{{$t}}]" value=" {{$tt>0?$tt:0}}" > --}}
                    </td>
                    <td>
                        {{$farmer->balance}}
                        {{-- <input type="hidden" name="balance[{{$t}}]" value=" {{$tt<0?(-1*$tt):0}}" > --}}
                    </td>
                    @if (env('hasextra',0)==0)
                    <td>
                        @if ($farmer->old)
                           Already Taken
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach

        </tbody>
    </table>
    <div class="py-2">
        <input type="submit" value="Update Session Data" class="btn btn-success">
    </div>
</form>



