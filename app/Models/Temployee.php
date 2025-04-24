<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temployee extends Model
{
    protected $table = 'temployee';
    protected $primaryKey = 'idx';

    public $timestamps = false;

    protected $fillable = [
        'idx',
        'prefix_short',
        'fname',
        'lname',
        'username',
        'password',
        'T_Work_id',
        'T_Work_name',
        'T_Worku_id',
        'T_Worku_name',
        'position',
    ];
}
