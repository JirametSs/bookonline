<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::orderByDesc('book_id')->paginate(15);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $units = DB::table('tunit')->pluck('unit_name', 'unit_id');
        $booktypes = DB::table('booktype')->pluck('booktype_desc', 'booktype');
        return view('books.create', compact('units', 'booktypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booktype' => 'required',
            'topic' => 'required|string|max:255',
            'unit_id' => 'required|string',
            'pages' => 'required|integer|min:1',
        ], [
            'booktype.required' => 'กรุณาเลือกหมวดหนังสือ',
            'topic.required' => 'กรุณาระบุเรื่องของหนังสือ',
            'unit_id.required' => 'กรุณาเลือกหน่วยงานภายใน',
            'pages.required' => 'กรุณาระบุจำนวนหน้า',
            'pages.integer' => 'จำนวนหน้าต้องเป็นตัวเลข',
            'pages.min' => 'จำนวนหน้าต้องมากกว่า 0',
        ]);

        $unit_name = DB::table('tunit')->where('unit_id', $request->unit_id)->value('unit_name');
        $user = Auth::user();

        Book::create([
            'booktype'     => $request->booktype,
            'topic'        => $request->topic,
            'unit_id'      => $request->unit_id,
            'unit_name'    => $unit_name,
            'page_no'      => $request->pages,
            'priority'     => $request->priority ?? 0,
            'notice'       => $request->notice ?? '0',
            'flag'         => '1',
            'insert_date'  => now(),
            'rec_date'     => now(),
            'user_id'      => $user?->id ?? '01',
            'idx'          => $user?->idx ?? '99',
        ]);

        return redirect()->route('books.index')->with('saved_success', 'เพิ่มหนังสือเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $units = DB::table('tunit')->pluck('unit_name', 'unit_id');
        $booktypes = DB::table('booktype')->pluck('booktype_desc', 'booktype');
        return view('books.edit', compact('book', 'units', 'booktypes'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'booktype' => 'required',
            'topic' => 'required|string|max:255',
            'unit_id' => 'required|string',
            'pages' => 'required|integer|min:1',
        ], [
            'booktype.required' => 'กรุณาเลือกหมวดหนังสือ',
            'topic.required' => 'กรุณาระบุเรื่องของหนังสือ',
            'unit_id.required' => 'กรุณาเลือกหน่วยงานภายใน',
            'pages.required' => 'กรุณาระบุจำนวนหน้า',
            'pages.integer' => 'จำนวนหน้าต้องเป็นตัวเลข',
            'pages.min' => 'จำนวนหน้าต้องมากกว่า 0',
        ]);

        $unit_name = DB::table('tunit')->where('unit_id', $request->unit_id)->value('unit_name');

        $book->update([
            'booktype'    => $request->booktype,
            'topic'       => $request->topic,
            'unit_id'     => $request->unit_id,
            'unit_name'   => $unit_name,
            'page_no'     => $request->pages,
            'piority'    => $request->piority ?? 0,
            'notice'      => $request->notice ?? '0',
            'rec_date'    => now(),
        ]);

        return redirect()->route('books.index')->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')->with('success', 'ลบหนังสือเรียบร้อยแล้ว');
    }
}
