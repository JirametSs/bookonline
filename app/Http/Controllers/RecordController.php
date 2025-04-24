<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('book_unit')
            ->select('unit_id', 'unit_name', 'rec_date', 'insert_date')
            ->where('flag', '1');
        //$query = Book::query()->where('flag', '1');
        if ($request->filled('unit')) {
            $keyword = $request->input('unit');
            $query->where('unit_name', 'like', '%' . $keyword . '%');
        }

        $records = $query->orderBy('unit_id', 'desc')->paginate(20);

        return view('record', compact('records'));
    }

    public function show($id)
    {
        $unit = DB::table('book_unit')
            ->where('unit_id', $id)
            ->where('flag', '1')
            ->first();

        if (!$unit) {
            return redirect()->route('record.index')->withErrors(['not_found' => 'ไม่พบหน่วยงาน']);
        }

        return view('record_show', compact('unit'));
    }

    public function delete($id)
    {
        DB::table('book_unit')->where('unit_id', $id)->update(['flag' => 0]);

        return redirect()->route('record.index')->with('status', "ลบหน่วยงาน ID: {$id} เรียบร้อยแล้ว");
    }

    public function update(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255',
        ]);

        $unitName = trim($request->unit_name);
        $now = now();

        try {
            if ($request->filled('unit_id') && intval($request->unit_id) > 0) {
                // Update หน่วยงานเดิม
                DB::table('book_unit')
                    ->where('unit_id', $request->unit_id)
                    ->update([
                        'unit_name' => $unitName,
                        'rec_date' => $now,
                        'flag' => 1, // กรณีเคยถูกซ่อน จะเปิดให้ใช้งานอีกครั้ง
                    ]);

                $message = 'อัปเดตชื่อหน่วยงานเรียบร้อยเมื่อเวลา ' . $now->format('H:i');
            } else {
                // เพิ่มหน่วยงานใหม่ พร้อม flag = 1
                $newId = DB::table('book_unit')->max('unit_id') + 1;
                while (DB::table('book_unit')->where('unit_id', $newId)->exists()) {
                    $newId++;
                }

                DB::table('book_unit')->insert([
                    'unit_id' => $newId,
                    'unit_name' => $unitName,
                    'insert_date' => $now,
                    'rec_date' => $now,
                    'flag' => 1
                ]);

                $message = 'เพิ่มหน่วยงานใหม่เรียบร้อยเมื่อเวลา ' . $now->format('H:i');
            }

            return redirect()->route('record.index')
                ->with('saved_success', $message);
        } catch (\Exception $e) {
            return redirect()->route('record.index')
                ->withErrors(['db_error' => $e->getMessage()]);
        }
    }
}
