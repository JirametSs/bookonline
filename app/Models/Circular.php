<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circular extends Model
{
    protected $table = 'circulars';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'external_agency',
        'department',
        'category',
        'broadcast',
        'pages',
        'date',
        'read_count',
        'access_group',
        'news_type',
        'highlight',
        'priority',
        'display_days',
        'pdf_path',
        'image_path'
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
