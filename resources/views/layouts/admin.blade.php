<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>Admin Dashboard</title>
<meta content="Admin Dashboard" name="description" />
<meta content="Themesbrand" name="author" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="assets/images/favicon.ico">

@include('includes.style');

</head>

<body>

<!-- Begin page -->
<div id="wrapper">

<!-- Top Bar Start -->
<div class="topbar">

<!-- LOGO -->
<div class="topbar-left">
<a href="index.html" class="logo">
<h3 class="mt-3" style="color: white">AHSS</h3>
</a>
</div>
<nav class="navbar-custom">
<ul class="navbar-right d-flex list-inline float-right mb-0">
<li class="dropdown notification-list d-none d-sm-block">
<form role="search" class="app-search">
    <div class="form-group mb-0">
        <input type="text" class="form-control" placeholder="Search..">
        <button type="submit"><i class="fa fa-search"></i></button>
    </div>
</form>
</li>
<li class="dropdown notification-list">
<div class="dropdown notification-list nav-pro-img">
<a class="dropdown-toggle nav-link arrow-none waves-effect nav-user waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
    <img src="{{url('assets/images/users/user-4.jpg')}}" alt="user" class="rounded-circle">
</a>
<form action="{{route('logout')}}" method="POST">
    @csrf
<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
    <!-- item-->
    <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5"></i> Profile</a>
    <a class="dropdown-item d-block" href="#"><i class="mdi mdi-settings m-r-5"></i> Settings</a>
    <button class="dropdown-item text-danger" type="submit"><i class="mdi mdi-power text-danger"></i> Logout</button>
</div>
</form>
</div>
</li>
</ul>
<ul class="list-inline menu-left mb-0">
	<li class="float-left">
			<button class="button-menu-mobile open-left waves-effect waves-light">
					<i class="mdi mdi-menu"></i>
			</button>
	</li>
</ul>

</nav>

</div>
<!-- Top Bar End -->

<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu side-menu-dark">
<div class="slimscroll-menu" id="remove-scroll">
    <div class="user-details">
        <div class="float-left mr-2">
            <img src="{{url('assets/images/users/user-4.jpg')}}" alt="" class="thumb-md rounded-circle">
        </div>
        <div class="user-info">
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{Auth::user()->username}}
                </a>
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-account-circle m-r-5"></i> <span class="text-dark">Profile</span><div class="ripple-wrapper"></div></a></li>
                    <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-settings m-r-5"></i> <span class="text-dark">Settings</span></a></li>
                    <li>
                        <button type="submit" class="dropdown-item"><i class="mdi mdi-power m-r-5"></i><span class="text-dark">Logout</span> </button>
                    </li>
                </ul>
            </form>
        </div>
        <p class="text-white-50 m-0">{{Auth::user()->name}}</p>
    </div>
</div>
<!--- Sidemenu -->
<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu" id="side-menu">
        <li class="menu-title">Main</li>
        <li>
            <a href="{{route('admin.dashboard')}}" class="waves-effect">
                <i class="mdi mdi-home"></i><span> Dashboard </span>
            </a>
        </li>
        <li>
            <a href="{{route('admin.user.index')}}" class="waves-effect">
                <i class="mdi mdi-account-box"></i><span> User </span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-database-search"></i><span> Manage Data <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
            <ul class="submenu">
                <li>
                    <a href="{{route('admin.mekanik.index')}}">
                        Mechanic </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.supplier.index')}}">
                        Suppliers </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.categories.index')}}">
                        Category </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.motor.index')}}">
                        Motor </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.barang.index')}}">
                        Barang </span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-title">Main Menu</li>
        <li>
            <a href="{{route('admin.persediaan')}}" class="waves-effect">
                <i class="mdi mdi-buffer"></i><span> Persediaan </span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-database-search"></i><span> Transaksi <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
            <ul class="submenu">
                <li>
                    <a href="{{route('admin.servis.index')}}" class="waves-effect">
                        <i class="mdi mdi-file-document-box"></i><span> Service </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.pembelian.index')}}" class="waves-effect">
                        <i class="mdi mdi-cart-outline"></i><span> Pembalian </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.penjualan.index')}}" class="waves-effect">
                        <i class="mdi mdi-cart-plus"></i><span> Penjualan </span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" class="waves-effect"><i class="mdi mdi-email"></i><span> Repot <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
            <ul class="submenu">
                <li><a href="{{route('admin.laporan.service')}}"> Service</a></li>
                <li><a href="{{route('admin.laporan.beli')}}"> Pembelian</a></li>
                <li><a href="{{route('admin.laporan.jual')}}"> Penjualan</a></li>
            </ul>
        </li>
        <li>
            <a href="{{route('admin.peramalan')}}" class="waves-effect">
                <i class="mdi mdi-google-analytics"></i><span> Peramalan </span>
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
			@yield('content')
        </div>
    </div>
	<!-- content -->

    <footer class="footer">
        © 2020 Agustina <span class="d-none d-sm-inline-block">- Copy Right by Themesbrand.</span>
    </footer>

</div>


<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->

@include('includes.script');

</body>

</html>
