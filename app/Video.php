<?php

namespace App;

class Video extends Model
{
    protected $guarded = [];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function editable()
    {
        return auth()->check() && auth()->user()->id == $this->channel->user_id;
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, "voteable");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('comment_id')->latest();//->orderBy('created_at', 'DESC');
    }
}
