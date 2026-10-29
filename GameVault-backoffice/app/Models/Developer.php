<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $fillable = ['name', 'slug'];

    public function videogames()
    {
        return $this->hasMany(Videogame::class);
    }
}
