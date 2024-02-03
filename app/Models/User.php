<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $no_of_artists;
 * @property int $no_of_tabs;
 * @property int $no_of_views;
 * @property int $role_id;
 * @property ?DateTime $email_verified_at;
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_ID_ADMIN = 2;

    public const COLUMN_NAME = 'name';
    public const COLUMN_USERNAME = 'username';
    public const COLUMN_EMAIL_VERIFIED_AT = 'email_verified_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_USERNAME,
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        self::COLUMN_EMAIL_VERIFIED_AT => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeOnlyActive(Builder $query): Builder
    {
        return $query->whereNotNull(self::COLUMN_EMAIL_VERIFIED_AT);
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

    public function increaseNoOfArtists(): void
    {
        $this->no_of_artists++;
		$this->save();
    }

    public function decreaseNoOfArtists(): void
    {
        if ($this->no_of_artists <= 0) {
            return;
        }

        $this->no_of_artists--;
        $this->save();
    }

    public function isAdmin(): bool
    {
        return $this->role_id <= self::ROLE_ID_ADMIN;
    }

    public function isActive(): bool
    {
        return null !== $this->email_verified_at;
    }
}
