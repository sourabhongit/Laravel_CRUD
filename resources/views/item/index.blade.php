@extends('layouts.main')
@section('main-section')
@if (session('error'))
<x-alert type="danger"> {{ session('error') }} </x-alert>
@endif
<section class="content pt-3">
    <div class="container-fluid">
                <div class="card">
                    <div class="card-header" style="height: fit-content;">
                        <div class="d-flex">
                            <div>
                                <h3>Items</h3>
                            </div>
                            @can('create user')
                        <div class="ml-auto">
                                <a href="{{route('item.create')}}">
                                    <button class="btn btn-info">
                                        Create Item
                                    </button>
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
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th class="text-start" style="max-width: 200px; word-wrap: break-word;">Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $serialNumber = 1;
                                ?>
                                @foreach ($items as $item)
                                <tr class="text-center">
                                    <td>
                                        <?php echo $serialNumber; $serialNumber++; ?>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->categories->name}}</td>
                                    <td>{{ $item->price }}</td>
                                    <td class="text-start" style="max-width: 200px; word-wrap: break-word;">{{ $item->description }}</td>
                                    <td>
                                        <input
                                        type="checkbox"
                                        class="item-status"
                                        name="item_status"
                                        data-item-id="{{ $item->id }}"
                                        data-update-url="{{ route('item.update-status') }}"
                                        {{ $item->status ? 'checked' : '' }}
                                    >
                                    </td>
                                    <td>
                                        <a
                                            class="text-decoration-none"
                                            href="{{ route('item.edit', ['id' => $item->id]) }}"
                                        >
                                            <button class="btn btn-info btn-sm">
                                                Update
                                            </button>
                                            @can('delete user')
                                            <a
                                                class="text-decoration-none"
                                                href="{{route('item.delete',['id' => $item->id])}}"
                                                onclick="return confirm('Are you sure you want to delete'. $item->name . '?');"
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
$(document).ready(function () {
    $('.item-status').on('click', function () {
        const checkbox = $(this);
        const itemId = checkbox.data('item-id');

        const updateUrl = checkbox.data('update-url');
        const isChecked = checkbox.is(':checked');
        $.ajax({
            type: 'POST',
            url: updateUrl,
            data: {
                item_id: itemId,
                item_status: isChecked ? 1 : 0,
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                console.log("Status Changed");
            },
            error: function (error) {
                console.error(error);
            },
        });
    });
});
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
