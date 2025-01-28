window.start_load = function(){
    $('body').prepend('<di id="preloader2"></di>')
}
window.end_load = function(){
    $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
    })
}

window.uni_modal = function($title = '' , $url=''){
    start_load()
    $.ajax({
        url:$url,

        error:function(qhr,status,msg){
            console.error(qhr);
            end_load()

            notify('error',"Err "+status)
        },
        success:function(resp){
            if(resp.modal){
                $('#uni_modal .modal-title').html($title)
                $('#uni_modal .modal-body').html(resp.modal)
                $('#uni_modal').modal('show')
            }
            end_load()

            notify(resp.status,resp.message)

        }
    })
}
window.uni_modal_right = function($title = '' , $url=''){
    start_load()
    $.ajax({
        url:$url,
        error:function(Xhr,st,s3){
            console.log(Xhr)
            end_load()
            notify('error',"Err "+st)
        },
        success:function(resp){
            if(resp.modal){
                $('#uni_modal_right .modal-title').html($title)
                $('#uni_modal_right .modal-body').html(resp.modal)
                $('#uni_modal_right').modal('show')
            }
            end_load()

            notify(resp.status,resp.message)

        }
    })
}
window.alert_toast= function($msg = 'TEST',$bg = 'success'){
    alert("Replace this alert\n"+$msg)
}
window.load_cart = function(){
    $.ajax({
        url:'admin/ajax.php?action=get_cart_count',
        success:function(resp){
            if(resp > -1){
                // resp = resp ;
                $('.item_count').html(resp)
            }
        }
    })
}
