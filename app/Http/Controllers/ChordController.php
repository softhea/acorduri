<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Chord;
use Illuminate\View\View;

class ChordController extends Controller
{
    public function index(): View
    {
        $chords = Chord::query()->orderBy(Chord::COLUMN_CHORD)->get();

        return view('chords.index', compact('chords'));
    }

    public function show(Chord $chord): View
    {
        return view('chords.show', compact('chord'));
    }
}
