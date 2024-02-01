<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property ?int $user_id
 * @property ?int $artist_id
 * @property int $no_of_chords
 * @property int $no_of_views
 * @property bool $is_active
 * @property ?string $text
 * @property ?User $user
 * @property ?Artist $artist
 * @property Collection $chords
 */
class Tab extends Model
{
    use HasFactory;

    public const TABLE = 'tabs';

    public const COLUMN_USER_ID = 'user_id';
    public const COLUMN_ARTIST_ID = 'artist_id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_TEXT = 'text';
    public const COLUMN_IS_ACTIVE = 'is_active';
    public const COLUMN_NO_OF_CHORDS = 'no_of_chords';

    protected $fillable = [
        self::COLUMN_USER_ID,
        self::COLUMN_ARTIST_ID,
        self::COLUMN_NAME,
        self::COLUMN_TEXT,
        self::COLUMN_IS_ACTIVE,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }	

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function chords(): BelongsToMany
    {
        return $this->belongsToMany(Chord::class);
    }	

    public function scopeOnlyActive(Builder $query): Builder
    {
        return $query->where(self::COLUMN_IS_ACTIVE, true);
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /** @return Collection<int, Chord> */
    public function getChords(): Collection
    {
        return $this->chords;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getArtistId(): ?int
    {
        return $this->artist_id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function increaseNoOfViews(): void
    {
        $this->no_of_views++;
		$this->save();
    }

    public function updateNoOfChords(int $noOfChords): void
    {
        $this->no_of_chords = $noOfChords;
        $this->save();
    }
}
