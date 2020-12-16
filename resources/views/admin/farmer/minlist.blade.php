<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Farmer Name</th>
            </tr>
        </thead>
        <tbody id="farmerData">
            @foreach(\App\Models\User::where('role',1)->get() as $u)
            <tr id="farmer-{{ $u->no }}" data-name="{{ $u->name }}" onclick="farmerId({{ $u->no }});">
                <td class="p-1"><span style="cursor: pointer;">{{ $u->no }}</span></td>
                <td class="p-1"> <span style="cursor: pointer;">{{ $u->name }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
