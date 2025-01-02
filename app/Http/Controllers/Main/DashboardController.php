<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $menu = 'Dashboard';
        return view('main.dashboard')->with(['menu' => $menu]);
    }
}
