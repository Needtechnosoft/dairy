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
                Prev Due
            </th>
            <th>
                Prev Advance
            </th>
            <th>
                Total
            </th>
            <th>
                Paid
            </th>
            <th>
                 Due
            </th>
            <th>
                 Advance
            </th>

        </tr>
        @php
            $totalQty=0;
            $total=0;
        @endphp
        @foreach ($elements as $data)
            @php
                $_data=(object)$data;
            @endphp
            <tr>
                <td>
                    {{$_data->id}}
                </td>
                <td>
                    {{$_data->name}}
                </td>
                <td>
                    {{(float)$_data->prevdue}}
                </td>
                <td>
                    {{(float)$_data->prevadvance}}
                </td>
                {{-- <td>
                    {{$_data->qty}}
                    @php
                        $totalQty+=$_data->qty;
                    @endphp
                </td> --}}
                <td>
                    {{(float)$_data->total}}
                    @php
                        $total+=$_data->total;
                    @endphp
                </td>
                <td>
                    {{(float)$_data->paid}}
                </td>
                <td>
                    {{(float)$_data->due??0}}
                </td>
                <td>
                    {{(float)$_data->advance??0}}
                </td>
            </tr>

        @endforeach

        {{-- <tr class="font-weight-bold">
            <td colspan="2" class="text-right">
                Total
            </td>
            <td>
                {{$totalQty}}
            </td>
            <td>
                {{$total}}
            </td>
        </tr> --}}
    </table>
</div>
