<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'property',
        'type',
        'rent_type',
        'country',
        'state',
        'division',
        'street',
        'house_no',
        'post_code',
        'street_and_house_no_visible',
        'photos',
        'area',
        'rooms',
        'floor',
        'build_year',
        'available_from',
        'price',
        'rent',
        'deposit',
        'compensation',
        'bathtub',
        'balcony', 'terrace',
        'garden',
        'furnished',
        'equipped_kitchen',
        'lift',
        'wlan',
        'email_visible',
        'phone_visible',
        'user_id'
    ];
}
