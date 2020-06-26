
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
    td, th {
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
	<title>repot persediaan</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h6 class="judul">UD. SARI INDAH MOTOR LUKLUK</h6>
    <p class="alamat">JL. RAYA PERANG NO. 9 LUKLUK, BADUNG BALI</p>
    <p class="phone">Telp: 03614422338</p>
    <br>
    <p class="repot">Repot Persediaan Barang</p>
    <p class="priode">Priode Tahun: {{ $year_today }}</p>
    <table>
        <thead>
            <tr>
                <th>Category Barang</th>
                <th>Name Barang</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
            <tr>
                <td>{{ $barang->category->name }}</td>
                <td>{{ $barang->name_barang }}</td>
                <td>{{ $barang->details_barang->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
