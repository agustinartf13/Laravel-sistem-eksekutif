@extends('layouts.login')

@section('content')

<div class="card">
    <div class="card-body">
        <div class="p-2">
            <h4 class="text-muted font-18 m-b-5 text-center">Welcome Sari Indah Motor Lukluk !</h4>
            <p class="text-muted text-center">Sign in to continue to working.</p>

            <form class="form-horizontal m-t-30" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email"
                        class="form-control {{$errors->first('email') ? "is-invalid" : ""}}" value="{{ old('email') }}"
                        autocomplete="email" autofocus id="email" placeholder="Enter Email">
                    <div class="invalid-feedback">
                        {{$errors->first('email')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password"
                        class="form-control {{$errors->first('password') ? "is-invalid" : ""}}"
                        value="{{ old('password') }}" autocomplete="password" autofocus id="password"
                        placeholder="Enter password">
                    <div class="invalid-feedback">
                        {{$errors->first('password')}}
                    </div>
                </div>
                <div class="form-group row m-t-20">
                    <div class="col-6">
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                        {{-- <button type="button" class="btn btn-danger toastrDefaultError mt-3">
                            Launch Error Toast
                        </button> --}}
                    </div>
                </div>
                <div class="form-group m-t-10 mb-0 row">
                    <div class="col-12 m-t-20">
                        <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your
                            password?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}")
    @endif

    $(document).ready(function () {
        $('.toastrDefaultError').click(function () {
            toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
        });
    })

</script>
@endsection
