<div class="container-fluid">
    <div class="card ">
        <img src="{{asset($menu->image_url)}}" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">{{$menu->name}}</h5>
            <p class="card-text truncate">{{$menu->description}}</p>
            <div class="form-group">
            </div>
            <div class="row">
                <div class="col-md-2"><label class="control-label">Qty</label></div>
                <div class="input-group col-md-7 mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" id="qty-minus"><span
                                class="fa fa-minus"></span></button>
                    </div>
                    <input type="number" readonly value="{{$qty}}" min=1 class="form-control text-center" name="qty_order">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-dark" type="button" id="qty-plus"><span
                                class="fa fa-plus"></span></button>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-outline-dark btn-sm btn-block" id="add_to_cart_modal"><i
                        class="fa fa-cart-plus"></i> Add to Cart
                </button>
            </div>
        </div>

    </div>
</div>
<style>
    #uni_modal_right .modal-footer {
        display: none;
    }
</style>

<script>
    $('#qty-minus').click(function () {
        var qty = $('input[name="qty_order"]').val();
        if (qty == 1) {
            return false;
        } else {
            $('input[name="qty_order"]').val(parseInt(qty) - 1);
        }
    })
    $('#qty-plus').click(function () {
        var qty = $('input[name="qty_order"]').val();
        $('input[name="qty_order"]').val(parseInt(qty) + 1);
    })
    $('#add_to_cart_modal').click(function () {
        $.ajax({
            url: '{{route('cart.add-item')}}',
            method: 'POST',
            data: {mid: {{$menu->id}}, qty: $('[name="qty_order"]').val(),_token:'{{csrf_token()}}'},
            success: function (resp) {
                console.log(resp)
                if (resp)
                    notify(resp.status||'success',resp.message||"Order successfully added to cart")
                $('.item_count').html(parseInt($('.item_count').html()) + parseInt($('[name="qty_order"]').val()))
                $('.modal').modal('hide')
            },
            error: function (xhr, status, error) {
                console.log(xhr)
                notify('error',"Err "+status)
                console.log(status)
                console.log(error)
            }
        })
    })
</script>
