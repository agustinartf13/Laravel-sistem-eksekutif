@extends('layouts.admin')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Update Supplier</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.supplier.index') }}">Supplier</a></li>
                <li class="breadcrumb-item active"><a href=""></a> Edit Supplier</li>
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
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-account-card-details mr-2"></i>Edit Supplier</h4>
                    <hr>
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <form action="{{route('admin.supplier.update', $supplier->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mt-4">
                            <div class="col">
                                <label>Name Supplier</label>
                                <input type="text" name="name_supplier"
                                    class="form-control {{$errors->first("name_supplier") ? "is-invalid" : ""}}"
                                    placeholder="Name Supplier"
                                    value="{{old("name_supplier") ? old("name_supplier") : $supplier->name_supplier}}" />
                                <div class="invalid-feedback">
                                    {{$errors->first("name_supplier")}}
                                </div>
                            </div>
                            <div class="col">
                                <label>Email</label>
                                <input type="text" name="email"
                                    class="form-control {{$errors->first("email") ? "is-invalid" : ""}}"
                                    placeholder="Email" value="{{old("email") ? old("email") : $supplier->email}}" />
                                <div class="invalid-feedback">
                                    {{$errors->first("email")}}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <label>Perusahaan</label>
                                <input type="text" name="perusahaan"
                                    class="form-control {{$errors->first("perusahaan") ? "is-invalid" : ""}}"
                                    placeholder="Perusahaan"
                                    value="{{old("perusahaan") ? old("perusahaan") : $supplier->perusahaan}}" />
                                <div class="invalid-feedback">
                                    {{$errors->first("perusahaan")}}
                                </div>
                            </div>
                            <div class="col">
                                <label>Phone Number</label>
                                <input type="text" name="no_telphone"
                                    class="form-control {{$errors->first("no_telphone") ? "is-invalid" : ""}}"
                                    placeholder="Phone Number"
                                    value="{{old("no_telphone") ? old("no_telphone") : $supplier->no_telphone}}" />
                                <div class="invalid-feedback">
                                    {{$errors->first("no_telphone")}}
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Address</label>
                            <div>
                                <textarea name="address"
                                    class="form-control {{$errors->first('address') ? "is-invalid" : ""}}" n
                                    rows="5">{{old('address') ? old('address') : $supplier->address}}</textarea>
                                <div class="invalid-feedback">
                                    {{$errors->first('address')}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="control-label">Status</label>
                            <select class="form-control select2 {{$errors->first('status') ? "is-invalid" : ""}}"
                                name="status">
                                <option {{$supplier->status == 'ACTIVE' ? 'selected' : ''}}>ACTIVE</option>
                                <option {{$supplier->status == 'INACTIVE' ? 'selected' : ''}}>INACTIVE</option>
                            </select>
                            <div class="invalid-feedback">
                                {{$errors->first('status')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <br>
                            Current Image:
                            <br> @if ($supplier->image)
                            <img src="{{asset('storage/' . $supplier->image)}}" width="150px" alt="">
                            <br> @else No Image
                            @endif
                            <div class="form-group">
                                <label>Input Image</label>
                                <input type="file" name="image" id="filestyle" class="filestyle"
                                    data-buttonname="btn-secondary">
                                <span class="text-muted">Kosongkan jika tidak mengubah Image</span>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Update
                                </button>
                                <a href="{{route('admin.supplier.index')}}"
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
        <script text="text/javascript">
            $(document).ready(function () {

                @if(Session::has('success'))
                    toastr.success("{{ Session::get('success') }}")
                @endif

                $(":file").filestyle();
                $('.select2').select2();
            });
        </script>
        @endsection
