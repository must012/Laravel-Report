<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //

    public function Posts(){
        return $this->belongsTo(Post::class);
    }
}
