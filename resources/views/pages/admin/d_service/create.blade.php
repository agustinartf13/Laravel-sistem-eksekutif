@extends('layouts.admin')
@section('title')

@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="page-title-box">
          <h4 class="page-title">Add Data Mekanik</h4>
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
  <div class="col-lg-8">
    <div class="card m-b-20">
    <div class="card-body">
    @if (session("status"))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        {{session('status')}}
    </div>
    @endif
  <h4 class="mt-0 header-title">Add Data</h4>
  <a href="{{route('admin.mekanik.index')}}" class="btn btn-secondary btn-flat" style="float: right"><i class="fas fa-reply mr-2"></i>Back</a>
    <br>
  <form action="{{route('admin.mekanik.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mt-4">
      <div class="col">
        <label for="Name">Full Name</label>
        <input type="text" name="name" class="form-control {{$errors->first('name') ? "is-invalid" : ""}}"  placeholder="Full Name" value="{{old('name')}}">
        <div class="invalid-feedback">
          {{$errors->first('name')}}
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col">
        <label for="Email">Email Address</label>
        <input type="email" name="email" class="form-control {{$errors->first('email') ? "is-invalid" : ""}}" placeholder="Email Address" value="{{old('email')}}">
        <div class="invalid-feedback">
          {{$errors->first('email')}}
        </div>
      </div>
      <div class="col">
        <label for="">No Telphone</label>
        <input type="number" name="no_telphone" class="form-control {{$errors->first("no_telphone") ? "is-invalid" : ""}}" placeholder="No Telphone" value="{{old("no_telphone")}}">
        <div class="invalid-feedback">
          {{$errors->first("no_telphone")}}
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12">
        <label>Address</label>
        <div>
          <textarea class="form-control {{$errors->first('address') ? "is-invalid" : ""}}"
            name="address" rows="5" value="{{old("address")}}"></textarea>
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
      <div class="form-group">
        <label>Input Image</label>
        <input type="file" id="filestyle" name="image" class="filestyle {{$errors->first("image") ? "is-invalid" : ""}}" data-buttonname="btn-secondary">
        <div class="invalid-feedback">
            {{$errors->first("image")}}
        </div>
    </div>
    </div>
    <div class="col">
      <label class="control-label">Status</label>
      <select  class="form-control select2 {{$errors->first('status') ? "is-invalid" : ""}}"
        name="status" value="{{old("status")}}">
        <option value="">SELECT</option>
        <option value="ACTIVE">ACTIVE</option>
        <option value="INACTIVE">INACTIVE</option>
      </select>
      <div class="invalid-feedback">
        {{$errors->first('status')}}
      </div>
    </div>
  </div>
    <div class="form-group mt-3">
      <div>
        <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
          Create
        </button>
        <button type="reset" class="btn btn-warning waves-effect waves-light btn-flat">
          Reset
        </button>
        <a href="{{route('admin.mekanik.index')}}" class="btn btn-secondary waves-effect btn-flat">
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
  $(document).ready(function() {
    $(":file").filestyle();
  });
</script>


@endsection
