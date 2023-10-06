@extends('layouts.main')
@section('main-section')
@if (session('error'))
    <x-alert type="danger">
        {{ session('error') }}
    </x-alert>
@endif
<div class="card pt-3 ps-3 pe-3 pb-3 card-primary">
    <div class="card-header">
        <h3 class="card-title">Add User</h3>
    </div>
    <form
        action="{{route('user.store')}}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-lg-4 col-md-6">
                    <label for="exampleInputName"
                        >Name<span style="color: red">*</span></label
                    >
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        id="exampleInputName"
                        placeholder="Enter name"
                        value="{{old('name')}}"
                        pattern="[A-Za-z ]{1,50}"
                        minlength="1"
                        maxlength="50"
                        required
                    />
                    <span class="text-danger">
                        @error('name') {{$message}} @enderror
                    </span>
                </div>
                <div class="form-group col-lg-4 col-md-6">
                    <label for="exampleInputFatherName"
                        >Father Name<span style="color: red">*</span></label
                    >
                    <input
                        type="text"
                        name="father_name"
                        class="form-control"
                        id="exampleInputFatherName"
                        placeholder="Enter father name"
                        value="{{old('father_name')}}"
                        pattern="[A-Za-z ]{1,50}"
                        minlength="1"
                        maxlength="50"
                        required
                    />
                    <span class="text-danger">
                        @error('father_name') {{$message}} @enderror
                    </span>
                </div>
                <div class="form-group col-lg-4 col-md-6">
                    <label for="exampleInputContactNumber"
                        >Contact No<span style="color: red">*</span></label
                    >
                    <input
                        type="text"
                        class="form-control"
                        id="exampleInputContactNumber"
                        placeholder="Enter contact number"
                        name="contact"
                        value="{{old('contact')}}"
                        pattern="[0-9]{1,10}"
                        minlength="10"
                        maxlength="10"
                        required
                    />
                    <span class="text-danger">
                        @error('contact') {{$message}} @enderror
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4 col-md-6">
                    <label for="exampleInputDOB"
                        >DOB<span style="color: red">*</span></label
                    >
                    <input
                        type="date"
                        class="form-control"
                        id="exampleInputDOB"
                        placeholder="Enter DOB"
                        name="dob"
                        value="{{old('dob')}}"
                        required
                    />
                    <span class="text-danger">
                        @error('dob') {{$message}} @enderror
                    </span>
                </div>
                <div class="form-group col-lg-8 col-md-6">
                    <label for="exampleInputAddress"
                        >Address<span style="color: red">*</span></label
                    >
                    <input
                        type="text"
                        name="address"
                        class="form-control"
                        id="exampleInputAddress"
                        placeholder="Enter address"
                        value="{{old('address')}}"
                        pattern="[A-Za-z 0-9]{1,100}"
                        minlength="5"
                        maxlength="100"
                        required
                    />
                    <span class="text-danger">
                        @error('address') {{$message}} @enderror
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4 col-md-6">
                    <label for="exampleInputFile" class="form-label">Upload Photo<span style="color: red">*</span></label>
                    <input type="file" class="form-control" id="exampleInputFile" name="photo" />
                    <span class="text-danger">
                        @error('photo') {{$message}} @enderror
                    </span>
                </div>
                <div class="form-group col-lg-4 col-md-6">
                    <label for="exampleInputEmail1"
                        >Email address<span style="color: red">*</span></label
                    >
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Enter email"
                        value="{{old('email')}}"
                        required
                    />
                    <span class="text-danger">
                        @error('email') {{$message}} @enderror
                    </span>
                </div>
                <div class="form-group col-lg-4 col-md-6">
                    <label for="exampleInputPassword1"
                        >Password<span style="color: red">*</span></label
                    >
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        id="exampleInputPassword1"
                        placeholder="Password"
                        required
                    />
                </div>
            </div>
            <div class="form-check mb-3">
                <input
                    type="checkbox"
                    class="form-check-input"
                    id="exampleCheck1"
                />
                <label class="form-check-label" for="exampleCheck1"
                    >User Status</label
                >
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{route('user.index')}}">
                <button type="button" class="btn btn-info">Cancel</button>
            </a>
        </div>
    </form>
</div>

@endsection
