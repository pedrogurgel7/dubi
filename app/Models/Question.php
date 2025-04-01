<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\{Model, Prunable, SoftDeletes};

class Question extends Model
{
    use Prunable;
    use SoftDeletes;
    use HasFactory;

    protected $casts = [
        'draft' => 'boolean',
    ];

    protected $guarded = [];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function prunable(): \Illuminate\Database\Eloquent\Builder
    {
        return static::where('deleted_at', '<=', now()->subMonth());
    }
}
