<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="{{ route('dashboard')}}" class="d-block">User Goo</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul
                class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false"
            >
                <li class="nav-item">
                    <a href="{{route('dashboard')}}"
                    @if(request()->routeIs('dashboard'))
                    class="nav-link active"
                    @else
                    class="nav-link"
                    @endif>
                        <i class="far fa-circle nav-icon"></i>
                        <p>Home</p>
                    </a>
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
                @can(['export data', 'import data'])
                <li class="nav-item">
                    <a href="{{route('admin.bulk.data.excel.index')}}"
                    @if(request()->routeIs('admin.bulk.data.excel.index'))
                    class="nav-link active"
                    @else
                    class="nav-link"
                    @endif>
                        <i class="far fa-circle nav-icon"></i>
                        <p>Simple Excel</p>
                    </a>
                </li>
                @endcan
                @can(['export data', 'import data'])
                <li class="nav-item">
                    <a href="{{route('admin.bulk.data.csv.index')}}"
                    @if(request()->routeIs('admin.bulk.data.csv.index'))
                    class="nav-link active"
                    @else
                    class="nav-link"
                    @endif>
                        <i class="far fa-circle nav-icon"></i>
                        <p>Simple CSV</p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
    </div>
</aside>