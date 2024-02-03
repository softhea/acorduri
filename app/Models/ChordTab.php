<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ?int $tab_id
 * @property ?int $chord_id
 */
class ChordTab extends Model
{
    use HasFactory;

    public const COLUMN_CHORD_ID = "chord_id";
    public const COLUMN_TAB_ID = "tab_id";

    protected $table = 'chord_tab';

    public function setChordId(int $chordId): void
    {
        $this->chord_id = $chordId;
    }

    public function setTabId(int $tabId): void
    {
        $this->tab_id = $tabId;
    }
}
