<h5>Name :</h5>
<h6>{{$mekanik->name}}</h6>


<h5 class="mt-4">Avatar :</h5>
@if($mekanik->image)
<img src="{{asset('storage/'. $mekanik->image)}}" width="128px" />
@else
<h6>No avatar</h6>
@endif

<h5 class="mt-4">Email :</h5>
<h6>{{$mekanik->email}}</h6>


<h5 class="mt-4">Phone number :</h5>
<h6>{{$mekanik->no_telphone}}</h6>



<h5 class="mt-4">Address</h5>
<h6>{{$mekanik->address}}</h6>

<h5 class="mt-4">Status:</h5>
<h6>
    @if($mekanik->status=="ACTIVE")
    <span class="badge badge-success">{{$mekanik->status}}</span> @else
    <span class="badge badge-primary">{{$mekanik->status}}</span> @endif
</h6>
</div>

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
