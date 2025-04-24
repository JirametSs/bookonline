<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\Book;


class CircularController extends Controller
{
    public function index(Request $request)
    {
        try {
            $booktypes = DB::table('booktype')->get();
            $booktypesLookup = $booktypes->keyBy('booktype');
            $unitnames = DB::table('book_unit')->pluck('unit_name', 'unit_id');
        } catch (\Exception $e) {
            return back()->withErrors(['db_error' => 'ไม่สามารถเชื่อมต่อฐานข้อมูล: ' . $e->getMessage()]);
        }

        $thaiMonths = [
            'มกราคม' => 1,
            'กุมภาพันธ์' => 2,
            'มีนาคม' => 3,
            'เมษายน' => 4,
            'พฤษภาคม' => 5,
            'มิถุนายน' => 6,
            'กรกฎาคม' => 7,
            'สิงหาคม' => 8,
            'กันยายน' => 9,
            'ตุลาคม' => 10,
            'พฤศจิกายน' => 11,
            'ธันวาคม' => 12,
        ];

        $selectedMonth = $request->month ?? '';
        $selectedMonthNum = $thaiMonths[$selectedMonth] ?? null;
        $selectedYear = $request->year ?? '';
        $selectedYearNum = $selectedYear ? ((int)$selectedYear - 543) : null;
        $selectedCategory = $request->category ?? '';
        $keyword = $request->keyword ?? '';
        $now = now();
        $selectedMonth = $request->month ?? $now->locale('th')->monthName;
        $selectedYear = $request->year ?? ($now->year + 543);


        $query = Book::query()->where('flag', '1');

        if ($keyword) {
            $query->where('topic', 'like', '%' . $keyword . '%');
        }
        if ($selectedCategory) {
            $query->where('booktype', $selectedCategory);
        }
        if ($selectedMonthNum) {
            $query->whereMonth('rec_date', $selectedMonthNum);
        }
        if ($selectedYearNum) {
            $query->whereYear('rec_date', $selectedYearNum);
        }

        $circulars = $query->orderByDesc('book_id')->paginate(1000)->appends([
            'keyword' => $keyword,
            'month' => $selectedMonth,
            'year' => $selectedYear,
            'category' => $selectedCategory,
        ]);

        foreach ($circulars as $item) {
            $item->department_name = $item->unit_id
                ? ($unitnames[$item->unit_id] ?? 'ไม่ระบุ')
                : ($item->unit_out_name ?? 'ไม่ระบุ');

            $item->category_name = $booktypesLookup[$item->booktype]->booktype_desc ?? 'ไม่ระบุ';
        }

        $highlightBooks = DB::table('book')
            ->select('book_id', 'hilight', 'pic_upload', 'no_read')
            ->where('flag', '1')
            ->where('notice', '1')
            ->whereDate('end_date', '>=', now())
            ->where('piority', '!=', '0')
            ->orderBy('piority', 'asc')
            ->get();

        return view('circulars.index', compact(
            'circulars',
            'booktypes',
            'selectedMonth',
            'selectedYear',
            'selectedCategory',
            'keyword',
            'highlightBooks'
        ));
    }

    public function create()
    {
        ini_set('memory_limit', '512M');

        $booktypes = DB::table('booktype')->get();
        $departments = DB::table('tunit')->pluck('unit_name', 'unit_id');
        $bookgroups = DB::table('book_group')->pluck('bookgroup_name', 'bookgroup_id');

        return view('circulars.create', compact('booktypes', 'departments', 'bookgroups'));
    }

    public function store(Request $request)
    {
        ini_set('memory_limit', '512M');

        $hasAccessGroup = is_array($request->access_group) && count($request->access_group) > 0;

        $rules = [
            'topic' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'page_no' => 'required|integer|min:1',
            'date' => 'required|date',
            'pdf_file' => 'required|file|mimes:pdf|max:6144',
            'unit_id' => 'nullable|string|max:10',
            'book_name' => 'nullable|string|max:255',
            'image' => $hasAccessGroup ? 'required|file|mimes:jpeg,jpg,png|max:2048' : 'nullable|file|mimes:jpeg,jpg,png|max:2048',
            'hilight' => $hasAccessGroup ? 'required|string|max:255' : 'nullable|string|max:255',
            'piority' => $hasAccessGroup ? 'required|integer|min:0|max:10' : 'nullable|integer|min:0|max:10',

        ];

        $validated = $request->validate($rules);

        // PDF Upload
        $pdf = $request->file('pdf_file');
        $pdfName = time() . '_' . $pdf->getClientOriginalName();
        $pdfData = file_get_contents($pdf);
        Storage::disk('public')->put("pdfs/{$pdfName}", $pdfData);

        // Image Upload
        $base64Image = null;
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imageData = file_get_contents($image);
            $base64Image = base64_encode($imageData);
            Storage::disk('public')->put("images/{$imageName}", $imageData);
        }

        // Session & Metadata
        $user = session('user') ?? ['id' => '01', 'idx' => '99'];
        $unitPost = session('unit_post') ?? '';
        $now = now();
        $displayDays = (int) ($request->input('display_days', 0));
        $unitName = $request->unit_id
            ? DB::table('tunit')->where('unit_id', $request->unit_id)->value('unit_name') ?? ''
            : '';

        $userGroup = DB::table('user_book')
            ->where('idx', $user['idx'])
            ->value('user_group') ?? '001';


        $user_id = DB::table('user_book')
            ->where('idx', $user['idx'])
            ->value('user_id') ?? '';

        // Save
        try {
            Book::create([
                'booktype' => $validated['category'],
                'book_no' => $now->format('YmdHis'),
                'topic' => $validated['topic'],
                'unit_id' => $request->unit_id,
                'unit_post' => $unitPost,
                'unit_name' => $unitName,
                'unit_out_name' => $request->unit_id ? '' : $request->book_name,
                'page_no' => $validated['page_no'],
                'file_upload' => $pdfData,
                'file_name' => $pdfName,
                'file_size' => $pdf->getSize(),
                'file_type' => $pdf->getClientOriginalExtension(),
                'flag' => '1',
                'insert_date' => $now,
                'rec_date' => $validated['date'],
                'user_id' => $user_id,
                'idx' => $user['idx'],
                'no_read' => 0,
                'bookadmin_group' => $userGroup,
                'notice' => $hasAccessGroup ? '1' : "",
                'hilight' => $validated['hilight'] ?? '',
                'piority' => $validated['piority'] ?? 0,
                'day_show' => $displayDays,
                'count30day' => $displayDays,
                'end_date' => $now->copy()->addDays($displayDays),
                'pic_upload' => $base64Image,
            ]);

            return redirect()->route('circulars.record')->with('success', 'เพิ่มหนังสือเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            if (!empty($pdfName)) Storage::disk('public')->delete("pdfs/{$pdfName}");
            if (!empty($imageName)) Storage::disk('public')->delete("images/{$imageName}");
            return back()->withErrors(['db_error' => 'ไม่สามารถบันทึกข้อมูล: ' . $e->getMessage()])->withInput();
        }
    }


    public function edit($id)
    {
        $circular = Book::findOrFail($id);

        $departments = DB::table('tunit')->pluck('unit_name', 'unit_id');
        $booktypes = DB::table('booktype')->get();
        $bookgroups = DB::table('book_group')->pluck('bookgroup_name', 'bookgroup_id');

        $circular->access_group_array = $circular->bookadmin_group
            ? explode(',', $circular->bookadmin_group)
            : [];
        $circular->unit_internal_selected = $circular->unit_id ?? null;
        $circular->unit_external_name = $circular->unit_id ? null : ($circular->unit_out_name ?? '');

        return view('circulars.edit', compact(
            'circular',
            'booktypes',
            'departments',
            'bookgroups'
        ));
    }

    public function update(Request $request, $id)
    {
        ini_set('memory_limit', '512M');

        $circular = Book::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'pages' => 'required|integer|min:1',
            'date' => 'required|date',
            'pdf_file' => 'nullable|file|mimes:pdf|max:6144',
            'image' => 'nullable|image|max:5120',
            'access_group' => 'nullable|array',
            'highlight' => 'nullable|string|max:255',
            'piority' => 'nullable|integer|min:0|max:5',
            'display_days' => 'nullable|integer|min:1|max:100',
        ]);

        if ($request->hasFile('pdf_file')) {
            if ($circular->file_name && Storage::disk('public')->exists('pdfs/' . $circular->file_name)) {
                Storage::disk('public')->delete('pdfs/' . $circular->file_name);
            }

            $pdfFile = $request->file('pdf_file');
            $fileName = time() . '_' . $pdfFile->getClientOriginalName();
            $pdfContent = file_get_contents($pdfFile);
            Storage::disk('public')->put('pdfs/' . $fileName, $pdfContent);

            $circular->file_name = $fileName;
            $circular->file_size = $pdfFile->getSize();
            $circular->file_type = $pdfFile->getClientOriginalExtension();
            $circular->file_upload = $pdfContent;
        }

        // อัปเดตภาพและ base64
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'images/' . time() . '_' . $image->getClientOriginalName();
            $imageContent = file_get_contents($image);
            Storage::disk('public')->put($imagePath, $imageContent);

            $circular->pic_upload = base64_encode($imageContent);
        }

        $circular->topic = $validatedData['title'];
        $circular->unit_id = $validatedData['department'];
        $circular->unit_name = DB::table('tunit')->where('unit_id', $validatedData['department'])->value('unit_name') ?? '';
        $circular->booktype = $validatedData['category'];
        $circular->page_no = $validatedData['pages'];
        $circular->rec_date = $validatedData['date'];
        $circular->notice = $request->has('news_type') && in_array('ทั่วไป', $request->news_type) ? '1' : " ";
        $circular->bookadmin_group = isset($validatedData['access_group']) ? implode(',', $validatedData['access_group']) : $circular->bookadmin_group;
        $circular->hilight = $validatedData['highlight'] ?? null;
        $circular->piority = $validatedData['piority'] ?? 0;
        $circular->day_show = $validatedData['display_days'] ?? 7;
        $circular->end_date = now()->addDays($validatedData['display_days'] ?? "");

        $circular->save();

        return redirect()->route('circulars.index')->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }


    public function destroy($id)
    {
        $circular = Book::findOrFail($id);

        if ($circular->file_name && Storage::disk('public')->exists('pdfs/' . $circular->file_name)) {
            Storage::disk('public')->delete('pdfs/' . $circular->file_name);
        }

        if ($circular->pic_upload && Storage::disk('public')->exists($circular->pic_upload)) {
            Storage::disk('public')->delete($circular->pic_upload);
        }

        $circular->delete();

        return redirect()->route('circulars.index')->with('success', 'ลบหนังสือเรียบร้อยแล้ว');
    }

    public function show($id)
    {
        $circular = Book::findOrFail($id);
        $circular->increment('no_read');
        $circular->department_name = DB::table('book_unit')->where('unit_id', $circular->unit_id)->value('unit_name') ?? 'ไม่ระบุ';
        $circular->category_name = DB::table('booktype')->where('booktype', $circular->booktype)->value('booktype_desc') ?? 'ไม่ระบุ';

        return view('circulars.show', compact('circular'));
    }

    public function openPdf($id)
    {
        ini_set('memory_limit', '512M');

        $circular = Book::findOrFail($id);

        if (!$circular->file_name) {
            return back()->withErrors(['error' => 'ไม่พบไฟล์ PDF']);
        }

        if ($circular->file_upload) {
            return Response::make($circular->file_upload, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $circular->file_name . '"',
            ]);
        }

        $pdfPath = 'pdfs/' . $circular->file_name;
        if (!Storage::disk('public')->exists($pdfPath)) {
            return back()->withErrors(['error' => 'ไม่พบไฟล์ PDF']);
        }

        return Response::make(Storage::disk('public')->get($pdfPath), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $circular->file_name . '"',
        ]);
    }

    public function downloadPdf($id)
    {
        ini_set('memory_limit', '512M');

        $circular = Book::findOrFail($id);

        $circular->increment('no_read');

        if (!$circular->file_name) {
            return back()->withErrors(['error' => 'ไม่พบไฟล์ PDF']);
        }

        if (!empty($circular->file_upload)) {
            return response($circular->file_upload)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $circular->file_name . '"');
        }

        $pdfPath = storage_path('app/public/pdfs/' . $circular->file_name);

        if (!file_exists($pdfPath)) {
            return back()->withErrors(['error' => 'ไม่พบไฟล์ PDF ในระบบ']);
        }

        return response()->download($pdfPath, $circular->file_name);
    }

    // public function record()
    // {
    //     $unitnames = DB::table('book_unit')->pluck('unit_name', 'unit_id');
    //     $booktypes = DB::table('booktype')->get()->keyBy('booktype');

    //     $circulars = Book::where('notice', '1')->orderByDesc('book_id')->get();

    //     foreach ($circulars as $item) {
    //         $item->department_name = $unitnames[$item->unit_id] ?? 'ไม่ระบุ';
    //         $item->category_name = $booktypes[$item->booktype]->booktype_desc ?? 'ไม่ระบุ';
    //     }

    //     return view('circulars.record', compact('circulars'));
    // }

    public function record()
    {
        $unitnames = DB::table('book_unit')->pluck('unit_name', 'unit_id');
        $booktypes = DB::table('booktype')->get()->keyBy('booktype');

        $circulars = Book::where('notice', '1')
            ->orderByDesc('book_id')
            ->get()
            ->map(function ($item) use ($unitnames, $booktypes) {
                $item->department_name = $unitnames[$item->unit_id] ?? 'ไม่ระบุ';
                $item->category_name = $booktypes[$item->booktype]->booktype_desc ?? 'ไม่ระบุ';

                // ตรวจสอบวันหมดอายุสำหรับรูปภาพ
                if (!empty($item->pic_upload) && now()->greaterThan($item->end_date)) {
                    $item->pic_upload = null;
                }

                return $item;
            });

        return view('circulars.record', compact('circulars'));
    }

    public function showImage($id)
    {
        $circular = Book::findOrFail($id);

        if (!$circular->pic_upload) {
            abort(404, 'ไม่พบรูปภาพ');
        }

        $imageData = base64_decode($circular->pic_upload);
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($imageData);

        if (!str_starts_with($mime, 'image/')) {
            abort(403, 'ไฟล์นี้ไม่ใช่รูปภาพ');
        }

        return response($imageData)->header('Content-Type', $mime);
    }


    public function pdfView($id)
    {
        $circular = Book::findOrFail($id);
        $circular->increment('no_read');

        return view('circulars.pdfview', compact('circular'));
    }

    public function viewImage($id)
    {
        $circular = \App\Models\Book::findOrFail($id);

        if (empty($circular->pic_upload)) {
            abort(404, 'ไม่พบรูปภาพ');
        }

        return view('circulars.view_image', compact('circular'));
    }

    // public function highlightBooks()
    // {
    //     $highlightBooks = DB::table('book')
    //         ->select('book_id', 'hilight', 'pic_upload', 'no_read')
    //         ->where('flag', '1')
    //         ->where('notice', '1')
    //         ->whereDate('end_date', '>=', now())
    //         ->where('piority', '!=', '0')
    //         ->orderBy('piority', 'asc')
    //         ->get();

    //     return view('circulars.highlight_carousel', compact('highlightBooks'));
    // }

    public function highlightBooks()
    {
        $highlightBooks = DB::table('book')
            ->select('book_id', 'hilight', 'pic_upload', 'no_read', 'end_date')
            ->where('flag', '1')
            ->where('notice', '1')
            ->whereDate('end_date', '>=', now())
            ->where('piority', '!=', '0')
            ->orderBy('piority', 'asc')
            ->get()
            ->map(function ($item) {
                // หากเลยวันหมดอายุ ให้ลบรูปภาพออกจากการแสดงผล
                if (!empty($item->pic_upload) && now()->greaterThan($item->end_date)) {
                    $item->pic_upload = null;
                }
                return $item;
            });

        return view('circulars.highlight_carousel', compact('highlightBooks'));
    }
}
