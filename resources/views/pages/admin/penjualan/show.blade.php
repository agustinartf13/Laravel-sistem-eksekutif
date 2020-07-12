@php
    function rupiah($angka){
        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    function formatPhoneNum($phone){
        $phone = str_replace("-", "", $phone);// remove all the dashes
        $phone = substr($phone, 0,3) . "-" .  // add the two dashes in the right places
        substr($phone, 3,3) . "-" . substr($phone, 6);
        return $phone;
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
        <td>{{formatPhoneNum($penjualan->no_telphone)}}</td>
    </tr>
    <tr>
        <th>Address</th>
        <td>{{$penjualan->alamat}}</td>
    </tr>
    <tr>
        <th>Total Transaksi</th>
        <td>{{rupiah($penjualan->total_harga)}}</td>
    </tr>
    <tr>
        <th>Profit</th>
        <td>{{rupiah($penjualan->profit)}}</td>
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
                    <td>{{rupiah($value->harga_beli)}}</td>
                    <td>{{rupiah($value->harga_jual)}}</td>
                    <td>{{$value->qty}}</td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>
