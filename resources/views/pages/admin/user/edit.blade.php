@extends('layouts.admin')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Edit Data Users</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">User</a></li>
                <li class="breadcrumb-item active"><a href=""></a>Edit User</li>
            </ol>
        </div>
    </div>
</div>
<!-- end row -->

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-lg-8">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0"><i class="mdi mdi-account-card-details mr-2"></i>Edit Data User</h4>
                    <hr>
                    <form action="{{route('admin.user.update', $user->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row mt-4">
                            <div class="col">
                                <label for="Username">Username</label>
                                <input type="text" name="username" id="susername"
                                    class="form-control {{$errors->first('username') ? "is-invalid" : ""}}""
                                    placeholder=" Username"
                                    value="{{old('username') ? old('username') : $user->username}}">
                                <div id="valid-username" style="display:none; color: red;"></div>
                            </div>
                            <div class="col">
                                <label for="Name">Full Name</label>
                                <input type="text" name="name" id="sname" class="form-control" placeholder="Full Name"
                                    value="{{old('name') ? old('name') : $user->name}}">
                                <div id="valid-name" style="display:none; color: red;"></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="Email">Email Address</label>
                                <input type="email" name="email" id="semail" class="form-control"
                                    placeholder="Email Address" value="{{old('email') ? old('email') : $user->email}}">
                                <div id="valid-email" style="display:none; color: red;"></div>
                            </div>
                            <div class="col">
                                <label for="NoTelphone">No Telphone</label>
                                <input type="number" name="no_telphone" id="sno_telphone" class="form-control"
                                    placeholder="No Telphone"
                                    value="{{old('no_telphone') ? old('no_telphone') : $user->no_telphone}}">
                                <div id="valid-no_telphone" style="display:none; color: red;"></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label class="control-label">Role</label>
                                <select class="form-control select2 {{$errors->first('role') ? "is-invalid" : ""}}"
                                    name="role" value="">
                                    <option {{($user->role->name == "Administrator") ? "selected" : ""}}>Administator
                                    </option>
                                    <option {{($user->role->name == "TopLevelManagemen") ? "selected" : ""}}>Top level
                                        managemen</option>
                                    <option {{($user->role->name == "Operator") ? "selected" : ""}}>Operator</option>
                                </select>
                                <div id="valid-roles" style="display:none; color: red;"></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="Password">Password</label>
                                <input type="password" name="password" id="spassword" class="form-control"
                                    placeholder="Password" value="{{old('password')}}" disabled>
                                <div id="valid-password" style="display:none; color: red;"></div>
                            </div>
                            <div class="col">
                                <label for="NoTelphone">Confrime Password</label>
                                <input type="password" name="confrime_password" class="form-control"
                                    id="sconfrime_password" placeholder="Confrime Password">
                                <div id="valid-confrime_password" style="display:none; color: red;"></div>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Address</label>
                                <div>
                                    <textarea name="address" id="saddress" class="form-control"
                                        rows="5">{{old('address') ? old('address') : $user->address}}</textarea>
                                    <div id="valid-address" style="display:none; color: red;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <div class="form-group">
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
                            </div>
                            <div class="col">
                                <label class="control-label">Status</label>
                                <select class="form-control select2" name="status">
                                    <option {{$user->status == 'ACTIVE' ? 'selected' : ''}}>ACTIVE</option>
                                    <option {{$user->status == 'INACTIVE' ? 'selected' : ''}}>INACTIVE</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Submit
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
        @endsection
        @section('js')
        <script>
            $(document).ready(function () {
                $(":file").filestyle();
                $(".select2").select2();
            });

        </script>
        @endsection
