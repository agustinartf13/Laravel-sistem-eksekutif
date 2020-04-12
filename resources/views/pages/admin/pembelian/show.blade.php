<table class="table table-bordered">
    <tr>
        <th>Tanggal Transaksi</th>
        <td>{{$pembelian->tanggl_transaksi}}</td>
      </tr>
    <tr>
        <th>Nama Pembeli</th>
        <td>{{$pembelian->supplier->name_supplier}}</td>
    </tr>
    <tr>
        <th>Total Transaksi</th>
        <td>{{$pembelian->total_harga}}</td>
    </tr>

    <tr>
      <th>Pembelian Barang</th>
      <td>
        <table class="tabble table-bordered w-100">
          <tr>
            <th>Category Barang</th>
            <th>Name Barang</th>
            <th>Harga beli</th>
            <th>Quantity</th>
          </tr>
            @foreach ($pembelian->dtlpembelian as $value)
              <tr>
            <td>{{$value->category->name}}</td>
               <td>{{$value->barang->name_barang}}</td>
               <td>{{$value->harga_beli}}</td>
               <td>{{$value->qty}}</td>
              </tr>
            @endforeach
        </table>
      </td>
    </tr>
  </table>

  <div class="row mt-4">
    <div class="col">
        <a href="{{route('admin.pembelian.status', $pembelian->id)}}?status=FINISH" class="btn btn-success btn-block">
            <i class="fa fa-check"></i> Set Finish
        </a>
    </div>
    <div class="col">
        <a href="{{route('admin.pembelian.status', $pembelian->id)}}?status=PROCESS" class="btn btn-danger btn-block">
            <i class="fa fa-spinner fa-spin"></i> Set Process
        </a>
    </div>
    <div class="col">
        <a href="{{route('admin.pembelian.status', $pembelian->id)}}?status=CANCEL" class="btn btn-warning btn-block">
            <i class="fa fa-times"></i> Set Cancel
        </a>
    </div>
</div>



