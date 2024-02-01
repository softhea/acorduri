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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $searchName = $request->input("name");
        $searchUserId = (int) $request->input("user_id");
        $searchArtistId = (int) $request->input("artist_id");
        $searchNoOfChords = $request->input("no_of_chords");
        $searchChords = $request->input("chords");

        /** @var Builder $tabs*/
        $tabs = Tab::onlyActive();
        if (null !== $searchName) {
            $tabs = $tabs->where(function (Builder $query) use ($searchName) {
                $query->whereFullText(Tab::COLUMN_NAME, $searchName);
                $query->orWhereFullText(Tab::COLUMN_TEXT, $searchName);
            });    
        }
        if (0 !== $searchUserId) {
            $tabs = $tabs->where(Tab::COLUMN_USER_ID, $searchUserId);    
        }
        if (0 !== $searchArtistId) {
            $tabs = $tabs->where(Tab::COLUMN_ARTIST_ID, $searchArtistId);    
        }
        if (null !== $searchNoOfChords) {
            $tabs = $tabs->where(Tab::COLUMN_NO_OF_CHORDS, $searchNoOfChords);    
        }
        $tabs = $tabs->get();

        $chords = [];
        /** @var Tab[] $tabs*/
        foreach ($tabs as $tab) {
            foreach ($tab->getChords() as $chord) {
                $chords[] = $chord->getChord();
            }
        }
        $chords = array_unique($chords);

        $artists = Artist::onlyActive()->get();
        $users = User::onlyActive()->get();

        return view(
            'tabs.index', 
            compact(
                'tabs', 
                'chords', 
                'artists',
                'users',
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
        /** @var Tab $tab */
        $tab = Tab::query()->create($request->validated());

        if (null !== $tab->getArtistId() && $tab->isActive()) {
            $tab->getArtist()->increaseNoOfTabs();
        }
        if (null !== $tab->getUserId() && $tab->isActive()) {
            $tab->getUser()->increaseNoOfTabs();
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
        $tab->increaseNoOfViews();

        if (null !== $tab->getArtistId()) {
            $tab->getArtist()->increaseNoOfViews();
        }
        if (null !== $tab->getUserId()) {
		    $tab->getUser()->increaseNoOfViews();		
        }
        
        if (null !== $tab->getText() && $tab->getChords()->count() > 0) {
            $tab->setText(
                ChordHelper::showChords($tab->getText(),  $tab->getChords())
            );
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
        $oldText = $tab->getText();
        $oldArtistId = $tab->getArtistId();
        
        if ($tab->isActive() && $oldArtistId !== (int) $request->validated('artist_id')) {
            $tab->getArtist()->decreaseNoOfTabs();
        }

        $tab->update($request->validated());

        if ($tab->isActive() && $oldArtistId !== (int) $request->validated('artist_id')) {
            $tab->getArtist()->increaseNoOfTabs();
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
        if ($tab->isActive() && null !== $tab->getArtistId()) {
            $tab->getArtist()->decreaseNoOfTabs();
        }
        
        if ($tab->isActive() && null !== $tab->getUserId()) {
            $tab->getUser()->decreaseNoOfTabs();
        }

        if ($tab->getChords()->count() > 0) {
            if ($tab->isActive()) {
                foreach ($tab->getChords() as $chord) {
                    $chord->decreaseNoOfTabs();
                }
            }

            ChordTab::query()->where(ChordTab::COLUMN_TAB_ID, $tab->getId())->delete();
        }

        $tab->delete();

        return redirect()
            ->route('tabs.index')
            ->with("message", __("Tabulatura a fost stearsa cu succes"));
    }
}
