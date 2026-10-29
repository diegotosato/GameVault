<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'videogame_id'];

    public function videogame()
    {
        return $this->belongsTo(Videogame::class);
    }
}
