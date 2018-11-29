<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //
    protected $ileable = ['filename','bytes','mime'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
