<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Tab;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueTableNamePerArtistId implements ValidationRule
{
    private int $id = 0;
    private ?int $artistId = null;

    public function setArtistId(?int $artistId): self
    {
        $this->artistId = $artistId;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Tab::query()
            ->where(Tab::COLUMN_NAME, $value)
            ->where(Tab::COLUMN_ARTIST_ID, $this->artistId)    
            ->exists();
            
        if ($exists) {
            $fail('Table Name must be unique per Artist')->translate();
        }
    }
}
