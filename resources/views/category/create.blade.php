@extends('layouts.main')
@section('main-section')

<div class="card pt-3 ps-3 pe-3 pb-3 card-primary">
    <div class="card-header">
        <h3 class="card-title">Add Category</h3>
    </div>
    <form action="{{ route('category.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
        <div class="row">
                <div class="mb-2 col-lg-6">
                    <label for="" class="form-label"
                        >Category Name<span style="color: red">*</span></label
                    >
                    <input
                        type="text"
                        name="category_name"
                        class="form-control"
                        id=""
                        value="{{old('category_name')}}"
                        minlength="1"
                        maxlength="50"
                        required
                    />
                    <span class="text-danger">
                        @error('category_name')
                            {{$message}}
                        @enderror
                    </span>
                </div>
                <div class="mb-2 col-lg-6">
                    <label for="" class="form-label"
                        >Enter Number of Items<span style="color: red"
                            >*</span
                        ></label
                    >
                    <input
                        type="text"
                        name="number_of_items"
                        class="form-control"
                        id=""
                        value="{{old('number_of_items')}}"
                        min="1"
                        max="50"
                        required
                    />
                    <span class="text-danger">
                        @error('number_of_items')
                            {{$message}}
                        @enderror
                    </span>
                </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label for="exampleInputFile" class="form-label">Upload Photo<span style="color: red"
                    >*</span
                ></label>
                <input type="file" class="form-control" id="exampleInputFile" name="photo" />
                <span class="text-danger">
                    @error('photo') {{$message}} @enderror
                </span>
            </div>
        </div>
        <span>
            <label class="form-label">Category Status</label>
            <input type="checkbox" name="category_status" id="category_status" class="ms-3">
        </span><br>
        <button type="submit" class="btn mt-3 btn-primary">Submit</button>
    </form>
</div>

@endsection