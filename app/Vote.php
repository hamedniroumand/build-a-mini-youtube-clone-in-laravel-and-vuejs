<?php

namespace App;

class Vote extends Model
{
    protected $guarded = [];

    public function voteable()
    {
        return $this->morphTo();
    }
}
