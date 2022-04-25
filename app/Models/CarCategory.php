<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Cviebrock\EloquentSluggable\Sluggable;

class CarCategory extends Model
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
            'car_categories.name' => 10,
            'car_categories.description' => 10,
        ],
    ];

    public function products()
    {
        return $this->hasMany(CarProduct::class);
    }

}
