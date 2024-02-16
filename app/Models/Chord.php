<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property ?string $chord
 * @property int $no_of_tabs
 * @property int $no_of_chords
 */
class Chord extends Model
{
    use HasFactory;

    public const COLUMN_CHORD = "chord";

    public function getId(): int
    {
        return $this->id;
    }

    public function getChord(): ?string
    {
        return $this->chord;
    }

    public function getNoOfChords(): int
    {
        return $this->no_of_chords;
    }

    public function getNoOfTabs(): int
    {
        return $this->no_of_tabs;
    }

    public function increaseNoOfTabs(): void
    {
        $this->no_of_tabs++;
        $this->save();	
    }

    public function decreaseNoOfTabs(): void
    {
        if ($this->no_of_tabs <= 0) {
            return;
        }

        $this->no_of_tabs--;
        $this->save();	
    }
}
