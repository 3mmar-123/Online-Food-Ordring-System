@extends('layouts.main')
@section('content')
    <div class="page-wrapper">
        <!-- Top Links -->
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item active"><span>1</span><a href="#">Choose Restaurant</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Pick Your favorite food</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay</a></li>
                </ul>
            </div>
        </div>

        <!-- Search Bar and Nearby Button -->
        <div class="container mt-4">
            <div class="row align-items-center">
                <!-- Search Form -->
                <div class="col-md-8">
                    <form action="{{ route('customer.search') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search for restaurants..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>

{{--                <!-- Nearby Button -->--}}
{{--                <div class="col-md-4 text-end">--}}
{{--                    <a href="{{ route('customer.nearby') }}" class="btn btn-success">Find Nearby Restaurants</a>--}}
{{--                </div>--}}
            </div>
        </div>

        <!-- Restaurants List -->
        <section class="restaurants-page mt-4">
            <div class="container">
                <div class="bg-gray restaurant-entry">
                    <div class="row">
                        @forelse($restaurants as $restaurant)
                            <div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left">
                                <div class="entry-logo">
                                    <a class="img-fluid" href="{{ route('customer.menu', $restaurant->id) }}">
                                        <img src="{{ asset($restaurant->logo_url) }}" alt="{{ $restaurant->name }} logo">
                                    </a>
                                </div>
                                <!-- Entry Description -->
                                <div class="entry-dscr">
                                    <h5>
                                        <a href="{{ route('customer.menu', $restaurant->id) }}">{{ $restaurant->name }}</a>
                                    </h5>
                                    <span>{{ $restaurant->address }}</span>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">
                                <div class="right-content bg-white">
                                    <div class="right-review">
                                        <a href="{{ route('customer.menu', $restaurant->id) }}" class="btn theme-btn-dash">View Menu</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">No restaurants found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
@endsection
