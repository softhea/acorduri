<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property ?int $user_id
 * @property ?User $user
 * @property ?string $name
 * @property int $no_of_tabs;
 * @property int $no_of_views;
 */
class Artist extends Model
{
    use HasFactory;

    public const TABLE = 'artists';

    public const COLUMN_ID = 'id';
    public const COLUMN_USER_ID = 'user_id';
    public const COLUMN_NAME = 'name';

    protected $fillable = [
        self::COLUMN_USER_ID,
        self::COLUMN_NAME,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        return $this->user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getNoOfTabs(): int
    {
        return $this->no_of_tabs;
    }

    public function getNoOfViews(): int
    {
        return $this->no_of_views;
    }
}
