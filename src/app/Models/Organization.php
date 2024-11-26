<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "building_id",
        "contacts",
    ];

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class);
    }
}
