<style>
    .judul {
        font-family: arial, sans-serif;
        text-align: center;
        font-size: 20px;
    }

    .alamat {
        font-family: arial, sans-serif;
        font-size: 14px;
        text-align: center;
        margin-top: -18px;
    }

    .phone {
        font-family: arial, sans-serif;
        font-size: 14px;
        text-align: center;
        margin-top: -10px;
    }

    .b {
        font-family: arial, sans-serif;
        border: 5px;
    }

    .repot {
        font-family: arial, sans-serif;
        font-size: 18px;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    .priode {
        font-family: arial, sans-serif;
        margin-top: -10px;
    }

</style>

<html>

<head>
    <title>repot penjualan</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h6 class="judul">UD. SARI INDAH MOTOR LUKLUK</h6>
    <p class="alamat">JL. RAYA PERANG NO. 9 LUKLUK, BADUNG BALI</p>
    <p class="phone">Telp: 03614422338</p>
    <br>
    <p class="repot">Repot Penjualan</p>
    <p class="priode">Priode Tahun: {{ $year_today }}</p>
    <table>
        <thead>
            <tr>
                <th>Nomor Invoice</th>
                <th>Tanggal Transaksi</th>
                <th>Name Customer</th>
                {{-- <th>Qty</th> --}}
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php function rupiah($angka){ $hasil_rupiah = "Rp" .
            number_format($angka,0,',','.'); return $hasil_rupiah; }
            @endphp
            @php
            $totalqty = 0;
            @endphp
            @foreach ($penjualans as $penjualan)
            <tr>
                <td>{{ $penjualan->invoice_number }}</td>
                <td>{{ $penjualan->tanggal_transaksi }}</td>
                <td>{{ $penjualan->name_pembeli }}</td>
                {{-- <td>{{ $penjualan->qty }}</td> --}}
                <td>{{ rupiah($penjualan->total_harga) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
