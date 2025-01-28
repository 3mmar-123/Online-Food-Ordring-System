<div class="header">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">

            <a class="navbar-brand" href="{{ route('home') }}">
                Food Ordering
            </a>
        </div>

        <div class="navbar-collapse">
            <ul class="navbar-nav ml-auto mt-md-0">

            <!-- Notifications -->
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle text-muted" href="#" id="notificationsDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-danger">{{ auth()->user()->notifications->count() }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right animated fadeIn fadeInDown" aria-labelledby="notificationsDropdown">
                    <h6 class="dropdown-header">Notifications</h6>
                    <div class="dropdown-divider"></div>
                    @forelse (auth()->user()->notifications as $notification)
                        <a href="{{ $notification->goto_url ?? '#' }}" class="dropdown-item">
                            <i class="fa fa-info-circle text-primary"></i> {{ $notification->message }}
                            <br>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </a>
                        <div class="dropdown-divider"></div>
                    @empty
                        <a class="dropdown-item text-center text-muted">No new notifications</a>
                    @endforelse
                </div>
            </li>

            <!-- User Profile -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ asset(auth()->user()->restaurant->logo_url) }}" alt="user" class="profile-pic" />
                </a>
                <div class="dropdown-menu dropdown-menu-right animated zoomIn" aria-labelledby="userDropdown">
                    <ul class="dropdown-user">
                        <li><a href="{{ route('logout') }}"><i class="text-danger fa fa-sign-out"></i> Logout</a></li>
                    </ul>
                </div>
            </li>
            </ul>
        </div>

    </nav>
</div>
