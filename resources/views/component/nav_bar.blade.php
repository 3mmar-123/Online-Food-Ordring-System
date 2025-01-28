<!-- Navbar & Hero Start -->
<nav id="header" class="navbar navbar-expand-lg navbar-light  px-4 px-lg-5 py-3 py-lg-0"
     style="    background-color: #c92800;">
    <button class="navbar-toggler bg-primary white-text" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav me-auto py-0">
            <a href="{{route('home')}}"
               class="nav-item nav-link {{\Illuminate\Support\Facades\Route::currentRouteNamed('home')? 'active':''}}">Home</a>
            <a href="{{route('about')}}"
               class="nav-item nav-link {{\Illuminate\Support\Facades\Route::currentRouteNamed('about')? 'active':''}}">About</a>

            @if(!auth()->id())
                <a href="{{route('customer.restaurants')}}"
                   class="nav-item nav-link  {{\Illuminate\Support\Facades\Route::currentRouteNamed('customer.restaurants')? 'active':''}}">Restaurants</a>
            @else
                @if(auth()->user()->role=="owner")
                    <a class="nav-item nav-link" href="{{ route('owner.dashboard') }}" >Your
                        Dashboard</a>
                @elseif(auth()->user()->role=="agent")
                    <a class="nav-item nav-link" href="{{ route('agent.orders') }}" >Your
                        Tasks</a>
                @else
                    <a href="{{route('customer.restaurants')}}"
                       class="nav-item nav-link  {{\Illuminate\Support\Facades\Route::currentRouteNamed('customer.restaurants')? 'active':''}}">Restaurants</a>
                    <a class="nav-item nav-link {{\Illuminate\Support\Facades\Route::currentRouteNamed('cart.index')? 'active':''}}"
                       href="{{route('cart.index')}}"><span class="badge badge-danger item_count">0</span> <i
                            class="fa fa-shopping-cart"></i> Cart</a>

                    <a class="nav-item nav-link" href="{{ route('customer.orders') }}" >Your
                        Orders</a>
                @endif
            @endif
        </div>
        <div class="navbar-nav">
            @if(\Illuminate\Support\Facades\Auth::user())
                <!-- Notifications -->
                <div class="nav-item dropdown">
                    <a class="nav-link " href="#" id="notificationsDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-danger">{{ auth()->user()->notifications->count() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated fadeIn" aria-labelledby="notificationsDropdown">
                        <h6 class="dropdown-header">Notifications</h6>
                        <div class="dropdown-divider"></div>
                        @forelse (auth()->user()->notifications as $notification)
                            <a href="{{ route('notification.show',$notification->id) }}" class="dropdown-item text-red small">
                                <i class="fa fa-info-circle text-primary"></i> {{ $notification->message }}
                                <span class="text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                            <div class="dropdown-divider"></div>
                        @empty
                            <a class="dropdown-item text-center text-muted">No new notifications</a>
                        @endforelse
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link "
                       data-bs-toggle="dropdown">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                    <div class="dropdown-menu m-0">
                        <span class="divider-horizontal dropdown-divider"></span>
                        <a title="Logout" class="dropdown-item" href="{{route('logout')}}">
                            <i class="text-danger   fa fa-solid fa-sign-out"> </i> <span
                                data-no-translation>Logout</span></a>
                    </div>
                </div>

            @else
                <a title="sign-up" class="nav-item nav-link " href="{{route('login')}}">
                <span data-no-translation>
                        Sign Up</span></a>
            @endif

        </div>


    </div>
    <aside class="submenu-popup-container">
    </aside>

</nav>

<!-- Navbar & Hero End -->
