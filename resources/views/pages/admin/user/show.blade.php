<h5>Name :</h5>
<h6>{{$user->name}}</h6>


<h5 class="mt-4">Avatar :</h5>
@if($user->image)
<img src="{{asset('storage/'. $user->image)}}" width="128px" />
@else
<h6>No avatar</h6>
@endif

<h5 class="mt-4">Email :</h5>
<h6>{{$user->email}}</h6>


<h5 class="mt-4">Phone number :</h5>
<h6>{{$user->no_telphone}}</h6>



<h5 class="mt-4">Address</h5>
<h6>{{$user->address}}</h6>

<h5 class="mt-4">Status:</h5>
<h6>
    @if($user->status=="ACTIVE")
    <span class="badge badge-success">{{$user->status}}</span> @else
    <span class="badge badge-primary">{{$user->status}}</span> @endif
</h6>
</div>

