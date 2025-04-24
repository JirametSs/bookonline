<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Circular;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function stats()
    {

        $today = Cache::get('visitor_today', 32);
        $yesterday = Cache::get('visitor_yesterday', 13);

        return response()->json([
            'date' => now()->locale('th')->translatedFormat('d F Y'),
            'today' => $today,
            'yesterday' => $yesterday,
            'total' => Circular::count(),
        ]);
    }
}
