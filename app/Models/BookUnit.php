<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookUnit extends Model
{
    use HasFactory;

    // ถ้าใช้ table ชื่อ book_units ตาม Laravel convention ไม่ต้องกำหนด
    // แต่ถ้าชื่อ table ต่างจากนี้ ให้เพิ่ม:
    // protected $table = 'book_units';

    // ระบุฟิลด์ที่สามารถกรอกข้อมูลได้ (mass assignment)
    protected $fillable = ['name'];
}
