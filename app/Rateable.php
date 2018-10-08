<?php

namespace App;

/**
* Trait to enable polymorphic ratings on a model. 7*
* @package App
*/
trait Rateable
{
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }
}