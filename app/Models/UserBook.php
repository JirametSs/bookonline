<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    protected $table = 'user_book';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'idx',
        'fname',
        'lname',
        'status_user',
        'user_group',
        'unit_post',
        'flag'
    ];
}
