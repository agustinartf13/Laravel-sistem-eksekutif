@extends('layouts.operator') @section('title') @endsection @section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data Persediaan Barang</h4>
            <ol class="breadcrumb">
                <li>{{ Breadcrumbs::render('persediaanOperator') }}</li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <a
                        href="{{ route('operator.persediaan.exportexcelbarang') }}"
                        class="btn btn-success btn-flat d-inline"
                        style="float: right"
                        ><i class="fa fa-print"></i> Excel</a
                    >
                    <a
                        href="{{ route('operator.persediaan.exportpdfbarang') }}"
                        class="btn btn-primary btn-flat d-inline mr-1"
                        style="float: right"
                        ><i class="fa fa-print"></i> Pdf</a
                    >
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-cube mr-2"></i>Persediaan Barang</h4>
                    <hr />
                    <table
                        id="datatable"
                        class="table table-bordered dt-responsive nowrap table-striped"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;"
                    >
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name Categories</th>
                                <th>Name Barang</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th>No.</th>
                            <th>Name Categories</th>
                            <th>Name Barang</th>
                            <th>Stock</th>
                        </tfoot>
                        <tbody>
                            {{-- data Server Side --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @endsection @section('js')

    <script text="text/javascript">
        $(document).ready(function() {
            $("#datatable").DataTable({
                aaSorting: [[0, "DESC"]],
                ajax: "{{ route('operator.api.persediaan') }}",
                columns: [
                    {
                        data: "id",
                        sortable: true,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        width: "20"
                    },
                    {
                        data: "category.name",
                        name: "category.name"
                    },
                    {
                        data: "name_barang",
                        name: "name_barang"
                    },
                    {
                        data: "details_barang.stock",
                        name: "details_barang.stock"
                    }
                ]
            });
        });
    </script>
    @endsection
</div>
