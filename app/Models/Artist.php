<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property ?int $user_id
 * @property int $no_of_tabs;
 * @property int $no_of_views;
 * @property bool $is_active;
 */
class Artist extends Model
{
    use HasFactory;

    public const TABLE = 'artists';

    public const COLUMN_ID = 'id';
    public const COLUMN_USER_ID = 'user_id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_IS_ACTIVE = 'is_active';

    protected $fillable = [
        self::COLUMN_USER_ID,
        self::COLUMN_NAME,
        self::COLUMN_IS_ACTIVE,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }	

    public function scopeOnlyActive(Builder $query): Builder
    {
        return $query->where(self::COLUMN_IS_ACTIVE, true);
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
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

    public function increaseNoOfViews(): void
    {
        $this->no_of_views++;
        $this->save();
    }

    public function getUser(): ?User
    {
        return $this->user_id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
