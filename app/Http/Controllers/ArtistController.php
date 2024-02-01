<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Models\Tab;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input("search");

        /** @var Builder $artists */
        $artists = Artist::onlyActive();
        if (null !== $search) {
            $artists = $artists->whereFullText(Artist::COLUMN_NAME, $search);    
        }
        $artists = $artists->get();

        return view('artists.index', compact('artists', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('artists.create_update');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArtistRequest $request): RedirectResponse
    {
        /** @var Artist $artist */
        $artist = Artist::query()->create($request->validated());

        if (null !== $artist->getUserId() && $artist->isActive()) {
            $artist->getUser()->increaseNoOfArtists();
        }

        return redirect()
            ->route('artists.index')
            ->with("message", __("Artistul a fost adaugat cu succes"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Artist $artist): View
    {
        return view('artists.show', compact('artist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist): View
    {
        return view('artists.create_update', compact('artist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArtistRequest $request, Artist $artist): RedirectResponse
    {
        $artist->update($request->validated());

        return redirect()
            ->route('artists.index')
            ->with("message", __("Artistul a fost modificat cu succes"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist): RedirectResponse
    {
        Tab::query()
            ->where(Tab::COLUMN_ARTIST_ID, $artist->getId())
            ->update([Tab::COLUMN_ARTIST_ID => null]);

        if ($artist->isActive()) {
            /** @var User $loggedUser */
            $loggedUser = Auth::user();
            $loggedUser->decreaseNoOfArtists();
        }
        
        $artist->delete();

        return redirect()
            ->route('artists.index')
            ->with("message", __("Artistul a fost sters cu succes"));
    }
}
