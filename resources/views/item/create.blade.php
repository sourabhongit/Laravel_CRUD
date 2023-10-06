@extends('layouts.main')
@section('main-section')

@if (session('error'))
    <x-alert type="danger">
        {{ session('error') }}
    </x-alert>
@endif

<div class="card pt-3 ps-3 pe-3 pb-3 card-primary">
    <div class="card-header">
        <h3 class="card-title">Add Item</h3>
    </div>
    <form
        action="{{ route('item.store')}}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="mb-2 col-lg-4 form-group">
                    <label for="item_name" class="form-label"
                        >Item Name<span style="color: red">*</span></label
                    >
                    <input
                        type="text"
                        name="item_name"
                        class="form-control"
                        id="item_name"
                        value="{{old('item_name')}}"
                        pattern="[A-Za-z ]{1,50}"
                        minlength="1"
                        maxlength="50"
                        required
                    />
                    <span class="text-danger">
                        @error('item_name') {{$message}} @enderror
                    </span>
                </div>
                <div class="form-group col-lg-4 col-md-4">
                    <label for="exampleInputFile" class="form-label">Upload Photo<span style="color: red">*</span></label>
                    <input type="file" class="form-control" id="exampleInputFile" name="photo" />
                    <span class="text-danger">
                        @error('photo') {{$message}} @enderror
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
                        <option selected>Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <span class="text-danger">
                        @error('category_type') {{$message}} @enderror
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="mb-2 form-group col-lg-4">
                    <label for="" class="form-label"
                        >Item Price<span style="color: red">*</span></label
                    >
                    <input
                        type="text"
                        name="item_price"
                        class="form-control"
                        id=""
                        value="{{old('item_price')}}"
                        required
                    />
                    <span class="text-danger">
                        @error('item_price') {{$message}} @enderror
                    </span>
                </div>
                <div class="mb-2 form-group col-lg-8">
                    <label for="" class="form-label"
                        >Item Description<span style="color: red"
                            >*</span
                        ></label
                    >
                    <input
                        type="text"
                        name="item_description"
                        class="form-control"
                        value="{{old('item_description')}}"
                        pattern="[A-Za-z ]{30,100}"
                        minlength="30"
                        maxlength="100"
                        required
                    />
                    <span class="text-danger">
                        @error('item_description') {{$message}} @enderror
                    </span>
                </div>
            </div>
            <span>
                <label class="form-label">Item Status</label>
                <input
                    type="checkbox"
                    name="item_status"
                    id="item_status"
                    class="ms-3"
                />
            </span> <br>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Add item</button>
                <a href="{{route('item.index')}}">
                    <button type="button" class="btn btn-info">Cancel</button>
                </a>
            </div>
        </div>
    </form>
</div>

@endsection
