<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Chord;
use App\Http\Requests\StoreChordRequest;
use App\Http\Requests\UpdateChordRequest;

class ChordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chords = Chord::all();

        return view('chords.index', compact('chords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChordRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Chord $chord)
    {
        return view('chords.show', compact('chord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chord $chord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChordRequest $request, Chord $chord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chord $chord)
    {
        //
    }
}
