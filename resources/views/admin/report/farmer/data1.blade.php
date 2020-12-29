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
<table>

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
                        {{$farmer->user->no}}

                    </td>
                    @php
                        $t='farmer-'.$farmer->user_id;
                    @endphp

                    <td>
                        {{$farmer->user->name}}
                    </td>
                    <td>
                        {{($farmer->milk)}}


                    </td>
                    <td>
                        {{$farmer->snf}}

                    </td>
                    <td>
                        {{$farmer->fat}}


                    </td>
                    <td>
                        {{$farmer->rate}}


                    </td>
                    <td>
                        {{$farmer->total}}


                    </td>
                    <td>
                        {{$farmer->due}}

                    </td>
                    <td>
                        {{$farmer->advance}}

                    </td>
                    <td>
                        {{$farmer->prevdue}}

                    </td>

                    <td>
                        {{$farmer->nettotal}}

                    </td>
                    <td>
                        {{$farmer->balance}}

                    </td>
                    @if (env('hasextra',0)==0)
                        <td></td>
                    @endif
                </tr>
            @endforeach

        </tbody>
    </table>




