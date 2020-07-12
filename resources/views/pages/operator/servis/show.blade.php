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
        <td>{{$service->tanggal_servis}}</td>
    </tr>
    <tr>
        <th>Nama Mekanik</th>
        <td>{{$service->mekanik->name}}</td>
    </tr>
    <tr>
        <th>Nama Customer</th>
        <td>{{$service->customer_servis}}</td>
    </tr>
    <tr>
        <th>Alamat</th>
        <td>{{$service->alamat}}</td>
    </tr>
    <tr>
        <th>No Telphone</th>
        <td>{{formatPhoneNum($service->no_telphone)}}</td>
    </tr>
    <tr>
        <th>No Polis</th>
        <td>{{$service->no_polis}}</td>
    </tr>
    <tr>
        <th>Tipe Motor</th>
        <td>{{$service->motor->name}} | {{$service->motor->tipe_motor}}</td>
    </tr>
    <tr>
        <th>KM Datang</th>
        <td>{{$service->dtlservice[0]->km_datang}}</td>
    </tr>
    <tr>
        <th>Keluhan</th>
        <td>{{$service->dtlservice[0]->keluhan}}</td>
    </tr>
    <tr>
        <th>Tipe Service</th>
        <td>{{$service->dtlservice[0]->tipe_servis}}</td>
    </tr>
    <tr>
        <th>Waktu Service</th>
        <td>{{$service->dtlservice[0]->waktu_servis}}</td>
    </tr>
    <tr>
        <th>Harga Jasa</th>
        <td>{{rupiah($service->dtlservice[0]->harga_jasa)}}</td>
    </tr>
    <tr>
        <th>Total Transaksi</th>
        <td>{{rupiah($service->sub_total)}}</td>
    </tr>
    <tr>
        <th>Profit</th>
        <td>{{rupiah($service->profit)}}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            @if($service->status == 'SERVICE')
            <span class="badge badge-danger">
          @elseif($service->status == 'FINISH')
            <span class="badge badge-success">
          @elseif($service->status == 'CHECKING')
            <span class="badge badge-warning">
          @else
            <span>
          @endif
            {{ $service->status }}
            </span>
        </td>
    </tr>
    <tr>
      <th class="text-center">Service</th>
      <td>
        <table class="tabble table-bordered w-100">
          <tr>
            <th>Name Barang</th>
            <th>Harga beli</th>
            <th>Harga Jual</th>
            <th>Quantity</th>
          </tr>
            @foreach ($service->dtlservice as $value)
              <tr>
                <td>{{$value->barang->name_barang}}</td>
                <td>{{rupiah($value->harga_beli)}}</td>
                <td>{{rupiah($value->harga_jual)}}</td>
                <td>{{$value->qty}}</td>
              </tr>
            @endforeach
        </table>
      </td>
    </tr>
  </table>

  <div class="row mt-4">
    <div class="col">
        <a href="{{route('admin.servis.status', $service->id)}}?status=FINISH" class="btn btn-success btn-block">
            <i class="fa fa-check mr-2"></i> Set Finish
        </a>
    </div>
    <div class="col">
        <a href="{{route('admin.servis.status', $service->id)}}?status=CHECKING" class="btn btn-warning btn-block">
            <i class="fa fa-spinner mr-2"></i> Set Checking
        </a>
    </div>
    <div class="col">
        <a href="{{route('admin.servis.status', $service->id)}}?status=SERVICE" class="btn btn-danger btn-block">
            <i class="fa fa-times mr-2"></i> Set Service
        </a>
    </div>
</div>



