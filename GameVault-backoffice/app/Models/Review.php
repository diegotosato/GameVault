<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['content', 'videogame_id', 'user_id', 'user_name'];

    protected $casts = ['release_date' => 'date'];

    public function videogame()
    {
        return $this->belongsTo(Videogame::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
