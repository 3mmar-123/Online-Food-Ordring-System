<div class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label">Home</li>
                <li> <a href="{{ route('owner.dashboard') }}"><i class="fa fa-tachometer"></i><span>Dashboard</span></a>
                </li>
                <li class="nav-label">Log</li>
                <li> <a href="{{ route('menus.index') }}"><i class="fa fa-cutlery" aria-hidden="true"></i><span>Menus</span></a></li>
                <li> <a href="{{ route('owner.orders') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Orders</span></a></li>
{{--                <li> <a  href="{{ route('agent.index') }}"><img  src="{{asset('img/delivery.png')}}" aria-hidden="true" width="20" height="25" /><span>Delivery Agents</span></a></li>--}}

            </ul>
        </nav>

    </div>
</div>
