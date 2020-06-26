
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
</style>

<html>
<head>
	<title>repot service</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h6 class="judul">UD. SARI INDAH MOTOR LUKLUK</h6>
    <p class="alamat">JL. RAYA PERANG NO. 9 LUKLUK, BADUNG BALI</p>
    <p class="phone">Telp: 03614422338</p>
    <br>
    <p class="repot">Repot Service</p>
    <table>
        <thead>
            <tr>
                <th>Nomor Invoice</th>
                <th>Tanggal Service</th>
                <th>Customer Service</th>
                <th>No Polis</th>
                <th>Tipe Motor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
            <tr>
                <td>{{ $service->invocie_number }}</td>
                <td>{{ $service->tanggal_servis }}</td>
                <td>{{ $service->customer_servis }}</td>
                <td>{{ $service->no_polis }}</td>
                <td>{{ $service->motor->tipe_motor }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
