<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{

    protected $table = "homes";

    protected $fillable = [
        'title',
        'text',
        'button_text',
        'button_link',
        'image',
        'video',
        'type',
        'status',
    ];

}
