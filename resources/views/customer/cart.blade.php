@extends('layouts.main')
@section('styles')
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <style>

        header.masthead {
            background: url({{asset('assets/images/img/main.jpg')}});
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            position: relative;
            height: 85vh !important;
        }

        header.masthead:before {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            backdrop-filter: brightness(0.8);
        }

        .page-title > h1 {
            text-shadow: 0px 0px 5px #000 !important;
            font-family: 'Dancing Script', cursive !important;
            font-size: 4em !important;
        }
    </style>
    <style>
        .card p {
            margin: unset
        }
        .card img{
            max-width: calc(100%);
            max-height: calc(59%);
        }
        div.sticky {
            position: -webkit-sticky; /* Safari */
            position: sticky;
            top: 4.7em;
            z-index: 10;
            background: white
        }
        .rem_cart{
            position: relative;
            left: 0;
        }
    </style>


@endsection
@section('content')
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-center mb-4 page-title">
                    <h1 class="text-white">Your Shopping Cart</h1>
                    <hr class="divider my-4 bg-dark"/>
                </div>

            </div>
        </div>
    </header>

    <div class="top-links">
        <div class="container">
            <ul class="row links">
                <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a
                        href="{{ route('customer.restaurants') }}">Choose Restaurant</a>
                </li>
                <li class= "col-xs-12 col-sm-4 link-item "><span>2</span><a
                        href="#">Pick Your favorite food</a></li>
                <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="#">Order and Pay</a></li>
            </ul>
        </div>
    </div>

    <div class="breadcrumb">
        <div class="container">

        </div>
    </div>

    <section class="page-section" id="menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="sticky">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8 fw-bolder"><b>Items</b></div>
                                    <div class="col-4 text-right fw-bolder">Total</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @forelse($cart->items as $item)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 d-flex align-items-center" style="text-align: -webkit-center">
                                        <div class="col-auto">
                                            <a href="{{route('cart.destroy-item',$item->id)}}" class="rem_cart p-2 btn btn-sm btn-outline-danger" data-id="{{$item->id}}"><i class="fa fa-trash"></i></a>
                                        </div>
                                        <div class="col-auto p-3 flex-shrink-1 flex-grow-1 text-center">
                                            <img src="{{$item->menu->image_url}}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="fw-bolder"><large>{{$item->menu->name}}</large></p>
                                        <p class='truncate '><small><span class="fw-bolder"> Desc: </span>{{$item->menu->description}}</small></p>
                                        <p class="fw-bolder">Unit Price :{{number_format($item->menu->price,2)}}</p>
                                        <p class="text-muted fw-bolder">QTY :</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary qty-minus" type="button"   data-id="{{$item->id}}"><span class="fa fa-minus"></span></button>
                                            </div>
                                            <input type="number" readonly value="{{$item->quantity}}" min = 1 class="form-control text-center" name="qty" >
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary qty-plus" type="button" id=""  data-id="{{$item->id}}"><span class="fa fa-plus"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-right fw-bolder">
                                        <large>{{number_format($item->menu->price*$item->quantity,2)}}</large>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $total+=$item->menu->price*$item->quantity; ?>
                    @empty
                        <h2>Empty Cart. <a class="link link-success" href="{{ route('customer.restaurants') }}">Start Shopping</a> </h2>
                    @endforelse

                </div>
                <div class="col-md-4">
                    <div class="sticky">
                        <div class="card  fw-bolder">
                            <div class="card-title pt-1">Total Amount</div>
                            <div class="card-body mt-3">
                                <p class="text-right">{{number_format($total,2)}}</p>
                                <hr>
                                <div class="text-center">
                                    @if($total>0)
                                        <button class="btn btn-outline-secondary" type="button" id="checkout">Proceed to Checkout</button>
                                        <a class="btn btn-outline-danger" href="{{ route('cart.empty-cart') }}" >Empty Cart</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')

    <script>

        $('.qty-minus').click(function(){
            var qty = $(this).parent().siblings('input[name="qty"]').val();
            if(qty == 1){
                return false;
            }
            update_qty(parseInt(qty) -1,$(this).attr('data-id'),$(this).parent().siblings('input[name="qty"]'),parseInt(qty) -1);

        })
        $('.qty-plus').click(function(){
            var qty =  $(this).parent().siblings('input[name="qty"]').val();
            update_qty(parseInt(qty) +1,$(this).attr('data-id'),$(this).parent().siblings('input[name="qty"]'),parseInt(qty) +1)
        })
        function update_qty(qty,id,input=null,val=null){
            start_load()
            $.ajax({
                url:'{{route('cart.update-quantity')}}',
                method:"POST",
                data:{id:id,qty:qty,_token:'{{csrf_token()}}'},
                success:function(resp){
                    if(resp == 1){
                        window.location.reload()
                        if(input)
                            input.val(val)
                    }
                },
                error:function (qhr,Status,msg){
                    console.error(qhr);
                    end_load()
                    notify('error',"Err "+status)

                }
            })

        }
        $('#checkout').click(function(){
            if({{auth()->id()}}){
                uni_modal("Confirm Delivery Information","{{route('cart.checkout')}}")
            }else{
                uni_modal("Confirm Delivery Information","{{route('cart.checkout')}}")
            }
        })


    </script>

@endsection

