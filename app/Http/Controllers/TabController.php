<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ChordHelper;
use App\Models\Artist;
use App\Models\Tab;
use App\Http\Requests\StoreTabRequest;
use App\Http\Requests\UpdateTabRequest;
use App\Models\User;
use App\Services\ChordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input("search");

        $tabs = Tab::query()->where('is_active', true)->get();
        $chords = [];
        foreach ($tabs as $tab) {
            foreach ($tab->chords as $chord) {
                $chords[] = $chord['chord'];
            }
        }
        $chords = array_unique($chords);

        return view(
            'tabs.index', 
            compact('tabs', 'chords', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $artists = Artist::all();

        return view('tabs.create_update', compact('artists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTabRequest $request, ChordService $chordService)
    {
        $tab = Tab::query()->create($request->validated());

        // todo artist no_of_tabs

        $chordService->assignChordsToTab($tab->id, $tab->text);

        return redirect()
            ->route('tabs.index')
            ->with("message", __("Tabulatura a fost adaugata cu succes"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tab $tab)
    {
        $tab->no_of_views++;
		$tab->save();

        if (null !== $tab->artist_id) {
            $tab->artist->no_of_views++;
        }
		$tab->user->no_of_views++;		
		$tab->push();
        
        if (null !== $tab->text) {
            $chords = $tab->chords()->get()->toArray();
            if ([] !== $chords) {
                $tab->text = ChordHelper::showChords($tab->text, $chords);
            }
        }

        return view('tabs.show', compact('tab'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tab $tab)
    {
        $artists = Artist::all();

        return view('tabs.create_update', compact('tab','artists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTabRequest $request, Tab $tab, ChordService $chordService)
    {
        $oldText = $tab->text;

        $tab->update($request->validated());
        
        //todo update artist no_of_tabs

        $chordService->assignChordsToTab($tab->id, $tab->text, $oldText);

        return redirect()
            ->route('tabs.index')
            ->with("message", __("Tabulatura a fost modificata cu succes"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tab $tab)
    {
        if (null !== $tab->artist_id) {
            $artist = Artist::query()->find((int) $tab->artist_id);
            if ($artist->no_of_tabs > 0) {
                $artist->no_of_tabs--;
                $artist->save();
            }
        }
        
        /** @var User $loggedUser */
        $loggedUser = Auth::user();
        if ($loggedUser->no_of_tabs > 0) {
            $loggedUser->no_of_tabs--;
            $loggedUser->save();
        }
        
        $tab->delete();

        return redirect()
            ->route('tabs.index')
            ->with("message", __("Tabulatura a fost stearsa cu succes"));
    }
}
