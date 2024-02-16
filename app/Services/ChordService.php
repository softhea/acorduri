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

        $newText = $tab->getText();

        $newText = str_replace(' ', '&nbsp;', $newText);
        if (null !== $oldText) {
            $oldText = str_replace(' ', '&nbsp;', $oldText);
        }

        /** @var Chord[] $chords */
		$chords = Chord::all();
		foreach ($chords as $chord) {
            if (
                false !== strpos(
                    $newText, 
                    '$' . $chord->getChord() . '&nbsp;'
                ) 
                || false !== strpos(
                    $newText, 
                    '$' . $chord->getChord() . "\r\n"
                )
            ) {
				if (
                    null === $oldText
                    || (
                        false === strpos(
                            $oldText, 
                            '$' . $chord->getChord() . '&nbsp;'
                        ) 
                        && false === strpos(
                            $oldText, 
                            '$' . $chord->getChord() . "\r\n"
                        )                        
                    )
                ) {
					$chordTab = new ChordTab();
					$chordTab->setTabId($tab->getId());
					$chordTab->setChordId($chord->getId());
					$chordTab->save();

                    $chord->increaseNoOfTabs();
				}
				$noOfChords++;
			} elseif (
                null !== $oldText
                && preg_match('/\$' . $chord->getChord() . '/', $oldText)
            ) {
				ChordTab::query()
                    ->where(ChordTab::COLUMN_TAB_ID, $tab->getId())
                    ->where(ChordTab::COLUMN_CHORD_ID, $chord->getId())
                    ->delete();

                $chord->decreaseNoOfTabs();
			}
		}

        $tab->updateNoOfChords($noOfChords);
	}
}
