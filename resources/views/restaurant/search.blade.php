@extends('layouts.main')
@section('content')
    <div class="page-wrapper">

        <!-- Search Bar -->
        <div class="container mt-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <form action="{{ route('customer.search') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search for restaurants or menus..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
{{--                <div class="col-md-4 text-end">--}}
{{--                    <a href="{{ route('customer.nearby') }}" class="btn btn-success">Find Nearby Restaurants</a>--}}
{{--                </div>--}}
            </div>
        </div>

        <!-- Search Results -->
        @if(request('search'))
            <section class="restaurants-page mt-4">
                <div class="container">
                    <h4>Search Results for: <strong>{{ request('search') }}</strong></h4>
                    <div class="bg-gray restaurant-entry">
                        <div class="row">
                            @forelse($results as $restaurant)
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
                                    @if ($restaurant->menus->isNotEmpty())
                                        <h6>Matching Menus:</h6>
                                        <ul>
                                            @foreach ($restaurant->menus as $menu)
                                                <li>{{ $menu->name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No matching menus found.</p>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">
                                    <div class="right-content bg-white">
                                        <div class="right-review">
                                            <a href="{{ route('customer.menu', $restaurant->id) }}" class="btn theme-btn-dash">View Menu</a>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <p class="text-center">No restaurants or menus found for your search.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
