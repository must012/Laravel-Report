<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    protected $with = ['likes'];

    protected $fillable = ["writer","name","title","content","imgPath","created_at","updated_at"];

    protected $appends = ['like_count'];

    public function viewers(){
        return $this->hasMany(Viewer::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getLikeCountAttribute()
    {
        return (int) $this->likes()->sum('liked');
    }
    
}
