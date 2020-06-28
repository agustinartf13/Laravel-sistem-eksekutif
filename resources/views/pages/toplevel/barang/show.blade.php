@php function rupiah($angka){ $hasil_rupiah = "Rp " .
number_format($angka,0,',','.'); return $hasil_rupiah; } @endphp
<table class="table table-bordered">
    <tr>
        <th>Kode Barang</th>
        <td>{{ $barang->kode_barang }}</td>
    </tr>
    <tr>
        <th>Nama Barang</th>
        <td>{{ $barang->name_barang }}</td>
    </tr>
    <tr>
        <th>Category Barang</th>
        <td>{{ $barang->category->name }}</td>
    </tr>
    <tr>
        <th>Description</th>
        <td>{{ $barang->details_barang->description }}</td>
    </tr>
    <tr>
        <th>Image Barang</th>
        <td>
            @if($barang->details_barang->image)
            <img
                src="{{asset('storage/'. $barang->details_barang->image)}}"
                width="128px"
            />
            @else No Image @endif
        </td>
    </tr>
    <tr>
        <th>Harga Barang</th>
        <td>
            <table class="tabble table-bordered w-100">
                <tr>
                    <th>Harga Pokok</th>
                    <th>Harga Jual</th>
                    <th>Stock</th>
                </tr>
                <tr>
                    <td>{{ rupiah($barang->details_barang->harga_dasar) }}</td>
                    <td>{{ rupiah($barang->details_barang->harga_jual) }}</td>
                    <td>{{ $barang->details_barang->stock }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
