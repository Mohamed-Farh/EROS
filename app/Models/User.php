<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Mindscms\Entrust\Traits\EntrustUserWithPermissionsTrait;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, EntrustUserWithPermissionsTrait, SearchableTrait;


    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'mobile',
        'user_image',
        'status',
        'email',
        'password',
    ];

    public $searchable = [
        'columns' => [
            'users.first_name' => 10,
            'users.last_name' => 10,
            'users.username' => 10,
            'users.email' => 10,
            'users.mobile' => 10,
        ]
    ];

    protected $appends = ['full_name'];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getFullNameAttribute(): string
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function status(): string
    {
        return $this->status ? 'Active' : 'Inactive';
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }
    // public function addresses(): HasMany
    // {
    //     return $this->hasMany(UserAddress::class);
    // }
    public function address(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class);
    }

    #####
    public function buildingProducts(): HasMany
    {
        return $this->hasMany(BuildingProduct::class);
    }
    public function carProducts(): HasMany
    {
        return $this->hasMany(BuildingProduct::class);
    }
    public function medicals(): HasMany
    {
        return $this->hasMany(BuildingProduct::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(BuildingProduct::class);
    }
}
