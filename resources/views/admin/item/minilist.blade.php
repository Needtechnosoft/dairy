<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item Number</th>
                <th>Item Name</th>
            </tr>
        </thead>
        <tbody id="itemData">
            @foreach(\App\Models\Item::get() as $i)
            <tr id="item-{{ $i->id }}" data-rate="{{$i->sell_price}}" data-number="{{ $i->number }}" onclick="itemId({{ $i->id }});">
                <td class="p-1"><span style="cursor: pointer;">{{ $i->number }}</span></td>
                <td class="p-1"><span style="cursor: pointer;">{{ $i->title }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
