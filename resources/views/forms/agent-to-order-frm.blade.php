<style>
    #orders-menu .card-text p:last-child, #selected-order .text-muted {
        font-size: 0.7rem;
        text-wrap: balance wrap;
    }
</style>
<form action="{{ route('agent.assign-order') }}" method="POST">
    @csrf
    <input type="hidden" name="oid" id="order-input" value="">
    <div class="card-body">
        Assign the order
        <div class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"
             aria-haspopup="true" aria-expanded="false" id="selected-order">
            <span class="sr-only"></span>
        </div>
        <div class="dropdown-menu scrollable-auto" style="height: available" id="orders-menu">
            @foreach($orders as $order)
                    <?php $order->del_info = json_decode($order->delivery_info); ?>

                <div data-id="{{$order->id}}"
                     data-title="{{$order->del_info->name.'<br/> <span class="text-muted">'.$order->del_info->address.'</span>' }}"
                     class="dropdown-item order-item">
                    <div class="card border border-outline-info">
                        <div class="card-title ">
                            {{ $order->del_info->name }}
                        </div>
                        <div class="card-text">
                            <p><strong>Status:</strong>
                                <span class="badge badge-{{ $order->getStatusBadge()}}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p><strong>Total Amount:</strong> ${{ $order->total_amount }}</p>
                            <p><strong>Items:</strong>
                                {{ implode(', ', $order->items->map(fn($item) => $item->menu->name)->toArray()) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        to Agent
        <select class="form-select" name="aid">
            @foreach($agents as $key=>$name)
                <option value="{{$key}}" {{$key==$id?'selected':''}}>
                    {{$name}}
                </option>
            @endforeach
        </select>
    </div>
</form>
<script>
    $('.order-item').on('click', function (e) {
        e.preventDefault();
        $('#uni_modal form #order-input').val(this.dataset.id)
        $('#uni_modal form #selected-order').html(this.dataset.title)
    })
    $('#uni_modal form #orders-menu .order-item').first().click();

</script>
