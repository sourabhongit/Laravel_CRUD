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
                                <h3>Categories</h3>
                            </div>
                            @can('create user')
                                <div class="ml-auto">
                                    <a href="{{route('generatePDF')}}">
                                        <button class="btn btn-info">
                                            PDF
                                        </button>
                                    </a>
                                    <a href="{{route('export-categories')}}">
                                        <button class="btn btn-info">
                                            Export
                                        </button>
                                    </a>
                                    <a href="{{route('category.create')}}">
                                        <button class="btn btn-info">
                                            Create Category
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
                                    <th>Category Name</th>
                                    <th>Number of Items</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $serialNumber = 1; ?>
                                @foreach ($categories as $category)
                                <tr class="text-center">
                                    <td>
                                        <?php echo $serialNumber; $serialNumber++; ?>
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->number_of_items }}</td>
                                    <td>
                                    <input
                                        type="checkbox"
                                        class="category-status"
                                        name="category_status"
                                        data-category-id="{{ $category->id }}"
                                        data-update-url="{{ route('category.update-status') }}"
                                        {{ $category->status ? 'checked' : '' }}
                                    >
                                    </td>
                                    <td>
                                        <a
                                            class="text-decoration-none"
                                            href="{{ route('category.edit', ['id' => $category->id]) }}"
                                        >
                                            <button class="btn btn-info btn-sm">
                                                Update
                                            </button>
                                        </a>
                                        @can('delete user')
                                        <a
                                            class="text-decoration-none"
                                            href="{{route('category.delete',['id' => $category->id])}}"
                                            onclick="return confirm('Are you sure you want to delete {{$category->name}} ?');"
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
    $('.category-status').on('click', function () {
        const checkbox = $(this);
        const categoryId = checkbox.data('category-id');

        const updateUrl = checkbox.data('update-url');
        const isChecked = checkbox.is(':checked');
        $.ajax({
            type: 'POST',
            url: updateUrl,
            data: {
                category_id: categoryId,
                category_status: isChecked ? 1 : 0,
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
