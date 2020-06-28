
<style>
    .img-user{
        height: 155px;
        width: 155px;
    }
</style>
<!-- Profile Image -->
<div class="card-body box-profile">
    <div class="text-center">
        <div class="">
            <img class="rounded-circle shadow img-user" src="{{ url('assets/images/admin.png') }}" data-holder-rendered="true">
        </div>
    </div>

    <h3 class="profile-username text-center">{{$mekanik->name}}</h3>

    <p class="text-muted text-center">Mekanik</p>

    <ul class="list-group list-group-unbordered mb-3">
    <li class="list-group-item">
        <b>Email</b> <a class="float-right">{{ $mekanik->email }}</a>
    </li>
    <li class="list-group-item">
        <b>Address</b> <a class="float-right">{{ $mekanik->address }}</a>
    </li>
    <li class="list-group-item">
        <b>Status</b> <a class="float-right"> @if($mekanik->status=="ACTIVE")
            <span class="badge badge-success">{{$mekanik->status}}</span> @else
            <span class="badge badge-primary">{{$mekanik->status}}</span> @endif</a>
    </li>
    <li class="list-group-item">
        <b>Phone Number</b> <a class="float-right">{{ $mekanik->no_telphone }}</a>
    </li>
    </ul>

    <a href="{{ route('admin.mekanik.edit', ['mekanik' => $mekanik->id]) }}" class="btn btn-info btn-block"><b>Edit Mekanik</b></a>

    <div class="row mt-4">
        <div class="col">
            <a href="{{route('admin.mekanik.status', $mekanik->id)}}?status=ACTIVE" class="btn btn-success btn-block">
                <i class="fa fa-check"></i> Set Active
            </a>
        </div>
        <div class="col">
            <a href="{{route('admin.mekanik.status', $mekanik->id)}}?status=INACTIVE" class="btn btn-primary btn-block">
                <i class="fa fa-times"></i> Set Inactive
            </a>
        </div>
    </div>

    </div>

