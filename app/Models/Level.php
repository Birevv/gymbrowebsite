<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $fillable = ['name', 'descriptions', 'order_priority'];

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }
}

