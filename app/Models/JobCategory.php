<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class JobCategory extends Model
{
    use Sluggable, SearchableTrait;

    protected $guarded = [];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $searchable = [
        'columns' => [
            'job_categories.name' => 10,
            'job_categories.status' => 10,
        ],
    ];


    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    // public function scopeActiveJob($query)
    // {
    //     return $query->whereHas('jobs', function ($query) {

    //         $query->whereStatus(true);
    //     });
    // }
}
