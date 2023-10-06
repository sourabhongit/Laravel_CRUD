@extends('layouts.main') @section('main-section')

<div class="card pt-3 ps-3 pe-3 pb-3 card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Item</h3>
    </div>
    <form
        action="{{ route('item.update', ['id' => $id])}}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="mb-2 form-group col-lg-4">
                    <label for="" class="form-label"
                        >Item Name<span style="color: red">*</span></label
                    >
                    <input
                        type="text"
                        name="item_name"
                        class="form-control"
                        id=""
                        value="{{$item->name}}"
                        pattern="[A-Za-z ]{1,50}"
                        minlength="1"
                        maxlength="50"
                        required
                    />
                    <span class="text-danger">
                        @error('item_name') {{$message}} @enderror
                    </span>
                </div>
                <div class="mb-2 form-group col-lg-4 col-md-4">
                    <label for="" class="form-label"
                        >Item Price<span style="color: red">*</span></label
                    >
                    <input
                        type="text"
                        name="item_price"
                        class="form-control"
                        id=""
                        value="{{$item->price}}"
                        required
                    />
                    <span class="text-danger">
                        @error('item_price') {{$message}} @enderror
                    </span>
                </div>
                <div class="mb-2 form-group col-lg-4">
                    <label for="" class="form-label"
                        >Category<span style="color: red">*</span></label
                    >
                    <select
                        class="form-select"
                        name="category_id"
                        id="category_type"
                    >
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->
                            id == $item->category_id ? 'selected' : '' }}> {{
                            $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <span class="text-danger">
                        @error('category_type') {{$message}} @enderror
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="mb-2 form-group col-lg-6">
                    <label for="" class="form-label"
                    >Item Description<span style="color: red"
                    >*</span
                    ></label
                    >
                    <input
                    type="text"
                    name="item_description"
                    class="form-control"
                    id=""
                    value="{{$item->description}}"
                    pattern="[A-Za-z ]{30,100}"
                    minlength="30"
                    maxlength="100"
                    title="description"
                    required
                    />
                    <span class="text-danger">
                        @error('item_description') {{$message}} @enderror
                    </span>
                </div>
                <div class="form-group col-lg-6 col-md-4">
                    <label for="exampleInputFile" class="form-label">Upload Photo</label>
                    <input type="file" class="form-control" id="exampleInputFile" name="photo" />
                    <span class="text-danger">
                        @error('photo') {{$message}} @enderror
                    </span>
                </div>
                <div style="padding-left: 7.5px;" class="mb-3">
                <img style="width: 100px; border:5px solid #dee2e6;" src="{{ asset('images/items') . '/' . $item->photo }}" alt="No Item Image" >
            </div>
                <span>
                    <label class="form-label mb-2">Item Status</label>
                    <input
                        type="checkbox"
                        name="item_status"
                        id="item_status"
                        class="ms-3"
                        {{$item->status == '1' ? "checked" : ""}} >
                </span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{route('item.index')}}">
                <button type="button" class="btn btn-info">Cancel</button>
            </a>
        </div>
    </form>
</div>

@endsection
