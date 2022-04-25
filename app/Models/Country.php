<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Country extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    public $timestamps = false;

    protected $searchable = [
        'columns' => [
            'countries.name' => 10,
        ],
    ];


    public function status()
    {
        return $this->status ? 'Active' : 'InActive';
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    public function buildingProducts(): HasMany
    {
        return $this->hasMany(BuildingProduct::class);
    }
    public function carProducts(): HasMany
    {
        return $this->hasMany(CarProduct::class);
    }
    public function medicals(): HasMany
    {
        return $this->hasMany(Medical::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
