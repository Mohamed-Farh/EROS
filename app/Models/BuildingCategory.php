<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Cviebrock\EloquentSluggable\Sluggable;

class BuildingCategory extends Model
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
            'building_categories.name' => 10,
            'building_categories.description' => 10,
            'building_categories.status' => 10,
        ],
    ];



    public function products()
    {
        return $this->hasMany(BuildingProduct::class);
    }

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function appearedChildren()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('status', true);
    }

    public static function tree( $level = 1 )
    {
        return static::with(implode('.', array_fill(0, $level, 'children')))
            ->whereNull('parent_id')
            ->whereStatus(true)
            ->orderBy('id', 'asc')
            ->get();
    }

}
