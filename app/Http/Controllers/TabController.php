<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ChordHelper;
use App\Models\Artist;
use App\Models\ChordTab;
use App\Models\Tab;
use App\Http\Requests\StoreTabRequest;
use App\Http\Requests\UpdateTabRequest;
use App\Models\User;
use App\Services\ChordService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input("search", ""));
        $searchName = trim((string) $request->input("name", ""));
        $searchUserId = (int) $request->input("user_id");
        $searchArtistId = (int) $request->input("user_id");
        $searchNoOfChords = (int) $request->input("no_of_chords");
        $searchChords = trim((string) $request->input("no_of_chords", ""));

        $tabs = Tab::query()->where('is_active', true);
        if ("" !== $search) {
            $tabs = $tabs->where(function (Builder $query) use ($search) {
                $query->where("name", "LIKE", "%" . $search . "%");
                // $query->orWhere("username", "LIKE", "%" . $search . "%");
            });    
        }
        $tabs = $tabs->get();

        $chords = [];
        foreach ($tabs as $tab) {
            foreach ($tab->chords as $chord) {
                $chords[] = $chord['chord'];
            }
        }
        $chords = array_unique($chords);

        return view(
            'tabs.index', 
            compact(
                'tabs', 
                'chords', 
                'search',
                'searchName',
                'searchUserId',
                'searchArtistId',
                'searchNoOfChords',
                'searchChords'
            )
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

        $push = false;
        if (null !== $tab->artist_id) {
            $tab->artist->no_of_tabs++;

            $push = true;
        }
        if (null !== $tab->user_id) {
            $tab->user->no_of_tabs++;

            $push = true;
        }
        if ($push) {
            $tab->push();
        }

        $chordService->assignChordsToTab($tab);

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

        $push = false;
        if (null !== $tab->artist_id) {
            $tab->artist->no_of_views++;

            $push = true;
        }
        if (null !== $tab->user_id) {
		    $tab->user->no_of_views++;		
		    
            $push = true;
        }
        if ($push) {
            $tab->push();
        }
        
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
        $oldArtistId = (int) $tab->artist_id;
        
        if (
            $oldArtistId !== (int) $request->validated('artist_id')
            && $tab->artist->no_of_tabs > 0
        ) {
            $tab->artist->no_of_tabs--;

            $tab->push();
        }

        $tab->update($request->validated());

        if ($oldArtistId !== (int) $request->validated('artist_id')) {
            $tab->artist->no_of_tabs++;
        
            $tab->push();
        }

        if ($oldText !== $request->validated('text')) {
            $chordService->assignChordsToTab($tab, $oldText);
        }
        
        return redirect()
            ->route('tabs.index')
            ->with("message", __("Tabulatura a fost modificata cu succes"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tab $tab)
    {
        $push = false;

        if (
            null !== $tab->artist_id
            && $tab->artist->no_of_tabs > 0
        ) {
            $tab->artist->no_of_tabs--;

            $push = true;
        }
        
        if (
            null !== $tab->user_id
            && $tab->user->no_of_tabs > 0
        ) {
            $tab->user->no_of_tabs--;
            
            $push = true;
        }

        if ($tab->chords->count() > 0) {
            foreach ($tab->chords as $chord) {
                if ($chord->no_of_tabs > 0) {
                    $chord->no_of_tabs--;
                }
            }
            
            $push = true;

            ChordTab::query()->where('tab_id', $tab->id)->delete();
        }

        if ($push) {
            $tab->push();
        }

        $tab->delete();

        return redirect()
            ->route('tabs.index')
            ->with("message", __("Tabulatura a fost stearsa cu succes"));
    }
}
