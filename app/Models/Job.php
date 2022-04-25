<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;

class Job extends Model
{
    use SearchableTrait;
    use Sluggable;

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
            'jobs.name'         => 10,
            'jobs.gender'  => 10,
            'jobs.speciality'  => 10,
            'jobs.description'  => 10,
            'jobs.status'         => 10,
        ],
    ];



    public function jobCategory(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id', 'id');
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    ######
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
