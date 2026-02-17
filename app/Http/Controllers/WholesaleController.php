<?php

namespace App\Http\Controllers;

use App\Models\WholesaleContent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WholesaleController extends Controller
{
    public function index(Request $request): View
    {
        $contents = WholesaleContent::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('wholesale.index', [
            'contents' => $contents,
            'user' => $request->user(),
        ]);
    }
}
