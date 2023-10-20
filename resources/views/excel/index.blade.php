@extends('layouts.main') @section('main-section') @if (session('error'))
<x-alert type="danger"> {{ session('error') }} </x-alert>
@endif
<section class="content pt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="height: fit-content">
                <div class="d-flex">
                    <div>
                        <h3>Data</h3>
                    </div>
                    <div class="ml-auto">
                        <a href="{{route('admin.excel.records.export')}}">
                            <button class="btn btn-info">Export</button>
                        </a>
                        <!-- Button trigger modal -->
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop"
                        >
                            Import
                        </button>

                        <!-- Modal -->
                        <div
                            class="modal fade"
                            id="staticBackdrop"
                            data-bs-backdrop="static"
                            data-bs-keyboard="false"
                            tabindex="-1"
                            aria-labelledby="staticBackdropLabel"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5
                                            class="modal-title"
                                            id="staticBackdropLabel"
                                        >
                                            Import Excel
                                        </h5>
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"
                                        ></button>
                                    </div>
                                    <div class="modal-body">
                                        <form
                            action="{{ route('admin.excel.records.import') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            <input
                                type="file"
                                name="file"
                                class="form-control"
                            />
                            <br />
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal"
                                        >
                                            Close
                                        </button>
                                        <button class="btn btn-success">
                                            Import
                                        </button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <th>SN</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Number</th>
                                        <th>Remark</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ExcelRecords as $record)
                                    <tr class="text-center">
                                        <td>{{ $sn++ }}</td>
                                        <td>{{ $record->first_name }}</td>
                                        <td>{{ $record->last_name }}</td>
                                        <td>{{ $record->email }}</td>
                                        <td>{{ $record->number }}</td>
                                        <td>{{ $record->remark }}</td>
                                        <td>{{ $record->status }}</td>
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
            })
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
