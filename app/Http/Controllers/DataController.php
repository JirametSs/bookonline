<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function edit($id)
    {
        $circular = Book::findOrFail($id);
        $departments = DB::table('tunit')->pluck('unit_name', 'unit_id');
        $booktypes = DB::table('booktype')->get();

        return view('circulars.edit', compact('circular', 'departments', 'booktypes'));
    }

    public function update(Request $request, $id)
    {
        ini_set('memory_limit', '512M');

        $circular = Book::findOrFail($id);

        $validated = $request->validate([
            'topic' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'page_no' => 'nullable|integer|min:1',
            'date' => 'nullable|date',
            'unit_id' => 'nullable',
            'book_name' => 'nullable|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:6144',
            'hilight' => 'nullable|string|max:255',
            'piority' => 'nullable|integer|min:0|max:5',
            //'display_days' => 'nullable|integer|min:1|max:30',
            'pic_upload' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // อัปเดตทั่วไป
        $circular->topic        = $validated['topic'] ?? $circular->topic;
        $circular->booktype     = $validated['category'] ?? $circular->booktype;
        $circular->page_no      = $validated['page_no'] ?? $circular->page_no;
        $circular->rec_date     = $validated['date'] ?? $circular->rec_date;

        // หน่วยงาน
        if ($request->filled('unit_id')) {
            $unitName = DB::table('tunit')->where('unit_id', $request->unit_id)->value('unit_name');
            $circular->unit_id = $request->unit_id;
            $circular->unit_name = $unitName ?? '';
            $circular->unit_out_name = '';
        } elseif ($request->filled('book_name')) {
            $circular->unit_id = null;
            $circular->unit_name = '';
            $circular->unit_out_name = $request->book_name;
        } else {
            $circular->unit_id = null;
            $circular->unit_name = '';
            $circular->unit_out_name = '';
        }

        // PDF
        if ($request->hasFile('pdf_file')) {
            $pdf = $request->file('pdf_file');
            $circular->file_upload = file_get_contents($pdf);
            $circular->file_name = $pdf->getClientOriginalName();
            $circular->file_size = $pdf->getSize();
            $circular->file_type = $pdf->getClientMimeType();
        }

        // รูปภาพ
        if ($request->hasFile('pic_upload')) {
            $image = $request->file('pic_upload');
            $circular->pic_upload = base64_encode(file_get_contents($image));
            $request->validate(['display_days' => 'nullable|integer|min:1|max:30']);
        }

        // ฟิลด์เพิ่มเติม
        $circular->notice = $request->has('news_type') && in_array('ทั่วไป', $request->news_type) ? '1' : '';
        $circular->hilight = $validated['hilight'] ?? null;
        $circular->piority = $validated['piority'] ?? 0;
        $circular->day_show = (int) ($validated['display_days'] ?? "");
        $circular->end_date = now()->addDays($circular->day_show);

        $circular->save();

        return redirect()->route('circulars.index')->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }

    public function deleteImage($id)
    {
        $circular = Book::findOrFail($id);
        $circular->pic_upload = null;
        $circular->save();

        return response()->json(['message' => 'ลบรูปภาพเรียบร้อยแล้ว']);
    }
}
