<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = ["writer","name","title","content","imgPath","created_at","updated_at"];

    public function viewers(){
        return $this->hasMany(Viewer::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
