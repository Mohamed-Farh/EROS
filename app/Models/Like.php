<?php

namespace App\Models;

use App\Models\City;
use App\Models\Country;
use App\Models\User as ModelsUser;
use App\Models\State;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Like extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(ModelsUser::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function buildings()
    {
        return $this->hasMany(BuildingProduct::class);
    }
    public function cars()
    {
        return $this->hasMany(CarProduct::class);
    }
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    public function medicals()
    {
        return $this->hasMany(Medical::class);
    }

}
