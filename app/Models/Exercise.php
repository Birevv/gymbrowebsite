<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exercise extends Model
{
    protected $fillable = [
        'level_id', 'name', 'description', 'media_url', 'target_sets', 'target_reps'
    ];

    public function level() : BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}
