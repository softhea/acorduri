<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Models\Tab;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input("search", ""));

        $artists = Artist::query()->where('is_active', true);
        if ("" !== $search) {
            $artists = $artists->where("name", "LIKE", "%" . $search . "%");    
        }
        $artists = $artists->get();

        return view('artists.index', compact('artists', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('artists.create_update');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArtistRequest $request)
    {
        Artist::query()->create($request->validated());

        return redirect()
            ->route('artists.index')
            ->with("message", __("Artistul a fost adaugat cu succes"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        return view('artists.show', compact('artist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist)
    {
        return view('artists.create_update', compact('artist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArtistRequest $request, Artist $artist)
    {
        $artist->update($request->validated());

        return redirect()
            ->route('artists.index')
            ->with("message", __("Artistul a fost modificat cu succes"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        Tab::query()
            ->where('artist_id', $artist->id)
            ->update(['artist_id' => null]);

        /** @var User $loggedUser */
        $loggedUser = Auth::user();

        $loggedUser->no_of_artists--;
        $loggedUser->save();

        $artist->delete();

        return redirect()
            ->route('artists.index')
            ->with("message", __("Artistul a fost sters cu succes"));
    }
}
