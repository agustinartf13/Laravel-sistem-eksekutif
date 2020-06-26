@php
function rupiah($angka){
    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
    return $hasil_rupiah;
}
@endphp

<table class="table table-bordered">
    <tr>
        <th>Tanggal Transaksi</th>
        <td>{{$penjualan->tanggal_transaksi}}</td>
      </tr>
    <tr>
        <th>Nama Pembeli</th>
        <td>{{$penjualan->name_pembeli}}</td>
    </tr>
    <tr>
        <th>No Phone</th>
        <td>{{$penjualan->no_telphone}}</td>
    </tr>
    <tr>
        <th>Address</th>
        <td>{{$penjualan->alamat}}</td>
    </tr>
    <tr>
        <th>Total Transaksi</th>
        <td>{{$penjualan->total_harga}}</td>
    </tr>
    <tr>
        <th>Profit</th>
        <td>{{$penjualan->profit}}</td>
    </tr>

    <tr>
      <th>Pembelian Barang</th>
      <td>
        <table class="tabble table-bordered w-100">
          <tr>
            <th>Name Barang</th>
            <th>Harga Pokok</th>
            <th>Harga Jual</th>
            <th>Quantity</th>
          </tr>
            @foreach ($penjualan->dtlpenjualans as $value)
              <tr>
               <td>{{$value->barangs->name_barang}}</td>
               <td>{{$value->harga_beli}}</td>
               <td>{{$value->harga_jual}}</td>
               <td>{{$value->qty}}</td>
              </tr>
            @endforeach
        </table>
      </td>
    </tr>
  </table>


