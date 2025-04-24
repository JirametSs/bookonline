<?php

namespace App\Http\Controllers;

use App\Models\Temployee;
use App\Models\UserBook;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = Temployee::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'ไม่พบชื่อผู้ใช้นี้ในระบบ',
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'username' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            ])->withInput();
        }

        $isAdminRecord = UserBook::where('idx', $user->idx)->exists();
        $role = $isAdminRecord ? 'admin' : 'user';
        $unit_post = $isAdminRecord?->unit_post ?? null;

        session([
            'user' => $user,
            'username' => $user->username,
            'fullname' => $user->prefix_short . ' ' . $user->fname . ' ' . $user->lname,
            'position' => $user->position ?? '',
            't_worku_name' => $user->T_Worku_name ?? '',
            'idx' => $user->idx,
            't_work_id' => $user->T_Work_id,
            't_worku_id' => $user->T_Worku_id,
            'role' => $role,
            'unit_post' => $user->T_Worku_id ?? null,
        ]);


        return redirect()->route('circulars.index');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
}
