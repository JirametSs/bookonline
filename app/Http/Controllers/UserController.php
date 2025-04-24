<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function self()
    {
        $user = session('user'); // ดึงข้อมูลจาก session
        return view('users.self', compact('user'));
    }
}
