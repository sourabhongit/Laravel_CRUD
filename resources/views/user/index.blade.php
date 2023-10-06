@extends('layouts.main')
@section('main-section')
@if (session('error'))
    <x-alert type="danger"> {{ session('error') }} </x-alert>
@endif
<section class="content pt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div>
                        <h3>Users</h3>
                    </div>
                    @can('create user')
                    <div class="ml-auto">
                        <a href="{{route('user.create')}}">
                            <button class="btn btn-info">Create User</button>
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div
                    id="example1_wrapper"
                    class="dataTables_wrapper dt-bootstrap4"
                >
                    <div class="row">
                        <div class="col-sm-12">
                            <table
                                id="example1"
                                class="table table-bordered table-striped dataTable dtr-inline"
                                aria-describedby="example1_info"
                            >
                                <thead>
                                    <tr class="text-center">
                                        <th>S.N.</th>
                                        <th>User Photo</th>
                                        <th
                                            class="sorting sorting_asc"
                                            tabindex="0"
                                            aria-controls="example1"
                                            rowspan="1"
                                            colspan="1"
                                            aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending"
                                        >
                                            Name
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="example1"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Browser: activate to sort column ascending"
                                        >
                                            Father Name
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="example1"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                        >
                                            Contact
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="example1"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Engine version: activate to sort column ascending"
                                        >
                                            DOB
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="example1"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending"
                                        >
                                            Address
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="example1"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending"
                                        >
                                            Email
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            $serialNumber = 1;
                                        ?>
                                    @foreach ($users as $user)
                                    <tr class="odd text-center">
                                        <td>
                                            <?php echo $serialNumber; $serialNumber++; ?>
                                        </td>
                                        <td>
                                            @if($user->photo)
                                            <img
                                                src="{{ URL::to('/'). '/images/' . $user->photo}}"
                                                style="
                                                    width: 50px;
                                                    border-radius: 50%;
                                                "
                                            />
                                            @else
                                            <span>No image found!</span>
                                            @endif
                                        </td>
                                        <td
                                            class="dtr-control sorting_1"
                                            tabindex="0"
                                        >
                                            {{$user->name}}
                                        </td>
                                        <td>{{$user->father_name}}</td>
                                        <td>{{$user->contact}}</td>
                                        <td>{{$user->dob}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <a
                                                class="text-decoration-none"
                                                href="{{route('user.edit',['id' => $user->id])}}"
                                            >
                                                <button
                                                    class="btn btn-info btn-sm"
                                                >
                                                    Update
                                                </button>
                                            </a>
                                            @can('delete user')
                                            <a
                                                class="text-decoration-none"
                                                href="{{route('user.delete',['id' => $user->id])}}"
                                                onclick="return confirm('Are you sure you want to delete this user?');"
                                            >
                                                <button
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    Delete
                                                </button>
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        $("#example1")
            .DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            })
            .buttons()
            .container()
            .appendTo("#example1_wrapper .col-md-6:eq(0)");
        $("#example2").DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
        });
    });
</script>
@endsection
