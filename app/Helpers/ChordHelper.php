<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Chord;
use Illuminate\Database\Eloquent\Collection;

class ChordHelper
{	
	private static int $i = 1;

	/**
	 * Looks for the first occurence of $needle in $haystack
	 * and replaces it with $replace.
	 */
	private static function strReplaceOnce(string $needle, string $replace, string $haystack): string
	{

		$pos = strpos($haystack, $needle);
		if (false === $pos) {
			// Nothing found
			return $haystack;
		}

		return substr_replace($haystack, $replace, $pos, strlen($needle));
	}  

	private static function chord(Chord $chord): string
	{			
		$string = 
			'<a href="' 
				. route('chords.show', ['chord' => $chord->getId()])
				. '" class="chord" chord_id="chord_' . $chord->getChord()
			. '" >' 
				. $chord->getChord()
			. '</a>';

		return $string; 
	}

	/**
	 * @param Collection<int, Chord> $chords
	 */
	public static function showChords(string $string, Collection $chords): string
	{
		$string = str_replace(' ', '&nbsp;', $string);
		foreach ($chords as $chord) {		
			while (
				false !== strpos(
					$string, 
					'$' . $chord->getChord() . '&nbsp;'
				) 
				|| false !== strpos(
					$string, 
					'$' . $chord->getChord() . "\r\n"
				)
			) {
				$string = self::strReplaceOnce(
					'$' . $chord->getChord() . '&nbsp;', 
					'&nbsp' . self::chord($chord) . '&nbsp;', 
					$string
				);
				$string = self::strReplaceOnce(
					'$' . $chord->getChord() . "\r\n", 
					'&nbsp' . self::chord($chord) . "\r\n", 
					$string
				);				
			}
		}

		return nl2br($string);
	}		
}
