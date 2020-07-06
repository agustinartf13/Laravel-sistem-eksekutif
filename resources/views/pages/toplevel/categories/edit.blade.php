@extends('layouts.toplevel')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Updated Data Categories</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('toplevel.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('toplevel.categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active"><a href=""></a> Edit Categories</li>
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
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-cube mr-2"></i>Edit Categories</h4>
                    <hr>
                    <form action="{{route('toplevel.categories.update', $category->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mt-3">
                            <label>Name Category</label>
                            <input type="text" name="name"
                                class="form-control {{$errors->first("name") ? "is-invalid" : ""}}"
                                placeholder="Name Category" value="{{old("name") ? old("name") : $category->name}}" />
                            <div class="invalid-feedback">
                                {{$errors->first("name")}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <br>
                            Current Image:
                            <br> @if ($category->image)
                            <img src="{{asset('storage/' . $category->image)}}" width="150px" alt=""
                                class="rounded mr-2 mo-mb-2 mt-2 mb-2">
                            <br> @else No Image
                            @endif
                            <div class="form-group">
                                <label>Input Image</label>
                                <input type="file" name="image" id="filestyle" class="filestyle"
                                    data-buttonname="btn-secondary">
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Update
                                </button>
                                <a href="{{route('toplevel.categories.index')}}"
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
        <script>
            $(document).ready(function () {

                @if(Session::has('success'))
                    toastr.success("{{ Session::get('success') }}")
                @endif

                $(":file").filestyle();
            });
        </script>
        @endsection



