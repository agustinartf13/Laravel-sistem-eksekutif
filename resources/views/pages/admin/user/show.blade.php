<style>
    .img-user {
        height: 155px;
        width: 155px;
    }
</style>
<!-- Profile Image -->
<div class="card-body box-profile">
    <div class="text-center">
        <div class="">
            <img class="rounded-circle shadow img-user" src="{{ url('assets/images/admin.png') }}"
                data-holder-rendered="true">
        </div>
    </div>

    <h3 class="profile-username text-center">{{ $user->name }}</h3>

    <p class="text-muted text-center">{{ $user->username }}</p>

    <ul class="list-group list-group-unbordered mb-3">
        <li class="list-group-item">
            <b>Email</b> <a class="float-right">{{ $user->email }}</a>
        </li>
        <li class="list-group-item">
            <b>Address</b> <a class="float-right">{{ $user->address }}</a>
        </li>
        <li class="list-group-item">
            <b>Status</b> <a class="float-right"> @if($user->status=="ACTIVE")
                <span class="badge badge-success">{{$user->status}}</span> @else
                <span class="badge badge-primary">{{$user->status}}</span> @endif</a>
        </li>
        <li class="list-group-item">
            <b>Phone Number</b> <a class="float-right">{{ $user->no_telphone }}</a>
        </li>
    </ul>

    <a href="{{ route('admin.user.edit', ['user' => $user->id]) }}" class="btn btn-info btn-block"><b>Edit User</b></a>
</div>
<!-- /.card-body -->
