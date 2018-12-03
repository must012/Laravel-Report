<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //
    protected $fillable = ['filename','bytes','mime'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getBytesPost($value)
    {
        return format_filesize($value);
    }

    public function getUrlPost($value)
    {
        return url('files/'.$this->filename);
    }

}
