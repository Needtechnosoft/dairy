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
            <th>Due</th>
            <th>Avance</th>
            <th>
                Prev Due
            </th>
            <th>Net Total</th>
            <th>Balance</th>
            <th>Signature</th>
        </tr>
    </thead>
    <tbody>
        <form action="">
            @foreach ($data as $farmer)
                <tr>
                    <td>
                        {{$farmer->no}}
                        <input type="hidden" name="ids[]" value="{{$farmer->id}}" >
                    </td>
                    @php
                        $t='farmer_'.$farmer->id;
                    @endphp
                    <td>
                        {{$farmer->name}}
                    </td>
                    <td>
                        {{($farmer->m_milk+$farmer->e_milk)}}
                        <input type="hidden" name="milk.{{$t}}" value="{{($farmer->m_milk+$farmer->e_milk)}}" >

                    </td>
                    <td>
                        {{$farmer->snf}}
                        <input type="hidden" name="snf.{{$t}}" value="{{($farmer->snf)}}" >

                    </td>
                    <td>
                        {{$farmer->fat}}
                        <input type="hidden" name="fat.{{$t}}" value="{{($farmer->fat)}}" >

                    </td>
                    <td>
                        {{$farmer->rate}}
                        <input type="hidden" name="rate.{{$t}}" value="{{($farmer->rate)}}" >

                    </td>
                    <td>
                        {{$farmer->total}}
                        <input type="hidden" name="total.{{$t}}" value="{{($farmer->total)}}" >

                    </td>
                    <td>
                        {{$farmer->due}}
                        <input type="hidden" name="due.{{$t}}" value="{{($farmer->due)}}" >

                    </td>
                    <td>
                        {{$farmer->advance}}
                        <input type="hidden" name="advance.{{$t}}" value="{{($farmer->advance)}}" >
                    </td>
                    <td>
                        {{$farmer->prevdue}}
                        <input type="hidden" name="prevdue.{{$t}}" value="{{($farmer->prevdue)}}" >
                    </td>
                        @php
                            $t=$farmer->total-$farmer->advance-$farmer->due-$farmer->prevdue;
                        @endphp
                    <td>
                        {{$t>0?$t:0}}
                        <input type="hidden" name="nettotal.{{$t}}" value="{{($farmer->nettotal)}}" >
                    </td>
                    <td>
                        {{$t<0?(-1*$t):0}}
                        <input type="hidden" name="balance.{{$t}}" value="{{($farmer->balance)}}" >
                    </td>
                    <td></td>
                </tr>
            @endforeach
        </form>
    </tbody>
</table>



