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
                            <a href="{{ route('admin.records.csv.export') }}">
                                <button class="btn btn-info">Export</button>
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                                aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form id="uploadForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalToggleLabel">Choose File</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="input-group mb-3">
                                                    <input type="file" name="recordsFile" class="form-control"
                                                        id="inputGroupFile02">
                                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"
                                                    id="submitButton">Submit</button>
                                            </div>
                                        </div>
                                    </form>
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
                                        <form id="tableDataForm" enctype="multipart/form-data">
                                            @csrf
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

                                                    <tbody id="table-body">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type='submit' class="btn btn-primary" data-bs-toggle="modal"
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
                                        @foreach ($records as $key => $record)
                                            <tr class="text-center">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $record->date }}</td>
                                                <td>{{ $record->type }}</td>
                                                <td>{{ $record->description }}</td>
                                                <td>{{ $record->debit }}</td>
                                                <td>{{ $record->credit }}</td>
                                                <td class="text-center">
                                                    <div class="form-check text-center form-switch">
                                                        <input name="record-status"
                                                            class="form-check-input record-status toggle-button"
                                                            type="checkbox" data-record-id="{{ $record->id }}"
                                                            data-update-url="{{ route('admin.csv.record.update-status') }}"
                                                            id="flexSwitchCheckDefault"
                                                            {{ $record->status ? 'checked' : '' }}>
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
                    url: '{{ route('admin.records.csv.import') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        var importedData = data;
                        console.log(importedData);
                        var tableBody = $('#table-body');
                        tableBody.empty();
                        $.each(importedData, function(index, record) {
                            var tableData = `
            					<tr class="text-center">
                					<td>${index + 1}</td>
                					<td><input type="text" class="form-control" name="date[${index}]" value="${record.date}"></td>
                					<td><input type="text" class="form-control" name="type[${index}]" value="${record.type}"></td>
                					<td><input type="text" class="form-control" name="description[${index}]" value="${record.description}"></td>
                					<td><input type="text" class="form-control" name="debit[${index}]" value="${record.debit}"></td>
                					<td><input type="text" class="form-control" name="credit[${index}]" value="${record.credit}"></td>
                					<td class="status-column">
                    					<div class="form-check form-switch">
                        					<input
												type="checkbox"
												class="form-check-input record-status toggle-button"
												name="status[${index}]"
												id="flexSwitchCheckDefault">
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
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.records.csv.save') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Records saved');
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
