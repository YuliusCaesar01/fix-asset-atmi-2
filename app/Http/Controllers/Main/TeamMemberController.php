<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Userdetail;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    protected  $menu = 'Karyawan';
    public function index()
    {
        $data = User::whereHas(
            'roles',
            function ($query) {
                $query->where('name', 'staff');
            }
        )->get();

        return view('main.alluser')->with(['user' => $data, 'menu' => $this->menu]);
    }
}
