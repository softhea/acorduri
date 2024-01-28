<?php

declare(strict_types=1);

namespace App\Helpers;

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

	private static function chord(array $chord): string
	{			
		$string = 
			'<a href="' 
				. route('chords.show', ['chord' => $chord['id']])
				. '" class="chord" chord_id="chord_' . $chord['chord'] 
			. '" >' 
				. $chord['chord'] 
			. '</a>';

		return $string; 
	}

	public static function showChords(string $string, array $chords): string
	{
		$string = str_replace(' ', '&nbsp;', $string);
		foreach ($chords as $chord) {		
			while (
				false !== strpos(
					$string, 
					'$' . $chord['chord'] . '&nbsp;'
				) 
				|| false !== strpos(
					$string, 
					'$' . $chord['chord'] . "\r\n"
				)
			) {
				$string = self::strReplaceOnce(
					'$' . $chord['chord'] . '&nbsp;', 
					'&nbsp' . self::chord($chord) . '&nbsp;', 
					$string
				);
				$string = self::strReplaceOnce(
					'$' . $chord['chord'] . "\r\n", 
					'&nbsp' . self::chord($chord) . "\r\n", 
					$string
				);				
			}
		}

		return nl2br($string);
	}		
}
