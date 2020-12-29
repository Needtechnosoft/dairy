<div class="b-1 mt-4 p-3">

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
    <table class="table">
        <tr>
            <th>
                No
            </th>
            <th>
                Name
            </th>
            <th>
                Milk (ℓ)
            </th>
            <th>
                Total (Rs.)
            </th>
        </tr>
        @php
            $totalQty=0;
            $total=0;
        @endphp
        @foreach ($data as $_data)
            <tr>
                <td>
                    {{$_data->id}}
                </td>
                <td>
                    {{$_data->name}}
                </td>
                <td>
                    {{$_data->qty}}
                    @php
                        $totalQty+=$_data->qty;
                    @endphp
                </td>
                <td>
                    {{$_data->total}}
                    @php
                        $total+=$_data->total;
                    @endphp
                </td>
            </tr>

        @endforeach

        <tr class="font-weight-bold">
            <td colspan="2" class="text-right">
                Total
            </td>
            <td>
                {{$totalQty}}
            </td>
            <td>
                {{$total}}
            </td>
        </tr>
    </table>
</div>
