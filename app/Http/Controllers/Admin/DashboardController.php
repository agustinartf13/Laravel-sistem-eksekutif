<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view('pages.admin.dashboard');
    }
}