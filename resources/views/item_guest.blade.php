<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Items | Buyoo</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"
        />
        <link
            rel="stylesheet"
            href="{{ asset('css/client_home_style.css') }}"
        />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div>
            <nav class="navbar navbar-expand navbar-dark bg-dark">
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarsExample02"
                    aria-controls="navbarsExample02"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExample02">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('guest.index')}}"
                                >Home <span class="sr-only">(current)</span></a
                            >
                        </li>
                    </ul>
                </div>
                <form class="form-inline my-2 my-md-0">
                    @csrf
                  <input class="form-control" data-img-baseURL="{{ asset('') }}" data-route="{{ route('items.show') }}" id="search" type="text" placeholder="Search">
                </form>
            </nav>
        </div>
        <div class="container-fluid mt-3">
            <div class="d-flex items-container flex-wrap justify-content-around">
                @foreach($items as $item)
                <div
                    class="card"
                    style="
                        width: 15rem;
                        height: 26rem;
                        background-color: #121212;
                    "
                >
                    <div style="text-align: center">
                        <img
                            class="card-img-top"
                            src="{{ URL::to('/'). '/images/items/'. $item->photo}}"
                            alt="Card image cap"
                        />
                    </div>
                    <div class="card-body" style="background-color: #383838">
                        <h5 class="card-title text-white mb-2">
                            <strong>{{ $item->name}}</strong>
                        </h5>
                        <h6 class="text-white mb-2" style="clear:both;">
                            <strong style="font-weight: 900">{{ $item->price}}</strong>
                        </h6>
                        <p class="card-text text-white">
                            {{ $item->description }}
                        </p>
                        <a href="#" class="btn btn-primary">Buy Now</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <script src="{{ asset('backend/js/ItemSearch.js') }}"></script>

        <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    </body>
</html>
