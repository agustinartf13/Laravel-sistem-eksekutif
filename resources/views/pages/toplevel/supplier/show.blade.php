<h5>Name :</h5>
<h6>{{$supplier->name_supplier}}</h6>


<h5 class="mt-4">Avatar :</h5>
@if($supplier->image)
<img src="{{asset('storage/'. $supplier->image)}}" width="128px" />
@else
<h6>No avatar</h6>
@endif

<h5 class="mt-4">Email :</h5>
<h6>{{$supplier->email}}</h6>


<h5 class="mt-4">Phone number :</h5>
<h6>{{$supplier->no_telphone}}</h6>



<h5 class="mt-4">Address</h5>
<h6>{{$supplier->address}}</h6>

<h5 class="mt-4">Status:</h5>
<h6>
    @if($supplier->status=="ACTIVE")
    <span class="badge badge-success">{{$supplier->status}}</span> @else
    <span class="badge badge-primary">{{$supplier->status}}</span> @endif
</h6>
</div>

<div class="row mt-4">
    <div class="col">
        <a href="{{route('toplevel.supplier.status', $supplier->id)}}?status=ACTIVE" class="btn btn-success btn-block">
            <i class="fa fa-check"></i> Set Active
        </a>
    </div>
    <div class="col">
        <a href="{{route('toplevel.supplier.status', $supplier->id)}}?status=INACTIVE" class="btn btn-primary btn-block">
            <i class="fa fa-times"></i> Set Inactive
        </a>
    </div>
</div>
