<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewer extends Model
{
    public $timestamps = false;

    protected $fillable = ['viewer'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
