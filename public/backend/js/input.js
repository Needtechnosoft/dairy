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