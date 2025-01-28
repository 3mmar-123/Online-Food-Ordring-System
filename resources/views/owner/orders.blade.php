@extends('layouts.admin-main')
@section('styles')
@endsection
@section('content')

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="card card-outline-primary">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">All Orders</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Total Amount</th>
                                <th>Date Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orders as $order)
                                    <?php $order->del_info = json_decode($order->delivery_info); ?>
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <th>{{$order->del_info->name??$order->customer->name}}</th>
                                    <td>{{$order->del_info->address}}</td>
                                    <td>{{$order->del_info->phone}}</td>
                                    <td>{{$order->del_info->email}}</td>
                                    <td>{{$order->total_amount}}</td>
                                    <td>{{$order->order_date->diffForHumans()}}</td>
                                    <td>

                                        <div class="dropdown">
                                            <span class="btn badge badge-{{ $order->getStatusBadge()}}"
                                                  id="statusesDropdown" data-bs-toggle="dropdown"
                                                  aria-haspopup="true" aria-expanded="false">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                            <div class="dropdown-menu animated fadeIn"
                                                 aria-labelledby="statusesDropdown">
                                                <div class="dropdown-divider"></div>
                                                @if($order->status=='canceled'||$order->status=='rejected')
                                                    <a href="#" data-id="{{$order->id}}"
                                                       data-value="5" class="dropdown-item change-status">Remove</a>
                                                @elseif($order->status=='delivering')
{{--                                                    <a href="#"--}}
{{--                                                       class="dropdown-item assign-agent" data-id="{{$order->id}}" data-value="4">Assign Agent</a>--}}
                                                    <a href="#"
                                                       class="dropdown-item change-status" data-id="{{$order->id}}" data-value="4">Cancel</a>

                                                @elseif($order->status=='preparing')
                                                    <a href="#" data-id="{{$order->id}}"
                                                       data-value=2 class="dropdown-item change-status">Deliver</a>
                                                    <a href="#" data-id="{{$order->id}}"
                                                       data-value="3" class="dropdown-item change-status">Reject</a>
                                                @elseif($order->status=='pending')
                                                    <a href="#" data-id="{{$order->id}}"
                                                       data-value=1 class="dropdown-item change-status">Preparing</a>
                                                    <a href="#" data-id="{{$order->id}}"
                                                       data-value=2 class="dropdown-item change-status">Deliver</a>
                                                    <a href="#" data-id="{{$order->id}}"
                                                       data-value="3" class="dropdown-item change-status">Reject</a>
                                                @endif
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary view_order" data-id="{{$order->id}}"
                                                data-url="{{route('owner.view-order',$order->id)}}">View Order
                                        </button>

                                    </td>


                                </tr>
                            @empty
                                No Orders
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $('.view_order').click(function (){
            uni_modal('Order Details',this.dataset.url);
        })
        $('.assign-agent').click(function () {
            uni_modal('', '{{route('agent.operations')}}'+'?id='+this.dataset.id+'&op=ao&a=1');
        })
        $('.change-status').click(function () {
            start_load()
            $.ajax({
                url:'{{route("owner.change-order-status")}}',
                method:'POST',
                data:{id:this.dataset.id,sid:this.dataset.value,_token:'{{csrf_token()}}'},
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
        })
    </script>
@endsection
