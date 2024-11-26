<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{

    protected $fillable = [
        'name',
        'parent_id',
    ];



    public static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            $maxDepth = 3;
            $currentDepth = 0;
            $parent = $activity->parent_id ? Activity::find($activity->parent_id) : null;
            while ($parent) {
                $currentDepth++;
                $parent = $parent->parent;
            }

            if ($currentDepth >= $maxDepth) {
                throw new \Exception('Превышен допустимый уровень вложенности.');
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }


    public function loadTree()
    {
        return $this->load(['children' => function ($query) {
            $query->with('children');
        }]);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class);
    }
}
