<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use stdClass;

class Constants
{

  public static function user(): \App\User
  {
    return Auth::user();
  }

  public static function codes()
  {
    return new class
    {
      const OK = 200;
      const BAD_REQUEST = 400;
      const UNAUTHORIZED = 401;
      const NOT_FOUND = 404;
    };
  }

  const PROPERTY_ARRAY = ['house', 'apartment', 'room', 'bed', 'address'];
  const TYPE_ARRAY = ['rent', 'sell'];
  const RENT_TYPE_ARRAY = ['monthly', 'weekly', 'daily'];

  const DATE_FORMAT = 'd/m/Y';

  const MIN_PASS_LENGTH = 6;
  const MAX_TITLE_LENGTH = 200;
  const MAX_DESCRIPTION_LENGTH = 300;
  const MAX_STREET_LENGTH = 100;
  const MAX_HOUSE_NO_LENGTH = 10;
  const MAX_POST_CODE_LENGTH = 10;
  const MAX_PLACE_LENGTH = 100;
  const MIN_BUILD_YEAR = 1000;
  const MAX_BUILD_YEAR = 2020;
  const MAX_AREA = 10000;
  const MAX_ROOMS = 200;
  const MAX_FLOOR = 200;
  const MAX_PRICE = 1000000;
  const MAX_RENT = 1000000;
  const MAX_DEPOSIT = 1000000;
  const MAX_COMPENSATION = 1000000;
}
