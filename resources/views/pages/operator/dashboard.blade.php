@extends('layouts.operator')
@section('title')

@endsection
@section('content')
<div class="col-sm-12">
      <div class="title-box mt-3">
          <h4>Dashboard</h4>
      </div>
  </div>
<div class="row">
  <div class="col-sm-12">
      <div class="title-box mt-3">
        <div class="col-lg">
            <div class="card m-b-30" style="background-color: #cfcfcf;" >
                <div class="card-body">
                    <blockquote class="card-blockquote mb-0">
                        <p><h4>Hallo!!</h4></p>
                        <footer class="blockquotetext-white font-12">
                            <h6>Wellcome to Dashboard {{Auth::user()->username}}</h6>
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
<!-- end row -->

<div class="page-content-wrapper mt-3">
<div class="row">

</div>
<!-- end row -->
</div>

@endsection
@section('js')
<script>
     @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}")
    @endif
</script>
@endsection
