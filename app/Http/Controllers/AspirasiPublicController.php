<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AspirasiPublicController extends Controller
{
    public function create()
    {
        return view('aspirasi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => ['required', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:100'],
        ]);

        Aspirasi::create([
            'title'             => $request->title,
            'location'          => $request->location,
            'color'             => 'green',
            'status'            => 'baru',
            'moderation_status' => 'pending',
            'is_active'         => false,
            'submitted_at'      => now(),
        ]);

        return redirect()->route('aspirasi')
            ->with('submitted', true);
    }
}
