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
                            <h3>Calculate Age</h3>
                        </div>
                    </div>
                </div>
                <form id='ageCalculatorForm'>
                    @csrf
                    <div class="card-body">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" name='date_of_birth' class="form-control" id="dob">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="currentDate" class="form-label">Current Date</label>
                                        <input type="date" name='current_date' class="form-control" id="currentDate">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class='btn btn-info'>Calculate Age</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        $('#ageCalculatorForm').on('submit', function(e) {
            e.preventDefault();
            var form = $('#ageCalculatorForm')[0];
            var formData = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '{{ route('carbon.age.calculate') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('The age is: ' + response);
                },
                error: function(error) {
                    console.error(error);
                },
            });
        })
    </script>
@endsection
