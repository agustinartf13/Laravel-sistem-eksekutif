@extends('layouts.admin')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Edit Data Users</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Agroxa</a></li>
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active">Data Table</li>
            </ol>
        </div>
    </div>
</div>
<!-- end row -->

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-lg">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0"><i class="mdi mdi-account-card-details mr-2"></i> Data User</h4>
                    <hr>
                    <form action="{{route('admin.user.update', $user->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row mt-4">
                            <div class="col">
                                <label for="Username">Username</label>
                                <input type="text" name="username"
                                    class="form-control {{$errors->first('username') ? "is-invalid" : ""}}"
                                    placeholder="Username"
                                    value="{{old('username') ? old('username') : $user->username}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('username')}}
                                </div>
                            </div>
                            <div class="col">
                                <label for="Name">Full Name</label>
                                <input type="text" name="name"
                                    class="form-control {{$errors->first('name') ? "is-invalid" : ""}}"
                                    placeholder="Full Name" value="{{old('name') ? old('name') : $user->name}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('name')}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="Email">Email Address</label>
                                <input type="email" name="email"
                                    class="form-control {{$errors->first('email') ? "is-invalid" : ""}}"
                                    placeholder="Email Address" value="{{old('email') ? old('email') : $user->email}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('email')}}
                                </div>
                            </div>
                            <div class="col">
                                <label for="NoTelphone">No Telphone</label>
                                <input type="number" name="no_telphone"
                                    class="form-control {{$errors->first('no_telphone') ? "is-invalid" : ""}}"
                                    placeholder="No Telphone"
                                    value="{{old('no_telphone') ? old('no_telphone') : $user->no_telphone}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('no_telphone')}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="Password">Password</label>
                                <input type="password" name="password"
                                    class="form-control {{$errors->first('password') ? "is-invalid" : ""}}"
                                    placeholder="" value="{{old('password')}}" disabled>
                                <div class="invalid-feedback">
                                    {{$errors->first('Password')}}
                                </div>
                            </div>
                            <div class="col">
                                <label for="">Gender</label>
                                <br>
                                <div class="form-check d-inline mr-3">
                                    <input class="form-check-input mr-5" type="radio" name="gender" id="exampleRadios1"
                                        value="LAKI-LAKI" {{$user->gender == "LAKI-LAKI" ? "checked" : ''}}>
                                    <label class="form-check-label" for="exampleRadios1">
                                        LAKI-LAKI
                                    </label>
                                </div>
                                <div class="form-check d-inline">
                                    <input class="form-check-input mr-5" type="radio" name="gender" id="exampleRadios1"
                                        value="PEREMPUAN" {{$user->gender == "PEREMPUAN" ? "checked" : ''}}>
                                    <label class="form-check-label" for="exampleRadios1">
                                        PEREMPUAN
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="NoTelphone">Confrime Password</label>
                                <input type="password" name="confrime_password"
                                    class="form-control {{$errors->first('confrime_password') ? "is-invalid" : ""}}"
                                    placeholder="" value="{{old('password')}}" disabled>
                                <div class="invalid-feedback">
                                    {{$errors->first('confrime_password')}}
                                </div>
                            </div>
                            <div class="col">
                                <label class="control-label">Role</label>
                                <select class="form-control {{$errors->first('role') ? "is-invalid" : ""}}" name="role"
                                    value="">
                                    <option {{($user->role->name == "Administrator") ? "selected" : ""}}>Administator
                                    </option>
                                    <option {{($user->role->name == "TopLevelManagemen") ? "selected" : ""}}>Top level
                                        managemen</option>
                                    <option {{($user->role->name == "Operator") ? "selected" : ""}}>Operator</option>
                                </select>
                                <div class="invalid-feedback">
                                    {{$errors->first('role')}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label>Address</label>
                                <div>
                                    <textarea name="address"
                                        class="form-control {{$errors->first('address') ? "is-invalid" : ""}}" n
                                        rows="5">{{old('address') ? old('address') : $user->address}}</textarea>
                                    <div class="invalid-feedback">
                                        {{$errors->first('address')}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label>About</label>
                                <div>
                                    <textarea class="form-control {{$errors->first('about') ? "is-invalid" : ""}}"
                                        name="about" rows="5">{{old('about') ? old('about') : $user->about}}</textarea>
                                    <div class="invalid-feedback">
                                        {{$errors->first('about')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="image">Image</label>
                                <br>
                                Current Image:
                                <br> @if ($user->image)
                                <img src="{{asset('storage/' . $user->image)}}" width="150px" alt="">
                                <br> @else No Image
                                @endif
                                <div class="form-group">
                                    <label>Input Image</label>
                                    <input type="file" name="image" id="filestyle" class="filestyle"
                                        data-buttonname="btn-secondary">
                                </div>
                                <span class="text-muted">Kosongkan jika tidak mengubah Image</span>
                            </div>
                            <div class="col">
                                <label class="control-label">Status</label>
                                <select class="form-control select2 {{$errors->first('status') ? "is-invalid" : ""}}"
                                    name="status">
                                    <option {{$user->status == 'ACTIVE' ? 'selected' : ''}}>ACTIVE</option>
                                    <option {{$user->status == 'INACTIVE' ? 'selected' : ''}}>INACTIVE</option>
                                </select>
                                <div class="invalid-feedback">
                                    {{$errors->first('status')}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-warning waves-effect waves-light btn-flat">
                                    Reset
                                </button>
                                <a href="{{route('admin.user.index')}}" class="btn btn-secondary waves-effect btn-flat">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end col -->

        <script>
            $(document).ready(function () {
                $(":file").filestyle();
            });

        </script>


        @endsection
