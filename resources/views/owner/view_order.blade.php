<div class="container-fluid">

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Menu</th>
            <th>Qty</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{$item->menu->name}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->subtotal}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2" class="text-right">TOTAL</th>
            <th ><?php echo number_format($order->total_amount,2) ?></th>
        </tr>

        </tfoot>
    </table>
    <div class="text-center">
        @if($order->status=='pending')
            <button class="btn btn-primary" id="confirm" type="button" onclick="confirm_reject_order(1)">Prepare</button>
        @endif
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

    </div>
</div>
<style>
    #uni_modal .modal-footer{
        display: none
    }
</style>
<script>
    function confirm_reject_order(pid){
        start_load()
        $.ajax({
            url:'{{route("owner.confirm-order")}}',
            method:'POST',
            data:{id:'{{$order->id}}',pid:pid,_token:'{{csrf_token()}}'},
            success:function(resp){
                if(resp){
                    notify(resp.status||"success",resp.message||"Process completed")
                    setTimeout(function(){
                        location.reload()
                    },1500)
                }
            },
            error:function (xhr,status,message){
                console.log(xhr)
                end_load()
                notify('error',"Err "+status+" "+message)
            }
        })
    }
</script>
