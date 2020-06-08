@extends('layouts.toplevel')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Update Data Mekanik</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('toplevel.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('toplevel.mekanik.index') }}">Mekanik</a></li>
                <li class="breadcrumb-item active"><a href=""></a> Edit Mekanik</li>
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
                    <h4 class="mt-0"><i class="mdi mdi-account-card-details mr-2"></i> Edit Mekanik</h4>
                    <hr>
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <form action="{{route('toplevel.mekanik.update', $mekanik->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mt-4">
                            <div class="col">
                                <label for="Name">Full Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control {{$errors->first('name') ? "is-invalid" : ""}}"
                                    placeholder="Full Name" value="{{old('name') ? old('name') : $mekanik->name}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('name')}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="Email">Email Address</label>
                                <input type="email" name="email" id="email"
                                    class="form-control {{$errors->first('email') ? "is-invalid" : ""}}"
                                    placeholder="Email Address"
                                    value="{{old('email') ? old('email') : $mekanik->email}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('email')}}
                                </div>
                            </div>
                            <div class="col">
                                <label for="">No Telphone</label>
                                <input type="text" name="no_telphone" id="no_telphone"
                                    class="form-control {{$errors->first("no_telphone") ? "is-invalid" : ""}}"
                                    placeholder="No Telphone"
                                    value="{{old("no_telphone") ? old("no_telphone") : $mekanik->no_telphone}}">
                                <div class="invalid-feedback">
                                    {{$errors->first("no_telphone")}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label>Address</label>
                                <div>
                                    <textarea
                                        class="form-control form-control {{$errors->first('address') ? "is-invalid" : ""}}"
                                        name="address" id="address"
                                        rows="5">{{old("address") ? old("address") : $mekanik->address}}</textarea>
                                    <div class="invalid-feedback">
                                        {{$errors->first('address')}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="image">Image</label>
                                <br>
                                Current Image:
                                <br> @if ($mekanik->image)
                                <img src="{{asset('storage/' . $mekanik->image)}}" width="150px" alt="">
                                <br> @else No Image
                                @endif
                                <div class="form-group">
                                    <label>Input Image</label>
                                    <input type="file" name="image" id="image" class="filestyle"
                                        data-buttonname="btn-secondary">
                                </div>
                            </div>
                            <div class="col" style="margin-top: 70px">
                                <label class="control-label">Status</label>
                                <select class="form-control select2 {{$errors->first('status') ? "is-invalid" : ""}}"
                                    name="status">
                                    <option {{$mekanik->status == 'ACTIVE' ? 'selected' : ''}}>ACTIVE</option>
                                    <option {{$mekanik->status == 'INACTIVE' ? 'selected' : ''}}>INACTIVE</option>
                                </select>
                                <div class="invalid-feedback">
                                    {{$errors->first('status')}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Update
                                </button>
                                <a href="{{route('toplevel.mekanik.index')}}"
                                    class="btn btn-secondary waves-effect btn-flat">
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
        <script type="text/javascript">
            $(document).ready(function () {
                $(".select2").select2();
            });

        </script>
        @endsection
