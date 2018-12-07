<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $with = ['user'];

    protected $fillable = ['commentable_type', 'commetable_id', 'user_id', 'parent_id', 'content',];

    protected $hidden = [
        'user_id',
        'commentable_type',
        'commentable_id',
        'parent_id',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->oldest();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

}
