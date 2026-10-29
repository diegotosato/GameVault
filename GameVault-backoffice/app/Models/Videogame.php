<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videogame extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'release_date', 'image', 'image_alt', 'developer_id'];

    protected $casts = ['release_date' => 'date'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function consoles()
    {
        return $this->belongsToMany(Console::class);
    }

    public function multiplayerModes()
    {
        return $this->belongsToMany(MultiplayerMode::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
