@extends('layouts.main') @section('main-section')
    @if (session('error'))
        <x-alert type="danger"> {{ session('error') }} </x-alert>
    @endif
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header" style="height: fit-content">
                    <div class="d-flex">
                        <div>
                            <h3>Records</h3>
                        </div>
                        <div class="ml-auto">
                            <a href="#">
                                <button class="btn btn-info">Export</button>
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                                aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalToggleLabel">Choose File</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="uploadForm" enctype="multipart/form-data">
                                                @csrf
                                                <div class="input-group mb-3">
                                                    <input type="file" name="recordsFile" class="form-control"
                                                        id="inputGroupFile02">
                                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModalToggle2" aria-hidden="true"
                                aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalToggleLabel2">Records</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="Records-body">
                                            <table class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>SN</th>
                                                        <th>Date</th>
                                                        <th>Type</th>
                                                        <th>Description</th>
                                                        <th>Debit</th>
                                                        <th>Credit</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <form id="tableDataForm" enctype="multipart/form-data">
                                                    @csrf
                                                    <tbody id="table-body">
                                                    </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type='submit' class="btn btn-primary"
                                                data-bs-target="#exampleModalToggle" data-bs-toggle="modal"
                                                data-bs-dismiss="modal">Save</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle"
                                role="button">Import</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr class="text-center">
                                            <th>SN</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Records as $key => $Record)
                                            <tr class="text-center">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $Record->date }}</td>
                                                <td>{{ $Record->type }}</td>
                                                <td>{{ $Record->description }}</td>
                                                <td>{{ $Record->debit }}</td>
                                                <td>{{ $Record->credit }}</td>
                                                <td class="text-center">
                                                    <div class="form-check text-center form-switch">
                                                        <input name="record-status"
                                                            class="form-check-input record-status toggle-button"
                                                            type="checkbox" data-record-id="{{ $Record->id }}"
                                                            data-update-url="{{ route('admin.record.update-status') }}"
                                                            id="flexSwitchCheckDefault"
                                                            {{ $Record->status ? 'checked' : '' }}>
                                                    </div>
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
        //     $(function () {
        //         $("#example1")
        //             .DataTable({
        //                 responsive: true,
        //                 lengthChange: false,
        //                 autoWidth: false,
        //             })
        //             .appendTo("#example1_wrapper .col-md-6:eq(0)");
        //         $("#example2").DataTable({
        //             paging: true,
        //             lengthChange: false,
        //             searching: false,
        //             ordering: true,
        //             info: true,
        //             autoWidth: false,
        //             responsive: true,
        //         });
        //     });
        // 	$(document).ready(function () {

        // });

        $(document).ready(function() {
            // Record status change
            var formData;
            $('.record-status').on('click', function() {
                const checkbox = $(this);
                const recordId = checkbox.data('record-id');

                const updateUrl = checkbox.data('update-url');
                const isChecked = checkbox.is(':checked');
                $.ajax({
                    type: 'POST',
                    url: updateUrl,
                    data: {
                        record_id: recordId,
                        record_status: isChecked ? 1 : 0,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        console.log("Status Changed");
                        checkbox.prop('checked', isChecked);
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('log.add') }}',
                            data: {
                                record_id: recordId,
                                new_status: isChecked ? 1 : 0,
                                action: 'Status changed',
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                console.log(response);
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    },
                    error: function(error) {
                        console.error(error);
                    },
                });
            });
            // Appending uploaded file data
            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();
                var form = $('#uploadForm')[0];
                var formData = new FormData(form);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.records.import') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        var importedData = data;
                        importedData.shift();
                        var tableBody = $('#table-body');
                        tableBody.empty();
                        $.each(importedData, function(index, record) {
                            var tableData = `
            <tr class="text-center">
                <td>${index + 1}</td>
                <td><input type="text" name="[date]" value="${record[0]}"></td>
                <td><input type="text" name="[type]" value="${record[1]}"></td>
                <td><input type="text" name="[description]" value="${record[2]}"></td>
                <td><input type="text" name="[debit]" value="${record[3]}"></td>
                <td><input type="text" name="[credit]" value="${record[4]}"></td>
                <td class="status-column">
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input record-status toggle-button" name="[status]" id="flexSwitchCheckDefault">
                    </div>
                </td>
            </tr>`;
                            tableBody.append(tableData);
                        });

                        $('#exampleModalToggle').modal('hide');
                        $('#exampleModalToggle2').modal('show');
                    },
                    error: function(error) {
                        // Handle any error here
                    },
                });
            });
            // Save table data
            $('#tableDataForm').on('submit', function(e) {
                e.preventDefault();
                var form = $('#tableDataForm')[0];

                var formData = new FormData(form);
                console.log(formData);
                return;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.records.save') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        window.location = 'http://127.0.0.1:8000/admin/records';
                    },
                    error: function(error) {
                        // Handle any error here
                    },
                });
            });
        });
    </script>
@endsection
