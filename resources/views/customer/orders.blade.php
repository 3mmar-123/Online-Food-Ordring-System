@extends('layouts.main')
@section('styles')

    <style>
        .card-order {
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .filter-btn-group {
            margin-bottom: 1.5rem;
        }

        .favorite-icon {
            cursor: pointer;
            font-size: 1.2rem;
        }

        .delete-icon {
            cursor: pointer;
            font-size: 1.2rem;
        }
    </style>
@endsection

@section('content')
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-center mb-4 page-title">
                    <h1 class="text-white">Your Orders</h1>
                    <hr class="divider my-4 bg-dark"/>
                </div>
            </div>
        </div>
    </header>

    <section class="page-section" id="orders">
        <div class="container">
            <!-- Filter Buttons -->
            <div class="btn-group filter-btn-group" role="group" aria-label="Filter Orders">
                <button type="button" class="btn btn-primary filter-btn" data-filter="all">All Orders</button>
                <button type="button" class="btn btn-secondary filter-btn" data-filter="favorites">Favorites</button>
                <button type="button" class="btn btn-warning filter-btn" data-filter="pending">Pending</button>
            </div>

            <!-- Orders List -->
            <div id="orders-list" class="row">
                @forelse ($orders as $order)
                    <div class="card card-order col-md-6 col-lg-4 col-xl-3" data-status="{{ $order->status }}"
                         data-favorite="{{ $order->is_favorite }}">
                        <div class="card-header d-flex justify-content-between">
                            {{ $order->restaurant->name }}
                            <div class="d-flex justify-content-between">
                                <span class="favorite-icon me-2 change-order-status" data-id="{{ $order->id }}"
                                      data-value="1">
                                    <i class="fa {{ $order->is_favorite ? 'fa-heart text-danger' : 'fa-heart-o text-secondary' }}"></i>
                                </span>
                                @if($order->status!='delivering')
                                    <span class="delete-icon  change-order-status" data-id="{{ $order->id }}"
                                          data-value="2">
                                    <i class="fa fa-trash-o text-danger"></i></span>
                                @endif

                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Order Date:</strong> {{ $order->order_date->diffForHumans() }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge badge-{{ $order->getStatusBadge()}}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                @if($order->status=='pending')
                                    <a class="btn btn-warning text-sm p-1 change-order-status"
                                       data-id="{{ $order->id }}" data-value="3" href="javascript:">Cancel</a>

                                @elseif($order->status=='delivering'&&$order->delivery&&$order->delivery->delivery_status=='delivered')
                                    <a class="btn btn-warning text-sm p-1"
                                       href="{{ route('customer.confirm-delivery',$order->delivery->id) }}">Confirm
                                        Delivering</a>
                                @endif
                            </p>
                            <p><strong>Total Amount:</strong> ${{ $order->total_amount }}</p>
                            <p><strong>Items:</strong>
                                {{ implode(', ', $order->items->map(fn($item) => $item->menu->name)->toArray()) }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No orders found.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@section('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Filter functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            const orderCards = document.querySelectorAll('.card-order');

            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const filter = this.getAttribute('data-filter');

                    orderCards.forEach(card => {
                        const status = card.getAttribute('data-status');
                        const isFavorite = card.getAttribute('data-favorite') === '1';

                        if (
                            filter === 'all' ||
                            (filter === 'favorites' && isFavorite) ||
                            (filter === 'pending' && status === 'pending')
                        ) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Mark as favorite
            document.querySelectorAll('.favorite-icon').forEach(icon => {
                icon.addEventListener('click', function () {
                    const orderId = this.getAttribute('data-id');
                    const iconElement = this.querySelector('i');

                    fetch(`/orders/${orderId}/favorite`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({}),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                iconElement.classList.toggle('fa-heart');
                                iconElement.classList.toggle('fa-heart-o');
                                iconElement.classList.toggle('text-danger');
                                iconElement.classList.toggle('text-muted');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            // Delete order
        });
        $('.change-order-status').click(function () {
            if ($(this).hasClass('delete-icon') && !confirm('Are you sure you want to delete this order?'))
                return;

            start_load()
            $.ajax({
                url: '{{route("customer.change-order-status")}}',
                method: 'POST',
                data: {id: this.dataset.id, sid: this.dataset.value, _token: '{{csrf_token()}}'},
                success: function (resp) {
                    if (resp) {
                        notify(resp.status || "success", resp.message || "Process completed")
                        setTimeout(function () {
                            location.reload()
                        }, 1500)
                    }
                },
                error: function (xhr, status, message) {
                    console.log(xhr)
                    end_load()
                    notify('error', "Err " + status + " " + message)
                }
            })
        })

    </script>
@endsection
