@extends('layouts.main')
@section('main-section')

<div class="card pt-3 ps-3 pe-3 pb-3 card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Category</h3>
    </div>
    <form action="{{ route('category.update', ['id' => $id])}}" method="post" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="card-body">
        <div class="row">
            <div class="col-lg-6 mb-2">
                    <label for="" class="form-label"
                        >Category Name<span style="color: red">*</span></label
                    >
                    <input
                        type="text"
                        name="category_name"
                        class="form-control"
                        id=""
                        value="{{$category->name}}"
                        required
                    />
                    <span class="text-danger">
                        @error('category_name')
                            {{$message}}
                        @enderror
                    </span>
            </div>
            <div class="col-lg-6 mb-2">
                    <label for="" class="form-label"
                        >Enter Number of Items<span style="color: red"
                            >*</span
                        ></label
                    >
                    <input
                        type="number"
                        name="number_of_items"
                        class="form-control"
                        id=""
                        value="{{$category->number_of_items}}"
                        min="1"
                        max="50"
                        required
                    />
                    <span class="text-danger">
                        @error('category_item')
                            {{$message}}
                        @enderror
                    </span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label for="exampleInputFile" class="form-label">Upload Photo</label>
                <input type="file" class="form-control mb-3" id="exampleInputFile" name="photo" />
                <img style="width: 100px; border:5px solid #dee2e6;" src="{{ asset('storage') . '/' . $category->photo}}" alt="No Category Image" >
                <span class="text-danger">
                    @error('photo') {{$message}} @enderror
                </span>
            </div>
            {{-- <div class="col-lg-2">
            </div> --}}
        </div>
        <span>
            <label class="form-label">Category Status</label>
            <input type="checkbox" name="category_status" id="category_status" {{$category->status == '1' ? "checked" : ""}} class="ms-3">
        </span><br>
        <div class="mt-3">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{route('category.index')}}">
        <button type="button" class="btn btn-info">Cancel</button>
        </a>
    </div>
        </div>
    </form>
</div>

@endsection