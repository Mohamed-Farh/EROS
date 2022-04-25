<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class BuildingProduct extends Model
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
            'building_products.name'         => 10,
            'building_products.description'  => 10,
            'building_products.status'         => 10,
        ],
    ];



    public function buildingCategory(): BelongsTo
    {
        return $this->belongsTo(BuildingCategory::class, 'building_category_id', 'id');
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
    //علشان يجيب اول صوره تحمل الاسم يتاع البودكت
    public function firstMedia(): MorphOne
    {
        return $this->MorphOne(Media::class, 'mediable')->orderBy('file_sort', 'asc');
    }
    public function media(): MorphMany
    {
        return $this->MorphMany(Media::class, 'mediable');
    }
    ######
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
