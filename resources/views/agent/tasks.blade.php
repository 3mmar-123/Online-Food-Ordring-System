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
                    <h1 class="text-white">Your Tasks</h1>
                    <hr class="divider my-4 bg-dark"/>
                </div>
            </div>
        </div>
    </header>

    <section class="page-section" id="orders">
        <div class="container">
            <!-- Filter Buttons -->
            <div class="btn-group filter-btn-group" role="group" aria-label="Filter Orders">
                <button type="button" class="btn btn-dark filter-btn" data-filter="all">All Tasks</button>
                <button type="button" class="btn btn-warning filter-btn" data-filter="assigned">Assigned</button>
                <button type="button" class="btn btn-primary filter-btn" data-filter="in_transit">In Transit</button>
                <button type="button" class="btn btn-success filter-btn" data-filter="delivered">Delivered</button>
            </div>

            <!-- Orders List -->
            <div id="orders-list" class="row">
                @forelse ($deliveries as $delivery)
                        <?php $del_info = json_decode($delivery->order->delivery_info); ?>
                    <div class="card card-order col-md-6 col-lg-4 col-xl-3"
                         data-status="{{ $delivery->delivery_status }}">
                        <div class="card-header ">
                            {{ $del_info->name }}


                            <span class="text-muted">
                                    <br/>
                                    Phone: {{$del_info->phone}}<br/>
                                    Email: {{$del_info->email}}
                                </span>
                        </div>
                        <div class="card-body">
                            @if($delivery->order->status=='canceled'||$delivery->order->status=='rejected')
                                <span class="badge badge-danger">
                                    This Order Canceled
                                </span>
                            @else

                                <p><strong>Status:</strong>
                                    <span class="badge badge-{{ $delivery->getStatusBadge()}}">
                                    {{ ucfirst($delivery->delivery_status) }}
                                </span>
                                    @if($delivery->order->status=='delivering')
                                        <a class="btn  text-sm p-sm-1 change-status btn-{{$delivery->getStatusBadge(1)}} {{$delivery->delivery_status=='delivered'?'disabled':''}}"
                                           data-id="{{$delivery->id}}">
                                            @if($delivery->delivery_status=="assigned"&&$delivery->order->status=='delivering')
                                                Deliver Now
                                            @elseif($delivery->delivery_status=="in_transit")
                                                Mark Delivered
                                            @elseif($delivery->delivery_status=="delivered"&&$delivery->order->status!='completed')
                                                Not Confirmed
                                            @endif
                                        </a>
                                    @endif
                                </p>
                                <p><strong>Total Amount:</strong> ${{ $delivery->order->total_amount }}</p>
                                <p><strong>Address:</strong>
                                    {{ $delivery->delivery_address }}
                                </p>
                            @endif
                        </div>
                    </div>

                @empty
                    <p class="card-text text-center">No tasks found.</p>
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
                        if (
                            filter === 'all' ||
                            (filter === status)
                        ) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

        });
        $('.change-status').click(function () {
            if ($(this).hasClass('delete-icon') && !confirm('Are you sure you want to delete this order?'))
                return;
            start_load()
            $.ajax({
                url: '{{route("agent.change-order-status")}}',
                method: 'POST',
                data: {id: this.dataset.id, _token: '{{csrf_token()}}'},
                success: function (resp) {
                    if (resp.status) {
                        notify(resp.status, resp.message)
                        setTimeout(function () {
                            location.reload()
                        }, 1500)
                    } else
                        end_load()

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
