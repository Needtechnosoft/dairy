<tr id="procat-{{$cat->id}}" >
    <form action="">
        <td><input type="text" id="title-{{$cat->id}}" name="title" placeholder="Title" value="{{ $cat->name }}" required> </td>

        <td>
            <span  type="button" class="btn btn-primary btn-sm" onclick="editData({{ $cat->id }});" >Edit</span>
            |
            <button class="btn btn-danger btn-sm" onclick="removeData({{$cat->id}});">Delete</button>
        </td>
    </form>
</tr>
