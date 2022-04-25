<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Cviebrock\EloquentSluggable\Sluggable;

class CarType extends Model
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
            'car_types.name' => 10,
            'car_types.status' => 10,
        ],
    ];

    public function products()
    {
        return $this->hasMany(CarProduct::class);
    }
    public function scopeActiveProduct($query)
    {
        return $query->whereHas('products', function ($query) {

            $query->whereStatus(1);
        });
    }
}
