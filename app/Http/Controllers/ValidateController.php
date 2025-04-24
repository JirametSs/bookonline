<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Temployee;
use App\Models\UserBook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ValidateController extends Controller
{
    public function index()
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



        return view('validate.index', compact('employees'));
    }

    public function create()
    {
        return view('validate.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:temployee,idx',
            'T_Worku_name' => 'required|string',
            'role' => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $flag = $request->role === 'admin' ? 1 : 0;

                $emp = Temployee::where('idx', $request->username)->first();

                if (!$emp) {
                    throw new \Exception("ไม่พบผู้ใช้ใน temployee");
                }

                UserBook::updateOrCreate(
                    ['idx' => $emp->idx],
                    [
                        'flag' => $flag,
                        'fname' => $emp->fname,
                        'lname' => $emp->lname,
                        'unit_post' => $emp->T_Worku_id ?? null,
                        'status_user' => 1,
                        'user_group' => 1
                    ]
                );

                Temployee::where('idx', $emp->idx)
                    ->update(['T_Worku_name' => $request->T_Worku_name]);
            });

            return redirect()->route('validate.index')
                ->with('success', 'เพิ่มผู้ใช้ใหม่เรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['create_error' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'nullable|in:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                UserBook::query()->update(['flag' => 0]);

                if ($request->has('permissions')) {
                    foreach ($request->permissions as $idx => $value) {
                        if ($value === '1') {
                            UserBook::updateOrCreate(
                                ['idx' => $idx],
                                ['flag' => 1]
                            );
                        }
                    }
                }
            });

            return redirect()->route('validate.index')
                ->with('success', 'บันทึกสิทธิ์เรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'เกิดข้อผิดพลาดในการอัปเดตสิทธิ์: ' . $e->getMessage()]);
        }
    }

    public function edit($idx)
    {
        $employee = Temployee::findOrFail($idx);
        $userBook = UserBook::where('idx', $idx)->first();

        return view('validate.edit', [
            'employee' => $employee,
            'is_admin' => $userBook ? $userBook->flag === 1 : false
        ]);
    }

    public function updateEdit(Request $request, $idx)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'fname' => 'required|string',
            'lname' => 'required|string',
            'T_Worku_name' => 'required|string',
            'role' => 'required|in:user,admin',
            'password' => 'nullable|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request, $idx) {
                $employee = Temployee::findOrFail($idx);
                $employee->update([
                    'username' => $request->username,
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'T_Worku_name' => $request->T_Worku_name,
                    'password' => $request->filled('password')
                        ? bcrypt($request->password)
                        : $employee->password,
                ]);

                $flag = $request->role === 'admin' ? 1 : 0;
                UserBook::updateOrCreate(
                    ['idx' => $idx],
                    [
                        'flag' => $flag,
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'unit_post' => $employee->T_Worku_id ?? null,
                        'status_user' => 1,
                        'user_group' => 1
                    ]
                );
            });

            return redirect()->route('validate.index')
                ->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'เกิดข้อผิดพลาดในการอัปเดต: ' . $e->getMessage()])
                ->withInput();
        }
    }


    public function get_nameEmp(Request $request)
    {
        $term = $request->get('term');

        if (empty($term)) {
            return response()->json([]);
        }

        $results = Temployee::where('fname', 'like', '%' . $term . '%')
            ->orWhere('lname', 'like', '%' . $term . '%')
            ->select('idx', 'fname', 'lname', 'T_Worku_name')
            ->limit(20)
            ->get()
            ->map(function ($emp) {
                return [
                    'label' => $emp->fname . ' ' . $emp->lname,
                    'value' => $emp->idx,
                    'unit_name' => $emp->T_Worku_name ?? ''
                ];
            });

        return response()->json($results);
    }

    public function get_emp_detail(Request $request)
    {
        $idx = $request->input('idx');

        if (!$idx) {
            return response()->json(['error' => 'Missing idx'], 400);
        }

        $unitName = DB::table('temployee')
            ->where('idx', $idx)
            ->value('T_Worku_name');

        if (!$unitName) {
            return response()->json(['error' => 'ไม่พบข้อมูล'], 404);
        }

        return response()->json(['unit_name' => $unitName]);
    }

    public function destroy($id)
    {
        try {
            $userBook = UserBook::where('idx', $id)->delete();

            return redirect()->route('validate.index')
                ->with('success', 'ลบผู้ใช้เรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return redirect()->route('validate.index')
                ->withErrors('ไม่พบผู้ใช้ที่ต้องการลบ');
        }
    }
}
