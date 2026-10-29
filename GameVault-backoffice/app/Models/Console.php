<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Console extends Model
{
    protected $fillable = ['name', 'slug', 'color'];

    public function videogames()
    {
        return $this->belongsToMany(Videogame::class);
    }
}
