<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#data-1" role="tab" aria-controls="home" aria-selected="true">Farmer Sales</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#data-2" role="tab" aria-controls="profile" aria-selected="false">Normal Sales</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#data-3" role="tab" aria-controls="contact" aria-selected="false">Distributor Sales</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="data-1" role="tabpanel" aria-labelledby="home-tab">
      <div class="py-3">
        <span class="btn btn-success" onclick="printDiv('table-1');"> Print Report</span>

      </div>
    <div id="table-1">
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

        <table >
            <thead>
                @php
                    $i=1;
                @endphp
                <tr>

                    <th>
                        SN
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Farmer
                    </th>
                    <th>
                        Item Name
                    </th>
                    <th>
                        Rate
                    </th>
                    <th>
                        Qty
                    </th>
                    <th>
                        Total
                    </th>
                    <th>
                        Due
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['sellitem'] as $sellitem)
                    <tr>
                        <td>
                            {{$i++}}
                        </td>
                        <td>
                            {{_nepalidate($sellitem->date)}}

                        </td>
                        <td>
                            {{$sellitem->name}} ( {{$sellitem->no}} )
                        </td>
                        <td>
                            {{$sellitem->title}}
                        </td>
                        <td>
                            {{$sellitem->rate}}
                        </td>
                        <td>
                            {{$sellitem->qty}}
                        </td>
                        <td>
                            {{$sellitem->total}}
                        </td>
                        <td>
                            {{$sellitem->due}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

  </div>
  <div class="tab-pane fade" id="data-2" role="data-2" aria-labelledby="profile-tab">...</div>
  <div class="tab-pane fade" id="data-3" role="data-3" aria-labelledby="contact-tab">
    <div class="py-3">
        <span class="btn btn-success" onclick="printDiv('table-3');"> Print Report</span>

      </div>
    <div id="table-3">
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

        <table >
            <thead>
                @php
                    $i=1;
                @endphp
                <tr>

                    <th>
                        SN
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Distributor
                    </th>

                    <th>
                        Rate
                    </th>
                    <th>
                        Qty
                    </th>
                    <th>
                        Total
                    </th>
                    <th>
                        Due
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['sellmilk'] as $sellmilk)
                    <tr>
                        <td>
                            {{$i++}}
                        </td>
                        <td>
                            {{_nepalidate($sellmilk->date)}}
                        </td>
                        <td>
                            {{$sellmilk->name}}
                        </td>

                        <td>
                            {{$sellmilk->rate}}
                        </td>
                        <td>
                            {{$sellmilk->qty}}
                        </td>
                        <td>
                            {{$sellmilk->total}}
                        </td>
                        <td>
                            {{$sellmilk->deu}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>
