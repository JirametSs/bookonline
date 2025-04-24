<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListAdminController extends Controller
{
    public function index()
    {
        $admins = DB::table('user_book')
            ->join('tunit', 'user_book.unit_post', '=', 'tunit.unit_id')
            ->select(
                'user_book.idx',
                'user_book.user_id',
                'user_book.fname',
                'user_book.lname',
                'tunit.unit_name',
                'user_book.user_group'
            )
            ->where('user_book.user_group', '1')
            ->get();
        // exit;

        return view('validate.index', compact('admins'));
    }

    public function createAdmin()
    {
        $employees = DB::table('temployee')
            ->leftJoin('user_book', 'temployee.idx', '=', 'user_book.idx')
            ->select(
                'temployee.idx',
                'temployee.fname',
                'temployee.lname',
                'temployee.T_Worku_name as unit_name',
                'temployee.prefix_short',
                'temployee.username',
                'temployee.T_Work_name',
                'temployee.position_name',
                'temployee.tel_o',
                'temployee.email_cmu',
                'user_book.flag'
            )
            ->whereRaw("CONCAT(temployee.fname, ' ', temployee.lname) != ?", ['พิพิธภูมิ จุฐาเกต'])
            ->orderBy('temployee.idx')
            ->get();

        $adminIdxList = DB::table('user_book')->pluck('idx')->toArray();

        foreach ($employees as $employee) {
            $employee->is_admin = in_array($employee->idx, $adminIdxList);
        }

        return view('validate.createAdmin', compact('employees'));
    }

    public function update(Request $request, $id)
    {
        // ตัวอย่าง: แก้ไขข้อมูลผู้ใช้
        $admin = DB::table('user_book')->where('user_id', $id)->first();

        // ตรวจสอบว่ามีหรือไม่
        if (!$admin) {
            return redirect()->back()->withErrors(['ไม่พบข้อมูลผู้ดูแล']);
        }

        // อัปเดตข้อมูล (ตัวอย่าง: เปลี่ยน group)
        DB::table('user_book')->where('user_id', $id)->update([
            'user_group' => $request->input('user_group'),
        ]);

        return redirect()->route('listadmin.index')->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }
}
