<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public static function getRandom()
    {
        return self::inRandomOrder()->first();
    }
}
