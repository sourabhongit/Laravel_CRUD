@extends('layouts.main') @section('main-section') @if (session('error'))
<x-alert type="danger"> {{ session('error') }} </x-alert>
@endif
<section class="content pt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="height: fit-content">
                <div class="d-flex">
                    <div>
                        <h3>logs</h3>
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
                                        <th>User ID</th>
                                        <th>Record ID</th>
                                        <th>Status</th>
                                        <th>Remark</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $key => $log)
                                    <tr class="text-center">
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $log->users->name }}</td>
                                        <td>{{ $log->record_id }}</td>
                                        <td>{{ $log->new_status }}</td>
                                        <td>{{ $log->remark }}</td>
                                        <td>{{ date_format($log->created_at, 'd-m-Y') }}</td>
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
