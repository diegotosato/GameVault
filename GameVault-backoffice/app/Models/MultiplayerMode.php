<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultiplayerMode extends Model
{
    protected $fillable = ['name', 'slug'];

    public function videogames()
    {
        return $this->belongsToMany(Videogame::class);
    }
}
