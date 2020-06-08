@extends('layouts.toplevel')
@section('title')

@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data Motor</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('toplevel.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('toplevel.motor.index') }}">Motor</a></li>
                <li class="breadcrumb-item active"><a href=""></a> Edit Motor</li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-lg-8">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0"><i class="mdi mdi-cube"></i> Edit Data</h4>
                    <hr>
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <form action="{{route('toplevel.motor.update', $motor->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <div class="form-group mt-3">
                            <label>Name Motor</label>
                            <input type="text" name="name"
                                class="form-control {{$errors->first("name") ? "is-invalid" : ""}}"
                                placeholder="Type something" value="{{old("name") ? old("name") : $motor->name}}" />
                            <div class="invalid-feedback">
                                {{$errors->first("name")}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tipe Motor</label>
                            <input type="text" name="tipe_motor"
                                class="form-control {{$errors->first("tipe_motor") ? "is-invalid" : ""}}"
                                placeholder="Type something"
                                value="{{old("tipe_motor") ? old("tipe_motor") : $motor->tipe_motor}}" />
                            <div class="invalid-feedback">
                                {{$errors->first("tipe_motor")}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Motor</label>
                            <div class="form-group">
                                <select name="jenis"
                                    class="form-control select2 {{$errors->first("jenis") ? "is-invalid" : ""}}"
                                    value="{{old("jenis")}}">
                                    <option value="AUTOMATIC" {{($motor->jenis == "AUTOMATIC") ? "checked" : ''}}>
                                        AUTOMATIC</option>
                                    <option value="MANUAL" {{($motor->jenis == "MANUAL") ? "checked" : ''}}>MANUAL
                                    </option>
                                </select>
                                <div class="invalid-feedback">
                                    {{$errors->first("jenis")}}
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Update
                                </button>
                                <a href="{{route('toplevel.motor.index')}}"
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
                $(":file").filestyle();
                $('.select2').select2();
            });

        </script>
        @endsection
