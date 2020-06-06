<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    public static function getRandom()
    {
        return self::inRandomOrder()->first();
    }
}
