@extends('layouts.main') @section('main-section') @if (session('error'))
<x-alert type="danger"> {{ session('error') }} </x-alert>
@endif
<section class="content pt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="height: fit-content">
                <div class="d-flex">
                    <div>
                        <h3>CSV Import</h3>
                    </div>
                    <div class="ml-auto"></div>
                </div>
            </div>
            <div class="card-body">
                {{--
                <form action="" method="post" style="display: inline-block">
                    <button
                        type="submit"
                        class="file btn btn-lg btn-primary"
                        style="position: relative; overflow: hidden"
                    >
                        Upload
                        <input
                            type="file"
                            name="file"
                            style="
                                opacity: 0;
                                position: absolute;
                                right: 0;
                                top: 0;
                                cursor: pointer;
                                height: 100%;
                                width: 100%;
                            "
                        />
                    </button>
                </form>
                --}}
                <div class="row">
                    <div class="col-lg-6">
                        <form
                            action="{{ route('admin.bulk.data.csv.import') }}"
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
                            <button class="btn btn-success">
                                Import User Data
                            </button>
                        </form>
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
