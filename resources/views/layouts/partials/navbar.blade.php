<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"
                ><i class="fas fa-bars"></i
            ></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard')}}"
                @if(request()->routeIs('dashboard'))
                class="nav-link active"
                @else
                class="nav-link"
                @endif
            >Home</a>
        </li>
        <li class="nav-item">
            <a href="{{route('user.index')}}"
            @if(request()->routeIs('user.index'))
            class="nav-link active"
            @else
            class="nav-link"
            @endif>
                <i class="far fa-circle nav-icon"></i>
                <p>Users</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('item.index')}}"
            @if(request()->routeIs('item.index'))
            class="nav-link active"
            @else
            class="nav-link"
            @endif>
                <i class="far fa-circle nav-icon"></i>
                <p>Items</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('category.index')}}"
            @if(request()->routeIs('category.index'))
            class="nav-link active"
            @else
            class="nav-link"
            @endif>
                <i class="far fa-circle nav-icon"></i>
                <p>Categories</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-pills ml-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <a
                class="btn btn-danger me-3"
                href="route('logout')"
                onclick="event.preventDefault();
                this.closest('form').submit();"
            >
                {{ __('Log Out') }}
            </a>
        </form>
    </ul>
</nav>
