<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    protected $primaryKey = 'book_id';
    public $timestamps = false;

    protected $fillable = [
        'booktype',
        'book_no',
        'topic',
        'unit_name',
        'unit_id',
        'unit_out_name',
        'unit_post',
        'page_no',
        'file_upload',
        'file_name',
        'file_size',
        'file_type',
        'flag',
        'insert_date',
        'rec_date',
        'user_id',
        'idx',
        'no_read',
        'count30day',
        'bookadmin_group',
        'notice',
        'hilight',
        'piority',
        'day_show',
        'end_date',
        'pic_upload'
    ];
}
