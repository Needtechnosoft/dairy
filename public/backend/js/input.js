$(".next").keydown(function(event){
    var key = (event.keyCode ? event.keyCode : event.which);
    if(key=='13'){
        event.preventDefault()
        id=$(this).data('next');
        $('#'+id).focus();
    }
});

$('.modal').each(function(){
    _id=$(this).data('ff');
    console.log(_id);
    $(this).on('shown.bs.modal', function (e) {
        _id=$(this).data('ff');
        console.log('shown',_id);
        $('#'+_id).focus();
    });
});

$('.href').click(function(){
    window.location.href=$(this).data('target');
});

function exists(selector){
    return $(selector).length > 0;
}

$('.checkfarmer').focusout(function(){
    no=$(this).val();
    if(no!=""){
        if(!exists('#farmer-'+no)){
            alert('Farmer with farmer no-'+no+' doesnot exist;')
            $(this).focus();
            $(this).select();
        }
    }
});

function CheckFarmer(no){
    return exists('#farmer-'+no);
}

$('connectmax').change(function(){
    connected=$(this).data('connected');
    $('#'+connected).attr('max',$(this).val());
});




$('.checkitem').focusout(function(){
    id=$(this).val();
    console.log('running',id);
    if(id!=""){

        if(!exists('#item-'+id)){
            alert('Farmer with farmer no-'+id+' doesnot exist;')
            $(this).focus();
            $(this).select();
        }else{
            rate_id=$(this).data('rate');
            rate=$('#item-'+id).data('rate');
            $('#'+rate_id).val(rate);
        }
    }
});

function CheckItem(id){
    return exists('#item-'+id);
}
