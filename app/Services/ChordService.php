<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Chord;
use App\Models\ChordTab;
use App\Models\Tab;

class ChordService
{
    public function assignChordsToTab(Tab $tab, ?string $oldText = null): void
	{
		$noOfChords = 0;

        $newText = $tab->text;

        $newText = str_replace(' ', '&nbsp;', $newText);
        if (null !== $oldText) {
            $oldText = str_replace(' ', '&nbsp;', $oldText);
        }

		$chords = Chord::all();
		foreach ($chords as $chord) {
            if (
                false !== strpos(
                    $newText, 
                    '$' . $chord->chord . '&nbsp;'
                ) 
                || false !== strpos(
                    $newText, 
                    '$' . $chord->chord . "\r\n"
                )
            ) {
				if (
                    null === $oldText
                    || (
                        false === strpos(
                            $oldText, 
                            '$' . $chord->chord . '&nbsp;'
                        ) 
                        && false === strpos(
                            $oldText, 
                            '$' . $chord->chord . "\r\n"
                        )                        
                    )
                ) {
					$chordTab = new ChordTab();
					$chordTab->tab_id = $tab->Id;
					$chordTab->chord_id = $chord->id;
					$chordTab->save();

					$chord->no_of_tabs++;
					$chord->save();
				}
				$noOfChords++;
			} elseif (
                null !== $oldText
                && preg_match('/\$' . $chord->chord . '/', $oldText)
            ) {
				$chordToTab = ChordTab::query()
                    ->where('tab_id', $tab->id)
                    ->where('chord_id', $chord->id)
                    ->first();
				$chordToTab->delete();

                $chord->no_of_tabs--;
				$chord->save();			
			}
		}

        $tab->no_of_chords = $noOfChords;
        $tab->save();
	}
}
