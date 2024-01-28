<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tab extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'text',
        'user_id',
        'artist_id',
        'is_active',
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
}
