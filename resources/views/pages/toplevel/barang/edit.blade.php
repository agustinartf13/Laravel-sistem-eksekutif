@extends('layouts.toplevel')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data Barang</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">{{Auth::user()->username}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('toplevel.barang.index')}}">Barang</a></li>
                <li class="breadcrumb-item"><a href="{{route('toplevel.barang.create')}}">Add Barang</a></li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="card m-b-20">
                <div class="card-body">
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <h4 class="mt-0 header-title">Add Data</h4>
                    <a href="{{route('toplevel.barang.index')}}" class="btn btn-primary btn-flat" style="float: right"><i
                            class="fas fa-reply mr-2"></i>Back</a>
                    <br>
                    <form action="{{route('toplevel.barang.update', $barang->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="row mt-4">
                            <div class="col">
                                <label for="kode_barang">Kode Barang</label>
                                <input type="text" name="kode_barang"
                                    class="form-control {{$errors->first('kode_barang') ? "is-invalid" : ""}}"
                                    placeholder="Kode Barang"
                                    value="{{old('kode_barang') ? old('kode_barang') : $barang->kode_barang}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('kode_barang')}}
                                </div>
                            </div>
                            <div class="col">
                                <label for="Name">Name Barang</label>
                                <input type="text" name="name_barang"
                                    class="form-control {{$errors->first('name_barang') ? "is-invalid" : ""}}"
                                    placeholder="Name Barang"
                                    value="{{old('name_barang') ? old('name_barang') : $barang->name_barang}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('name_barang')}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label class="control-label">Category Name</label>
                                <select
                                    class="form-control select2 {{$errors->first("categories_id") ? "is-invalid" : ""}}"
                                    name="categories_id">
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}"
                                        {{$barang->categories_id == $category->id ? "selected" : ""}}>
                                        {{$category->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{$errors->first('categories_id')}}
                                </div>
                            </div>
                            <div class="col">
                                <label for="">Harga Pokok</label>
                                <input type="text" name="harga_dasar"
                                    class="form-control {{$errors->first("harga_dasar") ? "is-invalid" : ""}}"
                                    placeholder="Harga Pokok"
                                    value="{{old("harga_dasar") ? old("harga") : $barang->details_barang->harga_dasar}}">
                                <div class="invalid-feedback">
                                    {{$errors->first("harga")}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Description</label>
                                <div>
                                    <textarea class="form-control {{$errors->first('description') ? "is-invalid" : ""}}"
                                        name="description" rows="5"
                                        value="">{{$barang->details_barang->description}}</textarea>
                                    <div class="invalid-feedback">
                                        {{$errors->first('description')}}
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="">Harga Jual</label>
                                <input type="text" name="harga_jual"
                                    class="form-control {{$errors->first("harga_jual") ? "is-invalid" : ""}}"
                                    placeholder="Harga Jual"
                                    value="{{old("harga_jual") ? old("harga_jual") : $barang->details_barang->harga_jual}}">
                                <div class="invalid-feedback">
                                    {{$errors->first("harga_jual")}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="">Stock</label>
                                <input type="number" name="stock"
                                    class="form-control {{$errors->first("stock") ? "is-invalid" : ""}}"
                                    placeholder="Stock"
                                    value="{{old("stock") ? old("stock") : $barang->details_barang->stock}}">
                                <div class="invalid-feedback">
                                    {{$errors->first("stock")}}
                                </div>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="image">Image</label>
                                <br>
                                Current Image:
                                <br>
                                @if ($barang->details_barang->image)
                                <img src="{{asset('storage/' . $barang->details_barang->image)}}" width="150px" alt="">
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
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Update
                                </button>
                                <a href="{{route('toplevel.barang.index')}}"
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
                $(":file").filestyle({});
                $(".select2").select2({});
            });
        </script>

        @endsection
