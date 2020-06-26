
 @php
 function rupiah($angka){
     $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
     return $hasil_rupiah;
 }
 @endphp

<table class="table table-bordered">
    <tr>
        <th>Tanggal Transaksi</th>
        <td>{{$pembelian->tanggl_transaksi}}</td>
      </tr>
    <tr>
        <th>Nama Supplier</th>
        <td>{{$pembelian->supplier->name_supplier}}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{$pembelian->supplier->email}}</td>
    </tr>
    <tr>
        <th>Company</th>
        <td>{{$pembelian->supplier->perusahaan}}</td>
    </tr>
    <tr>
        <th>Address</th>
        <td>{{$pembelian->supplier->address}}</td>
    </tr>
    <tr>
        <th>Phone</th>
        <td>{{$pembelian->supplier->no_telphone}}</td>
    </tr>
    <tr>
        <th>Total Transaksi</th>
        <td>{{rupiah($pembelian->total_harga)}}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            @if($pembelian->status == 'PROCESS')
            <span class="badge badge-danger">
          @elseif($pembelian->status == 'FINISH')
            <span class="badge badge-success">
          @elseif($pembelian->status == 'CANCEL')
            <span class="badge badge-warning">
          @else
            <span>
          @endif
            {{ $pembelian->status }}
            </span>
        </td>
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
               <td>{{rupiah($value->harga_beli)}}</td>
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
            <i class="fa fa-check mr-2"></i> Set Finish
        </a>
    </div>
    <div class="col">
        <a href="{{route('admin.pembelian.status', $pembelian->id)}}?status=PROCESS" class="btn btn-danger btn-block">
            <i class="fa fa-spinner mr-2"></i> Set Process
        </a>
    </div>
    <div class="col">
        <a href="{{route('admin.pembelian.status', $pembelian->id)}}?status=CANCEL" class="btn btn-warning btn-block">
            <i class="fa fa-times mr-2"></i> Set Cancel
        </a>
    </div>
</div>



