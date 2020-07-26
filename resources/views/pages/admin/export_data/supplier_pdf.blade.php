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
    <title>repot supplier</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h6 class="judul">UD. SARI INDAH MOTOR LUKLUK</h6>
    <p class="alamat">JL. RAYA PERANG NO. 9 LUKLUK, BADUNG BALI</p>
    <p class="phone">Telp: 03614422338</p>
    <br>
    <p class="repot">Repot list Supplier</p>
    <p class="priode">Priode Tahun: {{ $year_today }}</p>
    <table>
        <thead>
            <tr>
                <th>Nama Supplier</th>
                <th>Email</th>
                <th>Perusahaan</th>
                <th>No Telphone</th>
                <th>address</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->name_supplier }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->perusahaan }}</td>
                <td>{{ $supplier->no_telphone }}</td>
                <td>{{ $supplier->address }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
